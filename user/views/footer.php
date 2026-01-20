<div class="footer-wrapper">
    <div class="footer-section f-section-1">
        <p class=""><?php echo htmlspecialchars(settings("footer_text") ?? ''); ?></p>
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

<!-- Google Translate Scripts -->
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
  border-radius: 6px !important;
  padding: 2px 6px !important;
  font-size: 11px !important;
  cursor: pointer;
  display: inline-flex !important;
  align-items: center !important;
  line-height: 1.2 !important;
  min-height: auto !important;
}
#google_translate_element .goog-te-gadget-simple .goog-te-menu-value {
  color: inherit !important;
}
#google_translate_element .goog-te-gadget-icon {
  display: inline-block !important;
  margin-right: 3px;
  width: 12px !important;
  height: 12px !important;
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
  border-radius: 6px;
  padding: 3px 8px;
  background: white;
  font-size: 11px;
  height: auto !important;
}
</style>