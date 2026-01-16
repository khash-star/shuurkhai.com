<script src="<?=base_url();?>assets/jquery-ui.js"></script>
<link rel="stylesheet" type="text/css" href="<?=base_url();?>assets/jquery.ui.themes/flick/jquery.ui.theme.css"/>
<link rel="stylesheet" type="text/css" href="<?=base_url();?>assets/jquery.ui.themes/flick/jquery-ui.css"/>
<script type="application/javascript">
$(document).ready(function() {
			$('body').on('keydown', 'input, select, textarea', function(e) {
			var self = $(this)
			  , form = self.parents('form:eq(0)')
			  , focusable
			  , next
			  ;
			if (e.keyCode == 13) {
				focusable = form.find('input,a,select,button,textarea').filter(':visible');
				next = focusable.eq(focusable.index(this)+1);
				if (next.length) {
					next.focus();
				} else {
					form.submit();
				}
				return false;
			}
		});
	
	
    $('input[name="select_all"]').click(function(event) {
        if(this.checked) { 
            $('input[type="checkbox"]').each(function() {
                this.checked = true;            
            });
        }else{
            $('input[type="checkbox"]').each(function() {
                this.checked = false; 
            });        
        }
    });
	
	 $('input[type="checkbox"]').click(function(event) {
		 var sum=0;
		 var count=0;
		 var total_price = 0;
		 $('input[type="checkbox"]').each(function() {
         if (this.checked == true) { 
		 var weight = $(this).parent().next().next().next().next().next().next().next().next().next().text();
		 if (weight!="Жин")
			 {
			 sum+=parseFloat(weight);
			 count++;
			 }
		 }
            })
			if (count==0) sum=0;
			if (sum<1 && sum>0)	sum=1;
			total_price= sum  * parseFloat(<? echo cfg_paymentrate();?>);
			$('#total_weight').text(sum.toFixed(2));
			$('#total_price').text(total_price.toFixed(2));

		 })
	$('input[name="contacts"]').change(function(){
		$('#result').append('<img src="<?=base_url()?>assets/ajax-loader.gif" id="loading">');
		var tel= $('input[name="contacts"]').val();
	$.ajax ({
		url: '<?=base_url()?>/admin/customers_check',
		type:'POST',
		data:'tel='+tel,
		success: function(responce){
									$('#loading').remove();
									$('#result').append('<p id="responce">'+responce+'</p>');
									if (responce=="Found user") 
									{
										$.ajax ({
										url: '<?=base_url()?>/admin/customers_check',
										type:'POST',
										data:'tel='+tel+'&value=rd',
										success: function(responce0){
											$('input[name="customers_rd"]').val(responce0);
																	}
												});	
												
										$.ajax ({
										url: '<?=base_url()?>/admin/customers_check',
										type:'POST',
										data:'tel='+tel+'&value=surname',
										success: function(responce1){
											$('input[name="customers_surname"]').val(responce1);
																	}
												});	
												
										$.ajax ({
										url: '<?=base_url()?>/admin/customers_check',
										type:'POST',
										data:'tel='+tel+'&value=name',
										success: function(responce2){
											$('input[name="customers_name"]').val(responce2);
																	}
												});	
												
										$.ajax ({
										url: '<?=base_url()?>/admin/customers_check',
										type:'POST',
										data:'tel='+tel+'&value=email',
										success: function(responce3){
											$('input[name="email"]').val(responce3);
																	}
												});	
												
										$.ajax ({
										url: '<?=base_url()?>/admin/customers_check',
										type:'POST',
										data:'tel='+tel+'&value=address',
										success: function(responce4){
											$('textarea[name="address"]').text(responce4);
																	}
												});	
									}
									}
		});	
	});
	
})
</script>


<div class="panel panel-primary">
  <div class="panel-heading">Shuurkhai.Com</div>
  <div class="panel-body">
<? 
echo "<h3>Бараа олголт</h3>";
if(isset($_POST["search"])) 
	{
	$search_term=str_replace(" ","%",$_POST["search"]);
	if ($search_term!="")
	echo "Xайлт:".$search_term."<br>";
	}
	else $search_term="";
	
	$sql="SELECT orders.*, receiver_customer.name AS r_name,receiver_customer.surname AS r_surname,receiver_customer.tel AS r_tel,receiver_customer.address AS r_address,sender_customer.name AS s_name,sender_customer.surname AS s_surname,sender_customer.tel AS s_tel,sender_customer.address AS s_address FROM orders LEFT JOIN customer AS receiver_customer ON orders.receiver=receiver_customer.customer_id 
LEFT JOIN customer AS sender_customer ON orders.sender=sender_customer.customer_id";
$sql.=" WHERE CONCAT_WS(receiver_customer.name,receiver_customer.tel,sender_customer.name,orders.barcode,orders.third_party) LIKE '%".$search_term."%'";

$sql.=" AND orders.status NOT IN('completed','delivered')";
$sql.=" ORDER BY created_date DESC";

