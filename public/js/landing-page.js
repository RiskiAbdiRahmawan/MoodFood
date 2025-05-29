// Landing Page JavaScript Functions

document.addEventListener('DOMContentLoaded', function() {
    // Initialize AOS (Animate On Scroll)
    initializeAOS();
    
    // Initialize interactive effects
    initializeCardHoverEffects();
    
    // Initialize smooth scrolling
    initializeSmoothScrolling();
    
    // Initialize form validation
    initializeFormValidation();
    
    // Initialize loading animations
    initializeLoadingAnimations();
    
    // Initialize parallax effects
    initializeParallaxEffects();
    
    // Initialize performance optimizations
    initializePerformanceOptimizations();
});

/**
 * Initialize AOS (Animate On Scroll) library
 */
function initializeAOS() {
    if (typeof AOS !== 'undefined') {
        AOS.init({
            duration: 800,
            easing: 'ease-in-out',
            once: true,
            offset: 100,
            delay: 100,
            disable: function() {
                // Disable on mobile for better performance
                return window.innerWidth < 768;
            }
        });
    }
}

/**
 * Add interactive hover effects to cards
 */
function initializeCardHoverEffects() {
    const cards = document.querySelectorAll('.card-hover');
    
    cards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-8px) scale(1.02)';
            this.style.transition = 'all 0.3s cubic-bezier(0.4, 0, 0.2, 1)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
        });
        
        // Add touch support for mobile
        card.addEventListener('touchstart', function() {
            this.classList.add('touched');
        });
        
        card.addEventListener('touchend', function() {
            setTimeout(() => {
                this.classList.remove('touched');
            }, 150);
        });
    });
}

/**
 * Initialize smooth scrolling for navigation links
 */
function initializeSmoothScrolling() {
    const navLinks = document.querySelectorAll('a[href^="#"]');
    
    navLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            
            const targetId = this.getAttribute('href');
            const targetSection = document.querySelector(targetId);
            
            if (targetSection) {
                const offsetTop = targetSection.offsetTop - 80; // Account for fixed header
                
                window.scrollTo({
                    top: offsetTop,
                    behavior: 'smooth'
                });
                
                // Update URL without jumping
                history.pushState(null, null, targetId);
            }
        });
    });
}

/**
 * Initialize form validation with enhanced UX
 */
function initializeFormValidation() {
    const form = document.querySelector('#feedback form');
    
    if (form) {
        const inputs = form.querySelectorAll('input, textarea');
        
        // Real-time validation
        inputs.forEach(input => {
            input.addEventListener('blur', function() {
                validateField(this);
            });
            
            input.addEventListener('input', function() {
                if (this.classList.contains('error')) {
                    validateField(this);
                }
            });
        });
        
        // Form submission
        form.addEventListener('submit', function(e) {
            const requiredInputs = this.querySelectorAll('input[required], textarea[required]');
            let isValid = true;
            
            requiredInputs.forEach(input => {
                if (!validateField(input)) {
                    isValid = false;
                }
            });
            
            if (!isValid) {
                e.preventDefault();
                showNotification('Mohon lengkapi semua field yang diperlukan.', 'error');
                
                // Focus on first invalid field
                const firstInvalid = this.querySelector('.error');
                if (firstInvalid) {
                    firstInvalid.focus();
                }
            } else {
                // Show loading state
                const submitBtn = this.querySelector('button[type="submit"]');
                if (submitBtn) {
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = '<span>Mengirim...</span>';
                }
            }
        });
    }
}

/**
 * Validate individual form field
 */
function validateField(field) {
    const value = field.value.trim();
    const isRequired = field.hasAttribute('required');
    const fieldType = field.type;
    
    // Remove previous error states
    field.classList.remove('error', 'border-red-400', 'ring-red-100');
    field.classList.add('border-gray-200');
    
    let isValid = true;
    
    // Required field validation
    if (isRequired && !value) {
        isValid = false;
    }
    
    // Email validation
    if (fieldType === 'email' && value) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(value)) {
            isValid = false;
        }
    }
    
    // Apply error styles if invalid
    if (!isValid) {
        field.classList.add('error', 'border-red-400', 'ring-red-100');
        field.classList.remove('border-gray-200');
    }
    
    return isValid;
}

