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

<!--Home Start-->
<section class="slider-sec" id="slider-sec">
    <div id="rev-slider" class="rev-slider">
        <div id="rev_slider_18_1_wrapper" class="rev_slider_wrapper fullscreen-container" data-alias="megaone-restaurant-1" data-source="gallery" style="background:transparent;padding:0px;">
            <!-- START REVOLUTION SLIDER 5.4.8.1 fullscreen mode -->
            <div id="rev_slider_18_1" class="rev_slider fullscreenbanner" style="display:none;" data-version="5.4.8.1">

                <ul>	
                    <?
                    $sql  = "SELECT *FROM slides ORDER BY dd";
                    $result = mysqli_query($conn,$sql);
                    while ($data = mysqli_fetch_array($result))
                    {
                        ?>
                        <!-- SLIDE  -->
                        <li data-index="rs-<?=$data["id"];?>" data-transition="fade" data-slotamount="default" data-hideafterloop="0" data-hideslideonmobile="on"  data-easein="default" data-easeout="default" data-masterspeed="300"  data-rotate="0"  data-saveperformance="off"  data-title="Slide" data-param1="" data-param2="" data-param3="" data-param4="" data-param5="" data-param6="" data-param7="" data-param8="" data-param9="" data-param10="" data-description="">
                            <!-- MAIN IMAGE -->
                            <img src="<?=$data["image"];?>" alt=""  data-bgposition="center center" data-bgfit="cover" data-bgrepeat="no-repeat" class="rev-slidebg" data-no-retina>
                            <div class="slider-overlay"></div>
                            <!-- LAYERS -->

                            <!-- LAYER NR. 6 -->
                            <div class="tp-caption   tp-resizeme"
                                id="slide-<?=$data["id"];?>-layer-1"
                                data-x="['center','center','center','center']" data-hoffset="['0','0','0','0']"
                                data-y="['middle','middle','middle','middle']" data-voffset="['0','0','0','0']"
                                data-fontsize="['52','50','42','35']"
                                data-lineheight="['82','82','72','55']"
                                data-width="none"
                                data-height="none"
                                data-whitespace="nowrap"

                                data-type="text"
                                data-responsive_offset="on"

                                data-frames='[{"delay":0,"split":"chars","splitdelay":0.1,"speed":1500,"split_direction":"forward","frame":"0","from":"sX:0.8;sY:0.8;opacity:0;","to":"o:1;","ease":"Power4.easeOut"},{"delay":"wait","speed":300,"frame":"999","to":"opacity:0;","ease":"Power3.easeInOut"}]'
                                data-textAlign="['inherit','inherit','inherit','inherit']"
                                data-paddingtop="[0,0,0,0]"
                                data-paddingright="[0,0,0,0]"
                                data-paddingbottom="[0,0,0,0]"
                                data-paddingleft="[0,0,0,0]"

                                style="z-index: 6; white-space: nowrap; font-size: 52px; line-height: 82px; font-weight: 500; color: #bf0a30; letter-spacing: 0;font-family: 'Roboto Condensed', sans-serif;"><?=$data["name"];?></div>

                            <!-- LAYER NR. 7 -->
                            <div class="tp-caption   tp-resizeme"
                                id="slide-<?=$data["id"];?>-layer-3"
                                data-x="['center','center','center','center']" data-hoffset="['0','0','0','0']"
                                data-y="['middle','middle','middle','middle']" data-voffset="['70','60','70','70']"
                                data-fontsize="['16','14','14','14']"
                                data-width="['490','490','600','450']"
                                data-height="none"
                                data-whitespace="normal"

                                data-type="text"
                                data-responsive_offset="on"

                                data-frames='[{"delay":2400,"speed":1500,"frame":"0","from":"y:[100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;opacity:0;","mask":"x:0px;y:[100%];s:inherit;e:inherit;","to":"o:1;","ease":"Power2.easeInOut"},{"delay":"wait","speed":300,"frame":"999","to":"opacity:0;","ease":"Power3.easeInOut"}]'
                                data-textAlign="['center','center','center','center']"
                                data-paddingtop="[0,0,0,0]"
                                data-paddingright="[0,0,0,0]"
                                data-paddingbottom="[0,0,0,0]"
                                data-paddingleft="[0,0,0,0]"

                                style="z-index: 7; min-width: 600px; max-width: 600px; white-space: normal; font-size: 16px; line-height: 26px; font-weight: 400; color: #FFF; letter-spacing:0;font-family:'Roboto Condensed';"><?=$data["text"];?></div>

                            <!-- LAYER NR. 8 -->
                          
                                <div class="tp-caption  tp-resizeme"
                                    id="slide-<?=$data["id"];?>-layer-4"
                                    data-x="['center','center','center','center']" data-hoffset="['0','0','0','0']"
                                    data-y="['middle','middle','middle','middle']" data-voffset="['138','134','138','138']"
                                    data-width="['130','130','130','130']"
                                    data-height="none"
                                    data-whitespace="normal"
                                    data-type="button"
                                    data-responsive_offset="on"
                                    data-frames='[{"delay":2600,"speed":1500,"frame":"0","from":"y:[100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;opacity:0;","mask":"x:0px;y:[100%];s:inherit;e:inherit;","to":"o:1;","ease":"Power2.easeInOut"},{"delay":"wait","speed":300,"frame":"999","to":"opacity:0;","ease":"Power3.easeInOut"}]'
                                    data-textAlign="['inherit','inherit','center','center']"
                                    data-paddingtop="[0,0,0,0]"
                                    data-paddingright="[0,0,0,0]"
                                    data-paddingbottom="[0,0,0,0]"
                                    data-paddingleft="[0,0,0,0]"

                                    style="z-index: 8; font-family:'Roboto Condensed';"><a class="btn web-btn rounded-pill" href="<?=$data["link"];?>" target="new">Дэлгэрэнгүй</a></div>
                        </li>
                        <?
                    }
                    ?>

                </ul>
                <div class="tp-bannertimer tp-bottom" style="visibility: hidden !important;"></div>	</div>
        </div>
        <!-- END REVOLUTION SLIDER -->
        <!--SLIDER DOWN ARROW-->
        <!--    <svg class="separator__svg" width="100%" height="100" viewBox="0 0 100 100" preserveAspectRatio="none" fill="#44A36F" version="1.1" xmlns="http://www.w3.org/2000/svg">-->
        <!--        <path d="M 100 100 V 10 L 0 100"/>-->
        <!--        <path d="M 30 73 L 100 18 V 10 Z" fill="#308355" stroke-width="0"/>-->
        <!--    </svg>-->
        <svg id="bigHalfCircle" xmlns="http://www.w3.org/2000/svg" version="1.1" width="100%" height="60" viewBox="0 0 100 100" preserveAspectRatio="none">
            <path d="M0 100 C40 0 60 0 100 100 Z"/>
        </svg>
    </div>
