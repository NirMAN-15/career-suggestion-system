/**
 * Authentication Form Validation
 * Member 1 - Authentication System
 * 
 * Client-side validation for login and registration forms
 */

document.addEventListener('DOMContentLoaded', function() {
    
    // ========================================
    // REGISTRATION FORM VALIDATION
    // ========================================
    const registerForm = document.getElementById('registerForm');
    
    if (registerForm) {
        // Real-time validation
        const fullNameInput = document.getElementById('full_name');
        const usernameInput = document.getElementById('username');
        const emailInput = document.getElementById('email');
        const passwordInput = document.getElementById('password');
        const confirmPasswordInput = document.getElementById('confirm_password');
        const termsCheckbox = document.getElementById('terms');
        
        // Full Name Validation
        if (fullNameInput) {
            fullNameInput.addEventListener('blur', function() {
                validateFullName();
            });
        }
        
        // Username Validation
        if (usernameInput) {
            usernameInput.addEventListener('blur', function() {
                validateUsername();
            });
            
            usernameInput.addEventListener('input', function() {
                // Remove invalid characters as user types
                this.value = this.value.replace(/[^a-zA-Z0-9_]/g, '');
            });
        }
        
        // Email Validation
        if (emailInput) {
            emailInput.addEventListener('blur', function() {
                validateEmail();
            });
        }
        
        // Password Validation
        if (passwordInput) {
            passwordInput.addEventListener('input', function() {
                validatePassword();
                if (confirmPasswordInput.value) {
                    validateConfirmPassword();
                }
            });
        }
        
        // Confirm Password Validation
        if (confirmPasswordInput) {
            confirmPasswordInput.addEventListener('input', function() {
                validateConfirmPassword();
            });
        }
        
        // Terms Checkbox Validation
        if (termsCheckbox) {
            termsCheckbox.addEventListener('change', function() {
                validateTerms();
            });
        }
        
        // Form Submit
        registerForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Validate all fields
            const isFullNameValid = validateFullName();
            const isUsernameValid = validateUsername();
            const isEmailValid = validateEmail();
            const isPasswordValid = validatePassword();
            const isConfirmPasswordValid = validateConfirmPassword();
            const isTermsValid = validateTerms();
            
            // If all validations pass, submit the form
            if (isFullNameValid && isUsernameValid && isEmailValid && 
                isPasswordValid && isConfirmPasswordValid && isTermsValid) {
                
                // Show loading state
                const submitBtn = registerForm.querySelector('button[type="submit"]');
                submitBtn.classList.add('loading');
                submitBtn.disabled = true;
                
                // Submit form
                registerForm.submit();
            }
        });
    }
    
    // ========================================
    // LOGIN FORM VALIDATION
    // ========================================
    const loginForm = document.getElementById('loginForm');
    
    if (loginForm) {
        const emailInput = document.getElementById('email');
        const passwordInput = document.getElementById('password');
        
        // Email Validation
        if (emailInput) {
            emailInput.addEventListener('blur', function() {
                validateLoginEmail();
            });
        }
        
        // Password Validation
        if (passwordInput) {
            passwordInput.addEventListener('blur', function() {
                validateLoginPassword();
            });
        }
        
        // Form Submit
        loginForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Validate fields
            const isEmailValid = validateLoginEmail();
            const isPasswordValid = validateLoginPassword();
            
            // If validations pass, submit the form
            if (isEmailValid && isPasswordValid) {
                // Show loading state
                const submitBtn = loginForm.querySelector('button[type="submit"]');
                submitBtn.classList.add('loading');
                submitBtn.disabled = true;
                
                // Submit form
                loginForm.submit();
            }
        });
    }
    
    // ========================================
    // PASSWORD TOGGLE FUNCTIONALITY
    // ========================================
    const togglePasswordBtns = document.querySelectorAll('.password-toggle');
    
    togglePasswordBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const input = this.previousElementSibling;
            const icon = this.querySelector('i');
            
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });
    });
    
    // ========================================
    // VALIDATION FUNCTIONS
    // ========================================
    
    function validateFullName() {
        const input = document.getElementById('full_name');
        const errorSpan = document.getElementById('full_name-error');
        const value = input.value.trim();
        
        if (value === '') {
            showError(input, errorSpan, 'Full name is required');
            return false;
        } else if (value.length < 3) {
            showError(input, errorSpan, 'Full name must be at least 3 characters');
            return false;
        } else {
            showSuccess(input, errorSpan);
            return true;
        }
    }
    
    function validateUsername() {
        const input = document.getElementById('username');
        const errorSpan = document.getElementById('username-error');
        const value = input.value.trim();
        const usernameRegex = /^[a-zA-Z0-9_]{3,20}$/;
        
        if (value === '') {
            showError(input, errorSpan, 'Username is required');
            return false;
        } else if (!usernameRegex.test(value)) {
            showError(input, errorSpan, 'Username must be 3-20 characters (letters, numbers, underscore)');
            return false;
        } else {
            showSuccess(input, errorSpan);
            return true;
        }
    }
    
    function validateEmail() {
        const input = document.getElementById('email');
        const errorSpan = document.getElementById('email-error');
        const value = input.value.trim();
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        
        if (value === '') {
            showError(input, errorSpan, 'Email is required');
            return false;
        } else if (!emailRegex.test(value)) {
            showError(input, errorSpan, 'Please enter a valid email address');
            return false;
        } else {
            showSuccess(input, errorSpan);
            return true;
        }
    }
    
    function validatePassword() {
        const input = document.getElementById('password');
        const errorSpan = document.getElementById('password-error');
        const value = input.value;
        
        if (value === '') {
            showError(input, errorSpan, 'Password is required');
            return false;
        } else if (value.length < 8) {
            showError(input, errorSpan, 'Password must be at least 8 characters long');
            return false;
        } else {
            showSuccess(input, errorSpan);
            return true;
        }
    }
    
    function validateConfirmPassword() {
        const passwordInput = document.getElementById('password');
        const input = document.getElementById('confirm_password');
        const errorSpan = document.getElementById('confirm_password-error');
        const value = input.value;
        
        if (value === '') {
            showError(input, errorSpan, 'Please confirm your password');
            return false;
        } else if (value !== passwordInput.value) {
            showError(input, errorSpan, 'Passwords do not match');
            return false;
        } else {
            showSuccess(input, errorSpan);
            return true;
        }
    }
    
    function validateTerms() {
        const checkbox = document.getElementById('terms');
        const errorSpan = document.getElementById('terms-error');
        
        if (!checkbox.checked) {
            errorSpan.textContent = 'You must agree to the terms and conditions';
            return false;
        } else {
            errorSpan.textContent = '';
            return true;
        }
    }
    
    function validateLoginEmail() {
        const input = document.getElementById('email');
        const errorSpan = document.getElementById('email-error');
        const value = input.value.trim();
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        
        if (value === '') {
            showError(input, errorSpan, 'Email is required');
            return false;
        } else if (!emailRegex.test(value)) {
            showError(input, errorSpan, 'Please enter a valid email address');
            return false;
        } else {
            showSuccess(input, errorSpan);
            return true;
        }
    }
    
    function validateLoginPassword() {
        const input = document.getElementById('password');
        const errorSpan = document.getElementById('password-error');
        const value = input.value;
        
        if (value === '') {
            showError(input, errorSpan, 'Password is required');
            return false;
        } else {
            showSuccess(input, errorSpan);
            return true;
        }
    }
    
    function showError(input, errorSpan, message) {
        input.classList.add('error');
        input.classList.remove('success');
        if (errorSpan) {
            errorSpan.textContent = message;
        }
    }
    
    function showSuccess(input, errorSpan) {
        input.classList.remove('error');
        input.classList.add('success');
        if (errorSpan) {
            errorSpan.textContent = '';
        }
    }
    
});