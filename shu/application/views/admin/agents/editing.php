<? if ($_POST["agent_id"]=="") redirect('admin/agents'); else $agent_id=$_POST["agent_id"]; ?>


<div class="panel panel-primary">
  <div class="panel-heading">Агентийн удирдлагын хэсэг</div>
  <div class="panel-body">
<? 
$query = $this->db->query("SELECT * FROM agents WHERE agent_id=".$agent_id);

if ($query->num_rows() == 1)
{
	$name=$_POST["name"];
	$username=$_POST["username"];
	$password=$_POST["password"];
	$password2=$_POST["password2"];
	$data = array(
               'name' => $name,
			   'username' => $username,
            );
	if ($password!="" && $password==$password2)
	$data = array(
               'password' => $password,
            );
	$this->db->where('agent_id', $agent_id);
	if ($this->db->update('agents', $data)) echo '<div class="alert alert-success" role="alert">Амжилттай заслаа.</div>';
	else echo '<div class="alert alert-danger" role="alert">Error'.$this->db->error().'</div>';

}
else echo '<div class="alert alert-danger" role="alert">Агент олдсонгүй.</div>';

?>
  </div><!-- PANEL-BODY -->
</div><!-- PANEL -->