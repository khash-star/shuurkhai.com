<? //if (!isset($_POST["deliver"]) || !isset($_POST["tel"])) redirect("admin/deliver");?>
<script type="application/javascript">
$(document).ready(function() {
			$(".alert").hide();
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

			$("#cash_value").hide();
			$("#pos_value").hide();
			$("#account_value").hide();
	
	
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
		 var sum_weight=0;
		 var total_advance=0;
		 var grand_total=0;
		  var total_admin_value=0;
		 $('input[type="checkbox"]').each(function() {
         if (this.checked == true) { 
			 var weight = $(this).parent().next().next().next().next().next().next().next().text();
			 var advance = $(this).parent().next().next().next().next().next().next().next().next().text();
			 var admin_value = $(this).parent().next().next().next().next().next().next().next().next().next().text();
			 if (!isNaN(parseFloat(admin_value)))
				total_admin_value +=parseFloat(admin_value);

			 if (weight!="Жин")
				 {
					 if (advance=="")
					 sum_weight+=parseFloat(weight);
				 }
			 if (advance>0)
				 {
				 total_advance+=parseFloat(advance);
				 }			 
			 }
			 
            })

			if (sum_weight>1) total_price=7*sum_weight;
			if (sum_weight>0.5 && sum_weight<=1) total_price=7;
			if (sum_weight>0 && sum_weight<=0.5) total_price=5;
			if (sum_weight==0) total_price=0;
			
			var grand_total = total_price+total_advance;
			var grand_total_tug = grand_total*<?=cfg_rate();?>;

			//alert (grand_total.toFixed(2));
			$('#total_weight').val(sum_weight.toFixed(2));
			$('#total_advance').val(total_advance.toFixed(2));
			$('#total_admin').val(total_admin_value.toFixed(2));
			$('#grand_total').val(grand_total.toFixed(2));
			$('#grand_total_tug').val(grand_total_tug.toFixed(2));
			//$('#grand_total').hide(100);
			
			$('#total_weight_inmodal').val(sum_weight.toFixed(2));
			$('#grand_total_inmodal').val(grand_total.toFixed(2));
			$('#total_admin_inmodal').val(total_admin_value.toFixed(2));
			$('#grand_total_inmodal_tug').val(grand_total_tug.toFixed(2));
		 })

	$('input[type="radio"]').change(function(){
 		if ($('input[type="radio"]:checked').val()=="mix")
 			{
			$("#cash_value").show();
			$("#pos_value").show();
			$("#account_value").show();
 			}
		 })	
})
</script>
<? echo form_open("admin/handovering");?>
<div class="panel panel-success">
  <div class="panel-heading">Хүргэлтээр гаргах</div>
  <div class="panel-body">
