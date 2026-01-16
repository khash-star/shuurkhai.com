<? if ($this->uri->segment(3)) $track = $this->uri->segment(3); else redirect('orders/track');?>
<? if ($this->uri->segment(4)) $tel = $this->uri->segment(4); else redirect('orders/track_register/'.$track);?>
<div class="panel panel-primary">
  <div class="panel-heading">Shuurkhai.Com</div>
  <div class="panel-body">
<?
	$query = $this->db->query("SELECT * FROM customer WHERE tel='".$tel."' LIMIT 1");
if ($query->num_rows() == 1)
{
	$row = $query->row();
	$customer_id = $row->customer_id ;
	$name = $row->name;
	$surname = $row->surname;
	
	echo "<div class=\"box\">";
	echo "<h4 class=\"legend\">Хэрэглэгч</h4>";
	echo "Таны дугаар <b style='font-size:larger'>".substr($surname,0,2).".".$name." </b> нэр дээр бүртгэлтэй байна.<br>";
	echo "Та энэ нэрээр захиалгаа бүртгүүлэх үү?<br><br>";
	echo anchor ("orders/track_detail2/".$track."/".$tel,"Тийм",array('class'=>'button'))." ";
	echo anchor ("orders/track_register/".$track,"Үгүй",array('class'=>'button'))."<br>";
	echo "</div>";
	
}

if ($query->num_rows() == 0)
  redirect('customers/register/'.$tel);
?>
</div>
