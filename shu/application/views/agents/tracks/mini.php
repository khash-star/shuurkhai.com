<? if ($this->uri->segment(3)) $order_id=$this->uri->segment(3); else exit();

require_once('assets/class/BCGFontFile.php');
require_once('assets/class/BCGDrawing.php');
require_once('assets/class/BCGcode128.barcode.php');
require_once("barcode_writer.php");

header('Content-Type: image/png');

$query = $this->db->query("SELECT * FROM orders WHERE order_id=".$order_id);

if ($query->num_rows() == 1)
{
   $row = $query->row();
   		$created_date=$row->created_date;
		$order_id=$row->order_id;
		$barcode=$row->barcode;
		$status=$row->status;
		$receiver=$row->receiver;
		$third_party=$row->third_party;
		
	//CLEAR PROXY
	$this->db->query ("UPDATE orders SET proxy_id='0' WHERE order_id=".$order_id);
	//CLEAR PROXY
		//$proxy=$row->proxy_id;
   
		//RECIEVER
		$receiver_name=customer($receiver,"full_name");
		$receiver_contact=customer($receiver,"tel");
		$receiver_address=customer($receiver,"address");
	barcode_generate($barcode);


	ini_set('memory_limit', '-1');
	$font='assets/fonts/Arial.ttf';
	$font_size=15;
    //$cp72Path ='assets/images/cp72.jpg';
    $image = imagecreate (800 , 200 );
	$white = imagecolorallocate($image, 255, 255, 255);
	imagefill($image, 0, 0, $white);
    $color = imagecolorallocate($image, 0, 0, 0);
	$barcode_image_source = imagecreatefromjpeg('barcode_temp.jpg');
	//$logo_image_source = imagecreatefromjpeg('assets/images/logo.jpg');
	
	
	imagettftext($image,$font_size,0,20,140,$color,$font,$receiver_name);
	imagettftext($image,$font_size,0,20,160,$color,$font,$receiver_contact);
	//if ($proxy!="") imagettftext($image,$font_size+10,0,20,60,$color,$font,proxy($proxy,'name'));
	//if ($proxy!="") imagettftext($image,$font_size+10,0,20,100,$color,$font,proxy($proxy,'tel'));

	
	imagettftext($image,$font_size,0,400,60,$color,$font,"Track: ".$third_party);

	imagecopymerge($image, $barcode_image_source, 400, 100, 0,0,334, 63,100);
	

 	imagejpeg($image);
	
   }
  ?>