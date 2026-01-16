<div class="panel panel-default">
  <div class="panel-heading">Идэвхитэй захиалгууд</div>
  <div class="panel-body">
<? 
$customer_id = $this->session->userdata('customer_id');
$url=$_POST["url"];
$size=$_POST["size"];
$color=$_POST["color"];
$number=$_POST["number"];
$description =$_POST["description"];

if(isset($_POST["transport"])) $transport = 1; else $transport=0;




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
$html = getSslPage($url);
$title = substr($html,strpos(strtolower($html),"<title>")+7, strpos(strtolower($html),"</title>")-strpos(strtolower($html),"<title>")-7);

if ($title=="") $title=$url;
if (strpos($title,": Amazon")>0) $title = substr($title,0,strpos($title,": Amazon"));
if (strpos($title,"| eBay")>0) $title = substr($title,0,strpos($title,"| eBay"));



$data = array(
			   'url'=>$url,
			   'size'=>$size,
			   'color'=>$color,
			   'number'=>$number,
			   'created_date'=>date("Y-m-d H:i:s"),
			   'customer_id'=>$customer_id,
			   'receiver'=>$customer_id,
			   'title'=>$title,
			    'transport'=>$transport,
			 	'context'=>$description,
			   'status'=> 'online'
            );
if ($this->db->insert('online', $data))
{
	$online_id=$this->db->insert_id()  ;
	
	
		//HELP CREATE
		//if ($description!="")
		//{
		///	$data = array(
		//	   'context'=>"ONLINE UUSLEE ".anchor("admin/online","online")."<br>".$description,
		//	   'sender'=>$customer_id,
		//	   'name' =>customer($customer_id,"name"),
		//	   'tel' =>customer($customer_id,"tel"),
		//	   'email' =>customer($customer_id,"email"),
		//	   'ip' =>$_SERVER['REMOTE_ADDR']
         //   );
		//if ($this->db->insert('help', $data));
		//}
		//HELP CREATE
		
	echo '<div class="alert alert-success" role="alert">Захиалга амжилттай үүсгэлээ.</div>';

$query = $this->db->query("SELECT * FROM online WHERE online_id=".$online_id);

if ($query->num_rows() == 1)
{
	
	$row = $query->row();
	if ($row->customer_id==$customer_id)
	{
	$created_date=$row->created_date;
	$url=$row->url; 
	$size=$row->size; 
	$color=$row->color;
	$number=$row->number;
	$receiver=$row->receiver;
	$track=$row->track;
	$comment=$row->comment;
	$status=$row->status;
	
	echo "<table class='table table-hover'>";
	echo "<tr><td>Огноо</td><td>".$created_date."</td></tr>";
	echo "<tr><td>URL</td><td>".$url."</td></tr>";	
	echo "<tr><td>Тоо</td><td>".$number."</td></tr>";	
	echo "<tr><td>Хэмжээ</td><td>".$size."</td></tr>";	
	echo "<tr><td>Өнгө</td><td>".$color."</td></tr>";	
	echo "<tr><td>Төлөв</td><td>".$status."</td></tr>";
	echo "<tr><td>Хүргэлт</td><td>"; if($transport) echo "Хүргэлттэй"; else echo "Хүргэлтгүй";echo "</td></tr>";
	echo "</table>";
	
	if ($status=="online") echo anchor("customer/online_deleting","Устгах",array("class"=>"btn btn-xs btn-danger"));
	echo "&nbsp;".anchor("customer/online_create","<span class='glyphicon glyphicon-shopping-cart'></span> Сагсанд нэмэх",array("class"=>"btn btn-xs btn-primary"));
	}
	else //$row->customer_id!=$customer_id
	{echo '<div class="alert alert-danger" role="alert">Таны оруулсан захиалга биш байна.</div>';}
	
}
else //$query->num_rows() ==0
	{
	echo '<div class="alert alert-danger" role="alert">Захиалга олдсонгүй.</div>';
	}
} //$this->db->insert('online', $data)
 else echo '<div class="alert alert-danger" role="alert">Захиалга үүсгэхэд алдаа гарлаа.</div>';
?>
  </div> <!-- PANEL BODY -->
</div><!-- PANEL  -->


<?=anchor("customer/online","Бусад захиалгууд",array("class"=>"btn btn-success"));
