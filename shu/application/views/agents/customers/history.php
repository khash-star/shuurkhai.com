<? if (!$this->uri->segment(3)) redirect('agents/customers_display'); else $customer_id=$this->uri->segment(3) ?>

<div class="panel panel-success">
  <div class="panel-heading">Shuurkhai.Com</div>
  <div class="panel-body">
<? 
$query = $this->db->query("SELECT * FROM customers WHERE id=".$customer_id);

if ($query->num_rows() == 1)
{
	$row = $query->row();
	$name=$row->name;
	$surname=$row->surname; 
	$family_name=$row->family_name;
	$reg_num=$row->reg_num;
	$contacts=$row->contacts;
	$address=$row->address;
	$email=$row->email;
	echo "Нэр: ".$name."<br>";	
	echo "Овог: ".$surname."<br>";
	echo "Ургын овог:".$family_name."<br>";
	echo "Регистр: ".$reg_num."<br>";		
	echo "Утас: ".$contacts."<br>";	
	echo "Э-мэйл:".$email."<br>";
	echo "Хаяг: ".$address."<br>";	
	$query = $this->db->query("SELECT * FROM credits WHERE customer_id='".$customer_id."'");
		if ($query->num_rows() > 0)
		{
			echo "<table class='table table-hover'>";
			 echo "<tr>";
			   echo "<th>Огноо</th>"; 
			   echo "<th>Зээлдэгч</th>"; 
			   echo "<th>Үндсэн зээл (₮)</th>"; 
			   echo "<th>Хоног</th>"; 
			   echo "<th>Төлөв</th>"; 
			   echo "<th>&nbsp;</th>"; 
			   echo "</tr>";
			   
			foreach ($query->result() as $row)
			{  echo "<tr>";
			   echo "<td>".$row->created_date."</td>"; 
					  //customer INFO 
						$query_customer = $this->db->query("SELECT * FROM customers WHERE id=".$row->customer_id);
						if ($query_customer->num_rows()>0)
						{
							$row_customer = $query_customer->row(); 
							echo "<td>".$row_customer->name."</td>"; 
						}
						else echo "<td>&nbsp;</td>"; 
			   echo "<td align='right'>".lombard_money_str($row->amount)."</td>"; 
			   echo "<td>".lombard_credit_days($row->id)."</td>"; 
			   echo "<td>".lombard_status($row->status)."</td>"; 
			   //  echo "<td>".anchor('credits/delete/'.$row->id,'устгах')."</td>"; 
			   if (lombard_status($row->status)!="completed")
			   echo "<td>".anchor('credits/detail/'.$row->id,'хаах/cунгах')."</td>";
			   else "<td>&nbsp;</td>"; 
			   echo "</tr>";
			} 
			echo "</table>";
		}
		else echo "Зээл байхгүй";
}
else echo "Зээлдэгч байхгүй";

?>

</div>

<div id="right_side">
<? $this->load->view("calendar");?>
<div id="side_menu">
<ul>
<li><?=anchor('agents/customers', 'Үйлчлүүлэгчид')?></li>
<li><?=anchor('agents/customers_insert', 'Үйлчлүүлэгч оруулах')?></li>
</ul>
</div> <!--side_menu-->
</div> <!--right_side-->
<div id="clear"></div>
</div> <!--wrapper-->