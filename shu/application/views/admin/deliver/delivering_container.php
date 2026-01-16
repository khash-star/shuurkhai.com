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
	$count = $_POST["count"];
	
	
	//$method = $_POST["method"];
	
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
		            );
					$this->db->where('tel', $contacts);
					if ($this->db->update('customer', $data)) 
					{
					$row=$query_deliver->row();
					$deliver_id=$row->customer_id;
					}
					else $error=FALSE;
				}
			else 
				{ //RECEIVER NOT FOUND IN RECORD SO INSERT INTO DB
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

			$account = $_POST["account_value"];$pos = $_POST["pos_value"];$cash=$_POST["cash_value"];$later=$_POST["later_value"];
			$total = $account+$pos+$cash+$later;

			$sql = "INSERT INTO bills_container (`timestamp`,deliver,count,cash,account,pos,later,total) VALUES('".date("Y-m-d H:i:s")."',$deliver_id,'$count','$cash','$account','$pos','$later','$total')";
			$this->db->query($sql);
			echo "Амжилттай гардууллаа.";
		}
		else  redirect("admin/deliver_container");

		//$bill_id = $this->db->insert_id();

		//echo anchor("admin/reverse/$bill_id","Энэ олголтыг хүчингүй болгох!!!!",array("class"=>"btn btn-danger btn-sm"));
?>


</div>
</div>
<?
/*if (!($total_price==0 && $total_advance==0))
	{
	?>
	<script type="text/javascript" language="Javascript">window.open('http://www.shuurkhai.com/login/index.php/admin/bill/<?=$deliver_id;?>/<?=implode(",",$orders);?>/<?=$method;?>');</script>
	
	<?php
	}
	*/
?>