<div class="panel panel-primary">
  <div class="panel-heading">Тусламж</div>
  <div class="panel-body">
<? 
$query = $this->db->query("SELECT * FROM help WHERE receiver IS NULL ORDER BY timestamp DESC");

if ($query->num_rows() >0)
{
	echo "<table class='table table-hover'>";
	echo "<tr><th>Огноо</th><th>Хариу</th><th>Хэнээс/Утас/Email</th><th width='50'>Тусламж</th><th width='150'>Үйлдэл</th>";
	foreach ($query->result() as $row)
		{
		$context=$row->context;
		$help_id=$row->help_id;
		$sender=$row->sender;
		$timestamp=$row->timestamp; 
		$read=$row->read_admin; 
		$reply = $row->reply; 
		$name=$row->name;
		$tel=$row->tel;
		$email=$row->email;
		echo "<tr>";
		echo "<td>$timestamp</td>";
		echo "<td>";
		if ($reply) echo '<span class="glyphicon glyphicon-share-alt"></span>';
		echo "</td>";
		if ($sender!=0)
		{
		echo "<td>";
		echo anchor("admin/customers_detail/".$sender, '<span class="glyphicon glyphicon-eye-open"></span>');
		echo customer($sender,"name");
		echo "<br>".customer($sender,"tel");
		echo "<br>".mailto(customer($sender,"email"),customer($sender,"email"));
		echo "</td>"; 
		}
		else echo "<td>".$name."<br>".$tel."<br>".mailto($email,$email)."</td>";
		
		echo "<td>";
		if (!$read) echo "<b>";
		echo anchor ("admin/help_read/".$help_id,$context."...");
		if (!$read) echo "</b>";
		echo "</td>";
		echo "<td><div class='btn-group'>";
			echo anchor ("admin/help_reply/".$help_id,"Хариу бичих",array("class"=>"btn btn-warning btn-xs"));
			echo anchor ("admin/help_deleting/".$help_id,"<span class='glyphicon glyphicon-trash'></span>",array("class"=>"btn btn-danger btn-xs"));
		echo "</td>";
		}
	echo "</table>";
	}
?>
  </div> <!-- PANEL BODY -->
</div><!-- PANEL  -->

