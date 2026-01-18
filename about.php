<?php require_once("config.php");?>
<?php require_once("views/helper.php");?>
<!DOCTYPE html>
<html lang="mn">
<head>
    <!-- Base URL for relative paths -->
    <base href="/shuurkhai/">
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1, shrink-to-fit=no" name="viewport">
    <title>Бидний тухай - Shuurkhai</title>
    <!-- Bundle -->
    <link href="assets/vendor/css/bundle.min.css" rel="stylesheet">
    <!-- Plugin Css -->
    <link href="assets/css/line-awesome.min.css" rel="stylesheet">
    <link href="assets/vendor/css/revolution-settings.min.css" rel="stylesheet">
    <link href="assets/vendor/css/jquery.fancybox.min.css" rel="stylesheet">
    <link href="assets/vendor/css/owl.carousel.min.css" rel="stylesheet">
    <link href="assets/vendor/css/cubeportfolio.min.css" rel="stylesheet">
    <link href="assets/vendor/css/LineIcons.min.css" rel="stylesheet">
    <link href="assets/vendor/css/wow.css" rel="stylesheet">
    <link href="assets/css/settings.css" rel="stylesheet">
    <link href="assets/css/blog.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
    <link href="assets/css/custom.css" rel="stylesheet">
    <style>
        /* Login button styling */
        .login-button-top {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1000;
            background-color: #dc3545;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
            transition: all 0.3s;
        }
        .login-button-top:hover {
            background-color: #c82333;
            color: white;
            text-decoration: none;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.3);
        }
        .login-button-top i {
            margin-right: 5px;
        }
    </style>
</head>
<body data-spy="scroll" data-target=".navbar" data-offset="90">
<!-- Login Button -->
<a href="/shuurkhai/user/" title="Нэвтрэх" class="login-button-top btn btn-danger text-white">
    <i class="las la-user-circle"></i> Нэвтрэх
</a>


<!--slider sec strat-->
<section id="slider-sec" class="slider-sec parallax" style="background: url('assets/images/warehouse-bg.jpg');">
    <div class="overlay text-center d-flex justify-content-center align-items-center">
        <div class="slide-contain">
            <h4 class="text-primary">Бидний тухай</h4>
            <div class="crumbs">
                <nav aria-label="breadcrumb" class="breadcrumb-items">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/shuurkhai/">Нүүр</a></li>
                        <li class="breadcrumb-item"><a href="#">Бид</a></li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>
<!--slider sec end-->

<!--mini services start-->
<section class="mini-services" id="mini-services">
    <div class="container">
        <div class="row no-gutters">
            <?php
            // Initialize variables
            $page_title = '';
            $page_content = '';
            $page_image = '';
            
            $sql = "SELECT * FROM advantages ORDER BY dd";
            $result = mysqli_query($conn, $sql);
            if ($result) {
                while ($data = mysqli_fetch_array($result)) {
                    if ($data) {
                        ?>
                        <div class="col-12 col-md-6 col-lg-3 col-xs-6 text-center mini-s">
                            <div class="mini-service-card">
                                <div class="service-icon"><i class="<?php echo htmlspecialchars($data["icon"] ?? '');?>"></i></div>
                                <h4 class="mini-service-heading"><?php echo htmlspecialchars($data["name"] ?? '');?></h4>
                                <span class="small-des"><?php echo htmlspecialchars($data["description"] ?? '');?></span>
                            </div>
                        </div>
                        <?php
                    }
                }
            }
            ?>
        </div>
    </div>
</section>
<!--mini services end-->

<section class="counters" id="counters">
    <div class="container"> 
        <div class="row">
            <div class="col-12 col-md-12 col-lg-12 text-center text-large">
                <span class="text-danger wow fadeInDown" data-wow-delay="1s">22.5k</span> Нийт хэрэглэгчид | 
                <span class="text-danger wow fadeInDown" data-wow-delay="1.1s">98k</span> Нийт ачаа таталт | 
                <span class="text-danger wow fadeInDown" data-wow-delay="1.2s">10</span> жилийн үйлчилгээ
            </div>
        </div>
    </div>
</section>


