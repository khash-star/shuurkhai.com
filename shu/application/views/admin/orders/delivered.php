  <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>


<script type="application/javascript">
function search_send(){
	$.ajax ({
		url: '<?=base_url()?>index.php/deliver/display_search',
		type:'POST',
		data:'search='+$('input[name="search"]').val()+'&type='+$('select[name="type"]').val()+'&start_date='+$('input[name="start_date"]').val()+'&finish_date='+$('input[name="finish_date"]').val(),
		success: function(responce)
			{
									$('#content').empty();
									//$('#content').append('<img id="loading" src="<?=base_url()?>assets/ajax-loader.gif">')
									//$('#responce').remove();
									$('#content').append('<p id="responce">'+responce+'</p>');	
									$('.loading').remove();
			}

			});	
						}

$(function() {
	$('input[name="search"]').keypress(function (e) { if (e.which == 13) search_send();});
	$('select[name="type"]').change(function(){search_send();})
	$('input[name="start_date"]').change(function(){search_send();})
	$('input[name="finish_date"]').change(function(){search_send();})
			})
			
$(function() {
    $( "input[name='start_date']" ).datepicker();
	 $( "input[name='finish_date']" ).datepicker();
  });
			
</script>
<div class="panel panel-primary">
  <div class="panel-heading">Shuurkhai.Com</div>
  <div class="panel-body">
<? 
$this->load->view('deliver/display_search');
?>

</div>

<div id="right_side">
<? echo "<span class=\"formspan\">Хайлт:</span>".form_input("search")."<br><br>";?>
<?
$options = array(
				  'advance' => 'Төлбөртэйг',
				  'all' => 'Бүгдийг'
                );
?>
<? echo "<span>Төрөл:</span>".form_dropdown("type",$options,'all')."<br><br>";?>
<? echo "<span>Эхлэх хугацаа:</span>".form_input("start_date",date("Y-m-d"))."<br>";?>
<? echo "<span>Дуусах хугацаа:</span>".form_input("finish_date",date("Y-m-d"))."<br><br>";?>

<? //$this->load->view("calendar");?>
<div id="side_menu">
<ul>
<li><?=anchor('deliver/delivered', 'Гардуулсан илгээмж')?></li>
<li><?=anchor('deliver', 'Олголт')?></li>
</ul>
</div> <!--side_menu-->
</div> <!--right_side-->
<div id="clear"></div>
</div> <!--wrapper-->