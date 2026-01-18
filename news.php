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
<section id="slider-sec" class="slider-sec parallax" style="background: url('assets/images/news-bg.jpg');">
    <div class="overlay text-center d-flex justify-content-center align-items-center">
        <div class="slide-contain">
            <h4>Мэдээ, мэдээлэл</h4>
            <div class="crumbs">
                <nav aria-label="breadcrumb" class="breadcrumb-items">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.php">Нүүр</a></li>
                        <li class="breadcrumb-item"><a href="#">Мэдээлэл</a></li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>
<!--slider sec end-->


<!--main page content-->
<section class="main">
    <div class="blog-content padding-top padding-bottom">
        <div class="container">
            <div class="row">
                <div class="col-12 col-lg-8 order-1">
                    <?
                    if (!isset($_GET["id"]))
                    {
                        ?>
                        <div class="main_content text-center text-lg-left">
                            <?php
                            if (isset($conn) && $conn) {
                                $sql = "SELECT news.*, news_category.name category_name FROM news LEFT JOIN news_category ON news.category = news_category.id ORDER BY timestamp DESC LIMIT 20";
                                $result = mysqli_query($conn,$sql);
                                if ($result && mysqli_num_rows($result) > 0) {
                                    while ($data = mysqli_fetch_array($result)) {
                                        if ($data && is_array($data)) {
                                            $thumb = isset($data["thumb"]) ? htmlspecialchars(fix_image_path($data["thumb"])) : '';
                                            $title = isset($data["title"]) ? htmlspecialchars($data["title"]) : '';
                                            $category_name = isset($data["category_name"]) ? htmlspecialchars($data["category_name"]) : '';
                                            $timestamp = isset($data["timestamp"]) ? substr($data["timestamp"],0,10) : '';
                                            $id = isset($data["id"]) ? $data["id"] : '';
                                            ?>
                                            <div class="single_blog">
                                                <div class="single_img">
                                                    <img src="<?php echo $thumb;?>" alt="<?php echo $title;?>"/>
                                                </div>
                                                <div class="single_detail">
                                                    <p class="blog-sub-heading text-center"><span></span><?php echo $category_name;?></p>
                                                    <h2><?php echo $title;?></h2>
                                                    <span class="blog-text"><a href="#"><?php echo $timestamp;?></a> | BY <a href="#">Shuurkhai</a> | <a href="#"><?php echo $category_name;?></a></span>
                                                    <!-- <p class="p-text">Nam ut rutrum ex, venenatis sollicitudin urna. Aliquam erat volutpat. Integer eu ipsum sem. Ut bibendum lacus vestibulum maximus suscipit. Quisque vitae nibh iaculis...</p> -->
                                                    <a class="btn web-btn rounded-pill" href="news?id=<?php echo $id;?>">Унших</a>
                                                </div>
                                            </div>
                                            <?php
                                        }
                                    }
                                }
                            }
                            ?>
                        </div>
                        <?
                    }
                    ?>

                    <?
                    if (isset($_GET["id"]))
                    {
                        $news_id =$_GET["id"];
                        ?>
                        <div class="main_content text-center text-lg-left">
                            <?php
                            if (isset($conn) && $conn && isset($news_id)) {
                                $news_id = mysqli_real_escape_string($conn, $news_id);
                                $sql = "SELECT news.*, news_category.name category_name FROM news LEFT JOIN news_category ON news.category = news_category.id WHERE news.id='$news_id'";
                                $result = mysqli_query($conn,$sql);
                                if ($result && mysqli_num_rows($result) > 0) {
                                    $data = mysqli_fetch_array($result);
                                    if ($data && is_array($data)) {
                                        $category_name = isset($data["category_name"]) ? htmlspecialchars($data["category_name"]) : '';
                                        $title = isset($data["title"]) ? htmlspecialchars($data["title"]) : '';
                                        $timestamp = isset($data["timestamp"]) ? substr($data["timestamp"],0,10) : '';
                                        $image = isset($data["image"]) ? htmlspecialchars(fix_image_path($data["image"])) : '';
                                        $content = isset($data["content"]) ? $data["content"] : '';
                                        ?>
                                        <div class="detail_blog">
                                            <div class="blog_detail">
                                                <p class="blog-sub-heading text-center"><span></span><?php echo $category_name;?></p>
                                                <h2><?php echo $title;?></h2>
                                                <span class="blog-text"><a href="#"><?php echo $timestamp;?></a> | BY <a href="#">Shuurkhai</a> | <a href="#"><?php echo $category_name;?></a></span>
                                                <img src="<?php echo $image;?>" class="w-100">
                                                <p class="d-text"><?php echo $content;?></p>

                                        <div class="row social">
                                            <!-- <div class="col-12 col-md-8 tags pb-3 pb-md-0">
                                                <span><a href=""> Image</a></span>
                                                <span><a href="">Project</a></span>
                                                <span><a href="">Studio</a></span>
                                            </div> -->
                                            <div class="col-12 col-md-4 social-tags text-center text-md-right">
                                                <span class="fb"><a href=""> <i class="fab fa-facebook-f"></i></a></span>
                                                <span class="twit"><a href=""><i class="fab fa-twitter"></i></a></span>
                                                <span class="in"><a href=""><i class="fab fa-linkedin-in"></i></a></span>
                                                <span class="pin"><a href=""><i class="fab fa-pinterest-p"></i></a></span>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="writer-detail">
                                    <div class="post_navigation">
                                        <div class="row">
                                            <div class="col-6 left-row text-left">
                                                <div class="row">
                                                    <div class="col-12 col-md-2 text-right text-md-left">
                                                        <a href=""><i class="fa fa-angle-left"></i></a>
                                                    </div>
                                                    <div class="col-10 left-arr-d d-none d-md-block">
                                                        <span class="links">Өмнөх</span>
                                                        <h5>Standard Post with a Video</h5>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6 right-row text-right">
                                                <div class="row">
                                                    <div class="col-10 right-arr-d d-none d-md-block">
                                                        <span class="links">Дараах</span>
                                                        <h5>Standard Post with a Video</h5>
                                                    </div>
                                                    <div class="col-2">
                                                        <a href=""><i class="fa fa-angle-right"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>
                                        <?php
                                    }
                                }
                            }
                            ?>
                        </div>
                        <?
                    }
                    ?>
                    
                </div>
                <div class="col-12 col-lg-4 side-bar order-3 order-lg-2">
                    <div class="row">
                        <div class="col-12">
                            <div class="side_tags">
                                <div class="search-bar">
                                    <form method="get" id="searchform" action="#" role="search">
                                        <label class="sr-only" for="s">Хайх</label>
                                        <div class="input-group">
                                            <input class="field form-control" id="s" name="s" type="text" placeholder="Search …" value="">
                                            <span class="input-group-append">
                                                <button class="submit btn-search" id="searchsubmit" name="submit" type="submit"><i class="fa fa-search"></i></button>
                                            </span>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="cat_sec">
                                <h4 class="text-center text-lg-left">Ангилал</h4>
                                <ul>
                                    <?php
                                    if (isset($conn) && $conn) {
                                        $sql = "SELECT * FROM news_category";
                                        $result = mysqli_query($conn,$sql);
                                        if ($result && mysqli_num_rows($result) > 0) {
                                            while ($data = mysqli_fetch_array($result)) {
                                                if ($data && is_array($data)) {
                                                    $name = isset($data["name"]) ? htmlspecialchars($data["name"]) : '';
                                                    ?>
                                                    <li><a href="#"><?php echo $name;?> </a> <span class="dots"></span> <p>2</p></li>
                                                    <?php
                                                }
                                            }
                                        }
                                    }
                                    ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--main page content end-->



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