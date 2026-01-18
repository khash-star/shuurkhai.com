<?php 

ob_start();
session_start();
require_once("../config.php"); 
require_once("helper.php");

if(isset($_POST["tel"])) 
{
    $tel = protect($_POST["tel"]);
    $tel_escaped = mysqli_real_escape_string($conn, $tel);
    $result = mysqli_query($conn,"SELECT * FROM customer WHERE tel='$tel_escaped' LIMIT 1");
    if ($result && mysqli_num_rows($result) == 1)
    {
        $data= mysqli_fetch_array($result);
        if ($data) {
            echo json_encode($data);
        }
    }
}
?>