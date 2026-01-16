<?
require_once('config.php');
require_once('views/helper.php');
?>

<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<style>
body{padding: 0px; margin: 0px;}
div.rotate {transform: rotate(90deg); height: 100px; width: 500px; font-size: 30px; margin-top: 250px; margin-left: -100px;}
@media print{ .btn {display:none;} hr {border-bottom:2px #000000 solid;}} 
hr {border-bottom:2px #000000 solid;}
</style>
<? $orders = $_GET["orders"] ?>
	<!--img src="base_url("assets/images/logo.png");?>" style="width:80%;margin-top: 0px; max-width: 300px;"-->  
      
<? 	
	/*$query_deliver = $this->db->query('SELECT * FROM customer WHERE customer_id="'.$deliver_id.'"');
	if($query_deliver->num_rows()==1)
			{
			$row=$query_deliver->row();
			$deliver_name=$data["name;
			$deliver_tel=$data["tel;
			}
	echo "<br>";
	echo "Гардан авсан: $deliver_name <br>$deliver_tel";
	echo "<br>";
	*/
	echo "<br>";
	echo date("Y-m-d H:i:s");
	echo "<br>";
	/*if ($method=="cash") echo "Төлбөрийг бэлнээр";
	if ($method=="pos") echo "Карт уншуулсан";
	if ($method=="account") echo "Дансаар шилжүүлсэн";*/
	echo "<br>";
	echo "<br>";
	
	$orders_array = explode(',',$orders);
	$N = count($orders_array);
	$count=1; $total_weight=0;$total_price=0;$total_advance=0;
		echo '<table>';
		echo '<tr><td>Ачаа</td><td>Жин</td></tr>';
		echo '<tr><td colspan="2"><hr></td></tr>';
		for($i=0; $i < $N; $i++)
		{
		$sql="SELECT * FROM orders WHERE order_id='".$orders_array[$i]."' LIMIT 1";
		$result= mysqli_query($conn,$sql);
			if ((mysqli_num_rows($result))==1)
			{
			$data=mysqli_fetch_array($result);
			$order_id=$data["order_id"];
			$created_date=$data["created_date"];
			$sender=$data["sender"];
			$receiver=$data["receiver"];
			//$deliver=$data["deliver"];
			$barcode=$data["barcode"];
			$track=$data["third_party"];
			$weight=$data["weight"];
			$advance=$data["advance"];
			$advance_value=$data["advance_value"];
			$status=$data["status"];
			$method=$data["method"];
			$is_online  = $data["is_online"];
			
			//if($status=="warehouse"&&$extra!="") 
			//$temp_status=$status." ".$extra."-р тавиур";else $temp_status=$status;
			echo "<tr>";
	
			echo "<td>".$count++.".".$barcode."</td>";
			//echo "<br>"; 
			//if ($is_online) echo "/collect/"; elseif($advance_value==0) echo "/paid/";
			
			//echo "</td>";
			echo "<td>".$weight."Кг</td>";
	   		//echo "<td>"; //if ($is_online) $advance_value."$"; echo "</td>"; 
	   		echo "</tr>";
			$total_weight+=$weight; //else $total_advance+=$advance_value; 

			}
		}
		echo '<tr><td colspan="2"><hr></td></tr>';

		echo "</table>";

		
		echo '<table>';

		echo "<tr><td colspan='2'>Нийт жин /Кг/</td><td >$total_weight</td><td></td></tr>";
		//echo "<tr ><td colspan='2'>Ачааны тооцоо /$/</td><td >".cfg_price($total_weight)."$</td></tr>";
		//echo "<tr ><td colspan='2'>Дараа тооцоо /$/</td><td >".$total_advance."$</td></tr>";
		//$total_price = $total_advance+cfg_price($total_weight);
		//echo "<tr ><td colspan='2'>Нийт тооцоо /$/ &nbsp;&nbsp;&nbsp;".$total_price."$</td></tr>";
		//echo "<tr ><td colspan='2'>Нийт төлбөр /₮/&nbsp;&nbsp;&nbsp;".$total_price*cfg_rate()."₮</td></tr>";
		echo "</table>";
//		echo '<table>';

			echo "<div class='rotate'>";
				echo customer($receiver,"name")."<br>";
				echo customer($receiver,"tel")."<br>";
				echo customer($receiver,"address")."<br>";
			echo "</div>";
			//echo "<tr><td>".customer($receiver,"tel")."</td></tr>";
			//echo "<tr><td>".customer($receiver,"address")."</td></tr>";
		//echo "<tr ><td colspan='2'>Ачааны тооцоо /$/</td><td >".cfg_price($total_weight)."$</td></tr>";
		//echo "<tr ><td colspan='2'>Дараа тооцоо /$/</td><td >".$total_advance."$</td></tr>";
		//$total_price = $total_advance+cfg_price($total_weight);
		//echo "<tr ><td colspan='2'>Нийт тооцоо /$/ &nbsp;&nbsp;&nbsp;".$total_price."$</td></tr>";
		//echo "<tr ><td colspan='2'>Нийт төлбөр /₮/&nbsp;&nbsp;&nbsp;".$total_price*cfg_rate()."₮</td></tr>";
	//	echo "</table>";
	
		
	
		echo "<a onClick='window.print();window.close();' class='btn btn-warning btn-xs'><i class='fa fa-print'></i>Хэвлэх</a>";
		//echo "<P align='center'>Танд баярлалаа</P>...<br>..<br>.";
			
?>