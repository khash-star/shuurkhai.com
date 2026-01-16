<div class="panel panel-success">
  <div class="panel-heading">Shuurkhai.Com</div>
  <div class="panel-body">
<? 
$file_name="customers.xlsx";
$allowedExts = array("xlsx");
$extension = end(explode(".", $_FILES["xlsx_file"]["name"]));
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
 $this->load->view('agents/customers/Classes/PHPExcel/IOFactory.php');
 $inputFileName = 'assets/uploads/'.$file_name;  // File to read
 $objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
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
  if ($this->db->query("SELECT tel FROM customer WHERE tel='".$aSheet->getCell("D".$i)->getValue()."' OR rd='".$aSheet->getCell("C".$i)->getValue()."'")->num_rows()==0)
  {
	  $data = array(
				   'name' => $aSheet->getCell("A".$i)->getValue(),
				   'surname' => $aSheet->getCell("B".$i)->getValue(),
				   'rd' => $aSheet->getCell("C".$i)->getValue(),
				   'tel' => $aSheet->getCell("D".$i)->getValue(),
				   'username' => $aSheet->getCell("D".$i)->getValue(),
				   'password' => $aSheet->getCell("D".$i)->getValue(),
				   'email' => $aSheet->getCell("E".$i)->getValue(),
				   'address' => $aSheet->getCell("F".$i)->getValue()
				);
	  if($this->db->insert('customer', $data)) $success_import++;
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