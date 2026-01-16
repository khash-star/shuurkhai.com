<script type="application/javascript">
function search_send(){
	$.ajax ({
		url: '<?=base_url()?>index.php/online/display_search',
		type:'POST',
		data:'search='+$('input[name="search"]').val(),
		success: function(responce)
			{
									$('#content').html('<img src="<?=base_url()?>assets/ajax-loader.gif" id="loading">')
									$('#loading').remove();
									//$('#responce').remove();
									$('#content').append('<p id="responce">'+responce+'</p>');	
									
			}

			});	
						}

$(function() {
	$('input[name="search"]').keypress(function (e) { if (e.which == 13) search_send();});
			})
</script>

<div class="panel panel-primary">
  <div class="panel-heading">Shuurkhai.Com</div>
  <div class="panel-body">

<? 
$this->load->view('online/display_search');
?>

</div>
<div id="right_side">
<?
/*$options = array(
				  'all'  => 'Бүx идэвхитэй',
				  'new'  => 'Нисэхэд бэлэн',
                  'onair'    => 'Онгоцоор ирж байгаа',
                  'warehouse'   => 'Агуулахад байгаа',
				  'delivered'  => 'Хүргэгдсэн',
                  'custom' => 'Гаальд саатсан'
                );*/
?>
<? echo "<span class=\"formspan\">Хайлт:</span>".form_input("search")."<br>";?>
<? //echo "<span class=\"formspan\">Төрөл:</span>".form_dropdown("status",$options,'all');?>




<? $this->load->view("calendar");?>
<div id="side_menu">
<ul>
<li><?=anchor('online', 'Захиалгууд')?></li>
<li><?=anchor('online/online_create', 'Захиалга оруулах')?></li>
<? /*if ($query->num_rows() == 1)
	{
	echo "<li>".anchor('orders/online_renew/'.$online_id,'Энэ online-г Илгээмж болгох')."</li>";
	//echo anchor('orders/deliver/'.$order_id,'Хүргэж өгсөн')."<br>";
    echo "<li>".anchor('orders/online_delete/'.$online_id,'Энэ online-г Устгах')."</li>";
   	//echo "<li>".anchor('orders/track/'.$order_id,'Хаана явна')."</li>";
	}*/
?>
</ul>
</div> <!--side_menu-->
</div> <!--right_side-->
<div id="clear"></div>
</div><!--wrapper-->