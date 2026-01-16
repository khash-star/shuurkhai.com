<? 
require_once('assets/PHP_XLSXWriter/xlsxwriter.class.php');

$sql="SELECT * FROM boxes WHERE status NOT IN ('warehouse','delivered') ORDER BY created_date DESC";

$query = $this->db->query($sql);

	$cumulative_weight=0;
	$cumulative_packages = 0;

if ($query->num_rows() > 0)
{
	//echo form_open("admin/boxes_changing");
	$data_excel = array(array('№','Box нэр','Тоо','Овог','Нэр','Хаяг','Утас','Үүсгэсэн','Branch','Овог','Нэр','Хаяг','Утас','Төлөв','Жин','Нэгтгэсэн','Дэлгэрэнгүй','Баталгаажсан','Үнэлгээ'));


	   $count_box=1;
	   foreach ($query->result() as $row)
	   {

		$box_id= $row->box_id;
		$name= $row->name;
// 		$surname= $row->surname;
		$created_date =$row->created_date;
		$status= $row->status;
		$weight=$row->weight;
	  	//$packages=box_inside($box_id,"packages");
		$packages=$row->packages;

		//echo "box_id:".$box_id."<br>";
	  
	   $cumulative_packages+=$packages;
	   $cumulative_weight+=$weight;
	   
	   array_push($data_excel,array($count_box,$name,$packages,"","","","",$created_date,"","","","",$status,$weight,"","","",""));
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
								  	if ($query_order->is_branch) $is_branch="DE"; else $is_branch="";
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
		   
						
						$r_name= customer($receiver,"name");
						$r_surname= customer($receiver,"surname");
						$r_tel= customer($receiver,"tel");
						$r_address= customer($receiver,"address");
		  
						$p_name= proxy2($proxy,$proxy_type,"name");
						$p_surname= proxy2($proxy,$proxy_type,"surname");
						$p_tel= proxy2($proxy,$proxy_type,"tel");
						$p_address= proxy2($proxy,$proxy_type,"address");
						
						$s_name= customer($sender,"name");
						$s_surname= customer($sender,"surname");
						$s_tel= customer($sender,"tel");
						$s_address= customer($sender,"address");
						
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
							if(substr($packages_array[$i*3+2],-1)=='$') $total_price +=intval(substr($packages_array[$i*3+2],0,strlen($packages_array[$i*3+2])-1));
							else $total_price +=intval($packages_array[$i*3+2]);
							
						}
						
						
						$total_weight+=floatval($weight_sigle);
						if ($proxy!=0)
							$data_single = array ("","","",$s_surname,$s_name,$s_address,$s_tel,$barcode,$is_branch,$p_surname,$p_name,$p_address,$p_tel,$status_single,$weight_sigle,$combine,$pack_names,$total_price,$date);
							else 
							$data_single = array ("","","",$s_surname,$s_name,$s_address,$s_tel,$barcode,$is_branch,$r_surname,$r_name,$r_address,$r_tel,$status_single,$weight_sigle,$combine,$pack_names,$total_price,$date);
							
						array_push($data_excel,$data_single);
						$count++;
				}
			}
			///inside
	}
	array_push($data_excel,array("","",$cumulative_packages,"","","","","","","","","","","","",$cumulative_weight,"",""));
	$writer = new XLSXWriter();
	$writer->writeSheet($data_excel);
	$writer->writeToFile('assets/xlsx/boxes_all.xlsx');
			
			
}
	

	

	redirect('admin/boxes');
	?>
