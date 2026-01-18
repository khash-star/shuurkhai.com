<?php
	//require_once ('../config.php');

	if (!function_exists("protect"))
	{
		function protect($input)
		{
			$input = str_replace("<", "", $input);
			$input = str_replace(">", "", $input);
			$input = str_replace("*", "", $input);
			$input = str_replace("script", "", $input);
			$input = str_replace(" and ", "", $input);
			$input = str_replace(" or ", "", $input);
			$input = str_replace("'", "", $input);
			$input = str_replace('"', '', $input);
			return ($input);
		}
	}


if (!function_exists("settings"))
{
	function settings($id_or_shortname)
	{
		global $conn;
		if (is_int($id_or_shortname))
			$sql = "SELECT * FROM settings WHERE id='$id_or_shortname' LIMIT 1";
		else 
			$sql = "SELECT * FROM settings WHERE shortname='$id_or_shortname' LIMIT 1";

		$result = mysqli_query($conn,$sql);
		
		if ($result && mysqli_num_rows($result)==1)
			{
				$data = mysqli_fetch_array($result);
				return $data["value"];
			}
			else
				return "";
	}
}

if (!function_exists("parameters"))
{
	function parameters($param_name)
	{
		global $conn;
			$sql = "SELECT * FROM parameters WHERE name='$param_name' LIMIT 1";
	
		$result = mysqli_query($conn,$sql);
		
		if (mysqli_num_rows($result)==1)
			{
				$data = mysqli_fetch_array($result);
				return $data["value"];
			}
			else
				return "";
	}
}

