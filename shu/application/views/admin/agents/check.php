<? if (isset($_POST["agent_id"])) $agent_id=$_POST["agent_id"];
$query = $this->db->query("SELECT * FROM agents WHERE agent_id='".$agent_id."' LIMIT 1");
if ($query->num_rows() == 1)
{
	$row = $query->row();
	$name=$row->name;
	$username=$row->username; 
	$last_log=$row->last_log;
	$status=$row->status;
	if (!isset($_POST["value"])) echo "Found user";
	else {
		if ($_POST["value"]=="username") echo $username;
		if ($_POST["value"]=="name") echo $name;
		if ($_POST["value"]=="last_log") echo $last_log;
		if ($_POST["value"]=="status") echo $status;
		  }
}
?>