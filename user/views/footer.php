<div class="footer-wrapper">
    <div class="footer-section f-section-1">
        <p class=""><?=settings("footer_text");?></p>
    </div>
    <div class="footer-section f-section-2">
        <p class=""><a href="http://mindsymbol.com/" target="new"><img src="assets/images/mindsymbol.png"></a></p>
    </div>
</div>

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