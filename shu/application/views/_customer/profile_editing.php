<div class="panel panel-danger">
  <div class="panel-heading">Хувийн мэдээлэл</div>
  <div class="panel-body">
<? 
$customer_id = $this->session->userdata('customer_id');
$surname = $_POST["surname"];
$rd =$_POST["rd"];
$email = $_POST["email"];
$address = $_POST["address"];
$sql="UPDATE customer SET surname='$surname',rd='$rd',email='$email',address='".$address."' WHERE customer_id=$customer_id LIMIT 1";
if ($this->db->query($sql))
{
	echo '<div class="alert alert-success" role="alert">Амжилттай заслаа.</div>';
}
else echo '<div class="alert alert-danger" role="alert">Алдаа гарлаа.</div>';
?>
  </div> <!-- PANEL BODY -->
</div><!-- PANEL  -->
<?	echo anchor('customer/profile','Буцах',array("class"=>"btn btn-warning"))."<br>"; ?>
