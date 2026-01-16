<? if (!$this->uri->segment(3)) redirect('admin/faqs'); else $faqs_id=$this->uri->segment(3); ?>


<div class="panel panel-primary">
  <div class="panel-heading">Асуултыг устгах</div>
      <div class="panel-body">
        <? 
    
        if ($this->db->query("DELETE FROM faqs WHERE faqs_id=".$faqs_id)) echo "Амжилттай устгалаа";
            else "Error:".$this->db->error;
        ?>
    
        </div>
</div>