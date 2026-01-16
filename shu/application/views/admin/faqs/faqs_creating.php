<div class="panel panel-primary">
  <div class="panel-heading">Асуулт үүсгэх</div>
  <div class="panel-body">
	<? 
	$question=$_POST["question"];
	$answer=$_POST["answer"];	
	$data = array(
               'question' => $question,
			   'answer' => $answer,
            );
	if ($this->db->insert('faqs', $data)) echo "Амжилттай нэмлээ.<br>";
	else echo "ERROR".$this->db->error();
	?>
	
	</div>
</div>