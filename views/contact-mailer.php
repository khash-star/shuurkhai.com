<? require_once("../config.php");?>
<? require_once("helper.php");?>

<?php
if($_POST)
{


    $name = mysqli_escape_string($conn,protect($_POST["name"]));
    $tel = mysqli_escape_string($conn,protect($_POST["tel"]));
    $email = mysqli_escape_string($conn,protect($_POST["email"]));
    $subject = mysqli_escape_string($conn,protect($_POST["subject"]));
    $content = mysqli_escape_string($conn,protect($_POST["content"]));
    $sql = "INSERT INTO feedback (name,contact,email,title,content) VALUES ('$name','$tel','$email','$subject','$content')";

    if (mysqli_query($conn,$sql)) echo "Амжилттай илгээгдлээ. Баярлала."; else echo "Алдаа гарлаа. ахин оролдоно уу.";
}
?>