/**
 * Show notification message
 */
function showNotification(message, type = 'info') {
    // Create notification element
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 z-50 p-4 rounded-lg shadow-lg transform transition-all duration-300 translate-x-full`;
    
    // Set type-specific styles
    switch (type) {
        case 'error':
            notification.classList.add('bg-red-500', 'text-white');
            break;
        case 'success':
            notification.classList.add('bg-green-500', 'text-white');
            break;
        default:
            notification.classList.add('bg-blue-500', 'text-white');
    }
    
    notification.innerHTML = `
        <div class="flex items-center">
            <span>${message}</span>
            <button class="ml-4 text-white hover:text-gray-200" onclick="this.parentElement.parentElement.remove()">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                </svg>
            </button>
        </div>
    `;
    
    document.body.appendChild(notification);
    
    // Animate in
    setTimeout(() => {
        notification.classList.remove('translate-x-full');
    }, 100);
    
    // Auto remove after 5 seconds
    setTimeout(() => {
        notification.classList.add('translate-x-full');
        setTimeout(() => {
            notification.remove();
        }, 300);
    }, 5000);
}

/**
 * Initialize loading animations
 */
function initializeLoadingAnimations() {
    window.addEventListener('load', function() {
        document.body.classList.add('loaded');
        
        // Trigger any additional load animations
        const fadeElements = document.querySelectorAll('.fade-in-on-load');
        fadeElements.forEach(element => {
            element.classList.add('opacity-100');
        });
    });
}

/**
 * Initialize parallax effects (with performance considerations)
 */
function initializeParallaxEffects() {
    let ticking = false;
    
    function updateParallax() {
        const scrolled = window.pageYOffset;
        const hero = document.querySelector('[style*="background-image"]');
        
        if (hero && window.innerWidth > 768) { // Only on desktop
            const speed = 0.5;
            hero.style.transform = `translateY(${scrolled * speed}px)`;
        }
        
        ticking = false;
    }
    
    function requestParallaxUpdate() {
        if (!ticking) {
            requestAnimationFrame(updateParallax);
            ticking = true;
        }
    }
    
    // Throttled scroll listener
    window.addEventListener('scroll', requestParallaxUpdate, { passive: true });
}

/**
 * Initialize performance optimizations
 */
function initializePerformanceOptimizations() {
    // Lazy load images
    const images = document.querySelectorAll('img[data-src]');
    const imageObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const img = entry.target;
                img.src = img.dataset.src;
                img.classList.remove('lazy');
                imageObserver.unobserve(img);
            }
        });
    });
    
    images.forEach(img => imageObserver.observe(img));
    
    // Optimize animations on low-end devices
    if (navigator.hardwareConcurrency <= 2) {
        document.body.classList.add('reduced-motion');
    }
    
    // Preload critical assets
    preloadCriticalAssets();
}

/**
 * Preload critical assets
 */
function preloadCriticalAssets() {
    const criticalImages = [
        '/assets/image/image.jpg',
        '/assets/image/rekomendasi.png',
        '/assets/image/education.png'
    ];
    
    criticalImages.forEach(src => {
        const link = document.createElement('link');
        link.rel = 'preload';
        link.as = 'image';
        link.href = src;
        document.head.appendChild(link);
    });
}

/**
 * Utility function to debounce function calls
 */
function debounce(func, wait, immediate) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            timeout = null;
            if (!immediate) func(...args);
        };
        const callNow = immediate && !timeout;
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
        if (callNow) func(...args);
    };
}

/**
 * Utility function to throttle function calls
 */
function throttle(func, limit) {
    let inThrottle;
    return function(...args) {
        if (!inThrottle) {
            func.apply(this, args);
            inThrottle = true;
            setTimeout(() => inThrottle = false, limit);
        }
    }
}

// Export functions for testing or external use
window.LandingPage = {
    initializeAOS,
    initializeCardHoverEffects,
    initializeSmoothScrolling,
    initializeFormValidation,
    validateField,
    showNotification,
    debounce,
    throttle
};
