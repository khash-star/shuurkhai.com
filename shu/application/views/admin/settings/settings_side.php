<div class="panel panel-primary">
  <div class="panel-heading">Админы цэс</div>
  <div class="panel-body">
  
    <ul class="list-group">
	<li class="list-group-item"  style="text-align:center; background:#FF9;">
    Нийт хуримтлалын сан:<br />
    <span style="font-size:50px; color:#090; text-align:center;">
	<? 
	$query_total = $this->db->query("SELECT SUM(cent) as total FROM customer");
	$row = $query_total->row();
	echo $row->total/100 ."$";
	?></span>
    </li>
    </ul>
    
  	<ul class="list-group">
    <li class="list-group-item"><?=anchor('admin/report', 'Тооцоо гаргах')?></li>
    <li class="list-group-item"><?=anchor('admin/events', 'Календарчилал')?></li>
    </ul>
    <ul class="list-group">
    <li class="list-group-item"><?=anchor('admin/page5_edit', 'Track оруулах')?></li>
    <li class="list-group-item"><?=anchor('admin/page6_edit', 'Захиалга өгөх')?></li>
    <li class="list-group-item"><?=anchor('admin/page4_edit', 'Онлайн захиалга')?></li>
    <li class="list-group-item"><?=anchor('admin/page_edit', 'Сонордуулга')?></li>
    <li class="list-group-item"><?=anchor('admin/page2_edit', 'Баруун баннер')?></li>
    <li class="list-group-item"><?=anchor('admin/page7_edit', 'Бидний тухай')?></li>
    <li class="list-group-item"><?=anchor('admin/page3_edit', 'Slide')?></li>
    </ul>
    
    <ul class="list-group">
    <li class="list-group-item"><?=anchor('admin/news', 'Мэдээ')?></li>
    <li class="list-group-item"><?=anchor('admin/news_create', 'Мэдээ оруулах')?></li>
   	</ul>

    <ul class="list-group">
    <li class="list-group-item"><?=anchor('admin/alerts', 'Мэдэгдэл')?></li>
    <li class="list-group-item"><?=anchor('admin/alert_create', 'Мэдэгдэл оруулах')?></li>
    <li class="list-group-item"><?=anchor('admin/alert_delete', 'Мэдэгдэл устгах')?></li>
    </ul>
    
    <ul class="list-group">
	<li class="list-group-item"><?=anchor('admin/envoice_create', 'Нэхэмжлэх үүсгэх')?></li>
    <li class="list-group-item"><?=anchor('admin/envoices', 'Нэхэмжлэхүүд')?></li>
   	</ul>
    
    <ul class="list-group">
    <li class="list-group-item"><?=anchor('admin/proxy', 'Public proxy')?></li>
    <li class="list-group-item"><?=anchor('admin/proxy_add', 'Public proxy оруулах')?></li>
    <li class="list-group-item"><?=anchor('admin/proxy_add_excel', 'Public proxy импортлох')?></li>
    </ul>
    
    <ul class="list-group">
	<li class="list-group-item"><?=anchor('admin/faqs', 'Түгээмэл асуулт')?></li>
   	</ul>

    <ul class="list-group">
    <li class="list-group-item"><?=anchor('admin/agents', 'Агентууд')?></li>
    </ul>
    
    
    <ul class="list-group">
    <li class="list-group-item"><?=anchor('admin/logs', 'Log харах')?></li>
    <li class="list-group-item"><?=anchor('admin/db_backup', 'DB backup')?></li>
   	</ul>
  </div><!-- PANEL-BODY -->
</div><!-- PANEL -->


