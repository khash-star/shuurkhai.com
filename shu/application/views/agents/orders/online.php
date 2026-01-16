<div class="panel panel-success">
  <div class="panel-heading">Shuurkhai.Com</div>
  <div class="panel-body">
<? 
echo "<h3>Online захиалгууд</h3>";
$query = $this->db->query("SELECT * FROM online ORDER by created_date DESC");

if ($query->num_rows() > 0)
{
		 echo "<table class='table table-hover'>";
		 echo "<tr>";
	 	 echo "<th>№</th>"; 
	   	 echo "<th>Үүсгэсэн огноо</th>"; 
		 echo "<th>Хүлээн авагчийн нэр</th>"; 
		 echo "<th>Хүлээн авагчийн утас</th>"; 
		 echo "<th>Барааны веблинк</th>"; 
		 echo "<th>Тоо</th>"; 
		 echo "<th>Размер</th>"; 
		 echo "<th>Өнгө</th>"; 
		 echo "<th></th>";
		  echo "<th></th>";
		 echo "</tr>";
		 
		 $count=1;
		 foreach ($query->result() as $row)
			{  
			$online_id=$row->online_id;
			$created_date=$row->created_date;
			$receiver=$row->receiver;
			$url=$row->url;
			$size=$row->size;
			$color=$row->color;
			$number=$row->number;
			$status=$row->status;
   			
   	
			//RECIEVER
			if ($receiver!="")
			{
			$query_reciever = $this->db->query("SELECT * FROM customer WHERE customer_id=\"$receiver\" LIMIT 1");
			foreach ($query_reciever->result() as $row_reciever)
			{
				$reciever_name=$row_reciever->name;
				$reciever_surname=$row_reciever->surname;
				$reciever_contact=$row_reciever->tel;
				$reciever_rd=$row_reciever->rd;
				$reciever_email=$row_reciever->email;
				$reciever_address=$row_reciever->address;
			}
			} else {$reciever_name="";$reciever_contact="";}
		
			 echo "<tr>";
			 echo "<td>".$count++."</td>"; 
			 echo "<td>".$created_date."</td>"; 
			 echo "<td>".substr($reciever_surname,0,2).".".$reciever_name."</td>"; 
			 echo "<td>".$reciever_contact."</td>"; 
			 echo "<td><a href='".$url."' target='new' title='".$url."'>".substr($url,0,100)."...</a></td>"; 
			 echo "<td>".$number."</td>"; 
			 echo "<td>".$size."</td>"; 
			 echo "<td>".$color."</td>"; 
			 echo "<td>".anchor('online_orders/online_renew/'.$online_id,'Order')."</td>";
			 echo "<td>".anchor('online_orders/online_delete/'.$online_id,'delete')."</td>"; 
			 echo "</tr>";
			}
   			echo "</table>";
	
	
   }
   else echo "Online захиалга олдсонгүй<br>";

?>

</div>
<div id="right_side">
<? $this->load->view("calendar");?>
<div id="side_menu">
<ul>
<li><?=anchor('online_orders', 'Илгээмжүүд')?></li>
<li><?=anchor('online_orders/create', 'Илгээмж оруулах')?></li>
<? if ($query->num_rows() == 1)
	{
	echo "<li>".anchor('orders/online_renew/'.$online_id,'Энэ online-г Илгээмж болгох')."</li>";
	//echo anchor('orders/deliver/'.$order_id,'Хүргэж өгсөн')."<br>";
    echo "<li>".anchor('orders/online_delete/'.$online_id,'Энэ online-г Устгах')."</li>";
   	//echo "<li>".anchor('orders/track/'.$order_id,'Хаана явна')."</li>";
	}
?>
</ul>
</div> <!--side_menu-->
</div> <!--right_side-->
<div id="clear"></div>
</div><!--wrapper-->