<? 
$combine_id=$this->uri->segment(3);
?>

<div class="panel panel-default">
  <div class="panel-heading">Админы цэс</div>
  <div class="panel-body">
  
  <ul class="list-group">
  	<li class="list-group-item">
   	<? 	
	echo anchor("admin/combine_display","Нэгтгэсэн ачаа");?>
  </li>
  
  <li class="list-group-item"> 	
	 <?
	if (!isset($_POST["search"])) $search="";  else $search=$_POST["search"];
	echo form_open("admin/combine_display/");
	echo '<div class="input-group">';
       	echo form_input("search",$search,array("class"=>"form-control","placeholder"=>"Хайх..."))."<br>";

     
	  echo '<span class="input-group-btn">';
        echo form_submit("Хайх","Хайх",array("class"=>"btn btn-primary"));
      echo '</span>';
    echo '</div>';
	 
	 ?>
  </li>
  
  <? if ($this->uri->segment(3)) {?>
	<li class="list-group-item">
    <?=anchor("admin/combine_preview/".$this->uri->segment(3),"Нэгтгэсэн CP72",array("target"=>"_blank"));?>
  </li>
  <? }?>
  </ul>
  </div>
</div>