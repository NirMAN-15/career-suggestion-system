<?php
/**
 * Login Handler
 * Member 1 - Authentication System
 * 
 * Processes user login form submission
 */

// Include database configuration
require_once '../config/database.php';

// Start session
session_start();

// Check if form was submitted via POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../login.php?error=invalid_request");
    exit();
}

// Get and sanitize form data
$email = sanitizeInput($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';
$remember_me = isset($_POST['remember_me']);

// Validation
if (empty($email) || empty($password)) {
    header("Location: ../login.php?error=empty_fields&email=" . urlencode($email));
    exit();
}

// Validate email format
if (!isValidEmail($email)) {
    header("Location: ../login.php?error=invalid_credentials");
    exit();
}

try {
    // Query user by email
    $sql = "SELECT user_id, username, email, password, full_name, is_active 
            FROM users 
            WHERE email = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$email]);
    $user = $stmt->fetch();
    
    // Check if user exists and password is correct
    if (!$user || !password_verify($password, $user['password'])) {
        // Log failed login attempt (optional)
        error_log("Failed login attempt for email: $email from IP: " . ($_SERVER['REMOTE_ADDR'] ?? 'unknown'));
        
        header("Location: ../login.php?error=invalid_credentials");
        exit();
    }
    
    // Check if account is active
    if (!$user['is_active']) {
        header("Location: ../login.php?error=account_inactive");
        exit();
    }
    
    // Regenerate session ID for security
    session_regenerate_id(true);
    
    // Set session variables
    $_SESSION['user_id'] = $user['user_id'];
    $_SESSION['username'] = $user['username'];
    $_SESSION['email'] = $user['email'];
    $_SESSION['full_name'] = $user['full_name'];
    $_SESSION['last_activity'] = time();
    $_SESSION['last_regeneration'] = time();
    $_SESSION['ip_address'] = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
    
    // Handle "Remember Me" functionality
    if ($remember_me) {
        // Set cookie for 30 days
        $cookie_token = bin2hex(random_bytes(32));
        $_SESSION['remember_token'] = $cookie_token;
        setcookie('remember_token', $cookie_token, time() + (86400 * 30), '/', '', false, true);
    }
    
    // Update last login timestamp
    $update_sql = "UPDATE users SET last_login = NOW() WHERE user_id = ?";
    $update_stmt = $pdo->prepare($update_sql);
    $update_stmt->execute([$user['user_id']]);
    
    // Log successful login
    $log_sql = "INSERT INTO session_logs (user_id, ip_address, user_agent, login_time) 
                VALUES (?, ?, ?, NOW())";
    $log_stmt = $pdo->prepare($log_sql);
    $log_stmt->execute([
        $user['user_id'],
        $_SERVER['REMOTE_ADDR'] ?? 'unknown',
        $_SERVER['HTTP_USER_AGENT'] ?? 'unknown'
    ]);
    
    // Redirect to home page or requested page
    $redirect_to = $_SESSION['redirect_after_login'] ?? '../index.php';
    unset($_SESSION['redirect_after_login']);
    
    header("Location: $redirect_to");
    exit();
    
} catch (PDOException $e) {
    // Log error
    error_log("Login Error: " . $e->getMessage());
    
    // Redirect back with error
    header("Location: ../login.php?error=login_failed");
    exit();
}
?>