<? if (isset($_POST["order_id"])) $order_id=$_POST["order_id"]; else redirect('admin/tracks');  ?>

<div class="panel panel-primary">
  <div class="panel-heading">Track:Track modify</div>
  <div class="panel-body">
<? 
//$agent_id= $this->session->userdata("agent_id");
$query = $this->db->query("SELECT * FROM orders WHERE order_id='".$order_id."'");

if ($query->num_rows() == 1)
{
    $row = $query ->row();
    if ($row ->status=="delivered" || $row ->status=="custom")
      
      { 
          if ($this->db->query("UPDATE orders SET third_party='".$_POST["new"]."' WHERE order_id=".$order_id))
      	  echo "Трак солилоо.";	 else echo $this->db->error;
      }

      else echo "Зөвхөн гардуулсан эсвэл агуулахын ачааны тракыг засах боломжтой";
} 
else echo "Трак олдсонгүй<br>";

?>

</div>
</div>
