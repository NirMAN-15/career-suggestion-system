<?php
session_start();
require_once '../config/database.php';

header('Content-Type: application/json');

// Check authentication
if(!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'Not authenticated']);
    exit;
}

// Check request method
if($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['error' => 'Invalid request method']);
    exit;
}

// Get and validate input
$subject = isset($_POST['subject']) ? trim($_POST['subject']) : '';
$message = isset($_POST['message']) ? trim($_POST['message']) : '';

if(empty($subject) || empty($message)) {
    echo json_encode([
        'success' => false,
        'error' => 'Subject and message are required'
    ]);
    exit;
}

// Validate lengths
if(strlen($subject) > 200) {
    echo json_encode([
        'success' => false,
        'error' => 'Subject must be less than 200 characters'
    ]);
    exit;
}

try {
    // Insert contact message
    $stmt = $pdo->prepare("
        INSERT INTO contact_messages (user_id, subject, message, status, created_at)
        VALUES (?, ?, ?, 'pending', NOW())
    ");
    
    $stmt->execute([
        $_SESSION['user_id'],
        $subject,
        $message
    ]);
    
    // Optional: Send email notification to admin
    // $to = "support@careerpath.com";
    // $email_subject = "New Contact Message: " . $subject;
    // mail($to, $email_subject, $message);
    
    echo json_encode([
        'success' => true,
        'message' => 'Your message has been sent successfully! We will respond within 24 hours.'
    ]);
    
} catch(PDOException $e) {
    echo json_encode([
        'success' => false,
        'error' => 'Failed to send message. Please try again.'
    ]);
}
?>