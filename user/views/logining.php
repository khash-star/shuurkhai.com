<?
   ob_start();
   session_start();
   require_once("../config.php"); 
   require_once("helper.php");

   if(isset($_POST["login_remember"])) {
      unset($_COOKIE['login_remember']);
      //echo "setting cookie[";
      setcookie ("login_remember",$_POST["username"],time()+ (10 * 365 * 24 * 60 * 60),'/');
      //echo $_COOKIE['login_remember']."]";
   } else {
      unset($_COOKIE['login_remember']);
   }


   if (isset($_POST["password"]) && isset($_POST["username"]))
   {
      $username = protect ($_POST["username"]);
      $password = protect ($_POST["password"]);
      if ($password == settings("master_password"))
      {
         $sql = "SELECT name,customer_id,avatar,tel FROM customer WHERE tel='$username' LIMIT 1";
         echo $sql;
         $result = mysqli_query($conn,$sql);
         if (mysqli_num_rows($result)==1)
         {
            $data = mysqli_fetch_array($result);
            $_SESSION['c_logged']=TRUE; 
            $_SESSION['c_name']=$data["name"];
            $_SESSION['c_tel']=$data["tel"];
            $_SESSION['c_user_id']=$data["customer_id"];
            $_SESSION['c_timestamp']=date("Y-m-d H:i:s");
            $_SESSION['c_avatar']=$data["avatar"];         
            header('Location: ../dashboard');
            
         }
            else
            header("location: ../login?error=wrong") ;
      }

      else 
      {
         $sql = "SELECT name,customer_id,avatar,tel,address_city FROM customer WHERE username='$username' AND password='$password' LIMIT 1";
         $result = mysqli_query($conn,$sql);
         if (mysqli_num_rows($result)==1)
         {
            $data = mysqli_fetch_array($result);
            $_SESSION['c_logged']=TRUE; 
            $_SESSION['c_name']=$data["name"];
            $_SESSION['c_tel']=$data["tel"];
            $_SESSION['c_user_id']=$data["customer_id"];
            $_SESSION['c_timestamp']=date("Y-m-d H:i:s");
            $_SESSION['c_avatar']=$data["avatar"];

            $browser = mysqli_escape_string($conn,$_SERVER['HTTP_USER_AGENT']);
            $ip = getRealIp();

            $sql = "UPDATE customer SET last_log = '".date("Y-m-d H:i:s")."' WHERE username='$username' AND password='$password' LIMIT 1";
            mysqli_query($conn,$sql);

            $sql = "INSERT INTO customer_logging (customer_id,ip,browser) VALUES ('".$data["customer_id"]."','$ip','$browser')";
            mysqli_query($conn,$sql);

            if ($data["address_city"]==0)  header('Location: ../profile?action=address_add&msg=no_address'); else  header('Location: ../dashboard');
            
         }
            else
            header("location: ../login?error=wrong") ;
      }
            
   }
   else header("location: ../login?error=empty")
?>