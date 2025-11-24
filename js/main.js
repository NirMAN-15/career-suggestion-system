// Global JavaScript Functions
document.addEventListener('DOMContentLoaded', function() {
    // Auto-hide alerts after 5 seconds
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.opacity = '0';
            setTimeout(() => alert.remove(), 300);
        }, 5000);
    });
    
    // Form validation helper
    window.validateForm = function(formId) {
        const form = document.getElementById(formId);
        const inputs = form.querySelectorAll('.form-control');
        let isValid = true;
        
        inputs.forEach(input => {
            if(input.hasAttribute('required') && !input.value.trim()) {
                input.style.borderColor = 'var(--error)';
                isValid = false;
            } else {
                input.style.borderColor = '#e5e7eb';
            }
        });
        
        return isValid;
    };
    
    // Show loading spinner
    window.showLoader = function() {
        const loader = document.createElement('div');
        loader.id = 'global-loader';
        loader.innerHTML = '<div class="spinner"></div>';
        loader.style.cssText = 'position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.5);display:flex;justify-content:center;align-items:center;z-index:9999;';
        document.body.appendChild(loader);
    };
    
    // Hide loading spinner
    window.hideLoader = function() {
        const loader = document.getElementById('global-loader');
        if(loader) loader.remove();
    };
    
    // Format date helper
    window.formatDate = function(dateString) {
        const options = { year: 'numeric', month: 'long', day: 'numeric' };
        return new Date(dateString).toLocaleDateString('en-US', options);
    };
    
    // Smooth scroll to element
    window.scrollToElement = function(elementId) {
        const element = document.getElementById(elementId);
        if(element) {
            element.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    };
});