<? 
	if (isset($_POST["handover"]))
	{
	$deliver = $_POST["handover"];
	$deliver_array=explode("\r\n",$deliver);
	$deliver_array =array_unique ($deliver_array);
	}
	
	if (isset($_POST["tel"]))
	{
	$tel = $_POST["tel"];
	}
	//print_r($deliver_array);
	echo "<table class='table table-hover'>";
		echo "<tr>";
		echo "<th>".form_checkbox(array('name'=>'select_all','title'=>'Select all orders',"checked"=>"checked"))."</th>";
		echo "<th>№</th>"; 
      	echo "<th>Илгээгч</th>"; 
	   echo "<th>Х/а утас</th>"; 
	   echo "<th class='track_td'>Barcode/Track</th>"; 
	   echo "<th>Хоног</th>"; 
	   echo "<th>Төлөв</th>"; 
	   echo "<th>Жин</th>"; 
	   echo "<th>Тооцоо /$/</th>"; 
	   echo "<th>Админ тооцоо</th>";
	   echo "<th></th>"; 
	   echo "</tr>";
	   $count=1;$total_weight=0;$total_advance=0; $grand_total=0; $total_admin_value=0;
	   if (isset($deliver))
	   {
		foreach($deliver_array as $deliver_barcode)
		{
			
			
		if ($deliver_barcode!="")
			{
				$sql = "SELECT *FROM box_combine WHERE barcode='$deliver_barcode' LIMIT 1";
				$query= $this->db->query($sql);
				if ($query->num_rows()==0)
				//if (substr($deliver_barcode,0,3)=="GO1" || substr($deliver_barcode,0,3)!="GO2") //SINGLE BARCODE
				{
					$sql="SELECT * FROM orders WHERE (barcode='$deliver_barcode' OR third_party='$deliver_barcode') LIMIT 1";
					$query= $this->db->query($sql);
					if ($query->num_rows()==1)
						{
							$row=$query->row();
							$order_id=$row->order_id;
							$created_date=$row->created_date;
							$sender=$row->sender;
							$receiver=$row->receiver;
							$barcode=$row->barcode;
							$track=$row->third_party;
							$weight=$row->weight;
							$advance=$row->advance;
							$advance_value=$row->advance_value;
							$extra=$row->extra;
							$status=$row->status;
							$admin_value=$row->admin_value;
							$proxy=$row->proxy_id;
							$proxy_type=$row->proxy_type;
							//$price=$weight*cfg_paymentrate();
							$is_online=$row->is_online;
							$Package_advance = $row ->advance;
							$Package_advance_value =$row->advance_value;
							$tr=0;
							if($status=="warehouse"&&$extra!="") 
							$temp_status=$status." ".$extra."-р тавиур";else $temp_status=$status;
							if ($Package_advance==1&&$is_online==0)
							{echo "<tr class='red' title='Үлдэгдэлтэй илгээмж:".$Package_advance_value."$' alt='order'>"; $tr=1;}
							
							if ($Package_advance==0&&$is_online==0&&$tr==0)
							{echo "<tr class='green' title='Илгээмжийг шууд олго төлбөргүй' alt='order'>"; $tr=1;}
						
							if (!$tr) echo "<tr>";else $tr=0;
							
							
							
							echo "<td>".form_checkbox("orders[]",$order_id,array("checked"=>"checked","weight"=>$weight,"advance"=>$advance_value))."</td>"; 
							echo "<td>".$count++."</td>"; 
							echo "<td>".anchor("admin/customers_detail/".$sender,substr(customer($sender,"surname"),0,2).".".customer($sender,"name"))."</td>";
							echo "<td>".anchor("admin/customers_detail/".$receiver,substr(customer($receiver,"surname"),0,2).".".customer($receiver,"name"))."<br>";
							echo customer($receiver,"tel");
							echo "<br>".proxy2($proxy,$proxy_type,"name")."</td>";
				
				
							echo "<td class='track_td'>".barcode_comfort($barcode)."<br>"; 
							echo $track."</td>";
							echo "<td>".days($created_date)."</td>"; 
							echo "<td>".$temp_status."</td>"; 
							echo "<td>".$weight."</td>"; 
							//	echo "<td>".$weight*cfg_paymentrate()."</td>"; 
							
							echo "<td>";
							if ($is_online==0) echo $Package_advance_value;
							echo "</td>"; 
							
							echo "<td>";
							if ($admin_value!=0) echo $admin_value;
							echo "</td>"; 
				
							echo "<td>".anchor('orders/detail/'.$row->order_id,'<span class="glyphicon glyphicon-edit"></span>')."</td>";
							echo "</tr>";
				
							if ($is_online==1) $total_weight+=$weight;
				
							$total_admin_value+=$admin_value;
				
							if ($is_online==0&&$Package_advance==1)
							$total_advance+=$Package_advance_value;
							
							//if ($is_online==1) $grand_total+=cfg_price($weight); else $grand_total+=$Package_advance_value;
							
							
						}
				}
			
			$sql = "SELECT *FROM box_combine WHERE barcode='$deliver_barcode' LIMIT 1";
			$query= $this->db->query($sql);
			if ($query->num_rows()==1)

			//if (substr($deliver_barcode,2,1)=="2") //COMBINE BARCODE
			{
				$sql="SELECT * FROM box_combine WHERE barcode='$deliver_barcode'";
				$query = $this->db->query($sql);
				if ($query->num_rows() == 1)
				{
					$row=$query->row();
					$barcodes = $row->barcodes;
					foreach(explode(",",$barcodes) as $barcode_single)
					{
					if ($barcode_single!="")
						$query_single  = $this->db->query("SELECT * FROM orders WHERE barcode = '$barcode_single'");						
						foreach( $query_single->result() as $data_single)
						{
						$order_id=$data_single->order_id;
						$created_date=$data_single->created_date;
						$sender=$data_single->sender;
						$receiver=$data_single->receiver;
						$barcode=$data_single->barcode;
						$track=$data_single->third_party;
						$weight=$data_single->weight;
						$advance=$data_single->advance;
						$advance_value=$data_single->advance_value;
						$extra=$data_single->extra;
						$status=$data_single->status;
						$admin_value=$data_single->admin_value;
						$proxy=$data_single->proxy_id;
						//$price=$weight*cfg_paymentrate();
						$is_online=$data_single->is_online;
						$Package_advance = $data_single ->advance;
						$Package_advance_value =$data_single->advance_value;
						$tr=0;
						if($status=="warehouse"&&$extra!="") 
						$temp_status=$status." ".$extra."-р тавиур";else $temp_status=$status;
						if ($Package_advance==1&&$is_online==0)
						{echo "<tr class='red' title='Үлдэгдэлтэй илгээмж:".$Package_advance_value."$' alt='order'>"; $tr=1;}
						
						if ($Package_advance==0&&$is_online==0&&$tr==0)
						{echo "<tr class='green' title='Илгээмжийг шууд олго төлбөргүй' alt='order'>"; $tr=1;}
					
						if (!$tr) echo "<tr>";else $tr=0;
				
				
				
						echo "<td>".form_checkbox("orders[]",$order_id,array("checked"=>"checked","weight"=>$weight,"advance"=>$advance_value))."</td>"; 
						echo "<td>".$count++."</td>"; 
						echo "<td>".anchor("admin/customers_detail/".$sender,substr(customer($sender,"surname"),0,2).".".customer($sender,"name"))."</td>";
						echo "<td>".anchor("admin/customers_detail/".$receiver,substr(customer($receiver,"surname"),0,2).".".customer($receiver,"name"))."<br>";
						echo customer($receiver,"tel");
						echo "<br>".proxy($proxy,"name")."</td>";
			
			
						echo "<td class='track_td'>".barcode_comfort($barcode)."<br>"; 
						echo $track."</td>";
						echo "<td>".days($created_date)."</td>"; 
						echo "<td>".$temp_status."</td>"; 
						echo "<td>".$weight."</td>"; 
					//	echo "<td>".$weight*cfg_paymentrate()."</td>"; 
						
						echo "<td>";
						if ($is_online==0) echo $Package_advance_value;
						echo "</td>"; 
						
						echo "<td>";
						if ($admin_value!=0) echo $admin_value;
						echo "</td>"; 
			
						echo "<td>".anchor('orders/detail/'.$order_id,'<span class="glyphicon glyphicon-edit"></span>')."</td>";
						echo "</tr>";
			
						if ($is_online==1) $total_weight+=$weight;
			
						$total_admin_value+=$admin_value;
			
						if ($is_online==0&&$Package_advance==1)
						$total_advance+=$Package_advance_value;
				
				//if ($is_online==1) $grand_total+=cfg_price($weight); else $grand_total+=$Package_advance_value;
				
				
						}
						
						
					}
				}
			}
		}
	}
		if ($total_advance==0) $grand_total = cfg_price($total_weight);
		else $grand_total =$total_advance;
	echo "<tr class='total'><td colspan='5'>Нийт жин (Kg)</td><td colspan='5'>";
	echo "<input type='text' id='total_weight' value='".number_format($total_weight,2)."' readonly='readonly' name='total_weight'></td></tr>";
	echo "<tr class='total'><td colspan='5'>Төлбөртэй илгээмж($)</td><td colspan='5'>";
	echo "<input type='text' id='total_advance' value='".number_format($total_advance,2)."' readonly='readonly' name='total_advance'></td></tr>";
	
	echo "<tr class='total'><td colspan='5'>Дараа тооцоо ($) /Хашбал/</td><td colspan='5'>";
	echo "<input type='text' id='total_admin' value='".number_format($total_admin_value,2)."' readonly='readonly' name='total_advance'></td></tr>";
	
	echo "<tr class='total'><td colspan='5'>Нийт төлбөр зохих ($)</td><td colspan='5'>";
	echo "<input type='text' id='grand_total' value='".number_format($grand_total+$total_admin_value,2)."' readonly='readonly' name='grand_total'></td></tr>";
	echo "<tr class='total'><td colspan='5'>Нийт төлбөр зохих (₮)</td><td colspan='5'>";
	echo "<input type='text' id='grand_total_tug' value='".($grand_total+$total_admin_value)*cfg_rate()."₮' readonly='readonly' name='grand_total_tug'></td></tr>";
	   }
	   
	   
	   
	   
	   
	   
	   
	    if (isset($tel))
	   {
		$sql="SELECT orders.*,orders.status AS realstatus FROM orders LEFT JOIN customer ON orders.receiver=customer.customer_id WHERE customer.tel='$tel' AND orders.status NOT IN('weight_missing')";
		$query= $this->db->query($sql);
		foreach ($query->result() as $row)
			{
			$order_id=$row->order_id;
			$created_date=$row->created_date;
			$sender=$row->sender;
			$receiver=$row->receiver;
			$barcode=$row->barcode;
			$track=$row->third_party;
			$weight=$row->weight;
			$advance=$row->advance;
			$advance_value=$row->advance_value;
			$status=$row->realstatus;
			$extra=$row->extra;
			$proxy=$row->proxy_id;
			$proxy_type=$row->proxy_type;
			//$price=$weight*cfg_paymentrate();
			$is_online=$row->is_online;
			$Package_advance = $row ->advance;
			$Package_advance_value =$row->advance_value;
			$admin_value = $row ->admin_value;
			$tr=0;
			if($status=="warehouse"&&$extra!="") 
			$temp_status=$status." ".$extra."-р тавиур";else $temp_status=$status;
			if ($Package_advance==1&&$is_online==0&&$tr==0)
			{echo "<tr class='red' title='Үлдэгдэлтэй илгээмж:".$Package_advance_value."$'>"; $tr=1;}

			if ($Package_advance==0&&$is_online==0&&$tr==0)
			{echo "<tr class='green' title='Илгээмжийг шууд олго төлбөргүй'>"; $tr=1;}
			if (!$tr) echo "<tr>";else $tr=0;

			
	  		echo "<td>".form_checkbox("orders[]",$order_id,array("checked"=>"checked"))."</td>"; 
	    	echo "<td>".$count++."</td>"; 
			echo "<td>".anchor("admin/customers_detail/".$sender,substr(customer($sender,"surname"),0,2).".".customer($sender,"name"))."</td>";
			echo "<td>".anchor("admin/customers_detail/".$receiver,substr(customer($receiver,"surname"),0,2).".".customer($receiver,"name"))."<br>";
			echo customer($receiver,"tel");
			echo "<br>".proxy2($proxy,$proxy_type,"name")."</td>";

			echo "<td>".barcode_comfort($barcode)."<br>"; 
			echo $track."</td>";
			echo "<td>".days($created_date)."</td>"; 
	   		echo "<td>".$temp_status."</td>"; 
			echo "<td>".$weight."</td>"; 
			

	   	//	echo "<td>".cfg_price($weight)."</td>"; 
	   		echo "<td>";
			if ($is_online==0) echo $Package_advance_value;
			echo "</td>"; 
			
			echo "<td>";
			if ($admin_value!=0) echo $admin_value;
			echo "</td>"; 

			echo "<td>".anchor('orders/detail/'.$row->order_id,'<span class="glyphicon glyphicon-edit"></span>')."</td>";
	   		echo "</tr>";
			
			
			
			if ($is_online==1) $total_weight+=$weight;

			if ($is_online==0&&$Package_advance==1)
			$total_advance+=$Package_advance_value;
			$total_admin_value+=$admin_value;
			//if ($is_online==1) $grand_total+=cfg_price($weight); else $grand_total+=$Package_advance_value;
			}
	if ($total_advance==0) $grand_total = cfg_price($total_weight);
		else $grand_total =$total_advance;


	echo "<tr class='total'><td colspan='5'>Нийт жин (Kg)</td><td colspan='6'>";
	echo "<input type='text' id='total_weight' value='".number_format($total_weight,2)."' readonly='readonly' name='total_weight'></td></tr>";
	echo "<tr class='total'><td colspan='5'>Төлбөртэй илгээмж($)</td><td colspan='6'>";
	echo "<input type='text' id='total_advance' value='".number_format($total_advance,2)."' readonly='readonly' name='total_advance'></td></tr>";
	
	echo "<tr class='total'><td colspan='5'>Дараа тооцоо ($) /Хашбал/</td><td colspan='6'>";
	echo "<input type='text' id='total_admin' value='".number_format($total_admin_value,2)."' readonly='readonly' name='total_advance'></td></tr>";
	
	echo "<tr class='total'><td colspan='5'>Нийт төлбөр зохих ($)</td><td colspan='6'>";
	echo "<input type='text' id='grand_total' value='".number_format($grand_total+$total_admin_value,2)."' readonly='readonly' name='grand_total'></td></tr>";
	echo "<tr class='total'><td colspan='5'>Нийт төлбөр зохих (₮)</td><td colspan='6'>";
	echo "<input type='text' id='grand_total_tug' value='".($grand_total+$total_admin_value)*cfg_rate()."₮' readonly='readonly' name='grand_total_tug'></td></tr>";

	 }

	echo "</table>";
	?>
    </div>
	</div>
    
    
    
    
    
    
    
    
    <!--button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo">Open modal for @mdo</button>
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" data-whatever="@fat">Open modal for @fat</button>
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" data-whatever="@getbootstrap">Open modal for @getbootstrap</button-->


