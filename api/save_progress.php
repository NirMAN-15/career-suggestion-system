<?php
session_start();
header('Content-Type: application/json');

// Check if user is logged in
if(!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit();
}

require_once '../config/database.php';

// Get JSON data
$input = json_decode(file_get_contents('php://input'), true);

if(!isset($input['answers'])) {
    echo json_encode(['success' => false, 'message' => 'No data provided']);
    exit();
}

$user_id = $_SESSION['user_id'];
$current_question = $input['currentQuestion'] ?? 0;
$answers = json_encode($input['answers']);

try {
    // Check if progress exists
    $stmt = $pdo->prepare("SELECT progress_id FROM user_progress WHERE user_id = ?");
    $stmt->execute([$user_id]);
    $existing = $stmt->fetch();
    
    if($existing) {
        // Update existing progress
        $stmt = $pdo->prepare("
            UPDATE user_progress 
            SET current_question = ?, answers = ?, updated_at = NOW() 
            WHERE user_id = ?
        ");
        $stmt->execute([$current_question, $answers, $user_id]);
    } else {
        // Insert new progress
        $stmt = $pdo->prepare("
            INSERT INTO user_progress (user_id, current_question, answers, updated_at) 
            VALUES (?, ?, ?, NOW())
        ");
        $stmt->execute([$user_id, $current_question, $answers]);
    }
    
    echo json_encode(['success' => true, 'message' => 'Progress saved']);
    
} catch(PDOException $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Failed to save progress: ' . $e->getMessage()
    ]);
}
?>