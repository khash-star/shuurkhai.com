<?php 
// Test route for new home page
// Use __DIR__ to prevent path issues
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once(__DIR__ . "/../config.php");
require_once(__DIR__ . "/../views/helper.php");
// Note: We don't include views/init.php here because this page uses Tailwind CSS
// instead of the old site's CSS framework
?>
<!DOCTYPE html>
<html lang="mn">
<head>
    <!-- Base URL for relative paths -->
    <base href="/shuurkhai/">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shuurkhai - Америк барааг Монголд</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap');
        
        * {
            font-family: 'Inter', sans-serif;
        }
        
        .scrollbar-hide {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
        
        @keyframes floatReverse {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(10px); }
        }
        
        .animate-float {
            animation: float 4s ease-in-out infinite;
        }
        
        .animate-float-reverse {
            animation: floatReverse 5s ease-in-out infinite;
        }
        
        @keyframes spin-slow {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        
        .animate-spin-slow {
            animation: spin-slow 30s linear infinite;
        }
        
        @keyframes scroll-indicator {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(12px); }
        }
        
        .animate-scroll-indicator {
            animation: scroll-indicator 2s ease-in-out infinite;
        }
    </style>
</head>
<body class="min-h-screen bg-white">
<?php require_once(__DIR__ . "/views/home_new.php"); ?>
<script>
    // Initialize Lucide icons
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }
    
    // Mobile menu toggle
    const mobileMenuBtn = document.getElementById('mobileMenuBtn');
    const mobileMenu = document.getElementById('mobileMenu');
    const menuIcon = document.getElementById('menuIcon');
    
    if (mobileMenuBtn && mobileMenu) {
        mobileMenuBtn.addEventListener('click', function() {
            mobileMenu.classList.toggle('hidden');
            if (menuIcon) {
                menuIcon.setAttribute('data-lucide', mobileMenu.classList.contains('hidden') ? 'menu' : 'x');
                if (typeof lucide !== 'undefined') {
                    lucide.createIcons();
                }
            }
        });
    }
    
    // Store scrolling function
    function scrollStores(direction) {
        const container = document.getElementById('storesContainer');
        if (container) {
            const scrollAmount = 300;
            container.scrollBy({
                left: direction === 'left' ? -scrollAmount : scrollAmount,
                behavior: 'smooth'
            });
        }
    }

    // Cargo Info Modal Functions
    const cargoData = {
        air: {
            icon: 'plane',
            iconBg: 'bg-blue-100',
            iconColor: 'text-blue-600',
            title: '✈️ Агаарын карго',
            info: [
                { label: 'Хүргэлт', value: '5–10 хоног' },
                { label: 'Жин', value: 'Жижиг, дунд оврын ачаа' },
                { label: 'Давуу тал', value: 'Хурдан, найдвартай' }
            ],
            actionText: 'Үнийн тооцоо',
            actionUrl: '/shuurkhai/calculator'
        },
        sea: {
            icon: 'ship',
            iconBg: 'bg-emerald-100',
            iconColor: 'text-emerald-600',
            title: '🚢 Далайн карго',
            info: [
                { label: 'Хүргэлт', value: '25–45 хоног' },
                { label: 'Төрөл', value: 'Том оврын ачаанд тохиромжтой' },
                { label: 'Давуу тал', value: 'Хямд үнэ' }
            ],
            actionText: 'Үнийн тооцоолол',
            actionUrl: '/shuurkhai/calculator?type=sea'
        }
    };

    function openCargoInfo(type) {
        const modal = document.getElementById('cargoInfoModal');
        const content = document.getElementById('cargoInfoContent');
        const data = cargoData[type];
        
        if (!modal || !data) return;
        
        // Set icon
        const iconEl = document.getElementById('cargoIcon');
        if (iconEl) {
            iconEl.className = `inline-flex items-center justify-center w-16 h-16 rounded-2xl mb-4 ${data.iconBg}`;
            iconEl.innerHTML = `<i data-lucide="${data.icon}" class="w-8 h-8 ${data.iconColor}"></i>`;
        }
        
        // Set title
        const titleEl = document.getElementById('cargoTitle');
        if (titleEl) titleEl.textContent = data.title;
        
        // Set info list
        const infoListEl = document.getElementById('cargoInfoList');
        if (infoListEl) {
            infoListEl.innerHTML = data.info.map(item => `
                <div class="flex items-start gap-3 p-3 rounded-xl bg-slate-50">
                    <div class="flex-shrink-0 w-2 h-2 rounded-full bg-[#1e3a5f] mt-2"></div>
                    <div class="flex-1">
                        <span class="font-semibold text-slate-900">${item.label}:</span>
                        <span class="text-slate-600 ml-2">${item.value}</span>
                    </div>
                </div>
            `).join('');
        }
        
        // Set action button
        const actionBtn = document.getElementById('cargoActionBtn');
        const actionText = document.getElementById('cargoActionText');
        if (actionBtn) actionBtn.href = data.actionUrl;
        if (actionText) actionText.textContent = data.actionText;
        
        // Show modal
        modal.classList.remove('hidden');
        setTimeout(() => {
            content.classList.remove('scale-95', 'opacity-0');
            content.classList.add('scale-100', 'opacity-100');
        }, 10);
        
        // Reinitialize Lucide icons
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
        
        // Prevent body scroll
        document.body.style.overflow = 'hidden';
    }

    function closeCargoInfo() {
        const modal = document.getElementById('cargoInfoModal');
        const content = document.getElementById('cargoInfoContent');
        
        if (!modal) return;
        
        content.classList.remove('scale-100', 'opacity-100');
        content.classList.add('scale-95', 'opacity-0');
        
        setTimeout(() => {
            modal.classList.add('hidden');
            document.body.style.overflow = '';
        }, 300);
    }

    // Close on Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeCargoInfo();
        }
    });
</script>
</body>
</html>
