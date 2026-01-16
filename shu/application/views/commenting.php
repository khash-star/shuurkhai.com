<div class="panel panel-success">
  <div class="panel-heading">Shuurkhai.Com</div>
  <div class="panel-body">

<?
$comment=$_POST["comment"];
if ($comment!="")
{
	$data = array(
			   'comment'=>$comment,
			   'author'=>$this->session->userdata("logged_name")
            );
	if ($this->db->insert('comments', $data)) ;
}
else redirect('welcome', 'refresh',3);
echo "Commenting.";
redirect('welcome', 'refresh',3);

?>

</div>
<div id="clear"></div>
</div><!--wrapper-->