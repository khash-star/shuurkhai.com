<? if ($this->uri->segment(3)) $combine_id=$this->uri->segment(3); else $combine_id="";?>

<div class="panel panel-success">
  <div class="panel-heading">Нэгтгэсэн ачаа</div>
  <div class="panel-body">
<? 
if ($combine_id=="")
{
	$sql="SELECT * FROM box_combine WHERE status!='delivered' AND status!='warehouse' ORDER BY created_date DESC";
	$query = $this->db->query($sql);
	if ($query->num_rows() > 0)
	{
		echo "<table class='table table-hover'>";
		 echo "<tr>";
		   echo "<th>№</th>"; 
		   echo "<th>Barcode</th>"; 
		   echo "<th>Х/aвагч</th>"; 
		   echo "<th>Огноо</th>"; 
		   echo "<th>Төлөв</th>"; 
		   echo "<th>Kg</th>"; 
		   echo "<th></th>"; 
		   echo "</tr>";
		   $count=1;
		   $total_weight=0;
		   $cumulative_weight=0;
		   $cumulative_packages = 0;
		foreach ($query->result() as $row)
		{ 
			$receiver= $row->receiver; 
			$weight= $row->weight;
			$created_date = $row->created_date;
			$barcode = $row->barcode;
			$barcodes = $row->barcodes;
			$proxy_id = $row->proxy_id;
			$status = $row->status;
			$total_weight+=$weight;
		
		   echo "<tr>";
		   echo "<td>".$count++."</td>";
		    echo "<td>".$barcode."</td>";
		   echo "<td>".customer($receiver,"name");
		   echo customer($receiver,"tel");
		   echo "</td>"; 
		   echo "<td>".$created_date."</td>"; 
		   echo "<td>".$status."</td>"; 
		   echo "<td>".$weight."</td>"; 
	
		   echo "<td>";
		   if ($status!="warehouse" && $status!="delivered" && $status!="onair")
		   echo anchor('agents/combine_delete/'.$row->combine_id,'<span class="glyphicon glyphicon-trash"></span>');
		   echo anchor('agents/combine_display/'.$row->combine_id,'<span class="glyphicon glyphicon-edit"></span>');
		   echo "</td>"; 
		   echo "</tr>";
	
		} 
		echo "<tr><td></td><td colspan='2'>Нийт</td><td>$cumulative_packages</td><td></td><td></td><td>$cumulative_weight</td><td></td></tr>";
	
		echo "</table>";
		
	}
	else echo '<div class="alert alert-danger" role="alert">No combines</div>';
}


if ($combine_id!="")
{
	$sql="SELECT * FROM box_combine WHERE combine_id='$combine_id' ORDER BY created_date DESC";
	$query = $this->db->query($sql);
	if ($query->num_rows() == 1)
	{
		$row=$query->row();
		echo $barcodes = $row->barcodes;
	}
	else echo '<div class="alert alert-danger" role="alert">Combined box not found</div>';
}

?>


  </div> <!-- PANEL BODY -->
</div><!-- PANEL  -->