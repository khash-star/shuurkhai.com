<?php
if ($this->uri->segment(3)!="") $date=$this->uri->segment(3); else $date=NULL;
$query=$this->db->query("SELECT * FROM events WHERE event_date='".$date."'");
if ($query->num_rows() > 0)
{
	echo "<ul>";
	foreach ($query->result() as $row)
	{	echo  "<li>".$row->event_date.": " ;
		if ($row->time!="00:00:00") echo "(".substr($row->time,0,5).")";
		echo "<b>".$row->description."</b></li>";
	}
	echo "</ul>";
}
?>