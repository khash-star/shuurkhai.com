<div class="panel panel-success">
  <div class="panel-heading">Delaware Трак хайлтын үр дүн</div>
  <div class="panel-body">
<? 
$track = $_POST["search"];
$query = $this->db->query("SELECT branch_inventories.*,driver,contact FROM branch_inventories LEFT JOIN branch_transport ON branch_inventories.transport=branch_transport.id WHERE track='".$track."'");

if ($query->num_rows() == 1)
{
   	$row = $query->row();
	
    echo "<table class='table table-hover'>";
    echo "<tr><td>Трак уншуулсан</td><td>".$row->created_date."</td></tr>";
    echo "<tr><td>Трак</td><td>".$track."</td></tr>";
    echo "<tr><td>Коммент</td><td>".$row->comment."</td></tr>";
    echo "<tr><td>Жолооч</td><td>".$row->driver."</td></tr>";
    echo "<tr><td>Жолоочын утас</td><td>".$row->contact."</td></tr>";
	echo "</table>";

   }
   else echo "Delaware-д энэ трак бүртгэлгүй";

?>
</div> <!--side_menu-->
</div> <!--right_side-->
