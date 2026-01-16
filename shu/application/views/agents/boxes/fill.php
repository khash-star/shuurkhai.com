<? if (!$this->uri->segment(3)) redirect('agents/boxes_display'); else $box_id=$this->uri->segment(3) ?>

<div class="panel panel-success">
  <div class="panel-heading">Box бүрдүүлэлт
<span title="Хайрцаглагдаагүй бэлэн ачаа">(<?=anchor("agents/boxes_outside/orders",agent_boxed_order());?> new order</span>
  <span title="Хайрцаглагдаагүй бэлэн нэгтгэсэн ачаа">,<?=anchor("agents/boxes_outside/combine",agent_boxed_combine());?> new combine)</span>	</div>
  <div class="panel-body">
		<? 
		echo form_open("agents/boxes_filling");
		echo form_hidden("box_id",$box_id);
        echo "<h4 class=\"legend\">Track or Barcode</h4>";
        echo form_input ("barcode","",array("class"=>"form-control","placeholder"=>"GO15101588MN"));
		 if ($this->uri->segment(4)=="already") echo $this->uri->segment(5)." хайрцагт байна.";
		 else echo $this->uri->segment(4);
		 echo "<br>";
		echo form_submit("Оруулах","оруулах",array("class"=>"btn btn-success"));
		echo form_close();
       // echo "<br><br><div id=\"result\"></div><br>";
        ?>

  </div> <!-- PANEL BODY -->
</div><!-- PANEL  -->
<script type="application/javascript">
$(document).ready(function(e) {
	$('input[name="barcode"]').focus();
})
</script>