if (!function_exists("price"))
{
	function price($product,$rank)
	{
		global $conn;
		$sql = "SELECT * FROM products WHERE id='$product' LIMIT 1";
		$result = mysqli_query($conn,$sql);
		if (mysqli_num_rows($result)==1)
		{
			$data = mysqli_fetch_array($result);
			switch ($rank)
			{
				case 'G1':
					return ($data["price_G1"]);
					break;
				case 'G2':
					return ($data["price_G2"]);
					break;
				case 'G3':
					return ($data["price_G3"]);
					break;
				case 'G4':
					return ($data["price_G4"]);
					break;
				case 'G5':
					return ($data["price_G5"]);
					break;
				case 'G6':
					return ($data["price_G6"]);
					break;
				case 'G7':
					return ($data["price_G7"]);
					break;
				case 'G8':
					return ($data["price_G8"]);
					break;
				case 'G9':
					return ($data["price_G9"]);
					break;
				case 'G10':
					return ($data["price_G10"]);
					break;
				default:
					return ($data["price_G3"]);
					break;
			}
		}
		else return (0);
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
							case "last_log":return $data_helper["last_log"]; break;
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


if (! function_exists ('cfg_price'))
{
	
	function cfg_price($weight)
	{
	if ($weight>1)return settings("paymentrate")*$weight;
	elseif ($weight>=0.5) return settings("paymentrate");
			elseif ($weight==0) return 0;
				else return settings("paymentrate_min");
	}
}

if (! function_exists ('cfg_price_old'))
{
	
	function cfg_price_old($weight)
	{
	if ($weight>1) return (settings("paymentrate")-1)*$weight;
	elseif ($weight>=0.5) return settings("paymentrate")-1;
			elseif ($weight==0) return 0;
				else return settings("paymentrate_min");
	}
}




if (!function_exists("progress"))
{
	function progress($input)
	{
		if ($input<5) return 0;
		if ($input>=5 && $input<10) return 5;
		if ($input>=10 && $input<15) return 10;
		if ($input>=15 && $input<20) return 15;
		if ($input>=20 && $input<25) return 20;
		if ($input>=25 && $input<30) return 25;
		if ($input>=30 && $input<35) return 30;
		if ($input>=35 && $input<40) return 35;
		if ($input>=40 && $input<45) return 40;
		if ($input>=45 && $input<50) return 45;
		if ($input>=50 && $input<55) return 50;
		if ($input>=55 && $input<60) return 55;
		if ($input>=60 && $input<65) return 60;
		if ($input>=65 && $input<70) return 65;
		if ($input>=70 && $input<75) return 70;
		if ($input>=75 && $input<80) return 75;
		if ($input>=80 && $input<85) return 80;
		if ($input>=85 && $input<90) return 85;
		if ($input>=90 && $input<95) return 90;
		if ($input>=95 && $input<100) return 95;
		if ($input>=100) return 100;
	}
}

if (!function_exists("status"))
	{
		function status($input)
		{
		switch ($input)
			{
				case "onair":return "Онгоцоор ниссэн";break;				
				case "warehouse":return "Монголд ирсэн";break;
				case "received":return "DE-д ирсэн";break;
				case "weight_missing":return "Илгээмж ирээгүй";break;
				case "new":return "Нисэхэд бэлэн";break;				
				case "delivered":return "Гардаж авсан";break;
				case "custom":return "Гаальд үлдсэн";break;
				case "item_missing":return "Бараа тайлбар";break;
				case "order":return "Тодорхойгүй";break;
				default: return $input; break;
			}
		}
	}

if (!function_exists("gmt"))
	{
		function gmt($gmt,$timestamp)
		{
			if ($timestamp<>"0000-00-00 00:00:00")
			return (date('Y-m-d H:i:s',strtotime($gmt." hours", strtotime($timestamp))));
			else  return "---";
		}
	}
if (!function_exists("nationality"))
{
	function nationality($input)
	{
		switch ($input)
		{
			case ("altai-urianhai") : 
			case (1): return "Алтайн Урианхай";break;
			case ("barga") : case (2): return "Барга";break;
			case ("baoan") : case (3): return "Баоань";break;
			case ("bayd") : case (4): return "Баяд";break;
			case ("buriad") : case (5): return "Буриад";break;
			case ("darhad") : case (6): return "Дархад";break;
			case ("dariganga") : case (7): return "Дарьганга";break;
			case ("deed") : case (8): return "Дээд Монголчууд";break;
			case ("durvud") : case (9): return "Дөрвөд";break;
			case ("zahchin") : case (10): return "Захчин";break;
			case ("kazak") : case (11): return "Казах Хасаг";break;
			case ("mongor") : case (12): return "Монгор Ту";break;
			case ("myngad") : case (13): return "Мянгад";break;
			case ("uuld") : case (14): return "Өөлд";break;
			case ("oirad") : case (15): return "Синьцзяны Ойрадууд";break;
			case ("torguud") : case (16): return "Торгууд";break;
			case ("tuva") : case (17): return "Тува Урианхай";break;
			case ("uzemchin") : case (18): return "Үзэмчин";break;
			case ("halh") : case (19): return "Халх";break;
			case ("hamniga") : case (20): return "Хамниган";break;
			case ("hotogoid") : case (21): return "Хотогойд";break;
			case ("hoton") : case (22): return "Хотон";break;
			case ("huvsgul-urianhai") : case (23): return "Хөвсгөлийн Урианхай Ар Ширхтэн Урианхай";break;
			case ("halh") : case (24): return "Халх";break;
			case ("tsahar") : case (25): return "Цахар";break;
		}
	}
}


if (!function_exists("resize_image"))
{
	function resize_image($file, $w, $h, $crop=FALSE) 
	{
		list($width, $height) = getimagesize($file);
		$r = $width / $height;
		if ($crop) {
			if ($width > $height) {
				$width = ceil($width-($width*abs($r-$w/$h)));
			} else {
				$height = ceil($height-($height*abs($r-$w/$h)));
			}
			$newwidth = $w;
			$newheight = $h;
		} else {
			if ($w/$h > $r) {
				$newwidth = $h*$r;
				$newheight = $h;
			} else {
				$newheight = $w/$r;
				$newwidth = $w;
			}
		}
		$src = imagecreatefromjpeg($file);
		$dst = imagecreatetruecolor($newwidth, $newheight);
		imagecopyresampled($dst, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

		return $dst;
	}
}


if (!function_exists("address"))
{
	function address($customer_id)
	{
		global $conn;
		if (empty($customer_id)) {
			return '';
		}
		$customer_id_escaped = mysqli_real_escape_string($conn, $customer_id);
		$sql = "SELECT city.name city_name, district.name district_name,customer.address_khoroo khoroo,address_build build,address_extra extra FROM customer 
		LEFT JOIN city ON customer.address_city = city.id
		LEFT JOIN district ON customer.address_district = district.id
		WHERE customer.customer_id='".$customer_id_escaped."' LIMIT 1";
		$result = mysqli_query($conn,$sql);
		if ($result && ($data = mysqli_fetch_array($result))) {
			$city_name = isset($data["city_name"]) ? trim($data["city_name"]) : '';
			$district_name = isset($data["district_name"]) ? trim($data["district_name"]) : '';
			$khoroo = isset($data["khoroo"]) ? trim($data["khoroo"]) : '';
			$build = isset($data["build"]) ? trim($data["build"]) : '';
			$extra = isset($data["extra"]) ? trim($data["extra"]) : '';
			$address_parts = array_filter([$city_name, $district_name, $khoroo, $build, $extra]);
			return implode(' ', $address_parts);
		}
		return '';
	}
}

if (!function_exists("address_deliver"))
{
	function address_deliver($address)
	{
		global $conn;
		if (empty($address)) {
			return '';
		}
		$address_escaped = mysqli_real_escape_string($conn, $address);
		$sql = "SELECT customer_address.*,city.name city_name, district.name district_name FROM customer_address 
		LEFT JOIN city ON customer_address.city=city.id
		LEFT JOIN district ON customer_address.district=district.id
		WHERE customer_address.id='".$address_escaped."' ORDER BY timestamp DESC LIMIT 1";
		$result_temp = mysqli_query($conn,$sql);
		if ($result_temp && ($data_temp = mysqli_fetch_array($result_temp))) {
			$city_name = isset($data_temp["city_name"]) ? trim($data_temp["city_name"]) : '';
			$district_name = isset($data_temp["district_name"]) ? trim($data_temp["district_name"]) : '';
			$khoroo = isset($data_temp["khoroo"]) ? trim($data_temp["khoroo"]) : '';
			$build = isset($data_temp["build"]) ? trim($data_temp["build"]) : '';
			$extra = isset($data_temp["extra"]) ? trim($data_temp["extra"]) : '';
			$address_parts = array_filter([$city_name, $district_name, $khoroo, $build, $extra]);
			return implode(' ', $address_parts);
		}
		return '';
	}
}


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

if (! function_exists ('getRealIp'))
{
	function getRealIp() {
		if (!empty($_SERVER['HTTP_CLIENT_IP'])) {  //check ip from share internet
		$ip=$_SERVER['HTTP_CLIENT_IP'];
		} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {  //to check ip is pass from proxy
		$ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
		} else {
		$ip=$_SERVER['REMOTE_ADDR'];
		}
		return $ip;
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

if (! function_exists ('short_date'))
{
	function short_date($long_date)
	{
		// $map = array('M' => 1000, 'CM' => 900, 'D' => 500, 'CD' => 400, 'C' => 100, 'XC' => 90, 'L' => 50, 'XL' => 40, 'X' => 10, 'IX' => 9, 'V' => 5, 'IV' => 4, 'I' => 1);
		$month = substr($long_date,5,2);
		$day = substr($long_date,8,2);
		switch($month)
		{
			case '01': $month='I';break;
			case '02': $month='II';break;
			case '03': $month='III';break;
			case '04': $month='IV';break;
			case '05': $month='V';break;
			case '06': $month='VI';break;
			case '07': $month='VII';break;
			case '08': $month='VIII';break;
			case '09': $month='IX';break;
			case '10': $month='X';break;
			case '11': $month='XI';break;
			case '12': $month='XII';break;
			default: $month=$month;
		}
		return ($month.'/'.$day);
	}
}


if (! function_exists ('cfg_paymentrate_branch'))
{
	function cfg_paymentrate_branch()
	{
	global $conn;	
	$result=mysqli_query($conn,"SELECT * FROM settings WHERE shortname='paymentrate_branch' LIMIT 1");
	$data=mysqli_fetch_array($result);
	return $data["value"];	
	}
}


if (! function_exists ('cfg_price_branch'))
{
	
	function cfg_price_branch($weight)
	{
		if ($weight>1) return settings("paymentrate_branch")*$weight;
		elseif ($weight==0) return 0;
		else return settings("paymentrate_branch");		
	}
}


?>
