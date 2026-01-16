<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$CI =& get_instance();


if (! function_exists ('string_clean'))
{
	function string_clean($string)
	{

 	 	$string = str_replace(' ', '', $string); // Replaces all spaces with hyphens.

   		return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
	}
}


if (! function_exists ('cfg_param'))
{
	function cfg_param($name)
	{
		$ci=& get_instance();		
		$ci->load->database();
		$query=$ci->db->query("SELECT * FROM settings_old WHERE param_name='$name' LIMIT 1");
		$row=$query ->row();
		return $row->param_value;
	}

}

if (! function_exists ('settings_new'))
{
	function settings_new($name)
	{
		$ci=& get_instance();		
		$ci->load->database();
		$query=$ci->db->query("SELECT * FROM settings WHERE shortname='$name' LIMIT 1");
		$row=$query ->row();
		return $row->value;
	}

}

if (! function_exists ('proxy_available'))
{
	function proxy_available($proxy_id,$proxy_type,$status)
	{
	$ci=& get_instance();		
	$ci->load->database();
	if ($proxy_type ==0)
		$query=$ci->db->query("UPDATE proxies SET status=$status WHERE proxy_id=$proxy_id");
	
	if ($proxy_type ==1)
		$query=$ci->db->query("UPDATE proxies_public SET status=$status WHERE proxy_id=$proxy_id");
	
	//return $row->param_value;	
	}
}



if (! function_exists ('container_outside'))
{
	function container_outside()
	{
	$ci=& get_instance();		
	$ci->load->database();
	$query=$ci->db->query("SELECT id FROM container_item WHERE container='0'");
	return $query ->num_rows();
	//return $row->param_value;	
	}
}


if (! function_exists ('tracksearch'))
{
	function tracksearch($track)
	{
		$filter_date = date('Y-m-d', strtotime(date('Y-m-d') . ' -2 month'));

		$track = str_replace(" ", "", $track);
		$ci=& get_instance();		
		if (substr($track,0,2)=='22' || substr($track,0,2)=='23' || substr($track,0,2)=='ES')
			$query=$ci->db->query("SELECT * FROM orders WHERE third_party = '$track' AND created_date>='$filter_date 00:00:00' LIMIT 1");
		if (substr($track,0,2)!='22' && substr($track,0,2)!='23' && substr($track,0,2)!='ES')
			{
				$track_eliminated = substr($track,-8,8);
				$ci=& get_instance();		
				$ci->load->database();
				$query=$ci->db->query("SELECT * FROM orders WHERE SUBSTRING(third_party,-8,8) = '$track_eliminated' AND created_date>='$filter_date 00:00:00' LIMIT 1");
			}
		if ($query->num_rows()==1)
		{
		$row=$query ->row();
		return $row->order_id;
		}
		else return "";
	}
}

if (! function_exists ('tracksearch_container'))
{
	function tracksearch_container($track)
	{
		$filter_date = date('Y-m-d', strtotime(date('Y-m-d') . ' -6 month'));

		$track = str_replace(" ", "", $track);
		$ci=& get_instance();		
		if (substr($track,0,2)=='22' || substr($track,0,2)=='23' || substr($track,0,2)=='ES')
			$query=$ci->db->query("SELECT * FROM container_item WHERE track = '$track' AND created_date>='$filter_date 00:00:00' LIMIT 1");
		if (substr($track,0,2)!='22' && substr($track,0,2)!='23' && substr($track,0,2)!='ES')
			{
				$track_eliminated = substr($track,-8,8);
				$ci=& get_instance();		
				$ci->load->database();
				$query=$ci->db->query("SELECT * FROM container_item WHERE SUBSTRING(track,-8,8) = '$track_eliminated' AND created_date>='$filter_date 00:00:00' LIMIT 1");
			}
		if ($query->num_rows()==1)
		{
		$row=$query ->row();
		return $row->id;
		}
		else return "";
	}
}


