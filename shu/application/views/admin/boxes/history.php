<div class="panel panel-primary">
  <div class="panel-heading">Box Related Settings</div>
  <div class="panel-body">
<? 
$query = $this->db->query("SELECT * FROM boxes WHERE status IN ('warehouse','delivered') ORDER BY created_date DESC");
if ($query->num_rows() > 0)
		{
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
	   	$name= $row->name; 
	   	$packages= $row->packages;
	   	$created_date = $row->created_date;
	   	$status = $row->status;
	   
	
	   echo "<tr>";
	   echo "<td>".form_checkbox("boxes[]",$box_id)."</td>"; 
	   echo "<td>".$count++."</td>";
	   echo "<td>".$name."</td>"; 
	   echo "<td>".$packages."</td>"; 
	   echo "<td>".$created_date."</td>"; 
	   echo "<td>".$status."</td>"; 
	   //Kg calculate
	   	$query_kg = $this->db->query("SELECT * FROM boxes_packages WHERE box_id=".$box_id);
		$total_weight=0;
	   foreach ($query_kg->result() as $row_kg)
		{ 
	   $order_id=$row_kg->order_id;
	   $weight=floatval(order($order_id,'weight'));
	   $total_weight+=$weight;
		}
	   //Kg calculate
	   
		 echo "<td>".$total_weight."</td>"; 
	   echo "<td>".anchor('admin/boxes_detail/'.$row->box_id,'<span class="glyphicon glyphicon-edit"></span>')."</td>"; 
	   echo "</tr>";
	   $cumulative_packages+=$packages;
	   $cumulative_weight+=$total_weight;
	   
	   //array_push($data,array($sender_surname,$sender,$sender_contact,$sender_address,$receiver_surname,$receiver,$receiver_contact,$receiver_address,$temp_status,$Package_advance_value,'',$weight,$price,$description,$barcode));

		} 
		echo "<tr><td></td><td colspan='2'>Нийт</td><td>$cumulative_packages</td><td></td><td></td><td>$cumulative_weight</td><td></td></tr>";
		echo "</table>";
}
else echo '<div class="alert alert-danger" role="alert">Хуучин хайрцаг олдсонгүй</div>';

?>

</div>
</div> <!--wrapper-->