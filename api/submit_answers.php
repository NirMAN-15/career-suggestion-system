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

if(!isset($input['answers']) || empty($input['answers'])) {
    echo json_encode(['success' => false, 'message' => 'No answers provided']);
    exit();
}

$user_id = $_SESSION['user_id'];
$answers = $input['answers'];

try {
    // Begin transaction
    $pdo->beginTransaction();
    
    // Delete any existing answers for this user
    $stmt = $pdo->prepare("DELETE FROM user_answers WHERE user_id = ?");
    $stmt->execute([$user_id]);
    
    // Insert new answers
    $stmt = $pdo->prepare("
        INSERT INTO user_answers (user_id, question_id, answer, submitted_at) 
        VALUES (?, ?, ?, NOW())
    ");
    
    foreach($answers as $question_id => $answer) {
        $stmt->execute([$user_id, $question_id, $answer]);
    }
    
    // Mark assessment as completed in user profile
    $stmt = $pdo->prepare("
        UPDATE users 
        SET assessment_completed = 1, assessment_date = NOW() 
        WHERE user_id = ?
    ");
    $stmt->execute([$user_id]);
    
    // Commit transaction
    $pdo->commit();
    
    // Clear any saved progress
    $stmt = $pdo->prepare("DELETE FROM user_progress WHERE user_id = ?");
    $stmt->execute([$user_id]);
    
    echo json_encode([
        'success' => true,
        'message' => 'Assessment submitted successfully',
        'total_answers' => count($answers)
    ]);
    
} catch(PDOException $e) {
    // Rollback on error
    $pdo->rollBack();
    
    echo json_encode([
        'success' => false,
        'message' => 'Failed to submit assessment: ' . $e->getMessage()
    ]);
}
?>