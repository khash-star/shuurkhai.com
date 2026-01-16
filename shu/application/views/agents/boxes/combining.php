<div class="panel panel-success">
  <div class="panel-heading">Нэгтгэх ачааны barcode-г оруулна уу</div>
  <div class="panel-body">
<? 
	if (isset($_POST["combine"]))
	{
		$combine = $_POST["combine"];
		$combine_array=explode("\r\n",$combine);
		$first_combine = $combine_array[0];
		$sql = "SELECT * FROM orders WHERE barcode='$first_combine' LIMIT 1";
		$query =$this->db->query($sql);
		if($query->num_rows()==1)
		{
			$row = $query->row();
			$receiver = $row->receiver;
			$similar = 1;
		}
		else $similar = 0;
	
		foreach($combine_array as $combine_barcode)
			{
			if ($combine_barcode!="") 
				{
				$sql = "SELECT * FROM orders WHERE barcode='$combine_barcode' LIMIT 1";
				$query =$this->db->query($sql);
				if ($query->num_rows()==1)
					{
					$row = $query->row();
					if($receiver!= $row->receiver) $similar =0;
					}
				else $similar =0;
				}
			}
		
	if ($similar==1)
	{
		$barcodes=implode(",",$combine_array);
		$weight=0;
		$advance=0;
		$advance_value=0;
		$agent_id=$this->session->userdata("agent_id");
		$status="new";
		$package="";
		$proxy_id =0;
		$proxy_type=0;
		$current_proxy=0;

	$sql_customer="SELECT no_proxy FROM customer WHERE customer_id='$receiver' LIMIT 1";
	$query_customer = $this->db->query($sql_customer);
	if ($query->num_rows() == 1)
	{
		$row_customer=$query_customer->row();
		$no_proxy=$row_customer->no_proxy;
	}
	else $no_proxy=0;

	if ($no_proxy==0)
	{

				$query_proxies = $this->db->query('SELECT * FROM proxies WHERE customer_id="'.$receiver.'" AND status=0 ORDER BY proxy_id DESC');
				$proxy_available_id=0;
				if ($query_proxies->num_rows()>1)
				{
					foreach($query_proxies->result() as $row_proxy)
					{
						$proxy_id = $row_proxy -> proxy_id;
						$proxy_type = 1;
						break;

						//$order_proxy = $this->db->query('SELECT proxy_id FROM orders WHERE receiver="'.$receiver.'" AND proxy_id="'.$proxy_id_instance.'" AND status NOT IN ("delivered","warehouse","custom","onair")');
						
						//$combine_proxy = $this->db->query('SELECT proxy_id FROM box_combine WHERE receiver="'.$receiver.'" AND proxy_id="'.$proxy_id_instance.'" AND status NOT IN ("delivered","warehouse","custom","onair")');
						
						//if ($order_proxy->num_rows() == 0 && $combine_proxy->num_rows()==0) 
						//	{$proxy_available_id= $proxy_id_instance;break;}
					}
				}
				//$proxy_id =$proxy_available_id;
				//$proxy_type=0;	

				/*
				if ($proxy_id==0)
				{
					$query_proxies = $this->db->query('SELECT * FROM proxies_public');
					$proxy_available_id=0;
					if ($query_proxies->num_rows()>0)
						{
							foreach($query_proxies->result() as $row_proxy)
							{
								$proxy_id = $row_proxy -> proxy_id;
								$proxy_type = 1;
								break;
								//$order_proxy = $this->db->query('SELECT proxy_id FROM orders WHERE status NOT IN ("delivered","warehouse","custom","onair") AND proxy_type=1 AND proxy_id="'.$proxy_each.'"');
								
								//$combine_proxy = $this->db->query('SELECT proxy_id FROM box_combine WHERE  status NOT IN ("delivered","warehouse","custom","onair") AND proxy_id="'.$proxy_each.'" AND proxy_type=1');
								
								//if ($order_proxy->num_rows() == 0 && $combine_proxy->num_rows()==0) 
								//{ $proxy_available_id= $proxy_each; break;echo $proxy_each;}
							}
						}
					//$proxy_id =$proxy_available_id;
					//$proxy_type=1;
				}
				*/
		//if ($current_proxy!=0) $proxy_id=$current_proxy;
	}
	
	
	
	foreach($combine_array as $combine_barcode)
		{
		if ($combine_barcode!="") 
			{
			$sql = "SELECT * FROM orders WHERE barcode='$combine_barcode' LIMIT 1";
			$query =$this->db->query($sql);
			if ($query->num_rows()==1)
				{
				$row = $query->row();
				$weight+=$row->weight;
				$advance+=$row->advance;
				$advance_value=$row->advance_value;	
				$package_single=$row->package;

			   	$package_single_array=explode("##",$package_single);

			   	$package1_name = $package_single_array[0];
				$package1_num = $package_single_array[1];
				$package1_value = $package_single_array[2];
				
				$package.=$package1_name."##".$package1_num."##".$package1_value."##";
				}	
			}
		}
	
	echo "PACAKGE:".$package;

	if ($weight>2.8) {$proxy_id=0;$proxy_type=0;}
	
	$package = str_replace("####","",$package);
	$data = array(
			'created_date'=>date("y-m-d H:i:s"),
			'receiver'=>$receiver,
			'package' =>$package,
			'weight' => $weight,
			'advance' =>$advance,
			'advance_value' =>$advance_value,
			'barcodes'=> $barcodes,
			'status'=> $status,
			'proxy_id'=> $proxy_id,
			'proxy_type'=> $proxy_type,
			'barcode'=> 'GO5'.substr(date("ymd"),1).sprintf("%03d",rand(000,999)).'MN',
			'agent' => $this->session->userdata("agent_id")
			);
			
			if ($this->db->insert('box_combine', $data)) 
			{
			$combine_id= $this->db->insert_id();
			proxy_available($proxy_id,$proxy_type,1);
			echo '<div class="alert alert-success" role="alert">Амжилттай хайрцаглалаа</div>';
			echo anchor('agents/combine_preview/'.$combine_id,'CP72 print',array('target'=>"new",'class'=>'btn btn-warning'))."<br>";
			}
			else echo "Алдаа:".$this->db->error();
	}
	else echo "Barcode нэг хүнийх биш barcode байна.";
	}
	
	
	
	
	
	
	
	
	
	if (isset($_POST["barcodes"]))
	{
	$barcodes = $_POST["barcodes"];
	$weight=0;
	$advance=0;
	$advance_value=0;
	$agent_id=$this->session->userdata("agent_id");
	$status="new";
	$package="";
	$receiver =0;
	

	foreach($barcodes as $combine_barcode)
		{
		//echo $combine_barcode;
		if ($combine_barcode!="") 
			{
			$sql = "SELECT * FROM orders WHERE barcode='$combine_barcode' LIMIT 1";
			$query =$this->db->query($sql);
			if ($query->num_rows()==1)
				{
				$row = $query->row();
				$weight+=$row->weight;
				$advance+=$row->advance;
				$advance_value=$row->advance_value;	
				$package_single=$row->package;
				$package.=$package_single;
				$receiver = $row->receiver;
				}	
			}
		}
	
			$package = str_replace("####################","##",$package);
	$data = array(
			'created_date'=>date("c"),
			'receiver'=>$receiver,
			'package' =>$package,
			'weight' => $weight,
			'advance' =>$advance,
			'advance_value' =>$advance_value,
			'barcodes'=> implode(",",$barcodes),
			'status'=> $status,
			'barcode'=> 'GO5'.substr(date("ymd"),1).sprintf("%03d",rand(000,999)).'MN',
			'agent' => $this->session->userdata("agent_id")
			);
			
			if ($this->db->insert('box_combine', $data)) 
			{
				$combine_id= $this->db->insert_id();
				echo '<div class="alert alert-success" role="alert">Амжилттай хайрцаглалаа</div>';
				echo anchor('agents/combine_preview/'.$combine_id,'CP72 print',array('target'=>"new",'class'=>'btn btn-warning'))."<br>";
			}
			else echo "Алдаа:".$this->db->error();
			
	}
	
	
	
	
	

	
	


?>

  </div> <!-- PANEL BODY -->
</div><!-- PANEL  -->