<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="exampleModalLabel">Тооцоо бодох</h4>
      </div>
      <div class="modal-body">
          <div class="form-group">
            <label for="recipient-name" class="control-label">Тооцоо /КГ/ </label>
            <input type="text" class="form-control" id="total_weight_inmodal" readonly="readonly" value="<?=$total_weight;?>">
          </div>
          
           <div class="form-group">
            <label for="recipient-name" class="control-label">Тооцоо /USD/ </label>
            <input type="text" class="form-control" id="grand_total_inmodal" readonly="readonly"  value="<?=$grand_total;?>">
          </div>
          
		<div class="form-group">
            <label for="recipient-name" class="control-label">Дараа тооцоо /USD/ </label>
            <input type="text" class="form-control" id="total_admin_inmodal" readonly="readonly"  value="<?=$total_admin_value;?>">
          </div>
          
          
           <div class="form-group">
            <label for="recipient-name" class="control-label">Тооцоо /Төг/ </label>
            <input type="text" class="form-control" id="grand_total_inmodal_tug" readonly="readonly"  value="<?=($grand_total+$total_admin_value)*cfg_rate();?>">
          </div>
          
          <div class="form-group">
            <label for="message-text" class="control-label">Арга</label>
            
            <div class="btn-group" data-toggle="buttons">
                  <label class="btn btn-primary active ">
                    <input type="radio" name="method" id="option1" autocomplete="off" checked value="cash"> Бэлэн 
                  </label>
                  <label class="btn btn-primary ">
                    <input type="radio" name="method" id="option2" autocomplete="off" value="pos"> POS машинаар
                  </label>
                  <label class="btn btn-primary ">
                    <input type="radio" name="method" id="option3" autocomplete="off" value="account"> Дансаар
                  </label>
                  <label class="btn btn-primary ">
                    <input type="radio" name="method" id="option4" autocomplete="off" value="later"> Дараа тооцоо
                  </label>
                  <label class="btn btn-primary ">
                    <input type="radio" name="method" id="option5" autocomplete="off" value="mix"> Холимог
                  </label>
                </div>
          </div>
		<input type="text" name="cash_value" id="cash_value" placeholder="Бэлэн" value="0">
		<input type="text" name="pos_value" id="pos_value" placeholder="Картаар"  value="0">
		<input type="text" name="account_value" id="account_value" placeholder="Данс"  value="0">          
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Гүйцэтгэх</button>
      </div>
    </div>
  </div>
