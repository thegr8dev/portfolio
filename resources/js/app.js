import './bootstrap';

// Portfolio App JavaScript
document.addEventListener('DOMContentLoaded', function() {
    // Theme Toggle Functionality
    const themeToggle = document.getElementById('theme-toggle');
    const sunIcon = document.getElementById('sun-icon');
    const moonIcon = document.getElementById('moon-icon');

    // Check for saved theme preference or default to system preference
    let isDarkMode = localStorage.getItem('theme') === 'dark' ||
        (!localStorage.getItem('theme') && window.matchMedia('(prefers-color-scheme: dark)').matches);

    function updateTheme() {
        if (isDarkMode) {
            document.documentElement.classList.add('dark');
            if (sunIcon && moonIcon && themeToggle) {
                sunIcon.classList.remove('hidden');
                moonIcon.classList.add('hidden');
                themeToggle.setAttribute('aria-label', 'Switch to light mode');
            }
        } else {
            document.documentElement.classList.remove('dark');
            if (sunIcon && moonIcon && themeToggle) {
                sunIcon.classList.add('hidden');
                moonIcon.classList.remove('hidden');
                themeToggle.setAttribute('aria-label', 'Switch to dark mode');
            }
        }
    }

    // Set initial theme
    updateTheme();

    // Theme toggle event listener
    if (themeToggle) {
        themeToggle.addEventListener('click', function(e) {
            e.preventDefault();
            isDarkMode = !isDarkMode;
            updateTheme();
            localStorage.setItem('theme', isDarkMode ? 'dark' : 'light');
        });
    }

    // Typing Animation for Hero Section
    const typingTextElement = document.getElementById('typing-text');
    
    if (typingTextElement) {
        const fullText = "Hi, I'm <span class='whitespace-nowrap bg-clip-text text-transparent bg-gradient-to-r from-blue-600 to-indigo-600 dark:from-blue-400 dark:to-indigo-400'>Ankit Kabra</span>";
        let charIndex = 0;
        let htmlText = '';
        let currentText = '';
        let isInTag = false;
        let isInClass = false;
        let tagBuffer = '';
        const typingSpeed = 60; // milliseconds per character
        
        function typeWriter() {
            if (charIndex < fullText.length) {
                const char = fullText[charIndex];
                
                if (char === '<') {
                    isInTag = true;
                    tagBuffer = char;
                } else if (char === '>' && isInTag) {
                    isInTag = false;
                    tagBuffer += char;
                    htmlText += tagBuffer;
                    tagBuffer = '';
                } else if (isInTag) {
                    tagBuffer += char;
                    if (char === "'" && tagBuffer.includes('class=')) {
                        isInClass = !isInClass;
                    }
                } else {
                    htmlText += char;
                    currentText += char;
                    typingTextElement.innerHTML = htmlText;
                }
                
                charIndex++;
                const nextDelay = isInTag || isInClass ? 0 : typingSpeed;
                setTimeout(typeWriter, nextDelay);
            }
        }
        
        // Start typing animation after a short delay
        setTimeout(typeWriter, 500);
    }

    // Listen for system theme changes
    window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', function(e) {
        if (!localStorage.getItem('theme')) {
            isDarkMode = e.matches;
            updateTheme();
        }
    });

    // Mobile Menu Functionality
    const mobileMenuButton = document.getElementById('mobile-menu-button');
    const mobileMenu = document.getElementById('mobile-menu');
    const hamburgerIcon = document.getElementById('hamburger-icon');
    const closeIcon = document.getElementById('close-icon');
    let isMenuOpen = false;

    // Mobile menu toggle event listener
    if (mobileMenuButton) {
        mobileMenuButton.addEventListener('click', function() {
            isMenuOpen = !isMenuOpen;
            toggleMobileMenu();
        });
    }

    function toggleMobileMenu() {
        if (isMenuOpen) {
            // Show menu
            mobileMenu.style.maxHeight = mobileMenu.scrollHeight + 'px';
            mobileMenu.classList.remove('opacity-0', 'pointer-events-none');
            mobileMenu.classList.add('opacity-100', 'pointer-events-auto');
            hamburgerIcon.classList.add('hidden');
            closeIcon.classList.remove('hidden');
            mobileMenuButton.setAttribute('aria-expanded', 'true');
        } else {
            // Hide menu
            mobileMenu.style.maxHeight = '0px';
            mobileMenu.classList.remove('opacity-100', 'pointer-events-auto');
            mobileMenu.classList.add('opacity-0', 'pointer-events-none');
            
            hamburgerIcon.classList.remove('hidden');
            closeIcon.classList.add('hidden');
            mobileMenuButton.setAttribute('aria-expanded', 'false');
        }
    }

    // Close mobile menu when clicking outside
    document.addEventListener('click', function(event) {
        if (isMenuOpen && mobileMenuButton && mobileMenu && 
            !mobileMenuButton.contains(event.target) && !mobileMenu.contains(event.target)) {
            isMenuOpen = false;
            toggleMobileMenu();
        }
    });

    // Back to Top Button Functionality
    const backToTopButton = document.getElementById('back-to-top');

    // Show/hide back to top button on scroll
    window.addEventListener('scroll', function() {
        if (backToTopButton) {
            if (window.pageYOffset > 300) {
                backToTopButton.classList.remove('hidden');
            } else {
                backToTopButton.classList.add('hidden');
            }
        }
    });

    // Back to top click event
    if (backToTopButton) {
        backToTopButton.addEventListener('click', function() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    }

    // Smooth scrolling for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            const targetId = this.getAttribute('href').substring(1);
            const targetSection = document.getElementById(targetId);

            if (targetSection) {
                // Close mobile menu if open
                if (isMenuOpen) {
                    isMenuOpen = false;
                    toggleMobileMenu();
                }

                // Smooth scroll to target with offset for fixed header
                const headerOffset = 80; // Adjust based on your header height
                const elementPosition = targetSection.getBoundingClientRect().top;
                const offsetPosition = elementPosition + window.pageYOffset - headerOffset;

                window.scrollTo({
                    top: offsetPosition,
                    behavior: 'smooth'
                });
            }
        });
    });
});
