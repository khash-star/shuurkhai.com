<?php require_once("config.php");?>
<?php require_once("views/helper.php");?>
<?php require_once("views/init.php");?>

  <body>
    <!-- Loader starts-->
    <div class="loader-wrapper">
      <div class="theme-loader">    
        <div class="loader-p"></div>
      </div>
    </div>
    <!-- Loader ends-->
    <!-- page-wrapper Start-->
    <section>         
      <div class="container-fluid p-0">
        <div class="row">
          <div class="col-12">
            <div class="login-card">
              <form class="theme-form login-form" action="login" method="POST">
                <div class="text-center"><img src="assets/images/logo.png" class="w-50"></div>
                <h4>Login</h4>                
                <?php
                  if (isset($_POST["username"]) && isset($_POST["password"]))
                  {

                      $username = protect($_POST["username"]);
                      $password = protect($_POST["password"]);
                      // $type = protect($_POST["type"]);

                      if(isset($_POST["login_remember"])) {
                          unset($_COOKIE['login_remember']);
                          //echo "setting cookie[";
                          setcookie ("login_remember",$username,time()+ (10 * 365 * 24 * 60 * 60),'/');
                          // setcookie ("login_type",$type,time()+ (10 * 365 * 24 * 60 * 60),'/');
                          //echo $_COOKIE['login_remember']."]";
                      } else {
                          unset($_COOKIE['login_remember']);
                      }

            
                            $sql = "SELECT *FROM branches WHERE username='$username' AND password=sha1('$password')";                      
                            // echo $sql;
                    
                            $result = mysqli_query($conn,$sql);
      
                            if (mysqli_num_rows($result)==1)
                            {
                                
                                // echo mysqli_num_rows($result);
                                $data = mysqli_fetch_array($result);
                            
                                // session_start();
                                $_SESSION['branch_logged_id'] = $data['id'];
                                $_SESSION['branch_logged_name'] = $data['name'];
                                $_SESSION['branch_logged_avatar'] = $data['avatar'];
                                $_SESSION['branch_logged_tel'] = $data['tel'];
                                $_SESSION['branch_logged_email'] = $data['email'];
                                $_SESSION['branch_logged'] = TRUE;
        
                                $sql = "UPDATE branches SET logged_date='".date("Y-m-d H:i:s")."' WHERE username='$username'";
                                mysqli_query($conn,$sql);
                                header("location:branch");
                                // echo "<script>window.location.href='dashboard';</script>";
                                // exit;
                          
      
                            }
                            else 
                            {
                              ?>
                              <div class="alert alert-danger" role="alert">
                                  <div class="alert-body d-flex align-items-center">
                                      <i data-feather="info" class="me-50"></i>
                                      <span>Failed to login please check username and password. <br>
                                           <a href="login">Try again</a>.
                                      </span>                                        
                                  </div>
                              </div>                                
                              <?php

                            }
                      

                      
                      
                  }
                  else 
                  {
                    ?>

                    <div class="form-group">
                      <label>Username</label>
                      <div class="input-group"><span class="input-group-text"><i class="icon-user"></i></span>
                        <input class="form-control" type="text" required="" placeholder="Username" name="username" value="<?=(isset($_COOKIE['login_remember']))?$_COOKIE['login_remember']:'';?>">
                      </div>
                    </div>
                    <div class="form-group">
                      <label>Password</label>
                      <div class="input-group"><span class="input-group-text"><i class="icon-lock"></i></span>
                        <input class="form-control" type="password" name="password" required="" placeholder="Password">                    
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="checkbox">
                        <input id="checkbox1" type="checkbox" name="login_remember" <?=(isset($_COOKIE['login_remember']))?'checked':'';?>>
                        <label for="checkbox1">Remember me</label>
                      </div>
                      <!-- <a class="link" href="recover">Нууц үг мартсан уу?</a> -->
                    </div>
                    <div class="form-group">
                      <button class="btn btn-primary" type="submit">Sign in</button>
                    </div>
                    <?php
                  }
                  ?>
                <!-- <div class="login-social-title">                
                  <h5>Бүртгүүлэх</h5>
                </div> -->
              
                <!-- <p>Бүртгэлгүй бол <a class="ms-2" href="register">энд дарж бүртгүүлнэ үү</a></p> -->
              </form>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- page-wrapper end-->
    <!-- latest jquery-->
    <script src="assets/js/jquery-3.5.1.min.js"></script>
    <!-- feather icon js-->
    <script src="assets/js/icons/feather-icon/feather.min.js"></script>
    <script src="assets/js/icons/feather-icon/feather-icon.js"></script>
    <!-- Sidebar jquery-->
    <script src="assets/js/sidebar-menu.js"></script>
    <script src="assets/js/config.js"></script>
    <!-- Bootstrap js-->
    <script src="assets/js/bootstrap/popper.min.js"></script>
    <script src="assets/js/bootstrap/bootstrap.min.js"></script>
    <!-- Plugins JS start-->
    <!-- Plugins JS Ends-->
    <!-- Theme js-->
    <script src="assets/js/script.js"></script>
    <!-- login js-->
    <script>
      // Ensure loader is hidden after page loads
      $(document).ready(function() {
        $('.loader-wrapper').fadeOut('slow', function() {
          $(this).remove();
        });
      });
    </script>
    <!-- Plugin used-->
  </body>
</html>