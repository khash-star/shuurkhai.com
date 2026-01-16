<? if (isset($_POST["tel"])) $tel=$_POST["tel"];
$query = $this->db->query("SELECT * FROM customer WHERE tel='".$tel."' LIMIT 1");
if ($query->num_rows() == 1)
{
	$row = $query->row();
	$name=$row->name;
	$surname=$row->surname; 
	$rd=$row->rd;
	$contacts=$row->tel;
	$address=$row->address;
	$email=$row->email;
	if (!isset($_POST["value"])) echo "Found user";
	else {
		if ($_POST["value"]=="rd") echo $rd;
		if ($_POST["value"]=="surname") echo $surname;
		if ($_POST["value"]=="name") echo $name;
		if ($_POST["value"]=="email") echo $email;
		if ($_POST["value"]=="address") echo $address;
		  }
}
?>