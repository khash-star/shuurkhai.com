<?php
	// require_once("../config.php");
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
			$sql = "SELECT *FROM settings WHERE id='$id_or_shortname' LIMIT 1";
		else 
			$sql = "SELECT *FROM settings WHERE shortname='$id_or_shortname' LIMIT 1";

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

if (!function_exists("parameters"))
{
	function parameters($param_name)
	{
		global $conn;
			$sql = "SELECT *FROM parameters WHERE name='$param_name' LIMIT 1";
	
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
		$sql = "SELECT *FROM products WHERE id='$product' LIMIT 1";
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
	if($customer_id>=0)
		{
		
			global $conn;
			if ($customer_id>0)
				{
					$result=mysqli_query($conn,"SELECT * FROM customer WHERE customer_id='$customer_id' LIMIT 1");
					if (mysqli_num_rows($result)==1)
							{
								$data=mysqli_fetch_array($result);
								switch ($parameter)
									{
										case "name":return $data["name"]; break;
										case "surname":return $data["surname"]; break;
										case "rd":return $data["rd"]; break;
										case "address":return $data["address"]; break;
										case "city":return $data["address_city"]; break;
										case "district":return $data["address_district"]; break;
										case "khoroo":return $data["address_khoroo"]; break;
										case "build":return $data["address_build"]; break;
										case "address_extra":return $data["address_extra"]; break;
										case "tel":return $data["tel"]; break;
										case "last_log":return $data["address"]; break;
										case "email":return $data["email"]; break;
										case "full_name":return $data["surname"]." ".$data["name"];break;
										case "cent":return $data["cent"];break;
										case "no_proxy":return $data["no_proxy"];break;
										case "||": return $data["name"]."||".$data["surname"]."||".$data["tel"]."||".$data["email"]."||".$data["address"];break;
										
									}
							}
							else return "";
				}
			else 
				{
				switch ($parameter)
					{
						case "name":return USA_OFFICE_name; break;
						case "surname": return ""; break;
						case "rd": return ""; break;
						case "address": return USA_OFFICE_address; break;
						case "address_extra": return ""; break;
						case "tel": return  USA_OFFICE_tel; break;
						case "last_log": return ""; break;
						case "email": return ""; break;
						case "full_name": return USA_OFFICE_name;break;
						
						case "||": return USA_OFFICE_name."||".""."||".USA_OFFICE_tel."||".""."||".USA_OFFICE_address;break;
					}
				}
		}
		else return "";
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
				case "placed":return "Шинэ";break;
				case "pending":return "Баталгаажсан";break;
				case "later":return "Хойшлуулсан";break;
				case "onway":return "Хүргэлтэнд";break;
				case "cancel":return "Цуцлагдсан";break;				
				case "delivered":return "ХҮРГЭГДСЭН";break;
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


if (! function_exists ('cfg_price'))
{
	function cfg_price($weight)
	{
		if ($weight>1)return cfg_paymentrate()*$weight;
		elseif ($weight>=0.5) return cfg_paymentrate();
				elseif ($weight==0) return 0;
					else return cfg_paymentrate_min();	}
}

if (! function_exists ('cfg_price2'))
{
	
	function cfg_price2($weight)
	{
	if ($weight>1)return cfg_paymentrate2()*$weight;
	else return cfg_paymentrate2();
	}
}




if (! function_exists ('cfg_rate'))
{
	function cfg_rate()
	{
		global $conn;
		$result=mysqli_query($conn,"SELECT * FROM settings_old WHERE param_name='rate' LIMIT 1");
		$data=mysqli_fetch_array($result);
		return $data["param_value"];
	}

}


if (! function_exists ('barcode_search'))
{
	function barcode_search($barcode,$parameter)
	{
		$barcode = str_replace(" ", "", $barcode);
		global $conn;

		if (substr($barcode,0,2)=='GO')
			{
				$result=mysqli_query($conn,"SELECT * FROM orders WHERE barcode = '$barcode'  LIMIT 1");
				if (mysqli_num_rows($result)==1)
					{
						$data=mysqli_fetch_array($result);
						switch ($parameter) {
							case 'weight':return $data["weight"]; break;
							
							default: return "";	break;
						}
						return $data["order_id"];
					}
					else return "";
			}
			else return "";
	}
}


if (! function_exists ('proxy2'))
{
	function proxy2($proxy_id,$proxy_type,$parameter)
	{
		global $conn;


		if ($proxy_type==0)
		{
			$result = mysqli_query($conn,"SELECT * FROM proxies WHERE proxy_id='$proxy_id' LIMIT 1");
			if (mysqli_num_rows($result)>0)
			{
			$data=mysqli_fetch_array($result);

				switch ($parameter)
				{
					case "name": return $data["name"];break;
					case "surname":return $data["surname"]; break;
					case "address":return $data["address"]; break;
					case "tel":return $data["tel"]; break;
					case "tel2cp":return $data["tel"]." (976)"; break;
					case "full_name":return $data["surname"]." ".$data["name"];break;
				}
			}
			else return "";
		}

		if ($proxy_type==1)
		{
			$result = mysqli_query($conn,"SELECT * FROM proxies_public WHERE proxy_id='$proxy_id' LIMIT 1");
			if (mysqli_num_rows($result)>0)
			{
			$data=mysqli_fetch_array($result);

				switch ($parameter)
				{
					case "name": return $data["name;break"];
					case "surname":return $data["surname"]; break;
					case "address":return $data["address"]; break;
					case "tel":return $data["tel"]; break;
					case "tel2cp":return $data["tel"]." (+976)"; break;
					case "full_name":return $data["surname"]." ".$data["name"];break;
				}
			}
			else return "";
		}
	}
}





if (! function_exists ('barcode_comfort'))
{
	function barcode_comfort($barcode)
	{
		global $conn;

		
		$result_temp=mysqli_query($conn,"SELECT * FROM orders WHERE barcode='$barcode' LIMIT 1");
		if (mysqli_num_rows($result_temp)==1)
		{
			$data_temp=mysqli_fetch_array($result_temp);
			$package = $data_temp["package"];
			$package_array=explode("##",$package);
			$package1_name = @$package_array[0];
			$package1_num = @$package_array[1];
			$package1_value = @$package_array[2];
			$package2_name = @$package_array[3];
			$package2_num = @$package_array[4];
			$package2_value = @$package_array[5];
			$package3_name = @$package_array[6];
			$package3_num = @$package_array[7];
			$package3_value = @$package_array[8];
			$package4_name = @$package_array[9];
			$package4_num = @$package_array[10];
			$package4_value = @$package_array[11];

			$tooltip=$package1_name."[".$package1_num."-".$package1_value."$]";
			if ($package2_name!="")
			$tooltip="\r\n".$package2_name ."[".$package2_num."-".$package2_value."$]";
			if ($package3_name!="")
			$tooltip="\r\n".$package3_name ."[".$package3_num."-".$package3_value."$]";
			if ($package4_name!="")
			$tooltip="\r\n". $package4_name ."[".$package4_num."-".$package4_value."$]";	
			
			return "<span title='".$tooltip."'><b>".$barcode."</b></span>";
		}
		else 
		{
			$result_temp = mysqli_query($conn,"SELECT * FROM box_combine WHERE barcode='$barcode' LIMIT 1");
			if (mysqli_num_rows($result_temp)==1)
			{
				$data_temp=mysqli_fetch_array($result_temp);
				$tooltip = "Нэгтгэсэн хайрцаг дотор нь (".count(explode(",",$data_temp["barcodes"])).") байна ".str_replace(",",", ",$data_temp["barcodes"]);
				return $barcode."<span class='glyphicon glyphicon-question-sign' data-toggle='tooltip' data-placement='top' title='$tooltip'></span>";
			}
			else return "";
		}
	}
}

if (! function_exists ('cfg_paymentrate'))
{
	function cfg_paymentrate()
	{
		global $conn;
		$data = mysqli_fetch_array(mysqli_query($conn,"SELECT * FROM settings WHERE shortname='paymentrate' LIMIT 1"));		
		return $data["value"];	
	}
}


if (! function_exists ('cfg_paymentrate2'))
{
	function cfg_paymentrate2()
	{

		global $conn;
		$data = mysqli_fetch_array(mysqli_query($conn,"SELECT * FROM settings WHERE shortname='paymentrate2' LIMIT 1"));		
		return $data["value"];	
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


if (! function_exists ('days'))
{
	function days($date)
	{
	return (strtotime(date("Y-m-d")) - strtotime(date("Y-m-d",strtotime($date))))/3600/24;	
	}
}


if (! function_exists ('box_inside'))
{
	function box_inside($box_id,$parameter)
	{
		global $conn;

		
		$result=mysqli_query($conn,"SELECT SUM(orders.weight) AS total_weight,COUNT(*) AS packages FROM boxes_packages LEFT JOIN orders ON boxes_packages.order_id=orders.order_id WHERE box_id=$box_id GROUP BY box_id");
		$packages = 0;
		$total_weight = 0;
		if (mysqli_num_rows($result)==1)
		{
			$data= mysqli_fetch_array($result);
			$total_weight = $data["total_weight"];
			$packages=$data["packages"];
		}
		switch($parameter)
		{
		case "weight" :return $total_weight;break;
		case "packages" :return $packages;break;
		default:return "";	
		}
	}
}



if (! function_exists ('cfg_price_branch'))
{
	
	function cfg_price_branch($weight)
	{
	if ($weight>=1) return cfg_paymentrate_branch()*$weight;
	elseif ($weight==0) return 0;
		else return cfg_paymentrate_branch();
	}
}

if (! function_exists ('cfg_price_selfdrop'))
{
	
	function cfg_price_selfdrop($weight)
	{
	if ($weight>1)return settings("paymentrate_selfdrop")*$weight;
	elseif ($weight>=0.5) return settings("paymentrate_selfdrop");
			elseif ($weight==0) return 0;
				else return cfg_paymentrate_min();
	}
}


if (! function_exists ('cfg_price_branch'))
{
	
	function cfg_price_branch($weight)
	{
	if ($weight>=1) return cfg_paymentrate_branch()*$weight;
	elseif ($weight==0) return 0;
		else return cfg_paymentrate_branch();
	}
}

if (! function_exists ('cfg_price_selfdrop'))
{
	
	function cfg_price_selfdrop($weight)
	{
	if ($weight>1)return settings("paymentrate_selfdrop")*$weight;
	elseif ($weight>=0.5) return settings("paymentrate_selfdrop");
			elseif ($weight==0) return 0;
				else return cfg_paymentrate_min();
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



if (! function_exists ('proxy_available'))
{
	function proxy_available($proxy_id,$proxy_type,$status)
	{
	global $conn;
	
	if ($proxy_type ==0)
		mysqli_query($conn,"UPDATE proxies SET status='$status' WHERE proxy_id='$proxy_id'");
		
		if ($proxy_type ==1)
		mysqli_query($conn,"UPDATE proxies_public SET status='$status' WHERE proxy_id='$proxy_id'");
		// $query=mysqli_query($conn,"UPDATE proxies_public SET status=$status WHERE proxy_id=$proxy_id");
	
	//return $row->param_value;	
	}
}



if (! function_exists ('barcode_generate'))
{
	function barcode_generate($text)
	{


		$font = new BCGFontFile('assets/fonts/Arial.ttf', 10);
		$color_black = new BCGColor(0, 0, 0);
		$color_white = new BCGColor(255, 255, 255);


		// Barcode Part
		$code = new BCGcode128();
		$code->setScale(2);
		$code->setThickness(25);
		$code->setForegroundColor($color_black);
		$code->setBackgroundColor($color_white);
		$code->setFont($font);
		$code->setStart(NULL);
		$code->setTilde(true);
		$code->parse($text);
		
		// Drawing Part
		$drawing = new BCGDrawing('assets/img/barcode_temp.jpg', $color_white);
		$drawing->setBarcode($code);
		$drawing->draw();
		//header('Content-Type: image/jpeg');
		$drawing->finish(BCGDrawing::IMG_FORMAT_JPEG);
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

if (! function_exists ('order'))
{
	function order($order_id,$parameter)
	{
		global $conn;

		
		$query=mysqli_query($conn,"SELECT * FROM orders WHERE order_id='$order_id' LIMIT 1");
		if (mysqli_num_rows($query)==1)
		{
			$data=mysqli_fetch_array($query);
				switch ($parameter)
				{
					case "weight":return $data["weight"]; break;
					case "track":return $data["third_party"]; break;
					case "barcode":return $data["barcode"]; break;
					default :return "";
				}	
		}
		else return "";
		}
		

}


if (! function_exists ('tracksearch'))
{
	function tracksearch($track)
	{
		global $conn;

		// Remove date filter to search from entire database
		$track = mysqli_real_escape_string($conn, str_replace(" ", "", $track));

		if (substr($track,0,2)=='22' || substr($track,0,2)=='23' || substr($track,0,2)=='ES')
		{
			$query=mysqli_query($conn,"SELECT * FROM orders WHERE (third_party = '$track' OR extratracks LIKE '%$track%') LIMIT 1");
		}
		else
		{
			$track_eliminated = mysqli_real_escape_string($conn, substr($track,-8,8));
			$query=mysqli_query($conn,"SELECT * FROM orders WHERE (SUBSTRING(third_party,-8,8) = '$track_eliminated' OR extratracks LIKE '%$track%') LIMIT 1");
		}
		
		if (mysqli_num_rows($query)==1)
		{
			$data=mysqli_fetch_array($query);
			return $data["order_id"];
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
			case "new":  return "USА оффис <span class='glyphicon glyphicon-question-sign' data-toggle='tooltip' data-placement='top' title='Монголруу нисэхэд бэлэн болсон.'></span>"; break;
			case "item_missing":  return "Задаргаагүй <span class='glyphicon glyphicon-question-sign' data-toggle='tooltip' data-placement='top' title='Илгээмжийн доторх мэдээллийг оруулаагүй байна. Иймд Монголруу гарах боложгүй. Та Track-aa бүртгүүлж барааны тайлбараа бөглөнө үү'></span>"; break;
			case "warehouse":  return "Ирсэн <span class='glyphicon glyphicon-question-sign' data-toggle='tooltip' data-placement='top' title='Монгол дахь агуулахад ирсэн байна. Та өөрийн биеэр ирж авах боломжтой.'></span>"; break;
			case "onair":  return "Ирж яваа <span class='glyphicon glyphicon-question-sign' data-toggle='tooltip' data-placement='top' title='Америкаас Монголруу гарсан байна.'></span>"; break;
			case "delivered":  return "Авсан <span class='glyphicon glyphicon-question-sign' data-toggle='tooltip' data-placement='top' title='Илгээмжийг хүлээн авсан.'></span>"; break;
			case "filled":  return "Бөглөсөн <span class='glyphicon glyphicon-question-sign' data-toggle='tooltip' data-placement='top' title='Та барааны мэдээллийн бүрэн оруулсан байна. Бид мэдээллийг шалган наашаа гаргахад бэлэн төлөвт оруулах болно.'></span>"; break;
			case "weight_missing":  return "Хүргэгдээгүй <span class='glyphicon glyphicon-question-sign' data-toggle='tooltip' data-placement='top' title='Таны захиалсан бараа манай Америк дахь салбарт хүргэгдээгүй байна. Та Track дугаар дээрээ дарж хаана явааг харах боломжтой.'></span>"; break;
			case "custom":  return "Гааль <span class='glyphicon glyphicon-question-sign' data-toggle='tooltip' data-placement='top' title='Гаальд саатсан байна.'></span>"; break;
			case "online":  return "Онлайн <span class='glyphicon glyphicon-question-sign' data-toggle='tooltip' data-placement='top' title='Онлайн захиалга хэвээр байна. Таны төлбөр хийгдсэн тохиолдолд барааг захиалах боломжтой.'></span>"; break;

			case "order":  return "Илгээмж <span class='glyphicon glyphicon-question-sign' data-toggle='tooltip' data-placement='top' title='Таны онлайн хүсэлтийг төлбөрийн төлөлт хийгдсэн. Та идэвхитэй илгэмжүүд цэснээс хаана явааг харах боломжтой.'></span>"; break;
			//case "proxy":  return "Утасны дугаар <span class='glyphicon glyphicon-education' data-toggle='tooltip' data-placement='top' title='Таны ачааг '></span>"; break;
			case "pending":  return "Pending <span class='glyphicon glyphicon-question-sign' data-toggle='tooltip' data-placement='top' title='Сайтад захиалга хийгдсэн бөгөөд шуудангийн Track дугаар хүлээгдэж байна.'></span>"; break;
			default: return $status; break;
		}
	}
	


}


if (! function_exists ('agent_boxed_order'))
{
	function agent_boxed_order()
	{
		global $conn;

		$query=mysqli_query($conn,"SELECT order_id FROM orders WHERE status='new' AND boxed=0");
		return mysqli_num_rows($query);
	}
}


if (! function_exists ('agent_boxed_combine'))
{
	function agent_boxed_combine()
	{
		global $conn;
		$query=mysqli_query($conn,"SELECT combine_id FROM box_combine WHERE status='new' AND boxed=0");
		return mysqli_num_rows($query);
	}
}



if (! function_exists ('tracksearch_container'))
{
	function tracksearch_container($track)
	{
		global $conn;

		$filter_date = date('Y-m-d', strtotime(date('Y-m-d') . ' -6 month'));
		$track = str_replace(" ", "", $track);

		if (substr($track,0,2)=='22' || substr($track,0,2)=='23' || substr($track,0,2)=='ES')
			$result=mysqli_query($conn,"SELECT * FROM container_item WHERE track = '$track' AND created_date>='$filter_date 00:00:00' LIMIT 1");
		if (substr($track,0,2)!='22' && substr($track,0,2)!='23' && substr($track,0,2)!='ES')
			{
				$track_eliminated = substr($track,-8,8);
				$result=mysqli_query($conn,"SELECT * FROM container_item WHERE SUBSTRING(track,-8,8) = '$track_eliminated' AND created_date>='$filter_date 00:00:00' LIMIT 1");
			}
		if (mysqli_num_rows($result)==1)
		{
			$data = mysqli_fetch_array($result);		
			return $data["id"];
		}
		else return "";
	}
}

if (! function_exists ('count_new_receiver'))
{
	function count_new_receiver($receiver)
	{
		global $conn;

	$init_date = date('Y-m-d', strtotime(date('Y-m-d') . ' -1 month'))." 00:00:00";

	$query_new_count=mysqli_query($conn,"SELECT order_id FROM orders WHERE created_date>='$init_date' AND status='new' AND receiver='$receiver'");
	if (mysqli_num_rows($query_new_count)>1)
	{
	return " <span title='new төлөвт байгаа ачаа ".mysqli_num_rows($query_new_count)."'>(".mysqli_num_rows($query_new_count).") </span>";
	}
	else return "";
	}
}






if (!function_exists("operator_find"))
{
    function operator_find($number)
    {
        if (substr($number,0,2)=='85') return "mobi";
        if (substr($number,0,2)=='94') return "mobi";
        if (substr($number,0,2)=='95') return "mobi";
        if (substr($number,0,2)=='99') return "mobi";

        if (substr($number,0,2)=='80') return "unitel";
        if (substr($number,0,2)=='86') return "unitel";
        if (substr($number,0,2)=='88') return "unitel";
        if (substr($number,0,2)=='89') return "unitel";

        if (substr($number,0,2)=='83') return "gmobile";
        if (substr($number,0,2)=='93') return "gmobile";
        if (substr($number,0,2)=='97') return "gmobile";
        if (substr($number,0,2)=='98') return "gmobile";

        if (substr($number,0,2)=='90') return "skytel";
        if (substr($number,0,2)=='91') return "skytel";
        if (substr($number,0,2)=='92') return "skytel";
        if (substr($number,0,2)=='96') return "skytel";
    }
}





if (!function_exists("smspro"))
{
	function smspro($tel,$sms)
	{
		$key = "40fb195af64bfda277e7431b96515244";
		$from = "72728585";
		$to = $tel;

		$ch = curl_init();
		$url = "https://api.messagepro.mn/send";
		$params = array();
		$params['key']=$key;
		$params['from']=$from;
		$params['to']=$to;
		$params['text']=$sms;
		$url .='?' . http_build_query($params);

		$ch = curl_init();

		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		$response_sms = curl_exec($ch);
		// var_dump($response_sms);
		$result_sms_decode = json_decode($response_sms);
		// if ($result_decode[0]->Result=='SUCCESS') 
		curl_close($ch); 
		return $result_sms_decode[0]->Result;
	}
}



if (!function_exists("alert_div"))
{
	function alert_div($message, $type="danger") 
	{		
		echo '<div class="alert alert-'.$type.'">'.$message.'</div>';
	}
}


if (! function_exists ('cfg_paymentrate_min'))
{
	function cfg_paymentrate_min()
	{
		global $conn;

		$result=mysqli_query($conn,"SELECT * FROM settings WHERE shortname='paymentrate_min' LIMIT 1");
		$data=mysqli_fetch_array($result);
		return $data["value"];	

	}
}


?>