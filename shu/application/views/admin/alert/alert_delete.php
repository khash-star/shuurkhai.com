<div class="panel panel-primary">
  <div class="panel-heading">Бүх нийтийн мэдэгдэл: Устгах</div>
  <div class="panel-body">
<? 
	if ($this->db->query("DELETE FROM alert WHERE type=1")) echo "Амжилттай устгалаа";
		else "Error:".$this->db->error;
?>

</div>
</div>