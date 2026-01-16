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

      
      if ($username == settings(1) && $password == settings(2))
      {
         $_SESSION['name']="Админ";
         $_SESSION['avatar']=settings(11);
         $_SESSION['rights']="admin";
         $_SESSION['timestamp']=date("Y-m-d H:i:s");
         $_SESSION['logged']=TRUE;
         //require_once("refresh.php");
         
         header('Location: ../dashboard');

      }
      else
      header("location:../login?error=wrong") ;
   }
   else header("location:../login?error=empty")
?>