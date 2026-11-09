<?php
// Check if user is logged in
session_start();
if(!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$page_title = "Career Assessment - Find Your IT Path";
$page_css = "css/assessment.css";
$page_js = "js/assessment.js";
include 'includes/header.php';
include 'includes/navbar.php';
?>

<div class="main-content">
    <div class="container">
        <!-- Welcome Card -->
        <div class="card" style="text-align: center; margin-bottom: 30px;">
            <h1 style="color: var(--primary-color); margin-bottom: 10px;">
                <i class="fas fa-clipboard-question"></i> Career Assessment
            </h1>
            <p style="color: var(--gray); font-size: 18px; margin-bottom: 0;">
                Answer 20 questions to discover your ideal IT career path
            </p>
        </div>

        <!-- Progress Section -->
        <div class="card" id="assessmentCard">
            <!-- Progress Bar -->
            <div class="progress-container">
                <div class="progress-bar">
                    <div class="progress-fill" id="progressFill"></div>
                </div>
                <p class="progress-text">
                    Question <span id="currentQuestion">1</span> of <span id="totalQuestions">20</span>
                    <span style="float: right; color: var(--primary-color); font-weight: 600;">
                        <span id="progressPercentage">0</span>% Complete
                    </span>
                </p>
            </div>

            <!-- Question Container -->
            <div id="questionContainer">
                <div class="question-card">
                    <h3 class="question-title" id="questionTitle">Loading...</h3>
                    <p class="question-number" id="questionNumber">Question 1 of 20</p>
                    
                    <div class="options-container" id="optionsContainer">
                        <!-- Options will be loaded dynamically via JavaScript -->
                    </div>
                </div>
            </div>

            <!-- Navigation Buttons -->
            <div class="navigation-buttons">
                <button class="btn btn-outline" id="prevBtn" style="display: none;">
                    <i class="fas fa-arrow-left"></i> Previous
                </button>
                
                <button class="btn btn-primary" id="nextBtn" style="margin-left: auto;" disabled>
                    Next <i class="fas fa-arrow-right"></i>
                </button>
                
                <button class="btn btn-secondary" id="submitBtn" style="display: none; margin-left: auto;">
                    Submit Assessment <i class="fas fa-check"></i>
                </button>
            </div>
        </div>

        <!-- Completion Message (Hidden Initially) -->
        <div class="card" id="completionCard" style="display: none; text-align: center;">
            <div style="font-size: 64px; color: var(--secondary-color); margin-bottom: 20px;">
                <i class="fas fa-check-circle"></i>
            </div>
            <h2 style="color: var(--dark); margin-bottom: 15px;">Assessment Completed!</h2>
            <p style="color: var(--gray); font-size: 18px; margin-bottom: 30px;">
                Thank you for completing the assessment. We're analyzing your responses...
            </p>
            <div class="spinner" style="margin: 0 auto;"></div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>