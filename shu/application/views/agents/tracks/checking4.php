<? if (!isset($_POST["track"])) redirect("agents/insert"); else $track=$_POST["track"];?>
<div class="panel panel-primary">
  <div class="panel-heading">Track: бүртгэл</div>
  <div class="panel-body">
<? 	
	$track = string_clean($track);
	
	$track_eliminated = substr($track,-8,8);

	$order_id= tracksearch($track);
	if ($order_id!="")
	{
		$query = $this->db->query("SELECT * FROM orders WHERE order_id='$order_id'");
		$row = $query->row();
		$order_id=$row->order_id;
		$customer_id=$row->receiver;
		$current_proxy=$row->proxy_id;
		$current_proxy_type=$row->proxy_type;
		$current_status=$row->status;
		$weight=$row->weight;
	

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
		$no_proxy = customer($customer_id,"no_proxy");
		//$sql_customer="SELECT no_proxy FROM customer WHERE customer_id='$customer_id' LIMIT 1";
		//$query_customer = $this->db->query($sql_customer);
		//if ($query->num_rows() == 1)
		//{
		//	$row_customer=$query_customer->row();
		//	$no_proxy=$row_customer->no_proxy;
		//}
		//else $no_proxy=0;
		if (isset($_POST["proxy"])) $proxy =$_POST["proxy"]; else $proxy="no";

		if ($no_proxy==0)
		{
			if ($current_proxy==0)
				{
					$query_proxies = $this->db->query('SELECT * FROM proxies WHERE customer_id="'.$customer_id.'" AND status=0 ORDER BY proxy_id DESC LIMIT 1');
					if ($query_proxies->num_rows()>=1)
					{
						
						foreach($query_proxies->result() as $row_proxy)
						{
							$proxy_id = $row_proxy->proxy_id;
							$proxy_type=0;	
						}
					}
					
					
					if ($weight<3.8)
					{
						if ($proxy=='yes' && $proxy_id==0)
						{						
							$query_proxies = $this->db->query('SELECT * FROM proxies_public WHERE status=0 ORDER BY RAND()');
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
						//if ($proxy=='no')
						//{
							//if ($weight<=3.8)
							//{
						//		$proxy_id=$current_proxy;
						//		$proxy_type=0;
							//}
						//}
					}

					if ($weight>=3.8 && $proxy_type ==1 )
					{ $proxy_id =0; $proxy_type =0; }
				}

			if ($current_proxy!=0) { $proxy_id=$current_proxy; $proxy_type=$current_proxy_type;}
		}

		// TAKE OWN NAME
		$order_proxy = $this->db->query('SELECT * FROM orders WHERE receiver="'.$customer_id.'" AND proxy_id=0 AND status IN ("new")');
		if ($order_proxy->num_rows() < 2) 
		{
			$proxy_id =0;
			$proxy_type =0;
		}
		// TAKE OWN NAME

		// IF KARGO.mn DONT CHANGE PROXY
		if($customer_id==6616) 
		{
			$proxy_id = $current_proxy;
			$proxy_type = $current_proxy_type;
		}
		// IF KARGO.mn DONT CHANGE PROXY
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
				echo anchor('agents/tracks_preview/'.$order_id,'CP72 print',array('class'=>'btn btn-warning'))."<br>";
				echo anchor('agents/tracks_mini/'.$order_id,'Mini print',array('class'=>'btn btn-danger'))."<br>";
				proxy_available($proxy_id,$proxy_type,1);
				log_write("Track edit id =$order_id.'SQL' =".implode(",",$data),"track edit");
			}
		else echo '<div class="alert alert-danger" role="alert">Алдаа:'.$this->db->error().'</div>';
		
		echo "<br>";

		//proxy_available($proxy_id,$proxy_type,1);

		//$this->db->where('order_id', $order_id);
		
		//if ($this->db->update('orders', $data))

		

		$sql="SELECT orders.* FROM orders WHERE receiver='".$customer_id."' AND status NOT IN('completed','delivered','warehouse','custom','weight_missing','onair')";
		$sql.=" ORDER BY created_date DESC";

		$query = $this->db->query($sql);
		$payment_rate = cfg_paymentrate();
		//$query = $this->db->like("barcode","CP87");
		if ($query->num_rows() > 0)
		{
			// echo form_open("agents/tracks_changing");
		     echo "<table class='table table-striped small' id='table_dd'>";
			 echo "<thead>";
			 echo "<tr>";
			  // echo "<th>".form_checkbox(array('name'=>'select_all','title'=>'Select all orders'))."</th>";
			   echo "<th>№</th>"; 
			   echo "<th>Үүсгэсэн огноо</th>"; 
			   echo "<th>Хүлээн авагч</th>"; 
			   echo "<th>Утас</th>"; 
			   echo "<th>Barcode / Track</th>"; 
			   echo "<th>Хайрцаг</th>"; 
			   echo "<th>Хоног</th>"; 
			   echo "<th>Төлөв</th>"; 
			   echo "<th>Жин</th>";
			   echo "<th></th>"; 
			   echo "</tr>";
			    echo "</thead>";
			   echo "<tbody>";
				$count=1;$total_weight=0;$total_price=0;
				foreach ($query->result() as $row)
				{  
					$created_date=$row->created_date;
					$order_id=$row->order_id;
					$receiver=$row->receiver;
					$weight=$row->weight;
					$price=$row->price;
					$proxy=$row->proxy_id;
					$proxy_type=$row->proxy_type;
					$barcode=$row->barcode;
					$description=$row->package;
					$Package_advance = $row->advance;
					$Package_advance_value = $row->advance_value;
					$third_party = $row->third_party;
					$extra=$row->extra;
					$boxed=$row->boxed;
					$print=$row->print;
					$status=$row->status;
					$total_weight+=floatval($weight);
					$total_price+=$Package_advance_value;
					$tr=0;
					$days= (strtotime(date("Y-m-d")) - strtotime(date("Y-m-d",strtotime($created_date))))/3600/24;
					if ($receiver!="" &&$status=='order'&&!$tr)
						{
							echo "<tr class='blue' title='Хүлээн авагч тодорхойгүй'>"; $tr=1; $class="blue";
						}
					
					if ($receiver!=1&&$status=='filled'&&!$tr)
						{
							echo "<tr class='green' title='Хүлээн авагч бөглөсөн'>"; $tr=1;$class="green";
						}
					
					
				  	if ($Package_advance==1&&!$tr)
						{
							echo "<tr class='red' title='Үлдэгдэл:".$Package_advance_value."$'>"; $tr=1; $class="red";
						}
					
					if ($status=='weight_missing'&&!$tr)
						{
							echo "<tr class='yellow' title='Жин бөглөгдөөгүй байна:'>"; $tr=1; $class="yellow";
						}
					
					if($status=="warehouse"&&$extra!="") $temp_status=$status." ".$extra."-р тавиур";else $temp_status=$status; 
					if (!$tr) echo "<tr>";else $tr=0;
				   echo "<td class='$class'><span class='$class'></span>".$count++."</td>"; 
				   echo "<td  class='$class'>".$created_date."</td>"; 
					echo "<td class='$class'>".anchor("agents/customers_detail/".$receiver,customer($receiver,"name").count_new_receiver($receiver))."<br>".proxy2($proxy,$proxy_type,"name")."</td>";

				   echo "<td  class='$class'>".customer($receiver,"tel")."</td>"; 
				   echo "<td  class='$class'>".$barcode."<br>"; 
				   if ($third_party!="")
					echo "<a href='".track($third_party)."' target='_blank' title='Хаана явна'>$third_party<span class='glyphicon glyphicon-globe'></span></a>";
				   echo "</td>"; 

				   echo "<td  class='$class'>";
				   if ($boxed==1) 
				   	{
				   		$query = $this->db->query("SELECT * FROM boxes_packages WHERE order_id=".$order_id);
						if ($query->num_rows()==1)
						{
							$row_box = $query->row();
							$box_id= 	$row_box ->box_id;
						}

						if ($box_id=="")
						{
							$query_box=$this->db->query("SELECT * FROM boxes_packages WHERE barcodes LIKE '%".$barcode."%'");
							if ($query_box->num_rows()==1)
							{
							$row_box = $query_box->row();
							$box_id= 	$row_box ->box_id;
							}
						}

						$query = $this->db->query("SELECT * FROM boxes WHERE box_id=".$box_id);
						if ($query->num_rows()==1)
						{
							$row_box = $query->row();
							$box_name= 	$row_box ->name;
						}
				   		echo "box:".anchor("agents/boxes_detail/".$box_id,$box_name);
				   	}
				   	else echo "no box";
				   echo "</td>";

				   echo "<td  class='$class'>".$days."</td>"; 
				   echo "<td  class='$class'>".$temp_status."</td>";

				   echo "<td  class='$class'>"; echo $weight;if($weight>0) "Kg";echo "</td>"; 
				  // echo "<td  class='$class'>".cfg_price($weight)."$</td>"; 
				   //echo "<td>".anchor('agents/tracks_detail/'.$row->order_id,'<img src="'.base_url().'assets/more.png" class="more" title="дэлгэрэнгүй">')."</td>"; 
				   echo "<td  class='$class' id='$class'>";
				   if ($print==0&&$status=="new") 
				   echo anchor('agents/tracks_preview/'.$row->order_id,'<span class="glyphicon glyphicon-print"></span>',array("title"=>"CP72 хэвлэх"));
				   if ($status=="filled") 
				   echo anchor('agents/tracks_preview/'.$row->order_id,'<span class="glyphicon glyphicon-print"></span>',array("title"=>"CP72 хэвлэх"));
				   echo anchor('agents/tracks_detail/'.$row->order_id,'<span class="glyphicon glyphicon-edit"></span>');
				   "</td>"; 


				   echo "</tr>";
				} 
				echo "</tbody>";
				echo "</table>";
		}

	}
	else echo '<div class="alert alert-danger" role="alert">Track not registered</div>';
?>

</div> <!-- PANEL-BODY -->
</div><!-- PANEL -->