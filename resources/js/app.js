import './bootstrap';

import Alpine from 'alpinejs';

// Hacer Alpine disponible globalmente ANTES de importar toast-system
window.Alpine = Alpine;

// Importar toast-system para registrar componentes de Alpine
import './toast-system';

// Iniciar Alpine después de registrar todos los componentes
Alpine.start();

// Theme toggle functionality
document.addEventListener('DOMContentLoaded', function() {
    const themeToggle = document.getElementById('theme-toggle');
    const themeToggleMobile = document.getElementById('theme-toggle-mobile');
    const themeToggleDarkIcon = document.getElementById('theme-toggle-dark-icon');
    const themeToggleLightIcon = document.getElementById('theme-toggle-light-icon');
    const themeToggleDarkIconMobile = document.getElementById('theme-toggle-dark-icon-mobile');
    const themeToggleLightIconMobile = document.getElementById('theme-toggle-light-icon-mobile');

    // Check for saved theme preference or default to 'light'
    const currentTheme = localStorage.getItem('theme') || 'light';
    
    // Apply the current theme
    if (currentTheme === 'dark') {
        document.documentElement.classList.add('dark');
        themeToggleDarkIcon.classList.remove('hidden');
        themeToggleLightIcon.classList.add('hidden');
        themeToggleDarkIconMobile.classList.remove('hidden');
        themeToggleLightIconMobile.classList.add('hidden');
    } else {
        document.documentElement.classList.remove('dark');
        themeToggleDarkIcon.classList.add('hidden');
        themeToggleLightIcon.classList.remove('hidden');
        themeToggleDarkIconMobile.classList.add('hidden');
        themeToggleLightIconMobile.classList.remove('hidden');
    }

    // Desktop theme toggle
    if (themeToggle) {
        themeToggle.addEventListener('click', function() {
            toggleTheme();
        });
    }

    // Mobile theme toggle
    if (themeToggleMobile) {
        themeToggleMobile.addEventListener('click', function() {
            toggleTheme();
        });
    }

    function toggleTheme() {
        const isDark = document.documentElement.classList.contains('dark');
        
        if (isDark) {
            // Switch to light mode
            document.documentElement.classList.remove('dark');
            localStorage.setItem('theme', 'light');
            themeToggleDarkIcon.classList.add('hidden');
            themeToggleLightIcon.classList.remove('hidden');
            themeToggleDarkIconMobile.classList.add('hidden');
            themeToggleLightIconMobile.classList.remove('hidden');
        } else {
            // Switch to dark mode
            document.documentElement.classList.add('dark');
            localStorage.setItem('theme', 'dark');
            themeToggleDarkIcon.classList.remove('hidden');
            themeToggleLightIcon.classList.add('hidden');
            themeToggleDarkIconMobile.classList.remove('hidden');
            themeToggleLightIconMobile.classList.add('hidden');
        }
    }
});
