// ============================================================
// MOBILE UX ENHANCEMENTS
// ============================================================

(function() {
    'use strict';

    // ============================================================
    // 1. TOUCH SWIPE FOR CAROUSELS
    // ============================================================
    function initTouchSwipe() {
        const carousels = document.querySelectorAll('.carousel');
        
        carousels.forEach(carousel => {
            let touchStartX = 0;
            let touchEndX = 0;
            const minSwipeDistance = 50;
            
            carousel.addEventListener('touchstart', function(e) {
                touchStartX = e.changedTouches[0].screenX;
            }, { passive: true });
            
            carousel.addEventListener('touchend', function(e) {
                touchEndX = e.changedTouches[0].screenX;
                handleSwipe();
            }, { passive: true });
            
            function handleSwipe() {
                const swipeDistance = touchEndX - touchStartX;
                
                if (Math.abs(swipeDistance) > minSwipeDistance) {
                    if (swipeDistance > 0) {
                        // Swipe right - previous slide
                        const prevButton = carousel.querySelector('.carousel-control-prev');
                        if (prevButton) prevButton.click();
                    } else {
                        // Swipe left - next slide
                        const nextButton = carousel.querySelector('.carousel-control-next');
                        if (nextButton) nextButton.click();
                    }
                }
            }
        });
    }

    // ============================================================
    // 2. MOBILE MENU ENHANCEMENTS
    // ============================================================
    function initMobileMenu() {
        const mobileMenu = document.querySelector('.nav-mobile');
        const toggleBtn = document.querySelector('.nav-toggle');
        
        if (!mobileMenu || !toggleBtn) return;
        
        // Close menu when clicking outside
        document.addEventListener('click', function(e) {
            if (!mobileMenu.contains(e.target) && !toggleBtn.contains(e.target)) {
                mobileMenu.classList.remove('active');
                toggleBtn.setAttribute('aria-expanded', 'false');
            }
        });
        
        // Close menu when clicking on a link
        mobileMenu.querySelectorAll('a').forEach(link => {
            link.addEventListener('click', function() {
                mobileMenu.classList.remove('active');
                toggleBtn.setAttribute('aria-expanded', 'false');
            });
        });
        
        // Keyboard accessibility
        toggleBtn.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                toggleBtn.click();
            }
        });
    }

    // ============================================================
    // 3. SCROLL TO TOP BUTTON
    // ============================================================
    function initScrollButton() {
        const scrollBtn = document.getElementById('scrollTopBtn');
        if (!scrollBtn) return;
        
        let lastScroll = 0;
        
        window.addEventListener('scroll', function() {
            const currentScroll = window.pageYOffset;
            
            if (currentScroll > 300) {
                scrollBtn.classList.add('visible');
            } else {
                scrollBtn.classList.remove('visible');
            }
            
            lastScroll = currentScroll;
        }, { passive: true });
        
        scrollBtn.addEventListener('click', function() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    }

    // ============================================================
    // 4. SMOOTH SCROLL FOR ANCHOR LINKS
    // ============================================================
    function initSmoothScroll() {
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                const targetId = this.getAttribute('href');
                if (targetId === '#' || targetId === '#!') return;
                
                const target = document.querySelector(targetId);
                if (target) {
                    e.preventDefault();
                    
                    const navHeight = document.querySelector('.site-header, .navbar')?.offsetHeight || 0;
                    const targetPosition = target.getBoundingClientRect().top + window.pageYOffset - navHeight;
                    
                    window.scrollTo({
                        top: targetPosition,
                        behavior: 'smooth'
                    });
                }
            });
        });
    }

    // ============================================================
    // 5. LAZY LOADING ENHANCEMENTS
    // ============================================================
    function initLazyLoad() {
        if ('IntersectionObserver' in window) {
            const imageObserver = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const img = entry.target;
                        if (img.dataset.src) {
                            img.src = img.dataset.src;
                            img.removeAttribute('data-src');
                            img.classList.add('loaded');
                        }
                        observer.unobserve(img);
                    }
                });
            }, {
                rootMargin: '50px 0px',
                threshold: 0.01
            });
            
            document.querySelectorAll('img[data-src]').forEach(img => {
                imageObserver.observe(img);
            });
        }
    }

    // ============================================================
    // 6. FORM VALIDATION ENHANCEMENTS
    // ============================================================
    function initFormEnhancements() {
        // Date picker enhancements
        const dateInputs = document.querySelectorAll('input[type="date"]');
        const today = new Date().toISOString().split('T')[0];
        
        dateInputs.forEach(input => {
            if (!input.hasAttribute('min')) {
                input.setAttribute('min', today);
            }
            
            // Update min date for end date based on start date
            input.addEventListener('change', function() {
                const startDateInput = document.querySelector('input[name="start_date"]');
                const endDateInput = document.querySelector('input[name="end_date"]');
                
                if (this.name === 'start_date' && endDateInput) {
                    const startDate = this.value;
                    if (startDate) {
                        endDateInput.setAttribute('min', startDate);
                    }
                }
            });
        });
        
        // Phone number formatting
        const phoneInputs = document.querySelectorAll('input[type="tel"]');
        phoneInputs.forEach(input => {
            input.addEventListener('input', function(e) {
                let value = e.target.value.replace(/\D/g, '');
                if (value.startsWith('0')) {
                    value = value.substring(1);
                }
                if (value.startsWith('970')) {
                    value = value.substring(3);
                }
                // Format as user types
                if (value.length > 0) {
                    e.target.value = value;
                }
            });
        });
    }

    // ============================================================
    // 7. ACCESSIBILITY ENHANCEMENTS
    // ============================================================
    function initAccessibility() {
        // Skip to main content link
        const skipLink = document.createElement('a');
        skipLink.href = '#main-content';
        skipLink.className = 'skip-link';
        skipLink.textContent = 'Skip to main content';
        skipLink.style.cssText = 'position:absolute;left:-9999px;z-index:9999;padding:1em;background:#000;color:#fff;';
        
        skipLink.addEventListener('focus', function() {
            this.style.left = '0';
        });
        
        skipLink.addEventListener('blur', function() {
            this.style.left = '-9999px';
        });
        
        document.body.insertBefore(skipLink, document.body.firstChild);
        
        // Add main content ID if not exists
        const main = document.querySelector('main, .site-main, .main-content');
        if (main && !main.id) {
            main.id = 'main-content';
        }
        
        // Focus trap for modals
        const modals = document.querySelectorAll('.modal');
        modals.forEach(modal => {
            modal.addEventListener('shown.bs.modal', function() {
                const focusable = modal.querySelector('input, button, select, textarea, a[href]');
                if (focusable) {
                    setTimeout(() => focusable.focus(), 100);
                }
            });
        });
    }

    // ============================================================
    // 8. PERFORMANCE: PASSIVE LISTENERS
    // ============================================================
    function initPassiveListeners() {
        // Convert scroll listeners to passive
        const addEventListener = EventTarget.prototype.addEventListener;
        EventTarget.prototype.addEventListener = function(type, listener, options) {
            if (type === 'scroll' || type === 'touchstart' || type === 'touchmove') {
                if (typeof options === 'boolean') {
                    options = { capture: options, passive: true };
                } else if (typeof options === 'object') {
                    options = { ...options, passive: true };
                } else {
                    options = { passive: true };
                }
            }
            return addEventListener.call(this, type, listener, options);
        };
    }

    // ============================================================
    // 9. DEVICE ORIENTATION HANDLING
    // ============================================================
    function initOrientationHandling() {
        // Add orientation class to body
        function updateOrientation() {
            if (window.innerHeight > window.innerWidth) {
                document.body.classList.add('portrait');
                document.body.classList.remove('landscape');
            } else {
                document.body.classList.add('landscape');
                document.body.classList.remove('portrait');
            }
        }
        
        updateOrientation();
        window.addEventListener('resize', updateOrientation, { passive: true });
        window.addEventListener('orientationchange', updateOrientation);
    }

    // ============================================================
    // 10. PREVENT OVERSCROLL ON MOBILE
    // ============================================================
    function initOverscrollPrevention() {
        // Prevent pull-to-refresh on mobile
        let lastTouchY = 0;
        
        document.addEventListener('touchstart', function(e) {
            lastTouchY = e.touches[0].clientY;
        }, { passive: true });
        
        document.addEventListener('touchmove', function(e) {
            const currentY = e.touches[0].clientY;
            const diff = currentY - lastTouchY;
            
            // If at top and pulling down, or at bottom and pulling up
            const atTop = window.scrollY === 0;
            const atBottom = window.scrollY >= document.documentElement.scrollHeight - window.innerHeight;
            
            if ((atTop && diff > 0) || (atBottom && diff < 0)) {
                e.preventDefault();
            }
        }, { passive: false });
    }

    // ============================================================
    // INITIALIZE ALL
    // ============================================================
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }

    function init() {
        initTouchSwipe();
        initMobileMenu();
        initScrollButton();
        initSmoothScroll();
        initLazyLoad();
        initFormEnhancements();
        initAccessibility();
        initPassiveListeners();
        initOrientationHandling();
        initOverscrollPrevention();
    }
})();
