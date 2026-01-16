<div class="panel panel-primary">
  <div class="panel-heading">Олголт</div>
  <div class="panel-body">
<? 

//DELIVER costumer

	$contacts = $_POST["contacts"];
	$name = $_POST["name"];
	$surname = $_POST["surname"];
	$rd = $_POST["rd"];
	$email = $_POST["email"];
	$address = $_POST["address"];

	$city=$_POST["city"];
	$district=$_POST["district"];
	$khoroo=$_POST["khoroo"];
	$build=$_POST["build"];

	
	
	$method = $_POST["method"];
	
	$error=TRUE;
	if ($contacts!=""&&$name!="")
		{	
		$query_deliver = $this->db->query('SELECT * FROM customer WHERE tel="'.$contacts.'"');
		if($query_deliver->num_rows()==1)
			{
			$data = array(
			   'name'=>$name,
			   'surname'=>$surname,
			   'rd'=>$rd,
			   'email'=>$email,
			   'address'=>$address,
			   'address_city' =>$city,
			   'address_district' =>$district,
			   'address_khoroo' =>$khoroo,
			   'address_build' =>$build
            );
			$this->db->where('tel', $contacts);
			if ($this->db->update('customer', $data)) 
			{
			$row=$query_deliver->row();
			$deliver_id=$row->customer_id;
			}
			else $error=FALSE;
			}
		else { //RECEIVER NOT FOUND IN RECORD SO INSERT INTO DB
				$data = array(
					'name'=>$name,
					'tel'=>$contacts,
					'surname'=>$surname,
					'rd'=>$rd,
					'email'=>$email,
					'address'=>$address,
					'address_city' =>$city,
					'address_district' =>$district,
					'address_khoroo' =>$khoroo,
					'address_build' =>$build,
					'username'=>$contacts,
					'password'=>$contacts,
					'status'=> 'regular'
	            );
				if ($this->db->insert('customer', $data))
				$deliver_id=$this->db->insert_id();
				else  $error=FALSE;
			}	

		if(isset($_POST['orders'])) 
		{
			$orders=$_POST['orders'];$N = count($orders);
		    $barcodes=array();
				for($i=0; $i < $N; $i++)
				{
					$order_id=$orders[$i];
					$sql="SELECT * FROM orders WHERE order_id=$order_id LIMIT 1";
					$query= $this->db->query($sql);
					//if ($query->num_rows()==1)
					//	{
					$row=$query->row();
					$proxy_id = $row->proxy_id;
					$proxy_type = $row->proxy_type;
					$status = $row->status;

					if ($status=="custom")
					$sql = "UPDATE orders SET delivered_date='".date("Y-m-d H:i:s")."' ,method='".$method."',deliver='$deliver_id' WHERE order_id=$order_id LIMIT 1";
					
					if ($status!="custom")
					$sql = "UPDATE orders SET status='delivered',deliver='$deliver_id',delivered_date='".date("Y-m-d H:i:s")."' ,method='".$method."' WHERE order_id=$order_id LIMIT 1" ;
					
					array_push($barcodes,$row->barcode);
					if ($this->db->query($sql)) proxy_available($proxy_id,$proxy_type,0); else $error=FALSE;
				}
		}
	}
	
	if($error&&isset($_POST['orders'])&&isset($deliver_id)) 
	echo '<div class="alert alert-success" role="alert">Амжилттай өөрчиллөө</div>';
	else echo '<div class="alert alert-danger" role="alert">Олголтонд алдаа гарлаа. Error:'.$this->db->error().'</div>';
	
	if(isset($_POST['orders'])) 
	{
		echo "<table class='table table-hover'>";
		echo "<tr>";
		echo "<th>№</th>"; 
		echo "<th>Үүсгэсэн огноо</th>"; 
      	echo "<th>Илгээгч</th>"; 
	   echo "<th>Х/авах</th>"; 
	   echo "<th>Гардсан</th>"; 
	   echo "<th>Barcode/track</th>"; 
	   echo "<th>Хоног</th>"; 
	   echo "<th>Төлөв</th>"; 
	   echo "<th>Жин</th>"; 
	   echo "<th>Төлбөр</th>"; 
	   echo "<th>Үлдэгдэл</th>";
	    echo "<th>Арга</th>";
	   echo "<th></th>"; 
	   echo "</tr>";
		$count=1;$total_weight=0;$total_price=0;$total_advance=0; $total_weight_branch =0; $total_admin_value=0;

		$orders=$_POST['orders'];$N = count($orders);

		for($i=0; $i < $N; $i++)
		{
		$sql="SELECT * FROM orders WHERE order_id='".$orders[$i]."' LIMIT 1";
		$query= $this->db->query($sql);
			if ($query->num_rows()==1)
			{
			$row=$query->row();
			$order_id=$row->order_id;
			$created_date=$row->created_date;
			$sender=$row->sender;
			$receiver=$row->receiver;
			$deliver=$row->deliver;
			$barcode=$row->barcode;
			$track=$row->third_party;
			$weight=$row->weight;
			$advance=$row->advance;
			$advance_value=floatval($row->advance_value);
			$status=$row->status;
			$method=$row->method;
			$is_online=$row->is_online;
			$is_branch=$row->is_branch;
			$admin_value=$row->admin_value;
			$Package_advance = $row ->advance;
			$Package_advance_value =$row->advance_value;


			if ($is_online==1) 
			{
				if ($is_branch)
				$total_weight_branch+=$weight;
				else  
				$total_weight+=$weight;
			}

			$total_admin_value+=$admin_value;

			if ($is_online==0 && $Package_advance==1)
			$total_advance+=$Package_advance_value;
							

			$price=cfg_price($weight);
			if($status=="warehouse"&&$extra!="") 
			$temp_status=$status." ".$extra."-р тавиур";else $temp_status=$status;
			echo "<tr>";
	    	echo "<td>".$count++."</td>"; 
			echo "<td>".$created_date."</td>"; 
			echo "<td>".anchor("admin/customers_detail/".$sender,substr(customer($sender,"surname"),0,2).".".customer($sender,"name"))."</td>";
			echo "<td>".anchor("admin/customers_detail/".$receiver,substr(customer($receiver,"surname"),0,2).".".customer($receiver,"name"))."</td>";
			echo "<td>".anchor("admin/customers_detail/".$deliver,substr(customer($deliver,"surname"),0,2).".".customer($deliver,"name"))."</td>";

			echo "<td>".$barcode."<br>"; 
			echo $track."</td>";
			echo "<td>".intval(days($created_date))."</td>"; 
	   		echo "<td>".$temp_status."</td>"; 
			echo "<td>".$weight."</td>"; 
	   		echo "<td>".cfg_price($weight)."</td>"; 
	   		echo "<td>".$advance_value."</td>"; 
			echo "<td>".$method."</td>"; 
			echo "<td>".anchor('orders/detail/'.$row->order_id,'<span class="glyphicon glyphicon-edit"></span>')."</td>";
	   		echo "</tr>";
	   		//$total_weight+=$weight;
			$total_price+=$price;
			$total_advance+=floatval($advance_value);

			if ($is_online==1) $total_weight+=$weight;
	
				$total_admin_value+=$admin_value;
	
				if ($is_online==0&&$advance==1)
				$total_advance+=$advance_value;
			}
		}
		echo "<tr class='total'><td colspan='8'>Нийт</td><td id='total_weight'>$total_weight</td><td id='total_price'>$total_price</td><td>$total_advance</td><td></td><td></td></tr>";
	echo "</table>";
	}
	//if ($total_advance==0) $grand_total = cfg_price($total_weight);
	//	else $grand_total =$total_advance;
	// $grand_total = cfg_price($total_weight);
	if ($total_advance==0) 
	$grand_total = cfg_price($total_weight) + cfg_price_branch($total_weight_branch);
	else $grand_total =$total_advance;

	// //echo $grand_total;
	// $grand_total_tug = ($grand_total+$total_admin_value)*cfg_rate();

	// // if ($total_advance==0) $grand_total = cfg_price($total_weight);
	// // else $grand_total =$total_advance;

	// if ($grand_total_tug == 0)
	$grand_total_tug = $_POST["grand_total_tug"];

	if ($method=='cash') {$cash = $grand_total_tug;$pos=0;$account=0;}
	if ($method=='pos') {$pos = $grand_total_tug;$cash=0;$account=0;}
	if ($method=='account') {$account = $grand_total_tug;$pos=0;$cash=0;}
	if ($method=='mix') {$account = $_POST["account_value"];$pos = $_POST["pos_value"];$cash=$_POST["cash_value"];}
	 $later = 0;
	if ($method=='later') {$account = 0;$pos = 0;$cash=0; $later = $grand_total_tug;}
	$sql = "SELECT *FROM bills WHERE deliver=$deliver_id AND barcode='".implode(',',$barcodes)."'";
	$query_delivered = $this->db->query($sql);
		if($query_delivered->num_rows()==0)
		{
			$sql = "INSERT INTO bills (`timestamp`,deliver,barcode,weight,type,count,cash,account,pos,later,total) VALUES('".date("Y-m-d H:i:s")."',$deliver_id,'".implode(',',$barcodes)."',$total_weight,'$method',$N,'$cash','$account','$pos','$later','$grand_total_tug')";
			$this->db->query($sql);
			$bill_id = $this->db->insert_id();


			foreach ($barcodes as $i => $value)
				{
		    		unset($barcodes[$i]);
				}

			if ($method == 'later')
			{
				$query_receiver =$this->db->query("SELECT receiver FROM orders WHERE order_id IN (".implode(",",$orders).") GROUP BY receiver");
				foreach ($query_receiver->result() as $row_receier)
					{
						  $receiver = $row_receier->receiver;
						  $query_orders =$this->db->query("SELECT * FROM orders WHERE order_id IN (".implode(",",$orders).") AND receiver='$receiver'") ;

						  		$weight=0;
								$weight_noooo=0;
								$advance=0;
								$admin=0;
								$price=0;
								$grand_weight = 0;
								$total_payment = 0;


								foreach ($query_orders->result() as $row_orders)
								{  
									array_push ($barcodes, $row_orders->barcode);
									if ($row_orders->is_online == 0)
										{
										$advance+=$row_orders->advance_value;
										$weight_noooo +=$row_orders->weight;
										}
									if ($row_orders->is_online == 1)
										{
										$admin+=$row_orders->admin_value;
										$weight+=$row_orders->weight;
										}
								}
								$total_payment = $advance+$admin+cfg_price($weight);
							$init_balance = 0;
							$query_records = $this->db->query("SELECT * FROM later_payment WHERE d_customer='".$deliver."' ORDER BY id DESC LIMIT 1");
									if ($query_records->num_rows() ==1)
									{
										$row = $query_records->row();
										$init_balance = $row->final_balance;
									}
									else 
									{
										$query_orders= $this->db->query( "SELECT * FROM orders WHERE deliver=$deliver AND (status='delivered' OR status='custom') AND method ='later'");
										$init_balance =0;$weight=0;$admin=0;$admin_value=0;$advance_value=0;$advance=0;$weight_noooo=0;
										foreach ($query_orders->result() as $row_orders)
											{  
											if ($row_orders->is_online == 0)
												{
												$advance+=$row_orders->advance_value;
												$weight_noooo +=$row_orders->weight;
												}
											if ($row_orders->is_online == 1)
												{
												$admin+=$row_orders->admin_value;
												$weight+=$row_orders->weight;
												}
												$init_balance += $advance+$admin+cfg_price($weight);
											}
									}
							$final_balance = $init_balance+$total_payment;
							$sql = "INSERT INTO later_payment (`date`,d_customer,dept,init_balance,final_balance,description,bill) VALUES(
							'".date("Y-m-d")."',$deliver,$total_payment,$init_balance,$final_balance,'".implode(",",$barcodes)."',$bill_id)";
							$this->db->query($sql);
				
					}
			}

			if (!($total_price==0 && $total_advance==0))
				{
					if(strpos($_SERVER['HTTP_HOST'],'www')===false)
					{
						$base_url = 'https://shuurkhai.com/shu/';
					}
					else
					{
						$base_url = 'https://www.shuurkhai.com/shu/';
					}

				?>
				<script type="text/javascript" language="Javascript">window.open('<?=$base_url;?>index.php/admin/bill/<?=$deliver_id;?>/<?=implode(",",$orders);?>/<?=$method;?>');</script>
				
				<?php
				}
			echo anchor("admin/reverse/$bill_id","Энэ олголтыг хүчингүй болгох!!!!",array("class"=>"btn btn-danger btn-sm"));
		}

		else 
		{
			echo "Энэ ачаа гардуулагдаж тооцоонд орсон байна. Тооцоог буцаана уу.";
		}		
?>


</div>
</div>