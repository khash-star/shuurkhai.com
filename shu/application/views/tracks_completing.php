<? if (!isset($_POST["track"]) && $_POST["track"]=="") redirect("welcome/track_search"); 
else {
	$track=$_POST["track"]; 
	$track = str_replace(" ","",$track);
	$track = str_replace("script","***",$track);
	$track = str_replace("php","***",$track);
	$track = str_replace("<?","***",$track);
	 }
	if (isset($_POST["contact"]) && $_POST["contact"]=="") redirect("welcome/track_search");
	else
	{
	$contact=$_POST["contact"]; 
	$contact = str_replace(" ","",$contact);
	$contact = str_replace("script","***",$contact);
	$contact = str_replace("php","***",$contact);
	$contact = str_replace("<?","***",$contact);
	} 
	
?>
<div class="panel panel-success">
  <div class="panel-heading">Та Тракаа бүртгүүлснээр 1&cent; таны хуримтлалын санд нэмэгдэнэ.</div>
  <div class="panel-body">
<? 
if (!isset($_POST["container_trigger"]))
	{
	$track_eliminated = substr($track,-8,8);
	$sql = "SELECT * FROM orders WHERE SUBSTRING(third_party,-8,8) = '$track_eliminated'";
	$query = $this->db->query($sql);
	if ($query->num_rows() > 1) echo "1-с олон track олдлоо. Та хайлтын утгаа ихэсгэж ахин оролдоно уу? <br>".anchor("welcome/track_search","Ахин оролдох",array("class"=>"btn btn-xs btn-primary"));
	if ($query->num_rows() == 1)
		{
		$row = $query->row();
		$status = $row->status;
		if ($status=="new") echo "USА оффис-д байгаа Монголруу нисэхэд бэлэн болсон.";
		if ($status=="item_missing") echo "Задаргаагүй. Илгээмжийн доторх мэдээллийг оруулаагүй байна. Иймд Монголруу гарах боложгүй. Та нэвтэрч орон Track-aa өөр дээрээ бүртгүүлж барааны тайлбараа бөглөнө үү";
		if ($status=="warehouse") echo "Монгол дахь агуулахад ирсэн байна. Та өөрийн биеэр ирж авах боломжтой.";
		if ($status=="onair") echo "Америкаас Монголруу ирж яваа.";
		if ($status=="delivered") echo "Илгээмжийг хүлээн авч олгосон.";
		if ($status=="filled") echo "Барааны мэдээллийн бүрэн оруулсан байна. Бид мэдээллийг шалган наашаа гаргахад бэлэн төлөвт оруулах болно.";
		if ($status=="weight_missing") echo "Ачаа манай Америк дахь салбарт хүргэгдээгүй байна. Та Track дугаар дээрээ дарж хаана явааг харах боломжтой.";
		if ($status=="custom") echo "Гаальд саатсан байна.";
		echo "<br><br>";
		echo "<i>Хэрэв таны ачаа хүргэгдсэн төлөв байгаад манайд бүртгэгдээгүй бол бидэнд яаралтай мэдэгдэнэ үү.</i>";
		}

	if ($query->num_rows() == 0)  //Бүтргэлгүй
		{
	
		$sql2 = "SELECT customer_id,password,name FROM customer WHERE tel='$contact' LIMIT 1";
		$query2 = $this->db->query($sql2);
		if ($query2->num_rows() == 1)
			{
			$row2 = $query2->row();
			$customer_id = $row2->customer_id;
			$proxy_id=0;$proxy_available_id=0;
				
			if ($_POST["trigger"]==1)
				{
				$proxy_name = $_POST["name"];
				$proxy_surname = $_POST["surname"];
				$proxy_tel = $_POST["tel"];
				$proxy_address = $this->db->escape($_POST["address"]);
				
				$query_proxies =  $this->db->query('SELECT * FROM proxies WHERE customer_id="'.$customer_id.'" AND tel="'.$proxy_tel.'"');
				if ($query_proxies->num_rows()==1)
					{
					$row_proxy = $query_proxies->row();
					$proxy_id = $row_proxy -> proxy_id;					
					}
				if ($query_proxies->num_rows()==0)	
					{
					$this->db->query('INSERT INTO proxies (customer_id,name,surname,tel,address,single) VALUES("'.$customer_id.'","'.$proxy_name.'","'.$proxy_surname.'","'.$proxy_tel.'","'.$proxy_address.'",1)');
					$proxy_id= $this->db->insert_id(); 	
					}
				}
				if ($proxy_id==0)
				{
				$query_proxies = $this->db->query('SELECT * FROM proxies WHERE customer_id="'.$customer_id.'" AND single=0 ORDER BY proxy_id  DESC');
					if ($query_proxies->num_rows()>0)
					{
					foreach($query_proxies->result() as $row_proxy)
					{
					$proxy_id = $row_proxy -> proxy_id;
					$order_proxy = $this->db->query('SELECT * FROM orders WHERE receiver="'.$customer_id.'" AND proxy_id="'.$proxy_id.'" AND status NOT IN ("delivered","warehouse","custom","onair")');
					
					if ($order_proxy->num_rows() == 0) 
					$proxy_available_id= $proxy_id;
					}
					}
				}
				
				$sender=USA_OFFICE_id;
				$receiver=$row2->customer_id;
				
				$package1_name=$_POST["package1_name"];
				$package1_num =$_POST["package1_num"];
				$package1_price =$_POST["package1_price"];
				$package2_name=$_POST["package2_name"];
				$package2_num =$_POST["package2_num"];
				$package2_price =$_POST["package2_price"];
				$package3_name=$_POST["package3_name"];
				$package3_num =$_POST["package3_num"];
				$package3_price =$_POST["package3_price"];
				$package4_name=$_POST["package4_name"];
				$package4_num =$_POST["package4_num"];
				$package4_price =$_POST["package4_price"];
				
				$package_array = array(
				$package1_name, $package1_num, $package1_price,
				$package2_name, $package2_num, $package2_price,
				$package3_name, $package3_num, $package3_price,
				$package4_name, $package4_num, $package4_price
				);
				
				$package =implode("##",$package_array);
				$package_price = $package1_price + $package2_price + $package3_price + $package4_price;
				$transport = 0;
				
				$barcode='GO'.date("ymd").sprintf("%03d",rand(000,999)).'MN';
		do {
  			$barcode='GO'.date("ymd").sprintf("%03d",rand(000,999)).'MN';
 			$query = $this->db->query("SELECT order_id FROM orders WHERE barcode='$barcode'");
			} 
		while ($query->num_rows() == 1); 	
			$data = array(
						'created_date'=>date("Y-m-d H:i:s"),
						'barcode'=>$barcode,
						'third_party'=>$track,
						'package'=>$package,
						'price'=>$package_price,
						'sender' => $sender,
						'receiver' => $receiver,
						'status' => "weight_missing",
						'proxy_id' => $proxy_available_id,
						'transport' => $transport,
						'is_online' => 1
							);
			if ($this->db->insert('orders', $data))
					{
					echo '<div class="alert alert-success alert-xs" role="alert">Тракийг амжилттай үүсгэлээ.</div>';
					$this->db->query("UPDATE customer SET cent=cent+1 WHERE customer_id='$customer_id'");
					}
				}	
			}
		}
	/////////////////////////////////////////////////////////////////////////////////
	/////////////////////////////////////////////////////////////////////////////////
	/////////////////////////////////////////////////////////////////////////////////
	/////////////////////////////////////////////////////////////////////////////////
	/////////////////////////////////////////////////////////////////////////////////
	/////////////////////////////////////////////////////////////////////////////////
	/////////////////////////////////////////////////////////////////////////////////
	/////////////////////////////////////////////////////////////////////////////////	

	if (isset($_POST["container_trigger"]))
	{
		$track_eliminated = substr($track,-8,8);
		$sql = "SELECT * FROM container_item WHERE SUBSTRING(track,-8,8) = '$track_eliminated'";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 1) 
			echo "1-с олон track олдлоо. Та хайлтын утгаа ихэсгэж ахин оролдоно уу? <br>".anchor("welcome/track_search","Ахин оролдох",array("class"=>"btn btn-xs btn-primary"));
		if ($query->num_rows() == 1)
		{
		$row = $query->row();
		$status = $row->status;
		if ($status=="new") echo "USА оффис-д байгаа Монголруу далайгаар гарахад бэлэн болсон.";
		if ($status=="item_missing") echo "Задаргаагүй. Илгээмжийн доторх мэдээллийг оруулаагүй байна. Иймд Монголруу гарах боложгүй. Та нэвтэрч орон Track-aa өөр дээрээ бүртгүүлж барааны тайлбараа бөглөнө үү";
		if ($status=="warehouse") echo "Монгол дахь агуулахад ирсэн байна. Та өөрийн биеэр ирж авах боломжтой.";
		if ($status=="onway") echo "Америкаас Монголруу далайгаар ирж яваа.";
		if ($status=="delivered") echo "Илгээмжийг хүлээн авч олгосон.";
		if ($status=="filled") echo "Барааны мэдээллийн бүрэн оруулсан байна. Бид мэдээллийг шалган наашаа гаргахад бэлэн төлөвт оруулах болно.";
		if ($status=="custom") echo "Гаальд саатсан байна.";
		echo "<br><br>";
		echo "<i>Хэрэв таны ачаа хүргэгдсэн төлөв байгаад манайд бүртгэгдээгүй бол бидэнд яаралтай мэдэгдэнэ үү.</i>";
		}

			if ($query->num_rows() == 0)  //Бүтргэлгүй
				{
				$sql2 = "SELECT customer_id,password,name FROM customer WHERE tel='$contact' LIMIT 1";
				$query2 = $this->db->query($sql2);
				if ($query2->num_rows() == 1)
					{
					$row2 = $query2->row();
					$customer_id = $row2->customer_id;
					$proxy_id=0;$proxy_available_id=0;
						
					if ($_POST["trigger"]==1)
						{
						$proxy_name = $_POST["name"];
						$proxy_surname = $_POST["surname"];
						$proxy_tel = $_POST["tel"];
						$proxy_address = $this->db->escape($_POST["address"]);
						
						$query_proxies =  $this->db->query('SELECT * FROM proxies WHERE customer_id="'.$customer_id.'" AND tel="'.$proxy_tel.'"');
						if ($query_proxies->num_rows()==1)
							{
							$row_proxy = $query_proxies->row();
							$proxy_id = $row_proxy -> proxy_id;					
							}
						if ($query_proxies->num_rows()==0)	
							{
							$this->db->query('INSERT INTO proxies (customer_id,name,surname,tel,address,single) VALUES("'.$customer_id.'","'.$proxy_name.'","'.$proxy_surname.'","'.$proxy_tel.'","'.$proxy_address.'",1)');
							$proxy_id= $this->db->insert_id(); 	
							}
						}
						if ($proxy_id==0)
						{
						$query_proxies = $this->db->query('SELECT * FROM proxies WHERE customer_id="'.$customer_id.'" AND single=0 ORDER BY proxy_id  DESC');
							if ($query_proxies->num_rows()>0)
							{
							foreach($query_proxies->result() as $row_proxy)
							{
							$proxy_id = $row_proxy -> proxy_id;
							$order_proxy = $this->db->query('SELECT * FROM orders WHERE receiver="'.$customer_id.'" AND proxy_id="'.$proxy_id.'" AND status NOT IN ("delivered","warehouse","custom","onair")');
							
							if ($order_proxy->num_rows() == 0) 
							$proxy_available_id= $proxy_id;
							}
							}
				}
				
				$sender=USA_OFFICE_id;
				$receiver=$row2->customer_id;
				
				$package1_name=$_POST["package1_name"];
				$package1_num =$_POST["package1_num"];
				$package1_price =$_POST["package1_price"];
				$package2_name=$_POST["package2_name"];
				$package2_num =$_POST["package2_num"];
				$package2_price =$_POST["package2_price"];
				$package3_name=$_POST["package3_name"];
				$package3_num =$_POST["package3_num"];
				$package3_price =$_POST["package3_price"];
				$package4_name=$_POST["package4_name"];
				$package4_num =$_POST["package4_num"];
				$package4_price =$_POST["package4_price"];
				
				$package_array = array(
				$package1_name, $package1_num, $package1_price,
				$package2_name, $package2_num, $package2_price,
				$package3_name, $package3_num, $package3_price,
				$package4_name, $package4_num, $package4_price
				);
				
				$package =implode("##",$package_array);
				$package_price = $package1_price + $package2_price + $package3_price + $package4_price;
				$transport = 0;
				
				$barcode='CO'.date("ymd").sprintf("%03d",rand(000,999)).'MN';
		do {
  			$barcode='CO'.date("ymd").sprintf("%03d",rand(000,999)).'MN';
 			$query = $this->db->query("SELECT id FROM container_item WHERE barcode='$barcode'");
			} 
		while ($query->num_rows() == 1); 	
			$data = array(
						'created_date'=>date("Y-m-d H:i:s"),
						'barcode'=>$barcode,
						'track'=>$track,
						'package'=>$package,
						'sender' => $sender,
						'receiver' => $receiver,
						'status' => "weight_missing",
						'proxy_id' => $proxy_available_id,
						'owner' => 1,
						'is_online' => 1
							);
			if ($this->db->insert('container_item', $data))
					{
					echo '<div class="alert alert-success alert-xs" role="alert">Таны ачаа чингэлэгээр ирхээр боллоо.</div>';
					$this->db->query("UPDATE customer SET cent=cent+1 WHERE customer_id='$customer_id'");
					}
				}	
			}
		}
?>
  </div> <!-- PANEL BODY -->
</div><!-- PANEL  -->

<?=anchor("welcome/track_search","Ахин хайх",array("class"=>"btn btn-primary"));?>
<?=anchor("welcome/login","Нэвтрэх",array("class"=>"btn btn-success"));?>