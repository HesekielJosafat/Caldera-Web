<div class="dark-mode-toggle" onclick="toggleDarkMode()" id="darkModeToggle">
    <i class="fas fa-moon"></i>
</div>

<script>
// Dark mode toggle function
function toggleDarkMode() {
    document.body.classList.toggle('dark-mode');
    const isDarkMode = document.body.classList.contains('dark-mode');
    localStorage.setItem('darkMode', isDarkMode);
    
    // Update icon
    const toggleIcon = document.querySelector('#darkModeToggle i');
    if (toggleIcon) {
        if (isDarkMode) {
            toggleIcon.className = 'fas fa-sun';
        } else {
            toggleIcon.className = 'fas fa-moon';
        }
    }
}

// Load dark mode preference on page load
document.addEventListener('DOMContentLoaded', function() {
    const savedDarkMode = localStorage.getItem('darkMode');
    if (savedDarkMode === 'true') {
        document.body.classList.add('dark-mode');
        const toggleIcon = document.querySelector('#darkModeToggle i');
        if (toggleIcon) {
            toggleIcon.className = 'fas fa-sun';
        }
    }
});
</script><?php /**PATH D:\PA_03\PA2\resources\views/components/dark-mode-toggle.blade.php ENDPATH**/ ?>