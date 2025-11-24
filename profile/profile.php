<?php
// Start session and check access
session_start();
require_once 'auth/session_check.php'; // Ensure user is logged in [cite: 19]

// Page configuration
$page_title = "My Profile - CareerPath";
$page_css = "css/profile.css";
$page_js = "js/profile.js";

// Include shared components
include 'includes/header.php';
include 'includes/navbar.php';
?>

<div class="main-content">
    <div class="container">
        <div class="profile-grid">
            
            <div class="profile-sidebar">
                <div class="card center-content">
                    <div class="profile-image-container">
                        <img src="assets/images/default-avatar.png" alt="Profile" id="profileImagePreview" class="profile-img">
                        <div class="edit-icon" onclick="document.getElementById('profile_pic').click()">
                            <i class="fas fa-camera"></i>
                        </div>
                    </div>
                    <h3 id="displayFullName">Loading...</h3>
                    <p class="text-muted" id="displayEmail">Loading...</p>
                    <p class="badge badge-primary" id="displayEducation">Student</p>
                </div>
            </div>

            <div class="profile-content">
                
                <div class="card">
                    <h2 class="card-title"><i class="fas fa-user-edit"></i> Personal Information</h2>
                    <form id="profileForm" enctype="multipart/form-data">
                        <input type="file" id="profile_pic" name="profile_pic" accept="image/*" hidden>
                        
                        <div class="form-row">
                            <div class="form-group half">
                                <label class="form-label">Full Name</label>
                                <input type="text" name="full_name" id="full_name" class="form-control" required>
                            </div>
                            <div class="form-group half">
                                <label class="form-label">Phone Number</label>
                                <input type="tel" name="phone" id="phone" class="form-control">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group half">
                                <label class="form-label">Date of Birth</label>
                                <input type="date" name="date_of_birth" id="date_of_birth" class="form-control">
                            </div>
                            <div class="form-group half">
                                <label class="form-label">Education Level</label>
                                <select name="education_level" id="education_level" class="form-control">
                                    <option value="High School">High School</option>
                                    <option value="Undergraduate">Undergraduate</option>
                                    <option value="Graduate">Graduate</option>
                                    <option value="Professional">Professional</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Career Interests</label>
                            <textarea name="interests" id="interests" class="form-control" rows="3" placeholder="e.g., Coding, Design, Marketing"></textarea>
                        </div>

                        <div id="profileMessage"></div>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </form>
                </div>

                <div class="card">
                    <h2 class="card-title"><i class="fas fa-lock"></i> Security</h2>
                    <form id="passwordForm">
                        <div class="form-group">
                            <label class="form-label">Current Password</label>
                            <input type="password" name="current_password" class="form-control" required>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group half">
                                <label class="form-label">New Password</label>
                                <input type="password" name="new_password" id="new_password" class="form-control" required>
                            </div>
                            <div class="form-group half">
                                <label class="form-label">Confirm New Password</label>
                                <input type="password" name="confirm_password" id="confirm_password" class="form-control" required>
                            </div>
                        </div>

                        <div id="passwordMessage"></div>
                        <button type="submit" class="btn btn-secondary">Update Password</button>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>