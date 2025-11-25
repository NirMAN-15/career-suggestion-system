<?php
/**
 * API: Get Roadmap
 * Fetches roadmap steps for a specific career and user progress
 */

header('Content-Type: application/json');
require_once '../config/database.php';

// Get parameters
$career_id = isset($_GET['career_id']) ? intval($_GET['career_id']) : 0;
$user_id = isset($_GET['user_id']) ? intval($_GET['user_id']) : 0;

if(!$career_id || !$user_id) {
    echo json_encode([
        'success' => false,
        'message' => 'Missing required parameters'
    ]);
    exit();
}

try {
    // Get roadmap steps
    $stmt = $pdo->prepare("
        SELECT 
            step_id,
            career_id,
            step_order,
            step_title,
            step_description,
            estimated_duration
        FROM roadmap_steps
        WHERE career_id = ?
        ORDER BY step_order ASC
    ");
    $stmt->execute([$career_id]);
    $steps = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Get user progress
    $stmt = $pdo->prepare("
        SELECT 
            progress_id,
            step_id,
            completed,
            completed_at
        FROM user_roadmap_progress
        WHERE user_id = ?
    ");
    $stmt->execute([$user_id]);
    $progress = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Response
    echo json_encode([
        'success' => true,
        'steps' => $steps,
        'progress' => $progress
    ]);
    
} catch(PDOException $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Database error: ' . $e->getMessage()
    ]);
}
?>
