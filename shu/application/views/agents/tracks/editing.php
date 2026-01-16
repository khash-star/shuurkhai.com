<? if ($_POST["order_id"]=="") redirect('agents/tracks'); else $order_id=$_POST["order_id"]?>


<div class="panel panel-primary">
  	<div class="panel-heading">Трак засах</div>
  	<div class="panel-body">
	<? 
	if ($order_id!="")
	{
		$query = $this->db->query("SELECT * FROM orders WHERE order_id='$order_id'");
		$row = $query->row();
		$status = $row->status;
		$receiver_id = $row->receiver;
		$current_proxy =$row->proxy_id;

		if ($status=="item_missing")
		{
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
			$package2_name, $package2_num, $package2_price,
			$package3_name, $package3_num,$package3_price,
			$package4_name, $package4_num, $package4_price
			);
		
			$package =implode("##",$package_array);
			$package_price = $package1_price + $package2_price + $package3_price + $package4_price;

			$proxy_id =0;
			$proxy_type=0;

			$sql_customer="SELECT no_proxy FROM customer WHERE customer_id='$receiver_id' LIMIT 1";
			$query_customer = $this->db->query($sql_customer);
			if ($query->num_rows() == 1)
			{
				$row_customer=$query_customer->row();
				$no_proxy=$row_customer->no_proxy;
			}
			else $no_proxy=0;

			if ($no_proxy==0)
			{
				if ($current_proxy==0)
					{
						
							$query_proxies = $this->db->query('SELECT * FROM proxies WHERE customer_id="'.$receiver_id.'" AND status=0 ORDER BY proxy_id DESC');
							$proxy_available_id=0;
							if ($query_proxies->num_rows()>1)
							{

								foreach($query_proxies->result() as $row_proxy)
								{
									$proxy_id = $row_proxy->proxy_id;
									$proxy_type=0;	
									break;
								}
							}
							
							if (isset($_POST["proxy"])) $proxy =$_POST["proxy"]; else $proxy="no";
							
							if ($proxy=='yes' && $proxy_id==0)
							{							
								$query_proxies = $this->db->query('SELECT * FROM proxies_public WHERE status=0');
								if ($query_proxies->num_rows()>0)
									{
										foreach($query_proxies->result() as $row_proxy)
										{
											$proxy_id = $row_proxy -> proxy_id;
											$proxy_type=1;
											break;
										}
									}
							}

							if ($proxy=='no')
							{
								$proxy_id=$current_proxy;
								$proxy_type=0;
							}
					}

				if ($current_proxy!=0 && $weight>=3.8) $proxy_id=$current_proxy;
			}

		
			$order_proxy = $this->db->query('SELECT * FROM orders WHERE receiver="'.$receiver_id.'" AND proxy_id=0 AND status NOT IN ("delivered","warehouse","custom","onair")');
			if ($order_proxy->num_rows() == 0) 
			{
				$proxy_id =0;
				$proxy_type =0;
			}


			$new_status='new';
			$data = array(
				'package'=>$package,
				'price' => $package_price,
				'status'=> $new_status,
				'proxy_id'=> $proxy_id,
				'proxy_type'=> $proxy_type // 0-own proxy, 1-public proxy
				);

			$this->db->where('order_id', $order_id);
		
			if ($this->db->update('orders', $data))
				{
					echo anchor('agents/tracks_preview/'.$order_id,'CP72 print',array('target'=>"_blank",'class'=>'btn btn-warning'))."<br>";
					
					echo anchor('agents/tracks_mini/'.$order_id,'Mini print',array('target'=>"_blank",'class'=>'btn btn-danger'))."<br>";
					log_write("Track edit id =$order_id.'SQL' =".implode(",",$data),"track edit");
					proxy_available($proxy_id,$proxy_type,1);
				}
					else echo '<div class="alert alert-danger" role="alert">Алдаа:'.$this->db-error().'</div>';
		}
		else echo '<div class="alert alert-danger" role="alert">Зөвхөн өөрийн оруулсан item_missing төлөвт буй ачааны тайлбарыг оруулах боломжтой. </div>';
	}
	else echo '<div class="alert alert-danger" role="alert">Илгээмж олдсонгүй</div>';

	?>


</div> <!-- PANEL-BODY -->
</div><!-- PANEL -->