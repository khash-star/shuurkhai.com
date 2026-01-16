<div class="panel panel-primary">
  <div class="panel-heading">Мэдээ: Оруулах</div>
  <div class="panel-body">

<? 
	$title=$_POST["title"];
	$context=$_POST["context"];
	
	$data = array(
               'title' => $title,
			   'context' => $context,
            );
	if ($this->db->insert('news', $data)) echo "Амжилттай нэмлээ.<br>";
	else echo "ERROR".$this->db->error();


?>

</div>
</div>