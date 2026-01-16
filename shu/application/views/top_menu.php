<? 
    if ($this->session->userdata('logged_name')=="Administrator")
	{
	    
	    ?><nav class="navbar navbar-inverse navbar-fixed-top">	<?	
	    
	}
 else { 

 ?><nav class="navbar navbar-default navbar-fixed-top"><? } ?>
  <div class="container">

  	<div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
    </div>
    
    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">

      <? if ($this->session->userdata('admin_login')) 
	{//ADMIN LOGGED
		echo '<li class="dropdown">';
		echo anchor('admin/orders', 'Илгээмж <span class="caret"></span>',array("class"=>"dropdown-toggle","data-toggle"=>"dropdown","role"=>"button","aria-haspopup"=>"true","aria-expanded"=>"false"));
		echo '<ul class="dropdown-menu">';
		echo '<li>'.anchor('admin/orders', 'Илгээмжүүд').'</li>';
		echo '<li role="separator" class="divider"></li>';
		echo '<li>'.anchor('admin/barcodes', 'Barcode').'</li>';
		echo '<li>'.anchor('admin/barcode_insert', 'Barcode оруулах').'</li>';
		echo '</ul>';
		echo '</li>';


		$sql_online= "SELECT * FROM online WHERE status ='online'";
		$query_online = $this->db->query($sql_online);


		echo '<li class="dropdown">';
		echo anchor('admin/online', 'Online	<span class="badge">'.$query_online->num_rows().'</span><span class="caret"></span>',array("class"=>"dropdown-toggle","data-toggle"=>"dropdown","role"=>"button","aria-haspopup"=>"true","aria-expanded"=>"false"));
		echo '<ul class="dropdown-menu">';
		echo '<li>'.anchor('admin/online', 'Бүх online').'</li>';
		echo '<li>'.anchor('admin/online_pendings', 'Pending Track').'</li>';
		echo '<li>'.anchor('admin/online_history', 'Түүх').'</li>';
		echo '</ul>';
		echo '</li>';
		
		echo '<li class="dropdown">';
		echo anchor('admin/tracks', 'Tracks <span class="caret"></span>',array("class"=>"dropdown-toggle","data-toggle"=>"dropdown","role"=>"button","aria-haspopup"=>"true","aria-expanded"=>"false"));
		echo '<ul class="dropdown-menu">';
		//echo '<li>'.anchor('admin/tracks_insert', 'Track оруулах').'</li>';
		echo '<li>'.anchor('admin/tracks', 'Track').'</li>';
		echo '<li>'.anchor('admin/track_search', 'Track хайх').'</li>';
		echo '</ul>';
		echo '</li>';
		
		
		echo '<li class="dropdown">';
		echo anchor('admin/boxes', 'Box <span class="caret"></span>',array("class"=>"dropdown-toggle","data-toggle"=>"dropdown","role"=>"button","aria-haspopup"=>"true","aria-expanded"=>"false"));
		echo '<ul class="dropdown-menu">';
		echo '<li>'.anchor('admin/boxes', 'Boxes').'</li>';
		echo '<li>'.anchor('admin/boxes_search', 'Boxes хайх').'</li>';
		echo '<li>'.anchor('admin/boxes_history', 'Boxes түүх').'</li>';
		echo '<li>'.anchor("admin/combine_display","Нэгтгэсэн ачаа").'</li>';
		echo '</ul>';
		echo '</li>';
		
		echo '<li class="dropdown">';
			echo anchor('admin/deliver', 'Олголт <span class="caret"></span>',array("class"=>"dropdown-toggle","data-toggle"=>"dropdown","role"=>"button","aria-haspopup"=>"true","aria-expanded"=>"false"));
			echo '<ul class="dropdown-menu">';
			echo '<li>'.anchor('admin/deliver', 'Олголт').'</li>';
			echo '<li>'.anchor('admin/deliver_container', 'Чингэлэгийн ачаа гардуулах').'</li>';
			echo '<li role="separator" class="divider"></li>';
			echo '<li>'.anchor('admin/reverse', 'Буцаалт').'</li>';
			echo '<li role="separator" class="divider"></li>';
			echo '<li>'.anchor('admin/later_pay', 'Дараа тооцоог төлөх').'</li>';
			echo '<li>'.anchor('admin/later_transaction', 'Дараа тооцоо тулгалт').'</li>';
			echo '</ul>';
		echo '</li>';

			echo '<li class="dropdown">';
			echo anchor('admin/deliver', 'Хүргэлт <span class="caret"></span>',array("class"=>"dropdown-toggle","data-toggle"=>"dropdown","role"=>"button","aria-haspopup"=>"true","aria-expanded"=>"false"));
			echo '<ul class="dropdown-menu">';
			echo '<li>'.anchor('admin/handover', 'Хүргэлтээр гаргах').'</li>';
			echo '</ul>';
		echo '</li>';

		echo '<li>'.anchor('admin/customers', 'Үйлчлүүлэгч').'</li>';

		echo '<li class="dropdown">';
			echo anchor('admin/report', 'Тайлан <span class="caret"></span>',array("class"=>"dropdown-toggle","data-toggle"=>"dropdown","role"=>"button","aria-haspopup"=>"true","aria-expanded"=>"false"));
			echo '<ul class="dropdown-menu">';
				echo '<li>'.anchor('admin/delivered_report', 'Гардуулалтын тайлан /Бэлэн/').'</li>';
				echo '<li>'.anchor('admin/delivered_report3', 'Гардуулалтын тайлан /Дараа/').'</li>';
				echo '<li>'.anchor('admin/delivered_report2', 'Гардуулалтын тайлан Сансар').'</li>';
				echo '<li>'.anchor('admin/delivered_report4', 'Хашбал тайлан').'</li>';
				echo '<li>'.anchor('admin/delivered_report5', 'Агуулахын тайлан').'</li>';
				echo '<li role="separator" class="divider"></li>';
				echo '<li>'.anchor('admin/handover_report', 'Хүргэлтийн тайлан').'</li>';
				echo '<li role="separator" class="divider"></li>';
				echo '<li>'.anchor('admin/later_report', 'Дараа тооцооны тайлан').'</li>';
			echo '</ul>';
		echo '</li>';

		
		$sql= "SELECT * FROM help WHERE receiver IS NULL AND `read_admin`='0'";
		$query = $this->db->query($sql);
		echo '<li>'.anchor("admin/help","Тусламж <span class='badge'>".$query->num_rows()."</span>").'</li>';

		echo '<li class="iconmenu">'.anchor('admin/settings', '<span class="glyphicon glyphicon-wrench"></span>',array("title"=>"Тохиргоо")).'</li>';
		echo '<li class="iconmenu">'.anchor('welcome/logout', '<span class="glyphicon glyphicon-log-out"></span>',array("title"=>"Гарах")).'</li>';
	}
	if ($this->session->userdata('agent_login')) 
	{ //AGENT LOGGED
		echo '<li>'.anchor('agents', 'Home').'</li>';
		
		echo '<li class="dropdown">';
		echo anchor('agents/orders', 'Orders <span class="caret"></span>',array("class"=>"dropdown-toggle","data-toggle"=>"dropdown","role"=>"button","aria-haspopup"=>"true","aria-expanded"=>"false"));
		echo '<ul class="dropdown-menu">';
		echo '<li>'.anchor('agents/orders', 'All orders').'</li>';
		echo '<li>'.anchor('agents/create', 'Place order').'</li>';
		echo '</ul>';
		echo '</li>';
	
	
	
		echo '<li class="dropdown">';
		echo anchor('agents/tracks', 'Track <span class="caret"></span>',array("class"=>"dropdown-toggle","data-toggle"=>"dropdown","role"=>"button","aria-haspopup"=>"true","aria-expanded"=>"false"));
		echo '<ul class="dropdown-menu">';
		echo '<li>'.anchor('agents/tracks', 'Track').'</li>';
		echo '<li>'.anchor('agents/tracks_insert', 'Track insert').'</li>';
		echo '<li>'.anchor('agents/tracks_de_insert', 'Delaware Track insert').'</li>';
		echo '<li>'.anchor('agents/track_search', 'Track search').'</li>';
		echo '<li>'.anchor('agents/track_branch', 'Delaware from').'</li>';
		echo '</ul>';
		echo '</li>';
		
		echo '<li class="dropdown">';
		echo anchor('agents/boxes', 'Box <span class="caret"></span>',array("class"=>"dropdown-toggle","data-toggle"=>"dropdown","role"=>"button","aria-haspopup"=>"true","aria-expanded"=>"false"));
		echo '<ul class="dropdown-menu">';
		
		echo '<li>'.anchor("agents/boxes","Active boxes").'</li>';
		echo '<li>'.anchor("agents/boxes_create","Box create").'</li>';
		echo '<li>'.anchor("agents/boxes_search","Box search").'</li>';
		echo '<li>'.anchor("agents/combine_display","Combined boxes").'</li>';
		echo '<li>'.anchor("agents/boxes_combine","Combine").'</li>';
		echo '<li>'.anchor("agents/boxes_relative","Customer related orders").'</li>';
			echo '<li class="divider"></li>';
		echo '<li>'.anchor("agents/boxes_outside","Orders not in box").'</li>';

		echo '</ul>';
		echo '</li>';
	

			echo '<li class="dropdown">';
			echo anchor('#', 'Containers <span class="caret"></span>',array("class"=>"dropdown-toggle","data-toggle"=>"dropdown","role"=>"button","aria-haspopup"=>"true","aria-expanded"=>"false"));
			echo '<ul class="dropdown-menu">';
			echo '<li>'.anchor('agents/container', 'Active containers').'</li>';
			echo '<li>'.anchor('agents/container_item_insert', 'Create container item').'</li>';
			echo '<li>'.anchor('agents/container_fill', 'Put into container').'</li>';
			echo '<li>'.anchor('agents/container_outside', 'Items not in container').'</li>';
			echo '<li>'.anchor('agents/container_insert', 'Create container').'</li>';
			echo '</ul>';
			echo '</li>';	
	
			echo '<li>'.anchor('agents/customers', 'Customers').'</li>';
		

		echo '<li class="dropdown">';
		echo anchor('#', 'Settings <span class="caret"></span>',array("class"=>"dropdown-toggle","data-toggle"=>"dropdown","role"=>"button","aria-haspopup"=>"true","aria-expanded"=>"false"));
		echo '<ul class="dropdown-menu">';
		echo '<li>'.anchor('agents/report', 'Report').'</li>';
		echo '</ul>';
		echo '</li>';

		echo '<li>'.anchor('welcome/logout', 'Logout').'</li>';
	}
