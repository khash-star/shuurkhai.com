<? if (!isset($_POST["online_id"])) redirect('admin/online'); else $online_id=$_POST["online_id"]; ?>
<div class="panel panel-primary">
  <div class="panel-heading">Илгээмж оруулах</div>
  <div class="panel-body">
<? 
		$error=TRUE;
		$query = $this->db->query("SELECT * FROM online WHERE online_id='".$online_id."'");
		if ($query->num_rows() == 1)
		{
		$row=$query->row();
		$online_id=$row->online_id;
		$created_date=$row->created_date;
		$receiver=$row->receiver;
		$url=$row->url;
		$size=$row->size;
		$color=$row->color;
		$number=$row->number;
		$comment=$row->comment;
		$title=$row->title;
		$price=$row->price;
		$status=$row->status;
		$transport=$row->transport;
		$surname = $_POST["surname"];
		$rd = $_POST["rd"];
		$email = $_POST["email"];
		$address = $_POST["address"];
		//$admin_advance = $_POST["admin_advance"];
		if (isset($_POST["admin_advance"])) $admin_value = $_POST["admin_value"]; else  $admin_value=0;
		
		$sql_customer="UPDATE customer SET rd='$rd',surname='$surname',email='$email',address='$address' WHERE customer_id='$receiver' LIMIT 1";
		if (!$this->db->query($sql_customer)) $error=FALSE;

		$sql_customer="SELECT no_proxy FROM customer WHERE customer_id='$receiver' LIMIT 1";
		$query_customer = $this->db->query($sql_customer);
		if ($query->num_rows() == 1)
		{
			$row_customer=$query_customer->row();
			$no_proxy=$row_customer->no_proxy;
		}
		else $no_proxy=0;

		
		$sql_online="UPDATE online SET status='order',proceed_date='".date("Y-m-d H:i:s")."' WHERE online_id=$online_id LIMIT 1";
		if (!$this->db->query($sql_online)) $error=FALSE;
		
		$created_date = date("c");
		/* Package */
		$package1_name=$_POST["package1_name"];
		$package1_num =$_POST["package1_num"];
		$package1_price =intval($_POST["package1_price"]);
		$package2_name=$_POST["package2_name"];
		$package2_num =$_POST["package2_num"];
		$package2_price =intval($_POST["package2_price"]);
		$package3_name=$_POST["package3_name"];
		$package3_num =$_POST["package3_num"];
		$package3_price =intval($_POST["package3_price"]);
		$package4_name=$_POST["package4_name"];
		$package4_num =$_POST["package4_num"];
		$package4_price =intval($_POST["package4_price"]);
		
		$package_array = array(
		$package1_name, $package1_num,$package1_price,
		$package2_name, $package2_num,$package2_price,
		$package3_name, $package3_num,$package3_price,
		$package4_name, $package4_num,$package4_price
		);
		
		$package =implode("##",$package_array);
		$package_price = $package1_price + $package2_price + $package3_price + $package4_price;
		$track = $_POST["track"];
		$track = string_clean($track);
		$track_eliminated = substr($track,-8,8);
		
		$proxy_id=0;
		$proxy_type=0;

		if ($no_proxy==0)
		{
			$query_proxies = $this->db->query('SELECT * FROM proxies WHERE customer_id="'.$receiver.'" AND single=0 AND status=0 ORDER BY proxy_id DESC');
			if ($query_proxies->num_rows()>0)
				{
					foreach($query_proxies->result() as $row_proxy)
					{
						$proxy_id = $row_proxy -> proxy_id;
						$proxy_type = 0;
						break;
						//$order_proxy = $this->db->query('SELECT * FROM orders WHERE receiver="'.$receiver.'" AND proxy_id="'.$proxy_id.'" AND status NOT IN ("delivered","warehouse","custom","onair")');
						
						//if ($order_proxy->num_rows() == 0) 
						//$proxy_available_id= $proxy_id;
					}
				}
			// if ($proxy_id==0)
			// {
			// 	$query_proxies = $this->db->query('SELECT * FROM proxies_public WHERE status=0');
			// 	//$proxy_available_id=0;
			// 	if ($query_proxies->num_rows()>0)
			// 		{
			// 			foreach($query_proxies->result() as $row_proxy)
			// 			{
			// 				$proxy_id = $row_proxy -> proxy_id;
			// 				$proxy_type = 0;
			// 				break;
			// 				//$order_proxy = $this->db->query('SELECT proxy_id FROM orders WHERE status NOT IN ("delivered","warehouse","custom","onair") AND proxy_type=1 AND proxy_id="'.$proxy_each.'"');
							
			// 				//$//combine_proxy = $this->db->query('SELECT proxy_id FROM box_combine WHERE  status NOT IN ("delivered","warehouse","custom","onair") AND proxy_id="'.$proxy_each.'" AND proxy_type=1');
							
			// 				//if ($order_proxy->num_rows() == 0 && $combine_proxy->num_rows()==0) 
			// 				//{ $proxy_available_id= $proxy_each; break;echo $proxy_each;}
			// 			}
			// 		}
			// 	//$proxy_id =$proxy_available_id;
			// 	//$proxy_type=1;
			// }
		}
		

					
					
		/* ADVANCE */
		//$Package_advance = $_POST["Package_advance"];
		/*if (isset($_POST["Package_advance"])) 
			{
			$Package_advance=1;
			$Package_advance_value = round($_POST["Package_advance_value"],2);
			}
			else 
			{
			$Package_advance=0;
			$Package_advance_value="";
			}
		*/
		$barcode='GO'.date("ymd").sprintf("%03d",rand(000,999)).'MN';
do {
  $barcode='GO'.date("ymd").sprintf("%03d",rand(000,999)).'MN';
  $query = $this->db->query("SELECT order_id FROM orders WHERE barcode='$barcode'");
} while ($query->num_rows() == 1); 


		$order_proxy = $this->db->query('SELECT * FROM orders WHERE receiver="'.$receiver.'" AND proxy_id=0 AND status NOT IN ("delivered","warehouse","custom","onair")');
		if ($order_proxy->num_rows() == 0) 
		{
			$proxy_id =0;
			$proxy_type =0;
		}


		$status="weight_missing";
		
		$data = array(
			   'created_date'=>$created_date,
			   'barcode'=>$barcode,
			   'package'=>$package,
			   //'weight'=>$weight,
			   //'price'=>$price,
               //'description'=>$package_description,
			   'sender'=>USA_OFFICE_id,
			   'receiver'=>$receiver,
			   //'insurance'=>$insurance,
			   //'insurance_value'=>$insurance_value,
			   'advance'=>1,
			   //'advance_value'=>$Package_advance_value,
			   'admin_value'=>$admin_value,
			   'third_party'=>$track,
			   'proxy_id' => $proxy_id,
			   'proxy_type' => $proxy_type,
			  // 'way'=>$way,
			   //'deliver_time'=>$deliver_time,
			  // 'inside'=>$Package_inside,
			  // 'return_type'=>$Package_return_type,
			  // 'return_address'=>$Package_return_address,
			  // 'return_day'=>$Package_return_day,
			  //'return_way'=>$Package_return_way,
			   'status'=> $status,
			   'transport'=> $transport,
			   'agents'=> USA_OFFICE_id,
			   'is_online'=> 1,
			   'owner'=> 3,
            );
			if ($error)
			if ($this->db->insert('orders', $data)) 
			{
			$order_id=$this->db->insert_id();	
			$this->db->query("UPDATE online SET status='order',track='$track' WHERE online_id='$online_id' LIMIT 1");
			echo '<div class="alert alert-success" role="alert">Илгээмжийг орууллаа</div>';
			proxy_available($proxy_id,$proxy_type,1);
			}
			else 
			{
			echo '<div class="alert alert-danger" role="alert">Error:'.$this->db->error().'</span>';
			$error=FALSE;
			}
		}
		else echo '<div class="alert alert-danger" role="alert">Илгээмж олдсонгүй</span>';
?>

</div>
</div>
<?=anchor("admin/online","Бүх online захиалгууд",array("class"=>"btn btn-primary"));?>