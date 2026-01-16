<? if (!$this->uri->segment(3)) redirect('agents/container'); else $box_id=$this->uri->segment(3) ?>


<?
require_once('assets/class/BCGFontFile.php');
require_once('assets/class/BCGDrawing.php');
require_once('assets/class/BCGcode128.barcode.php');
require_once("barcode_writer.php");




$query = $this->db->query("SELECT * FROM boxes WHERE box_id=".$box_id);
$box_row=$query->row();
$box_name= $box_row->name;
$box_created= $box_row->created_date;

echo "<h3>".$box_name."</h3>";
echo "<p>".$box_created."</p>";

$query = $this->db->query("SELECT * FROM boxes_packages WHERE box_id=".$box_id);

		echo "<table class='table table-hover'>";
		echo "<tr>";
		echo "<th></th>"; 
	  	echo "<th  width='200'>Barcode</th>"; 
		echo "<th>Receiver</th>"; 
		echo "<th>Contact</th>"; 

	  	echo "</tr>";
	 	$count=1;
	foreach ($query->result() as $row)
	{ 
	   $order_id=$row->order_id;
	   $barcode=$row->barcode;
	   $combined=$row->combined;
	   
	   if($combined==0)
	   {
	   $query_order = $this->db->query("SELECT * FROM orders WHERE order_id=".$order_id);
	   $receiver_row=$query_order->row();
	   $barcode=$receiver_row->barcode;
	   $receiver_id=$receiver_row->receiver;
	   $r_name= customer($receiver_id,"name");
	   $r_surname= customer($receiver_id,"surname");
	   $r_tel= customer($receiver_id,"tel");
	    $proxy= $receiver_row->proxy_id;
	   }
	   
	   if($combined==1)
	   {
	   $query_order = $this->db->query("SELECT * FROM box_combine WHERE barcode='".$barcode."'");
	   $receiver_row=$query_order->row();
	   $barcode=$receiver_row->barcode;
	   $receiver_id=$receiver_row->receiver;
	   $r_name= customer($receiver_id,"name");
	   $r_surname= customer($receiver_id,"surname");
	   $r_tel= customer($receiver_id,"tel");
	    $proxy= $receiver_row->proxy_id;
	   }
	  	//barcode_generate($barcode);
		
	   echo "<tr>";
	   echo "<td>".$count++."</td>";
	   echo "<td><img src='".base_url()."index.php/barcode/barcode_gen/".$barcode."' style='width:100%'></td>";
	   echo "<td>".substr($r_surname,0,2).".".$r_name;
	    if ($proxy!="") echo "<br>".proxy($proxy,"name");
	   echo "</td>";
	   echo "<td>".$r_tel;
	   if ($proxy!="") echo "<br>".proxy($proxy,"tel");
	   echo "</td>";
	   
	   echo "</tr>";
	
   }
    echo "</table>";
	echo '<button onClick="window.print()">Print this page</button>';

?>