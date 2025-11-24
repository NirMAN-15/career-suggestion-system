<?php
/**
 * Session Check & Authentication Validation
 * Member 1 - Authentication System
 * 
 * Include this file at the top of protected pages
 * Usage: require_once 'auth/session_check.php';
 */

// IMPORTANT: Set ini_set configurations BEFORE session_start()
if (session_status() == PHP_SESSION_NONE) {
    // Session configuration for security (MUST be before session_start)
    ini_set('session.cookie_httponly', 1);
    ini_set('session.use_only_cookies', 1);
    ini_set('session.cookie_secure', 0); // Set to 1 if using HTTPS
    ini_set('session.gc_maxlifetime', 3600); // Session lifetime: 1 hour
    ini_set('session.cookie_lifetime', 3600); // Cookie lifetime: 1 hour
    
    // Start session AFTER ini_set configurations
    session_start();
}

// Session timeout (30 minutes)
define('SESSION_TIMEOUT', 1800);

/**
 * Check if user is logged in
 * 
 * @return bool
 */
function isLoggedIn() {
    return isset($_SESSION['user_id']) && 
           isset($_SESSION['username']) && 
           isset($_SESSION['last_activity']);
}

/**
 * Check session timeout
 * 
 * @return bool
 */
function isSessionExpired() {
    if (isset($_SESSION['last_activity'])) {
        $inactive_time = time() - $_SESSION['last_activity'];
        return $inactive_time > SESSION_TIMEOUT;
    }
    return true;
}

/**
 * Regenerate session ID for security
 */
function regenerateSession() {
    session_regenerate_id(true);
    $_SESSION['last_regeneration'] = time();
}

/**
 * Update last activity timestamp
 */
function updateActivity() {
    $_SESSION['last_activity'] = time();
}

/**
 * Destroy session and logout
 */
function destroySession() {
    $_SESSION = array();
    
    if (isset($_COOKIE[session_name()])) {
        setcookie(session_name(), '', time() - 3600, '/');
    }
    
    session_destroy();
}

/**
 * Redirect to login page
 */
function redirectToLogin() {
    header("Location: ../login.php?error=session_expired");
    exit();
}

// Main session validation
if (!isLoggedIn()) {
    redirectToLogin();
}

// Check if session has expired
if (isSessionExpired()) {
    destroySession();
    redirectToLogin();
}

// Update last activity time
updateActivity();

// Regenerate session ID every 30 minutes for security
if (!isset($_SESSION['last_regeneration'])) {
    $_SESSION['last_regeneration'] = time();
} else {
    if (time() - $_SESSION['last_regeneration'] > 1800) {
        regenerateSession();
    }
}

// Make user data easily accessible
$current_user_id = $_SESSION['user_id'];
$current_username = $_SESSION['username'];
$current_user_email = $_SESSION['email'] ?? '';
$current_user_fullname = $_SESSION['full_name'] ?? '';

/**
 * Get user role (if you implement roles later)
 * 
 * @return string
 */
function getUserRole() {
    return $_SESSION['role'] ?? 'user';
}

/**
 * Check if user has specific permission
 * 
 * @param string $permission
 * @return bool
 */
function hasPermission($permission) {
    // Implement permission checking logic here
    // For now, return true for all logged-in users
    return true;
}
?>