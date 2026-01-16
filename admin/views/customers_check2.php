<? 

ob_start();
session_start();
require_once("../config.php"); 
require_once("helper.php");

if(isset($_POST["tel"])) 
{
    $tel=$_POST["tel"];
    $result = mysqli_query($conn,"SELECT * FROM customer WHERE tel='".$tel."' LIMIT 1");
    if (mysqli_num_rows($result) == 1)
    {
        $data= mysqli_fetch_array($result);
        echo json_encode($data);        
    }
}
?>