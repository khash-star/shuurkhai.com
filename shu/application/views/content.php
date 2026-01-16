<div class="container">
<div class="row">
<div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
<?
if(isset ($content) && $content!="" )
$this->load->view($content); 
?>
</div>
<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
<?
if(isset ($right_side) && $right_side!="" )
$this->load->view($right_side); 
?>
</div>
<div class="clearfix"></div>
</div>