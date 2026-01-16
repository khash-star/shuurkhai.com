<a href="<?=base_url();?>index.php/welcome/faqs" class="btn btn-primary">Түгээмэл асуултууд</a>
<div class="clearfix"></div><br />
 <div class="panel panel-primary">
    <div class="panel-heading">Тусламж</div>
      <div class="panel-body">
<? 
	$customer_id = $this->session->userdata('customer_id');
	$context =$_POST["context"];
	if($context!="")
	{
	if ($customer_id!="")
	{
		$data = array(
			   'context'=>$context,
			   'sender'=>$customer_id,
			   'name' =>customer($customer_id,"name"),
			   'tel' =>customer($customer_id,"tel"),
			   'email' =>customer($customer_id,"email"),
			   'ip' =>$_SERVER['REMOTE_ADDR']
            );
	}
	else 
	{	$data = array(
			   'context'=>$context,
			   'sender'=>"",
				'name' =>$_POST["name"],
			   'tel' =>$_POST["tel"],
			   'email' =>$_POST["email"],
			    'ip' =>$_SERVER['REMOTE_ADDR']
            );
	}
	
	if ($this->db->insert('help', $data))
	echo '<div class="alert alert-success" role="alert">
  	<span class="glyphicon glyphicon-ok-circle"></span>Амжилттай хүлээн авлаа. Бид даруй хариу мэдэгдэх болно.</div>';
	else
	echo '<div class="alert alert-danger" role="alert">
  	<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
  	</span>Алдаа:'.$this->db->error().'</div>';
	}
	else 
	{
	echo '<div class="alert alert-danger" role="alert">
  	<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
  	</span>Тусламж хэсгийг хоосон орхиж болохгүй.</div>';
	echo anchor ("welcome/help","Буцах",array("class"=>"btn btn-warning"));
	}
	

?>
</div>
</div>

