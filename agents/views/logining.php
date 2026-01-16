<?
   ob_start();
   if (session_status() === PHP_SESSION_NONE) session_start();
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


   if (isset($_POST["username"]) && isset($_POST["password"]))
   {
      $username = protect ($_POST["username"]);
      $password = protect ($_POST["password"]);
      
      $sql = "SELECT *FROM agents WHERE username='$username' AND password='$password' LIMIT 1";
      $result = mysqli_query($conn,$sql);
      if (mysqli_num_rows($result)==1)
      {
         $data = mysqli_fetch_array($result);
         
         $_SESSION['logged_agent']=TRUE;
         $_SESSION['logged_agent_id']=$data["agent_id"];
         $_SESSION['logged_agent_name']=$data["name"];
         $_SESSION['logged_agent_avatar']=$g_icon;
         $_SESSION['logged_agent_timestamp']=date("Y-m-d H:i:s");
         $sql = "UPDATE agents SET last_log = '".date("Y-m-d H:i:s")."' WHERE username='$username' AND password='$password' LIMIT 1";
         mysqli_query($conn,$sql);

         header('Location: index');
      
      }
      else 
      {
         header("location: login?error=wrong");
      }     
   }
   else header("location: login?error=empty");
?>