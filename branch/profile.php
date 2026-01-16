<? require_once("views/login_check.php");?>
<? require_once("config.php");?>
<? require_once("views/helper.php");?>
<? require_once("views/init.php");?>
<body>
    <div class="page-wrapper compact-wrapper" id="pageWrapper">
      <? require_once("views/header.php");?>
      <!-- Page Body Start-->
      <div class="page-body-wrapper sidebar-icon">
        <? require_once("views/sidemenu.php");?>
        <div class="page-body dashboard-2-main">
          <!-- Container-fluid starts-->
          <div class="container-fluid">
           
                    <?  
                    if (isset($_GET["action"])) $action =$_GET["action"]; else $action = "init";

          
                    if ($action=="init")
                    {

                        $sql = "SELECT *FROM branches WHERE id='$g_logged_id'";
                        $result = mysqli_query($conn,$sql);
                        $data = mysqli_fetch_array($result);
                        $avatar = $data["avatar"];
                        $username = $data["username"];
                        $name = $data["name"];
                        $tel = $data["tel"];
                        $email = $data["email"];
                        $avatar = $data["avatar"];

                        ?>
                        
                            
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="card">
                                        <div class="card-body">
                                                <legend>Profile info</legend>

                                                <img class="img-90 rounded-circle" height="90" src="../<?=$avatar;?>" alt="">
        
        
                                                <div class="form-group required">
                                                    <label class="control-label">Name</label>
                                                    <input type="text" class="form-control" id="input-name" placeholder="Name" value="<?=$name;?>" name="name" readonly>
                                                </div>
        
                                                
                                                <div class="form-group required">
                                                    <label for="input-tel" class="control-label">Tel</label>
                                                    <input type="tel" class="form-control" id="input-tel" placeholder="Tel" value="<?=$tel;?>" name="tel" readonly>
                                                </div>
                                               
        
                                                <div class="form-group required">
                                                    <label for="input-email" class="control-label">Mail</label>
                                                    <input type="email" class="form-control" id="input-email" placeholder="Mail" value="<?=$email;?>" name="email" readonly>
                                                </div>
        
                                                <div class="form-group required">
                                                    <label for="input-username" class="control-label">Username</label>
                                                    <input type="text" class="form-control" id="input-username" placeholder="Username" value="<?=$username;?>" name="username" readonly>
                                                </div>

                                        </div>
                                    </div>
                                </div>
                            </div>    
                            
                        </form>
                        <a href="profile?action=edit" class="btn btn-success">Change</a>
                        <?
                    }

                    if ($action=="edit")
                    {
                        $sql = "SELECT *FROM branches WHERE id='$g_logged_id'";
                        $result = mysqli_query($conn,$sql);
                        $data = mysqli_fetch_array($result);
                        $avatar = $data["avatar"];
                        $username = $data["username"];
                        $name = $data["name"];
                        $tel = $data["tel"];
                        $email = $data["email"];

                        ?>
                        <form action="profile?action=editing" method="POST" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="card">
                                        <div class="card-body">
                                            <legend>Profile</legend>

                                            <img class="img-90 rounded-circle" height="90" src="../<?=$avatar;?>" alt="">
                                                
                                            <div class="form-group required">
                                                <input type="file" name="avatar">
                                            </div>


                                            <div class="form-group required">
                                                <label class="control-label">Name</label>
                                                <input type="text" class="form-control" id="input-name" placeholder="Name" value="<?=$name;?>" name="name" required>
                                            </div>
                                            
                                            <div class="form-group required">
                                                <label for="input-tel" class="control-label">Tel</label>
                                                <input type="tel" class="form-control" id="input-tel" placeholder="Tel" value="<?=$tel;?>" name="tel">
                                            </div>
    
                                            <div class="form-group required">
                                                <label for="input-email" class="control-label">Email</label>
                                                <input type="email" class="form-control" id="input-email" placeholder="Email" value="<?=$email;?>" name="email">
                                            </div>

                                            <div class="form-group required">
                                                <label for="input-username" class="control-label">Username</label>
                                                <input type="text" class="form-control" id="input-username" placeholder="Username" value="<?=$username;?>" name="username">
                                            </div>

                                            <i class="text-danger">Required in case of change, otherwise leave it blank</i>
                                            <div class="form-group">
                                                <label for="input-password" class="control-label">New password</label>
                                                <input type="password" class="form-control" id="input-password" placeholder="New password" value="" name="password">
                                            </div>                                    
                                        </div>
                                    </div>                                        
                                    <input type="submit" class="btn btn-success" value="Save">
                                </div>                              
                            </div>                           
                        </form>
                        <?
                    }


                    if ($action=="editing")
                    {
                        ?>
                            <div class="row">
                                <div class="col-sm-12">
                                    <?
                                    $name = $_POST["name"];
                                    $tel = $_POST["tel"];
                                    $email = $_POST["email"];

                                    $username = $_POST["username"];
                                    $password = $_POST["password"];


                                    $sql = "UPDATE branches
                                    SET 
                                    name='$name',
                                    tel='$tel',
                                    email='$email',
                                    username='$username'
                                    WHERE id='$g_logged_id'";
                                    if (mysqli_query($conn,$sql))
                                    echo '<div class="alert alert-success">Successfully changed</div>';    
                                    else 
                                    echo '<div class="alert alert-danger">Error occured '.mysqli_error($conn).'</div>';    

                            

                                 

                                    if ($password<>'')
                                    {
                                        $sql = "UPDATE branches SET password='".sha1($password)."' WHERE id='$g_logged_id'";
                                        if (mysqli_query($conn,$sql))
                                        echo '<div class="alert alert-success">Password changed</div>';    
                                    }     
                                    
                                    if(isset($_FILES['avatar']))
                                    {
                                                 
                                        @$folder = date("Ym");
                                        if(!file_exists('../uploads/'.$folder))
                                        mkdir ( '../uploads/'.$folder);
                                        $target_dir = '../uploads/'.$folder;
                                        $target_file = $target_dir."/".@date("his").rand(0,1000). basename($_FILES["avatar"]["name"]);
                                        move_uploaded_file($_FILES['avatar']['tmp_name'], $target_file);
                                        //$image=settings("base_url").$target_file;
                                    //   $thumb_image_content = resize_image($target_file,300,200);
                                    //   $thumb = substr($target_file,0,-4)."_thumb".substr($target_file,-4,4);
                                    //   imagejpeg($thumb_image_content,$thumb,75);
                                        //$thumb = settings("base_url").$thumb;
                                        $target_file= substr($target_file,3);
                                        $sql = "UPDATE branches SET avatar='$target_file' WHERE id='$g_logged_id'";
                                        mysqli_query($conn,$sql);
                    
                                    }


                                    ?>
                                    <a href="profile?action=edit" class="btn btn-success">Edit</a>
                                    <a href="profile" class="btn btn-primary">Profile</a>
                                </div>
                            </div>                    
                        <?
                    }

                    ?>
                
          </div>
          <!-- Container-fluid Ends-->
        </div>
        <? require_once("views/footer.php");?>
      </div>
    </div>
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
    <script src="assets/js/chart/chartjs/chart.min.js"></script>
    <script src="assets/js/chart/chartist/chartist.js"></script>
    <script src="assets/js/chart/chartist/chartist-plugin-tooltip.js"></script>
    <script src="assets/js/chart/knob/knob.min.js"></script>
    <script src="assets/js/chart/apex-chart/apex-chart.js"></script>
    <script src="assets/js/chart/apex-chart/stock-prices.js"></script>
    <script src="assets/js/prism/prism.min.js"></script>
    <script src="assets/js/clipboard/clipboard.min.js"></script>
    <script src="assets/js/counter/jquery.waypoints.min.js"></script>
    <script src="assets/js/counter/jquery.counterup.min.js"></script>
    <script src="assets/js/counter/counter-custom.js"></script>
    <script src="assets/js/custom-card/custom-card.js"></script>
    <script src="assets/js/owlcarousel/owl.carousel.js"></script>
    <script src="assets/js/owlcarousel/owl-custom.js"></script>
    <script src="assets/js/dashboard/dashboard_2.js"></script>

    <!-- Plugins JS Ends-->
    <!-- Theme js-->
    <script src="assets/js/script.js"></script>
    <!-- login js-->
    <!-- Plugin used-->
  </body>
</html>