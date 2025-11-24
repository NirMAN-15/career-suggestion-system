<?php
// Set page-specific variables
$page_title = "Learning Materials - Career Suggestion System";
$page_css = "css/learning.css";
$page_js = "js/learning.js";

// Include shared header
include 'includes/header.php';
include 'includes/navbar.php';

// Check if user is logged in
require_once 'auth/session_check.php';
require_once 'config/database.php';

// Get user's top suggested career
$stmt = $pdo->prepare("
    SELECT c.career_id, c.career_name 
    FROM user_career_matches ucm
    JOIN careers c ON ucm.career_id = c.career_id
    WHERE ucm.user_id = ?
    ORDER BY ucm.match_percentage DESC
    LIMIT 1
");
$stmt->execute([$_SESSION['user_id']]);
$career = $stmt->fetch();
?>

<div class="main-content">
    <div class="container">
        
        <!-- Page Header -->
        <div class="card">
            <h1 class="card-title">
                <i class="fas fa-book"></i> Learning Materials
            </h1>
            <p style="color: var(--gray); font-size: 16px;">
                Explore curated resources to help you achieve your career goals
                <?php if($career): ?>
                    in <strong style="color: var(--primary-color);"><?php echo htmlspecialchars($career['career_name']); ?></strong>
                <?php endif; ?>
            </p>
        </div>

        <!-- Search & Filter Section -->
        <div class="card">
            <h3 style="margin-bottom: var(--spacing-lg);">
                <i class="fas fa-filter"></i> Filter Resources
            </h3>
            
            <div style="display: grid; grid-template-columns: 2fr 1fr 1fr; gap: var(--spacing-md); margin-bottom: 0;">
                <!-- Search Input -->
                <div class="form-group" style="margin-bottom: 0;">
                    <label class="form-label">
                        <i class="fas fa-search"></i> Search
                    </label>
                    <input type="text" id="searchInput" class="form-control" 
                           placeholder="Search by title or description...">
                </div>
                
                <!-- Type Filter -->
                <div class="form-group" style="margin-bottom: 0;">
                    <label class="form-label">
                        <i class="fas fa-layer-group"></i> Type
                    </label>
                    <select id="typeFilter" class="form-control">
                        <option value="">All Types</option>
                        <option value="video">📹 Videos</option>
                        <option value="article">📰 Articles</option>
                        <option value="course">🎓 Courses</option>
                        <option value="book">📚 Books</option>
                    </select>
                </div>
                
                <!-- Level Filter -->
                <div class="form-group" style="margin-bottom: 0;">
                    <label class="form-label">
                        <i class="fas fa-signal"></i> Level
                    </label>
                    <select id="levelFilter" class="form-control">
                        <option value="">All Levels</option>
                        <option value="beginner">🌱 Beginner</option>
                        <option value="intermediate">🌿 Intermediate</option>
                        <option value="advanced">🌳 Advanced</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Materials Container -->
        <div id="materialsContainer">
            <div style="text-align: center; padding: 80px 20px;">
                <div class="spinner" style="margin: 0 auto;"></div>
                <p style="margin-top: var(--spacing-lg); color: var(--gray); font-size: 16px;">
                    Loading resources...
                </p>
            </div>
        </div>

        <!-- No Results Message -->
        <div id="noResults" style="display: none;">
            <div class="card" style="text-align: center; padding: 80px 20px;">
                <i class="fas fa-search" style="font-size: 64px; color: var(--gray); margin-bottom: var(--spacing-lg); opacity: 0.5;"></i>
                <h3 style="color: var(--dark); margin-bottom: var(--spacing-sm);">No resources found</h3>
                <p style="color: var(--gray); font-size: 16px;">
                    Try adjusting your filters or search terms
                </p>
                <button onclick="resetFilters()" class="btn btn-primary" style="margin-top: var(--spacing-lg);">
                    <i class="fas fa-redo"></i> Reset Filters
                </button>
            </div>
        </div>

    </div>
</div>

<?php include 'includes/footer.php'; ?>