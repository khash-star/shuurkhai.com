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
  <div class="panel-heading">Хайрцаг</div>
  <div class="panel-body">
<? 
//$xls_name = "agent".date("ymd").rand(0,10000).".xlsx";
//require_once('assets/PHP_XLSXWriter/xlsxwriter.class.php');

$all = $this->db->count_all('boxes');
echo "Total boxes number:".$all ."<br>";
$sql="SELECT * FROM boxes";
$sql.= " WHERE agent='".$this->session->userdata("agent_id")."' AND status IN ('delivered','warehouse')";
$query = $this->db->query($sql);


if ($query->num_rows() > 0)
{
	echo form_open("agents/boxes_changing");
	/* $data_excel = array(
    array('Илгээгч','','','','Хүлээн авагч','','','','Төлөв','Төлбөртэй','Баглаа боодлын тоо','Жин','Үнэлгээ','Тайлбар','Barcode'),//
	array('Овог','Нэр','Утас','Хаяг','Овог','Нэр','Утас','Хаяг','','','','','',''));*/
	echo "<table class='table table-hover'>";
	 echo "<tr>";
	   //echo "<th>".form_checkbox(array('name'=>'select_all','title'=>'Select all orders'))."</th>";
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
	  // echo "<td>".form_checkbox("boxes[]",$box_id,array("class"=>"form-control"))."</td>"; 
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
	   $weight=order($order_id,'weight');
	   $total_weight+=$weight;
		}
	   //Kg calculate
		echo "<td>".$total_weight."</td>"; 
	   echo "<td>".anchor('agents/boxes_detail/'.$row->box_id,'<span class="glyphicon glyphicon-edit"></span>')."</td>"; 
	   echo "</tr>";
		$cumulative_packages+=$packages;
		$cumulative_weight+=$total_weight;

	   
	   
	  // array_push($data,array($sender_surname,$sender,$sender_contact,$sender_address,$receiver_surname,$receiver,$receiver_contact,$receiver_address,$temp_status,$Package_advance_value,'',$weight,$price,$description,$barcode));

	} 
	echo "<tr><td></td><td colspan='2'>Нийт</td><td>$cumulative_packages</td><td></td><td></td><td>$cumulative_weight</td><td></td></tr>";

	echo "</table>";
	
	
	/*$writer = new XLSXWriter();
	$writer->writeSheet($data);
	$writer->writeToFile('assets/'.$xls_name);*/
	/*$options = array(
                  'onair'    => 'Онгоцоор нисгэх',
                );


	echo '<div class="btn-group" role="group">';
	echo form_dropdown('options', $options, '',array("class"=>"form-control"));
	echo "<div id=\"more\"></div>";
	echo form_submit("submit","өөрчил",array("class"=>"btn btn-success"));
	echo form_close();
	echo '</div>';
	//echo "<br><br><br><br>".anchor(base_url().'assets/'.$xls_name, 'Excel файл татах',array('class'=>'button'));
	*/

}
else echo "No boxes";

?>


  </div> <!-- PANEL BODY -->
</div><!-- PANEL  -->