<?php require_once("config.php");?>
<?php require_once("views/helper.php");?>
<?php require_once("views/init.php");?>
<?php require_once(__DIR__ . "/../lib/csrf_helper.php"); // CSRF protection ?>
    <link href="assets/css/authentication/form-1.css" rel="stylesheet" type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->
    <link rel="stylesheet" type="text/css" href="assets/css/forms/theme-checkbox-radio.css">
    <link rel="stylesheet" type="text/css" href="assets/css/forms/switches.css">
    <link rel="stylesheet" type="text/css" href="assets/css/elements/alert.css">


<body class="form">
    <div class="form-container">
        <div class="form-form">
            <div class="form-form-wrap">
                <div class="form-container">
                    <div class="form-content">
                    <?php //$_COOKIE["login_remember"];?>
                        <a href="https://shuurkhai.com"><img src="assets/images/logo.png" class="pb-3"></a>
                        <p class="signup-link">Шинэ бүртгэл <a href="register">энд дарж</a> үүсгэнэ</p>
                        <form class="text-left" method="post" action="views/logining">
                            <?php echo csrf_field(); // CSRF token ?>
                            <div class="form">
                                <?php
                                 if (isset($_GET["error"]))
                                 {
                                     ?>
                                     <div class="alert alert-arrow-left alert-icon-left alert-light-danger mb-4" role="alert">
                                         <button type="button" class="close" data-dismiss="alert" aria-label="Close"><svg xmlns="http://www.w3.org/2000/svg" data-dismiss="alert" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button>
                                         <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bell"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
                                         <b>Нууц үг буруу байна
                                     </div>
                                     <?php
                                 }
                                ?>
                                <div id="username-field" class="field-wrapper input">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                                    <input id="username" name="username" type="text" class="form-control" placeholder="Нэвтрэх нэр" autocomplete="off" value="<?php echo htmlspecialchars((isset($_COOKIE["login_remember"]))?$_COOKIE["login_remember"]:'');?>">
                                </div>

                                <div id="password-field" class="field-wrapper input mb-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-lock"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                                    <input id="password" name="password" type="password" class="form-control" placeholder="Нууц үг">
                                </div>
                                <div class="d-sm-flex justify-content-between">
                                    <!-- <div class="field-wrapper toggle-pass">
                                        <p class="d-inline-block">Show Password</p>
                                        <label class="switch s-primary">
                                            <input type="checkbox" id="toggle-password" class="d-none">
                                            <span class="slider round"></span>
                                        </label>
                                    </div> -->
                                    <div class="field-wrapper">
                                        <button type="submit" class="btn btn-primary" value="">Нэвтрэх</button>
                                    </div>
                                    
                                </div>

                                <div class="field-wrapper text-center keep-logged-in">
                                    <div class="n-chk new-checkbox checkbox-outline-primary">
                                        <label class="new-control new-checkbox checkbox-outline-primary">
                                          <input type="checkbox" class="new-control-input"  <?php echo (isset($_COOKIE["login_remember"]))?'checked':'';?> name="login_remember">
                                          <span class="new-control-indicator"></span>Намайг сана
                                        </label>
                                    </div>
                                </div>

                                <div class="field-wrapper">
                                    <a href="recover" class="forgot-pass-link">Нууц үг мартсан?</a>
                                </div>

                            </div>
                        </form>                        
                        <p class="terms-conditions"><?php echo htmlspecialchars(settings("footer_text") ?? '');?></p>

                    </div>                    
                </div>
            </div>
        </div>
        <div class="form-image">
            <div class="l-image" id="login-video-container">
                <?php
                // Get YouTube video URL from settings
                $youtube_url = '';
                if (function_exists('settings')) {
                    $youtube_url = settings('youtube_video') ?? settings('youtube') ?? '';
                }
                
                // Extract YouTube video ID
                $video_id = '';
                if (!empty($youtube_url)) {
                    // Pattern for youtube.com/watch?v=VIDEO_ID
                    if (preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/|youtube\.com\/embed\/)([a-zA-Z0-9_-]{11})/', $youtube_url, $matches)) {
                        $video_id = $matches[1];
                    }
                }
                
                if (!empty($video_id)) {
                    // Store video ID in data attribute for JavaScript
                    ?>
                    <div id="youtube-placeholder" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: #002868; display: flex; align-items: center; justify-content: center;">
                        <div style="color: white; font-size: 14px;">Ачааллаж байна...</div>
                    </div>
                    <iframe 
                        id="youtube-video" 
                        data-video-id="<?php echo htmlspecialchars($video_id); ?>"
                        frameborder="0" 
                        allow="autoplay; encrypted-media" 
                        allowfullscreen
                        style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover; pointer-events: none; opacity: 0; transition: opacity 0.5s;">
                    </iframe>
                    <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: linear-gradient(to bottom, rgba(0,40,104,0.3), rgba(0,40,104,0.7)); pointer-events: none; z-index: 1;"></div>
                    <?php
                }
                ?>
            </div>
        </div>
    </div>

    
    <!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
    <script src="assets/js/libs/jquery-3.1.1.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
    
    <!-- END GLOBAL MANDATORY SCRIPTS -->
    <script src="assets/js/authentication/form-1.js"></script>
    
    <script>
    // Stable YouTube video loading - always loads consistently
    (function() {
        var youtubeIframe = document.getElementById('youtube-video');
        var placeholder = document.getElementById('youtube-placeholder');
        
        if (!youtubeIframe) {
            return;
        }
        
        var videoId = youtubeIframe.getAttribute('data-video-id');
        if (!videoId) {
            if (placeholder) {
                placeholder.style.display = 'none';
            }
            return;
        }
        
        // Build YouTube embed URL with all necessary parameters
        var embedUrl = 'https://www.youtube.com/embed/' + videoId + 
            '?autoplay=1' +
            '&mute=1' +
            '&loop=1' +
            '&playlist=' + videoId +
            '&controls=0' +
            '&showinfo=0' +
            '&rel=0' +
            '&iv_load_policy=3' +
            '&enablejsapi=1' +
            '&origin=' + encodeURIComponent(window.location.origin);
        
        var isLoaded = false;
        var loadTimeout = null;
        
        function showVideo() {
            if (isLoaded) {
                return;
            }
            isLoaded = true;
            youtubeIframe.style.opacity = '1';
            if (placeholder) {
                placeholder.style.display = 'none';
            }
        }
        
        function loadVideo() {
            // Clear any existing timeout
            if (loadTimeout) {
                clearTimeout(loadTimeout);
            }
            
            // Always set the src - this ensures it loads on every refresh
            youtubeIframe.src = embedUrl;
            
            // Set up load event listener
            var loadHandler = function() {
                showVideo();
                youtubeIframe.removeEventListener('load', loadHandler);
            };
            
            youtubeIframe.addEventListener('load', loadHandler);
            
            // Fallback: show video after 2 seconds even if load event doesn't fire
            loadTimeout = setTimeout(function() {
                if (!isLoaded) {
                    showVideo();
                }
            }, 2000);
            
            // Additional check: if iframe content is accessible
            setTimeout(function() {
                try {
                    if (youtubeIframe.contentWindow && !isLoaded) {
                        showVideo();
                    }
                } catch (e) {
                    // Cross-origin, that's fine - rely on load event
                }
            }, 1500);
        }
        
        // Load video immediately when script runs
        loadVideo();
        
        // Also ensure it loads when DOM is ready
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', loadVideo);
        } else {
            // DOM already ready, but ensure video loads
            setTimeout(loadVideo, 100);
        }
        
        // Handle page visibility - reload if page becomes visible
        document.addEventListener('visibilitychange', function() {
            if (!document.hidden && !isLoaded) {
                loadVideo();
            }
        });
        
        // Preload YouTube iframe API for better compatibility
        if (!window.YT && !window.YTConfig) {
            var tag = document.createElement('script');
            tag.src = 'https://www.youtube.com/iframe_api';
            tag.async = true;
            var firstScriptTag = document.getElementsByTagName('script')[0];
            if (firstScriptTag && firstScriptTag.parentNode) {
                firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
            }
        }
    })();
    </script>

</body>
</html>