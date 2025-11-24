<?php
// Set page-specific variables
$page_title = "Help & FAQ - Career Suggestion System";
$page_css = "css/learning.css";
$page_js = "js/learning.js";

// Include shared header
include 'includes/header.php';
include 'includes/navbar.php';

require_once 'config/database.php';

// Fetch FAQ items grouped by category
$stmt = $pdo->query("SELECT * FROM faq ORDER BY category, display_order, faq_id");
$all_faqs = $stmt->fetchAll();

// Group FAQs by category
$faqs = [];
foreach($all_faqs as $faq) {
    $faqs[$faq['category']][] = $faq;
}
?>

<div class="main-content">
    <div class="container">
        
        <!-- Page Header -->
        <div class="card">
            <h1 class="card-title">
                <i class="fas fa-question-circle"></i> Help & Support
            </h1>
            <p style="color: var(--gray); font-size: 16px;">
                Find answers to common questions or contact our support team
            </p>
        </div>

        <!-- Quick Help Links -->
        <div class="card">
            <h3 style="margin-bottom: var(--spacing-lg);">
                <i class="fas fa-bolt"></i> Quick Help
            </h3>
            <div class="quick-help-grid">
                <a href="#getting-started" class="help-card">
                    <i class="fas fa-play-circle"></i>
                    <h4>Getting Started</h4>
                    <p>Learn how to use the system</p>
                </a>
                <a href="#taking-assessment" class="help-card">
                    <i class="fas fa-clipboard-question"></i>
                    <h4>Taking Assessment</h4>
                    <p>How the career test works</p>
                </a>
                <a href="#understanding-results" class="help-card">
                    <i class="fas fa-chart-line"></i>
                    <h4>Understanding Results</h4>
                    <p>Interpret your career matches</p>
                </a>
                <a href="#roadmap" class="help-card">
                    <i class="fas fa-route"></i>
                    <h4>Career Roadmap</h4>
                    <p>Follow your career path</p>
                </a>
            </div>
        </div>

        <!-- Video Tutorials -->
        <div class="card">
            <h2 style="margin-bottom: var(--spacing-md);">
                <i class="fas fa-video"></i> Video Tutorials
            </h2>
            <p style="color: var(--gray); margin-bottom: var(--spacing-xl);">
                Watch our step-by-step guides to get the most out of CareerPath
            </p>

            <div class="tutorial-grid">
                <div class="tutorial-card">
                    <div class="tutorial-thumbnail">
                        <i class="fas fa-play"></i>
                    </div>
                    <div class="tutorial-content">
                        <h4>How to Complete Assessment</h4>
                        <p style="color: var(--gray); margin-bottom: var(--spacing-sm);">
                            Step-by-step guide through the career assessment process
                        </p>
                        <span class="badge badge-primary">
                            <i class="fas fa-clock"></i> 5:30
                        </span>
                    </div>
                </div>

                <div class="tutorial-card">
                    <div class="tutorial-thumbnail">
                        <i class="fas fa-play"></i>
                    </div>
                    <div class="tutorial-content">
                        <h4>Understanding Your Results</h4>
                        <p style="color: var(--gray); margin-bottom: var(--spacing-sm);">
                            Learn how to interpret your career match percentages
                        </p>
                        <span class="badge badge-primary">
                            <i class="fas fa-clock"></i> 8:15
                        </span>
                    </div>
                </div>

                <div class="tutorial-card">
                    <div class="tutorial-thumbnail">
                        <i class="fas fa-play"></i>
                    </div>
                    <div class="tutorial-content">
                        <h4>Using the Roadmap</h4>
                        <p style="color: var(--gray); margin-bottom: var(--spacing-sm);">
                            Navigate your personalized career development path
                        </p>
                        <span class="badge badge-primary">
                            <i class="fas fa-clock"></i> 6:45
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- FAQ Sections -->
        <div class="card">
            <h2 style="margin-bottom: var(--spacing-xl);">
                <i class="fas fa-comments"></i> Frequently Asked Questions
            </h2>
            
            <?php if(empty($faqs)): ?>
                <p style="color: var(--gray); text-align: center; padding: var(--spacing-xl);">
                    No FAQs available at the moment.
                </p>
            <?php else: ?>
                <?php foreach($faqs as $category => $questions): ?>
                <div class="faq-category">
                    <h3 style="color: var(--primary-color); margin-bottom: var(--spacing-lg); display: flex; align-items: center; gap: 12px;">
                        <i class="fas fa-folder-open"></i>
                        <?php echo htmlspecialchars($category); ?>
                    </h3>
                    
                    <?php foreach($questions as $faq): ?>
                    <div class="faq-item">
                        <div class="faq-question">
                            <i class="fas fa-chevron-down"></i>
                            <span><?php echo htmlspecialchars($faq['question']); ?></span>
                        </div>
                        <div class="faq-answer">
                            <p><?php echo nl2br(htmlspecialchars($faq['answer'])); ?></p>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <!-- Contact Form -->
        <div class="card">
            <h2 style="margin-bottom: var(--spacing-md);">
                <i class="fas fa-envelope"></i> Still Need Help?
            </h2>
            <p style="color: var(--gray); margin-bottom: var(--spacing-xl);">
                Send us a message and we'll get back to you within 24 hours
            </p>

            <form id="contactForm">
                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-heading"></i> Subject
                    </label>
                    <input type="text" name="subject" class="form-control" 
                           placeholder="What do you need help with?" required>
                </div>

                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-message"></i> Message
                    </label>
                    <textarea name="message" class="form-control" rows="6" 
                              placeholder="Describe your issue or question in detail..." required></textarea>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-paper-plane"></i> Send Message
                </button>
            </form>

            <!-- Contact Result Message -->
            <div id="contactResult" style="margin-top: var(--spacing-lg);"></div>
        </div>

    </div>
</div>

<?php include 'includes/footer.php'; ?>