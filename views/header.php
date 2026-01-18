<?php $current_page = basename($_SERVER['REQUEST_URI'], '?' . $_SERVER['QUERY_STRING']);?>

<!--Header Start-->
<header id="header">
    <ul class="d-flex mb-0 top-info">
        <li class="c-links d-none d-lg-block"><span><i class="las la-phone-volume"></i></span><a href="tel:<?php echo htmlspecialchars(settings("tel") ?? '');?>"><?php echo htmlspecialchars(settings("tel") ?? '');?></a></li>
        <li class="c-links d-none d-lg-block"><span><i class="la la-envelope"></i></span><a href="mailto:<?php echo htmlspecialchars(settings("email") ?? '');?>"><?php echo htmlspecialchars(settings("email") ?? '');?></a></li>
    </ul>
    <div class="upper-nav">
        <div class="container">
            <div class="row">
               
                <div class="col-12 d-flex justify-content-center align-items-center">
                    <a class="navbar-brand pt-0 mt-0" href="index.php"><img src="assets/images/logo.png"></a>
                </div>
            </div>
        </div>
    </div>
    <!--Navigation-->

    <nav class="navbar navbar-top-default navbar-expand-lg navbar-simple nav-line">
        <div class="container">
        <div class="row no-gutters w-100">
            <div class="col-6 col-lg-3 offset-3 offset-lg-0">
                <a href="index.php" title="Logo" class="logo fixed-nav-items">
                    <!--Logo Default-->
                    <img src="assets/images/logo-sm.png" alt="logo" class="logo-dark">
                </a>
            </div>
            <!--Nav Links-->
            <div class="col-6 d-none d-lg-flex justify-content-lg-center align-items-lg-center">
                <div class="collapse navbar-collapse" id="megaone">
                    <ul class="navbar-nav ml-auto mr-auto">
                        <li class="nav-item"><a class="nav-link <?php echo ($current_page=="index" || $current_page=="index.php")?'active':'';?>" href="index.php"><i class="las la-home d-none d-md-inline"></i> Hүүр</a></li>
                        <li class="nav-item"><a class="nav-link <?php echo ($current_page=="about" || $current_page=="about.php")?'active':'';?>" href="about"><i class="las la-info-circle d-none d-md-inline"></i> Танилцуулга</a></li>
                        <li class="nav-item"><a class="nav-link <?php echo ($current_page=="shop" || $current_page=="shop.php")?'active':'';?>" href="shop"><i class="las la-store d-none d-md-inline"></i> Дэлгүүр</a></li>
                        <li class="nav-item"><a class="nav-link <?php echo ($current_page=="news" || $current_page=="news.php")?'active':'';?>" href="news"><i class="las la-newspaper d-none d-md-inline"></i> Мэдээлэл</a></li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle <?php echo ($current_page=="faqs" || $current_page=="faqs.php")?'active':'';?>" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="las la-question-circle d-none d-md-inline"></i> Тусламж <i class="fas fa-angle-down"></i>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="faqs"><i class="las la-question"></i> Түгээмэл асуулт</a>
                                <a class="dropdown-item" href="https://www.youtube.com/channel/UCiTB2QBzh8S_oo9_CeVyuuw" target="new"><i class="lab la-youtube"></i> Гарын авлага</a>
                            </div>
                        </li>
                        <li class="nav-item"><a class="nav-link <?php echo ($current_page=="contact" || $current_page=="contact.php")?'active':'';?>" href="contact.php"><i class="las la-envelope d-none d-md-inline"></i> Холбогдох</a></li>
                    </ul>
                </div>
            </div>
            <!--Side Menu Button-->
            <div class="col-3 d-flex justify-content-end align-items-center">

                <ul class="shop-details fixed-nav-items">
                    <li>
                            <a href="user/" title="Нэвтрэх"><i class="la la-user"></i></a>
                    </li>
                    <!-- <li>
                        <a href="javascript:void(0)" class="open_search"><i class="las la-search"></i></a>
                    </li>
                    <li><a href="javascript:void(0)" id="open-shop-card1"><i class="las la-shopping-bag"></i></a></li> -->
                </ul>
            </div>
        </div>
        </div>
    </nav>
    <a href="user/" title="Нэвтрэх" class="login-button btn btn-danger text-white"><i class="las la-user-circle"></i> Нэвтрэх</a>
    <a id="close_side_menu" href="javascript:void(0);"></a>
    <!-- End side menu -->
    <svg id="header-svg" xmlns="http://www.w3.org/2000/svg" version="1.1" width="100%" height="60" viewBox="0 0 100 100" preserveAspectRatio="none">
        <path d="M0 100 C40 0 60 0 100 100 Z"/>
    </svg>
    <a href="javascript:void(0)" class="sidemenu_btn" id="sidemenu_toggle">
        <span></span>
        <span></span>
        <span></span>
    </a>
</header>
<!--Header End-->

    <!--Side Nav-->
    <div class="side-menu hidden">
        <div class="inner-wrapper">
            <span class="btn-close" id="btn_sideNavClose"><i></i><i></i></span>
            <nav class="side-nav w-100">
                <ul class="navbar-nav">
                        <li class="nav-item"><a class="nav-link " href="index.php">Hүүр</a></li>
                        <li class="nav-item"><a class="nav-link " href="about">Танилцуулга</a></li>
                        <li class="nav-item"><a class="nav-link " href="shop">Дэлгүүр</a></li>
                        <li class="nav-item"><a class="nav-link " href="news">Мэдээлэл</a></li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Тусламж <i class="fas fa-angle-down"></i>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="faqs"><i class="las la-angle-double-right"></i> Түгээмэл асуулт</a>
                                <a class="dropdown-item" href="https://www.youtube.com/channel/UCiTB2QBzh8S_oo9_CeVyuuw" target="new"><i class="las la-angle-double-right"></i> Гарын авлага</a>
                            </div>
                        </li>
                        <li class="nav-item"><a class="nav-link" href="contact.php">Холбогдох</a></li>


                    <!-- <li class="nav-item">
                        <a class="nav-link scroll" href="#header">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="assets/about-us.html">About Us</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown1" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Pages <i class="fas fa-angle-down"></i>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown1">
                            <a class="dropdown-item" href="assets/product-listing.html"><i class="las la-angle-double-right"></i> Product Listing</a>
                            <a class="dropdown-item" href="assets/product-detail.html"><i class="las la-angle-double-right"></i> Product Detail</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#"><i class="las la-angle-double-right"></i> Standalone</a>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="assets/product-listing.html">Shop</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="assets/standard-blog.html">Blogs</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="assets/contact-us.html">Contact Us</a>
                    </li> -->
                </ul>
            </nav>

            <div class="side-footer w-100">
                <ul class="social-icons-simple">
                    <li><a class="facebook-text-hvr" href="<?php echo htmlspecialchars(settings("facebook") ?? '');?>"><i class="fab fa-facebook-f"></i> </a> </li>
                    <li><a class="youtube-text-hvr" href="<?php echo htmlspecialchars(settings("youtube") ?? '');?>"><i class="fab fa-youtube"></i> </a> </li>
                    <li><a class="instagram-text-hvr" href="<?php echo htmlspecialchars(settings("instagram") ?? '');?>"><i class="fab fa-instagram"></i> </a> </li>
                </ul>
                <p class="text-dark"><?php echo htmlspecialchars(settings("footer_text") ?? '');?></p>
            </div>
        </div>
    </div>