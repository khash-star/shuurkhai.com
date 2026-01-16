<div class="panel panel-primary">
  <div class="panel-heading">Агентийн удирдлагын хэсэг</div>
  <div class="panel-body">
<? 

	$name=$_POST["name"];
	$username=$_POST["username"];
	$password=$_POST["password"];
	$password2=$_POST["password2"];
	if ($name!="" &&
	$username!="" &&
	$password!="" &&
	$password==$password2)
	$data = array(
               'name' => $name,
			   'username' => $username,
			   'password' => $password,
            );
	if ($this->db->insert('agents', $data)) echo '<div class="alert alert-success" role="alert">Амжилттай нэмлээ</div>';
	else echo '<div class="alert alert-danger" role="alert">ERROR:'.$this->db->error().'</div>';

?>
  </div><!-- PANEL-BODY -->
</div><!-- PANEL -->