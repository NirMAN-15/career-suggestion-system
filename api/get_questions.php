<?php
session_start();
header('Content-Type: application/json');

// Check if user is logged in
if(!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit();
}

require_once '../config/database.php';

try {
    // Fetch all questions from database
    $stmt = $pdo->prepare("
        SELECT question_id, question_text, category, question_type, options 
        FROM questions 
        ORDER BY question_order ASC
    ");
    
    $stmt->execute();
    $questions = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if(count($questions) > 0) {
        echo json_encode([
            'success' => true,
            'questions' => $questions,
            'total' => count($questions)
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'No questions found'
        ]);
    }
    
} catch(PDOException $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Database error: ' . $e->getMessage()
    ]);
}
?>