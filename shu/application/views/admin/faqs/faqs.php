<div class="panel panel-primary">
  <div class="panel-heading">Асуултууд</div>
	<div class="panel-body">
	<? 
	$count =1;
	$sql = "SELECT * FROM faqs ORDER BY question,answer"; 
	$query = $this->db->query($sql);
	if ($query->num_rows() > 0)
		{
			?>
			<table class="table">
			<tr><th>№</th><th>Асуулт</th><th>Хариулт</th><th></th></tr>
            <?
			foreach ($query->result() as $row)
				{  
				?>
                <tr>
                    <td><?=$count++;?></td>
                    <td><?=$row->question;?></td>
                    <td><?=$row->answer;?></td> 
                    <td><?=anchor('admin/faqs_edit/'.$row->faqs_id,'<span class="glyphicon glyphicon-edit"></span>');?></td> 
	  			</tr>
                <?
				}
				?>
	</table>
    <?
    }	
	else echo "Асуулт байхгүй";
	echo anchor("admin/faqs_create","Шинээр үүсгэх")."<br>";
	?>
	</div>
</div>