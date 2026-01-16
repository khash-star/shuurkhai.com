<? require_once("config.php");?>
<? require_once("views/helper.php");?>
<? require_once("views/init.php");?>

<link href="assets/css/range-slider.css" rel="stylesheet">


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



<!--Product Line Up Start -->
<div class="product-listing">
    <div class="container">
        <div class="row">

            <!-- START STICKY NAV -->
            <div class="col-12 col-lg-3 order-2 order-lg-1 sticky">
                <div id="product-filter-nav" class="product-filter-nav mb-3">
                    <div class="product-category">
                        <h5 class="filter-heading  text-center text-lg-left">Ангилал</h5>
                        <ul>
                            <?
                            $sql = "SELECT *FROM shops_category ORDER BY dd";
                            $result = mysqli_query($conn,$sql);
                            while ($data = mysqli_fetch_array($result))
                            {
                                ?>
                                <li><a href="shop?category=<?=$data["id"];?>"><?=$data["name"];?> </a><span>(<?=$data["count"];?>)</span></li>
                                <?
                            }
                            ?>
                        </ul>
                    </div>

                </div>
            </div>
            <!-- END STICKY NAV -->

            <!-- START PRODUCT COL 8 -->
            <div class="col-md-12 col-lg-9 order-1 order-lg-2">
                <div class="row">

                    <!-- START PRODUCT LISTING SECTION -->
                    <div class="col-12 product-listing-products">
                        <!--featured item sec start-->
                        <section class="featured-items padding-bottom" id="featured-items">
                        <div class="row">
                            <?
                            $sql = "SELECT *FROM shops";
                            if (isset($_GET["category"])) $sql.=" WHERE category = '".$_GET["category"]."'";
                            $result = mysqli_query($conn,$sql);
                            while ($data = mysqli_fetch_array($result))
                            {
                                ?>
                                <div class="col-12 col-md-6 col-lg-4 text-center wow slideInUp">
                                    <div class="featured-item-card">
                                        <div class="item-img">
                                            <img src="<?=$data["image"];?>" class="product-outside-image">
                                            <div class="item-overlay">
                                                <div class="item-btns">
                                                    <a href="<?=$data["url"];?>" class="btn btn-view" target="new"><i class="las la-shopping-bag"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="item-detail">
                                            <h4 class="item-name"><?=$data["name"];?></h4>
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
                                <?
                            }
                            ?>

                        </div>
                        </section>
                        <!--featured item sec end-->
                    </div>
                    <!-- END PRODUCT LISTING SECTION -->
                </div>
            </div>
            <!-- END PRODUCT COL 8 -->
        </div>
    </div>
</div>
<!--Product Line Up End-->




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
<script src="assets/js/nouislider.min.js"></script>


<!--contact form-->
<script src="assets/js/script.js"></script>

</body>
</html>