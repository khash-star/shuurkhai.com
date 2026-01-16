<?
if (! function_exists ('string_clean'))
{
	function string_clean($string)
	{

 	 	$string = str_replace(' ', '', $string); // Replaces all spaces with hyphens.

   		return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
	}
}


if (! function_exists ('proxy_available'))
{
	function proxy_available($proxy_id,$proxy_type,$status)
	{
		global $conn;
		
	if ($proxy_type ==0)
		mysqli_query($conn,"UPDATE proxies SET status=$status WHERE proxy_id=$proxy_id");
	
	if ($proxy_type ==1)
		mysqli_query($conn,"UPDATE proxies_public SET status=$status WHERE proxy_id=$proxy_id");
	}
}



if (! function_exists ('customer'))
{
	function customer($customer_id,$parameter)
	{
	global $conn;
	if($customer_id>=0)
		{
		if ($customer_id==0) $admin=TRUE; else $admin=FALSE; 
  		//if ($admin) return "Admin"; else return "Not Admin";
		if (!$admin)
			{
			$sql_helper = "SELECT * FROM customer WHERE customer_id='$customer_id' LIMIT 1";
			$result_helper = mysqli_query($conn,$sql_helper);
			if (mysqli_num_rows($result_helper)==1)
					{
					$data_helper =mysqli_fetch_array($result_helper);
					switch ($parameter)
						{
							case "name":return $data_helper["name"]; break;
							case "surname":return $data_helper["surname"]; break;
							case "rd":return $data_helper["rd"]; break;
							case "address":return $data_helper["address"]; break;
							case "address_extra":return $data_helper["address_extra"]; break;
							case "tel":return $data_helper["tel"]; break;
							case "last_log":return $data_helper["address"]; break;
							case "email":return $data_helper["email"]; break;
							case "full_name":return $data_helper["name"]." ".$data_helper["surname"];break;
							case "cent":return $data_helper["cent"];break;
						}
					}
					else return "";
				}
			else 
				{
				switch ($parameter)
					{
						case "name":return "Shuurkhai.com"; break;
						case "surname": return ""; break;
						case "rd": return ""; break;
						case "address": return "4712 OAKTON STREET, 60076, Chicago IL"; break;
						case "address_extra": return ""; break;
						case "tel": return  "773-621-6807"; break;
						case "last_log": return ""; break;
						case "email": return ""; break;
						case "full_name": return "Shuurkhai.com";break;
						case "cent": return 0;break;
					}
				}
		}
		else return "";
	}

}



