<?php
/**
 * User Registration Page
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
$page_title = "Register - Career Suggestion System";
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
                    <i class="fas fa-user-plus"></i>
                </div>
                <h2 class="card-title">Create Your Account</h2>
                <p style="color: var(--gray); text-align: center;">
                    Start your career discovery journey today
                </p>
            </div>

            <?php if ($error): ?>
                <div class="alert alert-error" id="error-alert">
                    <i class="fas fa-exclamation-circle"></i>
                    <span>
                        <?php
                        switch ($error) {
                            case 'empty_fields':
                                echo 'Please fill in all required fields.';
                                break;
                            case 'invalid_email':
                                echo 'Please enter a valid email address.';
                                break;
                            case 'password_mismatch':
                                echo 'Passwords do not match.';
                                break;
                            case 'password_weak':
                                echo 'Password must be at least 8 characters long.';
                                break;
                            case 'email_exists':
                                echo 'This email is already registered. Please login instead.';
                                break;
                            case 'username_exists':
                                echo 'This username is already taken. Please choose another.';
                                break;
                            case 'registration_failed':
                                echo 'Registration failed. Please try again.';
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
                    <span>Registration successful! Please login to continue.</span>
                </div>
            <?php endif; ?>

            <form id="registerForm" method="POST" action="auth/register_handler.php" novalidate>
                <!-- Full Name -->
                <div class="form-group">
                    <label class="form-label" for="full_name">
                        <i class="fas fa-user"></i> Full Name
                    </label>
                    <input 
                        type="text" 
                        id="full_name" 
                        name="full_name" 
                        class="form-control" 
                        placeholder="Enter your full name"
                        required
                        value="<?php echo htmlspecialchars($_GET['full_name'] ?? ''); ?>"
                    >
                    <span class="error-message" id="full_name-error"></span>
                </div>

                <!-- Username -->
                <div class="form-group">
                    <label class="form-label" for="username">
                        <i class="fas fa-at"></i> Username
                    </label>
                    <input 
                        type="text" 
                        id="username" 
                        name="username" 
                        class="form-control" 
                        placeholder="Choose a username"
                        required
                        pattern="[a-zA-Z0-9_]{3,20}"
                        value="<?php echo htmlspecialchars($_GET['username'] ?? ''); ?>"
                    >
                    <small style="color: var(--gray); font-size: 14px;">
                        3-20 characters, letters, numbers, and underscore only
                    </small>
                    <span class="error-message" id="username-error"></span>
                </div>

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
                            placeholder="Create a strong password"
                            required
                            minlength="8"
                        >
                        <button type="button" class="password-toggle" id="togglePassword">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                    <small style="color: var(--gray); font-size: 14px;">
                        Minimum 8 characters
                    </small>
                    <span class="error-message" id="password-error"></span>
                </div>

                <!-- Confirm Password -->
                <div class="form-group">
                    <label class="form-label" for="confirm_password">
                        <i class="fas fa-lock"></i> Confirm Password
                    </label>
                    <div class="password-input-wrapper">
                        <input 
                            type="password" 
                            id="confirm_password" 
                            name="confirm_password" 
                            class="form-control" 
                            placeholder="Re-enter your password"
                            required
                        >
                        <button type="button" class="password-toggle" id="toggleConfirmPassword">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                    <span class="error-message" id="confirm_password-error"></span>
                </div>

                <!-- Terms and Conditions -->
                <div class="form-group">
                    <label class="checkbox-label">
                        <input type="checkbox" id="terms" name="terms" required>
                        <span>
                            I agree to the <a href="#" style="color: var(--primary-color);">Terms and Conditions</a> 
                            and <a href="#" style="color: var(--primary-color);">Privacy Policy</a>
                        </span>
                    </label>
                    <span class="error-message" id="terms-error"></span>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn btn-primary" style="width: 100%;">
                    <i class="fas fa-user-plus"></i> Create Account
                </button>
            </form>

            <!-- Divider -->
            <div class="auth-divider">
                <span>OR</span>
            </div>

            <!-- Login Link -->
            <div class="auth-footer">
                <p>Already have an account?</p>
                <a href="login.php" class="btn btn-outline" style="width: 100%;">
                    <i class="fas fa-sign-in-alt"></i> Login Instead
                </a>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>