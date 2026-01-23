<?php
/**
 * Production server дээр ажиллуулах скрипт
 * Энэ скрипт index.php файлыг шинэчлэнэ
 * 
 * Ашиглах: php update_index.php
 */

$indexPath = __DIR__ . '/index.php';
$backupPath = __DIR__ . '/index.php.old.' . date('Y-m-d_H-i-s');

// Хуучин файлыг backup хийх
if (file_exists($indexPath)) {
    copy($indexPath, $backupPath);
    echo "✓ Хуучин index.php backup хийгдлээ: $backupPath\n";
}

// Шинэ index.php агуулга
$newIndexContent = '<?php 
// Main entry point - displays new home page
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Try to include config.php if it exists (may be in parent directory for production)
$configPath = __DIR__ . "/../config.php";
if (file_exists($configPath)) {
    require_once($configPath);
}

// Try to include helper.php if it exists
$helperPath = __DIR__ . "/views/helper.php";
if (file_exists($helperPath)) {
    require_once($helperPath);
} else {
    // Try parent directory structure
    $helperPath = __DIR__ . "/../views/helper.php";
    if (file_exists($helperPath)) {
        require_once($helperPath);
    }
}

// Note: We don\'t include views/init.php here because this page uses Tailwind CSS
// instead of the old site\'s CSS framework
?>
<!DOCTYPE html>
<html lang="mn">
<head>
    <!-- Base URL for relative paths - Production path -->
    <base href="/shuurkhai_git/">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shuurkhai - Америк барааг Монголд</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        @import url(\'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap\');
        
        * {
            font-family: \'Inter\', sans-serif;
            box-sizing: border-box;
        }
        
        /* Prevent horizontal scroll on mobile - STRONGEST */
        html {
            overflow-x: hidden !important;
            max-width: 100vw !important;
            width: 100% !important;
            position: relative;
        }
        
        body {
            overflow-x: hidden !important;
            max-width: 100vw !important;
            width: 100% !important;
            position: relative;
            margin: 0;
            padding: 0;
        }
        
        /* Prevent all sections from overflowing */
        section {
            max-width: 100vw !important;
            overflow-x: hidden !important;
            width: 100% !important;
            box-sizing: border-box;
        }
        
        /* Ensure all containers respect viewport width */
        .max-w-7xl, .max-w-6xl, .max-w-xl, .max-w-2xl, .max-w-lg {
            max-width: 100% !important;
            box-sizing: border-box;
            width: 100%;
        }
        
        /* Ensure all images are responsive */
        img {
            max-width: 100% !important;
            height: auto;
            display: block;
            box-sizing: border-box;
        }
        
        /* Prevent flex containers from overflowing */
        .flex {
            min-width: 0;
            max-width: 100%;
        }
        
        /* Prevent absolute positioned elements from causing overflow */
        [class*="absolute"] {
            max-width: 100vw;
        }
        
        /* Ensure all divs respect width */
        div {
            box-sizing: border-box;
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
    if (typeof lucide !== \'undefined\') {
        lucide.createIcons();
    }
    
    // Mobile menu toggle
    const mobileMenuBtn = document.getElementById(\'mobileMenuBtn\');
    const mobileMenu = document.getElementById(\'mobileMenu\');
    const menuIcon = document.getElementById(\'menuIcon\');
    
    if (mobileMenuBtn && mobileMenu) {
        mobileMenuBtn.addEventListener(\'click\', function() {
            mobileMenu.classList.toggle(\'hidden\');
            if (menuIcon) {
                menuIcon.setAttribute(\'data-lucide\', mobileMenu.classList.contains(\'hidden\') ? \'menu\' : \'x\');
                if (typeof lucide !== \'undefined\') {
                    lucide.createIcons();
                }
            }
        });
    }
    
    // Store scrolling function
    function scrollStores(direction) {
        const container = document.getElementById(\'storesContainer\');
        if (container) {
            const scrollAmount = 300;
            container.scrollBy({
                left: direction === \'left\' ? -scrollAmount : scrollAmount,
                behavior: \'smooth\'
            });
        }
    }

    // Cargo Info Modal Functions
    const cargoData = {
        air: {
            icon: \'plane\',
            iconBg: \'bg-blue-100\',
            iconColor: \'text-blue-600\',
            title: \'✈️ Агаарын карго\',
            info: [
                { label: \'Хүргэлт\', value: \'5–10 хоног\' },
                { label: \'Жин\', value: \'Жижиг, дунд оврын ачаа\' },
                { label: \'Давуу тал\', value: \'Хурдан, найдвартай\' }
            ],
            actionText: \'Үнийн тооцоо\',
            actionUrl: \'/shuurkhai_git/calculator\'
        },
        sea: {
            icon: \'ship\',
            iconBg: \'bg-emerald-100\',
            iconColor: \'text-emerald-600\',
            title: \'🚢 Далайн карго\',
            info: [
                { label: \'Хүргэлт\', value: \'25–45 хоног\' },
                { label: \'Төрөл\', value: \'Том оврын ачаанд тохиромжтой\' },
                { label: \'Давуу тал\', value: \'Хямд үнэ\' }
            ],
            actionText: \'Үнийн тооцоолол\',
            actionUrl: \'/shuurkhai_git/calculator?type=sea\'
        }
    };

    function openCargoInfo(type) {
        const modal = document.getElementById(\'cargoInfoModal\');
        const content = document.getElementById(\'cargoInfoContent\');
        const data = cargoData[type];
        
        if (!modal || !data) return;
        
        // Set icon
        const iconEl = document.getElementById(\'cargoIcon\');
        if (iconEl) {
            iconEl.className = `inline-flex items-center justify-center w-16 h-16 rounded-2xl mb-4 ${data.iconBg}`;
            iconEl.innerHTML = `<i data-lucide="${data.icon}" class="w-8 h-8 ${data.iconColor}"></i>`;
        }
        
        // Set title
        const titleEl = document.getElementById(\'cargoTitle\');
        if (titleEl) titleEl.textContent = data.title;
        
        // Set info list
        const infoListEl = document.getElementById(\'cargoInfoList\');
        if (infoListEl) {
            infoListEl.innerHTML = data.info.map(item => `
                <div class="flex items-start gap-3 p-3 rounded-xl bg-slate-50">
                    <div class="flex-shrink-0 w-2 h-2 rounded-full bg-[#1e3a5f] mt-2"></div>
                    <div class="flex-1">
                        <span class="font-semibold text-slate-900">${item.label}:</span>
                        <span class="text-slate-600 ml-2">${item.value}</span>
                    </div>
                </div>
            `).join(\'\');
        }
        
        // Set action button
        const actionBtn = document.getElementById(\'cargoActionBtn\');
        const actionText = document.getElementById(\'cargoActionText\');
        if (actionBtn) actionBtn.href = data.actionUrl;
        if (actionText) actionText.textContent = data.actionText;
        
        // Show modal
        modal.classList.remove(\'hidden\');
        setTimeout(() => {
            content.classList.remove(\'scale-95\', \'opacity-0\');
            content.classList.add(\'scale-100\', \'opacity-100\');
        }, 10);
        
        // Reinitialize Lucide icons
        if (typeof lucide !== \'undefined\') {
            lucide.createIcons();
        }
        
        // Prevent body scroll
        document.body.style.overflow = \'hidden\';
    }

    function closeCargoInfo() {
        const modal = document.getElementById(\'cargoInfoModal\');
        const content = document.getElementById(\'cargoInfoContent\');
        
        if (!modal) return;
        
        content.classList.remove(\'scale-100\', \'opacity-100\');
        content.classList.add(\'scale-95\', \'opacity-0\');
        
        setTimeout(() => {
            modal.classList.add(\'hidden\');
            document.body.style.overflow = \'\';
        }, 300);
    }

    // Close on Escape key
    document.addEventListener(\'keydown\', function(e) {
        if (e.key === \'Escape\') {
            closeCargoInfo();
        }
    });

    // Hero Slider Functionality
    let currentSlide = 0;
    const slides = document.querySelectorAll(\'.hero-slide\');
    const dots = document.querySelectorAll(\'.slider-dot\');
    const totalSlides = slides.length;

    function showSlide(index) {
        if (index < 0 || index >= totalSlides) return;
        
        // Hide all slides
        slides.forEach((slide, i) => {
            slide.style.display = i === index ? \'block\' : \'none\';
        });
        
        // Update dots
        dots.forEach((dot, i) => {
            dot.classList.toggle(\'bg-white\', i === index);
            dot.classList.toggle(\'bg-white/50\', i !== index);
        });
        
        currentSlide = index;
    }

    // Auto-rotate slides every 5 seconds
    if (totalSlides > 1) {
        setInterval(() => {
            currentSlide = (currentSlide + 1) % totalSlides;
            showSlide(currentSlide);
        }, 5000);
    }
</script>
</body>
</html>';

// Шинэ файл бичих
if (file_put_contents($indexPath, $newIndexContent)) {
    echo "✓ index.php файл амжилттай шинэчлэгдлээ!\n";
    echo "✓ Шинэ нүүр хуудас одоо ажиллах ёстой.\n";
} else {
    echo "✗ Алдаа: index.php файл бичих боломжгүй байна. Эрх шалгана уу.\n";
    exit(1);
}

echo "\n✓ Бүх зүйл бэлэн! Browser дээр refresh хийгээрэй.\n";
?>