if (! function_exists ('status_comfort'))
{
	function status_comfort($status)
	{
		switch ($status)
		{
	case "new":  return "<span style='color:#0AA508'>USА оффис <span class='glyphicon glyphicon-question-sign' data-toggle='tooltip' data-placement='top' title='Монголруу нисэхэд бэлэн болсон.'></span></span>"; break;
	case "item_missing":  return "Задаргаагүй <span class='glyphicon glyphicon-question-sign' data-toggle='tooltip' data-placement='top' title='Илгээмжийн доторх мэдээллийг оруулаагүй байна. Иймд Монголруу гарах боложгүй. Та Track-aa бүртгүүлж барааны тайлбараа бөглөнө үү'></span>"; break;
	case "warehouse":  return "<span style='color:#0AA508'>Ирсэн <span class='glyphicon glyphicon-question-sign' data-toggle='tooltip' data-placement='top' title='Монгол дахь агуулахад ирсэн байна. Та өөрийн биеэр ирж авах боломжтой.'></span></span>"; break;
	case "onair":  return "<span style='color:#0810A5'><b>Ирж яваа <span class='glyphicon glyphicon-question-sign' data-toggle='tooltip' data-placement='top' title='Америкаас Монголруу гарсан байна.'></b></span></span>"; break;
	case "delivered":  return "Авсан <span class='glyphicon glyphicon-question-sign' data-toggle='tooltip' data-placement='top' title='Илгээмжийг хүлээн авсан.'></span>"; break;
	case "filled":  return "Бөглөсөн <span class='glyphicon glyphicon-question-sign' data-toggle='tooltip' data-placement='top' title='Та барааны мэдээллийн бүрэн оруулсан байна. Бид мэдээллийг шалган наашаа гаргахад бэлэн төлөвт оруулах болно.'></span>"; break;
	case "weight_missing":  return "<span style='color:#A50810'>Хүргэгдээгүй <span class='glyphicon glyphicon-question-sign' data-toggle='tooltip' data-placement='top' title='Таны захиалсан бараа манай Америк дахь салбарт хүргэгдээгүй байна. Та Track дугаар дээрээ дарж хаана явааг харах боломжтой.'></span></span>"; break;
	case "custom":  return "Гааль <span class='glyphicon glyphicon-question-sign' data-toggle='tooltip' data-placement='top' title='Гаальд саатсан байна.'></span>"; break;
	case "online":  return "Онлайн <span class='glyphicon glyphicon-question-sign' data-toggle='tooltip' data-placement='top' title='Онлайн захиалга хэвээр байна. Таны төлбөр хийгдсэн тохиолдолд барааг захиалах боломжтой.'></span>"; break;
	
	case "order":  return "Илгээмж <span class='glyphicon glyphicon-question-sign' data-toggle='tooltip' data-placement='top' title='Таны онлайн хүсэлтийг төлбөрийн төлөлт хийгдсэн. Та идэвхитэй илгэмжүүд цэснээс хаана явааг харах боломжтой.'></span>"; break;
	//case "proxy":  return "Утасны дугаар <span class='glyphicon glyphicon-education' data-toggle='tooltip' data-placement='top' title='Таны ачааг '></span>"; break;
	case "pending":  return "Pending <span class='glyphicon glyphicon-question-sign' data-toggle='tooltip' data-placement='top' title='Сайтад захиалга хийгдсэн бөгөөд шуудангийн Track дугаар хүлээгдэж байна.'></span>"; break;
		default: return $status; break;
	case "":  return "Тодорхойгүй <span class='glyphicon glyphicon-question-sign' data-toggle='tooltip' data-placement='top' title='Та дэлгэрэнгүй мэдээллийг манайхаас утсаар тодруулна.'></span>"; break;
	case "onway":  return "Ирж яваа <span class='glyphicon glyphicon-question-sign' data-toggle='tooltip' data-placement='top' title='Таны ачаа далайгаар ирж явна.'></span>"; break;
	case "handover":  return "<span style='color:#881111'>Хүргэлтэнд гарсан<span class='glyphicon glyphicon-question-sign' data-toggle='tooltip' data-placement='top' title='Таны ачаа монголд ирсэн ба хүргэлтээр гарсан байна.'></span></span>"; break;
	default:  return "Тодорхойгүй <span class='glyphicon glyphicon-question-sign' data-toggle='tooltip' data-placement='top' title='Та дэлгэрэнгүй мэдээллийг манайхаас утсаар тодруулна.'></span>"; break;
		}
	}
	


}


