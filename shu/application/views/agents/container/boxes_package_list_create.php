<? 
require_once('assets/PHP_XLSXWriter/xlsxwriter.class.php');
//echo ":asdadasdas";
//$sql="SELECT * FROM boxes WHERE status NOT IN ('warehouse','delivered') ORDER BY created_date DESC";
$sql="SELECT * FROM boxes WHERE status IN ('new')";

$query = $this->db->query($sql);

	$cumulative_weight=0;
	$cumulative_packages = 0;

if ($query->num_rows() > 0)
{
	//echo form_open("admin/boxes_changing");
	$data_excel = array(array('№','Овог','Нэг','Тоо','Овог','Нэр','Хаяг','Утас','Үүсгэсэн','Овог','Нэр','Хаяг','Утас','Төлөв','Жин','Нэгтгэсэн','Дэлгэрэнгүй','Баталгаажсан','Үнэлгээ'));


	   $count_box=1;
	   foreach ($query->result() as $row)
	   {

		$box_id= $row->box_id;
		//$name= $row->name;
		//$surname= $row->surname;
		$created_date =$row->created_date;
		$status= $row->status;
		$weight=$row->weight;
	  	//$packages=box_inside($box_id,"packages");
		$packages=$row->packages;

		//echo "box_id:".$box_id."<br>";
	  
	   $cumulative_packages+=$packages;
	   $cumulative_weight+=$weight;
	   
	   array_push($data_excel,array($count_box,"","",$packages,"","","","",$created_date,"","","",$status,$weight,"","","",""));
		$count_box ++;
		
			///inside 
			
			$query_packages = $this->db->query("SELECT * FROM boxes_packages WHERE box_id=".$box_id);
			$total_weight=0;
			if ($query_packages->num_rows() > 0)
			{
				$count=1;
				foreach ($query_packages->result() as $row_package)
				{ 
					$barcode=$row_package->barcode;
					$weight_sigle=$row_package->weight;
					$combine=$row_package->combined;
					$order_id=$row_package->order_id;
					$receiver =0;
					$proxy =0;
					$sender =0;
					echo $barcode;

					   if ($order_id!=0)
					   	{
						   $query_order = $this->db->query("SELECT * FROM orders WHERE order_id=".$order_id);
						   if ($query_order->num_rows()==1)
						   	   {
							   	   	//echo "single";
								   $query_order=$query_order->row();
								   $status=$query_order->status;
								   $receiver = $query_order->receiver;
								   $proxy= $query_order->proxy_id;
								   $proxy_type= $query_order->proxy_type;
								   $status_single=$query_order->status;
								   $packages=$query_order->package;
								   $sender = $query_order->sender;
								   $date =substr($query_order->created_date,0,10);
							   }
							  // else echo "deleted";
						}
						   else 
						   	{
							   	//	echo "combine";
							   $query_combine = $this->db->query("SELECT * FROM box_combine WHERE barcode='".$barcode."'");
							   $combine_row=$query_combine->row();
							   $status=$combine_row->status;
							   $receiver = $combine_row->receiver;
							   $proxy= $combine_row->proxy_id;
							   $status_single=$combine_row->status;
							   $packages=$combine_row->package;
							   $sender = $combine_row->sender;
							   $date=substr($combine_row->created_date,0,10);
							}
		   
						
						$rrrr= customer($receiver,"||");
						echo $rrrr;
						$receiver_explode = explode($rrrr,"||");
						$r_name= $r_name = $r_tel = $r_email = $r_address ="";
						if (count($receiver_explode)>0)
						{
						$r_name = $receiver_explode[0];
						$r_surname = $receiver_explode[1];
						$r_tel = $receiver_explode[2];
						$r_email = $receiver_explode[3];
						$r_address = $receiver_explode[4];
						}
						// $r_surname= customer($receiver,"surname");
						// $r_tel= customer($receiver,"tel");
						// $r_address= customer($receiver,"address");
		  
						// $p_name= proxy2($proxy,$proxy_type,"name");
						// $p_surname= proxy2($proxy,$proxy_type,"surname");
						// $p_tel= proxy2($proxy,$proxy_type,"tel");
						// $p_address= proxy2($proxy,$proxy_type,"address");
						echo $ssss;
						$ssss= customer($sender,"||");
						$sender_explode = explode($ssss,"||");
						$s_name= $s_name = $s_tel = $s_email = $s_address ="";
						if (count($sender_explode)>0)
						{
						$s_name = $sender_explode[0];
						$s_surname = $sender_explode[1];
						$s_tel = $sender_explode[2];
						$s_email = $sender_explode[3];
						$s_address = $sender_explode[4];
						}
						
						// $s_surname= customer($sender,"surname");
						// $s_tel= customer($sender,"tel");
						// $s_address= customer($sender,"address");
						
						//$packages_array=explode("##",$packages);

						$packages = str_replace("########","##",$packages);
						$packages = str_replace("######","##",$packages);
						$packages_array = explode("##",$packages);
						$total_price = 0; 
						$pack_names = "";
						$items = floor(count($packages_array)/3);
						for($i=0;$i<$items; $i++)
						{
							$pack_names.=$packages_array[$i*3].",";
							if(substr($packages_array[$i*3+2],-1)=='$') $total_price +=substr($packages_array[$i*3+2],0,strlen($packages_array[$i*3+2])-1);
							else $total_price +=$packages_array[$i*3+2];
							
						}
						
						
						$total_weight+=$weight_sigle;
						if ($proxy!=0)
							$data_single = array ("","","","",$s_surname,$s_name,$s_address,$s_tel,$barcode,$p_surname,$p_name,$p_address,$p_tel,$status_single,$weight_sigle,$combine,$pack_names,$total_price,$date);
							else 
							$data_single = array ("","","","",$s_surname,$s_name,$s_address,$s_tel,$barcode,$r_surname,$r_name,$r_address,$r_tel,$status_single,$weight_sigle,$combine,$pack_names,$total_price,$date);
							
						array_push($data_excel,$data_single);
						$count++;
				}
			}
			///inside
	}
	array_push($data_excel,array("","",$cumulative_packages,"","","","","","","","","","","","",$cumulative_weight,"",""));
	$writer = new XLSXWriter();
	$writer->writeSheet($data_excel);
	$writer->writeToFile('assets/xlsx/boxes_package.xlsx');
			
			
}
	

	

	redirect('agents/boxes');
	?>
