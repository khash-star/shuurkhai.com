<?
require_once('assets/class/BCGFontFile.php');
require_once('assets/class/BCGDrawing.php');
require_once('assets/class/BCGcode128.barcode.php');
require_once("barcode_writer.php");
?>

<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<style>
body{padding: 0px; width: 20cm !important; background: url("../../../assets/images/logo_bg.png") 4cm center no-repeat;}
hr {border-bottom:2px #000000 solid;}
@media print{ .btn {display:none;} h3 {font-size: 2cm;} h1 {font-size: 2cm;} img {width: 3cm;}}

</style>
<? if ($this->uri->segment(3)) $item_id=$this->uri->segment(3) ?>

<img src="<?=base_url("assets/images/logo.png");?>" style="width:3cm;">  
      
<? 	
	$query = $this->db->query('SELECT * FROM container_item WHERE id="'.$item_id.'"');
	if($query->num_rows()==1)
			{
			$row=$query->row();
			$sender=$row->sender;
			$receiver=$row->receiver;
			$barcode=$row->barcode;
			$description=$row->description;
			$weight=$row->weight;
			$payment=$row->payment;
			$pay_in_mongolia=$row->pay_in_mongolia;
			}
	echo "<img src='".base_url()."index.php/barcode/barcode_gen/".$barcode."' style='width:300px; float:right; margin-top:30px;' >";
	echo "<h3>From:".customer($sender,"tel")."</h3>";
	echo "<h1>".customer($sender,"full_name")."</h1>";
	echo "<h3>Тo:".customer($receiver,"tel")."</h3>";
	echo "<h1>".customer($receiver,"full_name")."</h1>";
	echo "<hr>";
	?>

	<table class="table">
	<tr><td>
	<table class="table" style="width:6сm !important; border: 1px solid #999999;">
		<tr><td><img src="<?=base_url("assets/images/logo.png");?>" style="width:2cm;"></td></tr>
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
		<tr><td><img src="<?=base_url("assets/images/logo.png");?>" style="width:2cm;"></td></tr>
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