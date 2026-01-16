<? if(!isset($_POST["help_id"])) redirect('admin/help'); else $help_id=$_POST["help_id"]; ?>
<div class="clearfix"></div><br />
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
	$ip=$row->ip; 
	echo "<tr><td>Огноо</td><td>$timestamp</td></tr>";
	echo "<tr><td>Нэр</td><td>".customer($sender,"name")."</td></tr>";
	echo "<tr><td>Утас</td><td>".customer($sender,"tel")."</td></tr>";
	echo "<tr><td>Email</td><td>".mailto(customer($sender,"email"),customer($sender,"email"))."</td></tr>";
	echo "<tr><td>IP</td><td>$ip</td></tr>";
	echo "<tr><td>Тусламж</td><td>$context</td></tr>";
	echo "<tr><td>Тусламжын хариу</td><td>".$_POST["context"]."</td></tr>";
	echo "</table>";
		$data = array(
			   'context'=>$_POST["context"],
			   'sender'=>NULL,
			   'receiver'=>$sender,
			   'name' =>"",
			   'tel' =>"",
			   'email' =>"",
			   'ip' =>$_SERVER['REMOTE_ADDR']
            );

	if ($this->db->insert('help', $data))
		{
		echo '<div class="alert alert-success" role="alert">
  	<span class="glyphicon glyphicon-ok-circle"></span>Хариуг бичлээ.</div>';
		$this->db->query("UPDATE help SET reply=1 WHERE help_id='$help_id' LIMIT 1");

		}
	else
	echo '<div class="alert alert-danger" role="alert">
  	<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
  	</span>Алдаа:'.$this->db->error().'</div>';

}
else echo "Тусламж олдсонгүй";
?>
	


</div>
</div>

