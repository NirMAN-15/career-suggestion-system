<?php
/**
 * Logout Handler
 * Member 1 - Authentication System
 * 
 * Logs out the user and destroys session
 */

// Include database configuration
require_once 'config/database.php';

// Start session
session_start();

// Check if user is logged in
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    
    try {
        // Update session log with logout time
        $sql = "UPDATE session_logs 
                SET logout_time = NOW() 
                WHERE user_id = ? 
                AND logout_time IS NULL 
                ORDER BY login_time DESC 
                LIMIT 1";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$user_id]);
    } catch (PDOException $e) {
        error_log("Logout logging error: " . $e->getMessage());
    }
}

// Remove remember me cookie if exists
if (isset($_COOKIE['remember_token'])) {
    setcookie('remember_token', '', time() - 3600, '/', '', false, true);
    unset($_COOKIE['remember_token']);
}

// Destroy all session data
$_SESSION = array();

// Delete session cookie
if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time() - 3600, '/');
}

// Destroy session
session_destroy();

// Redirect to login page with success message
header("Location: login.php?success=logged_out");
exit();
?>