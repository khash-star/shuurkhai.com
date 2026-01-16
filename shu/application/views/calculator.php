<script type="text/javascript" src="<?=base_url();?>assets/js/alert.js"></script>
<script language="javascript">
$(document).ready(function(e) {
	$('body').on( 'input', function(e) {
			var self = $(this)
			  , form = self.parents('form:eq(0)')
			  , focusable
			  , next
			  ;
			if (e.keyCode == 13) {
				focusable = form.find('input').filter(':visible');
				next = focusable.eq(focusable.index(this)+1);
				if (next.length) {
					next.focus();
				} else {
					form.submit();
				}
				return false;
			}
		});
	
	
	
	
	
	
	
	var type ='cm';
    $("input[value='cm']").change(function(){$('span[class="input-group-addon"]:lt(3)').text('cm');type='cm'});
	$("input[value='inches']").change(function(){$('span[class="input-group-addon"]:lt(3)').text('inches');type='inches'});
	$("input[type='text']").change(function(){
		var height= $("input[name='height']").val();
		var width= $("input[name='width']").val();
		var long= $("input[name='long']").val();
		if (type=='cm') $("input[name='total']").val((height*width*long)/6000);
		if (type=='inches') $("input[name='total']").val((height*width*long)/336);
		})
});
</script>
<div class="panel panel-primary">
<div class="panel-heading">Овор тооцох</div>
<div class="panel-body">
<div class="alert alert-warning alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <span class="glyphicon glyphicon-question-sign"></span>
  <strong>Овор!</strong> Онгоцоор нисгэх ачааны эзлэхүүнээс хамаарч түүнийг оворт тооцож үнийг тооцож авдаг байгаа.
</div>

	<table class="table table-hover">
    <tr><td>Нэгж</td><td>
<div class="btn-group" data-toggle="buttons">
  <label class="btn btn-primary active">
    <input type="radio" name="options" id="measurement" autocomplete="off"  value="cm" checked>cm
  </label>
  <label class="btn btn-primary">
    <input type="radio" name="options" id="measurement" autocomplete="off" value="inches">inches
  </label>
  </div></td></tr>
  
  <tr><td>Өндөр</td><td>
  <div class="input-group">
  <input type="text" name="height" placeholder="Өндөр" class="form-control" /><span class="input-group-addon">cm</span>
  </div></td></tr>
  
  
  <tr><td>Өргөн</td><td>
    <div class="input-group">
  <input type="text" name="width" placeholder="Өргөн" class="form-control" /><span class="input-group-addon">cm</span>
  </div>
  </td></tr>
  
   <tr><td>Урт</td><td>
	<div class="input-group">
  <input type="text" name="long" placeholder="Урт" class="form-control" /><span class="input-group-addon">cm</span>
  </div>
  </td>
  </tr>
  
  
	<tr><td>Оворт жин</td><td>
	<div class="input-group">
  <input type="text" name="total" placeholder="Оворт жин" class="form-control" readonly="readonly" /><span class="input-group-addon">кг</span>
  </div>
  </td>
  </tr>
  </table>















</div>
</div>
