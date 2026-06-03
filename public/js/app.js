// Global utility functions
window.showNotification = function(message = 'This is a demo notification.') {
    const existingNotif = document.querySelector('.notification');
    if (existingNotif) existingNotif.remove();
    
    const notification = document.createElement('div');
    notification.className = 'notification alert alert-success alert-dismissible fade show';
    notification.innerHTML = `
        <i class="fas fa-check-circle me-2"></i>
        <strong>Success!</strong> ${message}
        <button type="button" class="btn-close" onclick="this.parentElement.remove()"></button>
    `;
    document.body.appendChild(notification);
    
    setTimeout(() => {
        if (notification.parentElement) notification.remove();
    }, 3000);
};

// Initialize all tooltips
document.addEventListener('DOMContentLoaded', function() {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});