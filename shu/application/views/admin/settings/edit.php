<div class="panel panel-primary">
  <div class="panel-heading">SETTINGS</div>
  <div class="panel-body">
<? 
$paymentrate=cfg_paymentrate();
$paymentrate2=cfg_paymentrate2();
$paymentrate_min=cfg_paymentrate_min();
$delete_pass=cfg_deletepass();
$rate=cfg_rate();
$nextdeliver=cfg_param("nextdeliver");
$admin_username=cfg_param("admin_username");
$admin_password=cfg_param("admin_password");

echo form_open("admin/settings_editing");
echo "<table class='table table-hover'>";
echo "<tr><td>Долларын ханш 1$=</td><td>".form_input("rate",$rate,array("class"=>"form-control"))."</td></tr>";
echo "<tr><td>Үйлчилгээний хөлс 1кг=</td><td>".form_input("paymentrate",$paymentrate,array("class"=>"form-control"))."</td></tr>";
echo "<tr><td>Илгээмжийн хөлс 1кг=</td><td>".form_input("paymentrate2",$paymentrate2,array("class"=>"form-control"))."</td></tr>";
echo "<tr><td>Үйлчилгээний хөлс 0,5кг-с бага</td><td>".form_input("paymentrate_min",$paymentrate_min,array("class"=>"form-control"))."</td></tr>";
echo "<tr><td>Еврогийн ханш</td><td>".form_input("delete_pass",$delete_pass,array("class"=>"form-control"))."</td></tr>";
echo "<tr><td>Дараагийн ачаа ирэх</td><td>".form_input("nextdeliver",$nextdeliver,array("class"=>"form-control"))."</td></tr>";
echo "<tr><td>Админ нэвтрэх нэр</td><td>".form_input("admin_username",$admin_username,array("class"=>"form-control"))."</td></tr>";
echo "<tr><td>Админ нууц үг /солихгүй бол хоосон орхи/</td><td>".form_input("admin_password","",array("class"=>"form-control"))."</td></tr>";

echo "</table>";
echo form_submit("submit","Хадгалах",array("class"=>"btn btn-success"));
echo form_close();
?>

  </div><!-- PANEL-BODY -->
</div><!-- PANEL -->