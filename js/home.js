// Home Page JavaScript
document.addEventListener('DOMContentLoaded', function() {
    
    // Animate stats on page load
    animateStats();
    
    // Add hover effects to action buttons
    initializeActionButtons();
    
    // Check for URL parameters (e.g., success messages)
    checkUrlParameters();
});

// Animate stats counting up
function animateStats() {
    const statCards = document.querySelectorAll('.stat-card h3');
    
    statCards.forEach(stat => {
        const text = stat.textContent.trim();
        
        // Check if the stat contains a number
        const match = text.match(/(\d+)/);
        if(match) {
            const targetNumber = parseInt(match[1]);
            animateNumber(stat, 0, targetNumber, 1000);
        }
    });
}

// Animate number counting
function animateNumber(element, start, end, duration) {
    const originalText = element.textContent;
    const range = end - start;
    const increment = range / (duration / 16);
    let current = start;
    
    const timer = setInterval(() => {
        current += increment;
        if(current >= end) {
            current = end;
            clearInterval(timer);
        }
        
        // Replace only the number in the original text
        const newText = originalText.replace(/\d+/, Math.round(current));
        element.textContent = newText;
    }, 16);
}

// Initialize action button interactions
function initializeActionButtons() {
    const actionButtons = document.querySelectorAll('.action-btn');
    
    actionButtons.forEach(btn => {
        btn.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-4px) scale(1.02)';
        });
        
        btn.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
        });
    });
}

// Check URL parameters for messages
function checkUrlParameters() {
    const urlParams = new URLSearchParams(window.location.search);
    
    if(urlParams.has('assessment_complete')) {
        showNotification('Assessment completed successfully!', 'success');
        
        // Remove the parameter from URL
        window.history.replaceState({}, document.title, window.location.pathname);
    }
    
    if(urlParams.has('profile_updated')) {
        showNotification('Profile updated successfully!', 'success');
        window.history.replaceState({}, document.title, window.location.pathname);
    }
}

// Show notification
function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `alert alert-${type}`;
    notification.innerHTML = `
        <i class="fas fa-${type === 'success' ? 'check-circle' : 'info-circle'}" style="margin-right: 12px;"></i>
        <span>${message}</span>
    `;
    
    const container = document.querySelector('.container');
    container.insertBefore(notification, container.firstChild);
    
    // Auto-remove after 5 seconds
    setTimeout(() => {
        notification.style.opacity = '0';
        setTimeout(() => notification.remove(), 300);
    }, 5000);
}

// Fetch user stats via API (optional enhancement)
async function fetchUserStats() {
    try {
        const response = await fetch('api/get_user_stats.php');
        const data = await response.json();
        
        if(data.success) {
            updateDashboardStats(data.stats);
        }
    } catch(error) {
        console.error('Error fetching user stats:', error);
    }
}

// Update dashboard with fetched stats
function updateDashboardStats(stats) {
    // Update assessment status
    const assessmentStat = document.querySelector('.stat-card:nth-child(1) h3');
    if(assessmentStat) {
        assessmentStat.textContent = stats.assessment_completed ? 'Completed' : 'Not Started';
    }
    
    // Update career matches
    const careerStat = document.querySelector('.stat-card:nth-child(2) h3');
    if(careerStat) {
        careerStat.textContent = stats.career_matches || '0';
    }
    
    // Update progress
    const progressStat = document.querySelector('.stat-card:nth-child(3) h3');
    if(progressStat) {
        progressStat.textContent = stats.roadmap_progress + '%';
    }
}