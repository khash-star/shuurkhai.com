<? 
 $item_id=$_POST["item_id"];

$query = $this->db->query("SELECT * FROM container_item WHERE id=".$item_id);
if ($query->num_rows()==1)
{
	$row = $query->row();
	$status= 	$row ->status;
	
	//if ($status=="weight_missing")
	//{
		
		 $weight=$_POST["weight"];
		 $payment=$_POST["payment"];
		 $pay_in_mongolia=$_POST["pay_in_mongolia"];
		 if ($payment>0 || $pay_in_mongolia>0) 
		 	if ($status=="weight_missing") $status= "new";
		$data = array(
			   'price_date'=>date("Y-m-d H:i:s"),
			   'weight'=>$weight,
			   'payment'=> $payment,
			   'pay_in_mongolia'=> $pay_in_mongolia,
			   'status'=> $status
            );
	$this->db->where('id', $item_id);
	if ($this->db->update('container_item', $data)) 
		{		
		echo '<div class="alert alert-success" role="alert">Чингэлэгийн ачааг үнийг орууллаа</div>';
		echo anchor("agents/container_cp72/".$item_id,"CP72 хэвлэх",array('target'=>"new","class"=>"btn btn-primary"));
		log_write("Container-t ачаа үнийг оруулав id =$item_id ".json_encode($data)," container item added");
		echo anchor("agents/container_item_print/".$item_id,"Пайз хэвлэх",array('target'=>"new","class"=>"btn btn-warning"));
	}
		else echo '<div class="alert alert-danger" role="alert">Error:'.$this->db->error().'</span>';
	//}
	//else echo '<div class="alert alert-danger" role="alert">Чинэглэгийн төлөв засаж болохгүй төлөвт байна</div>';
}
else echo '<div class="alert alert-danger" role="alert">Ачааны дугаар алдаатай байна</div>';



	
?>