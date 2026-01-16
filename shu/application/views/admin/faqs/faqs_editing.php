<? if ($_POST["faqs_id"]=="") redirect('admin/faqs'); else $faqs_id=$_POST["faqs_id"]; ?>


<div class="panel panel-primary">
  <div class="panel-heading">Асуултыг засах</div>
  	<div class="panel-body">
		<? 
        $query = $this->db->query("SELECT * FROM faqs WHERE faqs_id=".$faqs_id);
        
        if ($query->num_rows() == 1)
        {
            $answer=$_POST["answer"];
            $question=$_POST["question"];
            
            $data = array(
                       'answer' => $answer,
                       'question' => $question,
                    );
            $this->db->where('faqs_id', $faqs_id);
            if ($this->db->update('faqs', $data)) echo "Амжилттай заслаа.<br>";
            else echo "ERROR".$this->db->error();
        
        }
        else echo "Асуулт олдоогүй";
        ?>

	</div>
</div>