<?php
$page_title = "Career Roadmap - Career Suggestion System";
$page_css = "css/roadmap.css";
$page_js = "js/roadmap.js";
include 'includes/header.php';
include 'includes/navbar.php';

// Check if user is logged in
if(!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

require_once 'config/database.php';

// Get user's selected career
$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare("
    SELECT c.career_id, c.career_name, c.description, ucm.match_percentage
    FROM user_career_matches ucm
    JOIN careers c ON ucm.career_id = c.career_id
    WHERE ucm.user_id = ?
    ORDER BY ucm.match_percentage DESC
    LIMIT 1
");
$stmt->execute([$user_id]);
$career = $stmt->fetch(PDO::FETCH_ASSOC);

if(!$career) {
    header('Location: assessment.php');
    exit();
}
?>

<div class="main-content">
    <div class="container">
        <!-- Career Info Card -->
        <div class="card">
            <div style="display: flex; justify-content: space-between; align-items: start; flex-wrap: wrap; gap: 20px;">
                <div>
                    <h2 class="card-title">
                        <i class="fas fa-route"></i> Your Career Roadmap
                    </h2>
                    <h3 style="color: var(--primary-color); margin-bottom: 10px;">
                        <?php echo htmlspecialchars($career['career_name']); ?>
                    </h3>
                    <p style="color: var(--gray); margin-bottom: 20px;">
                        <?php echo htmlspecialchars($career['description']); ?>
                    </p>
                    <div class="badge badge-success">
                        <i class="fas fa-chart-line"></i> <?php echo $career['match_percentage']; ?>% Match
                    </div>
                </div>
                <div>
                    <a href="results.php" class="btn btn-outline">
                        <i class="fas fa-arrow-left"></i> Back to Results
                    </a>
                </div>
            </div>
        </div>

        <!-- Progress Overview -->
        <div class="card">
            <h3 style="margin-bottom: 20px;">
                <i class="fas fa-chart-pie"></i> Overall Progress
            </h3>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 20px;">
                <div class="stat-card">
                    <div class="stat-value" id="totalSteps">0</div>
                    <div class="stat-label">Total Steps</div>
                </div>
                <div class="stat-card">
                    <div class="stat-value" id="completedSteps">0</div>
                    <div class="stat-label">Completed</div>
                </div>
                <div class="stat-card">
                    <div class="stat-value" id="progressPercentage">0%</div>
                    <div class="stat-label">Progress</div>
                </div>
                <div class="stat-card">
                    <div class="stat-value" id="estimatedTime">-</div>
                    <div class="stat-label">Time Remaining</div>
                </div>
            </div>
            <div class="progress-bar" style="height: 12px;">
                <div class="progress-fill" id="overallProgress" style="width: 0%;"></div>
            </div>
        </div>

        <!-- Roadmap Timeline -->
        <div class="card">
            <h3 style="margin-bottom: 30px;">
                <i class="fas fa-map-marked-alt"></i> Your Journey
            </h3>
            <div id="roadmapTimeline" class="roadmap-timeline">
                <!-- Roadmap steps will be loaded here via JavaScript -->
                <div style="text-align: center; padding: 40px;">
                    <div class="spinner" style="margin: 0 auto;"></div>
                    <p style="margin-top: 20px; color: var(--gray);">Loading your roadmap...</p>
                </div>
            </div>
        </div>

        <!-- Tips Card -->
        <div class="card" style="background: linear-gradient(135deg, var(--primary-light) 0%, var(--secondary-light) 100%);">
            <h3 style="margin-bottom: 15px;">
                <i class="fas fa-lightbulb"></i> Pro Tips
            </h3>
            <ul style="list-style: none; padding: 0;">
                <li style="padding: 10px 0; display: flex; align-items: start; gap: 10px;">
                    <i class="fas fa-check-circle" style="color: var(--secondary-color); margin-top: 3px;"></i>
                    <span>Complete steps in order for the best learning experience</span>
                </li>
                <li style="padding: 10px 0; display: flex; align-items: start; gap: 10px;">
                    <i class="fas fa-check-circle" style="color: var(--secondary-color); margin-top: 3px;"></i>
                    <span>Track your progress regularly to stay motivated</span>
                </li>
                <li style="padding: 10px 0; display: flex; align-items: start; gap: 10px;">
                    <i class="fas fa-check-circle" style="color: var(--secondary-color); margin-top: 3px;"></i>
                    <span>Visit the Learning section for resources related to each step</span>
                </li>
                <li style="padding: 10px 0; display: flex; align-items: start; gap: 10px;">
                    <i class="fas fa-check-circle" style="color: var(--secondary-color); margin-top: 3px;"></i>
                    <span>Don't rush - quality learning takes time</span>
                </li>
            </ul>
        </div>
    </div>
</div>

<script>
    // Pass career ID to JavaScript
    const careerID = <?php echo $career['career_id']; ?>;
    const userID = <?php echo $_SESSION['user_id']; ?>;
</script>

<?php include 'includes/footer.php'; ?>
