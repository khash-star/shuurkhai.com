<?php require_once("config.php");?>
<?php require_once("views/helper.php");?>
<?php require_once("views/init.php");?>

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

<?php require_once("views/header.php");?>


<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
  <ol class="carousel-indicators">
    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
    <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
    <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
  </ol>
  <div class="carousel-inner">
      <?php
      $count =1;
      $sql  = "SELECT * FROM sliders ORDER BY dd";
      $result = mysqli_query($conn,$sql);
      if ($result) {
          while ($data = mysqli_fetch_array($result))
          {
              if ($data) {
                  ?>
                    <div class="carousel-item <?php echo ($count==1)?'active':'';?>">
                        <img class="d-block w-100" src="<?php echo htmlspecialchars(fix_image_path($data["image"] ?? ''));?>" alt="First slide">
                    </div>
                  <?php
                  $count++;
              }
          }
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
        <?php
        $page_title = '';
        $page_image = '';
        $page_content = '';
        
        $sql = "SELECT * FROM pages WHERE page_id = 14";
        $result = mysqli_query($conn, $sql);
        
        if ($result) {
            $data = mysqli_fetch_assoc($result);
            if ($data) {
                $page_title   = $data['title']   ?? '';
                $page_image   = $data['image']   ?? '';
                $page_content = $data['content'] ?? '';
            }
        }
        ?>
        
        <div class="row">
            <div class="col-12 text-center">
                <div class="heading-details mb-0">
                    <h4 class="heading"><?php echo htmlspecialchars(isset($page_title) ? $page_title : '');?></h4>
                </div>
            </div>
            <div class="col-12 col-md-8 offset-md-2 text-center mb-4">
                <p class="text"><?php echo htmlspecialchars(isset($page_content) ? $page_content : '');?></p>
            </div>
        </div>
        <div class="row">
            <?php
            $sql = "SELECT * FROM shops";
            $result = mysqli_query($conn,$sql);
            if ($result) {
                while ($data = mysqli_fetch_array($result))
                {
                    if ($data) {
                        ?>
                        <div class="col-12 col-md-4 col-lg-3 text-center wow slideInUp">
                            <div class="featured-item-card">
                                <div class="item-img">
                                    <img src="<?php echo htmlspecialchars(fix_image_path($data["image"] ?? ''));?>" class="product-outside-image">
                                    <div class="item-overlay">
                                        <div class="item-btns">
                                            <a href="<?php echo htmlspecialchars($data["url"] ?? '#');?>" class="btn btn-view" target="new"><i class="las la-shopping-bag"></i></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="item-detail">
                                    <h4 class="item-name"><?php echo htmlspecialchars($data["name"] ?? '');?></h4>
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
                        <?php
                    }
                }
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
            <?php
            $sql = "SELECT * FROM advantages ORDER BY dd";
            $result = mysqli_query($conn,$sql);
            if ($result) {
                while ($data = mysqli_fetch_array($result))
                {
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



<!--about us section start-->
<section class="about-sec padding-top padding-bottom" id="about-sec">
    <div class="container">
        <?php
        $page_title = '';
        $page_image = '';
        $page_content = '';
        
        $sql = "SELECT * FROM pages WHERE page_id =15";
        $result = mysqli_query($conn,$sql);
        if ($result) {
            $data = mysqli_fetch_array($result);
            if ($data) {
                $page_title = $data["title"] ?? '';
                $page_image = $data["image"] ?? '';
                $page_content = $data["content"] ?? '';
            }
        }
        ?>
        <div class="row">
            <div class="col-12 text-center">
                <div class="heading-details">
                    <h4 class="heading"><?php echo htmlspecialchars(isset($page_title) ? $page_title : '');?></h4>
                </div>
            </div>
            <div class="col-12 col-md-8 offset-md-2 text-center">
                <p class="text"><?php echo htmlspecialchars(isset($page_content) ? $page_content : '');?></p>
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

<!--stats section start-->
<section class="stats-sec padding-top padding-bottom" id="stats-sec" style="background: linear-gradient(135deg, #002868 0%, #004080 100%);">
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-3 col-sm-6 text-center mb-4 mb-md-0">
                <div class="stat-item wow fadeInUp" data-wow-delay=".1s">
                    <div class="stat-icon"><i class="las la-shipping-fast" style="font-size: 48px; color: #fff;"></i></div>
                    <h3 class="stat-number" style="color: #fff; font-size: 42px; font-weight: bold; margin: 15px 0;">10+</h3>
                    <p class="stat-text" style="color: #fff; font-size: 16px;">Жилийн туршлага</p>
                </div>
            </div>
            <div class="col-12 col-md-3 col-sm-6 text-center mb-4 mb-md-0">
                <div class="stat-item wow fadeInUp" data-wow-delay=".2s">
                    <div class="stat-icon"><i class="las la-users" style="font-size: 48px; color: #fff;"></i></div>
                    <h3 class="stat-number" style="color: #fff; font-size: 42px; font-weight: bold; margin: 15px 0;">5000+</h3>
                    <p class="stat-text" style="color: #fff; font-size: 16px;">Сэтгэл ханамжтай үйлчлүүлэгчид</p>
                </div>
            </div>
            <div class="col-12 col-md-3 col-sm-6 text-center mb-4 mb-md-0">
                <div class="stat-item wow fadeInUp" data-wow-delay=".3s">
                    <div class="stat-icon"><i class="las la-box" style="font-size: 48px; color: #fff;"></i></div>
                    <h3 class="stat-number" style="color: #fff; font-size: 42px; font-weight: bold; margin: 15px 0;">10000+</h3>
                    <p class="stat-text" style="color: #fff; font-size: 16px;">Амжилттай хүргэлт</p>
                </div>
            </div>
            <div class="col-12 col-md-3 col-sm-6 text-center mb-4 mb-md-0">
                <div class="stat-item wow fadeInUp" data-wow-delay=".4s">
                    <div class="stat-icon"><i class="las la-globe" style="font-size: 48px; color: #fff;"></i></div>
                    <h3 class="stat-number" style="color: #fff; font-size: 42px; font-weight: bold; margin: 15px 0;">2</h3>
                    <p class="stat-text" style="color: #fff; font-size: 16px;">Улс дахь салбар</p>
                </div>
            </div>
        </div>
    </div>
</section>
<!--stats section end-->

<!--latest news section start-->
<section class="latest-news-sec padding-top padding-bottom" id="latest-news-sec">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center mb-5">
                <div class="heading-details">
                    <h4 class="heading">Сүүлийн мэдээлэл</h4>
                    <p class="text">Манай компанийн хамгийн сүүлийн мэдээ, мэдээлэл</p>
                </div>
            </div>
        </div>
        <div class="row">
            <?php
            $sql = "SELECT news.*, news_category.name category_name FROM news LEFT JOIN news_category ON news.category = news_category.id ORDER BY timestamp DESC LIMIT 3";
            $result = mysqli_query($conn,$sql);
            if ($result && mysqli_num_rows($result) > 0) {
                while ($data = mysqli_fetch_array($result)) {
                    if ($data && is_array($data)) {
                        $news_id = isset($data["id"]) ? $data["id"] : '';
                        $news_title = isset($data["title"]) ? htmlspecialchars($data["title"]) : '';
                        $news_thumb = isset($data["thumb"]) ? htmlspecialchars(fix_image_path($data["thumb"])) : 'assets/images/default-news.jpg';
                        $news_timestamp = isset($data["timestamp"]) ? substr($data["timestamp"],0,10) : '';
                        $news_category = isset($data["category_name"]) ? htmlspecialchars($data["category_name"]) : '';
                        $news_content = isset($data["content"]) ? strip_tags($data["content"]) : '';
                        $news_excerpt = mb_substr($news_content, 0, 100, 'UTF-8') . '...';
                        ?>
                        <div class="col-12 col-md-4 mb-4 wow fadeInUp" data-wow-delay=".2s">
                            <div class="news-card" style="border-radius: 10px; overflow: hidden; box-shadow: 0 5px 15px rgba(0,0,0,0.1); transition: transform 0.3s;">
                                <div class="news-image" style="height: 200px; overflow: hidden;">
                                    <img src="<?php echo $news_thumb;?>" alt="<?php echo $news_title;?>" style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.3s;">
                                </div>
                                <div class="news-content" style="padding: 20px; background: #fff;">
                                    <div class="news-meta" style="font-size: 12px; color: #666; margin-bottom: 10px;">
                                        <span><i class="las la-calendar"></i> <?php echo $news_timestamp;?></span>
                                        <span style="margin-left: 15px;"><i class="las la-tag"></i> <?php echo $news_category;?></span>
                                    </div>
                                    <h5 style="font-size: 18px; font-weight: bold; margin-bottom: 10px; color: #002868;">
                                        <a href="news?id=<?php echo $news_id;?>" style="color: #002868; text-decoration: none;"><?php echo $news_title;?></a>
                                    </h5>
                                    <p style="font-size: 14px; color: #666; line-height: 1.6;"><?php echo $news_excerpt;?></p>
                                    <a href="news?id=<?php echo $news_id;?>" class="btn btn-sm" style="margin-top: 15px; background: #002868; color: #fff; border-radius: 20px; padding: 8px 20px; text-decoration: none; display: inline-block;">Дэлгэрэнгүй <i class="las la-arrow-right"></i></a>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                }
            }
            ?>
        </div>
        <div class="row mt-4">
            <div class="col-12 text-center">
                <a href="news" class="btn web-btn rounded-pill">Бүх мэдээлэл <i class="las la-arrow-right"></i></a>
            </div>
        </div>
    </div>
</section>
<!--latest news section end-->

<!--cta section start-->
<section class="cta-sec padding-top padding-bottom" id="cta-sec" style="background: linear-gradient(135deg, #002868 0%, #004080 100%); position: relative; overflow: hidden;">
    <div class="container">
        <div class="row">
            <div class="col-12 col-lg-8 offset-lg-2 text-center">
                <div class="cta-content wow fadeInUp">
                    <h3 style="color: #fff; font-size: 36px; font-weight: bold; margin-bottom: 20px;">Америкаас захиалга хийх хүсэлтэй байна уу?</h3>
                    <p style="color: #fff; font-size: 18px; margin-bottom: 30px;">Бид танд хамгийн хурдан, найдвартай тээврийн үйлчилгээг санал болгох бэлэн байна</p>
                    <div class="cta-buttons">
                        <a href="contact.php" class="btn" style="background: #fff; color: #002868; padding: 15px 40px; border-radius: 30px; font-weight: bold; margin-right: 15px; text-decoration: none; display: inline-block;">Холбогдох</a>
                        <a href="shop" class="btn" style="background: transparent; color: #fff; border: 2px solid #fff; padding: 15px 40px; border-radius: 30px; font-weight: bold; text-decoration: none; display: inline-block;">Дэлгүүр үзэх</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--cta section end-->

<!--testimonial sec start-->
<section class="testimonial-sec padding-top padding-bottom" id="testimonial-sec">
    <svg id="test-header" xmlns="http://www.w3.org/2000/svg" version="1.1" width="100%" height="60" viewBox="0 0 100 100" preserveAspectRatio="none">
        <path d="M0 100 C40 0 60 0 100 100 Z"/>
    </svg>

    <div class="container">
        <div class="testimonial-carousel owl-carousel owl-theme">
            <?php
            $sql = "SELECT * FROM testimonial ORDER BY dd";
            $result = mysqli_query($conn,$sql);
            if ($result) {
                while ($data = mysqli_fetch_array($result))
                {
                    if ($data) {
                        ?>
                        <div class="item text-center">
                            <div class="testimonial-review">
                                <div class="review-image">
                                    <img src="<?php echo htmlspecialchars(fix_image_path($data["thumbnail"] ?? ''));?>">
                                </div>
                                <div class="review-detail">
                                    <h4 class="test-heading"><?php echo htmlspecialchars($data["name"] ?? '');?></h4>
                                    <p class="text-des"><?php echo htmlspecialchars($data["words"] ?? '');?></p>
                                    <ul class="test-review">
                                        <li><a href="#"><i class="las la-star"></i></a></li>
                                        <li><a href="#"><i class="las la-star"></i></a></li>
                                        <li><a href="#"><i class="las la-star"></i></a></li>
                                        <li><a href="#"><i class="las la-star"></i></a></li>
                                        <li><a href="#"><i class="las la-star"></i></a></li>
                                    </ul>
                                </div>
                                <div class="client-info media-body">
                                    <p class="client-designation"><?php echo htmlspecialchars($data["description"] ?? '');?></p>
                                </div>
                            </div>
                        </div>   
                        <?php
                    }
                }
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

<?php require_once("views/footer.php");?>

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