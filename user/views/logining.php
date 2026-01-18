<?php
   ob_start();
   session_start();
   require_once("../config.php"); 
   require_once("helper.php");

   if(isset($_POST["login_remember"])) {
      unset($_COOKIE['login_remember']);
      if (isset($_POST["username"])) {
         setcookie ("login_remember",$_POST["username"],time()+ (10 * 365 * 24 * 60 * 60),'/');
      }
   } else {
      unset($_COOKIE['login_remember']);
   }


   if (isset($_POST["password"]) && isset($_POST["username"]))
   {
      $username = protect ($_POST["username"]);
      $password = protect ($_POST["password"]);
      $username_escaped = mysqli_real_escape_string($conn, $username);
      $password_escaped = mysqli_real_escape_string($conn, $password);
      
      if ($password == settings("master_password"))
      {
         $sql = "SELECT name,customer_id,avatar,tel FROM customer WHERE tel='".$username_escaped."' LIMIT 1";
         $result = mysqli_query($conn,$sql);
         if ($result && mysqli_num_rows($result)==1)
         {
            $data = mysqli_fetch_array($result);
            $_SESSION['c_logged']=TRUE; 
            $_SESSION['c_name']=isset($data["name"]) ? $data["name"] : '';
            $_SESSION['c_tel']=isset($data["tel"]) ? $data["tel"] : '';
            $_SESSION['c_user_id']=isset($data["customer_id"]) ? intval($data["customer_id"]) : 0;
            $_SESSION['c_timestamp']=date("Y-m-d H:i:s");
            $_SESSION['c_avatar']=isset($data["avatar"]) ? $data["avatar"] : '';         
            header('Location: ../dashboard');
            exit;
         }
         else
         {
            header("location: ../login?error=wrong");
            exit;
         }
      }
      else 
      {
         $sql = "SELECT name,customer_id,avatar,tel,address_city FROM customer WHERE username='".$username_escaped."' AND password='".$password_escaped."' LIMIT 1";
         $result = mysqli_query($conn,$sql);
         if ($result && mysqli_num_rows($result)==1)
         {
            $data = mysqli_fetch_array($result);
            $_SESSION['c_logged']=TRUE; 
            $_SESSION['c_name']=isset($data["name"]) ? $data["name"] : '';
            $_SESSION['c_tel']=isset($data["tel"]) ? $data["tel"] : '';
            $_SESSION['c_user_id']=isset($data["customer_id"]) ? intval($data["customer_id"]) : 0;
            $_SESSION['c_timestamp']=date("Y-m-d H:i:s");
            $_SESSION['c_avatar']=isset($data["avatar"]) ? $data["avatar"] : '';

            $browser = mysqli_real_escape_string($conn,$_SERVER['HTTP_USER_AGENT']);
            $ip = getRealIp();
            $ip_escaped = mysqli_real_escape_string($conn, $ip);

            $sql = "UPDATE customer SET last_log = '".date("Y-m-d H:i:s")."' WHERE username='".$username_escaped."' AND password='".$password_escaped."' LIMIT 1";
            mysqli_query($conn,$sql);

            $customer_id_escaped = mysqli_real_escape_string($conn, $data["customer_id"]);
            $sql = "INSERT INTO customer_logging (customer_id,ip,browser) VALUES ('".$customer_id_escaped."','".$ip_escaped."','".$browser."')";
            mysqli_query($conn,$sql);

            if (isset($data["address_city"]) && $data["address_city"]==0) {
               header('Location: ../profile?action=address_add&msg=no_address');
            } else {
               header('Location: ../dashboard');
            }
            exit;
         }
         else
         {
            header("location: ../login?error=wrong");
            exit;
         }
      }
   }
   else {
      header("location: ../login?error=empty");
      exit;
   }
?>