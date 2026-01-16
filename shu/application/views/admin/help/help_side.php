<div class="panel panel-danger">
  <div class="panel-heading">Тусламжийн цэс</div>
  <div class="panel-body">
   <ul class="list-group">
	<li class="list-group-item">
  	<?	$sql= "SELECT * FROM help WHERE receiver IS NULL AND `read_admin`='0'";
	$query = $this->db->query($sql);
  	echo anchor("admin/help","Тусламж хүссэн <span class='badge'>".$query->num_rows()."</span>");?>
  	</li>
	<li class="list-group-item">
  	<?=anchor("admin/help_history","Таны үүсгэсэн тусламжууд");?>
  	</li>
	<li class="list-group-item">
  	<?=anchor("admin/help_create","Таны үүсгэx");?>
  	</li>
  </ul>
  </div><!-- panel-body -->
  </div><!-- panel --> 
