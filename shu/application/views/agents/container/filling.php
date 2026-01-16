<? //if ($_POST["box_id"]=="" && $_POST["barcode"]=="") redirect('agents/boxes_display');  ?>
<? 
if (isset($_POST["container_id"])) $container_id = $_POST["container_id"];  else redirect("agents/container_fill");
if (isset($_POST["barcode"])) $barcode = strtoupper($_POST["barcode"]);

	if ($container_id!="" && $barcode!="")
	{
		$query = $this->db->query("SELECT * FROM container WHERE container_id=".$container_id);
			if ($query->num_rows()==1)
				{
					$row = $query->row();
					$container_status= 	$row ->status;
					if ($container_status="new")
					{

	 					$query = $this->db->query("SELECT * FROM container_item WHERE barcode='".$barcode."' OR track='".$barcode."'");
	 					if ($query->num_rows()==1)
							{
								$row = $query->row();
								$item_id = $row->id;
								$status = $row->status;
								$current_container = $row->container;

								if ($current_container==0 && $status=="new")
									{
										$this->db->query("UPDATE container_item SET container=$container_id WHERE id='".$item_id."'");
							 			redirect("agents/container_fill/".$container_id."/ok");
							 		}
							 		else redirect("agents/container_fill/".$container_id."/item_cant_change_due_to_status");
							}
		
					}
					else//echo '<div class="alert alert-danger" role="alert">Barcode not found</div>';
					redirect("agents/container_fill/".$container_id."/container_not_new");
				}
				else//echo '<div class="alert alert-danger" role="alert">Barcode not found</div>';
				redirect("agents/container_fill/".$container_id."/container_not_found");
		}
		else //echo '<div class="alert alert-danger" role="alert">Barcode, хайрцаг оруулаагүй байна.</div>';
		redirect("agents/boxes_fill/".$box_id."/no_inputs");

?>