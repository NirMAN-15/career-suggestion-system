<?php
/**
 * API: Update Progress
 * Marks roadmap step as complete or incomplete
 */

header('Content-Type: application/json');
require_once '../config/database.php';

// Get POST data
$user_id = isset($_POST['user_id']) ? intval($_POST['user_id']) : 0;
$step_id = isset($_POST['step_id']) ? intval($_POST['step_id']) : 0;
$completed = isset($_POST['completed']) ? filter_var($_POST['completed'], FILTER_VALIDATE_BOOLEAN) : false;

if(!$user_id || !$step_id) {
    echo json_encode([
        'success' => false,
        'message' => 'Missing required parameters'
    ]);
    exit();
}

try {
    if($completed) {
        // Mark as complete
        // Check if progress record exists
        $stmt = $pdo->prepare("
            SELECT progress_id 
            FROM user_roadmap_progress 
            WHERE user_id = ? AND step_id = ?
        ");
        $stmt->execute([$user_id, $step_id]);
        $existing = $stmt->fetch();
        
        if($existing) {
            // Update existing record
            $stmt = $pdo->prepare("
                UPDATE user_roadmap_progress 
                SET completed = TRUE, completed_at = NOW()
                WHERE user_id = ? AND step_id = ?
            ");
            $stmt->execute([$user_id, $step_id]);
        } else {
            // Insert new record
            $stmt = $pdo->prepare("
                INSERT INTO user_roadmap_progress (user_id, step_id, completed, completed_at)
                VALUES (?, ?, TRUE, NOW())
            ");
            $stmt->execute([$user_id, $step_id]);
        }
        
        echo json_encode([
            'success' => true,
            'message' => 'Step marked as complete'
        ]);
        
    } else {
        // Mark as incomplete
        $stmt = $pdo->prepare("
            UPDATE user_roadmap_progress 
            SET completed = FALSE, completed_at = NULL
            WHERE user_id = ? AND step_id = ?
        ");
        $stmt->execute([$user_id, $step_id]);
        
        echo json_encode([
            'success' => true,
            'message' => 'Step marked as incomplete'
        ]);
    }
    
} catch(PDOException $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Database error: ' . $e->getMessage()
    ]);
}
?>
