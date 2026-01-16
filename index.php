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


<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
  <ol class="carousel-indicators">
    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
    <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
    <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
  </ol>
  <div class="carousel-inner">
      <?
      $count =1;
      $sql  = "SELECT *FROM slides ORDER BY dd";
      $result = mysqli_query($conn,$sql);
      while ($data = mysqli_fetch_array($result))
      {
          ?>
            <div class="carousel-item <?=($count==1)?'active':'';?>">
                <img class="d-block w-100" src="<?=$data["image"];?>" alt="First slide">
            </div>
          <?
          $count++;
      }
      ?>

  </div>
  <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div>



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
            $sql = "SELECT *FROM shops";
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