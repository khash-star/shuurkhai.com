<? if (!isset($_POST["track"])) redirect("agents/insert"); else $track=$_POST["track"];?>
<? if (!isset($_POST["track"])&&$_POST["track"]=="") redirect("agents/tracks_insert"); else $track=$_POST["track"];?>
<div class="panel panel-primary">
  <div class="panel-heading">Track: бүртгэл</div>
  <div class="panel-body">
<? 
	$track_eliminated = substr($track,-8,8);

	$query = $this->db->query("SELECT * FROM orders WHERE SUBSTRING(third_party,-8,8) = '$track_eliminated' LIMIT 1");
	
		//TRACK REGISTERED 
		if ($query->num_rows() == 1)
		{
			$row = $query->row();
			$order_id=$row->order_id;
			$track=$row->third_party;
			$receiver_id=$row->receiver;
			$created_date=$row->created_date;
			$status=$row->status;
			$weight=$row->weight;

			echo '<div class="alert alert-success" role="alert">';
			echo 'Track бүртгэлтэй байна. <br>';
			if ($status =="order") echo 'Хүлээн авагч нь тодорхойгүй байна.<br>';
			if ($status =="filled") echo "Хүлээн авагч бөглөгдсөн байна. ".anchor("agents/tracks_edit/".$order_id,"шалгах",array("class"=>"btn btn-primary")).'<br>';
			if ($status =="new") echo "Нисэхэд бэлэн. ".anchor("agents/tracks_preview/".$order_id,"CP72 хэвлэх",array('target'=>"new","class"=>"btn btn-warning")).'<br>';
			if ($status =="item_missing") echo "Ачааны задаргаа оруулаагүй байна. ".anchor("agents/tracks_edit/".$order_id,"оруулах",array("class"=>"btn btn-success"));
			if ($status =="onair") echo "Нисэж буй төлөвт байна. ";
			if ($status =="custom") echo "Гаальд саатсан. ";
			if ($status =="warehouse") echo "Агуулахад хүрсэн байна. ";
			if ($status =="delivered") echo "Хүргэгдсэн байна. ";
			echo '</div>';
			if ($status=="weight_missing") 
				{
				echo form_open('agents/tracks_checking2');
				echo "<table class='table table-hover'>";
				echo form_hidden("track",$track);
				echo "<tr><td>Track</td><td>".$track."</td></tr>";
				echo "<tr><td>Weight /KG/</td><td>".form_input("weight","",array("class"=>"form-control","placeholder"=>"Eg:5.4"))."</td></tr>";
				echo "</table>";
				echo form_submit("submit","add",array("class"=>"btn btn-success"));
		
				echo form_close();
				}
		}
		
		
		
		//TRACK REGISTERED ENDS HERE
		
		
		
		
		//TRACK NOT REGISTERED 
		if ($query->num_rows() == 0)   //TRACK NOT REGISTERED 
		{
				$sql="SELECT * FROM container_item WHERE  SUBSTRING(track,-8,8) = '$track_eliminated'  LIMIT 1";
				$query_container = $this->db->query($sql);
	
				//TRACK REGISTERED IN CONTAINER ITEM
				if ($query_container->num_rows() == 1)
				{
					$row_container = $query_container->row();
					$item_id = $row_container->id;
					redirect("agents/container_item_detail/".$item_id);
				}
				else 
				{

						echo '<div class="alert alert-danger" role="alert">';
						echo 'Track is not registered . Track can register with it\'s weight.';
						echo '</div>';
						echo form_open('agents/tracks_checking2');
						echo form_hidden("track",$track);
						echo "<table class='table table-hover'>";
						echo "<tr><td>Weight /KG/</td><td>".form_input("weight","",array("class"=>"form-control","placeholder"=>"Eg:5.4"))."</td></tr>";
						echo "</table>";
						echo form_submit("submit","add",array("class"=>"btn btn-success"));
						echo form_close();
					}
		}
		//TRACK NOT REGISTERED ENDS HERE
?>

</div> <!-- PANEL-BODY -->
</div><!-- PANEL -->