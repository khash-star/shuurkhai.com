<?
	require_once ('config.php');

	if (!function_exists('protection'))
	{
		function protection($input)
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


if (!function_exists('settings'))
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

if (!function_exists('mslog'))
{
	function mslog($name,$request,$response,$method)
	{
		global $conn;			
		mysqli_query($conn,"INSERT INTO applogs (page,input,output,method) VALUES ('$name','$request','$response','$method')");		
	}
}

// if (!function_exists(parameters))
// {
// 	function parameters($param_name)
// 	{
// 		global $conn;
// 			$sql = "SELECT *FROM parameters WHERE name='$param_name' LIMIT 1";
	
// 		$result = mysqli_query($conn,$sql);
		
// 		if (mysqli_num_rows($result)==1)
// 			{
// 				$data = mysqli_fetch_array($result);
// 				return $data["value"];
// 			}
// 			else
// 				return "";
// 	}
// }


if (!function_exists('gmt'))
	{
		function gmt($gmt,$timestamp)
		{
			return (date('Y-m-d H:i:s',strtotime($gmt, strtotime($timestamp))));
		}
	}


	if (!function_exists("notification"))
	{
		function notification($type,$id)
		{
			switch ($type) {
				case 'order':
					global $conn;
					$from_member=$to_member=0;
					$order_id = $id;
					
					$image = "";
					$text = "Захиалга үүсгэгдэв";
					$link = "orders2?action=detail&id=".$order_id;
					
					$sql_temp = "SELECT customer_id,total_sum FROM orders2 WHERE id='$order_id'";
					$result_temp= mysqli_query($conn,$sql_temp);
					$data_temp = mysqli_fetch_array($result_temp);
					$user_id = $data_temp["customer_id"];
					$price = $data_temp["total_sum"];
					
					$sql_temp = "INSERT INTO notification (image,from_member,to_member,text,link,user_id,price) 
					VALUES ('$image','$from_member','$to_member','$text','$link','$user_id','$price')";
					mysqli_query($conn,$sql_temp);
					break;
				
				default:
					# code...
					break;
			}

		}
	}

	if (!function_exists("isJson"))
	{
		function isJson($string) {
			json_decode($string);
			return (json_last_error() == JSON_ERROR_NONE);
		}
	}

		

	function getAuthorizationHeader()
	{
		$headers = null;
		if (isset($_SERVER['Authorization'])) {
			$headers = trim($_SERVER["Authorization"]);
		}
		else if (isset($_SERVER['HTTP_AUTHORIZATION'])) { //Nginx or fast CGI
			$headers = trim($_SERVER["HTTP_AUTHORIZATION"]);
		} elseif (function_exists('apache_request_headers')) {
			$requestHeaders = apache_request_headers();
			// Server-side fix for bug in old Android versions (a nice side-effect of this fix means we don't care about capitalization for Authorization)
			$requestHeaders = array_combine(array_map('ucwords', array_keys($requestHeaders)), array_values($requestHeaders));
			//print_r($requestHeaders);
			if (isset($requestHeaders['Authorization'])) {
				$headers = trim($requestHeaders['Authorization']);
			}
		}
		return $headers;
	}
	/**
	* get access token from header
	* */
	function getBearerToken() {
		$headers = getAuthorizationHeader();
		// HEADER: Get the access token from the header
		if (!empty($headers)) {
			if (preg_match('/Bearer\s(\S+)/', $headers, $matches)) {
				return $matches[1];
			}
		}
		return null;
	}

	
if (!function_exists("AnyImgSaveCompress2Webp")) 
{
function AnyImgSaveCompress2Webp($saveToPath, $inputPath,$saveToFileName,$InputImageName,$extention, $max_x, $max_y) 
	{
		// preg_match("'^(.*)\.(gif|jpe?g|png|webp)$'i", $InputImageName, $extention);
		// switch (strtolower($ext[2])) {
		switch ($extention) {

			case '.jpg' :
			case '.jpeg': $im   = imagecreatefromjpeg ($inputPath.$InputImageName);
						break;
			case '.gif' : $im   = imagecreatefromgif  ($inputPath.$InputImageName);
						break;
			case '.png' : $im   = imagecreatefrompng  ($inputPath.$InputImageName);
						break;
			case '.webp' : $im   = imagecreatefromwebp  ($inputPath.$InputImageName);
						break;
			default    : $stop = true;
						break;
		}

		if (!isset($stop)) {
			$x = imagesx($im);
			$y = imagesy($im);

			if (($max_x/$max_y) < ($x/$y)) {
				$save = imagecreatetruecolor($x/($x/$max_x), $y/($x/$max_x));
			}
			else {
				$save = imagecreatetruecolor($x/($y/$max_y), $y/($y/$max_y));
			}
			imagecopyresized($save, $im, 0, 0, 0, 0, imagesx($save), imagesy($save), $x, $y);
		
			imagewebp($save, $saveToPath.$saveToFileName);
			// imagejpeg($save, $saveToPath.$saveToFileName);
			imagedestroy($im);	
			imagedestroy($save);
		}
	}
}



if (!function_exists("password_recover"))
{
	function password_recover($email,$checksum ) 
	{
		$to = $email;
		// $to = "alphaemploymentagencynow@gmail.com";
		// $to = "mindsymbol@gmail.com";

		$subject = 'Poppy.mn нууц үг солих';
		$headers = "From: " . strip_tags("info@poppy.mn") . "\r\n";
		$headers .= "Reply-To: ". strip_tags("info@poppy.mn") . "\r\n";
		// $headers .= "CC: tamir926@yahoo.com\r\n";
		$headers .= "MIME-Version: 1.0\r\n";
		$headers .= "Content-Type: text/html; charset=UTF-8\r\n";

		$message = '<html><body>';
		$message .= '<img src="//https://poppy.mn/landing/images/favicon.png" alt="poppy.mn" />';
		$message .= '<p>Poppy.mn-д нэвтрэх нууц үг ахин тохируулах</p>';

		$message .= '<a href="https://poppy.mn/recover?checksum='.$checksum.'">Нууц үг солих</a>';

		$message .= "</body></html>";

		return mail($to, $subject, $message, $headers);
	}
}


if (!function_exists("weekdaymn"))
{
	function weekdaymn($weekday)
	{
		switch ($weekday)
		{
			case (0): return "Ням";break;
			case (1): return "Даваа";break;
			case (2): return "Мягмар";break;
			case (3): return "Лхагва";break;
			case (4): return "Пүрэв";break;
			case (5): return "Баасан";break;
			case (6): return "Бямба";break;
			default: return "";
		}
	}
}



if (!function_exists("address"))
{
	function address($customer_id)
	{
		global $conn;
		$sql = "SELECT city.name city_name, district.name district_name,customer.address_khoroo khoroo,address_build build,address_extra extra FROM customer 
		LEFT JOIN city ON customer.address_city = city.id
		LEFT JOIN district ON customer.address_district = district.id
		WHERE customer.customer_id='$customer_id' LIMIT 1";
		$result = mysqli_query($conn,$sql);
		$data = mysqli_fetch_array($result);

		return $data["city_name"]." ".$data["district_name"]." ".$data["khoroo"]." ".$data["build"]." ".$data["extra"];
	}
}

if (!function_exists("address_deliver"))
{
	function address_deliver($address)
	{
		global $conn;
		$sql = "SELECT customer_address.*,city.name city_name, district.name district_name FROM customer_address 
		LEFT JOIN city ON customer_address.city=city.id
		LEFT JOIN district ON customer_address.district=district.id
		WHERE customer_address.id='$address' ORDER BY timestamp DESC";
		$result_temp = mysqli_query($conn,$sql);
		$data_temp = mysqli_fetch_array($result_temp);

		return $data_temp["city_name"]." ".$data_temp["district_name"]." ".$data_temp["khoroo"]." ".$data_temp["build"]." ".$data_temp["extra"];
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



if (!function_exists('appsettings'))
{
	function appsettings($shortname)
	{
		global $conn;
		
		$sql = "SELECT *FROM appsettings WHERE shortname='$shortname' LIMIT 1";

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



?>