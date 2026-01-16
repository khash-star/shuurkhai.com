<? if (!isset($_POST["track"]) && $_POST["track"]=="") redirect("welcome/track_search"); 
else {
	$track=$_POST["track"]; 
	$track = str_replace(" ","",$track);
	$track = str_replace("script","***",$track);
	$track = str_replace("php","***",$track);
	$track = str_replace("<?","***",$track);
}

?>
<div class="panel panel-success">
  <div class="panel-heading">Та Тракаа бүртгүүлснээр 1&cent; таны хуримтлалын санд нэмэгдэнэ.</div>
  <div class="panel-body">
<? 
$track_eliminated = substr($track,-8,8);
$sql = "SELECT * FROM orders WHERE SUBSTRING(third_party,-8,8) = '$track_eliminated'";
$query = $this->db->query($sql);
if ($query->num_rows() > 1) echo "1-с олон track олдлоо. Та хайлтын утгаа ихэсгэж ахин оролдоно уу? <br>".anchor("welcome/track_search","Ахин оролдох",array("class"=>"btn btn-xs btn-primary"));
if ($query->num_rows() == 1)
{
	$row = $query->row();
	//$receiver = $row->receiver;
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
	
	echo "<h3>Утасны дугаараа оруулна уу.</h3>";
	echo form_open('welcome/track_register');
	echo form_hidden("track",$track);
	//if ($this->session->userdata('saved')!="") 
	//$saved=$this->session->userdata('saved'); else $saved="";
	echo form_input("contact","",array("placeholder"=>"Утасны дугаар Жишээ:99123456)","class"=>"form-control"))."<br>";	
	
	echo form_submit("submit","Шалгах",array("class"=>"btn btn-success"));
	echo " &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
	echo anchor("welcome/track_search","Ахин хайх",array("class"=>"btn btn-primary"));
	echo "<br>";


	echo "<span style='color:#a61212;'><i>Таны оруулсан Track-тай ачаа манайд ирээгүй байна. Та <a href='".track($track)."' target='_blank'> энд </a> дарж хаана явж буй харах боломжтой.</i></span><br>";

	
	
}
/*if(!isset($_POST["sender_trigger"]))
{
$sender_name=$_POST["sender_name"];
$sender_tel=$_POST["sender_tel"];
$sender_address=$_POST["sender_address"];
}
else $sender=$customer_id;

if(!isset($_POST["receiver_trigger"]))
{
$receiver_name=$_POST["receiver_name"];
$receiver_tel=$_POST["receiver_tel"];
$receiver_address=$_POST["receiver_address"];
}
else */

/*sql_track = "SELECT * FROM orders WHERE third_party='$track'";
$query_track = $this->db->query($sql_track);
if ($query_track->num_rows() == 0)
	{
	$sender=USA_OFFICE_id;
	$receiver=$customer_id;
	
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
	$package1_name, $package1_num, "","",$package1_price,
	$package2_name, $package2_num, "","",$package2_price,
	$package3_name, $package3_num, "","",$package3_price,
	$package4_name, $package4_num, "","",$package4_price
	);
	
	$package =implode("##",$package_array);
	$package_price = $package1_price + $package2_price + $package3_price + $package4_price;
	
	
	$barcode='GO'.date("ymd").sprintf("%03d",rand(000,999)).'MN';
do {
  $barcode='GO'.date("ymd").sprintf("%03d",rand(000,999)).'MN';
  $query = $this->db->query("SELECT order_id FROM orders WHERE barcode='$barcode'");
} while ($query->num_rows() == 1); 
	
	$data = array(
					'created_date'=>date("y-m-d h:i:s"),
					'barcode'=>$barcode,
					'third_party'=>$track,
					'package'=>$package,
					'price'=>$package_price,
					'sender' => $sender,
					'receiver' => $receiver,
					'status' => "weight_missing",
					'is_online' => 1
					
				);
	if ($this->db->insert('orders', $data))
		echo '<div class="alert alert-success alert-xs" role="alert">Захиалга амжилттай үүсгэлээ.</div>';
		else echo '<div class="alert alert-danger" role="alert">Илгээмж үүсгэхэд алдаа гарлаа.</div>';
	}
	else 
	{ 	
		//echo '<div class="alert alert-danger" role="alert">Таны оруулсан Track бүртгэлтэй байна.</div>';
		$row_track = $query_track->row();
		if ($row_track->receiver==$customer_id)
		{
			echo '<div class="alert alert-success" role="alert">Таны оруулсан Track тань дээр бүртгэлтэй байна.</div>';
			if ($row_track->status=="order")
			echo anchor ("customer/orders_owning/".$row_track->order_id,"Өөрийн болгох",array("class"=>"btn btn-success btn-xs"));
			else echo anchor ("customer/orders_detail/".$row_track->order_id,"Дэлгэрэнгүй",array("class"=>"btn btn-warning btn-xs"));
		}
		
		else echo '<div class="alert alert-danger" role="alert">Таны оруулсан Track өөр хүнд бүртгэлгүй байна.</div>';*/
	//}
?>
  </div> <!-- PANEL BODY -->
</div><!-- PANEL  -->

