<script>
$(document).ready(function(e) {
    $("input[name='contact']").focus();
});
</script>

<div class="panel panel-primary">
  <div class="panel-heading">Track: Хүлээн авагч</div>
  <div class="panel-body">
<? 

if (isset($_POST["track"])) $track=$_POST["track"]; else $track="";
$track = str_replace (" ","",$track);
$track_eliminated = substr($track,-8,8);
if (isset($_POST["weight"])) $weight=$_POST["weight"]; else $weight="";

$weight=str_replace(",",".",$weight);
$weight=str_replace("Kg","",$weight);
$weight=str_replace("KG","",$weight);
$weight=str_replace("kg","",$weight);
$weight=str_replace("Кг","",$weight);
$weight=str_replace("КГ","",$weight);
$weight=str_replace("кг","",$weight);

		if ($track!="" && $weight!="")
		{
		$query = $this->db->query("SELECT * FROM orders WHERE SUBSTRING(third_party,-8,8) = '$track_eliminated' LIMIT 1");
		
		if ($query->num_rows() == 1)  // тухай barcode-н жин дутуу хэсэг
		{
		$row = $query->row();
		$order_id=$row->order_id;
		//$barcode=$row->barcode;// track № into barcode
		$third_party=$row->third_party;
		$receiver_id=$row->receiver;
		$created_date=$row->created_date;
		$status=$row->status;
		$agent_id=$this->session->userdata("agent_id");
			if ($status=="weight_missing") 
			{
			if ($receiver_id=="") $new_status="order"; else $new_status="new";
			$data = array(
			'created_date '=>date("c"),
			'weight'=>$weight,
			'advance'=>1,
			'advance_value'=>cfg_price($weight),		
			'status'=> $new_status,
			'weight'=>$weight,
			//'agents'=> $agent_id
			);
			log_write("Track inserting $order_id ".json_encode($data),"Track inserting");

			$this->db->where('order_id', $order_id);
			$this->db->update('orders', $data);
			$status=$new_status;
			if ($new_status=="new")
			echo anchor('agents/tracks_preview/'.$order_id,'CP72 print',array('target'=>"new","class"=>"btn btn-warning"));
			echo anchor('agents/tracks_mini/'.$order_id,'Mini print',array('target'=>"new","class"=>"btn btn-primary"))."<br>";
			

			}
		}
		
		if ($query->num_rows() == 0)   // хэрэглэгч тодорхойгүй ч жинг оруулан шинээр хадгалах хэсэг
		{
			$data = array(
			'created_date'=>date("c"),
			'package' =>'####################',
			'sender' => USA_OFFICE_id,
			'weight' => $weight,
			'advance' =>1,
			'advance_value' =>cfg_price($weight),
			'barcode'=> 'GO'.date("ymd").sprintf("%03d",rand(000,999)).'MN',
			'third_party' => $track,
			'status'=> 'order',
			'is_online'=> 1,
			'agents' => $this->session->userdata("agent_id"),
			'owner' => 2
			);
			
			if ($this->db->insert('orders', $data)) 
			{
			echo '<div class="alert alert-success" role="alert">Order created with weight</div>';
			$status="order";
			}
		
		}
		
	if ($status=='order') // хэрэглэгч тодорхойгүй ч жинг оруулан шинээр хадгалах хэсэг
		{
		echo '<div class="alert alert-success" role="alert">Track need it\'s receiver contact</div>';
		echo form_open('agents/tracks_checking3');
		echo form_hidden("track",$track);

		echo form_input ("contact","",array("class"=>"form-control","placeholder"=>"99123456"));
		echo form_submit("submit","add",array("class"=>"btn btn-success"));
		echo form_close();
		}
	}
	else echo '<div class="alert alert-danger" role="alert">No Weight or Barcode</div>';
?>

</div> <!-- PANEL-BODY -->
</div><!-- PANEL -->