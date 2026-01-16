<? require_once("config.php");?>
<? require_once("views/helper.php");?>
<?
    if (isset($_GET["payment_id"]) && isset($_GET["user_id"]))
    {
        $payment_id = $_GET["payment_id"];
        $user_id = $_GET["user_id"];
        //echo $payment_id;
        $sql = "SELECT *FROM envoice WHERE envoice_id='$payment_id' AND customer_id='$user_id' LIMIT 1";
        //echo $sql;
        $result = mysqli_query($conn,$sql);

        if (mysqli_num_rows($result) == 1)
            {
                $sql = "UPDATE envoice SET status='paid',qpay_paid ='".date("Y-m-d H:i:s")."' WHERE envoice_id='$payment_id' AND customer_id='$user_id' LIMIT 1";
                mysqli_query($conn,$sql);
                echo "Payment successful";
            }
            else echo header("HTTP/1.1 405 Not Found");
    }
    else 
    {
        header("HTTP/1.0 404 Not Found");
        die();
    }

?>
            
