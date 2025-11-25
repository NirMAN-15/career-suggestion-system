<?php
session_start();
require_once 'config/database.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

// Check if user has completed assessment
$stmt = $pdo->prepare("SELECT COUNT(*) as answer_count FROM user_answers WHERE user_id = ?");
$stmt->execute([$user_id]);
$result = $stmt->fetch(PDO::FETCH_ASSOC);

if ($result['answer_count'] == 0) {
    header('Location: assessment.php');
    exit();
}

$page_title = "Your Career Results";
$page_css = "css/results.css";
$page_js = "js/results.js";
include 'includes/header.php';
include 'includes/navbar.php';
?>

<div class="main-content">
    <div class="container">
        <!-- Loading State -->
        <div id="loadingState" class="card" style="text-align: center; padding: 60px;">
            <div class="spinner" style="margin: 0 auto;"></div>
            <h3 style="margin-top: 20px; color: var(--gray);">Analyzing Your Answers...</h3>
            <p style="color: var(--gray);">We're calculating your career matches based on your preferences.</p>
        </div>

        <!-- Results Container (Hidden Initially) -->
        <div id="resultsContainer" style="display: none;">
            <!-- Header Section -->
            <div class="results-header">
                <h1 class="page-title">
                    <i class="fas fa-trophy"></i> Your Top Career Matches
                </h1>
                <p class="subtitle">Based on your assessment, here are the IT careers that best match your preferences and skills.</p>
            </div>

            <!-- Career Cards Container -->
            <div id="careerCards">
                <!-- Career cards will be loaded here via JavaScript -->
            </div>

            <!-- Retake Assessment Button -->
            <div style="text-align: center; margin-top: 40px;">
                <a href="assessment.php" class="btn btn-outline">
                    <i class="fas fa-redo"></i> Retake Assessment
                </a>
                <a href="roadmap.php" class="btn btn-primary" style="margin-left: 16px;">
                    <i class="fas fa-route"></i> View Career Roadmap
                </a>
            </div>
        </div>

        <!-- Error State -->
        <div id="errorState" class="card" style="display: none; text-align: center; padding: 60px;">
            <i class="fas fa-exclamation-triangle" style="font-size: 48px; color: var(--error);"></i>
            <h3 style="margin-top: 20px; color: var(--dark);">Something Went Wrong</h3>
            <p style="color: var(--gray);">We couldn't calculate your career matches. Please try again.</p>
            <button class="btn btn-primary" onclick="location.reload()">
                <i class="fas fa-redo"></i> Retry
            </button>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>