<?php
   ob_start();
   session_start();
   require_once("../config.php"); 
   require_once("helper.php");
   require_once("../lib/security.php"); // Security functions
   require_once("../lib/csrf_helper.php"); // CSRF protection

   if(isset($_POST["login_remember"])) {
      unset($_COOKIE['login_remember']);
      if (isset($_POST["username"])) {
         setcookie ("login_remember",$_POST["username"],time()+ (10 * 365 * 24 * 60 * 60),'/');
      }
   } else {
      unset($_COOKIE['login_remember']);
   }


   // CSRF Protection - POST request-д шалгах
   if ($_SERVER['REQUEST_METHOD'] === 'POST' && function_exists('verify_csrf_post')) {
       if (!verify_csrf_post()) {
           header("location: ../login?error=csrf");
           exit;
       }
   }

   if (isset($_POST["password"]) && isset($_POST["username"]))
   {
      // Input validation сайжруулах
      if (function_exists('sanitize_input')) {
          $username = sanitize_input($_POST["username"], 'string');
          $password = sanitize_input($_POST["password"], 'string');
      } else {
          $username = protect ($_POST["username"]);
          $password = protect ($_POST["password"]);
      }
      
      // Validation
      if (empty($username) || empty($password)) {
          header("location: ../login?error=empty");
          exit;
      }
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
         // Password verification - password_hash ашиглах (backward compatibility)
         $sql = "SELECT name,customer_id,avatar,tel,address_city,password,password_hash FROM customer WHERE username='".$username_escaped."' LIMIT 1";
         $result = mysqli_query($conn,$sql);
         if ($result && mysqli_num_rows($result)==1)
         {
            $data = mysqli_fetch_array($result);
            $stored_password = $data["password"] ?? '';
            $stored_password_hash = $data["password_hash"] ?? '';
            
            // Password verify - password_hash байвал түүнийг ашиглах, үгүй бол хуучин password-тэй харьцуулах
            $password_valid = false;
            if (!empty($stored_password_hash)) {
               // Шинэ password_hash ашиглах
               $password_valid = verify_password($password, $stored_password_hash);
            } else {
               // Backward compatibility - хуучин plain text/md5 password
               $password_valid = ($password == $stored_password || md5($password) == $stored_password);
               
               // Хэрэв хуучин password зөв байвал шинэ password_hash үүсгэж хадгалах
               if ($password_valid && function_exists('hash_password')) {
                  $new_hash = hash_password($password);
                  $new_hash_escaped = mysqli_real_escape_string($conn, $new_hash);
                  $update_hash_sql = "UPDATE customer SET password_hash = '$new_hash_escaped' WHERE username='".$username_escaped."' LIMIT 1";
                  mysqli_query($conn, $update_hash_sql);
               }
            }
            
            if ($password_valid) {
               $_SESSION['c_logged']=TRUE; 
               $_SESSION['c_name']=isset($data["name"]) ? $data["name"] : '';
               $_SESSION['c_tel']=isset($data["tel"]) ? $data["tel"] : '';
               $_SESSION['c_user_id']=isset($data["customer_id"]) ? intval($data["customer_id"]) : 0;
               $_SESSION['c_timestamp']=date("Y-m-d H:i:s");
               $_SESSION['c_avatar']=isset($data["avatar"]) ? $data["avatar"] : '';

               $browser = mysqli_real_escape_string($conn,$_SERVER['HTTP_USER_AGENT']);
               $ip = getRealIp();
               $ip_escaped = mysqli_real_escape_string($conn, $ip);

               $customer_id_escaped = mysqli_real_escape_string($conn, $data["customer_id"]);
               $sql = "UPDATE customer SET last_log = '".date("Y-m-d H:i:s")."' WHERE customer_id='".$customer_id_escaped."' LIMIT 1";
               mysqli_query($conn,$sql);

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