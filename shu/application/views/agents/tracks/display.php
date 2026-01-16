



<script type="application/javascript">
function search_send(){
	$.ajax ({
		url: '<?=base_url()?>index.php/agents/tracks_display_search',
		type:'POST',
		data:'search='+$('input[name="search"]').val()+'&search_status='+$('select[name="status"]').val()+'&status_type='+$('select[name="status_type"]').val(),
		success: function(responce)
			{						//$('input[name="search"]').val('');
									$('#content').html('<img src="<?=base_url()?>assets/ajax-loader.gif" id="loading">')
									//$('#responce').remove();
									$('#loading').remove();
									$('#content').append(responce)	
									
			}

			});	
						}

$(function() {
	$('input[name="search"]').keypress(function (e) { if (e.which == 13) search_send();});
	$('select[name="status"]').change(function(){search_send();});
	$('select[name="status_type"]').change(function(){search_send();});
			})
</script>
<div class="panel panel-primary">
  <div class="panel-heading">Shuurkhai.Com</div>
  <div class="panel-body">
<? 
$this->load->view('agents/tracks/display_search');
?>

</div>

<div id="right_side">
<?
$options = array(
				  'all'  => 'Бүx идэвхитэй',
				  'new'  => 'Нисэхэд бэлэн',
				  'order'  => 'Хүлээн авагчгүй',
				  'filled'  => 'Х/авагч бөглөсөн',
				  'weight_missing'  => 'Жин нь бөглөгдөөгүй',
                  'onair'    => 'Онгоцоор ирж байгаа',
                  'warehouse'   => 'Агуулахад байгаа',
				  'delivered'  => 'Хүргэгдсэн',
                  'custom' => 'Гаальд саатсан',
				  'db' => 'Баазаас'
                );
?>
<? echo "<div class=\"box_left\">"; ?>
<? echo "<h4 class=\"legend\">Шүүлтүүр</h4>"; ?>
<? echo "<span class=\"formspan\">Хайлт:</span>".form_input("search")."<br>";?>
<? echo "<span class=\"formspan\">Төрөл:</span>".form_dropdown("status",$options,'all');?>
<?
$options = array(
				  'advance' => 'Төлбөртэйг',
				  'all' => 'Бүгдийг'
                );
?>
<? echo "<span class=\"formspan\">Төрөл:</span><br>".form_dropdown("status_type",$options,'all');?>

<? echo "</div>"; ?>
<? $this->load->view("calendar");?>
<div id="side_menu">
<ul>

<li><?=anchor('agents', 'Home')?></li>
<li><?=anchor('agents/tracks', 'Tracks')?></li>
<li><?=anchor('agents/tracks_insert', 'Track оруулах')?></li>
<!--li><? //anchor(base_url().'assets/orders.xlsx', 'Excel файл татах')?></li-->
</ul>
</div> <!--side_menu-->
</div> <!--right_side-->
<div id="clear"></div>
</div> <!--wrapper-->