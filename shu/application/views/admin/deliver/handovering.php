<div class="panel panel-primary">
  <div class="panel-heading">Хүргэлтээр гаргах</div>
  <div class="panel-body">
<? 

//DELIVER costumer

	/*	$contacts = $_POST["contacts"];
	$name = $_POST["name"];
	$surname = $_POST["surname"];
	$rd = $_POST["rd"];
	$email = $_POST["email"];
	$address = $_POST["address"];*/
	
	
	//$method = $_POST["method"];
	
	$error=TRUE;
	/*if ($contacts!=""&&$name!="")
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
				'username'=>$contacts,
				'password'=>$contacts,
				'status'=> 'regular'
            );
			if ($this->db->insert('customer', $data))
			$deliver_id=$this->db->insert_id();
			else  $error=FALSE;
		}	
	*/

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
			$status = $row->status;
			//if ($status=="custom")
			//$sql = "UPDATE orders SET delivered_date='".date("Y-m-d H:i:s")."' ,method='".$method."',deliver='$deliver_id' WHERE order_id=$order_id LIMIT 1";
			
			//if ($status!="custom")
			//$sql = "UPDATE orders SET status='delivered',deliver='$deliver_id',delivered_date='".date("Y-m-d H:i:s")."' ,method='".$method."' WHERE order_id=$order_id LIMIT 1" ;

			$sql = "UPDATE orders SET status='warehouse',warehouse_date='".date("Y-m-d H:i:s")."',extra='999' WHERE order_id=$order_id LIMIT 1" ;
			// 999-Хүргэлтээр гарсан
			array_push($barcodes,$row->barcode);
			if (!$this->db->query($sql)) $error=FALSE;
		}
	}
	
	if($error&&isset($_POST['orders'])) 
		echo '<div class="alert alert-success" role="alert">Амжилттай өөрчиллөө</div>';
		else echo '<div class="alert alert-danger" role="alert">Хүргэлтээр гаргахад алдаа гарлаа. Error:'.$this->db->error().'</div>';
	
	if(isset($_POST['orders'])) 
	{
		echo "<table class='table table-hover'>";
		echo "<tr>";
		echo "<th>№</th>"; 
	    echo "<th>Х/авах</th>"; 
	    echo "<th>Утас</th>";
	   	echo "<th>Barcode/track</th>"; 
	   	echo "<th>Жин</th>"; 
	   	//echo "<th>Төлбөр</th>"; 
	   	//echo "<th>Үлдэгдэл</th>";
	    //echo "<th>Арга</th>";
	   	echo "<th></th>"; 
	   	echo "</tr>";
		$count=1;$total_weight=0;
		$orders=$_POST['orders'];$N = count($orders);

		for($i=0; $i < $N; $i++)
		{
			$sql="SELECT * FROM orders WHERE order_id='".$orders[$i]."' LIMIT 1";
			$query= $this->db->query($sql);
			if ($query->num_rows()==1)
			{
				$row=$query->row();
				$order_id=$row->order_id;
				//$created_date=$row->created_date;
				//$sender=$row->sender;
				$receiver=$row->receiver;
				//$deliver=$row->deliver;
				$barcode=$row->barcode;
				$track=$row->third_party;
				$weight=$row->weight;
				//$advance=$row->advance;
				//$advance_value=$row->advance_value;
				//$status=$row->status;
				//$method=$row->method;
				//$is_online=$row->is_online;
				//$admin_value=$row->admin_value;

				//$price=cfg_price($weight);
				//if($status=="warehouse"&&$extra!="") 
				//$temp_status=$status." ".$extra."-р тавиур";else $temp_status=$status;
				echo "<tr>";
	    		echo "<td>".$count++."</td>"; 
				//echo "<td>".$created_date."</td>"; 
				//echo "<td>".anchor("admin/customers_detail/".$sender,substr(customer($sender,"surname"),0,2).".".customer($sender,"name"))."</td>";
				echo "<td>".anchor("admin/customers_detail/".$receiver,substr(customer($receiver,"surname"),0,2).".".customer($receiver,"name"))."</td>";
				echo "<td>".anchor("admin/customers_detail/".$receiver,customer($receiver,"tel"))."</td>";
				
				//echo "<td>".anchor("admin/customers_detail/".$deliver,substr(customer($deliver,"surname"),0,2).".".customer($deliver,"name"))."</td>";

				echo "<td>".$barcode."<br>"; 
				echo $track."</td>";
				
	   			echo "<td>".$weight."</td>"; 
	   			//echo "<td>".cfg_price($weight)."</td>"; 
	   			//echo "<td>".$advance_value."</td>"; 
				//echo "<td>".$method."</td>"; 
				//echo "<td>".anchor('orders/detail/'.$row->order_id,'<span class="glyphicon glyphicon-edit"></span>')."</td>";
	   			echo "</tr>";

		   		$total_weight+=$weight;
				//$total_price+=$price;
				//$total_advance+=$advance_value;

			/*if ($is_online==1) $total_weight+=$weight;
	
				$total_admin_value+=$admin_value;
	
				if ($is_online==0&&$advance==1)
				$total_advance+=$advance_value;*/
			}
		}
		//echo "<tr class='total'><td colspan='8'>Нийт</td><td id='total_weight'>$total_weight</td><td id='total_price'>$total_price</td><td>$total_advance</td><td></td><td></td></tr>";
		echo "<tr class='total'><td colspan='4'>Нийт</td><td id='total_weight'>$total_weight</td></tr>";
	echo "</table>";
	}
	//if ($total_advance==0) $grand_total = cfg_price($total_weight);
	//	else $grand_total =$total_advance;
	//$grand_total = cfg_price($total_weight);
	//echo $grand_total;
	//$grand_total_tug = ($grand_total+$total_admin_value)*cfg_rate();

	//if ($method=='cash') {$cash = $grand_total_tug;$pos=0;$account=0;}
	//if ($method=='pos') {$pos = $grand_total_tug;$cash=0;$account=0;}
	//if ($method=='account') {$account = $grand_total_tug;$pos=0;$cash=0;}
	//if ($method=='mix') {$account = $_POST["account_value"];$pos = $_POST["pos_value"];$cash=$_POST["cash_value"];}
	// $later = 0;
	//if ($method=='later') {$account = 0;$pos = 0;$cash=0; $later = $grand_total_tug;}

	//$sql = "INSERT INTO bills (`timestamp`,deliver,barcode,weight,type,cash,account,pos,later,total) VALUES('".date("Y-m-d H:i:s")."',$deliver_id,'".implode(',',$barcodes)."',$total_weight,'$method','$cash','$account','$pos','$later','$grand_total_tug')";
	//$this->db->query($sql);
		
		
?>


</div>
</div>
<?
if ($count>0)
	{
	?>
	<script type="text/javascript" language="Javascript">window.open('https://www.shuurkhai.com/shu/index.php/admin/handover_bill/<?=implode(",",$orders);?>');</script>
	
	<?
	}
?>