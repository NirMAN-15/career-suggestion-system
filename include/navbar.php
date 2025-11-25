<nav class="navbar">
    <div class="container navbar-container">
        <a href="index.php" class="navbar-brand">
            <i class="fas fa-compass"></i> CareerPath
        </a>
        
        <?php if(isset($_SESSION['user_id'])): ?>
        <ul class="navbar-menu">
            <li><a href="index.php" class="navbar-link <?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : ''; ?>">
                <i class="fas fa-home"></i> Home
            </a></li>
            <li><a href="assessment.php" class="navbar-link <?php echo basename($_SERVER['PHP_SELF']) == 'assessment.php' ? 'active' : ''; ?>">
                <i class="fas fa-clipboard-question"></i> Assessment
            </a></li>
            <li><a href="results.php" class="navbar-link <?php echo basename($_SERVER['PHP_SELF']) == 'results.php' ? 'active' : ''; ?>">
                <i class="fas fa-chart-line"></i> Results
            </a></li>
            <li><a href="roadmap.php" class="navbar-link <?php echo basename($_SERVER['PHP_SELF']) == 'roadmap.php' ? 'active' : ''; ?>">
                <i class="fas fa-route"></i> Roadmap
            </a></li>
            <li><a href="learning.php" class="navbar-link <?php echo basename($_SERVER['PHP_SELF']) == 'learning.php' ? 'active' : ''; ?>">
                <i class="fas fa-book"></i> Learning
            </a></li>
            <li><a href="profile.php" class="navbar-link <?php echo basename($_SERVER['PHP_SELF']) == 'profile.php' ? 'active' : ''; ?>">
                <i class="fas fa-user"></i> Profile
            </a></li>
            <li><a href="help.php" class="navbar-link <?php echo basename($_SERVER['PHP_SELF']) == 'help.php' ? 'active' : ''; ?>">
                <i class="fas fa-question-circle"></i> Help
            </a></li>
            <li><a href="logout.php" class="navbar-link">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a></li>
        </ul>
        <?php else: ?>
        <ul class="navbar-menu">
            <li><a href="login.php" class="navbar-link">
                <i class="fas fa-sign-in-alt"></i> Login
            </a></li>
            <li><a href="register.php" class="btn btn-primary">
                Get Started
            </a></li>
        </ul>
        <?php endif; ?>
    </div>
</nav>