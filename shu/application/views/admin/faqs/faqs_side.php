<div class="panel panel-primary">
  <div class="panel-heading">Түгээмэл асуулт цэс</div>
  <div class="panel-body">
  
  	
   <ul class="list-group">
	<li class="list-group-item"><?=anchor('admin/faqs', 'Aсуултууд')?></li>
    <li class="list-group-item"><?=anchor('admin/faqs_create', 'Асуулт үүсгэх')?></li>
   	</ul>
    
    
    <ul class="list-group">
    <li class="list-group-item"><?=anchor('admin/settings', 'Үндсэн тохиргоо')?></li>
   	</ul>
  </div><!-- PANEL-BODY -->
</div><!-- PANEL -->

<div class="panel panel-primary">
  <div class="panel-body">
<? $this->load->view("calendar");?>
<? $this->load->view("rate");?>
  </div><!-- PANEL-BODY -->
</div><!-- PANEL -->
