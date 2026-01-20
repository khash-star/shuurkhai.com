<!--Footer Start-->
<footer class="footer-style-1">
    <div class="container">
        <div class="row align-items-center">
            <!--Social-->
            <div class="col-lg-12">
                <div class="footer-social text-center">
                    <ul class="list-unstyled">
                        <li><a class="wow fadeInUp" href="<?php echo htmlspecialchars(settings("facebook") ?? '');?>"><i aria-hidden="true" class="lab la-facebook-f"></i></a></li>
                        <li><a class="wow fadeInDown" href="<?php echo htmlspecialchars(settings("youtube") ?? '');?>"><i aria-hidden="true" class="lab la-youtube"></i></a></li>
                        <li><a class="wow fadeInUp" href="<?php echo htmlspecialchars(settings("instagram") ?? '');?>"><i aria-hidden="true" class="lab la-instagram"></i></a></li>
                    </ul>
                </div>
            </div>
            <!--Text-->
            <div class="col-lg-12 text-center">
                <p class="company-about fadeIn"><?php echo htmlspecialchars(settings("footer_text") ?? '');?>
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

<!-- Google Translate -->
<script type="text/javascript">
function googleTranslateElementInit() {
  new google.translate.TranslateElement({
    pageLanguage: 'mn',
    includedLanguages: 'en,zh-CN,zh-TW,ru,ko,ja',
    layout: google.translate.TranslateElement.InlineLayout.SIMPLE,
    autoDisplay: false
  }, 'google_translate_element');
}
</script>
<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
<style>
/* Google Translate Widget Styling */
#google_translate_element {
  display: inline-block !important;
  vertical-align: middle;
  visibility: visible !important;
  opacity: 1 !important;
  position: relative;
  z-index: 1000;
}
#google_translate_element .goog-te-gadget {
  font-family: inherit !important;
}
#google_translate_element .goog-te-gadget-simple {
  background-color: transparent !important;
  border: 1px solid rgba(0,0,0,0.1) !important;
  border-radius: 4px !important;
  padding: 4px 8px !important;
  font-size: 13px !important;
  cursor: pointer;
  display: inline-flex !important;
  align-items: center !important;
}
#google_translate_element .goog-te-gadget-simple .goog-te-menu-value {
  color: inherit !important;
}
#google_translate_element .goog-te-gadget-icon {
  display: inline-block !important;
  margin-right: 5px;
}
/* Hide Google Branding */
.goog-te-banner-frame.skiptranslate {
  display: none !important;
}
body {
  top: 0px !important;
}
/* Style for dropdown */
#google_translate_element select {
  border: 1px solid #ddd;
  border-radius: 4px;
  padding: 5px 10px;
  background: white;
  font-size: 13px;
}
</style>