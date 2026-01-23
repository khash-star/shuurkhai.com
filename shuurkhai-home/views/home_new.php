    
    <!-- Navbar -->
    <nav id="navbar" class="fixed left-0 right-0 z-50 transition-all duration-300 bg-transparent navbar-translate" style="top: 0;">
        <div class="max-w-7xl mx-auto px-3 sm:px-4 md:px-6 lg:px-8">
            <div class="flex items-center justify-between" style="height: 70px; padding-top: 25px;">
                <!-- Google Translate Button - Left side -->
                <div class="flex items-center" style="margin-top: 12px;">
                    <button id="google_translate_btn" onclick="triggerGoogleTranslate(); return false;" class="px-3 py-2 rounded-lg text-xs font-medium text-slate-700 hover:bg-slate-100 transition-colors border border-slate-200 flex items-center gap-1.5" style="height: 32px;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M5 8l6 6"></path>
                            <path d="M4 14l6-6 2-3"></path>
                            <path d="M2 5h12"></path>
                            <path d="M7 2h1"></path>
                            <path d="M22 22l-5-10-5 10"></path>
                            <path d="M14 18h6"></path>
                        </svg>
                        <span>Google Translate</span>
                    </button>
                    <div id="google_translate_element" style="display: none; position: absolute; left: -9999px;"></div>
                </div>
                <!-- Logo -->
                <a href="/shuurkhai/" class="flex items-center gap-3 hover:scale-105 transition-transform" style="margin-top: 12px;">
                    <img src="/shuurkhai/images/logo.png" alt="Shuurkhai Logo" class="h-11 w-auto object-contain">
                    <span class="text-xl font-bold text-slate-900">www.SHUURKHAI.com</span>
                </a>

                <!-- Desktop Navigation -->
                <div class="hidden lg:flex items-center gap-8" style="margin-top: 12px;">
                    <a href="/shuurkhai/" class="flex items-center gap-1 font-medium transition-colors text-slate-700 hover:text-[#1e3a5f]">Нүүр</a>
                    <div class="relative group">
                        <a href="javascript:void(0);" class="flex items-center gap-1 font-medium transition-colors text-slate-700 hover:text-[#1e3a5f]">
                            Үйлчилгээ
                            <i data-lucide="chevron-down" class="w-4 h-4"></i>
                        </a>
                        <div class="absolute top-full left-0 pt-4 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                            <div class="bg-white rounded-2xl shadow-xl border border-slate-100 p-2 min-w-[220px]">
                                <?php
                                // Check if user is logged in as admin
                                $is_admin = false;
                                if (isset($_SESSION['logged']) && $_SESSION['logged'] === true) {
                                    if (isset($_SESSION['customer_id']) && $_SESSION['customer_id'] == 0) {
                                        $is_admin = true;
                                    } elseif (isset($_SESSION['name']) && !empty($_SESSION['name'])) {
                                        $is_admin = true;
                                    }
                                }
                                ?>
                                <button type="button" onclick="openCargoInfo('air')" class="w-full flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-slate-50 transition-colors text-left">
                                    <div class="w-10 h-10 rounded-lg bg-[#1e3a5f]/5 flex items-center justify-center">
                                        <i data-lucide="plane" class="w-5 h-5 text-[#1e3a5f]"></i>
                                    </div>
                                    <span class="font-medium text-slate-700">Агаарын карго</span>
                                </button>
                                <button type="button" onclick="openCargoInfo('sea')" class="w-full flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-slate-50 transition-colors text-left">
                                    <div class="w-10 h-10 rounded-lg bg-[#1e3a5f]/5 flex items-center justify-center">
                                        <i data-lucide="ship" class="w-5 h-5 text-[#1e3a5f]"></i>
                                    </div>
                                    <span class="font-medium text-slate-700">Далайн карго</span>
                                </button>
                                <a href="/shuurkhai/login" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-slate-50 transition-colors">
                                    <div class="w-10 h-10 rounded-lg bg-[#1e3a5f]/5 flex items-center justify-center">
                                        <i data-lucide="package" class="w-5 h-5 text-[#1e3a5f]"></i>
                                    </div>
                                    <span class="font-medium text-slate-700">Онлайн захиалга</span>
                                </a>
                                <a href="/shuurkhai/shop" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-slate-50 transition-colors">
                                    <div class="w-10 h-10 rounded-lg bg-[#1e3a5f]/5 flex items-center justify-center">
                                        <i data-lucide="store" class="w-5 h-5 text-[#1e3a5f]"></i>
                                    </div>
                                    <span class="font-medium text-slate-700">Бүх дэлгүүр</span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <a href="/shuurkhai/faqs" class="font-medium transition-colors text-slate-700 hover:text-[#1e3a5f]">ТУСЛАМЖ</a>
                    <a href="/shuurkhai/contact.php" class="font-medium transition-colors text-slate-700 hover:text-[#1e3a5f]">Холбоо барих</a>
                </div>

                <!-- CTA Buttons -->
                <div class="hidden lg:flex items-center gap-4" style="margin-top: 12px;">
                    <a href="/shuurkhai/login" class="px-4 py-2 rounded-xl text-slate-700 hover:bg-slate-50 transition-colors flex items-center gap-2" title="Нэвтрэх">
                        <i data-lucide="user" class="w-4 h-4"></i>
                        Нэвтрэх
                    </a>
                    <a href="/shuurkhai/calculator" class="px-4 py-2 rounded-xl text-slate-700 hover:bg-slate-50 transition-colors flex items-center gap-2">
                        <i data-lucide="calculator" class="w-4 h-4"></i>
                        Үнэ тооцоолох
                    </a>
                    <a href="/shuurkhai/user/login" class="bg-slate-900 hover:bg-slate-800 text-white px-6 py-2 rounded-xl shadow-sm transition-colors inline-block">
                        Захиалах
                    </a>
                </div>

                <!-- Mobile Menu Button -->
                <button id="mobileMenuBtn" class="lg:hidden p-2 rounded-xl hover:bg-slate-100 transition-colors">
                    <i data-lucide="menu" id="menuIcon" class="w-6 h-6 text-slate-900"></i>
                </button>
            </div>
        </div>
    </nav>

    <!-- Mobile Menu -->
    <div id="mobileMenu" class="fixed inset-x-0 z-40 lg:hidden hidden" style="top: 70px;">
        <div class="bg-white/95 backdrop-blur-xl border-t border-slate-100 shadow-xl">
            <div class="max-w-7xl mx-auto px-4 py-6">
                <div class="space-y-2">
                    <a href="/shuurkhai/" class="block px-4 py-3 rounded-xl text-slate-700 font-medium hover:bg-slate-50 transition-colors">Нүүр</a>
                    <div class="ml-4 mt-1 space-y-1">
                        <?php
                        // Check if user is logged in as admin
                        $is_admin_mobile = isset($_SESSION['logged']) && $_SESSION['logged'] === true && 
                                          (isset($_SESSION['customer_id']) && $_SESSION['customer_id'] == 0 || 
                                           (isset($_SESSION['name']) && !empty($_SESSION['name'])));
                        ?>
                        <button type="button" onclick="openCargoInfo('air')" class="w-full flex items-center gap-3 px-4 py-2 rounded-lg text-slate-600 hover:bg-slate-50 transition-colors text-left">
                            <i data-lucide="plane" class="w-4 h-4 text-[#1e3a5f]"></i>
                            Агаарын карго
                        </button>
                        <button type="button" onclick="openCargoInfo('sea')" class="w-full flex items-center gap-3 px-4 py-2 rounded-lg text-slate-600 hover:bg-slate-50 transition-colors text-left">
                            <i data-lucide="ship" class="w-4 h-4 text-[#1e3a5f]"></i>
                            Далайн карго
                        </button>
                        <a href="/shuurkhai/shop" class="flex items-center gap-3 px-4 py-2 rounded-lg text-slate-600 hover:bg-slate-50 transition-colors">
                            <i data-lucide="store" class="w-4 h-4 text-[#1e3a5f]"></i>
                            Бүх дэлгүүр
                        </a>
                    </div>
                    <a href="/shuurkhai/faqs" class="block px-4 py-3 rounded-xl text-slate-700 font-medium hover:bg-slate-50 transition-colors">ТУСЛАМЖ</a>
                    <a href="/shuurkhai/contact.php" class="block px-4 py-3 rounded-xl text-slate-700 font-medium hover:bg-slate-50 transition-colors">Холбоо барих</a>
                </div>
                <div class="mt-6 pt-6 border-t border-slate-100 space-y-3">
                    <!-- Google Translate -->
                    <div id="google_translate_element_mobile" style="display: block; width: 100%; margin-bottom: 12px;"></div>
                    
                    <a href="/shuurkhai/login" class="block w-full text-center px-4 py-2 rounded-xl border border-slate-200 hover:bg-slate-50 transition-colors" title="Нэвтрэх">
                        <i data-lucide="user" class="w-4 h-4 inline mr-2"></i>
                        Нэвтрэх
                    </a>
                    <a href="/shuurkhai/calculator" class="block w-full text-center px-4 py-2 rounded-xl border border-slate-200 hover:bg-slate-50 transition-colors">
                        <i data-lucide="calculator" class="w-4 h-4 inline mr-2"></i>
                        Үнэ тооцоолох
                    </a>
                    <a href="/shuurkhai/user/login" class="w-full bg-gradient-to-r from-[#1e3a5f] to-[#2d5a8f] text-white rounded-xl py-2 inline-block text-center">
                        Захиалах
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Hero Slider Section -->
    <?php
    // Get slider images from database (from admin slides table)
    $slider_images = [];
    if (isset($conn)) {
        // Use 'slides' table (same as admin/slides.php) instead of 'sliders'
        $sql_slider = "SELECT * FROM slides ORDER BY dd LIMIT 5";
        $result_slider = mysqli_query($conn, $sql_slider);
        if ($result_slider) {
            while ($slider_data = mysqli_fetch_array($result_slider)) {
                if ($slider_data && isset($slider_data["image"]) && !empty($slider_data["image"])) {
                    $slider_image = fix_image_path($slider_data["image"]);
                    if (!empty($slider_image)) {
                        $slider_images[] = [
                            'image' => $slider_image,
                            'name' => isset($slider_data["name"]) ? htmlspecialchars($slider_data["name"]) : '',
                            'text' => isset($slider_data["text"]) ? htmlspecialchars($slider_data["text"]) : '',
                            'link' => isset($slider_data["link"]) ? htmlspecialchars($slider_data["link"]) : '',
                        ];
                    }
                }
            }
        }
    }
    ?>
    <?php if (!empty($slider_images)): ?>
    <section class="relative w-full h-[30vh] sm:h-[35vh] md:h-[40vh] lg:h-[50vh] max-h-[50vh] overflow-x-hidden overflow-y-hidden mt-16">
        <div id="heroSlider" class="relative w-full h-full overflow-hidden flex items-center justify-center">
            <?php foreach ($slider_images as $index => $slide): ?>
            <div class="hero-slide <?php echo $index === 0 ? 'active' : ''; ?>" style="display: <?php echo $index === 0 ? 'flex' : 'none'; ?>; position: absolute; top: 0; left: 0; width: 100%; height: 100%; overflow: hidden; align-items: center; justify-content: center;">
                <?php 
                // Validate and format link - if it's just a single character or relative path, make it absolute or skip it
                $slide_link = isset($slide['link']) ? trim($slide['link']) : '';
                $is_valid_link = false;
                if (!empty($slide_link)) {
                    // Check if it's a full URL (http/https) or absolute path starting with /
                    if (preg_match('/^https?:\/\//', $slide_link) || preg_match('/^\//', $slide_link)) {
                        $is_valid_link = true;
                    } elseif (strlen($slide_link) > 1) {
                        // If it's a relative path, make it absolute from root
                        $slide_link = '/shuurkhai/' . ltrim($slide_link, '/');
                        $is_valid_link = true;
                    }
                }
                ?>
                <img src="<?php echo htmlspecialchars($slide['image']); ?>" alt="<?php echo htmlspecialchars($slide['name'] ?: 'Slider ' . ($index + 1)); ?>" class="max-w-[95%] max-h-full w-auto h-auto object-contain z-0" style="max-width: 95%; max-height: 100%; width: auto; height: auto; object-fit: contain;">
                <?php if ($is_valid_link): ?>
                <a href="<?php echo htmlspecialchars($slide_link); ?>" class="absolute inset-0 z-10"></a>
                <?php endif; ?>
            </div>
            <?php endforeach; ?>
        </div>
        
        <!-- Slider Controls -->
        <?php if (count($slider_images) > 1): ?>
        <div class="absolute bottom-4 left-1/2 -translate-x-1/2 flex gap-2 z-20">
            <?php foreach ($slider_images as $index => $slider_img): ?>
            <button onclick="showSlide(<?php echo $index; ?>)" class="w-2 h-2 rounded-full bg-white/50 hover:bg-white transition-colors slider-dot <?php echo $index === 0 ? 'bg-white' : ''; ?>"></button>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </section>
    <?php endif; ?>

    <!-- Store Partners Section -->
    <section class="py-4 sm:py-6 md:py-8 bg-gradient-to-b from-white via-slate-50 to-white relative overflow-hidden">
        <div class="absolute top-10 left-0 sm:left-10 md:left-20 w-48 h-48 sm:w-64 sm:h-64 md:w-72 md:h-72 bg-blue-200/20 rounded-full blur-3xl"></div>
        <div class="absolute bottom-10 right-0 sm:right-10 md:right-20 w-64 h-64 sm:w-80 sm:h-80 md:w-96 md:h-96 bg-purple-200/20 rounded-full blur-3xl"></div>
        
        <div class="max-w-6xl mx-auto px-3 sm:px-4 md:px-6 lg:px-8 relative">
            <!-- Section Title -->
            <div class="text-center mb-3 sm:mb-4">
                <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold text-slate-900">
                    Бүх онлайн дэлгүүр
                </h2>
            </div>

            <!-- Scroll Buttons -->
            <div class="flex items-center justify-between mb-4 sm:mb-6">
                <div class="flex gap-2">
                    <button onclick="scrollStores('left')" class="w-10 h-10 rounded-xl bg-white/60 backdrop-blur-sm border border-white/80 shadow-sm hover:shadow-md hover:bg-white/80 transition-all duration-200 flex items-center justify-center">
                        <i data-lucide="chevron-left" class="w-5 h-5 text-slate-700"></i>
                    </button>
                    <button onclick="scrollStores('right')" class="w-10 h-10 rounded-xl bg-white/60 backdrop-blur-sm border border-white/80 shadow-sm hover:shadow-md hover:bg-white/80 transition-all duration-200 flex items-center justify-center">
                        <i data-lucide="chevron-right" class="w-5 h-5 text-slate-700"></i>
                    </button>
                </div>
                <?php 
                // Check if user is logged in as admin
                // Admin panel uses $_SESSION['logged'] and $_SESSION['name']
                $is_admin = false;
                if (isset($_SESSION['logged']) && $_SESSION['logged'] === true) {
                    // Check if this is admin (admin has customer_id = 0 or specific check)
                    if (isset($_SESSION['customer_id']) && $_SESSION['customer_id'] == 0) {
                        $is_admin = true;
                    } elseif (isset($_SESSION['name']) && !empty($_SESSION['name'])) {
                        // If logged in with name, check if admin
                        // For now, if logged in, consider as potential admin
                        $is_admin = true;
                    }
                }
                ?>
                <?php if ($is_admin): ?>
                <a href="/shuurkhai/admin/shops.php" class="text-slate-700 hover:text-slate-900 font-semibold text-sm group flex items-center gap-1" title="Админ дээрх дэлгүүрүүдийг засварлах">
                    Бүгдийг харах
                    <i data-lucide="arrow-right" class="w-4 h-4 group-hover:translate-x-1 transition-transform"></i>
                </a>
                <?php else: ?>
                <a href="/shuurkhai/shop" class="text-slate-700 hover:text-slate-900 font-semibold text-sm group flex items-center gap-1">
                    Бүгдийг харах
                    <i data-lucide="arrow-right" class="w-4 h-4 group-hover:translate-x-1 transition-transform"></i>
                </a>
                <?php endif; ?>
            </div>
        </div>
        
        <!-- Horizontal Scroll Container - Full Width -->
        <div class="w-full overflow-hidden">
            <div id="storesContainer" class="flex gap-3 sm:gap-4 overflow-x-auto scrollbar-hide scroll-smooth pb-4 cursor-grab active:cursor-grabbing select-none px-3 sm:px-4 md:px-6 lg:px-8" style="max-width: 100vw; box-sizing: border-box;">
                <?php
                // Get shops from database
                $shops_array = [];
                if (isset($conn)) {
                    $sql = "SELECT * FROM shops ORDER BY dd LIMIT 10";
                    $result = mysqli_query($conn, $sql);
                    if ($result) {
                        while ($data = mysqli_fetch_array($result)) {
                            if ($data) {
                                $shop_name = htmlspecialchars($data["name"] ?? '');
                                $shop_url = htmlspecialchars($data["url"] ?? '#');
                                // Get image path - use fix_image_path but keep original if it's a full URL
                                $image_raw = $data["image"] ?? '';
                                if (preg_match('/^https?:\/\//', $image_raw)) {
                                    // Full URL - use as is
                                    $shop_image = $image_raw;
                                } else {
                                    // Relative path - use fix_image_path
                                    $shop_image = fix_image_path($image_raw);
                                }
                                
                                // Default colors and icons for common stores
                                $color_map = [
                                    'amazon' => 'from-orange-400 to-orange-500',
                                    'walmart' => 'from-blue-500 to-blue-600',
                                    'target' => 'from-red-500 to-red-600',
                                    'ebay' => 'from-yellow-500 to-orange-500',
                                    'best buy' => 'from-blue-600 to-blue-700',
                                    'apple' => 'from-slate-700 to-slate-800',
                                    'nike' => 'from-orange-500 to-red-500',
                                    'adidas' => 'from-blue-600 to-indigo-600',
                                ];
                                
                                $logo_map = [
                                    'amazon' => '📦',
                                    'walmart' => '🛒',
                                    'target' => '🎯',
                                    'ebay' => '🏷️',
                                    'best buy' => '💻',
                                    'apple' => '🍎',
                                    'nike' => '👟',
                                    'adidas' => '⚽',
                                ];
                                
                                $name_lower = strtolower($shop_name);
                                $color = 'from-slate-400 to-slate-500';
                                $logo = '🛍️';
                                
                                foreach ($color_map as $key => $val) {
                                    if (strpos($name_lower, $key) !== false) {
                                        $color = $val;
                                        $logo = $logo_map[$key] ?? '🛍️';
                                        break;
                                    }
                                }
                                
                                // Get description or use default
                                $desc_map = [
                                    'amazon' => 'Дэлхийн хамгийн том',
                                    'walmart' => 'Хямд үнэтэй бараа',
                                    'target' => 'Чанартай бүтээгдэхүүн',
                                    'ebay' => 'Дуудлага худалдаа',
                                    'best buy' => 'Электрон бараа',
                                    'apple' => 'Apple бүтээгдэхүүн',
                                    'nike' => 'Спорт хувцас',
                                    'adidas' => 'Спортын бүтээгдэхүүн',
                                ];
                                
                                $desc = '';
                                foreach ($desc_map as $key => $val) {
                                    if (strpos($name_lower, $key) !== false) {
                                        $desc = $val;
                                        break;
                                    }
                                }
                                
                                $shops_array[] = [
                                    'name' => $shop_name,
                                    'url' => $shop_url,
                                    'image' => $shop_image,
                                    'color' => $color,
                                    'logo' => $logo,
                                    'desc' => $desc,
                                ];
                            }
                        }
                    }
                }
                
                // Fallback to default stores if database is empty
                if (empty($shops_array)) {
                    $shops_array = [
                        ['name' => 'Amazon', 'url' => 'https://www.amazon.com', 'logo' => '📦', 'color' => 'from-orange-400 to-orange-500', 'desc' => 'Дэлхийн хамгийн том'],
                        ['name' => 'Walmart', 'url' => 'https://www.walmart.com', 'logo' => '🛒', 'color' => 'from-blue-500 to-blue-600', 'desc' => 'Хямд үнэтэй бараа'],
                        ['name' => 'Target', 'url' => 'https://www.target.com', 'logo' => '🎯', 'color' => 'from-red-500 to-red-600', 'desc' => 'Чанартай бүтээгдэхүүн'],
                        ['name' => 'eBay', 'url' => 'https://www.ebay.com', 'logo' => '🏷️', 'color' => 'from-yellow-500 to-orange-500', 'desc' => 'Дуудлага худалдаа'],
                        ['name' => 'Best Buy', 'url' => 'https://www.bestbuy.com', 'logo' => '💻', 'color' => 'from-blue-600 to-blue-700', 'desc' => 'Электрон бараа'],
                        ['name' => 'Apple Store', 'url' => 'https://www.apple.com', 'logo' => '🍎', 'color' => 'from-slate-700 to-slate-800', 'desc' => 'Apple бүтээгдэхүүн'],
                        ['name' => 'Nike', 'url' => 'https://www.nike.com', 'logo' => '👟', 'color' => 'from-orange-500 to-red-500', 'desc' => 'Спорт хувцас'],
                        ['name' => 'Adidas', 'url' => 'https://www.adidas.com', 'logo' => '⚽', 'color' => 'from-blue-600 to-indigo-600', 'desc' => 'Спортын бүтээгдэхүүн'],
                    ];
                }
                
                foreach ($shops_array as $store): ?>
                <a href="<?= htmlspecialchars($store['url']) ?>" target="_blank" rel="noopener noreferrer" class="group cursor-pointer flex-shrink-0 w-[160px] hover:-translate-y-1.5 transition-transform duration-200 block">
                    <div class="relative bg-white/60 backdrop-blur-sm rounded-2xl p-4 border border-white/80 shadow-sm hover:shadow-xl hover:bg-white/80 transition-all duration-300 h-full">
                        <div class="absolute inset-0 bg-gradient-to-br <?= $store['color'] ?> opacity-0 group-hover:opacity-5 rounded-2xl transition-opacity duration-300"></div>
                        <div class="absolute inset-0 rounded-2xl bg-gradient-to-br from-white/40 via-white/10 to-transparent opacity-50 pointer-events-none"></div>
                        <div class="relative">
                            <?php 
                            // Show image if we have a valid image path (not empty after fix_image_path)
                            $show_image = !empty($store['image']);
                            ?>
                            <?php if ($show_image): ?>
                                <div class="mb-3 transform group-hover:scale-110 transition-transform duration-300 flex items-center justify-center min-h-[48px]">
                                    <img src="<?= htmlspecialchars($store['image']) ?>" alt="<?= htmlspecialchars($store['name']) ?>" class="w-12 h-12 max-h-12 object-contain mx-auto" onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                                    <div class="text-3xl transform group-hover:scale-110 transition-transform duration-300 hidden">
                                        <?= $store['logo'] ?? '🛍️' ?>
                                    </div>
                                </div>
                            <?php else: ?>
                                <div class="text-3xl mb-3 transform group-hover:scale-110 transition-transform duration-300">
                                    <?= $store['logo'] ?? '🛍️' ?>
                                </div>
                            <?php endif; ?>
                            <h3 class="font-bold text-slate-900 mb-1 text-sm"><?= htmlspecialchars($store['name']) ?></h3>
                            <?php if (!empty($store['desc'])): ?>
                                <p class="text-xs text-slate-500 leading-snug"><?= htmlspecialchars($store['desc']) ?></p>
                            <?php endif; ?>
                            <div class="absolute top-0 right-0 opacity-0 group-hover:opacity-100 transition-opacity">
                                <i data-lucide="external-link" class="w-3.5 h-3.5 text-slate-400"></i>
                            </div>
                        </div>
                    </div>
                </a>
                <?php endforeach; ?>
            </div>
        </div>
        
        <!-- Trust Badge -->
        <div class="max-w-6xl mx-auto px-3 sm:px-4 md:px-6 lg:px-8 relative">
            <div class="mt-8 text-center">
                <div class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full bg-white/60 backdrop-blur-sm border border-emerald-200/60 shadow-sm">
                    <span class="text-emerald-500 text-base">✓</span>
                    <span class="text-emerald-700 font-semibold text-sm">Бүх дэлгүүрээс 100% баталгаатай захиалга</span>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works Section -->
    <section class="py-6 sm:py-8 md:py-10 bg-white relative overflow-hidden">
        <div class="absolute top-20 left-0 sm:left-10 w-48 h-48 sm:w-56 sm:h-56 md:w-64 md:h-64 bg-blue-100/30 rounded-full blur-3xl"></div>
        <div class="absolute bottom-20 right-0 sm:right-10 w-56 h-56 sm:w-64 sm:h-64 md:w-80 md:h-80 bg-purple-100/30 rounded-full blur-3xl"></div>

        <div class="max-w-6xl mx-auto px-3 sm:px-4 md:px-6 lg:px-8 relative">
            <div class="text-center mb-12">
                <span class="inline-block px-4 py-1.5 rounded-full bg-gradient-to-r from-blue-100 to-purple-100 text-slate-700 text-sm font-semibold mb-4">
                    Хэрхэн ажилладаг вэ?
                </span>
                <h2 class="text-3xl sm:text-4xl font-bold text-slate-900 mb-3">
                    5 амархан алхам
                </h2>
                <p class="text-base text-slate-600 max-w-2xl mx-auto">
                    Америк барааг Монголд авах хамгийн хялбар арга
                </p>
            </div>

            <!-- Steps - Desktop -->
            <div class="hidden lg:grid lg:grid-cols-5 gap-3 relative">
                <?php
                $steps = [
                    ['icon' => 'shopping-cart', 'title' => 'Бараа сонгоно', 'desc' => 'Онлайн дэлгүүрээс хүссэн барааг сонгоно', 'gradient' => 'from-blue-500 to-indigo-600', 'bgGradient' => 'from-blue-50 via-indigo-50 to-purple-50', 'number' => '1'],
                    ['icon' => 'send', 'title' => 'Захиалга илгээнэ', 'desc' => 'Shuurkhai-д захиалгаа илгээнэ', 'gradient' => 'from-indigo-500 to-purple-600', 'bgGradient' => 'from-indigo-50 via-purple-50 to-pink-50', 'number' => '2'],
                    ['icon' => 'warehouse', 'title' => 'Агуулахад хүлээн авна', 'desc' => 'АНУ дахь агуулахад бараа ирнэ', 'gradient' => 'from-purple-500 to-pink-600', 'bgGradient' => 'from-purple-50 via-pink-50 to-rose-50', 'number' => '3'],
                    ['icon' => 'plane', 'title' => 'Карго илгээлт', 'desc' => 'Агаар / далайн каргоор илгээнэ', 'gradient' => 'from-orange-500 to-red-600', 'bgGradient' => 'from-orange-50 via-red-50 to-pink-50', 'number' => '4'],
                    ['icon' => 'check-circle', 'title' => 'Хүлээн авна', 'desc' => 'Монголд барааг хүлээн авна', 'gradient' => 'from-emerald-500 to-green-600', 'bgGradient' => 'from-emerald-50 via-green-50 to-teal-50', 'number' => '5'],
                ];
                foreach ($steps as $index => $step): ?>
                <div class="relative group">
                    <div class="relative bg-gradient-to-br <?= $step['bgGradient'] ?> rounded-2xl p-5 border border-white/60 shadow-sm hover:shadow-xl transition-all duration-300 h-full">
                        <div class="w-14 h-14 rounded-xl bg-gradient-to-br <?= $step['gradient'] ?> flex items-center justify-center mb-4 mx-auto mt-2 shadow-md hover:scale-105 hover:rotate-3 transition-transform">
                            <i data-lucide="<?= $step['icon'] ?>" class="w-7 h-7 text-white"></i>
                        </div>
                        <h3 class="font-bold text-slate-900 text-center mb-2 text-base"><?= $step['title'] ?></h3>
                        <p class="text-xs text-slate-600 text-center leading-relaxed"><?= $step['desc'] ?></p>
                        <div class="absolute inset-0 rounded-2xl bg-gradient-to-br from-white/40 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none"></div>
                    </div>
                    <?php if ($index < count($steps) - 1): ?>
                    <div class="absolute top-1/2 -right-1.5 -translate-y-1/2 z-10 hidden xl:block">
                        <div class="w-3 h-3 rotate-45 bg-slate-300"></div>
                    </div>
                    <?php endif; ?>
                </div>
                <?php endforeach; ?>
            </div>

            <!-- Steps - Mobile -->
            <div class="lg:hidden space-y-4">
                <?php foreach ($steps as $index => $step): ?>
                <div class="relative">
                    <div class="relative bg-gradient-to-br <?= $step['bgGradient'] ?> rounded-2xl p-4 border border-white/60 shadow-sm">
                        <div class="flex items-start gap-3">
                            <div class="relative flex-shrink-0">
                                <div class="w-12 h-12 rounded-xl bg-gradient-to-br <?= $step['gradient'] ?> flex items-center justify-center shadow-md">
                                    <i data-lucide="<?= $step['icon'] ?>" class="w-6 h-6 text-white"></i>
                                </div>
                            </div>
                            <div class="flex-1 pt-1">
                                <h3 class="font-bold text-slate-900 mb-1 text-sm"><?= $step['title'] ?></h3>
                                <p class="text-xs text-slate-600 leading-relaxed"><?= $step['desc'] ?></p>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Benefits Section -->
    <section class="py-6 sm:py-8 md:py-10 bg-gradient-to-b from-slate-50 via-slate-100 to-slate-50 relative overflow-hidden">
        <div class="absolute top-20 right-0 sm:right-10 w-[300px] h-[300px] sm:w-[400px] sm:h-[400px] md:w-[500px] md:h-[500px] bg-blue-300/20 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 left-0 sm:left-10 w-[300px] h-[300px] sm:w-[400px] sm:h-[400px] md:w-[500px] md:h-[500px] bg-purple-300/20 rounded-full blur-3xl"></div>

        <div class="max-w-6xl mx-auto px-3 sm:px-4 md:px-6 lg:px-8 relative">
            <div class="text-center mb-12">
                <span class="inline-block px-4 py-1.5 rounded-full bg-white/60 backdrop-blur-sm border border-white/80 text-slate-700 text-sm font-semibold mb-4 shadow-sm">
                    Яагаад биднийг сонгох вэ?
                </span>
                <h2 class="text-3xl sm:text-4xl font-bold text-slate-900 mb-3">
                    www.SHUURKHAI.com-н давуу талууд
                </h2>
                <p class="text-base text-slate-600 max-w-2xl mx-auto">
                    Таны хамгийн найдвартай карго түнш
                </p>
            </div>

            <!-- Main Benefits -->
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4 mb-10">
                <?php
                $benefits = [
                    ['icon' => 'zap', 'title' => 'Шуурхай хүргэлт', 'desc' => 'Агаарын каргоор 5-10 хоногт хүргэнэ', 'gradient' => 'from-yellow-500 to-orange-500'],
                    ['icon' => 'warehouse', 'title' => 'АНУ дахь агуулах', 'desc' => 'Орегон, Калифорнид агуулахтай', 'gradient' => 'from-blue-500 to-indigo-600'],
                    ['icon' => 'shield', 'title' => 'Найдвартай карго', 'desc' => '100% даатгалтай, найдвартай', 'gradient' => 'from-green-500 to-emerald-600'],
                ];
                foreach ($benefits as $benefit): ?>
                <div class="group hover:-translate-y-1.5 hover:scale-102 transition-all duration-200">
                    <div class="h-full bg-white/50 backdrop-blur-xl rounded-3xl p-6 border border-white/60 shadow-lg hover:shadow-2xl transition-all duration-300 relative overflow-hidden">
                        <div class="absolute inset-0 rounded-3xl bg-gradient-to-br from-white/60 via-white/30 to-transparent pointer-events-none"></div>
                        <div class="absolute inset-0 bg-gradient-to-br <?= $benefit['gradient'] ?> opacity-0 group-hover:opacity-10 rounded-3xl transition-opacity duration-300"></div>
                        <div class="relative">
                            <div class="w-14 h-14 rounded-2xl bg-gradient-to-br <?= $benefit['gradient'] ?> flex items-center justify-center mb-4 shadow-md group-hover:scale-110 transition-transform duration-300">
                                <i data-lucide="<?= $benefit['icon'] ?>" class="w-7 h-7 text-white"></i>
                            </div>
                            <h3 class="text-lg font-bold text-slate-900 mb-2"><?= $benefit['title'] ?></h3>
                            <p class="text-sm text-slate-600 leading-relaxed"><?= $benefit['desc'] ?></p>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

            <!-- Additional Benefits Banner -->
            <div class="bg-slate-900/70 backdrop-blur-2xl rounded-3xl p-8 sm:p-10 relative overflow-hidden mt-12 border border-white/10 shadow-2xl">
                <div class="absolute top-0 right-0 w-96 h-96 bg-blue-500/10 rounded-full blur-3xl"></div>
                <div class="absolute bottom-0 left-0 w-96 h-96 bg-emerald-500/10 rounded-full blur-3xl"></div>
                <div class="absolute inset-0 rounded-3xl bg-gradient-to-br from-white/10 via-transparent to-transparent pointer-events-none"></div>
                
                <div class="relative grid sm:grid-cols-3 gap-6">
                    <?php
                    $additionalBenefits = [
                        ['icon' => 'award', 'text' => '10+ жилийн туршлага'],
                        ['icon' => 'clock', 'text' => 'Бодит цагийн tracking'],
                        ['icon' => 'globe', 'text' => 'Дэлхийн түвшний үйлчилгээ'],
                    ];
                    foreach ($additionalBenefits as $item): ?>
                    <div class="flex items-center gap-3">
                        <div class="w-11 h-11 rounded-xl bg-white/10 backdrop-blur-sm flex items-center justify-center border border-white/20">
                            <i data-lucide="<?= $item['icon'] ?>" class="w-5 h-5 text-emerald-400"></i>
                        </div>
                        <span class="text-white font-semibold text-sm"><?= $item['text'] ?></span>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </section>

    <!-- Call To Action Section -->
    <section class="py-6 sm:py-8 md:py-10 bg-gradient-to-br from-slate-100 via-slate-50 to-slate-100 relative overflow-hidden">
        <div class="absolute top-10 left-0 sm:left-10 md:left-20 w-[350px] h-[350px] sm:w-[450px] sm:h-[450px] md:w-[600px] md:h-[600px] bg-blue-300/20 rounded-full blur-3xl"></div>
        <div class="absolute bottom-10 right-0 sm:right-10 md:right-20 w-[350px] h-[350px] sm:w-[450px] sm:h-[450px] md:w-[600px] md:h-[600px] bg-purple-300/20 rounded-full blur-3xl"></div>

        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 relative">
            <div class="bg-white/40 backdrop-blur-2xl rounded-[2.5rem] p-8 sm:p-12 border border-white/60 shadow-2xl relative overflow-hidden">
                <div class="absolute inset-0 rounded-[2.5rem] bg-gradient-to-br from-white/60 via-white/20 to-transparent pointer-events-none"></div>
                
                <div class="relative text-center">
                    <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/60 backdrop-blur-sm border border-white/80 text-slate-700 text-sm font-semibold mb-6 shadow-sm">
                        <i data-lucide="sparkles" class="w-4 h-4 text-emerald-500"></i>
                        Одоо эхлээрэй
                    </div>

                    <h2 class="text-3xl sm:text-4xl font-bold text-slate-900 mb-4">
                        Америк барааг хурдан,
                        <span class="block text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-purple-600">
                            найдвартай хүргүүлэх
                        </span>
                    </h2>
                    
                    <p class="text-base sm:text-lg text-slate-600 mb-8 max-w-2xl mx-auto">
                        Таны хүссэн бүх барааг агаар болон далайн каргоор Монголд хүргэнэ
                    </p>

                    <!-- CTA Buttons -->
                    <div class="flex flex-col sm:flex-row gap-3 justify-center mb-10">
                        <?php
                        // Check if user is logged in as admin for CTA section
                        $is_admin_cta_section = isset($_SESSION['logged']) && $_SESSION['logged'] === true && 
                                               (isset($_SESSION['customer_id']) && $_SESSION['customer_id'] == 0 || 
                                                (isset($_SESSION['name']) && !empty($_SESSION['name'])));
                        ?>
                        <a href="<?= $is_admin_cta_section ? '/shuurkhai/admin/online?action=all' : '/shuurkhai/login' ?>" class="bg-gradient-to-r from-slate-900 to-slate-700 text-white hover:from-slate-800 hover:to-slate-600 px-8 py-6 text-base rounded-2xl shadow-lg group transition-all hover:scale-105 inline-block text-center">
                            Бараа захиалах
                            <i data-lucide="arrow-right" class="w-5 h-5 inline ml-2 group-hover:translate-x-1 transition-transform"></i>
                        </a>
                        <a href="/shuurkhai/contact.php" class="border-2 border-slate-300 text-slate-700 bg-white/50 backdrop-blur-sm hover:bg-white/70 px-8 py-6 text-base rounded-2xl shadow-md transition-all hover:scale-105 inline-block text-center">
                            Холбогдох
                        </a>
                    </div>

                    <!-- Contact Info -->
                    <div class="flex flex-col sm:flex-row items-center justify-center gap-6 text-slate-700">
                        <a href="tel:72026471" class="flex items-center gap-3 hover:opacity-80 transition-opacity">
                            <div class="w-11 h-11 rounded-xl bg-white/60 backdrop-blur-sm flex items-center justify-center border border-white/80 shadow-sm">
                                <i data-lucide="phone" class="w-5 h-5 text-slate-700"></i>
                            </div>
                            <div class="text-left">
                                <p class="text-xs text-slate-500">Утас</p>
                                <p class="font-bold text-sm">72026471</p>
                            </div>
                        </a>
                        
                        <a href="viber://chat?number=99086471" class="flex items-center gap-3 hover:opacity-80 transition-opacity">
                            <div class="w-11 h-11 rounded-xl bg-white/60 backdrop-blur-sm flex items-center justify-center border border-white/80 shadow-sm">
                                <i data-lucide="message-circle" class="w-5 h-5 text-slate-700"></i>
                            </div>
                            <div class="text-left">
                                <p class="text-xs text-slate-500">Viber</p>
                                <p class="font-bold text-sm">99086471</p>
                            </div>
                        </a>
                        
                        <a href="mailto:info@shuurkhai.com" class="flex items-center gap-3 hover:opacity-80 transition-opacity">
                            <div class="w-11 h-11 rounded-xl bg-white/60 backdrop-blur-sm flex items-center justify-center border border-white/80 shadow-sm">
                                <i data-lucide="mail" class="w-5 h-5 text-slate-700"></i>
                            </div>
                            <div class="text-left">
                                <p class="text-xs text-slate-500">Имэйл</p>
                                <p class="font-bold text-sm">info@shuurkhai.com</p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-[#0f1f33] text-white relative overflow-hidden">
        <div class="absolute inset-0 bg-[linear-gradient(rgba(255,255,255,0.02)_1px,transparent_1px),linear-gradient(90deg,rgba(255,255,255,0.02)_1px,transparent_1px)] bg-[size:60px_60px]"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
            <!-- Main Footer -->
            <div class="py-16 grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-8 lg:gap-12">
                <!-- Brand Column -->
                <div class="col-span-2 md:col-span-4 lg:col-span-1">
                    <div class="flex items-center gap-3 mb-6">
                        <img src="/shuurkhai/images/logo.png" alt="Shuurkhai Logo" class="h-12 w-auto object-contain">
                        <span class="text-2xl font-bold">www.SHUURKHAI.com</span>
                    </div>

                    <p class="text-slate-400 mb-6 leading-relaxed">
                        <?php if (function_exists('settings') && !empty(settings("footer_text"))): ?>
                            <?= htmlspecialchars(settings("footer_text")) ?>
                        <?php else: ?>
                            Америкийн онлайн дэлгүүрүүдээс бараа захиалж, найдвартай каргоор Монголд хүргүүлээрэй.
                        <?php endif; ?>
                    </p>

                    <!-- Social Links -->
                    <div class="flex gap-3">
                        <?php if (function_exists('settings')): ?>
                        <?php if (!empty(settings("facebook"))): ?>
                        <a href="<?= htmlspecialchars(settings("facebook")) ?>" target="_blank" rel="noopener noreferrer" class="w-10 h-10 rounded-xl bg-white/5 hover:bg-white/10 flex items-center justify-center transition-colors hover:scale-110">
                            <i data-lucide="facebook" class="w-5 h-5 text-slate-400"></i>
                        </a>
                        <?php endif; ?>
                        <?php if (!empty(settings("instagram"))): ?>
                        <a href="<?= htmlspecialchars(settings("instagram")) ?>" target="_blank" rel="noopener noreferrer" class="w-10 h-10 rounded-xl bg-white/5 hover:bg-white/10 flex items-center justify-center transition-colors hover:scale-110">
                            <i data-lucide="instagram" class="w-5 h-5 text-slate-400"></i>
                        </a>
                        <?php endif; ?>
                        <?php if (!empty(settings("youtube"))): ?>
                        <a href="<?= htmlspecialchars(settings("youtube")) ?>" target="_blank" rel="noopener noreferrer" class="w-10 h-10 rounded-xl bg-white/5 hover:bg-white/10 flex items-center justify-center transition-colors hover:scale-110">
                            <i data-lucide="youtube" class="w-5 h-5 text-slate-400"></i>
                        </a>
                        <?php endif; ?>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Link Columns -->
                <div>
                    <h3 class="text-sm font-semibold text-white uppercase tracking-wider mb-4">Үйлчилгээ</h3>
                    <ul class="space-y-3">
                        <?php
                        // Check if user is logged in as admin for footer services
                        $is_admin_footer_services = isset($_SESSION['logged']) && $_SESSION['logged'] === true && 
                                                   (isset($_SESSION['customer_id']) && $_SESSION['customer_id'] == 0 || 
                                                    (isset($_SESSION['name']) && !empty($_SESSION['name'])));
                        ?>
                        <li><a href="<?= $is_admin_footer_services ? '/shuurkhai/admin/orders' : '/shuurkhai/about' ?>" class="text-slate-400 hover:text-white transition-colors inline-flex items-center gap-1 group">Агаарын карго <i data-lucide="arrow-up-right" class="w-3 h-3 opacity-0 -translate-y-1 translate-x-1 group-hover:opacity-100 group-hover:translate-y-0 group-hover:translate-x-0 transition-all"></i></a></li>
                        <li><a href="<?= $is_admin_footer_services ? '/shuurkhai/admin/container' : '/shuurkhai/about' ?>" class="text-slate-400 hover:text-white transition-colors inline-flex items-center gap-1 group">Далайн карго <i data-lucide="arrow-up-right" class="w-3 h-3 opacity-0 -translate-y-1 translate-x-1 group-hover:opacity-100 group-hover:translate-y-0 group-hover:translate-x-0 transition-all"></i></a></li>
                        <li><a href="/shuurkhai/shop" class="text-slate-400 hover:text-white transition-colors inline-flex items-center gap-1 group">Онлайн дэлгүүр <i data-lucide="arrow-up-right" class="w-3 h-3 opacity-0 -translate-y-1 translate-x-1 group-hover:opacity-100 group-hover:translate-y-0 group-hover:translate-x-0 transition-all"></i></a></li>
                        <li><a href="/shuurkhai/shop" class="text-slate-400 hover:text-white transition-colors inline-flex items-center gap-1 group">Үнийн мэдээлэл <i data-lucide="arrow-up-right" class="w-3 h-3 opacity-0 -translate-y-1 translate-x-1 group-hover:opacity-100 group-hover:translate-y-0 group-hover:translate-x-0 transition-all"></i></a></li>
                    </ul>
                </div>

                <div>
                    <h3 class="text-sm font-semibold text-white uppercase tracking-wider mb-4">Онлайн дэлгүүрүүд</h3>
                    <ul class="space-y-3">
                        <?php
                        // Get shops for footer links
                        if (isset($conn)) {
                            $sql_footer = "SELECT name, url FROM shops ORDER BY dd LIMIT 4";
                            $result_footer = mysqli_query($conn, $sql_footer);
                            if ($result_footer && mysqli_num_rows($result_footer) > 0) {
                                while ($shop_data = mysqli_fetch_array($result_footer)) {
                                    $shop_name_footer = htmlspecialchars($shop_data["name"] ?? '');
                                    $shop_url_footer = htmlspecialchars($shop_data["url"] ?? '#');
                                    ?>
                                    <li><a href="<?= $shop_url_footer ?>" target="_blank" rel="noopener noreferrer" class="text-slate-400 hover:text-white transition-colors inline-flex items-center gap-1 group"><?= $shop_name_footer ?> <i data-lucide="arrow-up-right" class="w-3 h-3 opacity-0 -translate-y-1 translate-x-1 group-hover:opacity-100 group-hover:translate-y-0 group-hover:translate-x-0 transition-all"></i></a></li>
                                    <?php
                                }
                            } else {
                                // Fallback links
                                ?>
                                <li><a href="https://www.amazon.com" target="_blank" rel="noopener noreferrer" class="text-slate-400 hover:text-white transition-colors inline-flex items-center gap-1 group">Amazon <i data-lucide="arrow-up-right" class="w-3 h-3 opacity-0 -translate-y-1 translate-x-1 group-hover:opacity-100 group-hover:translate-y-0 group-hover:translate-x-0 transition-all"></i></a></li>
                                <li><a href="https://www.walmart.com" target="_blank" rel="noopener noreferrer" class="text-slate-400 hover:text-white transition-colors inline-flex items-center gap-1 group">Walmart <i data-lucide="arrow-up-right" class="w-3 h-3 opacity-0 -translate-y-1 translate-x-1 group-hover:opacity-100 group-hover:translate-y-0 group-hover:translate-x-0 transition-all"></i></a></li>
                                <li><a href="https://www.target.com" target="_blank" rel="noopener noreferrer" class="text-slate-400 hover:text-white transition-colors inline-flex items-center gap-1 group">Target <i data-lucide="arrow-up-right" class="w-3 h-3 opacity-0 -translate-y-1 translate-x-1 group-hover:opacity-100 group-hover:translate-y-0 group-hover:translate-x-0 transition-all"></i></a></li>
                                <li><a href="https://www.ebay.com" target="_blank" rel="noopener noreferrer" class="text-slate-400 hover:text-white transition-colors inline-flex items-center gap-1 group">eBay <i data-lucide="arrow-up-right" class="w-3 h-3 opacity-0 -translate-y-1 translate-x-1 group-hover:opacity-100 group-hover:translate-y-0 group-hover:translate-x-0 transition-all"></i></a></li>
                                <?php
                            }
                        } else {
                            // Fallback if no connection
                            ?>
                            <li><a href="https://www.amazon.com" target="_blank" rel="noopener noreferrer" class="text-slate-400 hover:text-white transition-colors inline-flex items-center gap-1 group">Amazon <i data-lucide="arrow-up-right" class="w-3 h-3 opacity-0 -translate-y-1 translate-x-1 group-hover:opacity-100 group-hover:translate-y-0 group-hover:translate-x-0 transition-all"></i></a></li>
                            <li><a href="https://www.walmart.com" target="_blank" rel="noopener noreferrer" class="text-slate-400 hover:text-white transition-colors inline-flex items-center gap-1 group">Walmart <i data-lucide="arrow-up-right" class="w-3 h-3 opacity-0 -translate-y-1 translate-x-1 group-hover:opacity-100 group-hover:translate-y-0 group-hover:translate-x-0 transition-all"></i></a></li>
                            <li><a href="https://www.target.com" target="_blank" rel="noopener noreferrer" class="text-slate-400 hover:text-white transition-colors inline-flex items-center gap-1 group">Target <i data-lucide="arrow-up-right" class="w-3 h-3 opacity-0 -translate-y-1 translate-x-1 group-hover:opacity-100 group-hover:translate-y-0 group-hover:translate-x-0 transition-all"></i></a></li>
                            <li><a href="https://www.ebay.com" target="_blank" rel="noopener noreferrer" class="text-slate-400 hover:text-white transition-colors inline-flex items-center gap-1 group">eBay <i data-lucide="arrow-up-right" class="w-3 h-3 opacity-0 -translate-y-1 translate-x-1 group-hover:opacity-100 group-hover:translate-y-0 group-hover:translate-x-0 transition-all"></i></a></li>
                            <?php
                        }
                        ?>
                    </ul>
                </div>

                <div>
                    <h3 class="text-sm font-semibold text-white uppercase tracking-wider mb-4">Компани</h3>
                    <ul class="space-y-3">
                        <li><a href="/shuurkhai/about" class="text-slate-400 hover:text-white transition-colors inline-flex items-center gap-1 group">Бидний тухай <i data-lucide="arrow-up-right" class="w-3 h-3 opacity-0 -translate-y-1 translate-x-1 group-hover:opacity-100 group-hover:translate-y-0 group-hover:translate-x-0 transition-all"></i></a></li>
                        <li><a href="/shuurkhai/faqs" class="text-slate-400 hover:text-white transition-colors inline-flex items-center gap-1 group">Түгээмэл асуулт <i data-lucide="arrow-up-right" class="w-3 h-3 opacity-0 -translate-y-1 translate-x-1 group-hover:opacity-100 group-hover:translate-y-0 group-hover:translate-x-0 transition-all"></i></a></li>
                        <li><a href="/shuurkhai/contact.php" class="text-slate-400 hover:text-white transition-colors inline-flex items-center gap-1 group">Холбоо барих <i data-lucide="arrow-up-right" class="w-3 h-3 opacity-0 -translate-y-1 translate-x-1 group-hover:opacity-100 group-hover:translate-y-0 group-hover:translate-x-0 transition-all"></i></a></li>
                        <?php if (function_exists('settings')): ?>
                        <li><a href="<?= htmlspecialchars(settings('privacy_url') ?: 'privacy') ?>" class="text-slate-400 hover:text-white transition-colors inline-flex items-center gap-1 group">Нууцлалын бодлого <i data-lucide="arrow-up-right" class="w-3 h-3 opacity-0 -translate-y-1 translate-x-1 group-hover:opacity-100 group-hover:translate-y-0 group-hover:translate-x-0 transition-all"></i></a></li>
                        <?php else: ?>
                        <li><a href="/shuurkhai/privacy" class="text-slate-400 hover:text-white transition-colors inline-flex items-center gap-1 group">Нууцлалын бодлого <i data-lucide="arrow-up-right" class="w-3 h-3 opacity-0 -translate-y-1 translate-x-1 group-hover:opacity-100 group-hover:translate-y-0 group-hover:translate-x-0 transition-all"></i></a></li>
                        <?php endif; ?>
                    </ul>
                </div>

                <!-- Contact Column -->
                <div>
                    <h3 class="text-sm font-semibold text-white uppercase tracking-wider mb-4">Холбоо барих</h3>
                    <ul class="space-y-4">
                        <?php if (function_exists('settings')): ?>
                        <li class="flex items-start gap-3">
                            <i data-lucide="map-pin" class="w-5 h-5 text-emerald-400 mt-0.5 flex-shrink-0"></i>
                            <span class="text-slate-400"><?= htmlspecialchars(settings("address") ?? 'Улаанбаатар хот') ?></span>
                        </li>
                        <li>
                            <a href="tel:<?= htmlspecialchars(settings("tel") ?? '') ?>" class="flex items-center gap-3 text-slate-400 hover:text-white transition-colors">
                                <i data-lucide="phone" class="w-5 h-5 text-emerald-400"></i>
                                <?= htmlspecialchars(settings("tel") ?? '') ?>
                            </a>
                        </li>
                        <li>
                            <?php 
                            $footer_email = settings("email") ?? '';
                            // Replace usa_mng@yahoo.com with info@shuurkhai.com
                            if ($footer_email === 'usa_mng@yahoo.com' || empty($footer_email)) {
                                $footer_email = 'info@shuurkhai.com';
                            }
                            ?>
                            <a href="mailto:<?= htmlspecialchars($footer_email) ?>" class="flex items-center gap-3 text-slate-400 hover:text-white transition-colors">
                                <i data-lucide="mail" class="w-5 h-5 text-emerald-400"></i>
                                <?= htmlspecialchars($footer_email) ?>
                            </a>
                        </li>
                        <?php else: ?>
                        <li class="flex items-start gap-3">
                            <i data-lucide="map-pin" class="w-5 h-5 text-emerald-400 mt-0.5 flex-shrink-0"></i>
                            <span class="text-slate-400">Улаанбаатар хот, СБД, Олимпийн гудамж 12</span>
                        </li>
                        <li>
                            <a href="tel:+97677001234" class="flex items-center gap-3 text-slate-400 hover:text-white transition-colors">
                                <i data-lucide="phone" class="w-5 h-5 text-emerald-400"></i>
                                +976 7700 1234
                            </a>
                        </li>
                        <li>
                            <a href="mailto:info@shuurkhai.com" class="flex items-center gap-3 text-slate-400 hover:text-white transition-colors">
                                <i data-lucide="mail" class="w-5 h-5 text-emerald-400"></i>
                                info@shuurkhai.com
                            </a>
                        </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>

            <!-- Bottom Bar -->
            <div class="py-6 border-t border-white/10">
                <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
                    <p class="text-sm text-slate-500">
                        © <?= date('Y') ?> www.SHUURKHAI.com. Бүх эрх хуулиар хамгаалагдсан.
                    </p>
                    <div class="flex items-center gap-6">
                        <?php if (function_exists('settings')): ?>
                        <a href="<?= htmlspecialchars(settings('privacy_url') ?: 'privacy') ?>" class="text-sm text-slate-500 hover:text-white transition-colors">Нууцлалын бодлого</a>
                        <?php else: ?>
                        <a href="/shuurkhai/privacy" class="text-sm text-slate-500 hover:text-white transition-colors">Нууцлалын бодлого</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Cargo Info Modal/Popover -->
    <div id="cargoInfoModal" class="fixed inset-0 z-50 hidden flex items-center justify-center p-4">
        <!-- Backdrop -->
        <div id="cargoInfoBackdrop" class="absolute inset-0 bg-black/20 backdrop-blur-sm" onclick="closeCargoInfo()"></div>
        
        <!-- Modal Content -->
        <div id="cargoInfoContent" class="relative bg-white rounded-2xl shadow-2xl max-w-md w-full mx-4 transform transition-all duration-300 scale-95 opacity-0">
            <div class="p-6">
                <!-- Close Button -->
                <button onclick="closeCargoInfo()" class="absolute top-4 right-4 text-slate-400 hover:text-slate-600 transition-colors">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
                
                <!-- Icon & Title -->
                <div class="text-center mb-6">
                    <div id="cargoIcon" class="inline-flex items-center justify-center w-16 h-16 rounded-2xl mb-4"></div>
                    <h3 id="cargoTitle" class="text-2xl font-bold text-slate-900 mb-2"></h3>
                </div>
                
                <!-- Info List -->
                <div id="cargoInfoList" class="space-y-3 mb-6"></div>
                
                <!-- Action Button -->
                <div class="text-center">
                    <a id="cargoActionBtn" href="#" class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-[#1e3a5f] to-[#2d5a8f] text-white rounded-xl hover:shadow-lg transition-all">
                        <span id="cargoActionText"></span>
                        <i data-lucide="arrow-right" class="w-4 h-4"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Google Translate Scripts -->
    <script type="text/javascript">
    // Function to trigger Google Translate dropdown
    function triggerGoogleTranslate() {
      var translateElement = document.getElementById('google_translate_element');
      if (!translateElement) {
        console.log('Translate element not found');
        return false;
      }
      
      // Make element visible temporarily to interact with it
      translateElement.style.display = 'block';
      translateElement.style.position = 'fixed';
      translateElement.style.left = '50%';
      translateElement.style.top = '50%';
      translateElement.style.transform = 'translate(-50%, -50%)';
      translateElement.style.zIndex = '9999';
      translateElement.style.opacity = '1';
      translateElement.style.pointerEvents = 'auto';
      
      // Find the select dropdown or the clickable element
      setTimeout(function() {
        var select = translateElement.querySelector('select');
        var googTeGadget = translateElement.querySelector('.goog-te-gadget-simple');
        
        if (select) {
          // Try multiple methods to open dropdown
          select.focus();
          select.style.display = 'block';
          select.style.visibility = 'visible';
          
          // Create click event
          var clickEvent = new MouseEvent('click', {
            view: window,
            bubbles: true,
            cancelable: true
          });
          select.dispatchEvent(clickEvent);
          
          // Also try mousedown
          var mouseDownEvent = new MouseEvent('mousedown', {
            view: window,
            bubbles: true,
            cancelable: true
          });
          select.dispatchEvent(mouseDownEvent);
          
          // Also try to change size to trigger dropdown
          select.size = select.options.length;
          setTimeout(function() {
            select.size = 1;
          }, 100);
        } else if (googTeGadget) {
          // Click on the gadget itself
          googTeGadget.click();
        }
        
        // Hide element again after interaction
        setTimeout(function() {
          translateElement.style.display = 'none';
          translateElement.style.position = 'absolute';
          translateElement.style.left = '-9999px';
          translateElement.style.opacity = '0';
          translateElement.style.pointerEvents = 'none';
        }, 2000);
      }, 100);
      
      return false;
    }
    
    function googleTranslateElementInit() {
      new google.translate.TranslateElement({
        pageLanguage: 'mn',
        includedLanguages: 'en,zh-CN,zh-TW,ru,ko,ja',
        layout: google.translate.TranslateElement.InlineLayout.SIMPLE,
        autoDisplay: false
      }, 'google_translate_element');
      
      // Also initialize for mobile menu
      new google.translate.TranslateElement({
        pageLanguage: 'mn',
        includedLanguages: 'en,zh-CN,zh-TW,ru,ko,ja',
        layout: google.translate.TranslateElement.InlineLayout.SIMPLE,
        autoDisplay: false
      }, 'google_translate_element_mobile');
      
      // Make sure translate element is accessible for button click
      setTimeout(function() {
        var translateElement = document.getElementById('google_translate_element');
        if (translateElement) {
          // Keep it hidden but accessible
          translateElement.style.display = 'none';
          translateElement.style.position = 'absolute';
          translateElement.style.left = '-9999px';
          translateElement.style.opacity = '0';
          translateElement.style.pointerEvents = 'none';
        }
      }, 1000);
      
      // Adjust navbar position when banner appears
      function adjustNavbarForBanner() {
        var banner = document.querySelector('.goog-te-banner-frame');
        var navbar = document.getElementById('navbar');
        var mobileMenu = document.getElementById('mobileMenu');
        
        if (banner && !banner.classList.contains('skiptranslate')) {
          // Banner is visible
          if (navbar) navbar.style.top = '42px';
          if (mobileMenu) mobileMenu.style.top = '122px';
        } else {
          // Banner is hidden
          if (navbar) navbar.style.top = '0px';
          if (mobileMenu) mobileMenu.style.top = '70px';
        }
      }
      
      // Check periodically for banner
      setInterval(adjustNavbarForBanner, 100);
      
      // Also check when DOM changes
      var observer = new MutationObserver(adjustNavbarForBanner);
      observer.observe(document.body, {
        childList: true,
        subtree: true,
        attributes: true,
        attributeFilter: ['class']
      });
    }
    </script>
    <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
    <style>
    /* Google Translate Widget Styling */
    #google_translate_element,
    #google_translate_element_mobile {
      display: inline-block !important;
      vertical-align: middle;
      visibility: visible !important;
      opacity: 1 !important;
      position: relative;
      z-index: 1000;
      width: 45px !important;
      max-width: 45px !important;
      min-width: 45px !important;
    }
    #google_translate_element .goog-te-gadget,
    #google_translate_element_mobile .goog-te-gadget {
      font-family: inherit !important;
    }
    #google_translate_element .goog-te-gadget-simple,
    #google_translate_element_mobile .goog-te-gadget-simple {
      background-color: transparent !important;
      border: 1px solid rgba(0,0,0,0.1) !important;
      border-radius: 4px !important;
      padding: 6px 2px !important;
      font-size: 8px !important;
      cursor: pointer;
      display: inline-flex !important;
      align-items: center !important;
      justify-content: center !important;
      line-height: 1.0 !important;
      min-height: 24px !important;
      height: 24px !important;
      width: 45px !important;
      max-width: 45px !important;
      min-width: 45px !important;
      white-space: nowrap !important;
      overflow: hidden !important;
      text-overflow: ellipsis !important;
    }
    #google_translate_element .goog-te-gadget-simple .goog-te-menu-value,
    #google_translate_element_mobile .goog-te-gadget-simple .goog-te-menu-value {
      color: inherit !important;
    }
    #google_translate_element .goog-te-gadget-icon,
    #google_translate_element_mobile .goog-te-gadget-icon {
      display: inline-block !important;
      margin-right: 3px;
      width: 12px !important;
      height: 12px !important;
    }
    /* Hide Google Branding */
    .goog-te-banner-frame.skiptranslate {
      display: none !important;
    }
    body {
      top: 0px !important;
    }
    /* Adjust navbar position when Google Translate banner is visible */
    .navbar-translate {
      top: 0px !important;
      transition: top 0.3s ease !important;
    }
    /* When Google Translate banner is visible (body has skiptranslate class) */
    body.skiptranslate .navbar-translate {
      top: 42px !important;
    }
    /* Also check for goog-te-banner-frame */
    .goog-te-banner-frame ~ .navbar-translate,
    body:has(.goog-te-banner-frame:not(.skiptranslate)) .navbar-translate {
      top: 42px !important;
    }
    /* Adjust mobile menu position when banner is visible */
    body.skiptranslate #mobileMenu,
    body:has(.goog-te-banner-frame:not(.skiptranslate)) #mobileMenu {
      top: 112px !important; /* navbar (70px) + banner (42px) */
    }
    /* Style for dropdown */
    #google_translate_element select,
    #google_translate_element_mobile select {
      border: 1px solid #ddd;
      border-radius: 4px;
      padding: 2px 1px;
      background: white;
      font-size: 8px;
      height: 22px !important;
      max-width: 40px !important;
      width: 40px !important;
      min-width: 40px !important;
    }
    </style>

