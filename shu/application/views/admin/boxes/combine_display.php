<? if ($this->uri->segment(3)) $combine_id=$this->uri->segment(3); else $combine_id="";?>
<script>
$(document).ready(function() {
    $('input[name="select_all"]').click(function(event) {
        if(this.checked) { 
            $('input[type="checkbox"]').each(function() {
                this.checked = true;            
            });
        }else{
            $('input[type="checkbox"]').each(function() {
                this.checked = false; 
            });        
        }
    });
})
</script>

<div class="panel panel-success">
  <div class="panel-heading">Нэгтгэсэн ачаа</div>
  <div class="panel-body">
<? 
if ($combine_id=="")
{
	if (isset($_POST["search"])&&$_POST["search"]!="")
	$sql="SELECT * FROM box_combine WHERE status!='delivered' AND barcodes LIKE '%".$_POST["search"]."%' ORDER BY created_date DESC";
	else 
	$sql="SELECT * FROM box_combine WHERE status!='delivered' ORDER BY created_date DESC"; 
	
	
	$query = $this->db->query($sql);
	if ($query->num_rows() > 0)
	{
		echo form_open("admin/combine_changing");
		echo "<table class='table table-hover'>";
		 echo "<tr>";
		   echo "<th>№</th>"; 
		    echo "<th>".form_checkbox(array('name'=>'select_all','title'=>'Select all orders'))."</th>";
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
			$extra = $row->extra;
		
		   echo "<tr>";
		   echo "<td>".$count++."</td>";
		   echo "<td>".form_checkbox("combine_id[]",$row->combine_id)."</td>"; 
		    echo "<td>".$barcode."</td>";
		   echo "<td>".customer($receiver,"name");
		   echo customer($receiver,"tel");
		   echo "</td>"; 
		   echo "<td>".$created_date."</td>"; 
		   echo "<td>".$status." ".$extra."</td>"; 
		   echo "<td>".$weight."</td>"; 
	
		   echo "<td>";
		   echo anchor('admin/combine_delete/'.$row->combine_id,'<span class="glyphicon glyphicon-trash"></span>');
		   echo anchor('admin/combine_display/'.$row->combine_id,'<span class="glyphicon glyphicon-edit"></span>');
		   echo "</td>"; 
		   echo "</tr>";
	
		} 
		echo "<tr><td></td><td colspan='2'>Нийт</td><td>$cumulative_packages</td><td></td><td></td><td>$cumulative_weight</td><td></td></tr>";
	
		echo "</table>";
		$options = array(
				  //''  => 'Шинэ төлөвийн сонго',
                  //'Агуулахад оруулах'  => 'Олгож дууссан',
                  'onair'    => 'Онгоцоор нисгэх',
                  'warehouse'   => 'Агуулахад оруулах',
                );


	echo form_dropdown('options', $options,"", array("class"=>"form-control"));
	echo form_submit("submit","өөрчил",array("class"=>"btn btn-success"));
	echo form_close();
	}
	else echo '<div class="alert alert-danger" role="alert">No combines</div>';
	
	

}


if ($combine_id!="")
{
	$sql="SELECT * FROM box_combine WHERE combine_id='$combine_id'";
	$query = $this->db->query($sql);
	if ($query->num_rows() == 1)
	{
		$row=$query->row();
		echo "<h3>".$row->barcode."</h3>";
		echo "<table class='table'>";
		$barcodes = $row->barcodes;
		foreach(explode(",",$barcodes) as $barcode_single)
		{
			if ($barcode_single!="")
			$query_single  = $this->db->query("SELECT * FROM orders WHERE barcode = '$barcode_single' LIMIT 1");
			$data_single = $query_single->row();
			echo "<tr>";
			echo "<td>".anchor("admin/tracks_detail/".$data_single->order_id,$data_single->barcode)."</td>";
			echo "<td>".$data_single->status."</td>";
			echo "</tr>";		
		}
		echo "</table>";
	}
	else echo '<div class="alert alert-danger" role="alert">Combined box not found</div>';
}

?>


  </div> <!-- PANEL BODY -->
</div><!-- PANEL  -->