if (! function_exists ('barcode_search'))
{
	function barcode_search($barcode,$parameter)
	{
		$barcode = str_replace(" ", "", $barcode);
		$ci=& get_instance();		
		if (substr($barcode,0,2)=='GO')
			{
				$query=$ci->db->query("SELECT * FROM orders WHERE barcode = '$barcode'  LIMIT 1");
				if ($query->num_rows()==1)
					{
						$row=$query ->row();
						switch ($parameter) {
							case 'weight':return $row->weight; break;
							
							default: return "";	break;
						}
						return $row->order_id;
					}
					else return "";
			}
			else return "";
	}
}


if (! function_exists ('containersearch'))
{
	function containersearch($track)
	{
		$filter_date = date('Y-m-d', strtotime(date('Y-m-d') . ' -2 month'));
		$track = str_replace(" ", "", $track);
		$track_eliminated = substr($track,-8,8);
		$ci=& get_instance();		
		$ci->load->database();
		$query=$ci->db->query("SELECT * FROM container_item WHERE  SUBSTRING(track,-8,8) = '$track_eliminated' AND created_date>='$filter_date 00:00:00'  LIMIT 1");
		if ($query->num_rows()==1)
		{
		$row=$query ->row();
		return $row->id;
		}
		else return "";
	}
}



if (! function_exists ('online'))
{
	function online($online_id,$parameter)
	{
	$ci=& get_instance();		
	$ci->load->database();
	$query=$ci->db->query("SELECT * FROM online WHERE online_id='$online_id' LIMIT 1");
	if ($query->num_rows()==1)
	{
	$row=$query ->row();
		switch ($parameter)
		{
			case "url":return $row->url; break;
			case "track":return $row->track; break;
			case "title":if ($row->title=="") return $row->url;  else return $row->title; break;
			case "price":return $row->price; break;
			case "tax":return $row->tax; break;
			case "shipping":return $row->shipping; break;
			default :return "";
		}	
	}
	else return "";
	}
	

}



if (! function_exists ('track2order'))
{
	function track2order($track,$parameter)
	{
		$ci=& get_instance();		
		$ci->load->database();
		$query=$ci->db->query("SELECT * FROM orders WHERE third_party='$track' LIMIT 1");
		if ($query->num_rows()==1)
		{
		$row=$query ->row();
		switch ($parameter)
		{
			case "order_id":return $row->order_id; break;
			case "track":return $row->third_party; break;
			case "barcode":return $row->barcode; break;
			default: return $track; break;
		}	
		}
		else return "";
	}
}





/*CFG FUNCTIONS*/
if (! function_exists ('cfg_rate'))
{
	function cfg_rate()
	{
		$ci=& get_instance();		
		$ci->load->database();
		$query=$ci->db->query("SELECT * FROM settings_old WHERE param_name='rate' LIMIT 1");
		$row=$query ->row();
		return $row->param_value;
	}

}


if (! function_exists ('agent_boxed_order'))
{
	function agent_boxed_order()
	{
	$ci=& get_instance();		
	$ci->load->database();
	$query=$ci->db->query("SELECT order_id FROM orders WHERE status='new' AND boxed=0");
	return $query ->num_rows();
	//return $row->param_value;	
	}
}


if (! function_exists ('agent_boxed_combine'))
{
	function agent_boxed_combine()
	{
	$ci=& get_instance();		
	$ci->load->database();
	$query=$ci->db->query("SELECT combine_id FROM box_combine WHERE status='new' AND boxed=0");
	return $query ->num_rows();
	//return $row->param_value;	
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
	if ($weight>1)return settings_new("paymentrate_selfdrop")*$weight;
	elseif ($weight>=0.5) return settings_new("paymentrate_selfdrop");
			elseif ($weight==0) return 0;
				else return cfg_paymentrate_min();
	}
}

if (! function_exists ('cfg_price2'))
{
	
	function cfg_price2($weight)
	{
	if ($weight>1)return cfg_paymentrate2()*$weight;
	else return cfg_paymentrate2();
	}
}



if (! function_exists ('cfg_order_price'))
{
	
	function cfg_order_price($weight)
	{
		if ($weight>1)
		return cfg_paymentrate()*$weight;
		if ($weight<=1)
		return cfg_paymentrate();
	}
}


