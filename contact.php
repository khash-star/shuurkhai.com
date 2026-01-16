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

<?
$sql = "SELECT *FROM pages WHERE page_id =6";
$result = mysqli_query($conn,$sql);
$data= mysqli_fetch_array($result);
$page_title = $data["title"];
$page_image = $data["image"];
$page_content = $data["content"];
?>
<!--slider sec strat-->
<section id="slider-sec" class="slider-sec parallax" style="background: url('<?=$page_image;?>');">
    <div class="overlay text-center d-flex justify-content-center align-items-center">
        <div class="slide-contain">
            <h4>Холбогдох хэсэг</h4>
            <div class="crumbs">
                <nav aria-label="breadcrumb" class="breadcrumb-items">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index">Нүүр</a></li>
                        <li class="breadcrumb-item"><a href="#">Холбогдох хэсэг</a></li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>
<!--slider sec end-->


<!-- Contact Us Start -->
<section class="contact-sec" id="contact-sec">

    <div class="container">
        <div class="row">
            <div class="col-12 col-lg-6 contact-description wow slideInLeft" data-wow-delay=".8s">
                <div class="contact-detail wow fadeInLeft">
                    <div class="ex-detail">
                        <span class="fly-text">Холбогдох</span>
                        <h4 class="large-heading">
                            <span class="heading-1"><?=$page_title;?></span>
                            <!-- <span class="heading-2">In Touch</span> -->
                        </h4>
                    </div>
                    <p class="small-text text-center text-md-left">
                        <?=$page_content;?>
                    </p>
                    <div class="row location-details text-center text-md-left">
                        <div class="col-12 col-md-6 couuntry-1">
                            <h4 class="heading-text text-left">Монголд</h4>
                            <ul>
                                <li><i class="fas la-phone-volume"></i><a href="tel:<?=settings("tel");?>"><?=settings("tel");?></a></li>
                                <li><i class="fas fa-envelope"></i><a href="mailto:<?=settings("email");?>"><?=settings("email");?></a></li>
                                <li><i class="fas fa-map-marker"></i><a href="#"><?=settings("address");?></a></li>
                            </ul>
                        </div>
                        <div class="col-12 col-md-6 country-1">
                            <h4 class="heading-text text-left">United States</h4>
                            <ul>
                                <li><i class="fas la-phone-volume"></i><a href="tel:<?=settings("tel_2");?>"><?=settings("tel_2");?></a></li>
                                <li><i class="fas fa-envelope"></i><a href="mailto:<?=settings("email_2");?>"><?=settings("email_2");?></a></li>
                                <li><i class="fas fa-map-marker"></i><a href="#"><?=settings("address_2");?></a></li>
                            </ul>
                        </div>
                       
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-6 contact-box text-center text-md-left wow slideInRight" data-wow-delay=".8s">
                <div class="c-box wow fadeInRight">
                    <h4 class="small-heading">Шуурхай зурвас илгээх</h4>
                    <!--                        <p class="small-text">Lorem ipsum is simply dummy text of the printing and typesetting industry. </p>-->
                    <form class="contact-form" id="contact-form-data">
                        <div class="row my-form">
                            <div class="col-md-12 col-sm-12">
                                <div id="result"></div>
                            </div>
                            <div class="col-12 col-md-6">
                                <input type="text" class="form-control" id="name" name="name" placeholder="Нэр" required="required">
                            </div>
                            <div class="col-12 col-md-6">
                                <input type="text" class="form-control" id="tel" name="tel" placeholder="Утас" required="required">
                            </div>
                            <div class="col-12 col-md-6">
                                <input type="email" class="form-control" id="email" name="email" placeholder="Имэйл" required="required">
                            </div>
                            <div class="col-12 col-md-6">
                                <input type="text" class="form-control" id="subject" name="subject" placeholder="Товч агуулга" required="required">
                            </div>
                            <div class="col-12">
                                <textarea class="form-control" id="content" name="content" placeholder="Агуулга" rows="7" required="required"></textarea>
                            </div>
                            <div class="col-12">
                                <button class="btn web-btn user-contact rounded-pill contact_btn" type="button">Илгээх
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Contact Us End -->


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
<script src="assets/vendor/js/contact_us.js"></script>
<script src="assets/js/script.js"></script>

</body>
</html>