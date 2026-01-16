<? if (!$this->uri->segment(3)) redirect('admin/online'); else $online_id=$this->uri->segment(3) ?>
<script type="text/javascript" src="<?=base_url();?>assets/js/jquery.mask.min.js"></script>
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
		$tax=$row->tax;
		$shipping=$row->shipping;
		$owe=$row->owe;
		 
		 echo "<tr>";
	   	 echo "<tr><td>Үүсгэсэн огноо</td><td>".$created_date."</td></tr>"; 
		 echo "<tr><td>Хүлээн авагч</td><td>".customer($receiver,"name")."(".customer($receiver,"tel").")</td></tr>"; 		
		echo "<tr><td>Барааны веблинк</td><td>".anchor($url,$url,array("target"=>"_new"))."</td></tr>"; 
		echo "<tr><td>Тоо</td><td>".$number."</td></tr>"; 
		echo "<tr><td>Размер</td><td>".$size."</td></tr>"; 
		echo "<tr><td>Өнгө</td><td>".$color."</td></tr>"; 
		echo "<tr><td>Бодит үнэ</td><td>".$price."</td></tr>"; 
		echo "<tr><td>Tax</td><td>".$tax."</td></tr>"; 
		echo "<tr><td>Shipping</td><td>".$shipping."</td></tr>";
		echo "<tr><td>Дараа төлбөр</td><td>".$owe."</td></tr>"; 
		
			}
   			echo "</table>";
?>
</div>
</div>


<div class="panel panel-primary">
  <div class="panel-heading">Үнэ оруулах</div>
  <div class="panel-body">
  
<?
			echo $comment;
			
			echo form_open('admin/online_pricing');
			echo form_hidden("online_id",$online_id);	
			echo "Бодит үнэ:".form_input ("price",$price,array("class"=>"form-control","placeholder"=>"бодит үнэ"));
			echo "Тах:".form_input ("tax",$tax,array("class"=>"form-control","placeholder"=>"Тах"));
			echo "Shipping:".form_input ("shipping",$shipping,array("class"=>"form-control","placeholder"=>"Shipping"));
			echo "Дараа төлбөр:".form_input ("owe",$owe,array("class"=>"form-control","placeholder"=>"Дараа төлбөр"));
			echo form_submit("submit","Оруулах",array("class"=>"btn btn-success"));
			echo form_close();
?>

</div>
</div>
<?=anchor('admin/online','Бусад',array('class'=>"btn btn-primary"));?>