<!--about us section start-->
<section class="about-sec padding-top padding-bottom" id="about-sec">
    <div class="container">
        <?php
        // Check if type parameter is set (air or sea cargo)
        $cargo_type = isset($_GET['type']) ? htmlspecialchars($_GET['type']) : '';
        
        // Initialize variables
        $page_title = '';
        $page_content = '';
        $page_image = '';
        
        // If cargo type is specified, show specific information
        if ($cargo_type === 'air') {
            $page_title = 'Агаарын карго үйлчилгээ';
            $page_content = '<div class="text-center mb-5">
                <i class="las la-dollar-sign" style="font-size: 48px; color: #1e3a5f;"></i>
            </div>
            <h3 class="text-center mb-4" style="color: #1e3a5f; font-weight: bold; font-size: 1.5rem;">Бодит үнэ</h3>
            <p class="text-center" style="color: #333; font-size: 1rem; line-height: 1.6;">Америкаас агаараар 1кг ачаа 7$, далайгаар 50х50х50см хайрцаг 70$ Тээврийн зардлыг Монголд төлөхөд нэмэгдэлгүй.</p>';
        } elseif ($cargo_type === 'sea') {
            $page_title = 'Далайн карго үйлчилгээ';
            $page_content = 'Манай газрын ачаа далайгаар тээвэрлэгдэн 40 хоногт багтан ирдэг. Далайн карго нь хэмжээтэй, хүнд ачааг тээвэрлэхэд тохиромжтой, эдийн засгийн хувьд хямд үйлчилгээ юм.';
        } else {
            // Default: show general about page
            $sql = "SELECT * FROM pages WHERE page_id = 1";
            $result = mysqli_query($conn, $sql);
            
            if ($result && mysqli_num_rows($result) > 0) {
                $data = mysqli_fetch_array($result);
                if ($data) {
                    $page_title = isset($data["title"]) ? $data["title"] : '';
                    $page_image = fix_image_path($data["image"] ?? '');
                    $page_content = isset($data["content"]) ? $data["content"] : '';
                }
            }
        }
        ?>
        <div class="row">
            <div class="col-12 text-center">
                <div class="heading-details">
                    <h4 class="heading"><?php echo htmlspecialchars($page_title);?></h4>
                </div>
            </div>

            <div class="col-12 col-md-12 text-center">
                <?php 
                if ($cargo_type === 'air' || $cargo_type === 'sea') {
                    echo $page_content;
                } else {
                    echo nl2br(htmlspecialchars($page_content));
                }
                ?>
            </div>
        </div>
        
        <?php if ($cargo_type === 'air' || $cargo_type === 'sea'): ?>
        <div class="row mt-5">
            <div class="col-12 text-center">
                <a href="/shuurkhai/about" class="btn web-btn rounded-pill">Буцах <i class="las la-arrow-left"></i></a>
            </div>
        </div>
        <?php endif; ?>
    </div>
</section>

<!--about us section end-->

