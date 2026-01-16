<div class="panel panel-primary">
  <div class="panel-heading">Shuurkhai.Com</div>
  <div class="panel-body">
<? 
$file_name="customers.xlsx";
$allowedExts = array("xlsx");
$path = $_FILES['xlsx_file']['name'];
$extension = pathinfo($path, PATHINFO_EXTENSION);
if (file_exists("assets/uploads/".$file_name)) unlink ("assets/uploads/".$file_name);
if ($_FILES["xlsx_file"]["size"] < 2662144
&& in_array($extension, $allowedExts))
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
      echo "File copied.<br>";
      }
    }
  }
else
  {
  echo "Invalid file<br>";
  }
  
  if (file_exists("assets/uploads/" .$file_name))
  {
	require_once('assets/Classes/PHPExcel/IOFactory.php');

 //$this->load->view(base_url('assets/Classes/PHPExcel/IOFactory.php'));
 $inputFileName = 'assets/uploads/'.$file_name;  // File to read
 $objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
// $objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
 $aSheet =$objPHPExcel->getActiveSheet();
 $rows = $aSheet->getHighestRow();
 $success_import=0;
 echo "<table class='table table-hover'>";
  echo "<tr>";
  echo "<th>".$aSheet->getCell("A1")->getValue()."</th>"; 
  echo "<th>".$aSheet->getCell("B1")->getValue()."</th>"; 
  echo "<th>".$aSheet->getCell("C1")->getValue()."</th>"; 
  echo "<th>".$aSheet->getCell("D1")->getValue()."</th>"; 
  echo "<th>".$aSheet->getCell("E1")->getValue()."</th>"; 
  echo "<th>".$aSheet->getCell("F1")->getValue()."</th>"; 
  echo "</tr>";
 for ($i=2; $i<=$rows; $i++)
  {
  echo "<tr>";
  echo "<td>".$aSheet->getCell("A".$i)->getValue()."</td>"; 
  echo "<td>".$aSheet->getCell("B".$i)->getValue()."</td>"; 
  echo "<td>".$aSheet->getCell("C".$i)->getValue()."</td>"; 
  echo "<td>".$aSheet->getCell("D".$i)->getValue()."</td>"; 
  echo "<td>".$aSheet->getCell("E".$i)->getValue()."</td>"; 
  echo "<td>".$aSheet->getCell("F".$i)->getValue()."</td>"; 
  echo "</tr>";
  if (($aSheet->getCell("D".$i)->getValue()<>"") && ($this->db->query("SELECT tel FROM customer WHERE tel='".$aSheet->getCell("D".$i)->getValue()."'")->num_rows()==0))
  {
	  $data = array(
				   'name' => $aSheet->getCell("A".$i)->getValue(),
				   'surname' => $aSheet->getCell("B".$i)->getValue(),
				   'rd' => $aSheet->getCell("C".$i)->getValue(),
				   'tel' => $aSheet->getCell("D".$i)->getValue(),
				   'email' => $aSheet->getCell("E".$i)->getValue(),
				   'address' => $aSheet->getCell("F".$i)->getValue(),
           'username' => $aSheet->getCell("D".$i)->getValue(),
           'password' => $aSheet->getCell("D".$i)->getValue()
				);
		/*$sql_insert = "INSERT INTO customer (name,surname,rd,tel,email,address) VALUES ('".$aSheet->getCell("A".$i)->getValue()."','".$aSheet->getCell("B".$i)->getValue()."','".$aSheet->getCell("C".$i)->getValue()."','".$aSheet->getCell("D".$i)->getValue()."','".$aSheet->getCell("E".$i)->getValue()."','".$aSheet->getCell("F".$i)->getValue()."')";
		echo $sql_insert;*/
		//if (mysql_query($sql_insert))$success_import++;
		
	  if($this->db->insert('customer', $data)) $success_import++;
	  else echo mysql_error();
  }
  }
  echo "</table>";
  echo "Импортлох ". ($rows - 1) ." бичлэг олдсоноос ".$success_import." амжилттай орууллаа";
  unlink("assets/uploads/" .$file_name);
  }
  else 
  echo "assets/uploads/" .$file_name." missing<br>";
?>
</div>
<div id="clear"></div>
</div>