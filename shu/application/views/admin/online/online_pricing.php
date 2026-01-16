<? if (!isset($_POST["online_id"])) redirect('admin/online'); else $online_id=$_POST["online_id"]; ?>
<? if ($_POST["price"]=="") redirect('admin/online_price/'.$online_id);else $price=$_POST["price"];

	if ($_POST["tax"]!="")   $tax=$_POST["tax"]; else  $tax="";
	if ($_POST["shipping"]!="") $shipping=$_POST["shipping"]; else  $shipping="";
	if ($_POST["owe"]!="") $owe=$_POST["owe"]; else  $owe="";
	if ($_POST["price"]=="" || $_POST["price"]==0) $new=1; else $new=0;
	?>


<?
	
	$sql="UPDATE online SET price = '$price', tax='$tax', shipping='$shipping',owe='$owe',new='$new' WHERE online_id=$online_id LIMIT 1";
	if($this->db->query($sql))
	echo '<div class="alert alert-success" role="alert">Үнийг амжилттай орууллаа</div>'; 
	else echo '<div class="alert alert-danger" role="alert">DB error:'.$query->db->error()."'</div>";
	
	
	$sql = "SELECT * FROM online WHERE online_id=$online_id LIMIT 1";
	$query = $this->db->query($sql);
	if ($query->num_rows() == 1)
	{
	$row = $query->row();
	$customer_id = $row->customer_id;
	$total = $price + $tax+ $shipping;
			//HELP CREATE
			$data = array(
				'context'=>"Cагсанд дахь барааны үнэ бодогдож ".$total."$ болсон",
				'customer_id'=>$customer_id,
				'target'=>'online.php'
				
            );
			$this->db->insert('alert', $data);
	}
	
	echo anchor('admin/online_comment/'.$online_id,'Буцах',array('class'=>"btn btn-success"));
	
?>


<div class="panel panel-primary">
  <div class="panel-heading">Shuurkhai.Com</div>
  <div class="panel-body">
<? 
		$query = $this->db->query("SELECT * FROM online WHERE online_id='".$online_id."'");
		echo "<table class='table table-hover'>";
		if ($query->num_rows() == 1)
		{
		$row=$query->row();
		$online_id=$row->online_id;
		$created_date=$row->created_date;
		$receiver=$row->receiver;
		$url=$row->url;
		$size=$row->size;
		$color=$row->color;
		$number=$row->number;
		$comment=$row->comment;
		$status=$row->status;
		$price=$row->price;
		 
		 echo "<tr>";
	   	 echo "<tr><td>Үүсгэсэн огноо</td><td>".$created_date."</td></tr>"; 
		 echo "<tr><td>Хүлээн авагч</td><td>".customer($receiver,"name")."(".customer($receiver,"tel").")</td></tr>"; 		
		echo "<tr><td>Барааны веблинк</td><td>".anchor($url,$url,array("target"=>"_new"))."</td></tr>"; 
		echo "<tr><td>Тоо</td><td>".$number."</td></tr>"; 
		echo "<tr><td>Размер</td><td>".$size."</td></tr>"; 
		echo "<tr><td>Өнгө</td><td>".$color."</td></tr>"; 
		echo "<tr><td>Оруулсан үнэ</td><td>".$price."</td></tr>"; 
		
			}
   			echo "</table>";
?>
</div>
</div>