if (! function_exists ('cfg_paymentrate'))
{
	function cfg_paymentrate()
	{
	$ci=& get_instance();		
	$ci->load->database();
	$query=$ci->db->query("SELECT * FROM settings WHERE shortname='paymentrate' LIMIT 1");
	$row=$query ->row();
	return $row->value;	
	}
}

if (! function_exists ('cfg_paymentrate_branch'))
{
	function cfg_paymentrate_branch()
	{
	$ci=& get_instance();		
	$ci->load->database();
	$query=$ci->db->query("SELECT * FROM settings WHERE shortname='paymentrate_branch' LIMIT 1");
	$row=$query ->row();
	return $row->value;	
	}
}


if (! function_exists ('cfg_paymentrate2'))
{
	function cfg_paymentrate2()
	{
		$ci=& get_instance();		
		$ci->load->database();
		$query=$ci->db->query("SELECT * FROM settings_old WHERE param_name='paymentrate2' LIMIT 1");
		$row=$query ->row();
		return $row->param_value;	
	}
}


if (! function_exists ('cfg_deletepass'))
{
	function cfg_deletepass()
	{
	$ci=& get_instance();		
	$ci->load->database();
	$query=$ci->db->query("SELECT * FROM settings_old WHERE param_name='delete_pass' LIMIT 1");
	$row=$query ->row();
	return $row->param_value;	
	}
}




if (! function_exists ('cfg_paymentrate_min'))
{
	function cfg_paymentrate_min()
	{
	$ci=& get_instance();		
	$ci->load->database();
	$query=$ci->db->query("SELECT * FROM settings WHERE shortname='paymentrate_min' LIMIT 1");
	$row=$query ->row();
	return $row->value;	
	}
}


if (! function_exists ('log_write'))
{
	function log_write($log,$type)
	{
		
		$ci=& get_instance();		
		$ci->load->database();
		$log = $ci->db->escape($log);
		if($ci->db->query("INSERT INTO logs (name,ip,logs,type) VALUES ('".$ci->session->userdata('logged_name')."','".$_SERVER['REMOTE_ADDR']."',".$log.",'$type')"))
		  return TRUE; else return FALSE;
	}

}

if (! function_exists ('cfg_smsgateway'))
{
	function cfg_smsgateway()
	{
		  $cfg_query=mysql_fetch_array(mysql_query("SELECT * FROM settings WHERE shortname='gateway' LIMIT 1"));
		  return $cfg_query["value"];
	}

}


if (! function_exists ('number2words'))
{
	function number2words($number)
	{
		  
	$hyphen      = '-';
    $conjunction = ' and ';
    $separator   = ', ';
    $negative    = 'negative ';
    $decimal     = ' point ';
    $dictionary  = array(
        0                   => 'zero',
        1                   => 'one',
        2                   => 'two',
        3                   => 'three',
        4                   => 'four',
        5                   => 'five',
        6                   => 'six',
        7                   => 'seven',
        8                   => 'eight',
        9                   => 'nine',
        10                  => 'ten',
        11                  => 'eleven',
        12                  => 'twelve',
        13                  => 'thirteen',
        14                  => 'fourteen',
        15                  => 'fifteen',
        16                  => 'sixteen',
        17                  => 'seventeen',
        18                  => 'eighteen',
        19                  => 'nineteen',
        20                  => 'twenty',
        30                  => 'thirty',
        40                  => 'fourty',
        50                  => 'fifty',
        60                  => 'sixty',
        70                  => 'seventy',
        80                  => 'eighty',
        90                  => 'ninety',
        100                 => 'hundred',
        1000                => 'thousand',
        1000000             => 'million',
        1000000000          => 'billion',
        1000000000000       => 'trillion',
        1000000000000000    => 'quadrillion',
        1000000000000000000 => 'quintillion'
    );
   
    if (!is_numeric($number)) {
        return false;
    }
   
    if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
        // overflow
        trigger_error(
            'convert_number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX,
            E_USER_WARNING
        );
        return false;
    }

    if ($number < 0) {
        return $negative . convert_number_to_words(abs($number));
    }
   
    $string = $fraction = null;
   
    if (strpos($number, '.') !== false) {
        list($number, $fraction) = explode('.', $number);
    }
   
    switch (true) {
        case $number < 21:
            $string = $dictionary[$number];
            break;
        case $number < 100:
            $tens   = ((int) ($number / 10)) * 10;
            $units  = $number % 10;
            $string = $dictionary[$tens];
            if ($units) {
                $string .= $hyphen . $dictionary[$units];
            }
            break;
        case $number < 1000:
            $hundreds  = $number / 100;
            $remainder = $number % 100;
            $string = $dictionary[$hundreds] . ' ' . $dictionary[100];
            if ($remainder) {
                $string .= $conjunction . convert_number_to_words($remainder);
            }
            break;
        default:
            $baseUnit = pow(1000, floor(log($number, 1000)));
            $numBaseUnits = (int) ($number / $baseUnit);
            $remainder = $number % $baseUnit;
            $string = convert_number_to_words($numBaseUnits) . ' ' . $dictionary[$baseUnit];
            if ($remainder) {
                $string .= $remainder < 100 ? $conjunction : $separator;
                $string .= convert_number_to_words($remainder);
            }
            break;
    }
   
    if (null !== $fraction && is_numeric($fraction)) {
        $string .= $decimal;
        $words = array();
        foreach (str_split((string) $fraction) as $number) {
            $words[] = $dictionary[$number];
        }
        $string .= implode(' ', $words);
    }
   
    return $string;
	}

}
if (! function_exists ('tel2id'))
{
	function tel2id($tel)
	{
	$ci=& get_instance();		
	$ci->load->database();
	$query=$ci->db->query("SELECT * FROM customer WHERE tel='$tel' LIMIT 1");
	$row=$query ->row();
	return $row->customer_id;
	}
}

