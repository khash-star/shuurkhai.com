<?php
    require_once(__DIR__ . "/../config.php");
    require_once(__DIR__ . "/views/helper.php");
    require_once(__DIR__ . "/views/init.php");
?>
<body style="margin:0px;">
    <div class="main-wrapper" >
		<div class="page-wrapper full-page">
			<div class="page-content d-flex align-items-center justify-content-center">

				<div class="row w-100 mx-0 auth-page">
					<div class="col-md-8 col-xl-6 mx-auto">
						<div class="card">
							<div class="row">
                                <div class="col-md-4 pr-md-0">
                                    <div class="auth-left-wrapper">

                                    </div>
                                </div>
                                <?php //$_COOKIE["login_remember"];?>
                                <div class="col-md-8 pl-md-0">
                                    <div class="auth-form-wrapper px-4 py-5">
                                        <a href="index" class="noble-ui-logo d-block mb-2"><img src="/shuurkhai_git/admin/assets/images/logo.png"></a>
                                        <form method="post" action="/shuurkhai_git/admin/views/logining">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Нэвтрэх нэр</label>
                                            <input type="text" class="form-control" placeholder="Нэвтрэх нэр" name="username" value="<?php echo (isset($_COOKIE["login_remember"]))?$_COOKIE["login_remember"]:'';?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Нууц үг</label>
                                            <input type="password" class="form-control"  placeholder="Нууц үг" name="password">
                                        </div>
                                        <div class="form-check form-check-flat form-check-primary">
                                            <label class="form-check-label">
                                            <input type="checkbox" class="form-check-input" <?php echo (isset($_COOKIE["login_remember"]))?'checked':'';?> name="login_remember">
                                            Намайг сана
                                            </label>
                                        </div>
                                        <div class="mt-3">
                                            <input type="submit" class="btn btn-primary mr-2 mb-2 mb-md-0 text-white" value="Нэвтрэх">
                                            <!-- <a href="../../dashboard-one.html" class="btn btn-primary mr-2 mb-2 mb-md-0 text-white">Login</a> -->
                                            <!-- <button type="button" class="btn btn-outline-primary btn-icon-text mb-2 mb-md-0">
                                            <i class="btn-icon-prepend" data-feather="twitter"></i>
                                            Login with twitter
                                            </button> -->
                                        </div>
                                        <!-- <a href="register.html" class="d-block mt-3 text-muted">Not a user? Sign up</a> -->
                                        </form>
                                    </div>
                                </div>
                            </div>
						</div>
					</div>
				</div>

			</div>
		</div>
	</div>

	<!-- core:js -->
	<script src="/shuurkhai_git/admin/assets/vendors/core/core.js"></script>
	<!-- endinject -->
  <!-- plugin js for this page -->
	<!-- end plugin js for this page -->
	<!-- inject:js -->
	<script src="/shuurkhai_git/admin/assets/vendors/feather-icons/feather.min.js"></script>
	<script src="/shuurkhai_git/admin/assets/js/template.js"></script>
	<!-- endinject -->
  <!-- custom js for this page -->
	<!-- end custom js for this page -->
</body>
</html>