if (! function_exists ('track'))
{
	function track($track)
	{
	$lowered = strtolower($track);
	
	$recon =0;
	if (substr($lowered,0,2)=="1z") 
	{
	$string =  "https://wwwapps.ups.com/WebTracking/processInputRequest?sort_by=status&tracknums_displayed=1&TypeOfInquiryNumber=T&loc=en_US&InquiryNumber1=$track&track.x=0&track.y=0";
	$recon =1;}
	if ($recon==0 && substr($lowered,0,3)=="tba") 
	{$string= "https://www.shuurkhai.com/login/index.php/welcome/amazon_track/"; $recon=1;}
	
	if (
	(substr($lowered,0,4)=="9405"||
	substr($lowered,0,4)=="9505"||
	substr($lowered,0,4)=="9261"||
	substr($lowered,0,4)=="9205"||
	substr($lowered,0,4)=="9407"||
	substr($lowered,0,4)=="9303"||
	substr($lowered,0,4)=="9270"||
	//substr($lowered,0,4)=="9274"||
	substr($lowered,0,4)=="9208"||
	substr($lowered,0,4)=="9305"||
	substr($lowered,0,4)=="9202"||
	substr($lowered,0,4)=="9400"||
	substr($lowered,0,3)=="420" ||
	substr($lowered,0,4)=="9361" ||
	substr($lowered,0,4)=="9374" ||
	substr($lowered,0,4)=="9500" ||
	substr($lowered,0,4)=="9274" ||
	substr($lowered,0,4)=="9410" ||
	strlen($lowered)==13)&&$recon==0
	)
	{
	$string ="https://tools.usps.com/go/TrackConfirmAction?tLabels=$track";
	$recon =1;
	}
	
	if (
	(substr($lowered,0,4)!="9405"&&
	substr($lowered,0,4)!="9261"&&
	substr($lowered,0,4)!="9505"&&
	substr($lowered,0,4)!="9205"&&
	substr($lowered,0,4)!="9407"&&
	substr($lowered,0,4)!="9303"&&
	substr($lowered,0,4)!="9270"&&
	//substr($lowered,0,4)!="9274"&&
	substr($lowered,0,4)!="9208"&&
	substr($lowered,0,4)!="9305"&&
	substr($lowered,0,4)!="9202"&&
	substr($lowered,0,4)!="9400"&&
	substr($lowered,0,4)!="9374"&&
	substr($lowered,0,4)!="9500"&&
	strlen($lowered)!=13&&
	substr($lowered,0,3)!="420"&&
	substr($lowered,0,4)!="9361")&&
	
	$recon==0)
	{
	$string ="https://www.fedex.com/apps/fedextrack/?action=track&tracknumbers=$track";
	$recon =1;
	} 
	if ($recon==0&&$lowered!="") $string ="https://search.yahoo.com/yhs/search;_ylt=A0LEVvVpNPZWOgwAJW8nnIlQ;_ylc=X1MDMTM1MTE5NTY4NwRfcgMyBGZyA3locy1tb3ppbGxhLTAwMQRncHJpZAN0MGFZd0U5cVExT1FRWm1uUlZPQzVBBG5fcnNsdAMwBG5fc3VnZwMxBG9yaWdpbgNzZWFyY2gueWFob28uY29tBHBvcwMwBHBxc3RyAwRwcXN0cmwDBHFzdHJsAzIyBHF1ZXJ5Azk2MTI4MDQ2ODM3Mzg1MjcxNTU0MDQEdF9zdG1wAzE0NTg5Nzc0NTU-?p=$track&fr2=sb-top-search&hspart=mozilla&hsimp=yhs-001";
	return $string;
	}
	
}


if (! function_exists ('proxy'))
{
	function proxy($proxy_id,$parameter)
	{
	global $conn;	
	$sql_helper = "SELECT * FROM proxies WHERE proxy_id='$proxy_id' LIMIT 1";
	$result_helper  = mysqli_query($conn,$sql_helper);
	if (mysqli_num_rows($result_helper)>0)
	{
	$data_helper = mysqli_fetch_array($result_helper);
	//$row=$query ->row();

		switch ($parameter)
		{
			case "name": return $data_helper["name"];break;
			case "surname":return $data_helper["surname"]; break;
			case "address":return $data_helper["address"]; break;
			case "tel":return $data_helper["tel"]; break;
			case "full_name":return $data_helper["surname"]." ".$data_helper["name"];break;
		}
	}
	else return "";
	}
	

}

if (! function_exists ('days'))
{
	function days($date)
	{
	return (strtotime(date("Y-m-d")) - strtotime(date("Y-m-d",strtotime($date))))/3600/24;	
	}
}


if (! function_exists ('cfg_rate'))
{
	function cfg_rate()
	{
		global $conn;
		$result_helper =mysqli_query($conn,"SELECT * FROM settings WHERE param_name='rate' LIMIT 1");
		$data_helper=mysqli_fetch_array($result_helper);
		return $data_helper["param_value"];
	}

}



if (! function_exists ('cfg_paymentrate'))
{
	function cfg_paymentrate()
	{
	global $conn;
	$result_helper =mysqli_query($conn,"SELECT * FROM settings WHERE param_name='paymentrate' LIMIT 1");
	$data=mysqli_fetch_array($result_helper);
	return $data["param_value"];	
	}
}

if (! function_exists ('cfg_paymentrate_min'))
{
	function cfg_paymentrate_min()
	{
	global $conn;
	$result_helper =mysqli_query($conn,"SELECT * FROM settings WHERE param_name='paymentrate_min' LIMIT 1");
	$data=mysqli_fetch_array($result_helper);
	return $data["param_value"];	
	}
}


