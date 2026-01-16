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
  <div class="panel-heading">Хайрцаг 
  <span title="Хайрцаглагдаагүй бэлэн ачаа">(<?=agent_boxed_order();?> new order</span>
  <span title="Хайрцаглагдаагүй бэлэн нэгтгэсэн ачаа">,<?=agent_boxed_combine();?> new combine)</span>
  </div>
  <div class="panel-body">
<? 
/*$xls_name = "agent".date("ymd").rand(0,10000).".xlsx";
require_once('assets/PHP_XLSXWriter/xlsxwriter.class.php');*/


$sql="SELECT * FROM boxes";
$sql.= " WHERE agent='".$this->session->userdata("agent_id")."' AND status NOT IN ('delivered','warehouse')";
$query = $this->db->query($sql);
$total_weight =0;

if ($query->num_rows() > 0)
{
	echo form_open("agents/boxes_changing");
	// $data_excel = array(
   // array('Илгээгч','','','','Хүлээн авагч','','','','Төлөв','Төлбөртэй','Баглаа боодлын тоо','Жин','Үнэлгээ','Тайлбар','Barcode'),
	//array('Овог','Нэр','Утас','Хаяг','Овог','Нэр','Утас','Хаяг','','','','','',''));
	echo "<table class='table table-hover table-striped'>";
	 echo "<tr>";
	   echo "<th>".form_checkbox(array('name'=>'select_all','title'=>'Select all orders'))."</th>";
	   echo "<th>№</th>"; 
	   echo "<th>Нэр</th>"; 
	   echo "<th>Үүсгэсэн</th>"; 
	   echo "<th>Төлөв</th>";
	   echo "<th>Тоо</th>"; 
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
	    $weight = $row->weight;
	
	   echo "<tr>";
	   echo "<td>".form_checkbox("boxes[]",$box_id,array("class"=>"form-control"))."</td>"; 
	   echo "<td>".$count++."</td>";
	   echo "<td>".$name."</td>"; 
	   echo "<td>".$created_date."</td>"; 
	   echo "<td>".$status."</td>"; 
		echo "<td>".$packages."</td>"; 
		echo "<td>".$weight."</td>"; 
 		echo "<td>".anchor('agents/boxes_detail/'.$box_id,'<span class="glyphicon glyphicon-edit"></span>')."</td>"; 
	   	echo "</tr>";
		$total_weight+=$weight;
		$cumulative_packages+=$packages;
	    $cumulative_weight+=$weight;

	   
	}
	echo "<tr><td></td><td colspan='4'>Нийт</td><td>$cumulative_packages</td><td>$cumulative_weight</td><td></td></tr>";
	echo "</table>";
}
else echo '<div class="alert alert-danger" role="alert">No boxes</div>';
	
	
	/*$writer = new XLSXWriter();
	$writer->writeSheet($data);
	$writer->writeToFile('assets/'.$xls_name);*/
	$options = array(
                  'onair'    => 'Онгоцоор нисгэх',
					'delete' => 'Хайрцагын устгах'

                );


	echo '<div class="btn-group" role="group">';
	echo form_dropdown('options', $options, '',array("class"=>"form-control"));
	echo "<div id=\"more\"></div>";
	echo form_submit("submit","өөрчил",array("class"=>"btn btn-success"));
	echo form_close();
	echo '</div>';
	//echo "<br><br><br><br>".anchor('assets/'.$xls_name, 'Excel файл татах',array('class'=>'btn btn-warning'));




?>


  </div> <!-- PANEL BODY -->
</div><!-- PANEL  -->