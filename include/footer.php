</div> <!-- Close page-wrapper -->
    
    <footer class="footer">
        <div class="container">
            <p>&copy; <?php echo date('Y'); ?> Career Suggestion System. All rights reserved.</p>
            <p>Built with ❤️ by Team CareerPath</p>
        </div>
    </footer>
    
    <!-- Global JavaScript -->
    <script src="js/main.js"></script>
    
    <!-- Page Specific JavaScript -->
    <?php if(isset($page_js)): ?>
        <script src="<?php echo $page_js; ?>"></script>
    <?php endif; ?>
</body>
</html>