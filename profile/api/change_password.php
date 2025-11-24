<?php
session_start();
header('Content-Type: application/json');
require_once '../config/database.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

$data = json_decode(file_get_contents("php://input"), true);
$current_pass = $data['current_password'];
$new_pass = $data['new_password'];

try {
    // Verify old password
    $stmt = $pdo->prepare("SELECT password FROM users WHERE user_id = ?");
    $stmt->execute([$_SESSION['user_id']]);
    $user = $stmt->fetch();

    if ($user && password_verify($current_pass, $user['password'])) {
        // Update to new password
        $new_hash = password_hash($new_pass, PASSWORD_DEFAULT);
        $update = $pdo->prepare("UPDATE users SET password = ? WHERE user_id = ?");
        $update->execute([$new_hash, $_SESSION['user_id']]);
        
        echo json_encode(['success' => true, 'message' => 'Password changed successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Incorrect current password']);
    }
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Error processing request']);
}
?>