<div class="panel panel-primary">
  <div class="panel-heading">SETTINGS</div>
  <div class="panel-body">
<? 
$rate=$_POST["rate"];
$paymentrate=$_POST["paymentrate"];
$paymentrate2=$_POST["paymentrate2"];
$paymentrate_min=$_POST["paymentrate_min"];
$delete_pass=$_POST["delete_pass"];
$nextdeliver=$_POST["nextdeliver"];
$admin_username=$_POST["admin_username"];
$admin_password=$_POST["admin_password"];

$error = TRUE;

	$data = array(
               'param_value' => $rate,
			);
	$this->db->where('param_name', 'rate');
	
	if ($this->db->update('settings', $data))
		{
		
		log_write("settings change rate=$rate","settings");
		}
		else $error=false;
		
		
	$data = array(
               'param_value' => $paymentrate,
			);
	$this->db->where('param_name', 'paymentrate');
	
	if ($this->db->update('settings', $data))
		{
		
		log_write("settings change payment_rate=$paymentrate","settings");
		}
		else $error=false;

	$data = array(
               'param_value' => $paymentrate2,
			);
	$this->db->where('param_name', 'paymentrate2');
	
	if ($this->db->update('settings', $data))
		{
		
		log_write("settings change payment_rate2=$paymentrate2","settings");
		}
		else $error=false;


	
	$data = array(
               'param_value' => $paymentrate_min,
			);
	$this->db->where('param_name', 'paymentrate_min');
	
	if ($this->db->update('settings', $data))
		{
		
		log_write("settings change paymentrate_min=$paymentrate_min","settings");
		}
		else $error=false;
		
	
	$data = array(
               'param_value' => $delete_pass,
			);
	$this->db->where('param_name', 'delete_pass');
	
	if ($this->db->update('settings', $data))
		{
		
		log_write("settings change delete_pass=$delete_pass","settings");
		}
		else $error=false;


	$data = array(
               'param_value' => $nextdeliver,
			);
	$this->db->where('param_name', 'nextdeliver');
	
	if ($this->db->update('settings', $data))
		{
		
		log_write("settings change nextdeliver=$nextdeliver","settings");
		}
		else $error=false;


	$data = array(
               'param_value' => $admin_username,
			);
	$this->db->where('param_name', 'admin_username');
	
	if ($this->db->update('settings', $data))
		{
		
		log_write("settings change admin_username=$admin_username","settings");
		}
		else $error=false;
	
	if ($admin_password!="")
	{
	$data = array(
               'param_value' => $admin_password,
			);
	$this->db->where('param_name', 'admin_password');
	
	if ($this->db->update('settings', $data))
		{
		
		log_write("settings change admin_password=*****","settings");
		}
		else $error=false;
	}


		
				
	if ($error) echo '<div class="alert alert-success" role="alert">Амжилттай засагдлаа</div>';
	
	$paymentrate=cfg_paymentrate();
	$paymentrate2=cfg_paymentrate2();
	$rate=cfg_rate();
	$cfg_paymentrate_min=cfg_paymentrate_min();
	$nextdeliver=cfg_param("nextdeliver");
	$admin_username=cfg_param("admin_username");
	$admin_password=cfg_param("admin_password");

	echo "<table class='table table-hover'>";
	echo "<tr><td>Долларын ханш</td><td>1$=".$rate."₮</td></tr>";
	echo "<tr><td>Үйлчилгээний хөлс</td><td>0,5кг-н доош =".$paymentrate_min."$</td></tr>";
	echo "<tr><td>Үйлчилгээний хөлс</td><td>0,5кг-н дээш =".$paymentrate."$</td></tr>";
	echo "<tr><td>Илгээмж </td><td> =".$paymentrate2."$</td></tr>";
	echo "<tr><td>Еврогийн ханш</td><td>=".$delete_pass."$</td></tr>";
	echo "<tr><td>Дараагын ачаа ирэх</td><td>".$nextdeliver."</td></tr>";
	echo "<tr><td>Админ нэвтрэх нэр</td><td>".$admin_username."</td></tr>";
	echo "<tr><td>Админ нууц үг</td><td>*****</td></tr>";

	echo "</table>";
	echo anchor ("admin/settings_edit","Ахин өөрчилөх",array("class"=>"btn btn-primary btn-xs"));

?>

  </div><!-- PANEL-BODY -->
</div><!-- PANEL -->
<?=anchor ("admin/settings","Тохиргоо",array("class"=>"btn btn-success"));?>
