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
if (isset($_GET["id"])) $box_id=intval($_GET["id"]); ?>

<img src="assets/img/logo.png" style="width:3cm;">  
<?


$result = mysqli_query($conn,("SELECT * FROM boxes WHERE box_id=".$box_id));
$data_box=mysqli_fetch_array($result);
$box_name= $data_box["name"];
$box_created= $data_box["created_date"];

echo "<h3>".$box_name."</h3>";
echo "<p>".$box_created."</p>";

$result = mysqli_query($conn,("SELECT * FROM boxes_packages WHERE box_id=".$box_id));

		echo "<table class='table table-hover'>";
		echo "<tr>";
		echo "<th></th>"; 
	  	echo "<th  width='200'>Barcode</th>"; 
		echo "<th>Receiver</th>"; 
		echo "<th>Contact</th>"; 

	  	echo "</tr>";
	 	$count=1;
	while ($data_records = mysqli_fetch_array($result))
	{ 
	   $order_id=$data_records["order_id"];
	   $barcode=$data_records["barcode"];
	   $combined=$data_records["combined"];
	   
	   if($combined==0)
	   {
            $query_order = mysqli_query($conn,"SELECT * FROM orders WHERE order_id=".$order_id);
            $data_order=mysqli_fetch_array($query_order);
            $barcode=$data_order["barcode"];
            $receiver_id=$data_order["receiver"];
            $r_name= customer($receiver_id,"name");
            $r_surname= customer($receiver_id,"surname");
            $r_tel= customer($receiver_id,"tel");
            $proxy= $data_order["proxy_id"];
            $proxy_type= $data_order["proxy_type"];
	   }
	   
	   if($combined==1)
	   {
            $result_compbine = mysqli_query($conn,("SELECT * FROM box_combine WHERE barcode='".$barcode."'"));
            $data_combine=mysqli_fetch_array($result_compbine);
            $barcode=$data_combine["barcode"];
            $receiver_id=$data_combine["receiver"];
            $r_name= customer($receiver_id,"name");
            $r_surname= customer($receiver_id,"surname");
            $r_tel= customer($receiver_id,"tel");
            $proxy= $data_combine["proxy_id"];
	   }
	  	//barcode_generate($barcode);
		
	   echo "<tr>";
	   echo "<td>".$count++."</td>";
	   echo "<td><img src='barcode?barcode=".$barcode."' style='width:100%'></td>";
	   echo "<td>".substr($r_surname,0,2).".".$r_name;
	    if ($proxy!="") echo "<br>".proxy2($proxy,$proxy_type,"name");
	   echo "</td>";
	   echo "<td>".$r_tel;
	   if ($proxy!="") echo "<br>".proxy2($proxy,$proxy_type,"tel");
	   echo "</td>";
	   
	   echo "</tr>";
	
   }
    echo "</table>";

	echo "<a onClick='window.print();window.close();' class='btn btn-warning btn-xs'><i class='fa fa-print'></i>Хэвлэх</a>";		
?>