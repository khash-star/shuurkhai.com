<?php

if (! function_exists ('string_clean'))
{
	function string_clean($string)
	{

 	 	$string = str_replace(' ', '', $string); // Replaces all spaces with hyphens.

   		return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
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
			// SQL Injection-ээс хамгаалах - Prepared Statements
			$customer_id_int = intval($customer_id);
			$stmt = mysqli_prepare($conn, "SELECT * FROM customer WHERE customer_id = ? LIMIT 1");
			if ($stmt) {
				mysqli_stmt_bind_param($stmt, "i", $customer_id_int);
				mysqli_stmt_execute($stmt);
				$result_helper = mysqli_stmt_get_result($stmt);
				mysqli_stmt_close($stmt);
			} else {
				// Fallback
				$customer_id_escaped = mysqli_real_escape_string($conn, $customer_id);
				$sql_helper = "SELECT * FROM customer WHERE customer_id='$customer_id_escaped' LIMIT 1";
				$result_helper = mysqli_query($conn,$sql_helper);
			}
			if ($result_helper && mysqli_num_rows($result_helper)==1)
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


if (! function_exists ('tracksearch'))
{
	function tracksearch($track)
	{
		$filter_date = date('Y-m-d', strtotime(date('Y-m-d') . ' -2 month'));

		$track = str_replace(" ", "", $track);
		global $conn;
		
		// SQL Injection-ээс хамгаалах - Prepared Statements ашиглах
		$filter_date_escaped = mysqli_real_escape_string($conn, $filter_date);
		
		if (substr($track,0,2)=='22' || substr($track,0,2)=='ES')
		{
			$track_escaped = mysqli_real_escape_string($conn, $track);
			$stmt = mysqli_prepare($conn, "SELECT * FROM orders WHERE third_party = ? AND created_date >= ? LIMIT 1");
			if ($stmt) {
				mysqli_stmt_bind_param($stmt, "ss", $track_escaped, $filter_date_escaped);
				mysqli_stmt_execute($stmt);
				$query = mysqli_stmt_get_result($stmt);
				mysqli_stmt_close($stmt);
			} else {
				// Fallback to escaped query if prepared statement fails
				$query = mysqli_query($conn, "SELECT * FROM orders WHERE third_party = '$track_escaped' AND created_date>='$filter_date_escaped 00:00:00' LIMIT 1");
			}
		}
		if (substr($track,0,2)!='22' && substr($track,0,2)!='ES')
		{
			$track_eliminated = substr($track,-8,8);
			$track_eliminated_escaped = mysqli_real_escape_string($conn, $track_eliminated);
			$stmt = mysqli_prepare($conn, "SELECT * FROM orders WHERE SUBSTRING(third_party,-8,8) = ? AND created_date >= ? LIMIT 1");
			if ($stmt) {
				mysqli_stmt_bind_param($stmt, "ss", $track_eliminated_escaped, $filter_date_escaped);
				mysqli_stmt_execute($stmt);
				$query = mysqli_stmt_get_result($stmt);
				mysqli_stmt_close($stmt);
			} else {
				// Fallback to escaped query if prepared statement fails
				$query = mysqli_query($conn, "SELECT * FROM orders WHERE SUBSTRING(third_party,-8,8) = '$track_eliminated_escaped' AND created_date>='$filter_date_escaped 00:00:00' LIMIT 1");
			}
		}
		if ($query && mysqli_num_rows($query)==1)
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
		
		// SQL Injection-ээс хамгаалах - Prepared Statements
		$filter_date_escaped = mysqli_real_escape_string($conn, $filter_date);
		
		if (substr($track,0,2)=='22' || substr($track,0,2)=='ES')
		{
			$track_escaped = mysqli_real_escape_string($conn, $track);
			$stmt = mysqli_prepare($conn, "SELECT * FROM container_item WHERE track = ? AND created_date >= ? LIMIT 1");
			if ($stmt) {
				mysqli_stmt_bind_param($stmt, "ss", $track_escaped, $filter_date_escaped);
				mysqli_stmt_execute($stmt);
				$query = mysqli_stmt_get_result($stmt);
				mysqli_stmt_close($stmt);
			} else {
				// Fallback
				$query = mysqli_query($conn, "SELECT * FROM container_item WHERE track = '$track_escaped' AND created_date>='$filter_date_escaped 00:00:00' LIMIT 1");
			}
		}
		if (substr($track,0,2)!='22' && substr($track,0,2)!='ES')
		{
			$track_eliminated = substr($track,-8,8);
			$track_eliminated_escaped = mysqli_real_escape_string($conn, $track_eliminated);
			$stmt = mysqli_prepare($conn, "SELECT * FROM container_item WHERE SUBSTRING(track,-8,8) = ? AND created_date >= ? LIMIT 1");
			if ($stmt) {
				mysqli_stmt_bind_param($stmt, "ss", $track_eliminated_escaped, $filter_date_escaped);
				mysqli_stmt_execute($stmt);
				$query = mysqli_stmt_get_result($stmt);
				mysqli_stmt_close($stmt);
			} else {
				// Fallback
				$query = mysqli_query($conn, "SELECT * FROM container_item WHERE SUBSTRING(track,-8,8) = '$track_eliminated_escaped' AND created_date>='$filter_date_escaped 00:00:00' LIMIT 1");
			}
		}
		if ($query && mysqli_num_rows($query)==1)
		{
			$row=mysqli_fetch_array($query);
			return $row["id"];
		}
		else return "";
	}
}


if (!function_exists("protect"))
{
	/**
	 * Protect function - хуучин функц (backward compatibility)
	 * Шинэ код дээр sanitize_input() ашиглах зөвлөмжлөгдөнө
	 */
	function protect($input)
	{
		// Хуучин функц хадгалж байна (backward compatibility)
		// Гэхдээ илүү сайн sanitization хийх
		if (is_array($input)) {
			return array_map('protect', $input);
		}
		
		// HTML tags устгах
		$input = strip_tags($input);
		
		// SQL injection-ээс хамгаалах (гэхдээ prepared statements ашиглах нь илүү сайн)
		$input = str_replace("'", "", $input);
		$input = str_replace('"', '', $input);
		$input = str_replace(";", "", $input);
		$input = str_replace("--", "", $input);
		
		// XSS-ээс хамгаалах
		$input = str_replace("<", "", $input);
		$input = str_replace(">", "", $input);
		$input = str_replace("script", "", $input);
		
		return trim($input);
	}
}


if (!function_exists("settings"))
{
	function settings($id_or_shortname)
	{
		global $conn;
		
		// SQL Injection-ээс хамгаалах - Prepared Statements
		if (is_int($id_or_shortname))
		{
			$id_int = intval($id_or_shortname);
			$stmt = mysqli_prepare($conn, "SELECT * FROM settings WHERE id = ? LIMIT 1");
			if ($stmt) {
				mysqli_stmt_bind_param($stmt, "i", $id_int);
				mysqli_stmt_execute($stmt);
				$result = mysqli_stmt_get_result($stmt);
				mysqli_stmt_close($stmt);
			} else {
				// Fallback
				$id_escaped = mysqli_real_escape_string($conn, $id_or_shortname);
				$sql = "SELECT * FROM settings WHERE id='$id_escaped' LIMIT 1";
				$result = mysqli_query($conn,$sql);
			}
		}
		else 
		{
			$shortname_escaped = mysqli_real_escape_string($conn, $id_or_shortname);
			$stmt = mysqli_prepare($conn, "SELECT * FROM settings WHERE shortname = ? LIMIT 1");
			if ($stmt) {
				mysqli_stmt_bind_param($stmt, "s", $shortname_escaped);
				mysqli_stmt_execute($stmt);
				$result = mysqli_stmt_get_result($stmt);
				mysqli_stmt_close($stmt);
			} else {
				// Fallback
				$sql = "SELECT * FROM settings WHERE shortname='$shortname_escaped' LIMIT 1";
				$result = mysqli_query($conn,$sql);
			}
		}
		
		if ($result && mysqli_num_rows($result)==1)
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
		
		// SQL Injection-ээс хамгаалах - Prepared Statements
		$name_escaped = mysqli_real_escape_string($conn, $name);
		$request_escaped = mysqli_real_escape_string($conn, $request);
		$response_escaped = mysqli_real_escape_string($conn, $response);
		$method_escaped = mysqli_real_escape_string($conn, $method);
		
		$stmt = mysqli_prepare($conn, "INSERT INTO applogs (page,input,output,method) VALUES (?, ?, ?, ?)");
		if ($stmt) {
			mysqli_stmt_bind_param($stmt, "ssss", $name_escaped, $request_escaped, $response_escaped, $method_escaped);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_close($stmt);
		} else {
			// Fallback
			mysqli_query($conn, "INSERT INTO applogs (page,input,output,method) VALUES ('$name_escaped','$request_escaped','$response_escaped','$method_escaped')");
		}
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

// Fix image paths for base href
if (!function_exists('fix_image_path'))
{
	function fix_image_path($path)
	{
		if (empty($path)) {
			return '';
		}
		
		// Trim whitespace
		$path = trim($path);
		
		// If path is already a full URL, return as is
		if (preg_match('/^https?:\/\//', $path)) {
			return $path;
		}
		
		// Remove leading slash if present (base tag will handle it)
		$path = ltrim($path, '/');
		
		// If path starts with shuurkhai/, remove it
		if (substr($path, 0, 10) === 'shuurkhai/') {
			$path = substr($path, 10);
		}
		
		// Check if uploads file exists, if not return empty to avoid 404 errors
		// This prevents 404 errors for missing images
		if (strpos($path, 'uploads/') === 0) {
			$file_path = dirname(__DIR__) . DIRECTORY_SEPARATOR . $path;
			if (!file_exists($file_path)) {
				// Return empty string to avoid broken image tags
				// Database might have paths to files that don't exist
				return '';
			}
		}
		
		// Return cleaned path (base tag will add /shuurkhai/ prefix)
		return $path;
	}
}


?>
