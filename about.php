<? require_once("config.php");?>
<? require_once("views/helper.php");?>
<? require_once("views/init.php");?>

<body data-spy="scroll" data-target=".navbar" data-offset="90">

<!-- Preloader -->
<div class="preloader">
    <div class="centrize full-width">
        <div class="vertical-center">
            <div class="spinner">
                <div class="double-bounce1"></div>
                <div class="double-bounce2"></div>
            </div>
        </div>
    </div>
</div>
<!-- Preloader End -->

<? require_once("views/header.php");?>


<!--slider sec strat-->
<section id="slider-sec" class="slider-sec parallax" style="background: url('assets/images/warehouse-bg.jpg');">
    <div class="overlay text-center d-flex justify-content-center align-items-center">
        <div class="slide-contain">
            <h4 class="text-primary">Бидний тухай</h4>
            <div class="crumbs">
                <nav aria-label="breadcrumb" class="breadcrumb-items">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index">Нүүр</a></li>
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
            <?
            $sql = "SELECT *FROM advantages ORDER BY dd";
            $result = mysqli_query($conn,$sql);
            while ($data = mysqli_fetch_array($result))
            {
                ?>
                <div class="col-12 col-md-6 col-lg-3 col-xs-6 text-center mini-s">
                    <div class="mini-service-card">
                        <div class="service-icon"><i class="<?=$data["icon"];?>"></i></div>
                        <h4 class="mini-service-heading"><?=$data["name"];?></h4>
                        <span class="small-des"><?=$data["description"];?></span>
                    </div>
                </div>
                <?
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
        <?
        $sql = "SELECT *FROM pages WHERE page_id =1";
        $result = mysqli_query($conn,$sql);
        $data= mysqli_fetch_array($result);
        $page_title = $data["title"];
        $page_image = $data["image"];
        $page_content = $data["content"];
        ?>
        <div class="row">
            <div class="col-12 text-center">
                <div class="heading-details">
                    <h4 class="heading"><?=$page_title;?></h4>
                </div>
            </div>

            <div class="col-12 col-md-12 text-center">
                <p class="text"><?=$page_content;?></p>
            </div>
        </div>
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



<? require_once("views/footer.php");?>


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