<div class="panel panel-primary">
  <div class="panel-heading">Shuurkhai.Com</div>
  <div class="panel-body">

<?
echo form_open('customers/logining');
echo "<span class='formspan'>Нэвтэх нэр</span>".form_input("tel")."<br>";
echo "<span class='formspan'>Нууц үг</span>".form_password("pass")."<br>";
echo form_submit("submit","нэвтрэх");
echo form_close();
?>

</div>
<div id="clear"></div>
</div> <!--wrapper-->