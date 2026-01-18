<?php require_once(__DIR__ . "/../config.php");?>
<?php require_once(__DIR__ . "/../views/helper.php");?>
<?php require_once(__DIR__ . "/../views/init.php");?>
    <link href="assets/css/authentication/form-1.css" rel="stylesheet" type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->
    <link rel="stylesheet" type="text/css" href="assets/css/forms/theme-checkbox-radio.css">
    <link rel="stylesheet" type="text/css" href="assets/css/forms/switches.css">
    <link rel="stylesheet" type="text/css" href="assets/css/elements/alert.css">
    <style>
        /* Fix icon and input alignment and width */
        .field-wrapper.input {
            display: flex !important;
            align-items: center !important;
            gap: 10px !important;
            max-width: 100% !important;
            width: 100% !important;
            box-sizing: border-box !important;
        }
        .field-wrapper.input svg {
            flex-shrink: 0 !important;
            display: inline-block !important;
            vertical-align: middle !important;
        }
        .field-wrapper.input input,
        .field-wrapper.input .form-control {
            flex: 1 !important;
            min-width: 0 !important;
            max-width: calc(100% - 34px) !important;
            width: auto !important;
            box-sizing: border-box !important;
        }
        .form-content {
            max-width: 100% !important;
            width: 100% !important;
            box-sizing: border-box !important;
        }
        .form-container {
            max-width: 100% !important;
            width: 100% !important;
            box-sizing: border-box !important;
        }
        form .form {
            max-width: 100% !important;
            width: 100% !important;
            box-sizing: border-box !important;
        }
    </style>


<body class="form">
    <div class="form-container">
        <div class="form-form">
            <div class="form-form-wrap">

                <?php
                    if (isset($_POST["username"]) && $_POST["username"]<>"" && $_POST["tel"]<>"" && $_POST["name"]<>"" && $_POST["password"]<>"")
                        {
                            $username=protect($_POST["username"]);
                            $tel=protect($_POST["tel"]);
                            $name=protect($_POST["name"]);
                            $surname=protect($_POST["surname"]);
                            $password=protect($_POST["password"]);
                            $email=protect($_POST["email"]);

                            $sql = "SELECT *FROM customer WHERE username='$username' OR tel='$tel'";
                            $result = mysqli_query($conn,$sql);
                            if (mysqli_num_rows($result)>0)
                            {
                                ?>
                                <div class="alert alert-arrow-left alert-icon-left alert-light-danger mb-4" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><svg xmlns="http://www.w3.org/2000/svg" data-dismiss="alert" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bell"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
                                    Нэвтрэх нэр, утас бүртгэлтэй байна. <b>Та нууц үгээ сэргээх авах боломжтой <a href="recover"> энд дар уу</a></b> 
                                </div>
                                <?php
                            }
                            else 
                           {
                                $sql = "INSERT INTO customer (name,surname,tel,email,username,password,registered_date,status) 
                                VALUES('".$name."','".$surname."','".$tel."','".$email."','".$username."','".$password."','".date("Y-m-d H:i:s")."','pending')";
                                
                                                                        
                                if (mysqli_query($conn,$sql))
                                {
                                    ?>
                                    <div class="alert alert-arrow-left alert-icon-left alert-light-success mb-4" role="alert">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><svg xmlns="http://www.w3.org/2000/svg" data-dismiss="alert" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bell"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
                                        Амжилттай бүртгэлээ. Та <a href="login">энд дарж</a> нэвтрэн орж өөрийн хаягаа оруулна уу. 
                                        
                                    </div>
                                    <?php
                                    //header("location:login",2);
                                    
                                }
                                else 
                                {
                                    ?>
                                    <div class="alert alert-arrow-left alert-icon-left alert-light-danger mb-4" role="alert">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><svg xmlns="http://www.w3.org/2000/svg" data-dismiss="alert" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bell"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
                                        Алдаа гарлаа: <?=isset($conn) ? mysqli_error($conn) : "Database connection not found";?>
                                    </div>
                                    <?php
                                }
                           }

                        }
                    ?>
                <div class="form-container">
                    
                    <div class="form-content">
                        <a href="https://shuurkhai.com"><img src="assets/images/logo.png" class="pb-3"></a>
                        <p class="signup-link">Бүртгэлтэй бол <a href="login">энд дарж</a> нэвтрэнэ</p>
                        <form class="text-left" method="post" action="register">
                            <div class="form">
                                <div id="name-field" class="field-wrapper input">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                                    <input id="name" name="name" type="text" class="form-control" placeholder="Таны нэр (*)" required id="name">
                                </div>

                                <div id="surname-field" class="field-wrapper input">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                                    <input id="surname" name="surname" type="text" class="form-control" placeholder="Таны овог (*)" required>
                                </div>


                                <div id="email-field" class="field-wrapper input">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-at-sign"><circle cx="12" cy="12" r="4"></circle><path d="M16 8v5a3 3 0 0 0 6 0v-1a10 10 0 1 0-3.92 7.94"></path></svg>
                                    <input id="email" name="email" type="email" value="" placeholder="Имэйл" >
                                </div>
                                <div id="tel-field" class="field-wrapper input">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-phone-call"><path d="M15.05 5A5 5 0 0 1 19 8.95M15.05 1A9 9 0 0 1 23 8.94m-1 7.98v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
                                    <input id="tel" name="tel" type="text" value="" placeholder="Утас (*)" required>
                                </div>
                                <div id="username-field" class="field-wrapper input">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                                    <input id="username" name="username" type="text" class="form-control" placeholder="Нэвтрэх нэр (*)" autocomplete="off" required>
                                </div>
                                <div id="password-field" class="field-wrapper input mb-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-lock"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                                    <input id="password" name="password" type="password" value="" placeholder="Нууц үг (*)" required>
                                </div>
                                <div class="field-wrapper terms_condition">
                                    <div class="n-chk new-checkbox checkbox-outline-primary">
                                        <label class="new-control new-checkbox checkbox-outline-primary">
                                          <input type="checkbox" class="new-control-input" required>
                                          <span class="new-control-indicator"></span><span>Үйлчилгээний нөхцөл зөвшөөрч байна</span>
                                        </label>
                                    </div>
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
                                        <button type="submit" class="btn btn-primary" value="">Бүртгүүлэх</button>
                                    </div>
                                </div>

                            </div>
                        </form>                        
                        <p class="terms-conditions"><?=settings("footer_text");?></p>

                    </div>                    
                </div>
            </div>
        </div>
        <div class="form-image">
            <div class="l-image">
            </div>
        </div>
    </div>

    
    <!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
    <script src="assets/js/libs/jquery-3.1.1.min.js"></script>
    <script src="bootstrap/js/popper.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
    
    <!-- END GLOBAL MANDATORY SCRIPTS -->
    <script src="assets/js/authentication/form-1.js"></script>

    <script src="plugins/input-mask/jquery.inputmask.bundle.min.js"></script>
    <script src="plugins/input-mask/input-mask.js"></script>


</body>
</html>