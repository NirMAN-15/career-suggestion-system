// ===================================
// ROADMAP PAGE JAVASCRIPT
// ===================================

let roadmapData = [];
let progressData = [];

// Load roadmap when page loads
document.addEventListener('DOMContentLoaded', function() {
    loadRoadmap();
});

// Load roadmap data from API
async function loadRoadmap() {
    try {
        const response = await fetch(`api/get_roadmap.php?career_id=${careerID}&user_id=${userID}`);
        const data = await response.json();
        
        if(data.success) {
            roadmapData = data.steps;
            progressData = data.progress;
            renderRoadmap();
            updateStatistics();
        } else {
            showEmptyState();
        }
    } catch(error) {
        console.error('Error loading roadmap:', error);
        showError('Failed to load roadmap. Please try again.');
    }
}

// Render roadmap timeline
function renderRoadmap() {
    const timeline = document.getElementById('roadmapTimeline');
    
    if(roadmapData.length === 0) {
        showEmptyState();
        return;
    }
    
    let html = '';
    let nextActiveFound = false;
    
    roadmapData.forEach((step, index) => {
        const isCompleted = progressData.some(p => p.step_id == step.step_id && p.completed);
        const isActive = !isCompleted && !nextActiveFound;
        
        if(isActive) nextActiveFound = true;
        
        const statusClass = isCompleted ? 'completed' : (isActive ? 'active' : 'pending');
        const statusLabel = isCompleted ? 'Completed' : (isActive ? 'In Progress' : 'Pending');
        const statusIcon = isCompleted ? 'fa-check-circle' : (isActive ? 'fa-spinner' : 'fa-clock');
        
        html += `
            <div class="timeline-step ${statusClass}" data-step-id="${step.step_id}">
                <div class="step-number">
                    ${isCompleted ? '<i class="fas fa-check"></i>' : step.step_order}
                </div>
                <div class="step-content">
                    <div class="step-header">
                        <h3 class="step-title">${escapeHtml(step.step_title)}</h3>
                        <span class="step-duration">
                            <i class="far fa-clock"></i>
                            ${escapeHtml(step.estimated_duration)}
                        </span>
                    </div>
                    
                    <p class="step-description">${escapeHtml(step.step_description)}</p>
                    
                    <div class="step-actions">
                        <span class="step-status status-${statusClass.toLowerCase()}">
                            <i class="fas ${statusIcon}"></i>
                            ${statusLabel}
                        </span>
                        
                        ${!isCompleted ? `
                            <button class="btn-complete" onclick="markComplete(${step.step_id})">
                                <i class="fas fa-check"></i>
                                Mark as Complete
                            </button>
                        ` : `
                            <button class="btn-undo" onclick="undoComplete(${step.step_id})">
                                <i class="fas fa-undo"></i>
                                Undo
                            </button>
                        `}
                    </div>
                    
                    ${step.resources ? `
                        <div class="step-resources">
                            <h4><i class="fas fa-link"></i> Helpful Resources</h4>
                            ${renderResources(step.resources)}
                        </div>
                    ` : ''}
                </div>
            </div>
        `;
    });
    
    timeline.innerHTML = html;
}

// Render resources links
function renderResources(resources) {
    // Assuming resources is a JSON string or array
    try {
        const resourceList = typeof resources === 'string' ? JSON.parse(resources) : resources;
        return resourceList.map(resource => 
            `<a href="${escapeHtml(resource.url)}" target="_blank" class="resource-link">
                <i class="fas fa-external-link-alt"></i>
                ${escapeHtml(resource.title)}
            </a>`
        ).join('');
    } catch(e) {
        return '';
    }
}

