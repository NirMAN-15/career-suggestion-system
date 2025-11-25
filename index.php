<?php
require_once 'auth/session_check.php';
require_once 'config/database.php';

$page_title = "Home - Career Suggestion System";
$page_css = "css/home.css";
$page_js = "js/home.js";

// Fetch user information
$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT * FROM users WHERE user_id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Check if user has completed assessment
$stmt = $pdo->prepare("SELECT COUNT(*) as count FROM user_answers WHERE user_id = ?");
$stmt->execute([$user_id]);
$assessment_completed = $stmt->fetch(PDO::FETCH_ASSOC)['count'] > 0;

// Get career match if exists
$career_match = null;
if($assessment_completed) {
    $stmt = $pdo->prepare("
        SELECT c.career_name, c.description, ucm.match_percentage 
        FROM user_career_matches ucm 
        JOIN careers c ON ucm.career_id = c.career_id 
        WHERE ucm.user_id = ? 
        ORDER BY ucm.match_percentage DESC 
        LIMIT 1
    ");
    $stmt->execute([$user_id]);
    $career_match = $stmt->fetch(PDO::FETCH_ASSOC);
}

// Get roadmap progress
$roadmap_progress = 0;
if($assessment_completed) {
    $stmt = $pdo->prepare("
        SELECT COUNT(CASE WHEN completed = TRUE THEN 1 END) as completed,
               COUNT(*) as total
        FROM user_roadmap_progress urp
        WHERE urp.user_id = ?
    ");
    $stmt->execute([$user_id]);
    $progress_data = $stmt->fetch(PDO::FETCH_ASSOC);
    if($progress_data['total'] > 0) {
        $roadmap_progress = round(($progress_data['completed'] / $progress_data['total']) * 100);
    }
}

include 'includes/header.php';
include 'includes/navbar.php';
?>

<div class="main-content">
    <div class="container">
        
        <!-- Welcome Section -->
        <div class="welcome-banner">
            <div class="welcome-content">
                <h1><i class="fas fa-hand-wave"></i> Welcome back, <?php echo htmlspecialchars($user['full_name'] ?? $user['username']); ?>!</h1>
                <p>Ready to continue your career journey?</p>
            </div>
            <div class="welcome-icon">
                <i class="fas fa-rocket"></i>
            </div>
        </div>

        <?php if(!$assessment_completed): ?>
        <!-- Start Assessment CTA -->
        <div class="alert alert-info">
            <i class="fas fa-info-circle" style="margin-right: 12px; font-size: 20px;"></i>
            <div>
                <strong>Get Started!</strong>
                <p style="margin: 4px 0 0 0;">Take our career assessment to discover the best career paths for you.</p>
            </div>
            <a href="assessment.php" class="btn btn-primary" style="margin-left: auto;">
                Start Assessment <i class="fas fa-arrow-right"></i>
            </a>
        </div>
        <?php endif; ?>

        <!-- Dashboard Stats -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon" style="background-color: var(--primary-light); color: var(--primary-color);">
                    <i class="fas fa-clipboard-check"></i>
                </div>
                <div class="stat-info">
                    <h3><?php echo $assessment_completed ? 'Completed' : 'Not Started'; ?></h3>
                    <p>Assessment Status</p>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon" style="background-color: var(--secondary-light); color: var(--secondary-color);">
                    <i class="fas fa-briefcase"></i>
                </div>
                <div class="stat-info">
                    <h3><?php echo $career_match ? '1' : '0'; ?></h3>
                    <p>Career Match</p>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon" style="background-color: #fef3c7; color: var(--accent-color);">
                    <i class="fas fa-route"></i>
                </div>
                <div class="stat-info">
                    <h3><?php echo $roadmap_progress; ?>%</h3>
                    <p>Roadmap Progress</p>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon" style="background-color: #e0e7ff; color: #6366f1;">
                    <i class="fas fa-book-open"></i>
                </div>
                <div class="stat-info">
                    <h3>Available</h3>
                    <p>Learning Resources</p>
                </div>
            </div>
        </div>

        <div class="dashboard-content">
            <!-- Left Column -->
            <div class="main-column">
                
                <?php if($career_match): ?>
                <!-- Career Match Card -->
                <div class="card">
                    <h2 class="card-title">
                        <i class="fas fa-star"></i> Your Top Career Match
                    </h2>
                    <div class="career-match-content">
                        <div class="match-header">
                            <h3><?php echo htmlspecialchars($career_match['career_name']); ?></h3>
                            <div class="match-percentage">
                                <?php echo $career_match['match_percentage']; ?>% Match
                            </div>
                        </div>
                        <p><?php echo htmlspecialchars($career_match['description']); ?></p>
                        <div style="display: flex; gap: 12px; margin-top: 20px;">
                            <a href="results.php" class="btn btn-primary">
                                View Full Results <i class="fas fa-arrow-right"></i>
                            </a>
                            <a href="roadmap.php" class="btn btn-outline">
                                View Roadmap <i class="fas fa-route"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Quick Actions -->
                <div class="card">
                    <h2 class="card-title">
                        <i class="fas fa-bolt"></i> Quick Actions
                    </h2>
                    <div class="quick-actions">
                        <a href="assessment.php" class="action-btn">
                            <i class="fas fa-clipboard-question"></i>
                            <span><?php echo $assessment_completed ? 'Retake Assessment' : 'Start Assessment'; ?></span>
                        </a>
                        <a href="results.php" class="action-btn">
                            <i class="fas fa-chart-line"></i>
                            <span>View Results</span>
                        </a>
                        <a href="roadmap.php" class="action-btn">
                            <i class="fas fa-route"></i>
                            <span>Career Roadmap</span>
                        </a>
                        <a href="learning.php" class="action-btn">
                            <i class="fas fa-book"></i>
                            <span>Learning Materials</span>
                        </a>
                        <a href="profile.php" class="action-btn">
                            <i class="fas fa-user-edit"></i>
                            <span>Edit Profile</span>
                        </a>
                        <a href="help.php" class="action-btn">
                            <i class="fas fa-question-circle"></i>
                            <span>Help & FAQ</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Right Column (Sidebar) -->
            <div class="sidebar-column">
                
                <!-- Progress Card -->
                <?php if($assessment_completed): ?>
                <div class="card">
                    <h3 class="card-title" style="font-size: 18px;">
                        <i class="fas fa-chart-pie"></i> Your Progress
                    </h3>
                    <div class="progress-item">
                        <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                            <span>Career Roadmap</span>
                            <strong><?php echo $roadmap_progress; ?>%</strong>
                        </div>
                        <div class="progress-bar">
                            <div class="progress-fill" style="width: <?php echo $roadmap_progress; ?>%;"></div>
                        </div>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Recent Activity -->
                <div class="card">
                    <h3 class="card-title" style="font-size: 18px;">
                        <i class="fas fa-clock"></i> Recent Activity
                    </h3>
                    <div class="activity-list">
                        <?php if($assessment_completed): ?>
                        <div class="activity-item">
                            <i class="fas fa-check-circle" style="color: var(--success);"></i>
                            <div>
                                <p style="margin: 0; font-weight: 500;">Assessment Completed</p>
                                <small style="color: var(--gray);">Career assessment finished</small>
                            </div>
                        </div>
                        <?php endif; ?>
                        
                        <div class="activity-item">
                            <i class="fas fa-user-plus" style="color: var(--primary-color);"></i>
                            <div>
                                <p style="margin: 0; font-weight: 500;">Account Created</p>
                                <small style="color: var(--gray);"><?php echo date('M d, Y', strtotime($user['created_at'])); ?></small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Help Card -->
                <div class="card" style="background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%); color: white;">
                    <h3 style="color: white; margin-bottom: 12px;">
                        <i class="fas fa-lightbulb"></i> Need Help?
                    </h3>
                    <p style="margin-bottom: 16px; opacity: 0.9;">
                        Check out our help section for guides and FAQs.
                    </p>
                    <a href="help.php" class="btn" style="background: white; color: var(--primary-color);">
                        Get Help <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>

    </div>
</div>

<?php include 'includes/footer.php'; ?>