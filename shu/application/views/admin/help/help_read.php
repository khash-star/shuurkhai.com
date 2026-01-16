<? if (!$this->uri->segment(3)) redirect('admin/help'); else $help_id=$this->uri->segment(3) ?>

<div class="panel panel-primary">
  <div class="panel-heading">Тусламж</div>
  <div class="panel-body">
<? 
$query = $this->db->query("SELECT * FROM help WHERE help_id='$help_id' LIMIT 1");

if ($query->num_rows()==1)
{
	echo "<table class='table table-hover'>";
	$row= $query->row() ;
	$context=$row->context;
	$help_id=$row->help_id;
	$sender=$row->sender;
	$timestamp=$row->timestamp; 
	$read=$row->read_admin; 
	$ip =$row->ip;
	echo "<tr><td>Огноо</td><td>$timestamp</td></tr>";
	echo "<tr><td>Нэр</td><td>".customer($sender,"name")."</td></tr>";
	echo "<tr><td>Утас</td><td>".customer($sender,"tel")."</td></tr>";
	echo "<tr><td>Email</td><td>".mailto(customer($sender,"email"),customer($sender,"email"))."</td></tr>";
	echo "<tr><td>IP</td><td>$ip</td></tr>";
	echo "<tr><td>Тусламж</td><td>$context</td></tr>";
	echo "</table>";
	echo anchor ("admin/help_reply/".$help_id,"Хариу бичих",array("class"=>"btn btn-warning"));
	$this->db->query("UPDATE help SET `read_admin`=1 WHERE help_id='$help_id' LIMIT 1");
}
?>
  </div> <!-- PANEL BODY -->
</div><!-- PANEL  -->

