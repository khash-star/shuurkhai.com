<? 
if (isset($_POST["tel"])) $tel=$_POST["tel"];
$query = $this->db->query("SELECT * FROM customer WHERE tel='".$tel."' LIMIT 1");
if ($query->num_rows() == 1)
{
	$row = $query->row();
	if (!isset($_POST["value"])) echo "Found user";
	else {
		$row = $query->row();
		$value = $_POST["value"];
		if ($value=="rd") echo $row->rd;
		if ($value=="surname") echo $row->surname;
		if ($value=="name") echo $name=$row->name;
		if ($value=="email") echo $row->email;
		if ($value=="address") echo $row->address;
		  }
}?>