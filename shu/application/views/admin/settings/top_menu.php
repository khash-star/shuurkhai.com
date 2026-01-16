<? if ($this->session->userdata('logged_name')=="Administrator")
	{ ?><nav class="navbar navbar-inverse navbar-fixed-top">	<?	}
 else { ?><nav class="navbar navbar-default navbar-fixed-top"><? } ?>
  <div class="container">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="<?=base_url();?>"><img src="<?=base_url();?>assets/images/logo.png" title="Shuurkhai.com" class="logo" /></a>
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
	echo '<li>'.anchor('admin/deliver_tel', 'Утсаар хайх').'</li>';
	echo '<li>'.anchor('admin/handover', 'Хүргэлт').'</li>';
	echo '<li role="separator" class="divider"></li>';
	echo '<li>'.anchor('admin/delivered', 'Гардуулсан').'</li>';
	echo '<li>'.anchor('admin/delivered_report', 'Гардуулалтын тайлан').'</li>';
	echo '<li>'.anchor('admin/delivered_report2', 'Гардуулалтын тайлан Сансар').'</li>';

	echo '</ul>';
	echo '</li>';

	echo '<li>'.anchor('admin/customers', 'Үйлчлүүлэгч').'</li>';
	echo '<li>'.anchor('admin/agents', 'Аgents').'</li>';
	echo '<li>'.anchor('admin/settings', 'Тохиргоо').'</li>';
	
	$sql= "SELECT * FROM help WHERE receiver IS NULL AND `read_admin`='0'";
	$query = $this->db->query($sql);
	echo '<li>'.anchor("admin/help","Тусламж <span class='badge'>".$query->num_rows()."</span>").'</li>';

	echo '<li>'.anchor('welcome/logout', 'Гарах').'</li>';
	}
	if ($this->session->userdata('agent_login')) 
	{ //AGENT LOGGED
	echo '<li>'.anchor('agents', 'Нүүр').'</li>';
	
	echo '<li class="dropdown">';
	echo anchor('agents/orders', 'Илгээмж <span class="caret"></span>',array("class"=>"dropdown-toggle","data-toggle"=>"dropdown","role"=>"button","aria-haspopup"=>"true","aria-expanded"=>"false"));
	echo '<ul class="dropdown-menu">';
	echo '<li>'.anchor('agents/orders', 'Илгээмжүүд').'</li>';
	echo '<li>'.anchor('agents/create', 'Илгээмжүүд оруулах').'</li>';
	echo '</ul>';
	echo '</li>';
	
	
	
	echo '<li class="dropdown">';
	echo anchor('agents/tracks', 'Track <span class="caret"></span>',array("class"=>"dropdown-toggle","data-toggle"=>"dropdown","role"=>"button","aria-haspopup"=>"true","aria-expanded"=>"false"));
	echo '<ul class="dropdown-menu">';
	echo '<li>'.anchor('agents/tracks', 'Track').'</li>';
	echo '<li>'.anchor('agents/tracks_insert', 'Track оруулах').'</li>';
	echo '<li>'.anchor('agents/track_search', 'Track хайх').'</li>';
	echo '</ul>';
	echo '</li>';
	
	echo '<li class="dropdown">';
	echo anchor('agents/boxes', 'Box <span class="caret"></span>',array("class"=>"dropdown-toggle","data-toggle"=>"dropdown","role"=>"button","aria-haspopup"=>"true","aria-expanded"=>"false"));
	echo '<ul class="dropdown-menu">';
	
	echo '<li>'.anchor("agents/boxes","Boxes идэвхитэй").'</li>';
	echo '<li>'.anchor("agents/boxes_create","Box үүсгэх").'</li>';
	echo '<li>'.anchor("agents/boxes_search","Box search").'</li>';
	echo '<li>'.anchor("agents/combine_display","Нэгтгэсэн ачаа").'</li>';
	echo '<li>'.anchor("agents/boxes_combine","Ачааг нэгтгэх").'</li>';
	echo '<li>'.anchor("agents/boxes_relative","Хамааралтай ачаа").'</li>';
		echo '<li class="divider"></li>';
	echo '<li>'.anchor("agents/boxes_outside","Box-д ороогүй").'</li>';

	echo '</ul>';
	echo '</li>';
	

	echo '<li class="dropdown">';
	echo anchor('#', 'Чингэлэг <span class="caret"></span>',array("class"=>"dropdown-toggle","data-toggle"=>"dropdown","role"=>"button","aria-haspopup"=>"true","aria-expanded"=>"false"));
	echo '<ul class="dropdown-menu">';
	echo '<li>'.anchor('agents/container_item_insert', 'Чингэлэгийн ачаа үүсгэх').'</li>';
	echo '<li>'.anchor('agents/container_fill', 'Чингэлэгт ачаа оруулах').'</li>';
	echo '<li>'.anchor('agents/container_outside', 'Чингэлэгт ороогүй ачаа').'</li>';
	echo '</ul>';
	echo '</li>';


	
	echo '<li>'.anchor('agents/customers', 'Үйлчлүүлэгчид').'</li>';

	echo '<li class="dropdown">';
	echo anchor('#', 'Тохиргоо <span class="caret"></span>',array("class"=>"dropdown-toggle","data-toggle"=>"dropdown","role"=>"button","aria-haspopup"=>"true","aria-expanded"=>"false"));
	echo '<ul class="dropdown-menu">';
	echo '<li>'.anchor('agents/report', 'Тайлан').'</li>';
	echo '</ul>';
	echo '</li>';

	echo '<li>'.anchor('welcome/logout', 'Гарах').'</li>';
	}
	if ($this->session->userdata('customer_login')) 
	{ //CUSTOMER LOGGED
	$customer_id = $this->session->userdata('customer_id');
			$query = $this->db->query("SELECT * FROM customer WHERE customer_id='$customer_id'");
			if ($query->num_rows() == 1)
			{
				$row = $query->row();
				$read_news = $row->news_read;
			}
			$read_news='0000-00-00 00:00:00';
	$query = $this->db->query("SELECT * FROM news WHERE timestamp>'$read_news'");
	$new_news = $query->num_rows();

	
	echo '<li>'.anchor("customer/news","Мэдээлэл <span class='badge'>".$new_news."</span>").'</li>';
	echo '<li class="dropdown">';
	echo anchor('customer/orders', 'Миний илгээмжүүд <span class="caret"></span>',array("class"=>"dropdown-toggle","data-toggle"=>"dropdown","role"=>"button","aria-haspopup"=>"true","aria-expanded"=>"false"));
	echo '<ul class="dropdown-menu">';

	echo '<li>'.anchor("customer/orders_create","Shipping track оруулах").'</li>';
	echo '<li role="separator" class="divider"></li>';
	$sql= "SELECT * FROM orders WHERE receiver='".$customer_id."' AND status NOT IN('delivered','completed','custom') AND created_date>'2015-09-01'";
	$query = $this->db->query($sql);
	echo '<li>'.anchor("customer/orders","Бүртгэлтэй илгээмж <span class='badge'>".$query->num_rows()."</span>").'</li>';
	$sql= "SELECT * FROM orders WHERE receiver='".$customer_id."' AND status IN('delivered','custom') AND created_date>'2015-09-01'";
	$query = $this->db->query($sql);
	echo '<li>'.anchor("customer/orders_history","Илгээмжийн түүх <span class='badge'>".$query->num_rows()."</span>").'</li>';
	echo '</ul>';
	echo '</li>';
	
	
	
	
	echo '<li class="dropdown">';
	echo anchor('customer/orders', 'Захиалгын сагс <span class="caret"></span>',array("class"=>"dropdown-toggle","data-toggle"=>"dropdown","role"=>"button","aria-haspopup"=>"true","aria-expanded"=>"false"));
	echo '<ul class="dropdown-menu">';
	$sql= "SELECT * FROM online WHERE (customer_id='".$customer_id."' OR receiver='".$customer_id."') AND status ='online' AND price!=0";
	$query = $this->db->query($sql);
	$online_count= $query->num_rows();
	
	$query = $this->db->query("SELECT * FROM online WHERE (customer_id='".$customer_id."' OR receiver='".$customer_id."') AND status ='online'");
		$sum_price=0;
				foreach ($query->result() as $row)
				{  
				$sum_price+=$row->price;
				}
	echo '<li>'.anchor("customer/online","<span class='glyphicon glyphicon-shopping-cart'></span> Миний сагс <span class='badge'>".$sum_price."$ (".$online_count.")</span>")."</li>";
	
	
	
	//<span class='badge'>".$query->num_rows()."</span>").'</li>';
	
	echo '<li>'.anchor("customer/online_create","<span class='glyphicon glyphicon-shopping-cart'></span> Сагсанд нэмэх").'</li>';
	//echo '<li role="separator" class="divider"></li>';
	
	
	
	$sql= "SELECT * FROM online WHERE (customer_id='".$customer_id."' OR receiver='".$customer_id."') AND status IN ('complete','order')";
	$query = $this->db->query($sql);
	
	echo '<li>'.anchor("customer/online_history","Захиалгын түүх <span class='badge'>".$query->num_rows()."</span>").'</li>';
	echo '</ul>';
	echo '</li>';
	
	
	
	//	echo '<li>'.anchor('customer/online', 'Миний Захиалгаууд').'</li>';
	//	echo '<li>'.anchor('customer/online_shops', 'Online дэлгүүр').'</li>';
	echo '<li>'.anchor('customer/profile', 'Хувийн тохиргоо').'</li>';
	$sql= "SELECT * FROM help WHERE receiver='".$customer_id."' AND `read`='0'";
	$query = $this->db->query($sql);
	echo '<li>'.anchor("customer/help","Тусламж <span class='badge'>".$query->num_rows()."</span>").'</li>';
	
	echo '<li>'.anchor('#', 'Нэхэмжлэх <span class="caret"></span>',array("class"=>"dropdown-toggle","data-toggle"=>"dropdown","role"=>"button","aria-haspopup"=>"true","aria-expanded"=>"false"));
		echo '<ul class="dropdown-menu">';
		echo '<li>'.anchor("customer/envoice","Шинээр үүсгэх").'</li>';
		echo '<li>'.anchor("customer/envoices","Үүсгэсэн нэхэмжлэх").'</li>';
		echo '</ul>';
	echo '</li>';

		echo '<li>'.anchor('welcome/logout', 'Гарах').'</li>';
	}
?>

 <?
if (!$this->session->userdata('login'))
{
echo '<li>'.anchor('welcome/login', 'Нэвтрэх').'</li>';
echo '<li>'.anchor('welcome/location', 'Байршил').'</li>';
echo '<li class="dropdown">';
	echo anchor('welcome/help', 'Тусламж <span class="caret"></span>',array("class"=>"dropdown-toggle","data-toggle"=>"dropdown","role"=>"button","aria-haspopup"=>"true","aria-expanded"=>"false"));
		echo '<ul class="dropdown-menu">';
		echo '<li>'.anchor('welcome/help', 'Тусламж үүсгэх').'</li>';
		echo '<li>'.anchor('welcome/online', 'Онлайн захиалга').'</li>';
	echo '<li>'.anchor('welcome/track_insert', 'Track оруулах').'</li>';
	echo '<li>'.anchor('welcome/order_create', 'Захиалга өгөх').'</li>';
		echo '</ul>';
	echo '</li>';
			echo '<li>'.anchor("welcome/track_search","Track шүүх").'</li>';
			echo '<li>'.anchor("welcome/about","Бидний тухай").'</li>';




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