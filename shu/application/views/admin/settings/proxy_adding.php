<div class="panel panel-primary">
  <div class="panel-heading">Publi Proxy нэмэх</div>
  <div class="panel-body">
<? 

 $name=$_POST["proxy_name"];
 $surname=$_POST["proxy_surname"];
 $address=$_POST["proxy_address"];
 $contacts=$_POST["proxy_contacts"];

 if ($contacts!="" && $surname!="" &&  $address!="" && $contacts!="") 
 {
	  $data = array(
               'name' => $name,
               'surname' => $surname,
			   'address' =>$address,
			   'tel' => $contacts,
	);

	 if($this->db->insert('proxies_public', $data)) 
		{
		echo "Амжилттай нэмлээ";
		echo "<table class='table table-hover'>";
		echo "<tr><td>Нэр</td><td>".$name."</td></tr>";	
		echo "<tr><td>Овог</td><td>".$surname."</td></tr>";
		echo "<tr><td>Утас</td><td>".$contacts."</td></tr>";	
		echo "<tr><td>Хаяг</td><td>".$address."</td></tr>";	
		echo "</table>";
		echo anchor ("admin/proxy/","Бүх Public Proxy",array("class"=>"btn btn-primary"));
		}
 }
 else 
 {
	 echo "Аль нэг талбар хоосон байна.";
	 echo anchor ("admin/proxy_add/","Ахин оролдох",array("class"=>"btn btn-primary"));
 }

?>
</div>
<div id="clear"></div>
</div>