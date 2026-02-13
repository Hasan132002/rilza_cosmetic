// Dark/Light Mode Toggle System
(function() {
    'use strict';

    const themeToggleBtn = document.getElementById('theme-toggle');
    const htmlElement = document.documentElement;

    // Check for saved theme preference or default to 'light' mode
    const currentTheme = localStorage.getItem('theme') || 'light';

    // Set the theme on page load
    if (currentTheme === 'dark') {
        htmlElement.classList.add('dark');
        updateIcon(true);
    } else {
        htmlElement.classList.remove('dark');
        updateIcon(false);
    }

    // Theme toggle function
    function toggleTheme() {
        const isDark = htmlElement.classList.toggle('dark');
        localStorage.setItem('theme', isDark ? 'dark' : 'light');
        updateIcon(isDark);
    }

    // Update icon based on theme
    function updateIcon(isDark) {
        if (themeToggleBtn) {
            const icon = themeToggleBtn.querySelector('i');
            if (icon) {
                icon.className = isDark ? 'fas fa-sun' : 'fas fa-moon';
            }
        }
    }

    // Attach event listener
    if (themeToggleBtn) {
        themeToggleBtn.addEventListener('click', toggleTheme);
    }
})();