</section>
<!--Home End-->

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

<!--featured item sec start-->
<section class="featured-items padding-top padding-bottom" id="featured-items">
    <div class="container">
        <?
        $sql = "SELECT *FROM pages WHERE page_id =14";
        $result = mysqli_query($conn,$sql);
        $data= mysqli_fetch_array($result);
        $page_title = $data["title"];
        $page_image = $data["image"];
        $page_content = $data["content"];
        ?>
        
        <div class="row">
            <div class="col-12 text-center">
                <div class="heading-details mb-0">
                    <h4 class="heading"><?=$page_title;?></h4>
                </div>
            </div>
            <div class="col-12 col-md-8 offset-md-2 text-center mb-4">
                <p class="text"><?=$page_content;?></p>
            </div>
        </div>
        <div class="row">
            <?
            $sql = "SELECT *FROM shops ORDER BY rand() LIMIT 8";
            $result = mysqli_query($conn,$sql);
            while ($data = mysqli_fetch_array($result))
            {
                ?>
                <div class="col-12 col-md-4 col-lg-3 text-center wow slideInUp">
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
        <div class="row">
            <div class="col-12 text-center mt-5">
                <a href="shop" class="btn web-btn rounded-pill">Бүх дэлгүүр <i class="las la-arrow-right"></i> </a>
            </div>
        </div>
    </div>
</section>
<!--featured item sec end-->

<!--about us section start-->
<section class="about-sec padding-top padding-bottom" id="about-sec">
    <div class="container">
        <?
        $sql = "SELECT *FROM pages WHERE page_id =15";
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
            <div class="col-12 col-md-8 offset-md-2 text-center">
                <p class="text"><?=$page_content;?></p>
            </div>
        </div>
        <div class="row services-area">
            <div class="col-12 col-lg-4 services text-center wow fadeInUp" data-wow-delay=".2s">
                <div class="service-card">
                    <div class="image-holder"><i class="lni lni-plane"></i></div>
                    <h4 class="service-heading">Агаарын тээвэр</h4>
                    <p class="text">Бид 10 гаруй жил америкаас агаараар ачаа тээвэрлэж байна</p>
                    <!-- <a href="#" class="btn web-trans-btn rounded-pill">Read More</a> -->
                </div>
            </div>
            <div class="col-12 col-lg-4 services text-center wow fadeInUp" data-wow-delay=".3s">
                <div class="service-card">
                    <div class="image-holder"><i class="lni lni-ship"></i></div>
                    <h4 class="service-heading">Газрын ачаа</h4>
                    <p class="text">Манай газрын ачаа далайгаар тээвэрлэгдэн 40 хоногт багтан ирдэг</p>
                    <!-- <a href="#" class="btn web-trans-btn rounded-pill">Read More</a> -->
                </div>
            </div>
            <div class="col-12 col-lg-4 services text-center wow fadeInUp" data-wow-delay=".4s">
                <div class="service-card">
                    <div class="image-holder"><i class="lni lni-shopping-basket"></i></div>
                    <h4 class="service-heading">Онлайн захиалга</h4>
                    <p class="text">Манайх танд хэрэгтэй ачааг онлайнаас олоход тусалж зөвлөгөө өгч шуурхай авчирна</p>
                    <!-- <a href="#" class="btn web-trans-btn rounded-pill">Read More</a> -->
                </div>
            </div>
        </div>
    </div>
</section>
<!--about us section end-->

<!--testimonial sec start-->
<section class="testimonial-sec padding-top padding-bottom" id="testimonial-sec">
    <svg id="test-header" xmlns="http://www.w3.org/2000/svg" version="1.1" width="100%" height="60" viewBox="0 0 100 100" preserveAspectRatio="none">
        <path d="M0 100 C40 0 60 0 100 100 Z"/>
    </svg>

    <div class="container">
        <div class="testimonial-carousel owl-carousel owl-theme">
            <?
            $sql = "SELECT *FROM testimonial ORDER BY dd";
            $result = mysqli_query($conn,$sql);
            while ($data = mysqli_fetch_array($result))
            {
                ?>
                <div class="item text-center">
                    <div class="testimonial-review">
                        <div class="review-image">
                            <img src="<?=$data["thumbnail"];?>">
                        </div>
                        <div class="review-detail">
                            <h4 class="test-heading"><?=$data["name"];?></h4>
                            <p class="text-des"><?=$data["words"];?></p>
                            <ul class="test-review">
                                <li><a href="#"><i class="las la-star"></i></a></li>
                                <li><a href="#"><i class="las la-star"></i></a></li>
                                <li><a href="#"><i class="las la-star"></i></a></li>
                                <li><a href="#"><i class="las la-star"></i></a></li>
                                <li><a href="#"><i class="las la-star"></i></a></li>
                            </ul>
                        </div>
                        <div class="client-info media-body">
                            <p class="client-designation"><?=$data["description"];?></p>
                        </div>
                    </div>
                </div>   
                <?
            } 
            ?>
        </div>

        <a id="customPrevBtn" class="test-btn"><i class="fas fa-angle-left"></i></a>
        <a id="customNextBtn" class="test-btn"><i class="fas fa-angle-right"></i></a>
    </div>

    <svg id="test-footer" xmlns="http://www.w3.org/2000/svg" version="1.1" width="100%" height="60" viewBox="0 0 100 100" preserveAspectRatio="none">
        <path d="M0 100 C40 0 60 0 100 100 Z"/>
    </svg>
</section>
<!--testimonial sec end-->

<? require_once("views/footer.php");?>

<!--Scroll Top Start-->
<span class="scroll-top-arrow"><i class="fas fa-angle-up"></i></span>
<!--Scroll Top End-->

<!-- JavaScript -->
<script src="assets/vendor/js/bundle.min.js"></script>

<!-- Plugin Js -->
<script src="assets/vendor/js/jquery.appear.js"></script>
<script src="assets/vendor/js/jquery.fancybox.min.js"></script>
<script src="assets/vendor/js/owl.carousel.min.js"></script>
<script src="assets/vendor/js/parallaxie.min.js"></script>
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

<script src="assets/vendor/js/wow.min.js"></script>
<!-- google map-->
<!-- <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCJRG4KqGVNvAPY4UcVDLcLNXMXk2ktNfY"></script>
<script src="assets/js/map.js"></script> -->
<!--Tilt Js-->
<!-- custom script-->
<script src="assets/js/script.js"></script>

</body>
</html>