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


echo "<table class='table table-hover'>";
echo "<tr><td>Долларын ханш 1$</td><td>".$rate."₮</td></tr>";
echo "<tr><td>Үйлчилгээний хөлс 1кг</td><td>".$paymentrate."$</td></tr>";
echo "<tr><td>Илгээмж 1кг</td><td>".$paymentrate2."$</td></tr>";
echo "<tr><td>Үйлчилгээний хөлс 0,5кг-с бага</td><td>".$paymentrate_min."$</td></tr>";
echo "<tr><td>Еврогийн ханш</td><td>".$delete_pass."$</td></tr>";
echo "<tr><td>Дараагын ачаа ирэх</td><td>".$nextdeliver."</td></tr>";
echo "<tr><td>Админ нэвтрэх нэр</td><td>".$admin_username."</td></tr>";
echo "<tr><td>Админ нууц үг</td><td>*****</td></tr>";
echo "</table>";
?>

  </div><!-- PANEL-BODY -->
</div><!-- PANEL -->