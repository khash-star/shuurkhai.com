<div class="panel panel-danger">
  <div class="panel-heading">Нууц үг солих</div>
  <div class="panel-body">
<?
$old_pass=$_POST["old"];
$new_pass=$_POST["new1"];
$new2_pass=$_POST["new2"];

$customer_id = $this->session->userdata('customer_id');
$query = $this->db->query("SELECT * FROM customer WHERE customer_id=".$customer_id);

if ($query->num_rows() == 1)
{
	$row = $query->row();
	$password=$row->password;
	if ($password!=$old_pass) 
	echo '<div class="alert alert-danger" role="alert">Хуучин нууц үг буруу</div>';
	else 
	{
	if ($new_pass!=$new2_pass && $new_pass=="")
	echo '<div class="alert alert-danger" role="alert">Шинэ нууг үг хоорондоо адилгүй эсвэл хоосон байж болохгүй.</div>';
	else 
		{
		if ($this->db->query("UPDATE customer SET password='$new_pass' WHERE customer_id='$customer_id' LIMIT 1"))
		echo '<div class="alert alert-success" role="alert">Нууц үг амжилттай солигдлоо.</div>';
		else echo '<div class="alert alert-danger" role="alert">Алдаа гарлаа.</div>';
		}
	}
}
echo anchor('customer/profile', 'Тохиргооруу буцах',array("class"=>"btn btn-success"));
?>

  </div> <!-- PANEL BODY -->
</div><!-- PANEL  -->
