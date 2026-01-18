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
    </script>
</body>
</html>
