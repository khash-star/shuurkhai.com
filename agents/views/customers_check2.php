<?php 

ob_start();
session_start();
require_once("../config.php"); 
require_once("helper.php");

if(isset($_GET["tel"])) 
{
    $tel=$_GET["tel"];
    if (!isset($_GET["value"])) echo "Found user";
    else 
    {
        $value=$_GET["value"];
        $result = mysqli_query($conn,"SELECT * FROM customer WHERE tel='".$tel."' LIMIT 1");
        if (mysqli_num_rows($result) == 1)
        {
            $data = mysqli_fetch_array($result);
            if ($value=="rd") echo $data["rd"];
            if ($value=="surname") echo $data["surname"];
            if ($value=="name") echo $name=$data["name"];
            if ($value=="email") echo $data["email"];
            if ($value=="address") echo $data["address"];
        }

    }
}
?>