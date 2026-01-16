<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
	<?
	$sql="SELECT * FROM faqs ORDER BY question,answer";
	//echo $sql;
	$query = $this->db->query($sql);
	//$query = $this->db->like("barcode","CP87");
	if ($query->num_rows() > 0)
	{
		foreach ($query->result() as $row)
		{  
		?>
        <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="headingOne">
              <h4 class="panel-title">
                <a  href="#faqs<?=$row->faqs_id;?>" role="button" data-toggle="collapse" data-parent="#accordion" aria-expanded="true" aria-controls="faqs<?=$row->faqs_id;?>">
                  <?=$row->question;?>
                </a>
              </h4>
            </div>
          	<div id="faqs<?=$row->faqs_id;?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="faqs<?=$row->faqs_id;?>">
              <div class="panel-body">
                <?=$row->answer;?>
              </div>
            </div>
          </div>
           <?
		}
	}
	?>
</div>