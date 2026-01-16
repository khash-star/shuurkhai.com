<? if (!$this->uri->segment(3)) redirect('admin/help'); else $help_id=$this->uri->segment(3) ?>

<div class="panel panel-primary">
  <div class="panel-heading">Тусламж</div>
  <div class="panel-body">
<? 

 if($this->db->query("DELETE FROM help WHERE help_id=$help_id LIMIT 1"))
	echo '<div class="alert alert-success" role="alert">Тусламжийг устгалаа.</div>';
	else echo '<div class="alert alert-success" role="alert">Алдаа.'.$this->db->error.'</div>';
?>
  </div> <!-- PANEL BODY -->
</div><!-- PANEL  -->
 <? redirect('admin/help', 'refresh',3); ?>

