<? if (!$this->uri->segment(3)) redirect('admin/agents'); else $agent_id=$this->uri->segment(3) ?>

<div id="dialog-confirm" title="Агентийн мэдээлэл устгах" style="display:none;">
<p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>Энэ Агентийг устгах уу?</p>
</div>

<div class="panel panel-primary">
  <div class="panel-heading">Агентийн удирдлагын хэсэг</div>
  <div class="panel-body">
<? 
$query = $this->db->query("SELECT * FROM agents WHERE agent_id=".$agent_id);

if ($query->num_rows() == 1)
{
	$row = $query->row();
	$name=$row->name;
	$username=$row->username; 
	$password=$row->password;
	$last_log=$row->last_log;
	$status=$row->status;

	echo form_open('admin/agents_editing');
	echo form_hidden('agent_id',$agent_id);
	echo "<table class='table table-hover'>";
	echo "<tr><td>Нэр</td><td>".form_input ("name",$name, array("class"=>"form-control"))."</td></tr>";
	echo "<tr><td>Нэвтрэх нэр</td><td>".form_input ("username",$username, array("class"=>"form-control"))."</td></tr>";
	echo "<tr><td>Нууц үг</td><td>".form_password ("password","", array("class"=>"form-control"))."</td></tr>";
	echo "<tr><td>Нууц үг (давт)</td><td>".form_password ("password2","", array("class"=>"form-control"))."</td></tr>";
	echo "</table>";
	echo form_submit("submit","засах", array("class"=>"btn  btn-success"));
	echo form_close();

 

}
else echo '<div class="alert alert-danger" role="alert">Агент олдсонгүй</div>';

?>
  </div><!-- PANEL-BODY -->
</div><!-- PANEL -->