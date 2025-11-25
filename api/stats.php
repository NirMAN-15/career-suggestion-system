<?php
session_start();
require_once '../config/database.php';

header('Content-Type: application/json');

// Check if user is logged in
if(!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Not authenticated']);
    exit;
}

$user_id = $_SESSION['user_id'];

try {
    // Check if assessment is completed
    $stmt = $pdo->prepare("SELECT COUNT(*) as count FROM user_answers WHERE user_id = ?");
    $stmt->execute([$user_id]);
    $assessment_completed = $stmt->fetch(PDO::FETCH_ASSOC)['count'] > 0;
    
    // Get number of career matches
    $stmt = $pdo->prepare("SELECT COUNT(*) as count FROM user_career_matches WHERE user_id = ?");
    $stmt->execute([$user_id]);
    $career_matches = $stmt->fetch(PDO::FETCH_ASSOC)['count'];
    
    // Get roadmap progress
    $stmt = $pdo->prepare("
        SELECT 
            COUNT(CASE WHEN completed = TRUE THEN 1 END) as completed,
            COUNT(*) as total
        FROM user_roadmap_progress
        WHERE user_id = ?
    ");
    $stmt->execute([$user_id]);
    $progress_data = $stmt->fetch(PDO::FETCH_ASSOC);
    
    $roadmap_progress = 0;
    if($progress_data['total'] > 0) {
        $roadmap_progress = round(($progress_data['completed'] / $progress_data['total']) * 100);
    }
    
    // Get recent activities
    $recent_activities = [];
    
    // Check for recent assessment completion
    if($assessment_completed) {
        $stmt = $pdo->prepare("
            SELECT MAX(submitted_at) as last_activity 
            FROM user_answers 
            WHERE user_id = ?
        ");
        $stmt->execute([$user_id]);
        $last_assessment = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if($last_assessment['last_activity']) {
            $recent_activities[] = [
                'type' => 'assessment',
                'message' => 'Completed career assessment',
                'date' => $last_assessment['last_activity']
            ];
        }
    }
    
    // Get user registration date
    $stmt = $pdo->prepare("SELECT created_at FROM users WHERE user_id = ?");
    $stmt->execute([$user_id]);
    $user_data = $stmt->fetch(PDO::FETCH_ASSOC);
    
    $recent_activities[] = [
        'type' => 'registration',
        'message' => 'Account created',
        'date' => $user_data['created_at']
    ];
    
    // Return stats
    echo json_encode([
        'success' => true,
        'stats' => [
            'assessment_completed' => $assessment_completed,
            'career_matches' => $career_matches,
            'roadmap_progress' => $roadmap_progress,
            'recent_activities' => $recent_activities
        ]
    ]);
    
} catch(PDOException $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Database error: ' . $e->getMessage()
    ]);
}
?>