if (! function_exists ('customer'))
{
	function customer($customer_id,$parameter)
	{
	if($customer_id>=0)
		{
		if ($customer_id==USA_OFFICE_id) $admin=TRUE; else $admin=FALSE; 
  		//if ($admin) return "Admin"; else return "Not Admin";
		if (!$admin)
			{
			$ci=& get_instance();		
			$ci->load->database();
			$query=$ci->db->query("SELECT * FROM customer WHERE customer_id='$customer_id' LIMIT 1");
			if ($query->num_rows()==1)
					{
					$row=$query ->row();
					switch ($parameter)
						{
							case "name":return $row->name; break;
							case "surname":return $row->surname; break;
							case "rd":return $row->rd; break;
							case "address":return $row->address; break;
							case "city":return $row->address_city; break;
							case "district":return $row->address_district; break;
							case "khoroo":return $row->address_khoroo; break;
							case "build":return $row->address_build; break;
							case "address_extra":return $row->address_extra; break;
							case "tel":return $row->tel; break;
							case "last_log":return $row->address; break;
							case "email":return $row->email; break;
							case "full_name":return $row->surname." ".$row->name;break;
							case "cent":return $row->cent;break;
							case "no_proxy":return $row->no_proxy;break;
							case "||": return $row->name."||".$row->surname."||".$row->tel."||".$row->email."||".$row->address;break;
							
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
						case "no_proxy":return $row->no_proxy;break;
						case "||": return USA_OFFICE_name."||".""."||".USA_OFFICE_tel."||".""."||".USA_OFFICE_address;break;
					}
				}
		}
		else return "";
	}

}


/*if (! function_exists ('proxy'))
{
	function proxy($proxy_id,$parameter)
	{
	
	$ci=& get_instance();		
	$ci->load->database();
	$query=$ci->db->query("SELECT * FROM proxies WHERE proxy_id='$proxy_id' LIMIT 1");
	if ($query->num_rows()>0)
	{
	$row=$query ->row();

		switch ($parameter)
		{
			case "name": return $row->name;break;
			case "surname":return $row->surname; break;
			case "address":return $row->address; break;
			case "tel":return $row->tel; break;
			case "full_name":return $row->surname." ".$row->name;break;
		}
	}
	else return "";
	}
	

}*/
if (! function_exists ('proxy2'))
{
	function proxy2($proxy_id,$proxy_type,$parameter)
	{
		if ($proxy_type==0)
		{
			$ci=& get_instance();		
			$ci->load->database();
			$query=$ci->db->query("SELECT * FROM proxies WHERE proxy_id='$proxy_id' LIMIT 1");
			if ($query->num_rows()>0)
			{
			$row=$query ->row();

				switch ($parameter)
				{
					case "name": return $row->name;break;
					case "surname":return $row->surname; break;
					case "address":return $row->address; break;
					case "tel":return $row->tel; break;
					case "tel2cp":return $row->tel." (976)"; break;
					case "full_name":return $row->surname." ".$row->name;break;
				}
			}
			else return "";
		}

		if ($proxy_type==1)
		{
			$ci=& get_instance();		
			$ci->load->database();
			$query=$ci->db->query("SELECT * FROM proxies_public WHERE proxy_id='$proxy_id' LIMIT 1");
			if ($query->num_rows()>0)
			{
			$row=$query ->row();

				switch ($parameter)
				{
					case "name": return $row->name;break;
					case "surname":return $row->surname; break;
					case "address":return $row->address; break;
					case "tel":return $row->tel; break;
					case "tel2cp":return $row->tel." (+976)"; break;
					case "full_name":return $row->surname." ".$row->name;break;
				}
			}
			else return "";
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





if (! function_exists ('days'))
{
	function days($date)
	{
	return (strtotime(date("Y-m-d")) - strtotime(date("Y-m-d",strtotime($date))))/3600/24;	
	}
}


if (! function_exists ('order'))
{
	function order($order_id,$parameter)
	{
	$ci=& get_instance();		
	$ci->load->database();
	$query=$ci->db->query("SELECT * FROM orders WHERE order_id='$order_id' LIMIT 1");
	if ($query->num_rows()==1)
	{
	$row=$query ->row();
		switch ($parameter)
		{
			case "weight":return $row->weight; break;
			case "track":return $row->third_party; break;
			case "barcode":return $row->barcode; break;
			default :return "";
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



if (! function_exists ('count_new_receiver'))
{
	function count_new_receiver($receiver)
	{
	$init_date = date('Y-m-d', strtotime(date('Y-m-d') . ' -1 month'))." 00:00:00";
	$ci=& get_instance();		
	$ci->load->database();
	$query_new_count=$ci->db->query("SELECT order_id FROM orders WHERE created_date>='$init_date' AND status='new' AND receiver='$receiver'");
	if ($query_new_count->num_rows()>1)
	{
	return " <span title='new төлөвт байгаа ачаа ".$query_new_count->num_rows."'>(".$query_new_count->num_rows.") </span>";
	}
	else return "";
	}
}







if (! function_exists ('box_inside'))
{
	function box_inside($box_id,$parameter)
	{
	$ci=& get_instance();		
	$ci->load->database();
	$query=$ci->db->query("SELECT SUM(orders.weight) AS total_weight,COUNT(*) AS packages FROM boxes_packages LEFT JOIN orders ON boxes_packages.order_id=orders.order_id WHERE box_id=$box_id GROUP BY box_id");
	$packages = 0;
	$total_weight = 0;
	if ($query->num_rows()==1)
	{
	$row = $query->row();
	$total_weight = $row->total_weight;
	$packages=$row->packages;
	}
	switch($parameter)
	{
	case "weight" :return $total_weight;break;
	case "packages" :return $packages;break;
	default:return "";	
	}
	}
}



if (! function_exists ('barcode_comfort'))
{
	function barcode_comfort($barcode)
	{
	$ci=& get_instance();		
	$ci->load->database();
	$query=$ci->db->query("SELECT * FROM orders WHERE barcode='$barcode' LIMIT 1");
	if ($query ->num_rows()==1)
	{
	$row=$query ->row();
	$package = $row->package;
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
	$query=$ci->db->query("SELECT * FROM box_combine WHERE barcode='$barcode' LIMIT 1");
	if ($query ->num_rows()==1)
	{
		$row=$query ->row();
		$tooltip = "Нэгтгэсэн хайрцаг дотор нь (".count(explode(",",$row->barcodes)).") байна ".str_replace(",",", ",$row->barcodes);
		return $barcode."<span class='glyphicon glyphicon-question-sign' data-toggle='tooltip' data-placement='top' title='$tooltip'></span>";
	}
	else return "";
	}
	}
}



?>