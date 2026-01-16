<div class="panel panel-primary">
  <div class="panel-heading">Boxes searching..</div>
  <div class="panel-body">
<? 
if (isset($_POST["search"])) $search_term= $_POST["search"]; else  $search_term="";
if ($search_term!="") echo "Хайх:".$search_term."<br>";
$sql = "SELECT boxes.*,boxes.name AS box_name,boxes.created_date AS box_created FROM boxes_packages LEFT JOIN boxes ON boxes_packages.box_id=boxes.box_id LEFT JOIN customer ON boxes_packages.receiver=customer.customer_id ";
$sql.=" WHERE CONCAT_WS(customer.name,customer.tel,boxes_packages.barcode,boxes_packages.barcodes) LIKE '%".$search_term."%' AND boxes.status IN ('new','onair') GROUP BY boxes.box_id";
//echo $sql;
$query = $this->db->query($sql);
if ($query->num_rows() > 0)
{
	echo form_open("agents/boxes_changing");
	echo "<table class='table table-hover'>";
	 echo "<tr>";
	   echo "<th>".form_checkbox(array('name'=>'select_all','title'=>'Select all orders'))."</th>";
	   echo "<th>№</th>"; 
	   echo "<th>Нэр</th>"; 
	   echo "<th>Тоо</th>"; 
	   echo "<th>Огноо</th>"; 
	   echo "<th>Төлөв</th>"; 
	   echo "<th>Kg</th>"; 
	   echo "<th></th>"; 
	   echo "</tr>";
	   $count=1;
	   $cumulative_weight=0;
	   $cumulative_packages = 0;
	foreach ($query->result() as $row)
	{ 
	   	$box_id= $row->box_id; 
	   	$name= $row->box_name; 
	   	$packages= $row->packages;
	   	$created_date = $row->box_created;
	   	$status = $row->status;
		$order_weight = $row->weight;
	   
	
	   echo "<tr>";
	   echo "<td>".form_checkbox("boxes[]",$box_id)."</td>"; 
	   echo "<td>".$count++."</td>";
	   echo "<td>".$name."</td>"; 
	   echo "<td>".$packages."</td>"; 
	   echo "<td>".$created_date."</td>"; 
	   echo "<td>".$status."</td>"; 
	   echo "<td>".$order_weight."</td>"; 
	   //Kg calculate
	   
	   echo "<td>".anchor('agents/boxes_detail/'.$row->box_id,'<span class="glyphicon glyphicon-edit"></span>')."</td>"; 
	   echo "</tr>";
	   $cumulative_packages+=$packages;
	   $cumulative_weight+=$order_weight;
	   
	   // array_push($data,array($sender_surname,$sender,$sender_contact,$sender_address,$receiver_surname,$receiver,$receiver_contact,$receiver_address,$temp_status,$Package_advance_value,'',$weight,$price,$description,$barcode));

	} 
	echo "<tr><td></td><td colspan='2'>Нийт</td><td>$cumulative_packages</td><td></td><td></td><td>$cumulative_weight</td><td></td></tr>";
	echo "</table>";
	
	
	//$writer = new XLSXWriter();
	//$writer->writeSheet($data);
	//$writer->writeToFile('assets/boxes.xlsx');
	$options = array(
				  //''  => 'Шинэ төлөвийн сонго',
                  //'delivered'  => 'Хүргэж өгөх',
                  'onair'    => 'Онгоцоор нисгэх',
                 //'warehouse'   => 'Агуулахад оруулах',
                  //'custom' => 'Гааль',
				  'delete' => 'Хайрцагын устгах',
                );


	echo form_dropdown('options', $options, '',array("class"=>"form-control"));
	echo "<div id=\"more\"></div>";
	echo form_submit("submit","өөрчил",array("class"=>"btn btn-success"));
	echo form_close();
}
else echo "No boxes";




?>

</div>
</div>
