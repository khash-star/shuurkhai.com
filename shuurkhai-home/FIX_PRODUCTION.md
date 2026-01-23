# Production Server засах заавар

Production server дээр дараах командуудыг ажиллуулаарай:

## 1. Root index.php файлыг засах

```bash
cd ~/public_html/shuurkhai_git

# Хуучин index.php-г backup хийх
cp index.php index.php.backup_$(date +%Y%m%d_%H%M%S)

# Шинэ index.php үүсгэх
cat > index.php << 'EOFPHP'
<?php 
// Root level index.php for production
// Main entry point - displays new home page
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Include config.php (from same directory)
require_once(__DIR__ . "/config.php");
require_once(__DIR__ . "/views/helper.php");
?>
<!DOCTYPE html>
<html lang="mn">
<head>
    <base href="/shuurkhai_git/">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shuurkhai - Америк барааг Монголд</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap');
        * { font-family: 'Inter', sans-serif; box-sizing: border-box; }
        html { overflow-x: hidden !important; max-width: 100vw !important; width: 100% !important; position: relative; }
        body { overflow-x: hidden !important; max-width: 100vw !important; width: 100% !important; position: relative; margin: 0; padding: 0; }
        section { max-width: 100vw !important; overflow-x: hidden !important; width: 100% !important; box-sizing: border-box; }
        .max-w-7xl, .max-w-6xl, .max-w-xl, .max-w-2xl, .max-w-lg { max-width: 100% !important; box-sizing: border-box; width: 100%; }
        img { max-width: 100% !important; height: auto; display: block; box-sizing: border-box; }
        .flex { min-width: 0; max-width: 100%; }
        [class*="absolute"] { max-width: 100vw; }
        div { box-sizing: border-box; }
    </style>
</head>
<body class="min-h-screen bg-white">
<?php require_once(__DIR__ . "/shuurkhai-home/views/home_new.php"); ?>
<script>
    if (typeof lucide !== 'undefined') { lucide.createIcons(); }
    const mobileMenuBtn = document.getElementById('mobileMenuBtn');
    const mobileMenu = document.getElementById('mobileMenu');
    const menuIcon = document.getElementById('menuIcon');
    if (mobileMenuBtn && mobileMenu) {
        mobileMenuBtn.addEventListener('click', function() {
            mobileMenu.classList.toggle('hidden');
            if (menuIcon) {
                menuIcon.setAttribute('data-lucide', mobileMenu.classList.contains('hidden') ? 'menu' : 'x');
                if (typeof lucide !== 'undefined') { lucide.createIcons(); }
            }
        });
    }
    function scrollStores(direction) {
        const container = document.getElementById('storesContainer');
        if (container) {
            container.scrollBy({ left: direction === 'left' ? -300 : 300, behavior: 'smooth' });
        }
    }
    const cargoData = {
        air: { icon: 'plane', iconBg: 'bg-blue-100', iconColor: 'text-blue-600', title: '✈️ Агаарын карго',
            info: [{ label: 'Хүргэлт', value: '5–10 хоног' }, { label: 'Жин', value: 'Жижиг, дунд оврын ачаа' }, { label: 'Давуу тал', value: 'Хурдан, найдвартай' }],
            actionText: 'Үнийн тооцоо', actionUrl: '/shuurkhai_git/calculator' },
        sea: { icon: 'ship', iconBg: 'bg-emerald-100', iconColor: 'text-emerald-600', title: '🚢 Далайн карго',
            info: [{ label: 'Хүргэлт', value: '25–45 хоног' }, { label: 'Төрөл', value: 'Том оврын ачаанд тохиромжтой' }, { label: 'Давуу тал', value: 'Хямд үнэ' }],
            actionText: 'Үнийн тооцоолол', actionUrl: '/shuurkhai_git/calculator?type=sea' }
    };
    function openCargoInfo(type) {
        const modal = document.getElementById('cargoInfoModal');
        const content = document.getElementById('cargoInfoContent');
        const data = cargoData[type];
        if (!modal || !data) return;
        const iconEl = document.getElementById('cargoIcon');
        if (iconEl) {
            iconEl.className = `inline-flex items-center justify-center w-16 h-16 rounded-2xl mb-4 ${data.iconBg}`;
            iconEl.innerHTML = `<i data-lucide="${data.icon}" class="w-8 h-8 ${data.iconColor}"></i>`;
        }
        const titleEl = document.getElementById('cargoTitle');
        if (titleEl) titleEl.textContent = data.title;
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
        const actionBtn = document.getElementById('cargoActionBtn');
        const actionText = document.getElementById('cargoActionText');
        if (actionBtn) actionBtn.href = data.actionUrl;
        if (actionText) actionText.textContent = data.actionText;
        modal.classList.remove('hidden');
        setTimeout(() => {
            content.classList.remove('scale-95', 'opacity-0');
            content.classList.add('scale-100', 'opacity-100');
        }, 10);
        if (typeof lucide !== 'undefined') { lucide.createIcons(); }
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
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') { closeCargoInfo(); }
    });
    let currentSlide = 0;
    const slides = document.querySelectorAll('.hero-slide');
    const dots = document.querySelectorAll('.slider-dot');
    const totalSlides = slides.length;
    function showSlide(index) {
        if (index < 0 || index >= totalSlides) return;
        slides.forEach((slide, i) => {
            slide.style.display = i === index ? 'block' : 'none';
        });
        dots.forEach((dot, i) => {
            dot.classList.toggle('bg-white', i === index);
            dot.classList.toggle('bg-white/50', i !== index);
        });
        currentSlide = index;
    }
    if (totalSlides > 1) {
        setInterval(() => {
            currentSlide = (currentSlide + 1) % totalSlides;
            showSlide(currentSlide);
        }, 5000);
    }
</script>
</body>
</html>
EOFPHP
```

## 2. .htaccess файлыг засах

`.htaccess` файл дээр root (/) route-ийг засах:

```bash
# .htaccess файлыг засах
nano .htaccess
```

Дараах мөрийг олоод:
```
RewriteRule ^$ shuurkhai-home/home-test.php [L]
```

Үүнийг дараах байдлаар засах:
```
RewriteRule ^$ index.php [L]
```

Эсвэл бүхэлд нь:
```
# Root (/) нь шинэ нүүр хуудсанд заах
RewriteRule ^$ index.php [L]
```

## 3. Шалгах

```bash
# index.php файлын эхний мөрүүдийг шалгах
head -10 index.php

# Browser дээр refresh хийх
# https://shuurkhai.com/shuurkhai_git/
```

## Хэрэв асуудал гарвал:

```bash
# Error log шалгах
tail -50 ~/logs/error_log

# PHP error шалгах
tail -50 /var/log/apache2/error.log
```