$count = 1;
$total_advance= 0;
$total_weight= 0;

	echo form_open("deliver/delivering_multiple");
	//if(isset($_POST['orders'])) {$orders=$_POST['orders'];$N = count($orders);}

	//if ($N!=0 || $order_id!="")
	//{
	//$count=1;
	
   	echo "<table class='system'>";
    echo "<tr>";
	   echo "<th>".form_checkbox(array('name'=>'select_all','title'=>'Select all orders','checked'=>'checked'))."</th>";
	   echo "<th>№</th>"; 
	   echo "<th>Үүсгэсэн огноо</th>"; 
       echo "<th>Илгээгч</th>"; 
	   echo "<th>Хүлээн авагч</th>"; 
	   echo "<th>Хүлээн авагчын утас</th>"; 
	   echo "<th>Barcode</th>"; 
	   echo "<th>Track</th>"; 
	   echo "<th>Хоног</th>"; 
	   echo "<th>Жин</th>";
	   echo "<th>Төлбөр</th>";
	   echo "<th>Үлдэгдэл</th>";
	   echo "<th>Төлөв</th>"; 
	   echo "<th></th>"; 
	   echo "</tr>";
	//if(isset($_POST['orders'])) {$orders=$_POST['orders'];$N = count($orders);} else $N=0;
	//$count=0;
   //for($i=0; $i < $N; $i++)
    {
//$order_id=$orders[$i];
$query = $this->db->query($sql);

foreach ($query->result() as $row)
		{
		$order_id=$row->order_id;
		$created_date=$row->created_date;
  	 	$sender=$row->sender;
   		$receiver=$row->receiver;
		$barcode=$row->barcode;
		$barcode=$row->barcode;
		$extra=$row->extra;
		$package=$row->package;
		$track=$row->third_party;
		$status=$row->status;
		$weight=$row->weight;if ($weight=="") $weight=0;
		$advance=$row->advance;
		$advance_value=$row->advance_value;


//SENDER 
		$query_sender = $this->db->query("SELECT * FROM customer WHERE customer_id=\"$sender\" LIMIT 1");
		foreach ($query_sender->result() as $row_sender)
		{
			$sender_name=$row_sender->name;

		}
		
		//RECIEVER
		$query_receiver = $this->db->query("SELECT * FROM customer WHERE customer_id=\"$receiver\" LIMIT 1");
		foreach ($query_receiver->result() as $row_receiever)
		{
			$receiver_name=$row_receiever->name;
			$receiver_contact=$row_receiever->tel;
		}
		
	   $days= (strtotime(date("Y-m-d")) - strtotime(date("Y-m-d",strtotime($created_date))))/3600/24;
		
		if ($advance)
		echo "<tr class='red' title=\"Үлдэгдэл:".$advance_value."$\">"; 
		else echo "<tr>";
		
		echo "<td>".form_checkbox("orders[]",$order_id,array('checked'=>'checked'))."</td>"; 
	   echo "<td>".$count++."</td>"; 
	   echo "<td>".$created_date."</td>"; 
       echo "<td>".anchor("customers/detail/".$sender,$sender_name)."</td>"; 
	   echo "<td>".anchor("customers/detail/".$receiver,$receiver_name)."</td>";
	   echo "<td>".$receiver_contact."</td>"; 
	   echo "<td>".$barcode."</td>"; 
	   echo "<td>".$track."</td>"; 
	   echo "<td>".$days."</td>"; 
	   echo "<td id='weight'>".$weight."</td>"; 
	   
	   echo "<td>".$weight*cfg_paymentrate()."</td>";
	   echo "<td>".$advance_value."</td>"; 
	   if ($status!="warehouse")
	   echo "<td>".$status."</td>";
	   else echo "<td>".$status." ".$extra."-р тавиур</td>";
	   echo "<td>".anchor('orders/detail/'.$order_id,'<span class="glyphicon glyphicon-edit"></span>')."</td>"; 
	    echo "</tr>";		
		$total_advance += $advance_value;
		$total_weight += $weight;
	}
	}
	echo "<tr class='total'><td colspan='9'>Нийт</td><td id='total_weight'>$total_weight</td><td  id='total_price'>".$total_weight*cfg_paymentrate()."</td><td>$total_advance</td><td></td><td></td></tr>";
	echo "</table>";
	
	echo "<div class=\"box\">";
	echo "<h4 class=\"legend\">Хүлээн авагч</h4>";
	echo "<span class='formspan'>Утас:(*)</span>";
	echo form_input (array('name'=>'contacts','autofocus'=>'autofocus'))."<span id='result'></span><br>";
	echo "<span class='formspan'>Нэр:(*)</span>";
	echo form_input (array('name'=>'customers_name','autofocus'=>'autofocus'))."<br>";
	echo "<span class='formspan'>Овог:</span>";
	echo form_input ("customers_surname")."<br>";
	echo "<span class='formspan'>РД:</span>";
	echo form_input ("customers_rd")."<br>";
	echo "<span class='formspan'>Э-мэйл:</span>";
	echo form_input ("email")."<br>";
	echo "<span class='formspan'>Хаяг:</span>";
	echo form_textarea("address")."<br>";
	echo "</div>";
	echo form_submit ("submit","Олгох");
	echo form_close();
	
	if ($count==0) echo "Ямар нэг илгээмж олдсонгүй";
?>

</div>
<div id="right_side">
<?
	echo "Хайлт<br>";
	echo form_open ("deliver/deliver_multiple");
	echo form_input("search",$search_term);
	echo form_submit("submit","Хайх");
	echo form_close();
?>
<? $this->load->view("calendar");?>
<div id="side_menu">
<ul>
<li><?=anchor('deliver/delivered', 'Гардуулсан илгээмж')?></li>
<li><?=anchor('deliver', 'Олголт')?></li>
</ul>
</div> <!--side_menu-->
</div> <!--right_side-->
<div id="clear"></div>
</div><!--wrapper-->