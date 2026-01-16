<?
require_once("config.php");
require_once("views/helper.php");
require_once('assets/vendor/libs/BCG/BCGFontFile.php');
require_once('assets/vendor/libs/BCG/BCGDrawing.php');
require_once('assets/vendor/libs/BCG/BCGcode128.barcode.php');

// require_once("barcode_writer.php");
?>

<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<style>
body{padding: 0px; width: 20cm !important; background: url("assets/img/logo_bg.png") 4cm center no-repeat;}
hr {border-bottom:2px #000000 solid;}
@media print{ .btn {display:none;} h3 {font-size: 2cm;} h1 {font-size: 2cm;} img {width: 3cm;}}

</style>
<? 
if (isset($_GET["id"])) $item_id=intval($_GET["id"]); ?>

<img src="assets/img/logo.png" style="width:3cm;">  
      
<? 	
	$result = mysqli_query($conn,'SELECT * FROM container_item WHERE id="'.$item_id.'"');
	if(mysqli_num_rows($result)==1)
			{
			$data=mysqli_fetch_array($result);
			$sender=$data["sender"];
			$receiver=$data["receiver"];
			$barcode=$data["barcode"];
			$description=$data["description"];
			$weight=$data["weight"];
			$payment=$data["payment"];
			$pay_in_mongolia=$data["pay_in_mongolia"];
			}
	echo "<img src='barcode?barcode=".$barcode."' style='width:300px; float:right; margin-top:30px;' >";
	echo "<h3>From:".customer($sender,"tel")."</h3>";
	echo "<h1>".customer($sender,"full_name")."</h1>";
	echo "<h3>Тo:".customer($receiver,"tel")."</h3>";
	echo "<h1>".customer($receiver,"full_name")."</h1>";
	echo "<hr>";
	?>

	<table class="table">
	<tr><td>
	<table class="table" style="width:6сm !important; border: 1px solid #999999;">
		<tr><td><img src="assets/img/logo.png" style="width:2cm;"></td></tr>
		<tr><td>Илгээсэн: <?=customer($sender,"full_name");?></td></tr>
		<tr><td>Хүлээн авагч:<?=customer($receiver,"full_name");?></td></tr>
		<tr><td>Огноо:<?=date("Y-m-d H:i");?></td></tr>
		<tr><td>Баркод:<?=$barcode;?></td></tr>
		<tr><td>Барааны тайлбар:<?=$description;?></td></tr>
		<tr><td>Жин:<?=$weight;?></td></tr>
		<tr><td>Төлбөрт:<?=$payment;?>$</td></tr>
		<tr><td>Монголд төлөх:<?=$pay_in_mongolia;?>$</td></tr>
		<tr><td>Гарын үсэг: </td></tr>
	</table>
	</td>

	<td>
	<table class="table" style="width:6сm !important;  border: 1px solid #999999;">
        <tr><td><img src="assets/img/logo.png" style="width:2cm;"></td></tr>
        <tr><td>Илгээсэн: <?=customer($sender,"full_name");?></td></tr>
		<tr><td>Хүлээн авагч:<?=customer($receiver,"full_name");?></td></tr>
		<tr><td>Огноо:<?=date("Y-m-d H:i");?></td></tr>
		<tr><td>Баркод:<?=$barcode;?></td></tr>
		<tr><td>Барааны тайлбар:<?=$description;?></td></tr>
		<tr><td>Жин:<?=$weight;?></td></tr>
		<tr><td>Төлбөрт:<?=$payment;?>$</td></tr>
		<tr><td>Монголд төлөх:<?=$pay_in_mongolia;?>$</td></tr>
		<tr><td>Гарын үсэг: </td></tr>
	</table>
	</td>
	</tr>
	</table>




<?
	echo "<a onClick='window.print();window.close();' class='btn btn-warning btn-xs'><i class='fa fa-print'></i>Хэвлэх</a>";		
?>