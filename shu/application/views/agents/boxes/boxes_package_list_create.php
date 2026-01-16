<? 
require_once('assets/PHP_XLSXWriter/xlsxwriter.class.php');

$sql="SELECT * FROM boxes WHERE status IN ('new') ORDER BY created_date DESC";

$query = $this->db->query($sql);

	$cumulative_weight=0;
	$cumulative_packages = 0;
    $cumulative_price = 0;

if ($query->num_rows() > 0)
{
	//echo form_open("admin/boxes_changing");
	$data_excel = array(array('№','Package','Surname','Firstname','Tel','Items','Quantity','Price $','Total Price $'));


	   $count_box=1;
	   foreach ($query->result() as $row)
	   {

		$box_id= $row->box_id;
		$name= $row->name;
		$surname= $row->surname;
		$created_date =$row->created_date;
		$status= $row->status;
		$weight=$row->weight;
	  	//$packages=box_inside($box_id,"packages");
		$packages=$row->packages;

		//echo "box_id:".$box_id."<br>";
	  
	   $cumulative_packages+=$packages;
	   $cumulative_weight+=$weight;

	   array_push($data_excel,array($count_box,$name,"","","","","","",""));
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
						$data_single = array ("","",customer($receiver,"surname"),customer($receiver,"name"),customer($receiver,"tel"),$pack_names,1,$total_price,$total_price);
                        $cumulative_price+=$total_price;

						array_push($data_excel,$data_single);
						$count++;
				}
			}
			///inside
	}
	array_push($data_excel,array("","","","","","",$cumulative_packages,"",$cumulative_price));
	$writer = new XLSXWriter();
	$writer->writeSheet($data_excel);
	$writer->writeToFile('assets/xlsx/boxes_package.xlsx');
			
			
}
	

	

	redirect('agents/boxes');
	?>
