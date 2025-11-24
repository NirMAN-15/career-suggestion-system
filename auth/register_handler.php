<?php
/**
 * Registration Handler
 * Member 1 - Authentication System
 * 
 * Processes user registration form submission
 */

// Include database configuration
require_once '../config/database.php';

// Start session
session_start();

// Check if form was submitted via POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../register.php?error=invalid_request");
    exit();
}

// Get and sanitize form data
$full_name = sanitizeInput($_POST['full_name'] ?? '');
$username = sanitizeInput($_POST['username'] ?? '');
$email = sanitizeInput($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';
$confirm_password = $_POST['confirm_password'] ?? '';
$terms_accepted = isset($_POST['terms']);

// Validation
$errors = [];

// Check if all fields are filled
if (empty($full_name) || empty($username) || empty($email) || empty($password) || empty($confirm_password)) {
    $errors[] = 'empty_fields';
}

// Validate username format
if (!empty($username) && !preg_match('/^[a-zA-Z0-9_]{3,20}$/', $username)) {
    $errors[] = 'invalid_username';
}

// Validate email
if (!empty($email) && !isValidEmail($email)) {
    $errors[] = 'invalid_email';
}

// Validate password length
if (!empty($password) && strlen($password) < 8) {
    $errors[] = 'password_weak';
}

// Check if passwords match
if (!empty($password) && !empty($confirm_password) && $password !== $confirm_password) {
    $errors[] = 'password_mismatch';
}

// Check if terms are accepted
if (!$terms_accepted) {
    $errors[] = 'terms_not_accepted';
}

// If there are validation errors, redirect back
if (!empty($errors)) {
    $error_string = implode('&', array_map(function($err) { return "error=$err"; }, $errors));
    $redirect_url = "../register.php?$error_string&full_name=" . urlencode($full_name) . 
                   "&username=" . urlencode($username) . "&email=" . urlencode($email);
    header("Location: $redirect_url");
    exit();
}

try {
    // Check if email already exists
    $stmt = $pdo->prepare("SELECT user_id FROM users WHERE email = ?");
    $stmt->execute([$email]);
    if ($stmt->fetch()) {
        header("Location: ../register.php?error=email_exists&username=" . urlencode($username) . 
               "&full_name=" . urlencode($full_name));
        exit();
    }
    
    // Check if username already exists
    $stmt = $pdo->prepare("SELECT user_id FROM users WHERE username = ?");
    $stmt->execute([$username]);
    if ($stmt->fetch()) {
        header("Location: ../register.php?error=username_exists&email=" . urlencode($email) . 
               "&full_name=" . urlencode($full_name));
        exit();
    }
    
    // Hash password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
    // Insert new user
    $sql = "INSERT INTO users (username, email, password, full_name, date_of_birth, phone, education_level, created_at) 
            VALUES (?, ?, ?, ?, ?, ?, ?, NOW())";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$username, $email, $hashed_password, $full_name, null, null, null]);
    
    // Get the newly created user ID
    $user_id = $pdo->lastInsertId();
    
    // Log the registration (optional)
    $log_sql = "INSERT INTO session_logs (user_id, ip_address, user_agent, login_time) 
                VALUES (?, ?, ?, NOW())";
    $log_stmt = $pdo->prepare($log_sql);
    $log_stmt->execute([
        $user_id,
        $_SERVER['REMOTE_ADDR'] ?? 'unknown',
        $_SERVER['HTTP_USER_AGENT'] ?? 'unknown'
    ]);
    
    // Redirect to login page with success message
    header("Location: ../login.php?success=registered&email=" . urlencode($email));
    exit();
    
} catch (PDOException $e) {
    // Log error
    error_log("Registration Error: " . $e->getMessage());
    
    // Redirect back with error
    header("Location: ../register.php?error=registration_failed&full_name=" . urlencode($full_name) . 
           "&username=" . urlencode($username) . "&email=" . urlencode($email));
    exit();
}
?>