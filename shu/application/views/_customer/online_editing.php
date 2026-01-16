<div class="panel panel-default">
  <div class="panel-heading">Идэвхитэй захиалгууд</div>
  <div class="panel-body">
<? 
$customer_id = $this->session->userdata('customer_id');
$online_id=$_POST["online_id"];
$url=$_POST["url"];
$size=$_POST["size"];
$color=$_POST["color"];
$number=$_POST["number"];
$description =$_POST["description"];

$query = $this->db->query("SELECT * FROM online WHERE online_id=".$online_id);

if ($query->num_rows() == 1)
{
	$row = $query->row();
	if ($row->customer_id==$customer_id)
	{
		$data = array(
		 		'url'=>$url,
			   'size'=>$size,
			   'color'=>$color,
			   'number'=>$number,
			    'transport'=>$transport,
			 	'context'=>$description
            );
		$this->db->where('online_id', $online_id);
		if ($this->db->update('online', $data)) 
		echo '<div class="alert alert-success" role="alert">Захиалга амжилттай заслаа.</div>';
		else 
	 	echo '<div class="alert alert-danger" role="alert">Захиалга засахад алдаа гарлаа.</div>';
	}
	else //$row->customer_id!=$customer_id
	echo '<div class="alert alert-danger" role="alert">Таны оруулсан захиалга биш байна.</div>';
}
else echo '<div class="alert alert-danger" role="alert">Захиалга олдсонгүй.</div>';
	
		
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
	echo "</table>";
	
	if ($status=="online") echo anchor("customer/online_edit/".$online_id,"Засах",array("class"=>"btn btn-xs btn-warning"));
	
	if ($status=="online") echo "&nbsp;".anchor("customer/online_deleting","Устгах",array("class"=>"btn btn-xs btn-danger"));
	echo "&nbsp;".anchor("customer/online_create","Ахин нэмэх",array("class"=>"btn btn-xs btn-primary"));
	}
	else //$row->customer_id!=$customer_id
	{echo '<div class="alert alert-danger" role="alert">Таны оруулсан захиалга биш байна.</div>';}
	
}
else //$query->num_rows() ==0
	{
	echo '<div class="alert alert-danger" role="alert">Захиалга олдсонгүй.</div>';
	}
?>
  </div> <!-- PANEL BODY -->
</div><!-- PANEL  -->


<?=anchor("customer/online","Бусад захиалгууд",array("class"=>"btn btn-success"));?>




			 <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
                <script type="text/javascript" src="<?=base_url();?>assets/js/bootstrap.min.js"></script>
                <script type="text/javascript">
				$(window).load(function(){
					$('#alert_modal').modal('show');
				});
				</script>
                <div class="modal fade" tabindex="-1" role="dialog" id="alert_modal">
                  <div class="modal-dialog modal-sm" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h3 class="modal-title text-left" style="color:#F00;">Анхааруулга</h3>
                      </div>
                      <div class="modal-body text-left text-big" style="color:#000;">
                        <p>Онлайн захиалгыг засахад бодсон үнэ өөрчлөгдөх учир үнийг ахин бодно.</p>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Хаах</button>
                      </div>
                    </div><!-- /.modal-content -->
                  </div><!-- /.modal-dialog -->
                </div><!-- /.modal -->
