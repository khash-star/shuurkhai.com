<script type="application/javascript">
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
  <div class="panel-heading">Хамааралтай ачааг олох</div>
  <div class="panel-body">
<? 
if (isset($_POST["barcode"]))
{
	 $barcode = $_POST["barcode"];
	 if(substr($barcode,0,2)=="GO")
	 $sql = "SELECT * FROM orders WHERE barcode='$barcode' LIMIT 1";
	 else $sql = "SELECT * FROM orders WHERE third_party='$barcode' LIMIT 1";
	 $query= $this->db->query($sql);
	 if ($query->num_rows()==1)
	 {
	 $row = $query->row();
	 $status = $row->status;
	 $order_id = $row->order_id;
	 $receiver= $row->receiver;
		echo $receiver_name=customer($receiver,"full_name")."<br>";
		echo $receiver_contact=customer($receiver,"tel")."<br>";
		echo $barcode."<br>";
		if ($status!="delivered" && $status!="warehouse" && $status!="customs")
		{
			$sql = "SELECT * FROM orders WHERE receiver='".$receiver."' AND status NOT IN ('delivered','warehouse','customs','onair')";
			$relatives_query= $this->db->query($sql);
			 if ($relatives_query->num_rows()>1)
			 {
				 echo form_open('agents/boxes_combining');
				 echo "<table class='table table-striped'>";
				 echo "<tr><th>".form_checkbox(array('name'=>'select_all','title'=>'Select all barcodes',"checked"=>"checked"))."</th><th>Barcode</th><th>Track</th><th>Weight</th><th>Status</th></tr>";
				 foreach($relatives_query->result() as $row_relatives)
				 {
					
				echo "<tr><td>".form_checkbox("barcodes[]",$row_relatives->barcode,array("checked"=>"checked"))."</td>";
				 echo "<td>".$row_relatives->barcode."</td>";
				 echo "<td><a href='".track($row_relatives->third_party)."' target='new'>".$row_relatives->third_party."</a></td>";
				 echo "<td>".$row_relatives->weight."</td>";
				 echo "<td>".$row_relatives->status."</td>";
				 echo "</tr>";	 
					
				 }
				 echo "</table>";
				 echo form_submit("Нэгтгэх","Нэгтгэх",array("class"=>"btn btn-success"));
				 echo form_close();
			 }

		 }
		 else echo "Barcode-н төлөв.".$status;
	 }
	 else echo "Barcode олдсонгүй.";
}
else echo "Barcode оруулаагүй.";

?>

  </div> <!-- PANEL BODY -->
</div><!-- PANEL  -->