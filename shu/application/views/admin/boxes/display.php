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
<div class="panel panel-primary">
  <div class="panel-heading">Box Related Settings</div>
  <div class="panel-body">
<? 


$sql="SELECT * FROM boxes WHERE status NOT IN ('warehouse','delivered') ORDER BY created_date DESC";

$query = $this->db->query($sql);

	$cumulative_weight=0;
	$cumulative_packages = 0;

if ($query->num_rows() > 0)
{
	echo form_open("admin/boxes_changing");

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
	   
	   $count_box=1;
	   foreach ($query->result() as $row)
	   {
		$box_id= $row->box_id;
		$name= $row->name;
		$created_date =$row->created_date;
		$status= $row->status;
		$weight=$row->weight;
	  	//$packages=box_inside($box_id,"packages");
		$packages=$row->packages;


	   echo "<tr>";
	   echo "<td>".form_checkbox("boxes[]",$box_id)."</td>"; 
	   echo "<td>".$count_box."</td>";
	   echo "<td>".anchor('admin/boxes_detail/'.$box_id,$name)."</td>"; 
	   echo "<td>".$packages."</td>"; 
	   echo "<td>".substr($created_date,0,10)."</td>"; 
	   echo "<td>".$status."</td>"; 
	   echo "<td>".$weight."Kg</td>";
	   echo "<td>".anchor('admin/boxes_detail/'.$row->box_id,'<span class="glyphicon glyphicon-edit"></span>')."</td>"; 
	   echo "</tr>";
	   $cumulative_packages+=$packages;
	   $cumulative_weight+=$weight;
	   
		$count_box ++;
	
			
	   }
	
	echo "<tr><td></td><td colspan='2'>Нийт</td><td>$cumulative_packages</td><td></td><td></td><td>$cumulative_weight</td><td></td></tr>";
	echo "</table>";
	$options = array(
                  'onair'    => 'Онгоцоор нисгэх',
                  'warehouse'   => 'Агуулахад оруулах',
				  'delete' => 'Хайрцагын устгах',
				  'new' => 'Шинэхийн өмнөх төлөвт'
                );

	
	echo form_dropdown('options', $options,"", array("class"=>"form-control"));
	echo form_submit("submit","өөрчил",array("class"=>"btn btn-success"));
	echo form_close();
}
else echo '<div class="alert alert-danger" role="alert">No boxes</div>';

?>
  </div><!-- PANEL-BODY -->
</div><!-- PANEL -->

<? //anchor(base_url().'assets/'.$xls_name, 'Excel файл татах',array('class'=>'btn btn-warning'));?>