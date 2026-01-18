<?php require_once(__DIR__ . "/../config.php");?>
<?php require_once(__DIR__ . "/../views/helper.php");?>
<?php require_once(__DIR__ . "/../views/init.php");?>
    <link href="assets/css/authentication/form-1.css" rel="stylesheet" type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->
    <link rel="stylesheet" type="text/css" href="assets/css/forms/theme-checkbox-radio.css">
    <link rel="stylesheet" type="text/css" href="assets/css/forms/switches.css">
    <link rel="stylesheet" type="text/css" href="assets/css/elements/alert.css">


<body class="form">
    <div class="form-container">
        <div class="form-form">
            <div class="form-form-wrap">

                <?php
                    if (isset($_POST["search"]))
                        {
                            $search=protect($_POST["search"]);
                            if (isset($_POST["with-username"])) $with_username =1; else $with_username=0;
                            
                            $sql = "SELECT *FROM customer WHERE tel='$search' OR email='$search' LIMIT 1";
                            $result = mysqli_query($conn,$sql);
                            if (mysqli_num_rows($result)==0)
                            {
                                ?>
                                <div class="alert alert-arrow-left alert-icon-left alert-light-danger mb-4" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><svg xmlns="http://www.w3.org/2000/svg" data-dismiss="alert" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bell"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
                                    Бүртгэл олдсонгүй. <b>Та шинээр бүртгүүлэн нэвтэрнэ үү <a href="login"> энд дар</a></b> 
                                </div>
                                <?php
                            }
                            if (mysqli_num_rows($result)==1)
                             
                           {
                               $data = mysqli_fetch_array($result);
                               $username = $data["username"];
                               $password = $data["password"];
                               $email = $data["email"];
                            
                                if ($email<>"")
                                {
                                    $message = '<html><body>';
                                    $message .= '<img src="https://shuurkhai.com/user/assets/images/logo.png" alt="Shuurkhai Logo" />';
                                    $message .= 'Хэрэглэгч таны системд нэвтрэх мэдээллийг илгээж байна.';
                                    $message .= '<table rules="all" style="border-color: #666;" cellpadding="10">';
                                    if ($with_username)
                                    $message .= "<tr><td><strong>Нэвтрэх нэр:</strong> </td><td>" . $username . "</td></tr>";
                                    $message .= "<tr><td><strong>Нууц үг:</strong> </td><td>" . $password . "</td></tr>";
                                    $message .= "</table>";
                                    $message .= "</body></html>";
                                    
                                    $to = $email;
                    
                                    $subject = 'Shuurkhai.com login';
                                    
                                    $headers = "From: no-reply@shuurkhai.com\r\n";
                                    //$headers .= "Reply-To: info@shuurkhai.com\r\n";
                                    $headers .= "MIME-Version: 1.0\r\n";
                                    $headers .= "Content-Type: text/html; charset=utf-8\r\n";
                        
                                    if (mail($to, $subject, $message, $headers))                       
                                        {
                                            ?>
                                            <div class="alert alert-arrow-left alert-icon-left alert-light-success mb-4" role="alert">
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><svg xmlns="http://www.w3.org/2000/svg" data-dismiss="alert" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bell"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
                                                Бүртгэлтэй имэйлрүү нэвтрэх нууц үгийг явууллаа.
                                                
                                            </div>
                                            <?php
                                            
                                        }
                                        else 
                                        {
                                            ?>
                                            <div class="alert alert-arrow-left alert-icon-left alert-light-danger mb-4" role="alert">
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><svg xmlns="http://www.w3.org/2000/svg" data-dismiss="alert" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bell"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
                                                Алдаа гарлаа. Шууд холбогдож нэвтрэх нууц үгийг сэргээлгэж авна уу.
                                            </div>
                                            <?php
                                        }
                                }
                                else
                                { 
                                    ?>
                                    <div class="alert alert-arrow-left alert-icon-left alert-light-danger mb-4" role="alert">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><svg xmlns="http://www.w3.org/2000/svg" data-dismiss="alert" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bell"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
                                        Бүртгэлтэй харилцагчид имэйл бүртгээгүй байна. 
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
                        <form class="text-left" method="post" action="recover">
                            <div class="form">
                                <div id="name-field" class="field-wrapper input">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-phone-call"><path d="M15.05 5A5 5 0 0 1 19 8.95M15.05 1A9 9 0 0 1 23 8.94m-1 7.98v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
                                    <input id="name" name="search" type="text" class="form-control" placeholder="Бүртгэлтэй утас, имэйл(*)" required>
                                </div>

                                <div class="d-sm-flex justify-content-between">
                                    <div class="field-wrapper toggle-pass">
                                        <p class="d-inline-block">Нэвтрэх нэрийг хамт илгээх</p>
                                        <label class="switch s-primary">
                                            <input type="checkbox" class="d-none" checked name="with-username">
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                </div>

                                <div class="d-sm-flex justify-content-between mt-3">
                                    <div class="field-wrapper toggle-pass">
                                        <p class="d-inline-block">Имэйлээр илгээх</p>
                                        <label class="switch s-primary">
                                            <input type="checkbox" class="d-none" checked name="via-email">
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                </div>
                                <div class="d-sm-flex justify-content-between mt-3">
                                    <div class="field-wrapper toggle-pass">
                                        <p class="d-inline-block">Утсаар илгээх</p>
                                        <label class="switch s-primary">
                                            <input type="checkbox" class="d-none" name="via-tel" disabled>
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                </div>

                                <div class="d-sm-flex justify-content-between mt-3">
                                    <div class="field-wrapper">
                                        <button type="submit" class="btn btn-primary" value="">Нууц үг илгээх</button>
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

</body>
</html>