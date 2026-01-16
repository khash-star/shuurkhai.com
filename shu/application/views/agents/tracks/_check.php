<?php

	if ((isset($_POST["barcode"])&&$_POST["barcode"]!="")||(isset($_GET["barcode"])&&$_GET["barcode"]!=""))
	{
	$barcode=$_POST["barcode"];
	if (substr($barcode,0,2)=="CP" || substr($barcode,0,2)=="GO")
	$query = $this->db->query("SELECT * FROM orders WHERE barcode=\"$barcode\" LIMIT 1");
	else 
	$query = $this->db->query("SELECT * FROM orders WHERE third_party=\"$barcode\" LIMIT 1");

	if ($query->num_rows() == 1)
		{
		$row = $query->row();
		$order_id=$row->order_id;
		$barcode=$row->barcode;// track № into barcode
		$third_party=$row->third_party;
		$receiver_id=$row->receiver;
		$created_date=$row->created_date;
		$status=$row->status;
		$weight=$row->weight;
		echo "Track бүртгэлтэй байна. <br>";
		if ($status =="order") echo "Хүлээн авагч нь тодорхойгүй байна.";
		if ($status =="filled") echo "Хүлээн авагч бөглөгдсөн байна. ".anchor("agents/tracks_preview/".$order_id,"CP72 хэвлэх",array('target'=>"new"));
		if ($status =="new") echo "Нисэхэд бэлэн. ".anchor("agents/tracks_preview/".$order_id,"CP72 хэвлэх",array('target'=>"new"));
		if ($status =="onair") echo "Нисэж буй төлөвт байна. ";
		if ($status =="custom") echo "Гаальд саатсан. ";
		if ($status =="warehouse") echo "Агуулахад хүрсэн байна. ";
		if ($status =="delivered") echo "Хүргэгдсэн байна. ";
		
		if ($status=="weight_missing") 
		{
			echo "Жин дутуу байна.";
			echo form_open("agents/tracks_adding");
			echo form_hidden("track",$barcode);
			//echo "<div class=\"box\">";
			//echo "<h4 class=\"legend\">Бараа</h4>";
			echo "<span class='formspan'>Нийт жин/кг/</span>";
			echo form_input ("weight")."<br>";
			echo form_submit("submit","нэмэх");
			echo form_close();
		}
		
		
		}
	else 
	{
	echo "Track бүртгэлгүй байна. Бүртгэлгүй Track-г жинг оруулан хандалж болно.";
	echo form_open("agents/tracks_adding");
	echo form_hidden("track",$barcode);
	//echo "<div class=\"box\">";
	//echo "<h4 class=\"legend\">Бараа</h4>";
	echo "<span class='formspan'>Нийт жин/кг/</span>";
	echo form_input ("weight")."<br>";
	echo "<span class='formspan'>Утас</span>";
	echo form_input ("contact")."<br>";
	
	echo form_submit("submit","нэмэх");
	echo form_close();
	}
	}
	else exit;
?>