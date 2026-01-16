<? if ($this->uri->segment(3)) $container_id=$this->uri->segment(3); else $container_id=0;?>

<div class="panel panel-default">
  <div class="panel-heading">Агентийн цэс</div>
  <div class="panel-body">
  
  <ul class="list-group">
	<li class="list-group-item">
    <?=anchor("agents/container","Идэвхитэй чингэлэг");?>

  </li>
  <? if ($container_id!=0)
  {
    ?>
    <li class="list-group-item">
    <?=anchor("agents/container_log_insert/".$container_id,"Чингэлэгт log оруулах");?></li>
    <li class="list-group-item">
   	<? 	
	   echo anchor("agents/container_item_insert/".$container_id,"Ачаа оруулах");?>
    </li>
    <?
  }
  ?>

  <li class="list-group-item">
    <?=anchor("agents/container_outside","Чингэлэгт ороогүй ачаа");?>
  </li>


 
  <!--li class="list-group-item">
    <? //anchor("agents/boxes_history","Boxes түүх");?>
  </li-->
  
</ul>
  </div>
</div>