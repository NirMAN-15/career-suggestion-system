// Results Page JavaScript

document.addEventListener('DOMContentLoaded', function() {
    loadCareerResults();
});

async function loadCareerResults() {
    const loadingState = document.getElementById('loadingState');
    const resultsContainer = document.getElementById('resultsContainer');
    const errorState = document.getElementById('errorState');
    const careerCards = document.getElementById('careerCards');

    try {
        // Call the calculate_career API
        const response = await fetch('api/calculate_career.php');
        const data = await response.json();

        if (!data.success) {
            throw new Error(data.message || 'Failed to calculate careers');
        }

        // Hide loading, show results
        loadingState.style.display = 'none';
        resultsContainer.style.display = 'block';

        // Display career cards
        if (data.careers && data.careers.length > 0) {
            careerCards.innerHTML = data.careers.map((career, index) => 
                createCareerCard(career, index + 1)
            ).join('');

            // Animate progress circles
            setTimeout(() => {
                data.careers.forEach((career, index) => {
                    animateProgressCircle(index, career.match_percentage);
                });
            }, 100);
        } else {
            careerCards.innerHTML = `
                <div class="card" style="text-align: center; padding: 60px;">
                    <i class="fas fa-info-circle" style="font-size: 48px; color: var(--info);"></i>
                    <h3 style="margin-top: 20px;">No career matches found</h3>
                    <p style="color: var(--gray);">Please retake the assessment to get career recommendations.</p>
                </div>
            `;
        }

    } catch (error) {
        console.error('Error loading career results:', error);
        loadingState.style.display = 'none';
        errorState.style.display = 'block';
    }
}

function createCareerCard(career, rank) {
    const matchLevel = getMatchLevel(career.match_percentage);
    const skills = career.skills_required ? career.skills_required.split(',').map(s => s.trim()) : [];

    return `
        <div class="career-card">
            <div class="rank-badge rank-${rank}">#${rank}</div>
            
            <div class="match-badge ${matchLevel.class}">
                <i class="fas fa-check-circle"></i>
                ${matchLevel.text}
            </div>

            <div class="career-header">
                <div>
                    <h2 class="career-title">${career.career_name}</h2>
                    <span class="career-category">
                        <i class="fas fa-tag"></i> ${career.category || 'IT'}
                    </span>
                </div>

                <div class="match-circle">
                    <svg width="100" height="100">
                        <circle class="circle-background" cx="50" cy="50" r="42"></circle>
                        <circle 
                            class="circle-progress" 
                            id="progress-${rank}" 
                            cx="50" 
                            cy="50" 
                            r="42"
                            stroke-dasharray="264"
                            stroke-dashoffset="264"
                        ></circle>
                    </svg>
                    <div class="circle-text">${Math.round(career.match_percentage)}%</div>
                </div>
            </div>

            <p class="career-description">${career.description || 'No description available.'}</p>

            <div class="career-details">
                <div class="detail-item">
                    <span class="detail-label">Average Salary</span>
                    <span class="detail-value">
                        <i class="fas fa-dollar-sign"></i>
                        ${career.avg_salary || 'Varies'}
                    </span>
                </div>

                <div class="detail-item">
                    <span class="detail-label">Job Growth</span>
                    <span class="detail-value">
                        <i class="fas fa-chart-line"></i>
                        ${career.job_growth || 'N/A'}
                    </span>
                </div>

                <div class="detail-item">
                    <span class="detail-label">Education Required</span>
                    <span class="detail-value">
                        <i class="fas fa-graduation-cap"></i>
                        ${career.required_education || 'Varies'}
                    </span>
                </div>
            </div>

            ${skills.length > 0 ? `
                <div class="skills-section">
                    <h3 class="skills-title">
                        <i class="fas fa-tools"></i> Required Skills
                    </h3>
                    <div class="skills-list">
                        ${skills.map(skill => `<span class="skill-tag">${skill}</span>`).join('')}
                    </div>
                </div>
            ` : ''}

            <div class="career-actions">
                <a href="roadmap.php?career_id=${career.career_id}" class="btn btn-primary btn-view-roadmap">
                    <i class="fas fa-route"></i> View Career Roadmap
                </a>
                <a href="learning.php?career_id=${career.career_id}" class="btn btn-secondary btn-learn-more">
                    <i class="fas fa-book"></i> Learning Materials
                </a>
            </div>
        </div>
    `;
}

function getMatchLevel(percentage) {
    if (percentage >= 80) {
        return { class: 'excellent', text: 'Excellent Match' };
    } else if (percentage >= 60) {
        return { class: 'good', text: 'Good Match' };
    } else {
        return { class: 'fair', text: 'Fair Match' };
    }
}

function animateProgressCircle(index, percentage) {
    const circle = document.getElementById(`progress-${index + 1}`);
    if (!circle) return;

    const circumference = 264; // 2 * π * 42
    const offset = circumference - (percentage / 100) * circumference;

    circle.style.strokeDashoffset = offset;
}

// Export function for external use (optional)
window.refreshCareerResults = loadCareerResults;