// Update statistics
function updateStatistics() {
    const totalSteps = roadmapData.length;
    const completedSteps = progressData.filter(p => p.completed).length;
    const progressPercentage = totalSteps > 0 ? Math.round((completedSteps / totalSteps) * 100) : 0;
    
    // Calculate estimated time remaining
    const remainingSteps = roadmapData.filter(step => 
        !progressData.some(p => p.step_id == step.step_id && p.completed)
    );
    
    let totalMonths = 0;
    remainingSteps.forEach(step => {
        const duration = step.estimated_duration.toLowerCase();
        if(duration.includes('month')) {
            const months = parseInt(duration.match(/\d+/));
            totalMonths += months || 1;
        } else if(duration.includes('week')) {
            const weeks = parseInt(duration.match(/\d+/));
            totalMonths += (weeks || 1) * 0.25;
        }
    });
    
    const estimatedTime = totalMonths > 0 ? 
        `${Math.round(totalMonths)} month${Math.round(totalMonths) !== 1 ? 's' : ''}` : 
        'Complete!';
    
    // Update DOM
    document.getElementById('totalSteps').textContent = totalSteps;
    document.getElementById('completedSteps').textContent = completedSteps;
    document.getElementById('progressPercentage').textContent = progressPercentage + '%';
    document.getElementById('estimatedTime').textContent = estimatedTime;
    document.getElementById('overallProgress').style.width = progressPercentage + '%';
}

// Mark step as complete
async function markComplete(stepId) {
    if(!confirm('Mark this step as complete?')) return;
    
    showLoader();
    
    try {
        const formData = new FormData();
        formData.append('user_id', userID);
        formData.append('step_id', stepId);
        formData.append('completed', true);
        
        const response = await fetch('api/update_progress.php', {
            method: 'POST',
            body: formData
        });
        
        const data = await response.json();
        
        hideLoader();
        
        if(data.success) {
            showSuccess('Step marked as complete! Keep up the great work! 🎉');
            loadRoadmap(); // Reload to update UI
        } else {
            showError(data.message || 'Failed to update progress');
        }
    } catch(error) {
        hideLoader();
        console.error('Error marking complete:', error);
        showError('Failed to update progress. Please try again.');
    }
}

// Undo completion
async function undoComplete(stepId) {
    if(!confirm('Mark this step as incomplete?')) return;
    
    showLoader();
    
    try {
        const formData = new FormData();
        formData.append('user_id', userID);
        formData.append('step_id', stepId);
        formData.append('completed', false);
        
        const response = await fetch('api/update_progress.php', {
            method: 'POST',
            body: formData
        });
        
        const data = await response.json();
        
        hideLoader();
        
        if(data.success) {
            showSuccess('Step marked as incomplete');
            loadRoadmap(); // Reload to update UI
        } else {
            showError(data.message || 'Failed to update progress');
        }
    } catch(error) {
        hideLoader();
        console.error('Error undoing completion:', error);
        showError('Failed to update progress. Please try again.');
    }
}

// Show empty state
function showEmptyState() {
    const timeline = document.getElementById('roadmapTimeline');
    timeline.innerHTML = `
        <div class="empty-state">
            <i class="fas fa-route"></i>
            <h3>No Roadmap Available</h3>
            <p>We're working on creating a roadmap for your selected career.</p>
            <a href="results.php" class="btn btn-primary">
                <i class="fas fa-arrow-left"></i> Back to Results
            </a>
        </div>
    `;
}

// Show success message
function showSuccess(message) {
    const alert = document.createElement('div');
    alert.className = 'alert alert-success';
    alert.innerHTML = `
        <i class="fas fa-check-circle"></i>
        <span>${message}</span>
    `;
    alert.style.cssText = 'position: fixed; top: 20px; right: 20px; z-index: 9999; max-width: 400px;';
    document.body.appendChild(alert);
    
    setTimeout(() => {
        alert.style.opacity = '0';
        setTimeout(() => alert.remove(), 300);
    }, 3000);
}

// Show error message
function showError(message) {
    const alert = document.createElement('div');
    alert.className = 'alert alert-error';
    alert.innerHTML = `
        <i class="fas fa-exclamation-circle"></i>
        <span>${message}</span>
    `;
    alert.style.cssText = 'position: fixed; top: 20px; right: 20px; z-index: 9999; max-width: 400px;';
    document.body.appendChild(alert);
    
    setTimeout(() => {
        alert.style.opacity = '0';
        setTimeout(() => alert.remove(), 300);
    }, 4000);
}

// Escape HTML to prevent XSS
function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

// Print roadmap
function printRoadmap() {
    window.print();
}

// Export roadmap as PDF (requires additional library)
function exportPDF() {
    showError('PDF export feature coming soon!');
}
