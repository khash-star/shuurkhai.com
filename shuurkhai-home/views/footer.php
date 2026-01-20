    <script>
        // Initialize Lucide icons
        lucide.createIcons();

        // Navbar scroll effect
        window.addEventListener('scroll', () => {
            const navbar = document.getElementById('navbar');
            if (window.scrollY > 20) {
                navbar.classList.remove('bg-transparent');
                navbar.classList.add('bg-white/80', 'backdrop-blur-xl', 'shadow-lg', 'shadow-slate-200/50');
            } else {
                navbar.classList.add('bg-transparent');
                navbar.classList.remove('bg-white/80', 'backdrop-blur-xl', 'shadow-lg', 'shadow-slate-200/50');
            }
        });

        // Mobile menu toggle
        const mobileMenuBtn = document.getElementById('mobileMenuBtn');
        const mobileMenu = document.getElementById('mobileMenu');
        const menuIcon = document.getElementById('menuIcon');
        
        mobileMenuBtn.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
            if (mobileMenu.classList.contains('hidden')) {
                menuIcon.setAttribute('data-lucide', 'menu');
            } else {
                menuIcon.setAttribute('data-lucide', 'x');
            }
            lucide.createIcons();
        });

        // Store scroll function
        function scrollStores(direction) {
            const container = document.getElementById('storesContainer');
            const scrollAmount = 300;
            container.scrollBy({
                left: direction === 'left' ? -scrollAmount : scrollAmount,
                behavior: 'smooth'
            });
        }

        // Store container drag scroll
        const storesContainer = document.getElementById('storesContainer');
        let isDragging = false;
        let startX = 0;
        let scrollLeft = 0;

        storesContainer.addEventListener('mousedown', (e) => {
            isDragging = true;
            startX = e.pageX - storesContainer.offsetLeft;
            scrollLeft = storesContainer.scrollLeft;
            storesContainer.style.cursor = 'grabbing';
        });

        storesContainer.addEventListener('mouseleave', () => {
            isDragging = false;
            storesContainer.style.cursor = 'grab';
        });

        storesContainer.addEventListener('mouseup', () => {
            isDragging = false;
            storesContainer.style.cursor = 'grab';
        });

        storesContainer.addEventListener('mousemove', (e) => {
            if (!isDragging) return;
            e.preventDefault();
            const x = e.pageX - storesContainer.offsetLeft;
            const walk = (x - startX) * 2;
            storesContainer.scrollLeft = scrollLeft - walk;
        });
        
        // Google Translate Banner Removal - Only remove banner, keep translate functionality
        (function removeGoogleTranslateBannerOnly() {
            'use strict';
            
            // Function to remove ONLY the banner iframe, keep translate widget
            function removeBannerOnly() {
                // Remove ONLY the top banner iframe (goog-te-banner-frame)
                // DO NOT remove the translate widget (google_translate_element)
                const banners = document.querySelectorAll('iframe.goog-te-banner-frame');
                banners.forEach(function(banner) {
                    try {
                        // Only remove if it's the banner, not the widget
                        if (banner.classList.contains('goog-te-banner-frame') || 
                            banner.className.indexOf('goog-te-banner-frame') !== -1) {
                            banner.remove();
                        }
                    } catch (e) {
                        // Silently fail
                    }
                });

                // Lock html/body styles - prevent Google Translate from altering layout
                const html = document.documentElement;
                const body = document.body;
                
                // Force reset inline styles that Google Translate might inject
                html.style.top = '0px';
                html.style.marginTop = '0px';
                html.style.paddingTop = '0px';
                
                body.style.top = '0px';
                body.style.marginTop = '0px';
                // Keep body padding-top for navbar, don't override it
                if (!body.style.paddingTop || body.style.paddingTop === '0px') {
                    body.style.paddingTop = '80px'; // navbar height
                }

                // Ensure navbar stays at top
                const navbar = document.querySelector('.navbar-translate');
                if (navbar) {
                    navbar.style.top = '0px';
                }

                // Ensure mobile menu stays at correct position
                const mobileMenu = document.getElementById('mobileMenu');
                if (mobileMenu) {
                    mobileMenu.style.top = '80px'; // navbar height
                }
            }

            // Run immediately
            removeBannerOnly();

            // Run on DOM ready
            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', removeBannerOnly);
            }

            // Run on window load
            window.addEventListener('load', removeBannerOnly);

            // Interval fallback - check every 300ms
            setInterval(removeBannerOnly, 300);

            // MutationObserver - watch for DOM changes and remove ONLY banner iframe
            const observer = new MutationObserver(function(mutations) {
                let shouldRemove = false;
                
                mutations.forEach(function(mutation) {
                    if (mutation.addedNodes && mutation.addedNodes.length > 0) {
                        mutation.addedNodes.forEach(function(node) {
                            if (node.nodeType === 1) { // Element node
                                // Check if added node is a banner iframe (NOT the widget)
                                if (node.tagName === 'IFRAME' && 
                                    (node.classList.contains('goog-te-banner-frame') || 
                                     node.className.indexOf('goog-te-banner-frame') !== -1)) {
                                    // Make sure it's not inside the translate widget
                                    const widget = document.getElementById('google_translate_element');
                                    const widgetMobile = document.getElementById('google_translate_element_mobile');
                                    if (widget && !widget.contains(node) && 
                                        widgetMobile && !widgetMobile.contains(node)) {
                                        shouldRemove = true;
                                    } else if (!widget && !widgetMobile) {
                                        shouldRemove = true;
                                    }
                                }
                                // Check if added node contains banner iframes (but not widget)
                                if (node.querySelectorAll) {
                                    const bannerIframes = node.querySelectorAll('iframe.goog-te-banner-frame');
                                    bannerIframes.forEach(function(iframe) {
                                        const widget = document.getElementById('google_translate_element');
                                        const widgetMobile = document.getElementById('google_translate_element_mobile');
                                        if (widget && !widget.contains(iframe) && 
                                            widgetMobile && !widgetMobile.contains(iframe)) {
                                            shouldRemove = true;
                                        } else if (!widget && !widgetMobile) {
                                            shouldRemove = true;
                                        }
                                    });
                                }
                            }
                        });
                    }
                });
                
                if (shouldRemove) {
                    removeBannerOnly();
                }
            });

            // Start observing
            observer.observe(document.documentElement, {
                childList: true,
                subtree: true,
                attributes: false
            });

            // Also observe body specifically
            if (document.body) {
                observer.observe(document.body, {
                    childList: true,
                    subtree: true,
                    attributes: false
                });
            }
        })();
    </script>
</body>
</html>
