<div class="panel panel-primary">
  <div class="panel-heading">Буцаалт</div>
  <div class="panel-body">
<? 
	$bill_id = $_POST["bill_id"];
	$query_bill = $this->db->query('SELECT * FROM bills WHERE id="'.$bill_id.'"');

	if($query_bill->num_rows()==1)
		{

			$row=$query_bill->row();
			$timestamp = $row->timestamp;
			$deliver_id = $row->deliver;
			$barcodes = $row->barcode;
			$barcode_array = explode(",",$barcodes);
			//if ($timestamp >= date('Y-m-d 00:00:00') && $timestamp <= date('Y-m-d 23:59:59') )
			if (1==1 )

			{
				//echo "Устгах боломжтой";
				$this->db->query("DELETE FROM bills WHERE id='".$bill_id."'");
				$this->db->query("DELETE FROM later_payment WHERE bill='".$bill_id."'");
				
				foreach($barcode_array as $barcode_single)
				{
					
					$this->db->query("UPDATE orders SET status='warehouse' WHERE barcode='".$barcode_single."'");				
					echo $barcode_single.'<br>';
				}	
				echo "Амжилттай буцлаа".'<br>';

			}
			else 
			{
				echo "Зөвхөн өнөөдөр үүссэн баримтын устгах боложмтой.";
			}
			
		}

	else 
		echo "Баримтын дугаар олдсонгүй";		
?>


</div>
</div>