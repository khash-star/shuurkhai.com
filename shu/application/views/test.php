<?
//date_default_timezone_set('Asia/Ulaanbaatar');
$sql = "SELECT * FROM box_combine";

$query = $this->db->query($sql);
if ($query->num_rows() > 0)
{
	foreach($query->result() as $row)
		{
		$package = $row ->package;
		//$order_id = $row ->order_id;
		$package = str_replace("######","##",$package);
		$package = str_replace("'","",$package);
		
		$this->db->query("UPDATE box_combine SET package = '$package' WHERE combine_id='".$row->combine_id."' LIMIT 1");
		//echo $package;
		}
}
?>