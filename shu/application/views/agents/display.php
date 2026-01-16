<script type="application/javascript">
function search_send(){
	$.ajax ({
		url: '<?=base_url()?>index.php/agents/display_search',
		type:'POST',
		data:'search='+$('input[name="search"]').val()+'&search_status='+$('select[name="status"]').val(),
		success: function(responce)
			{
									$('#content').html('<img src="<?=base_url()?>assets/ajax-loader.gif" id="loading">')
									//$('#responce').remove();
									$('#content').append('<p id="responce">'+responce+'</p>');	
									$('#loading').remove();
			}

			});	
						}

$(function() {
	$('input[name="search"]').keyup(function(){search_send();})
	$('select[name="status"]').change(function(){search_send();})
			})
</script>
<div class="panel panel-success">
  <div class="panel-heading">Shuurkhai.Com</div>
  <div class="panel-body">
<? 
$this->load->view('orders/display_search');
?>

</div>

<div id="right_side">
<?
$options = array(
				  'all'  => 'Бүx идэвхитэй',
				  'new'  => 'Нисэхэд бэлэн',
                  'onair'    => 'Онгоцоор ирж байгаа',
                  'warehouse'   => 'Агуулахад байгаа',
				  'delivered'  => 'Хүргэгдсэн',
                  'custom' => 'Гаальд саатсан'
                );
?>
<? echo "<span class=\"formspan\">Хайлт:</span>".form_input("search")."<br>";?>
<? echo "<span class=\"formspan\">Төрөл:</span>".form_dropdown("status",$options,'all');?>
<? $this->load->view("calendar");?>
<div id="side_menu">
<ul>

<li><?=anchor('agents', 'Home')?></li>
<li><?=anchor('agents/create', 'Илгээмж оруулах')?></li>
<li><?=anchor('barcode', 'Barcode')?></li>
<li><?=anchor('barcode/insert', 'Barcode оруулах')?></li>
<li><?=anchor(base_url().'assets/orders.xlsx', 'Excel файл татах')?></li>
</ul>
</div> <!--side_menu-->
</div> <!--right_side-->
<div id="clear"></div>
</div> <!--wrapper-->