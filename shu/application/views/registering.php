<?

echo "<div class='panel panel-default'>";

echo "<div class='panel-heading'>Хэрэглэгч бүртгүүлэх</div>";

echo "<div class='panel-body'>";

$name=$_POST["name"];

$surname=$_POST["surname"];

$contacts=$_POST["tel"];

$email=$_POST["email"];

$address=$_POST["address"];

$username=$_POST["username"];

$password=$_POST["password"];

if(isset($_POST["trigger"]))

{

	if ($name!="" && $contacts!="" && $username!="" && $password!="" && $email!="")

	{

		$sql = "SELECT * FROM customer WHERE tel='$contacts' OR username='$username' OR email='$email'";

		$query = $this->db->query($sql);

			if ($query->num_rows()==0)

			{

				$data = array(

               'name' => $name,

               'surname' => $surname,

			   'address' => $address,

			   'tel' => $contacts,

			   'username' => $username,

			   'password' => $password,

			   'email' => $email

					);

			if($this->db->insert('customer', $data)) 

			{

			$customer_id = $this->db->insert_id();
			echo '<div class="alert alert-success" role="alert">Амжилттай бүртгэлээ.</div>';
			
			$newdata = array(
				   'login'  => TRUE,
                   'customer_login'  => TRUE,
                   'customer_timestamp'     => date("Y-m-d h:i:s"),
				   'logged_name'     => $name,
                   //'agent_logged_user' => $username,
				   //'agent_logged_pass' =>md5($pass),
				   'customer_id' =>$customer_id
               );
			 $this->session->set_userdata($newdata);

			echo anchor ("customer","нэвтрэх",array("class"=>"btn btn-success"));
			

			}

			else 

			{

			echo '<div class="alert alert-danger" role="alert">Бүртгэхэд алдаа гарлаа '.$this->db->error().'.</div>';

			echo '<a href="javascript:history.go(-1)" class="btn btn-success">Буцах</a>';

			}

			}

		

		else //($query->num_rows()==0)

		{	

		echo '<div class="alert alert-danger" role="alert">Таныг өмнө нь бүртгэсэн байна та нэвтрэн орно уу.</div>';

		echo anchor("welcome/login","Нэвтрэх",array("class"=>"btn btn-primary"));

		}

	

	}

	else 

	{	

	echo '<div class="alert alert-danger" role="alert">Нэр, Утасны дугаар, Нэвтрэх нэр, Нууц үг,  и-мэйл хоосон байж болохгүй.</div>';

	echo '<a href="javascript:history.go(-1)" class="btn btn-success">Буцах</a>';

	}

}

else 

	{	

	echo '<div class="alert alert-danger" role="alert">Гэрээг зөвшөөрөх шаардлагатай.</div>';

	echo '<a href="javascript:history.go(-1)" class="btn btn-success">Буцах</a>';

	}



echo "</div>"; //panel body

echo "</div>";  //panel



?>