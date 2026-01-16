<div class="panel panel-default">
  <div class="panel-heading">Бүртгэлийг баталгаажуулах</div>
  <div class="panel-body">
<? 	
	$contact= $_POST["contact"];
	$password= $_POST["password"];
	$name= $_POST["name"];
	$address= $_POST["address"];

		$sql = "SELECT * FROM customer WHERE tel='$contact'";

		$query = $this->db->query($sql);

			if ($query->num_rows()==0)

			{
			$data = array(
               'name' => $name,
			   'address' => $address,
			   'tel' => $contact,
			   'username' => $contact,
			   'password' => $password
			   );

				if($this->db->insert('customer', $data)) 
				{
				$customer_id = $this->db->insert_id();
				
				$newdata = array(
				   'login'  => TRUE,
                   'customer_login'  => TRUE,
                   'customer_timestamp'     => date("Y-m-d h:i:s"),
				   'logged_name'     => $customer_id,
				   'customer_id' =>$customer_id
               	);
				$this->session->set_userdata($newdata);
				
				
				$data = array(
			   'url'=>$_POST["url"],
			   'size'=>$_POST["size"],
			   'color'=>$_POST["color"],
			   'number'=>$_POST["number"],
			   'created_date'=>date("Y-m-d H:i:s"),
			   'customer_id'=>$customer_id,
			   'receiver'=>$customer_id,
			   'title'=>$_POST["description"],
			    'transport'=>0,
			   'status'=> 'online'
           		 );
				 if ($this->db->insert('online', $data))
				 {
					 echo "Амжилттай бүртгэлээ. Та өөрийн оруулсан хаягийг ".anchor("customer/online","Энд")." дарж харах боломжтой.";
				 }
				 else echo $this->db->error();
				}
			}
			
				
?>

  </div> <!-- PANEL BODY -->
</div><!-- PANEL  -->


<!--a href="<? //base_url();?>index.php/welcome/faqs" class="btn btn-warning">Түгээмэл асуултууд</a>

<a href="<? //base_url();?>index.php/welcome/tutor" class="btn btn-warning">Заавар</a-->