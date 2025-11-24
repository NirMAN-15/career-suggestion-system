<?php
/**
 * User Login Page
 * Member 1 - Authentication System
 */

// Start session
session_start();

// If already logged in, redirect to home
if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

// Page configuration
$page_title = "Login - Career Suggestion System";
$page_css = "css/auth.css";
$page_js = "js/auth_validation.js";
$page_global_css = "css/global.css";

// Include header (without navbar)
include 'includes/header.php';

// Get error/success messages from URL
$error = $_GET['error'] ?? '';
$success = $_GET['success'] ?? '';

// Include global CSS
if (isset($page_global_css)) {
    echo "<link rel='stylesheet' href='$page_global_css'>";
}
?>

<div class="main-content">
    <div class="container">
        <div class="auth-card">
            <div class="auth-header">
                <div class="auth-icon">
                    <i class="fas fa-sign-in-alt"></i>
                </div>
                <h2 class="card-title">Welcome Back!</h2>
                <p style="color: var(--gray); text-align: center;">
                    Login to continue your career journey
                </p>
            </div>

            <?php if ($error): ?>
                <div class="alert alert-error" id="error-alert">
                    <i class="fas fa-exclamation-circle"></i>
                    <span>
                        <?php
                        switch ($error) {
                            case 'empty_fields':
                                echo 'Please enter both email and password.';
                                break;
                            case 'invalid_credentials':
                                echo 'Invalid email or password. Please try again.';
                                break;
                            case 'account_inactive':
                                echo 'Your account has been deactivated. Contact support.';
                                break;
                            case 'session_expired':
                                echo 'Your session has expired. Please login again.';
                                break;
                            case 'login_required':
                                echo 'Please login to access this page.';
                                break;
                            default:
                                echo 'An error occurred. Please try again.';
                        }
                        ?>
                    </span>
                </div>
            <?php endif; ?>

            <?php if ($success === 'registered'): ?>
                <div class="alert alert-success" id="success-alert">
                    <i class="fas fa-check-circle"></i>
                    <span>Registration successful! Please login with your credentials.</span>
                </div>
            <?php endif; ?>

            <?php if ($success === 'logged_out'): ?>
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i>
                    <span>You have been successfully logged out.</span>
                </div>
            <?php endif; ?>

            <form id="loginForm" method="POST" action="auth/login_handler.php" novalidate>
                <!-- Email -->
                <div class="form-group">
                    <label class="form-label" for="email">
                        <i class="fas fa-envelope"></i> Email Address
                    </label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        class="form-control" 
                        placeholder="your.email@example.com"
                        required
                        autofocus
                        value="<?php echo htmlspecialchars($_GET['email'] ?? ''); ?>"
                    >
                    <span class="error-message" id="email-error"></span>
                </div>

                <!-- Password -->
                <div class="form-group">
                    <label class="form-label" for="password">
                        <i class="fas fa-lock"></i> Password
                    </label>
                    <div class="password-input-wrapper">
                        <input 
                            type="password" 
                            id="password" 
                            name="password" 
                            class="form-control" 
                            placeholder="Enter your password"
                            required
                        >
                        <button type="button" class="password-toggle" id="togglePassword">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                    <span class="error-message" id="password-error"></span>
                </div>

                <!-- Remember Me & Forgot Password -->
                <div class="form-options">
                    <label class="checkbox-label">
                        <input type="checkbox" name="remember_me" id="remember_me">
                        <span>Remember me</span>
                    </label>
                    <a href="#" class="forgot-password">
                        Forgot Password?
                    </a>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn btn-primary" style="width: 100%;">
                    <i class="fas fa-sign-in-alt"></i> Login
                </button>
            </form>

            <!-- Divider -->
            <div class="auth-divider">
                <span>OR</span>
            </div>

            <!-- Register Link -->
            <div class="auth-footer">
                <p>Don't have an account yet?</p>
                <a href="register.php" class="btn btn-outline" style="width: 100%;">
                    <i class="fas fa-user-plus"></i> Create Account
                </a>
            </div>

            <!-- Demo Credentials (Remove in production!) -->
            <div style="margin-top: 24px; padding: 16px; background-color: var(--primary-light); border-radius: var(--radius-md); text-align: center;">
                <p style="font-size: 14px; color: var(--primary-dark); margin-bottom: 8px;">
                    <strong>Demo Credentials:</strong>
                </p>
                <p style="font-size: 13px; color: var(--gray); margin: 0;">
                    Email: test@example.com<br>
                    Password: password123
                </p>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>