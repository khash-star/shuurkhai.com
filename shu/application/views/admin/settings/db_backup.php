<div class="panel panel-primary">
  <div class="panel-heading">Shuurkhai.Com</div>
  <div class="panel-body">
<h3>DB backup</h3>
<?
//$backup_file = 'db_backup'. date("Y-m-d-H-i-s") . '.gz';
//$command = "$ mysqldump --opt -h localhost -u root -p sw01b116 system | gzip > $backup_file";

//system($command);
echo "DB амжилттай хадгаллаа";
?>

</div>

<div id="right_side">
<? $this->load->view("calendar");?>
<? $this->load->view("rate");?>
<div id="side_menu">
<ul>
<li><?=anchor('settings/edit', 'Тохиргоог өөрчлөх')?></li>
<li><?=anchor('settings/events', 'Календарчилал')?></li>
<li><?=anchor('settings/page_edit', 'Page edit')?></li>
<li><?=anchor('settings/page2_edit', 'Page2 edit')?></li>
<li><?=anchor('settings/logs', 'Log харах')?></li>
<li><?=anchor('settings/db_backup', 'DB backup')?></li>
<li><?=anchor('settings/db_backup', 'DB backup')?></li>
</ul>
</div> <!--side_menu-->
</div> <!--right_side-->
<div id="clear"></div>
</div> <!--wrapper-->