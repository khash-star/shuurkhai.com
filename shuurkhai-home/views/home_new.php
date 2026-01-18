    
    <!-- Navbar -->
    <nav id="navbar" class="fixed top-0 left-0 right-0 z-50 transition-all duration-300 bg-transparent">
        <div class="max-w-7xl mx-auto px-3 sm:px-4 md:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                <!-- Logo -->
                <a href="/shuurkhai/" class="flex items-center gap-3 hover:scale-105 transition-transform">
                    <div class="w-11 h-11 rounded-xl bg-slate-900 flex items-center justify-center shadow-sm">
                        <div class="flex">
                            <i data-lucide="plane" class="w-4 h-4 text-white -rotate-45"></i>
                            <i data-lucide="ship" class="w-4 h-4 text-emerald-400 -ml-0.5"></i>
                        </div>
                    </div>
                    <span class="text-xl font-bold text-slate-900">www.SHUURKHAI.com</span>
                </a>

                <!-- Desktop Navigation -->
                <div class="hidden lg:flex items-center gap-8">
                    <a href="/shuurkhai/" class="flex items-center gap-1 font-medium transition-colors text-slate-700 hover:text-[#1e3a5f]">Нүүр</a>
                    <div class="relative group">
                        <a href="javascript:void(0);" class="flex items-center gap-1 font-medium transition-colors text-slate-700 hover:text-[#1e3a5f]">
                            Үйлчилгээ
                            <i data-lucide="chevron-down" class="w-4 h-4"></i>
                        </a>
                        <div class="absolute top-full left-0 pt-4 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200">
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
                                <a href="/shuurkhai/user/" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-slate-50 transition-colors">
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
                    <a href="/shuurkhai/shop" class="font-medium transition-colors text-slate-700 hover:text-[#1e3a5f]">Үнийн мэдээлэл</a>
                    <a href="/shuurkhai/contact.php" class="font-medium transition-colors text-slate-700 hover:text-[#1e3a5f]">Холбоо барих</a>
                </div>

                <!-- CTA Buttons -->
                <div class="hidden lg:flex items-center gap-4">
                    <a href="/shuurkhai/user/" class="px-4 py-2 rounded-xl text-slate-700 hover:bg-slate-50 transition-colors flex items-center gap-2" title="Нэвтрэх">
                        <i data-lucide="user" class="w-4 h-4"></i>
                        Нэвтрэх
                    </a>
                    <a href="/shuurkhai/calculator" class="px-4 py-2 rounded-xl text-slate-700 hover:bg-slate-50 transition-colors flex items-center gap-2">
                        <i data-lucide="calculator" class="w-4 h-4"></i>
                        Үнэ тооцоолох
                    </a>
                    <?php
                    // Check if user is logged in as admin
                    $is_admin = isset($_SESSION['logged']) && $_SESSION['logged'] === true && 
                                (isset($_SESSION['customer_id']) && $_SESSION['customer_id'] == 0 || 
                                 (isset($_SESSION['name']) && !empty($_SESSION['name'])));
                    ?>
                    <a href="<?= $is_admin ? '/shuurkhai/admin/online?action=all' : '/shuurkhai/user/' ?>" class="bg-slate-900 hover:bg-slate-800 text-white px-6 py-2 rounded-xl shadow-sm transition-colors inline-block">
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
    <div id="mobileMenu" class="fixed inset-x-0 top-20 z-40 lg:hidden hidden">
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
                    <a href="/shuurkhai/shop" class="block px-4 py-3 rounded-xl text-slate-700 font-medium hover:bg-slate-50 transition-colors">Үнийн мэдээлэл</a>
                    <a href="/shuurkhai/contact.php" class="block px-4 py-3 rounded-xl text-slate-700 font-medium hover:bg-slate-50 transition-colors">Холбоо барих</a>
                </div>
                <div class="mt-6 pt-6 border-t border-slate-100 space-y-3">
                    <a href="/shuurkhai/user/" class="block w-full text-center px-4 py-2 rounded-xl border border-slate-200 hover:bg-slate-50 transition-colors" title="Нэвтрэх">
                        <i data-lucide="user" class="w-4 h-4 inline mr-2"></i>
                        Нэвтрэх
                    </a>
                    <a href="/shuurkhai/calculator" class="block w-full text-center px-4 py-2 rounded-xl border border-slate-200 hover:bg-slate-50 transition-colors">
                        <i data-lucide="calculator" class="w-4 h-4 inline mr-2"></i>
                        Үнэ тооцоолох
                    </a>
                    <?php
                    // Check if user is logged in as admin
                    $is_admin_mobile_btn = isset($_SESSION['logged']) && $_SESSION['logged'] === true && 
                                          (isset($_SESSION['customer_id']) && $_SESSION['customer_id'] == 0 || 
                                           (isset($_SESSION['name']) && !empty($_SESSION['name'])));
                    ?>
                    <a href="<?= $is_admin_mobile_btn ? '/shuurkhai/admin/online?action=all' : '/shuurkhai/user/' ?>" class="w-full bg-gradient-to-r from-[#1e3a5f] to-[#2d5a8f] text-white rounded-xl py-2 inline-block text-center">
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
    <section class="relative w-full h-[50vh] sm:h-[60vh] md:h-[70vh] lg:h-screen max-h-[100vh] overflow-x-hidden overflow-y-hidden mt-16">
        <div id="heroSlider" class="relative w-full h-full overflow-hidden">
            <?php foreach ($slider_images as $index => $slide): ?>
            <div class="hero-slide <?php echo $index === 0 ? 'active' : ''; ?>" style="display: <?php echo $index === 0 ? 'block' : 'none'; ?>; position: absolute; top: 0; left: 0; width: 100%; height: 100%; overflow: hidden;">
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
                <img src="<?php echo htmlspecialchars($slide['image']); ?>" alt="<?php echo htmlspecialchars($slide['name'] ?: 'Slider ' . ($index + 1)); ?>" class="absolute inset-0 w-full h-full object-cover object-center z-0" style="width: 100%; height: 100%; object-fit: cover; object-position: center; min-width: 100%;">
                <?php if (!empty($slide['name']) || !empty($slide['text'])): ?>
                <div class="absolute bottom-0 left-0 right-0 p-4 sm:p-6 md:p-8 text-slate-900 bg-gradient-to-t from-white/95 via-white/80 to-transparent z-20 pointer-events-none">
                    <?php if (!empty($slide['name'])): ?>
                    <h3 class="text-2xl sm:text-3xl font-bold mb-2"><?php echo $slide['name']; ?></h3>
                    <?php endif; ?>
                    <?php if (!empty($slide['text'])): ?>
                    <p class="text-base sm:text-lg opacity-90"><?php echo $slide['text']; ?></p>
                    <?php endif; ?>
                </div>
                <?php endif; ?>
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

    <!-- Hero Section -->
    <section class="relative min-h-[90vh] flex items-center overflow-hidden bg-white <?php echo empty($slider_images) ? 'pt-16' : ''; ?>">
        <!-- Background Elements -->
        <div class="absolute inset-0 overflow-hidden">
            <div class="absolute top-20 left-0 sm:left-10 w-[300px] h-[300px] sm:w-[400px] sm:h-[400px] md:w-[500px] md:h-[500px] bg-blue-500/5 rounded-full blur-3xl"></div>
            <div class="absolute bottom-20 right-0 sm:right-10 w-[350px] h-[350px] sm:w-[500px] sm:h-[500px] md:w-[600px] md:h-[600px] bg-emerald-500/5 rounded-full blur-3xl"></div>
        </div>

        <!-- Subtle Grid Pattern -->
        <div class="absolute inset-0 bg-[linear-gradient(rgba(0,0,0,0.01)_1px,transparent_1px),linear-gradient(90deg,rgba(0,0,0,0.01)_1px,transparent_1px)] bg-[size:80px_80px]"></div>

        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-10 md:py-12">
            <div class="grid lg:grid-cols-2 gap-6 sm:gap-8 md:gap-12 lg:gap-20 items-center">
                <!-- Left Content -->
                <div>
                    <p class="text-lg sm:text-xl text-slate-600 mb-8 leading-relaxed max-w-xl">
                        Amazon, Walmart болон бусад дэлгүүрээс захиалаад агаар болон далайн каргоор шуурхай хүргүүлээрэй
                    </p>

                    <div class="flex flex-col sm:flex-row gap-4">
                        <?php
                        // Check if user is logged in as admin for hero section
                        $is_admin_hero_section = isset($_SESSION['logged']) && $_SESSION['logged'] === true && 
                                                (isset($_SESSION['customer_id']) && $_SESSION['customer_id'] == 0 || 
                                                 (isset($_SESSION['name']) && !empty($_SESSION['name'])));
                        ?>
                        <a href="<?= $is_admin_hero_section ? '/shuurkhai/admin/online?action=all' : '/shuurkhai/user/' ?>" class="w-full sm:w-auto bg-slate-900 hover:bg-slate-800 text-white px-8 py-6 text-lg rounded-2xl shadow-lg shadow-slate-900/10 group transition-all inline-block text-center">
                            Бараа захиалах
                            <i data-lucide="arrow-right" class="w-5 h-5 inline ml-2 group-hover:translate-x-1 transition-transform"></i>
                        </a>
                        <a href="/shuurkhai/calculator" class="w-full sm:w-auto border-2 border-slate-200 text-slate-700 hover:bg-slate-50 px-8 py-6 text-lg rounded-2xl transition-colors inline-block text-center">
                            Карго үнийн тооцоо
                        </a>
                    </div>
                </div>

                <!-- Right Visual -->
                <div class="relative hidden lg:block">
                    <div class="relative w-full aspect-square max-w-lg mx-auto">
                        <!-- Main Circle -->
                        <div class="absolute inset-0 rounded-full bg-gradient-to-br from-slate-50 to-slate-100/50 border border-slate-200"></div>
                        
                        <!-- Floating Icons -->
                        <div class="absolute top-12 left-1/2 -translate-x-1/2 p-6 bg-white rounded-3xl shadow-xl shadow-slate-200/50 border border-slate-100 animate-float">
                            <i data-lucide="plane" class="w-12 h-12 text-blue-600"></i>
                        </div>

                        <div class="absolute bottom-20 left-8 p-5 bg-white rounded-2xl shadow-lg shadow-slate-200/50 border border-slate-100 animate-float-reverse">
                            <i data-lucide="ship" class="w-10 h-10 text-emerald-600"></i>
                        </div>

                        <div class="absolute bottom-32 right-8 p-4 bg-gradient-to-br from-slate-900 to-slate-700 rounded-2xl shadow-xl shadow-slate-900/20 animate-float">
                            <i data-lucide="package" class="w-8 h-8 text-white"></i>
                        </div>

                        <!-- Center Globe Illustration -->
                        <div class="absolute inset-12 rounded-full bg-gradient-to-br from-slate-900 via-slate-800 to-slate-700 flex items-center justify-center shadow-2xl">
                            <div class="text-center text-white p-8">
                                <div class="text-5xl font-bold mb-2">🌏</div>
                                <div class="text-sm font-medium opacity-80">USA → Mongolia</div>
                            </div>
                            <!-- Orbit Ring -->
                            <div class="absolute inset-0 rounded-full border-2 border-dashed border-white/20 animate-spin-slow"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

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
                        <div class="absolute -top-3 -left-3 z-20">
                            <div class="w-9 h-9 rounded-xl bg-gradient-to-br <?= $step['gradient'] ?> shadow-lg flex items-center justify-center">
                                <span class="text-white font-bold text-base"><?= $step['number'] ?></span>
                            </div>
                        </div>
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
                                <div class="absolute -top-2 -left-2 z-10">
                                    <div class="w-7 h-7 rounded-lg bg-gradient-to-br <?= $step['gradient'] ?> shadow-md flex items-center justify-center">
                                        <span class="text-white font-bold text-sm"><?= $step['number'] ?></span>
                                    </div>
                                </div>
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
                    Shuurkhai-н давуу талууд
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
                        <a href="<?= $is_admin_cta_section ? '/shuurkhai/admin/online?action=all' : '/shuurkhai/user/' ?>" class="bg-gradient-to-r from-slate-900 to-slate-700 text-white hover:from-slate-800 hover:to-slate-600 px-8 py-6 text-base rounded-2xl shadow-lg group transition-all hover:scale-105 inline-block text-center">
                            Бараа захиалах
                            <i data-lucide="arrow-right" class="w-5 h-5 inline ml-2 group-hover:translate-x-1 transition-transform"></i>
                        </a>
                        <a href="/shuurkhai/contact.php" class="border-2 border-slate-300 text-slate-700 bg-white/50 backdrop-blur-sm hover:bg-white/70 px-8 py-6 text-base rounded-2xl shadow-md transition-all hover:scale-105 inline-block text-center">
                            Холбогдох
                        </a>
                    </div>

                    <!-- Contact Info -->
                    <div class="flex flex-col sm:flex-row items-center justify-center gap-6 text-slate-700">
                        <a href="tel:+97677001234" class="flex items-center gap-3 hover:opacity-80 transition-opacity">
                            <div class="w-11 h-11 rounded-xl bg-white/60 backdrop-blur-sm flex items-center justify-center border border-white/80 shadow-sm">
                                <i data-lucide="phone" class="w-5 h-5 text-slate-700"></i>
                            </div>
                            <div class="text-left">
                                <p class="text-xs text-slate-500">Утас</p>
                                <p class="font-bold text-sm">+976 7700 1234</p>
                            </div>
                        </a>
                        
                        <a href="mailto:info@shuurkhai.mn" class="flex items-center gap-3 hover:opacity-80 transition-opacity">
                            <div class="w-11 h-11 rounded-xl bg-white/60 backdrop-blur-sm flex items-center justify-center border border-white/80 shadow-sm">
                                <i data-lucide="mail" class="w-5 h-5 text-slate-700"></i>
                            </div>
                            <div class="text-left">
                                <p class="text-xs text-slate-500">Имэйл</p>
                                <p class="font-bold text-sm">info@shuurkhai.mn</p>
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
                        <div class="w-12 h-12 rounded-2xl bg-white/10 flex items-center justify-center">
                            <div class="flex">
                                <i data-lucide="plane" class="w-5 h-5 text-white -rotate-45"></i>
                                <i data-lucide="ship" class="w-5 h-5 text-emerald-400 -ml-1"></i>
                            </div>
                        </div>
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
                            <a href="mailto:<?= htmlspecialchars(settings("email") ?? '') ?>" class="flex items-center gap-3 text-slate-400 hover:text-white transition-colors">
                                <i data-lucide="mail" class="w-5 h-5 text-emerald-400"></i>
                                <?= htmlspecialchars(settings("email") ?? '') ?>
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
                            <a href="mailto:info@shuurkhai.mn" class="flex items-center gap-3 text-slate-400 hover:text-white transition-colors">
                                <i data-lucide="mail" class="w-5 h-5 text-emerald-400"></i>
                                info@shuurkhai.mn
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
                        © <?= date('Y') ?> Shuurkhai. Бүх эрх хуулиар хамгаалагдсан.
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