?>

 <?
if (!$this->session->userdata('login'))
{
echo '<li>'.anchor('welcome/login', 'Login').'</li>';
echo '<li>'.anchor('welcome/location', 'Locations').'</li>';
echo '<li class="dropdown">';
	echo anchor('welcome/help', 'Support <span class="caret"></span>',array("class"=>"dropdown-toggle","data-toggle"=>"dropdown","role"=>"button","aria-haspopup"=>"true","aria-expanded"=>"false"));
		echo '<ul class="dropdown-menu">';
		echo '<li>'.anchor('welcome/help', 'Create ticket').'</li>';
		echo '<li>'.anchor('welcome/online', 'Online orders').'</li>';
	echo '<li>'.anchor('welcome/track_insert', 'Insert track').'</li>';
	echo '<li>'.anchor('welcome/order_create', 'Place order').'</li>';
		echo '</ul>';
	echo '</li>';
			echo '<li>'.anchor("welcome/track_search","Find tracks").'</li>';
			echo '<li>'.anchor("welcome/about","About").'</li>';




}?>

<!--li>
 <?
//if (!$this->session->userdata('login'))
//echo anchor('welcome/register', 'Бүртгүүлэх');?>
</li-->
      </ul>
     </div><!-- /.navbar-collapse -->
    
  </div><!-- /.container-fluid -->
 
</nav>