</div>
    
    
        
    <!--div class="panel panel-success">
      <div class="panel-heading">Хүргэлтээр гаргах мэдээлэл</div>
      <div class="panel-body"-->
	<?
	 if ($count>1) {
    /*echo "<table class='table table-hover'>";
    
    echo "<tr><td>Утас:(*)</td><td>".form_input ("contacts","",array("class"=>"form-control"))."</td></tr>";
    echo "<tr><td colspan='2'><span id='result' class='alert alert-danger alert-small' role='alert'></span></td></tr>";
    echo "<tr><td>Нэр(*)</td><td>".form_input ("name","",array("class"=>"form-control"))."</td></tr>";
    echo "<tr><td>Овог</td><td>".form_input ("surname","",array("class"=>"form-control"))."</td></tr>";
    echo "<tr><td>РД</td><td>".form_input ("rd","",array("class"=>"form-control"))."</td></tr>";
    echo "<tr><td>И-мейл(*)</td><td>".form_input ("email","",array("class"=>"form-control"))."</td></tr>";
    echo "<tr><td>Хаяг(*)</td><td>".form_textarea ("address","",array("class"=>"form-control"))."</td></tr>";
    echo "</table>";
	//if($query->num_rows()>0) echo form_submit("Олгох","Олгох",array("class"=>"btn btn-success"));
	
	 */
   	// echo '<button type="button" class="btn btn-success" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo">Хүргэлтээр гаргах</button>';
    echo '<input type="submit" class="btn btn-success" value="Хүргэлтээр гаргах">';
    echo form_close();
	}
	if ($count==1)
	redirect("admin/handover/notfound");
	?>
	<!--div>
	</div-->
    
    
    
	
	


	


