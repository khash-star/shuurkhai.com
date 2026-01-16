<? require_once("config.php");?>
<? require_once("views/helper.php");?>
<? require_once("views/init.php");?>

<link rel="stylesheet" href="assets/vendor/css/pages/page-auth.css" />
  <body>
    <div class="container-xxl">
      <div class="authentication-wrapper authentication-basic container-p-y">
        <div class="authentication-inner py-4">
          <div class="card">
            <div class="card-body">
              <div class="app-brand text-center mb-4 mt-2">
                <a href="index" class="app-brand-link gap-2">
                  <img src="<?=$g_icon;?>">                
                </a>
                <h4 class="app-brand-text demo text-body fw-bold ms-1">Шуурхай</h4>
              </div>
              <h4 class="mb-1 pt-2"></h4>
              <p class="mb-4">Агентийн эрхээр нэвтэрнэ үү</p>

              <?
              if (isset($_GET["error"]))
              {
                ?>
                <div class="alert alert-danger">
                  <?
                  if ($_GET["error"]=='wrong') echo 'Нэвтрэх мэдээлэл буруу байна';                
                  if ($_GET["error"]=='empty') echo 'мэдээлэл оруулаагүй байна';                
                  ?>
                </div>
                <?
              }
              ?>
              
              <form id="formAuthentication" class="mb-3" action="logining" method="POST">
                <div class="mb-3">
                  <label for="email" class="form-label">Нэвтрэх нэр</label>
                  <input type="text" class="form-control" name="username" placeholder="Нэвтрэх нэр" autofocus />
                </div>
                <div class="mb-3 form-password-toggle">
                  <div class="d-flex justify-content-between">
                    <label class="form-label" for="password">Нууц үг</label>
                    <!-- <a href="auth-forgot-password-basic">
                      <small>Forgot Password?</small>
                    </a> -->
                  </div>
                  <div class="input-group input-group-merge">
                    <input
                      type="password"
                      id="password"
                      class="form-control"
                      name="password"
                      placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                      aria-describedby="password" />
                    <span class="input-group-text cursor-pointer"><i class="ti ti-eye-off"></i></span>
                  </div>
                </div>
                <div class="mb-3">
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="login_remember" name="login_remember"/>
                    <label class="form-check-label" for="login_remember"> Намайг сана </label>
                  </div>
                </div>
                <div class="mb-3 ">
                  <button class="btn btn-primary d-grid w-100" type="submit">Нэвтрэх</button>
                </div>
              </form>                        
            </div>
          </div>
          <!-- /Register -->
        </div>
      </div>
    </div>

    <!-- / Content -->

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->

    <script src="assets/vendor/libs/jquery/jquery.js"></script>
    <script src="assets/vendor/libs/popper/popper.js"></script>
    <script src="assets/vendor/js/bootstrap.js"></script>
    <script src="assets/vendor/libs/node-waves/node-waves.js"></script>
    <script src="assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="assets/vendor/libs/hammer/hammer.js"></script>
    <script src="assets/vendor/libs/i18n/i18n.js"></script>
    <script src="assets/vendor/libs/typeahead-js/typeahead.js"></script>
    <script src="assets/vendor/js/menu.js"></script>

    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="assets/vendor/libs/@form-validation/umd/bundle/popular.min.js"></script>
    <script src="assets/vendor/libs/@form-validation/umd/plugin-bootstrap5/index.min.js"></script>
    <script src="assets/vendor/libs/@form-validation/umd/plugin-auto-focus/index.min.js"></script>

    <!-- Main JS -->
    <script src="assets/js/main.js"></script>

    <!-- Page JS -->
    <script src="assets/js/pages-auth.js"></script>
  </body>
</html>
