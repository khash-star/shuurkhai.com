<?  $customer_id=$_POST["customer_id"]; ?>
<div class="panel panel-primary">
  <div class="panel-heading">Хэрэглэгчийн удирдлагын хэсэг</div>
  <div class="panel-body">
<? 
$query = $this->db->query("SELECT * FROM customer WHERE customer_id=".$customer_id);

if ($query->num_rows() == 1)
{
	$row = $query->row();
	$name=$row->name;
	$surname=$row->surname; 
	$rd=$row->rd; 
	$contacts=$row->tel;
	$address=$row->address;
	$username=$row->username;
	$password=$row->password;
	$email=$row->email;
	echo "<table class='table table-hover'>";
	echo "<tr><td>Нэр</td><td>".$name."</td></tr>";	
	echo "<tr><td>Овог</td><td>".$surname."</td></tr>";
	echo "<tr><td>РД</td><td>".$rd."</td></tr>";
	echo "<tr><td>Утас</td><td>".$contacts."</td></tr>";	
	echo "<tr><td>Э-мэйл</td><td>".$email."</td></tr>";
	echo "<tr><td>Хаяг</td><td>".$address."</td></tr>";	
	echo "</table>";
	echo anchor('admin/customers_edit/'.$row->customer_id,'Мэдээлэллийг засах',array("class"=>"btn btn-primary"));
}
?>

</div>
</div>

<div class="panel panel-primary">
  <div class="panel-heading">Proxy importing</div>
  <div class="panel-body">
<? 
$file_name="proxy.xlsx";
//$allowedExts = array("xlsx");
//$extension = end(explode(".", $_FILES["xlsx_file"]["name"]));
if ($_FILES["xlsx_file"]["size"] < 2662144)
  {
  if ($_FILES["xlsx_file"]["error"] > 0)
    {
    echo "Return Code: " . $_FILES["xlsx_file"]["error"] . "<br />";
    }
  else
    {
    if (file_exists("assets/uploads/" .$file_name))
      {
      echo $file_name . " already exists. <br>";
	  unlink("assets/uploads/" .$file_name);
      }
    else
      {
      move_uploaded_file($_FILES["xlsx_file"]["tmp_name"],"assets/uploads/" . $file_name);
      echo "assets/uploads/" . $file_name." copied.<br>";
      }
    }
  }
else
  {
  echo "Invalid file<br>";
  }
  
  if (file_exists("assets/uploads/" .$file_name))
  {
// $this->load->view('customers/Classes/PHPExcel/IOFactory.php');
	require_once('assets/Classes/PHPExcel/IOFactory.php');

 $inputFileName = 'assets/uploads/'.$file_name;  // File to read
 $objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
 $aSheet =$objPHPExcel->getActiveSheet();
 $rows = $aSheet->getHighestRow();
 $success_import=0;
 echo "<table class='table table-hover'>";
  echo "<tr>";
  echo "<th>Нэр</th>"; 
  echo "<th>Овог</th>"; 
  echo "<th>Утас</th>"; 
  echo "<th>Хаяг</th>"; 
  echo "</tr>";
 for ($i=1; $i<=$rows; $i++)
  {
 	$name = $aSheet->getCell("A".$i)->getValue();
	$surname = $aSheet->getCell("B".$i)->getValue();
	$tel = $aSheet->getCell("C".$i)->getValue();
	$address = $aSheet->getCell("D".$i)->getValue();
  echo "<tr>";
  echo "<td>".$name."</td>"; 
  echo "<td>".$surname."</td>"; 
  echo "<td>".$tel."</td>"; 
  echo "<td>".$address."</td>"; 
  echo "</tr>";
  if($name!="" && $surname!="" && $tel!="" && $address!="")
  {
  if ($this->db->query("SELECT tel FROM customer WHERE tel='".$tel."'")->num_rows()==0)
  {
	  $data = array(
	  				'customer_id'=>$customer_id,
				   'name' => $name,
				   'surname' => $surname,
				   'tel' => $tel,
				   'address' => $address
				);		
	  if($this->db->insert('proxies', $data)) $success_import++;
	  else echo mysql_error();
  }
  else echo "Proxy already on customer";
  }
  else echo "Empty";
  }
  echo "</table>";
  echo "Импортлох ". ($rows - 1) ." бичлэг олдсоноос ".$success_import." амжилттай орууллаа";
  unlink("assets/uploads/" .$file_name);
  } 
  else echo "assets/uploads/" .$file_name." missing<br>";
?>
</div>
<div id="clear"></div>
</div>

<?=anchor("admin/customers_proxy/".$customer_id,"Бүх proxy",array("class"=>"btn btn-primary")); ?>