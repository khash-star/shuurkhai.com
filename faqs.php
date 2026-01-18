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

<? require_once("views/header.php");?>

<!--slider sec strat-->
<section id="slider-sec" class="slider-sec parallax" style="background: url('assets/images/question-mark.jpg');">
    <div class="overlay text-center d-flex justify-content-center align-items-center">
        <div class="slide-contain">
            <h4 class="text-primary">Түгээмэл асуултын хэсэг</h4>
            <div class="crumbs">
                <nav aria-label="breadcrumb" class="breadcrumb-items">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/shuurkhai/">Нүүр</a></li>
                        <li class="breadcrumb-item"><a href="#">Түгээмэл асуулт</a></li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>
<!--slider sec end-->

<section class="featured-items padding-top padding-bottom" id="featured-items">
    <div class="container">
        <div id="accordion">
            <?php
            if (isset($conn) && $conn) {
                $sql = "SELECT * FROM faqs ORDER BY dd";
                $result = mysqli_query($conn, $sql);
                
                if ($result && mysqli_num_rows($result) > 0) {
                    $count = 0;
                    while ($data = mysqli_fetch_array($result)) {
                        if ($data && is_array($data)) {
                            $faqs_id = isset($data["faqs_id"]) ? intval($data["faqs_id"]) : 0;
                            $question = isset($data["question"]) ? htmlspecialchars($data["question"]) : '';
                            $answer = isset($data["answer"]) ? $data["answer"] : '';
                            
                            if (!empty($question) && !empty($answer)) {
                                $count++;
                                $show_first = ($count === 1) ? 'show' : '';
                                ?>
                                <div class="card">
                                    <div class="card-header" id="heading_<?php echo $faqs_id; ?>">
                                        <h5 class="mb-0">
                                            <button class="btn btn-link <?php echo $count > 1 ? 'collapsed' : ''; ?>" type="button" data-toggle="collapse" data-target="#collapse_<?php echo $faqs_id; ?>" aria-expanded="<?php echo $count === 1 ? 'true' : 'false'; ?>" aria-controls="collapse_<?php echo $faqs_id; ?>">
                                                <?php echo $question; ?>
                                            </button>
                                        </h5>
                                    </div>

                                    <div id="collapse_<?php echo $faqs_id; ?>" class="collapse <?php echo $show_first; ?>" aria-labelledby="heading_<?php echo $faqs_id; ?>" data-parent="#accordion">
                                        <div class="card-body">
                                            <?php echo nl2br($answer); ?>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                        }
                    }
                    
                    if ($count === 0) {
                        ?>
                        <div class="alert alert-info" role="alert">
                            <h5 class="alert-heading">Мэдээлэл олдсонгүй</h5>
                            <p>Одоогоор түгээмэл асуулт байхгүй байна.</p>
                        </div>
                        <?php
                    }
                } else {
                    ?>
                    <div class="alert alert-info" role="alert">
                        <h5 class="alert-heading">Мэдээлэл олдсонгүй</h5>
                        <p>Одоогоор түгээмэл асуулт байхгүй байна.</p>
                    </div>
                    <?php
                }
            } else {
                ?>
                <div class="alert alert-warning" role="alert">
                    <h5 class="alert-heading">Холболт алдаатай</h5>
                    <p>Мэдээлэл ачаалж чадсангүй. Дахин оролдоно уу.</p>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
</section>



<?php require_once("views/footer.php");?>


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