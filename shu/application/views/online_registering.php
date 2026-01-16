

<div class="panel panel-default">
  <div class="panel-heading">Бүртгэл</div>
  <div class="panel-body">
<? 	
function getSslPage($url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_REFERER, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
}

	$sql2 = "SELECT customer_id,name,password FROM customer WHERE tel='".$_POST["contact"]."' LIMIT 1";
	$query2 = $this->db->query($sql2);
	if ($query2->num_rows() == 1)
	{
		$row2 = $query2->row();
		$html = getSslPage($_POST["url"]);
		$title = substr($html,strpos(strtolower($html),"<title>")+7, strpos(strtolower($html),"</title>")-strpos(strtolower($html),"<title>")-7);
		
		if ($title!="") $title=$_POST["url"];
		/*if ($row2->password==$_POST["password"])
			{
				$newdata = array(
				   'login'  => TRUE,
                   'customer_login'  => TRUE,
                   'customer_timestamp'     => date("Y-m-d h:i:s"),
				   'logged_name'     => $row2->customer_id,
				   'customer_id' =>$row2->customer_id
               	);
				$this->session->set_userdata($newdata);
		*/		
				$data = array(
			   'url'=>$_POST["url"],
			   'size'=>$_POST["size"],
			   'color'=>$_POST["color"],
			   'number'=>$_POST["number"],
			   'context'=>$_POST["description"],
			   'created_date'=>date("Y-m-d H:i:s"),
			   'customer_id'=>$row2->customer_id,
			   'receiver'=>$row2->customer_id,
			   'title'=>$title,
			    'transport'=>0,
			   'status'=> 'online'
           		 );
				 if ($this->db->insert('online', $data))
				 echo "Амжилттай бүртгэлээ.";//Та өөрийн оруулсан хаягийг ".anchor("customer/online","Энд")." дарж харах боломжтой.";
				else echo $this->db->error();
			//	}
			
		//	else  echo "Нууц буруу ".anchor("welcome","Энд")." дарж ахин оролдоно уу.";
	}
	else echo "Бүртгэл олдсонгүй.".anchor("welcome/register","Энд")." дарж ахин оролдоно уу.";

?>
<br />


  </div> <!-- PANEL BODY -->
</div><!-- PANEL  -->


<!--a href="<? //base_url();?>index.php/welcome/faqs" class="btn btn-warning">Түгээмэл асуултууд</a>

<a href="<? //base_url();?>index.php/welcome/tutor" class="btn btn-warning">Заавар</a-->