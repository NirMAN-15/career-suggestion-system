<?php
session_start();
header('Content-Type: application/json');

// Check if user is logged in
if(!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit();
}

require_once '../config/database.php';

$user_id = $_SESSION['user_id'];

try {
    // Fetch saved progress
    $stmt = $pdo->prepare("
        SELECT current_question, answers, updated_at 
        FROM user_progress 
        WHERE user_id = ?
    ");
    $stmt->execute([$user_id]);
    $progress = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if($progress) {
        // Decode answers JSON
        $progress['answers'] = json_decode($progress['answers'], true);
        
        echo json_encode([
            'success' => true,
            'progress' => $progress
        ]);
    } else {
        echo json_encode([
            'success' => true,
            'progress' => null
        ]);
    }
    
} catch(PDOException $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Failed to retrieve progress: ' . $e->getMessage()
    ]);
}
?>