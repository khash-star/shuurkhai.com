<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.5&appId=1084720608253387";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<script type="application/javascript">

$(function() {
			$('body').on('keydown', 'input[type="text"]', function(e) {
			var self = $(this)
			  , form = self.parents('form:eq(0)')
			  , focusable
			  , next
			  ;
			if (e.keyCode == 13) {
				focusable = form.find('input,a,select,button,textarea').filter(':visible');
				next = focusable.eq(focusable.index(this)+1);
				if (next.length) {
					next.focus();
				} else {
					form.submit();
				}
				return false;
			}
		});
			
})
</script>
<?
echo "<div class='panel panel-default'>";
echo "<div class='panel-heading'>Login panel</div>";
echo "<div class='panel-body'>";

if ($this->uri->segment(3))
{
	echo '<div class="alert alert-danger" role="alert">Incorrect password or username <div class="fb-like" data-href="https://www.facebook.com/shuurkhai.from.us" data-layout="button" data-action="like" data-show-faces="false" data-share="false"></div> дарж утасны дугаараа илгээнэ үү. </div>';
//	echo '<div class="fb-like" data-href="https://www.facebook.com/shuurkhai.from.us" data-layout="button" data-action="like" data-show-faces="false" data-share="false"></div>';
	
}


echo form_open('welcome/logining',array("id"=>"form1"));
if ($this->session->userdata('saved')!="") 
$saved=$this->session->userdata('saved'); else $saved="";
echo form_input("username",$saved,array("placeholder"=>"Login name (Eg:99123456)","class"=>"form-control"))."<br>";

$prop = array(
"placeholder"=>"Password",
"class"=>"form-control"
);

if ($saved!="") $prop["autofocus"]="autofocus";

echo form_password("pass","",$prop)."<br>";


echo form_submit("submit","Login",array("class"=>"btn btn-success"));
echo "<br>";
// echo "Намайг санах:&nbsp;".form_checkbox("saved",1,array("ckecked"=>"checked"))."&nbsp;&nbsp;";
// echo anchor("welcome/register","Шинээр бүртгүүлэх");
echo form_close();
echo "</div>"; //panel body
echo "</div>";  //panel
//echo anchor ("welcome/register","Шинээр бүртгүүлэх",array("class"=>"btn btn-primary"));

?>
 

