<? if (!$this->uri->segment(3)) redirect('admin/faqs'); else $faqs_id=$this->uri->segment(3); ?>

<div class="panel panel-primary">
  <div class="panel-heading">Асуултыг засах</div>
  <div class="panel-body">
	<? 
    $query = $this->db->query("SELECT * FROM faqs WHERE faqs_id=".$faqs_id);
    
    if ($query->num_rows() == 1)
    {
        $row = $query->row();
        $question=$row->question;
        $answer=$row->answer; 
    
        echo form_open('admin/faqs_editing');
        echo form_hidden('faqs_id',$faqs_id);
        echo "<span class='formspan'>Асуулт(*)</span>";
        echo form_input ("question",$question,array("class"=>"form-control","required"=>"required"))."<br>";
		echo "<span class='formspan'>Хариулт(*)</span>";
        echo form_textarea ("answer",$answer,array("class"=>"form-control","required"=>"required"))."<br>";
		
        echo form_submit("submit","засах",array("class"=>"btn btn-success"));
        echo form_close();
		echo "<br><br>";
		
        echo anchor("admin/faqs_deleting/".$faqs_id,"устгах",array("class"=>"btn btn-danger btn-xs"));
    
    }
    else echo "Асуулт байхгүй";
    
    ?>

	</div>
</div>