<!--testimonial sec start-->
<section class="partners-sec padding-top padding-bottom" id="partners-sec">
    <svg id="test-header" xmlns="http://www.w3.org/2000/svg" version="1.1" width="100%" height="60" viewBox="0 0 100 100" preserveAspectRatio="none">
        <path d="M0 100 C40 0 60 0 100 100 Z"/>
    </svg>

    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <div class="heading-details">
                    <h4 class="heading">Хамтрагчид</h4>
                </div>
            </div>
        </div>
        <div class="best-products-carousel owl-carousel owl-themesss">
            <div class="item text-center">
                <div class="product">
                    <div class="product-img">
                        <img src="assets/images/monos.jpg">
                        <div class="overlay-img">
                            <div class="overlay-content">
                                <a href="#"><i class="las la-globe"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="product-detail">
                        <span class="product-cat">Эм хангамж</span>
                        <h4 class="product-name">Монос</h4>
                        <span class="fly-line"></span>
                        <ul class="reviews">
                            <li><i class="las la-star"></i></li>
                            <li><i class="las la-star"></i></li>
                            <li><i class="las la-star"></i></li>
                            <li><i class="las la-star"></i></li>
                            <li><i class="las la-star"></i></li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="item text-center">
                <div class="product">
                    <div class="product-img">
                        <img src="assets/images/next.jpg">
                        <div class="overlay-img">
                            <div class="overlay-content">
                                <a href="#"><i class="las la-heart"></i></a>
                                <a href="#"><i class="las la-shopping-bag"></i></a>
                                <a href="product-detail.html"><i class="las la-search"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="product-detail">
                        <span class="product-cat">Цахилгаан барааны дэлгүүр</span>
                        <h4 class="product-name">Next</h4>
                        <span class="fly-line"></span>
                        <ul class="reviews">
                            <li><i class="las la-star"></i></li>
                            <li><i class="las la-star"></i></li>
                            <li><i class="las la-star"></i></li>
                            <li><i class="las la-star"></i></li>
                            <li><i class="las la-star"></i></li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="item text-center">
                <div class="product">
                    <div class="product-img">
                        <img src="assets/images/ms.jpg">
                        <div class="overlay-img">
                            <div class="overlay-content">
                                <a href="#"><i class="las la-heart"></i></a>
                                <a href="#"><i class="las la-shopping-bag"></i></a>
                                <a href="product-detail.html"><i class="las la-search"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="product-detail">
                        <span class="product-cat">Програм хангамж</span>
                        <h4 class="product-name">Майнд Симбол</h4>
                        <span class="fly-line"></span>
                        <ul class="reviews">
                            <li><i class="las la-star"></i></li>
                            <li><i class="las la-star"></i></li>
                            <li><i class="las la-star"></i></li>
                            <li><i class="las la-star"></i></li>
                            <li><i class="las la-star"></i></li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="item text-center">
                <div class="product">
                    <div class="product-img">
                        <img src="assets/images/mcs.jpg">
                        <div class="overlay-img">
                            <div class="overlay-content">
                                <a href="#"><i class="las la-heart"></i></a>
                                <a href="#"><i class="las la-shopping-bag"></i></a>
                                <a href="product-detail.html"><i class="las la-search"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="product-detail">
                        <span class="product-cat">Бизнес</span>
                        <h4 class="product-name">MCS</h4>
                        <span class="fly-line"></span>
                        <ul class="reviews">
                            <li><i class="las la-star"></i></li>
                            <li><i class="las la-star"></i></li>
                            <li><i class="las la-star"></i></li>
                            <li><i class="las la-star"></i></li>
                            <li><i class="las la-star"></i></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="item text-center">
                <div class="product">
                    <div class="product-img">
                        <img src="assets/images/bsb.jpg">
                        <div class="overlay-img">
                            <div class="overlay-content">
                                <a href="#"><i class="las la-heart"></i></a>
                                <a href="#"><i class="las la-shopping-bag"></i></a>
                                <a href="product-detail.html"><i class="las la-search"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="product-detail">
                        <span class="product-cat">Цахилгаан бараа</span>
                        <h4 class="product-name">BSB</h4>
                        <span class="fly-line"></span>
                        <ul class="reviews">
                            <li><i class="las la-star"></i></li>
                            <li><i class="las la-star"></i></li>
                            <li><i class="las la-star"></i></li>
                            <li><i class="las la-star"></i></li>
                            <li><i class="las la-star"></i></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>





<!--Scroll Top Start-->
<span class="scroll-top-arrow"><i class="fas fa-angle-up"></i></span>

<!--Scroll Top End-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.0.4/popper.js"></script>

<script src="assets/vendor/js/bundle.min.js"></script>
<!-- Plugin Js -->
<script src="assets/vendor/js/jquery.appear.js"></script>
<script src="assets/vendor/js/jquery.fancybox.min.js"></script>
<script src="assets/vendor/js/owl.carousel.min.js"></script>
<script src="assets/vendor/js/parallaxie.min.js"></script>
<script src="assets/vendor/js/wow.min.js"></script>
<script src="assets/vendor/js/stickyfill.min.js"></script>
<!-- REVOLUTION JS FILES -->
<script src="assets/vendor/js/jquery.themepunch.tools.min.js"></script>
<script src="assets/vendor/js/jquery.themepunch.revolution.min.js"></script>
<script src="assets/vendor/js/jquery.cubeportfolio.min.js"></script>
<!-- SLIDER REVOLUTION EXTENSIONS -->
<script src="assets/vendor/js/extensions/revolution.extension.actions.min.js"></script>
<script src="assets/vendor/js/extensions/revolution.extension.carousel.min.js"></script>
<script src="assets/vendor/js/extensions/revolution.extension.kenburn.min.js"></script>
<script src="assets/vendor/js/extensions/revolution.extension.layeranimation.min.js"></script>
<script src="assets/vendor/js/extensions/revolution.extension.migration.min.js"></script>
<script src="assets/vendor/js/extensions/revolution.extension.navigation.min.js"></script>
<script src="assets/vendor/js/extensions/revolution.extension.parallax.min.js"></script>
<script src="assets/vendor/js/extensions/revolution.extension.slideanims.min.js"></script>
<script src="assets/vendor/js/extensions/revolution.extension.video.min.js"></script>


<!-- custom script-->
<script src="assets/vendor/js/bootstrap-input-spinner.js"></script>
<script src="assets/vendor/js/swiper.min.js"></script>
<script src="assets/js/nouislider.min.js"></script>
<!--contact form-->
<script src="assets/js/script.js"></script>

</body>
</html>