if (! function_exists ('cfg_price'))
{
	
	function cfg_price($weight)
	{
	if ($weight>1)return cfg_paymentrate()*$weight;
	elseif ($weight>=0.5) return cfg_paymentrate();
			elseif ($weight==0) return 0;
				else return cfg_paymentrate_min();
	}
}


if (! function_exists ('order'))
{
	function order($order_id,$parameter)
	{
	global $conn;

	$result_helper =mysqli_query($conn,"SELECT * FROM orders WHERE order_id='$order_id' LIMIT 1");
	if (mysqli_num_rows($result_helper)==1)
	{
	$data_helper=mysqli_fetch_array($result_helper);
		switch ($parameter)
		{
			case "weight":return $data_helper["weight"]; break;
			case "track":return $data_helper["third_party"]; break;
			case "barcode":return $data_helper["barcode"]; break;
			default :return "";
		}	
	}
	else return "";
	}
	

}




if (! function_exists ('online'))
{
	function online($online_id,$parameter)
	{
	global $conn;

	$result_helper =mysqli_query($conn,"SELECT * FROM online WHERE online_id='$online_id' LIMIT 1");
	if (mysqli_num_rows($result_helper)==1)
	{
	$data_helper=mysqli_fetch_array($result_helper);
		switch ($parameter)
		{
			case "url":return $data_helper["url"]; break;
			case "track":return $data_helper["track"]; break;
			case "title":return $data_helper["title"]; break;
			case "price":return $data_helper["price"]; break;
			case "tax":return $data_helper["tax"]; break;
			case "shipping":return $data_helper["shipping"]; break;

			default :return "";
		}	
	}
	else return "";
	}
	

}

if (! function_exists ('cfg_param'))
{
	function cfg_param($name)
	{
		global $conn;
		  $cfg_query=mysqli_fetch_array(mysqli_query($conn,"SELECT * FROM settings WHERE param_name='$name' LIMIT 1"));
		  return $cfg_query["param_value"];
	}

}



	function protect($input)
	{
		$input = strtolower($input);
		$input = str_replace("<", "", $input);
		$input = str_replace(">", "", $input);
		$input = str_replace("script", "", $input);
		$input = str_replace(" and ", "", $input);
		$input = str_replace(" or ", "", $input);
		$input = str_replace("'", "", $input);
		$input = str_replace('"', '', $input);
		return ($input);
	}



if (! function_exists ('tracksearch'))
{
	function tracksearch($track)
	{
		$filter_date = date('Y-m-d', strtotime(date('Y-m-d') . ' -2 month'));

		$track = str_replace(" ", "", $track);
		global $conn;
		if (substr($track,0,2)=='22' || substr($track,0,2)=='ES')
			$query=mysqli_query($conn,"SELECT * FROM orders WHERE third_party = '$track' AND created_date>='$filter_date 00:00:00' LIMIT 1");
		if (substr($track,0,2)!='22' && substr($track,0,2)!='ES')
			{
				$track_eliminated = substr($track,-8,8);
				$result = 
				$query=mysqli_query($conn,"SELECT * FROM orders WHERE SUBSTRING(third_party,-8,8) = '$track_eliminated' AND created_date>='$filter_date 00:00:00' LIMIT 1");
			}
		if (mysqli_num_rows($query)==1)
		{
		$row=mysqli_fetch_array($query);
		return $row["order_id"];
		}
		else return "";
	}
}

if (! function_exists ('tracksearch_container'))
{
	function tracksearch_container($track)
	{
		$filter_date = date('Y-m-d', strtotime(date('Y-m-d') . ' -6 month'));
		global $conn;
		$track = str_replace(" ", "", $track);
		if (substr($track,0,2)=='22' || substr($track,0,2)=='ES')
			$query=mysqli_query($conn,"SELECT * FROM container_item WHERE track = '$track' AND created_date>='$filter_date 00:00:00' LIMIT 1");
		if (substr($track,0,2)!='22' && substr($track,0,2)!='ES')
			{
				$track_eliminated = substr($track,-8,8);
				$query=mysqli_query($conn,"SELECT * FROM container_item WHERE SUBSTRING(track,-8,8) = '$track_eliminated' AND created_date>='$filter_date 00:00:00' LIMIT 1");
			}
		if (mysqli_num_rows($query)==1)
		{
		$row=mysqli_fetch_array($query);
		return $row["id"];
		}
		else return "";
	}
}

?>
