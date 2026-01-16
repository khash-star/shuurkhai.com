<? if (!$this->uri->segment(3)) redirect('orders/online'); else $online_id=$this->uri->segment(3) ?>

<div class="panel panel-success">
  <div class="panel-heading">Shuurkhai.Com</div>
  <div class="panel-body">
<? 
echo "<h3>Online Илгээмж устгах</h3>";
$query = $this->db->query("SELECT * FROM online WHERE online_id=".$online_id);

if ($query->num_rows() == 1)
{
    if($this->db->query("DELETE FROM online WHERE online_id=".$online_id))
	echo "Online захиалгыг амжилттай устгалаа.<br>";
	else echo "Алдаа.".$this->db->error."<br>";
  
} 
else 
echo "Online Илгээмж олдсонгүй<br>";

?>

</div>
<div id="right_side">
<? $this->load->view("calendar");?>
<div id="side_menu">
<ul>
<li><?=anchor('online_orders', 'Илгээмжүүд')?></li>
<li><?=anchor('online_orders/create', 'Илгээмж оруулах')?></li>
</ul>
</div> <!--side_menu-->
</div> <!--right_side-->
<div id="clear"></div>
</div><!--wrapper-->