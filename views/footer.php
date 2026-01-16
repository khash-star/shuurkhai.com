<!--Footer Start-->
<footer class="footer-style-1">
    <div class="container">
        <div class="row align-items-center">
            <!--Social-->
            <div class="col-lg-12">
                <div class="footer-social text-center">
                    <ul class="list-unstyled">
                        <li><a class="wow fadeInUp" href="<?=settings("facebook");?>"><i aria-hidden="true" class="lab la-facebook-f"></i></a></li>
                        <li><a class="wow fadeInDown" href="<?=settings("youtube");?>"><i aria-hidden="true" class="lab la-youtube"></i></a></li>
                        <li><a class="wow fadeInUp" href="<?=settings("instagram");?>"><i aria-hidden="true" class="lab la-instagram"></i></a></li>
                    </ul>
                </div>
            </div>
            <!--Text-->
            <div class="col-lg-12 text-center">
                <p class="company-about fadeIn"><?=settings("footer_text");?>
                </p>
            </div>
        </div>
    </div>
</footer>
<!--Footer End-->


<!-- Load Facebook SDK for JavaScript -->
<div id="fb-root"></div>
      <script>
        window.fbAsyncInit = function() {
          FB.init({
            xfbml            : true,
            version          : 'v9.0'
          });
        };

        (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = 'https://connect.facebook.net/en_US/sdk/xfbml.customerchat.js';
        fjs.parentNode.insertBefore(js, fjs);
      }(document, 'script', 'facebook-jssdk'));</script>

      <!-- Your Chat Plugin code -->
      <div class="fb-customerchat"
        attribution="setup_tool"
        page_id="752984264811156"
  logged_in_greeting="Сайн байна уу. Танд хэрхэн туслах вэ?"
  logged_out_greeting="Сайн байна уу. Танд хэрхэн туслах вэ?">
      </div>