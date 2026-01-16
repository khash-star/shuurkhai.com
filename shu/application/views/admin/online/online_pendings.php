<div class="panel panel-default">
  <div class="panel-heading">Pendings захиалгууд</div>
  <div class="panel-body">
<?
if(isset($_POST["search"])) 
	{
	$search_term=str_replace(" ","%",$_POST["search"]);
	echo "Xайлт:".$search_term."<br>";
	} 
	else $search_term = "";

$sql="SELECT online.customer_id, SUM(price) AS total_price, SUM(tax) AS total_tax, SUM(shipping) AS total_shipping, SUM(owe) AS total_owe, COUNT(customer_id) AS count FROM online";
$sql.=" WHERE status='pending'";
$sql.=" GROUP by customer_id ORDER BY created_date DESC";

$query = $this->db->query($sql);
if ($query->num_rows() > 0)
{
	echo "<table class='table table-striped'>";
	
	echo "<tr><th>№</th><th>Нэр</th><th>Мейл</th><th>Утас</th><th>Үнэ</th><th width='130'>Үйлдэл</th></tr>";
	$j=$query->num_rows();
	foreach ($query->result() as $row)
	{  
	$receiver=$row->customer_id;	
	
	echo "<tr>";
	echo "<td>".$j--."</td>";
	echo "<td>";
	echo anchor("admin/customers_detail/".$receiver,substr(customer($receiver,"surname"),0,2).".".customer($receiver,"name"));
	echo "</td>";
	echo "<td>";
	if (customer($receiver,"email")!="") 
	echo mailto(customer($receiver,"email"), ' <span class="glyphicon glyphicon-envelope"></span>');
	echo "</td>";
	echo "<td>";
	echo customer($receiver,"tel")."</td>";	
	echo "<td>";
		echo '<span style="color:#000; font-weight:bold;">Нийт online: '.$row->count.'ш</span><br>';
		echo '<span style="color:#F00; font-weight:bold;">Үнэ: '.number_format($row->total_price,2).'$</span><br>';
		echo '<span style="color:#1079b2; font-weight:bold;">Tax: '.number_format($row->total_tax,2).'$</span><br>';
		echo '<span style="color:#f0861b; font-weight:bold;">Shipping: '.number_format($row->total_shipping,2).'$</span>';

		echo '<span style="color:#f08777; font-weight:bold;">Owe: '.number_format($row->total_owe,2).'$</span>';


	echo "</td>";
	
	echo "<td>";
		 echo ("<a class='btn btn-xs btn-primary btn-shuurkhai' role='button' data-toggle='collapse' href='#".$receiver."' aria-expanded='false' aria-controls='collapseExample'><span class='glyphicon glyphicon-th-list'></span> дэлгэх</a>");
	echo "</td>";

	echo "</tr>";	
	echo '<tr class="collapse" id="'.$receiver.'"><td colspan="6">';
	
	$sql_online="SELECT * FROM online";
	$sql_online.=" WHERE status='pending' AND customer_id='".$receiver."'";
	$sql_online.=" ORDER BY created_date DESC";
	
	$query_single = $this->db->query($sql_online);
	if ($query_single->num_rows() > 0)
	{
		echo "<table class='table table-striped'>";
		
		echo "<tr><th>№</th><th>Үүсгэсэн</th><th>Үнэ</th><th>Коммент</th><th>Төлөв</th><th width='130'>Үйлдэл</th></tr>";
		$i=$query_single->num_rows();
		foreach ($query_single->result() as $row_single)
		{  
		$created_date=$row_single->created_date;
		$online_id=$row_single->online_id;
		$url=$row_single->url; 
		$size=$row_single->size; 
		$color=$row_single->color;
		$number=$row_single->number;
		$track=$row_single->track;
		$comment=$row_single->comment;
		$price=$row_single->price;
		$tax=$row_single->tax;
		$shipping=$row_single->shipping;
		$status=$row_single->status;
		$transport= $row_single->transport;
		
		
		echo "<tr>";
		echo "<td>".$i--."</td>";
		echo "<td>".substr($created_date,0,10);
		if ($transport) echo "<br><span class='glyphicon glyphicon-home' title='Улаанбаатарт хүргэлттэй'></span> Хүргэлттэй"; 
	
		echo "</td>";
		
		echo "<td>".anchor($url,substr($url,0,20),array("target"=>"_blank")).".......<br>";	
		echo $number."/".$size."/".$color."<br>";
		echo '<span style="color:#F00; font-weight:bold;">Үнэ: '.$price.'$</span><br>';
		echo '<span style="color:#1079b2; font-weight:bold;">Tax: '.$tax.'$</span><br>';
		echo '<span style="color:#f0861b; font-weight:bold;">Shipping: '.$shipping.'$</span>';
		echo "<td>".$comment."</td>";	
		echo "<td>".status_comfort($status)."</td>";
	
		echo "<td>";
			echo  anchor('admin/online_price/'.$online_id,'<span class="glyphicon glyphicon-usd"></span> Үнэ',array('title'=>$comment,"class"=>"btn btn-xs btn-primary btn-shuurkhai"));
			echo "<br>";
			echo  anchor('admin/online_comment/'.$online_id,'<span class="glyphicon glyphicon-comment"></span> Бичих',array('title'=>$comment,"class"=>"btn btn-xs btn-primary btn-shuurkhai"));
			echo "<br>";
			echo anchor('admin/online_renew/'.$online_id,'<span class="glyphicon glyphicon-transfer"></span> Захиалга',array('title'=>"Make it order!","class"=>"btn btn-xs btn-success btn-shuurkhai"));
			echo"<br>";
			echo anchor('admin/online_pending/'.$online_id,'<span class="glyphicon glyphicon-refresh"></span> Unpending',array('title'=>"Track  Unpending!","class"=>"btn btn-xs btn-success btn-shuurkhai"));
			echo"<br>";
			echo anchor('admin/online_track_renew/'.$online_id,'<span class="glyphicon glyphicon-transfer"></span> Track',array('title'=>"Only Give Track!","class"=>"btn btn-xs btn-warning btn-shuurkhai"));
			echo "<br>";
			echo anchor('admin/online_delete/'.$online_id,'<span class="glyphicon glyphicon-trash"></span> Устгах',array('title'=>"Устгах","class"=>"btn btn-xs btn-danger btn-shuurkhai")); 
	
		echo "</td>";
	
		echo "</tr>";	
		}
		echo "</table>";
	}
			
			
	echo '</td></tr>';
	}
	echo "</table>";
}
else //$query->num_rows() ==0
{
echo '<div class="alert alert-danger" role="alert">Захиалга олдсонгүй.</div>';
}
?>
  </div> <!-- PANEL BODY -->
</div><!-- PANEL  -->