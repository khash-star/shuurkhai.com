<?php
    require_once("config.php");
    require_once("views/helper.php");
    require_once("views/login_check.php");
    require_once("views/init.php");
?>
<link rel="stylesheet" href="assets/vendors/datatables.net-bs4/dataTables.bootstrap4.css">

<body class="sidebar-dark">
	<div class="main-wrapper">
		<?php  require_once("views/navbar.php"); ?>
	
		<div class="page-wrapper">
		<?php  require_once("views/sidebar.php"); ?>
				

		<div class="page-content">
			<?php
			if (isset($_GET["action"])) $action=protect($_GET["action"]); else $action="display";
			$action_title = "Дэлгүүр"; // Default value
			switch ($action)
			{
				case "display": $action_title="Бүх бараа";break;
				case "new": $action_title="Шинэхэн бараа";break;
				case "active": $action_title="Их зарагддаг бараа";break;
				case "warehouse": $action_title="Агуулахад байгаа";break;
				case "incoming": $action_title="Ирж буй ачаатай бараа";break;
				case "category": $action_title="барааийн ангилал";break;          
				case "category_new": $action_title="Ангилал нэмэх";break;          
				case "category_adding": $action_title="Ангилал нэмэх";break;          
				case "category_edit": $action_title="Ангилал засах";break;          
				case "category_editing": $action_title="Ангилал засах";break;          
				case "category_delete": $action_title="Ангилал устгах";break;          
				case "categorize": $action_title="Ангилсан бараа";break;
				case "add": $action_title="бараа бүртгэх";break;
				case "adding": $action_title="бараа бүртгэх";break;
				case "detail": $action_title="барааийн дэлгэрэнгүй";break;
				case "edit": $action_title="барааийн мэдээлэл засах";break;
				case "editing": $action_title="барааийн мэдээлэл засах";break;
				case "delete": $action_title="барааийн мэдээлэл устгах";break;
				case "dashboard": $action_title="Удирдлага";break;
				case "search": $action_title="бараа хайх";break;
			}
			?>
			<nav class="page-breadcrumb">
				<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="shops">Дэлгүүр</a></li>
				<li class="breadcrumb-item active" aria-current="page"><?php echo htmlspecialchars($action_title);?></li>
				</ol>
			</nav>
	

            <?php if ($action =="display")
            {
                ?>
                <a href="shops?action=add" class="btn btn-warning mb-3">Шинэ дэлгүүр</a>
                <div class="card">
                <div class="card-body">
                    <table id="datatable1" class="table display responsive nowrap">
                    <thead>
                        <tr>
                        <th class="wd-10p">№</th>
                        <th class="wd-20p">Зураг</th>
                        <th class="wd-20p">Нэр</th>
                        <th class="wd-20p">Ангилал</th>
                        <th class="wd-20p">Нэмсэн</th>
                        <th class="wd-10p">Үйлдэл</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT shops.*,shops_category.name cateogory_name FROM shops LEFT JOIN shops_category ON shops.category=shops_category.id ORDER BY created_date DESC";
                        $result = mysqli_query($conn,$sql);
                        $count = 1;
                        if ($result && mysqli_num_rows($result) > 0)
                        {
                        while ($data = mysqli_fetch_array($result))
                        {
                            if (!$data) continue;
                            $id = isset($data["id"]) ? intval($data["id"]) : 0;
                            $image = isset($data["image"]) ? htmlspecialchars($data["image"]) : '';
                            $name = isset($data["name"]) ? htmlspecialchars($data["name"]) : '';
                            $category_name = isset($data["cateogory_name"]) ? htmlspecialchars($data["cateogory_name"]) : '';
                            $created_date = isset($data["created_date"]) ? htmlspecialchars($data["created_date"]) : '';

                            ?>
                            <tr>
                            <td><?php echo $count++;?></td>
                            <td><?php if ($image != "") echo '<img src="../'.htmlspecialchars($image).'" width="100%">';?></td>
                            <td><?php echo $name;?></td>
                            <td><?php echo $category_name;?></td>
                            <td><?php echo $created_date;?></td>
                            <td class="tx-18">
                                <div class="btn-group">
                                <a href="shops?action=edit&id=<?php echo htmlspecialchars($id);?>"  class="btn btn-warning btn-xs btn-icon text-white" title="Засах"><i data-feather="edit"></i></a>
                                </div>
                            </td>
                            </tr>
                            <?php
                        }
                        }
                        ?>
                    </tbody>
                    </table>
                </div><!-- table-wrapper -->
                </div><!-- section-wrapper -->
                <a href="shops?action=add" class="btn btn-warning mb-3">Шинэ дэлгүүр</a>
                <?php
            }
            ?>

			


			<?php
			if ($action =="add")
			{
				?>
				
				<form action="shops?action=adding" method="post" enctype="multipart/form-data">
					<div class="row">
						<div class="col-lg-6">
							<div class="card">
								<div class="card-body">
								<div class="media-list ">
									<div class="media">
										<div class="media-body mg-l-15 mg-t-4">
											<label for="name">Нэр (*)</label>
											<input type="text" name="name" id="name" value="" class="form-control" required="required">
										</div>
									</div>
									<div class="media">
										<div class="media-body mg-l-15 mg-t-4">
											<label for="short_name">URL</label>
											<input type="text" name="url" id="short_name" value="" class="form-control">
										</div>
									</div>
									<div class="media">
										<div class="media-body mg-l-15 mg-t-2">
											<label for="category">Ангилал</label>
											<select class="form-control" name="category" id="category">
											<option value="0">Ангилаагүй</option>
											<?php
											$sql = "SELECT * FROM shops_category";
											$result = mysqli_query($conn,$sql);
											if ($result) {
												while ($data = mysqli_fetch_array($result))
												{
													if (!$data) continue;
													$cat_id = isset($data["id"]) ? intval($data["id"]) : 0;
													$cat_name = isset($data["name"]) ? htmlspecialchars($data["name"]) : '';
													?>
													<option value="<?php echo htmlspecialchars($cat_id);?>"><?php echo $cat_name;?></option>
													<?php
												}
											}
											?>
											</select>
											
										</div>
									</div>


								</div>

								</div>
							</div>

						<input type="submit" class="btn btn-success btn-lg" value="Оруулах">
						</div>
						<div class="col-lg-6">
							<div class="card">
								<div class="card-body">
								<div class="media-list">
									<div class="media">
										<div class="media-body mg-l-15 mg-t-2">
											<label for="image">Зураг</label>
											<input type="file" id="image" name="image" class="form-control">
										</div>
									</div>
						

								</div>
							
							</div>
						</div>
					</div> 
				</form>
				<?php
			}
			?>


			<?php
			if ($action =="adding")
			{
				?>
				<div class="row row-xs mg-t-10">
				<div class="col-lg-12 order-lg-2">
					<div class="card">
						<div class="card-header">
						<h6 class="slim-card-title">Дэлгүүр бүртгэл</label>
						</div><!-- card-header -->
						<div class="card-body">
							<?php
							$name = isset($_POST["name"]) ? protect($_POST["name"]) : '';
							$url = isset($_POST["url"]) ? protect($_POST["url"]) : '';
							$category = isset($_POST["category"]) ? intval($_POST["category"]) : 0;
							$target_file = "";

							if(isset($_FILES['image']) && $_FILES['image']['name']!="")
							{
								if ($_FILES['image']['name']!="")
									{                        
										@$folder = date("Ym");
										if(!file_exists('../uploads/'.$folder))
										mkdir ( '../uploads/'.$folder);
										$target_dir = '../uploads/'.$folder;
										$target_file = $target_dir."/".@date("his").rand(0,1000). basename($_FILES["image"]["name"]);
										if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file))
										{
										// $thumb_image_content = resize_image($target_file,300,200);
										// $thumb = substr($target_file,0,-4)."_thumb".substr($target_file,-4,4);
										// imagejpeg($thumb_image_content,$thumb,75);
										$target_file = substr($target_file,3);
										//$thumb = substr($thumb,3);
										}
									}
							}

							$name_escaped = mysqli_real_escape_string($conn, $name);
							$url_escaped = mysqli_real_escape_string($conn, $url);
							$target_file_escaped = mysqli_real_escape_string($conn, $target_file);
							
							$sql = "INSERT INTO shops
							(
								name,
								url,
								image,
								category
							) 
							VALUES (
								'$name_escaped',
								'$url_escaped',
								'$target_file_escaped',
								'$category'
							)";                   
							if (mysqli_query($conn,$sql))
								{
								$shop_id = mysqli_insert_id($conn);
								mysqli_query ($conn,"UPDATE shops_category SET count=count+1 WHERE id='".$category."' LIMIT 1");
								?>
								<div class="alert alert-success mg-b-10" role="alert">
									Амжилттай бүртгэлээ.
									<button type="button" class="close" data-dismiss="alert" aria-label="Close">
									<span aria-hidden="true">&times;</span>
									</button>
								</div>
								<div class="btn-group">
									<a href="shops?action=edit&id=<?php echo htmlspecialchars($shop_id ?? 0);?>" class="btn btn-success"><i data-feather="edit"></i> Засах</a>
									<a href="shops?action=add" class="btn btn-primary"><i data-feather="list"></i> Бүх дэлгүүр</a>
								</div>
								<?php
								}
								else 
								{
								?>
								<div class="alert alert-danger mg-b-10" role="alert">
								алдаа гарлаа. <?php echo $conn ? htmlspecialchars(mysqli_error($conn)) : 'Database connection error';?>
									<button type="button" class="close" data-dismiss="alert" aria-label="Close">
									<span aria-hidden="true">&times;</span>
									</button>
								</div>
								<div class="btn-group">
									<a href="shops?action=add" class="btn btn-success"><i data-feather="edit"></i> Ахин оролдох</a>
								</div>
								<?php
								}


							?>                            
							
							

						</div>
					</div>
					</form>
				</div>
				</div>
				<?php
			}
			?>


			<?php
			if ($action =="edit")
			{
				if (isset($_GET["id"])) {
					$shop_id = intval(protect($_GET["id"]));
				} else {
					header("location:shops");
					exit;
				}
				?>
				<form action="shops?action=editing" method="post" enctype="multipart/form-data">
					<?php
						$shop_id_escaped = mysqli_real_escape_string($conn, $shop_id);
						$sql = "SELECT * FROM shops WHERE id=" . $shop_id_escaped . " LIMIT 1";
						$result = mysqli_query($conn,$sql);
						if ($result && mysqli_num_rows($result) == 1)
						{
							$data = mysqli_fetch_array($result);
							if (!$data) {
								echo "Мэдээлэл олдсонгүй.";
							} else {
								$data_shop_id = isset($data["id"]) ? intval($data["id"]) : 0;
								$name = isset($data["name"]) ? htmlspecialchars($data["name"]) : '';
								$url = isset($data["url"]) ? htmlspecialchars($data["url"]) : '';
								$image = isset($data["image"]) ? htmlspecialchars($data["image"]) : '';
								$category = isset($data["category"]) ? intval($data["category"]) : 0;
							
							?>
							<input type="hidden" name="shop_id" value="<?php echo htmlspecialchars($data_shop_id);?>">
							<div class="row">
								<div class="col-lg-6">
									<div class="card">
										<div class="card-body">
										<input type="hidden" name="shop_id" value="<?php echo htmlspecialchars($data_shop_id);?>">
										<div class="media-list ">
											<div class="media">
												<div class="media-body mg-l-15 mg-t-4">
													<label for="name">Нэр (*)</label>
													<input type="text" name="name" id="name" value="<?php echo $name;?>" class="form-control" required="required">
												</div>
											</div>
											<div class="media">
												<div class="media-body mg-l-15 mg-t-4">
													<label for="url">URL</label>
													<input type="text" name="url" id="url" value="<?php echo $url;?>" class="form-control">
												</div>
											</div>
											<div class="media">
												<div class="media-body mg-l-15 mg-t-2">
													<label for="category">Ангилал</label>
													<select class="form-control" name="category" id="category">
													<option value="0" <?php echo ($category==0)?'SELECTED="SELECTED"':'';?>>Ангилаагүй</option>
													<?php
													$sql = "SELECT * FROM shops_category";
													$result = mysqli_query($conn,$sql);
													if ($result) {
														while ($cat_data = mysqli_fetch_array($result))
														{
															if (!$cat_data) continue;
															$cat_id = isset($cat_data["id"]) ? intval($cat_data["id"]) : 0;
															$cat_name = isset($cat_data["name"]) ? htmlspecialchars($cat_data["name"]) : '';
															$selected = ($cat_id == $category) ? 'SELECTED="SELECTED"' : '';
															?>
															<option value="<?php echo htmlspecialchars($cat_id);?>" <?php echo $selected;?>><?php echo $cat_name;?></option>
															<?php
														}
													}
													?>
													</select>
													
												</div>
											</div>


										</div>

										</div>
									</div>

								<input type="submit" class="btn btn-success btn-lg" value="Засах">
								</div>
								<div class="col-lg-6">
									<div class="card">
										<div class="card-body">
										<?php if ($image != "" && file_exists("../".$image))
										{
											?><img src="../<?php echo htmlspecialchars($image);?>" style="max-width: 100%;"><?php
										}
										?>
										<div class="media-list">
											<div class="media">
												<div class="media-body mg-l-15 mg-t-2">
													<label for="image">Зураг</label>
													<input type="file" id="image" name="image" class="form-control">
												</div>
											</div>
										</div>
									
									</div>
								</div>
							</div> 
						
							<?php
							}
						}
						?>
					</form>
				<div class="btn-group mt-3">
				<a href="#" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#modaldemo"><i class="icon ion-ios-trash"></i> Устгах</a>
				<a href="shops" class="btn btn-primary btn-xs"><i class="icon ion-ios-list"></i> Бүх дэлгүүр</a>
				</div>


				<div id="modaldemo" class="modal fade">
				<div class="modal-dialog" role="document">
					<div class="modal-content tx-size-sm">
					<div class="modal-body tx-center pd-y-20 pd-x-20">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
						</button>
						<i class="icon icon ion-ios-close-outline tx-100 tx-danger lh-1 mg-t-20 d-inline-block"></i>
						<h4 class="tx-danger mg-b-20">Устгахад итгэлтэй байна уу!</h4>
						<p class="mg-b-20 mg-x-20">Ахин сэргээх боломжгүйгээр устах болно.</p>
						<a href="shops?action=delete&id=<?php echo htmlspecialchars($shop_id ?? 0);?>" class="btn btn-danger">Тийм устгах</a>
						<button type="button" class="btn btn-success pd-x-25" data-dismiss="modal" aria-label="Close">Үгүй, үлдээе</button>
					</div><!-- modal-body -->
					</div><!-- modal-content -->
				</div><!-- modal-dialog -->
				</div><!-- modal -->
				
				<?php
			}
			?>


			<?php
			if ($action =="editing")
			{
				?>
				<div class="row row-xs mg-t-10">
				<div class="col-lg-12 mg-t-10 order-lg-2">
					<div class="card">
					<div class="card-header">
						<h6 class="slim-card-title">Бараа засах</label>
					</div><!-- card-header -->
					<div class="card-body">
						<?php
						if (isset($_POST["shop_id"])) $shop_id=$_POST["shop_id"]; else header("location:shops");
						$shop_id_escaped = mysqli_real_escape_string($conn, $shop_id);
						$sql = "SELECT * FROM shops WHERE id=" . $shop_id_escaped . " LIMIT 1";
						$result = mysqli_query($conn,$sql);
						if ($result && mysqli_num_rows($result) == 1)
						{
							$data = mysqli_fetch_array($result);
							if (!$data) {
								echo "Мэдээлэл олдсонгүй.";
							} else {
								$old_category = isset($data["category"]) ? intval($data["category"]) : 0;
								$old_image = isset($data["image"]) ? $data["image"] : '';

								$name = isset($_POST["name"]) ? protect($_POST["name"]) : '';
								$url = isset($_POST["url"]) ? protect($_POST["url"]) : '';
								$category = isset($_POST["category"]) ? intval($_POST["category"]) : 0;


								if(isset($_FILES['image']) && $_FILES['image']['name']!="")
								{
									if ($_FILES['image']['name']!="")
										{                        
											@$folder = date("Ym");
											if(!file_exists('../uploads/'.$folder))
											mkdir ( '../uploads/'.$folder);
											$target_dir = '../uploads/'.$folder;
											$target_file = $target_dir."/".@date("his").rand(0,1000). basename($_FILES["image"]["name"]);
											if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file))
											{
												// $thumb_image_content = resize_image($target_file,300,200);
												// $thumb = substr($target_file,0,-4)."_thumb".substr($target_file,-4,4);
												// imagejpeg($thumb_image_content,$thumb,75);
												$target_file = substr($target_file,3);
												//$thumb = substr($thumb,3);
												
												$target_file_escaped = mysqli_real_escape_string($conn, $target_file);
												$update_image_sql = "UPDATE shops SET image='$target_file_escaped' WHERE id=" . $shop_id_escaped;
												mysqli_query($conn, $update_image_sql);
												if ($old_image && file_exists('../'.$old_image)) unlink ('../'.$old_image);
											}
										}
								}

								$name_escaped = mysqli_real_escape_string($conn, $name);
								$url_escaped = mysqli_real_escape_string($conn, $url);
								$sql = "UPDATE shops SET
								name = '$name_escaped',
								url = '$url_escaped',
								category = '$category'
								WHERE id=" . $shop_id_escaped . " LIMIT 1";
								//echo $sql;
							
								if (mysqli_query($conn,$sql)) 
								{
									mysqli_query ($conn,"UPDATE shops_category SET count=count-1 WHERE id=" . intval($old_category) . " LIMIT 1");
									mysqli_query ($conn,"UPDATE shops_category SET count=count+1 WHERE id=" . intval($category) . " LIMIT 1");                            
									
									?>
									<div class="alert alert-success mg-b-10" role="alert">
									Амжилттай шинэчиллээ.
									<button type="button" class="close" data-dismiss="alert" aria-label="Close">
										<span aria-hidden="true">&times;</span>
									</button>
									</div>
									<?php
								}
								else 
								{
									?>
									<div class="alert alert-danger mg-b-10" role="alert">
									Алдаа гарлаа. <?php echo $conn ? htmlspecialchars(mysqli_error($conn)) : 'Database connection error';?>
									<button type="button" class="close" data-dismiss="alert" aria-label="Close">
										<span aria-hidden="true">&times;</span>
									</button>
									</div>
									<?php
								}


								?>                            
								<div class="btn-group">
								<a href="shops?action=edit&id=<?php echo htmlspecialchars($shop_id);?>" class="btn btn-success"><i data-feather="edit"></i> Засах</a>
								<a href="shops" class="btn btn-primary"><i class="icon ion-ios-list"></i> Бүх дэлгүүр</a>
								</div>
								<?php
							}
						}
						?>
					</div>
					</div>
				</div><!-- col-12 -->
				</div>
				<?php
			}
			?>


			<?php
			if ($action =="delete")
			{
				?>
				<div class="row row-xs mg-t-10">
				<div class="col-lg-12 mg-1-10 order-lg-2">
					<form action="shops?action=editing" method="post" enctype="multipart/form-data">
					<div class="card">
						<div class="card-header">
						<h6 class="slim-card-title">Дэлгүүр устгах</label>
						</div><!-- card-header -->
						<div class="card-body">
							<?php
							if (isset($_GET["id"])) $id=$_GET["id"]; else header("location:shops");
							$id_escaped = mysqli_real_escape_string($conn, $id);
							$sql = "SELECT * FROM shops WHERE id=" . $id_escaped . " LIMIT 1";
							$result = mysqli_query($conn,$sql);
							if ($result && mysqli_num_rows($result) == 1)
							{
							$data = mysqli_fetch_array($result);
							if ($data) {
								$data_image = isset($data["image"]) ? $data["image"] : '';
								if ($data_image && file_exists("../".$data_image)) unlink("../".$data_image);
							}
							// ORDEr ShALGAH ShAARDLAGATAI

							
							$delete_sql = "DELETE FROM shops WHERE id=" . $id_escaped;
							if (mysqli_query($conn, $delete_sql)) 
								{
								?>
								<div class="alert alert-success mg-b-10" role="alert">
									Устгагдлаа.
									<button type="button" class="close" data-dismiss="alert" aria-label="Close">
									<span aria-hidden="true">&times;</span>
									</button>
								</div>
								<?php
								}
								else 
								{
								?>
								<div class="alert alert-danger mg-b-10" role="alert">
									Алдаа гарлаа. <?php echo $conn ? htmlspecialchars(mysqli_error($conn)) : 'Database connection error';?>
									<button type="button" class="close" data-dismiss="alert" aria-label="Close">
									<span aria-hidden="true">&times;</span>
									</button>
								</div>
								<?php
								}


							?>                            
							<div class="btn-group">
								<a href="shops" class="btn btn-primary"><i class="icon ion-ios-list"></i> Бүх дэлгүүр</a>
							</div>
								<?php
							}
							?>
						</div>
					</div>
					</form>
				</div>
				</div>
				<?php
			}
			?>


			<!--------------------------------------------------------->
			<!--------------------------------------------------------->
			<!---------------------C A T E G O R Y--------------------->
			<!--------------------------------------------------------->
			<!--------------------------------------------------------->


			<?php
			if ($action =="category")
			{
				$count = 1;
				?>
				<div class="row">
				<div class="col-md-12 grid-margin stretch-card">
					<div class="card">
					<div class="card-body">
						<div class="table-responsive">
						<table class="table responsive">
							<thead>
							<tr>
								<th class="wd-5p">№</th>
								<th class="wd-200p">Ангиллын нэр</th>
								<th class="wd-10p">Бараа</th>
								<th class="wd-5p">Үйлдэл</th>
							</tr>
							</thead>
							<tbody>
							<?php
							$sql = "SELECT * FROM shops_category ORDER BY dd,name";
							$result = mysqli_query($conn,$sql);
							if ($result && mysqli_num_rows($result) > 0)
							{
								while ($data = mysqli_fetch_array($result))
								{
									if (!$data) continue;
									$cat_id = isset($data["id"]) ? intval($data["id"]) : 0;
									$cat_name = isset($data["name"]) ? htmlspecialchars($data["name"]) : '';
									$cat_count = isset($data["count"]) ? intval($data["count"]) : 0;

								?>
								<tr>
									<td><?php echo $count++;?></td>
									<td><a href="shops?action=category_edit&id=<?php echo htmlspecialchars($cat_id);?>"><?php echo $cat_name;?></a></td>
									<td><a href="shops?action=categorize&category=<?php echo htmlspecialchars($cat_id);?>"><?php echo $cat_count;?></a></td>
									<td>
									<div class="btn-group">
										<a href="shops?action=category_edit&id=<?php echo htmlspecialchars($cat_id);?>" title="Засах"><i data-feather="edit"></i></a>

									</div>
									</td>
								</tr>
								<?php
								}
							}
							?>
							</tbody>
						</table>
						</div>
					</div>
					</div>
				</div>
				</div>
				<a href="shops?action=category_new" class="btn btn-success mg-t-10"><i class="icon ion-ios-plus"></i> Ангилал нэмэх</a>
				<?php
			}
			?>

			<?php
			if ($action =="category_new")
			{
				?>
				<div class="card">
				<div class="card-body">
					<form action="shops?action=category_adding" method="post" enctype="multipart/form-data">
					<div class="media-list ">
						<div class="media">
						<div class="media-body mg-l-15 mg-t-4">
							<label for="name">Нэр (*)</label>
							<input type="text" name="name" id="name" class="form-control" required="required">
						</div>
						</div>
					</div>
					<input type="submit" class="btn btn-success btn-lg mg-t-10" value="Үүсгэх">
					</form>
				</div>
				</div>
				<?php
			}
			?>

			<?php
			if ($action =="category_adding")
			{
				?>
				<div class="card">
				<div class="card-body">
							<?php
							$name = isset($_POST["name"]) ? protect($_POST["name"]) : '';

								$name_escaped = mysqli_real_escape_string($conn, $name);
								$sql = "INSERT INTO shops_category (name) VALUES ('$name_escaped')";
								if (mysqli_query($conn,$sql))
								{
								$category_id = mysqli_insert_id($conn);
								?>
								<div class="alert alert-success mg-b-10" role="alert">
									Амжилттай нэмэгдлээ.
									<button type="button" class="close" data-dismiss="alert" aria-label="Close">
									<span aria-hidden="true">&times;</span>
									</button>
								</div>
								<?php
								}
								else 
								{
								?>
								<div class="alert alert-danger mg-b-10" role="alert">
									Алдаа гарлаа. <?php echo $conn ? htmlspecialchars(mysqli_error($conn)) : 'Database connection error';?>
									<button type="button" class="close" data-dismiss="alert" aria-label="Close">
									<span aria-hidden="true">&times;</span>
									</button>
								</div>
								<?php
								}


							?>                            
							<div class="btn-group">
								<a href="shops?action=edit&id=<?=$category_id;?>" class="btn btn-success"><i data-feather="edit"></i> Засах</a>
								<a href="shops?action=category" class="btn btn-primary"><i data-feather="list"></i> Бүх ангилал</a>
							</div>
						</div>
					</div>
					</form>
				</div>
				</div>
				<?php
			}
			?>


			<?php
			if ($action =="category_edit")
			{
				?>
				<div class="card">
				<div class="card-body">
					<form action="shops?action=category_editing" method="post" enctype="multipart/form-data">
					<?php
					if (isset($_GET["id"])) {
						$category_id = intval(protect($_GET["id"]));
					} else {
						header("location:shops");
						exit;
					}
					$category_id_escaped = mysqli_real_escape_string($conn, $category_id);
					$sql = "SELECT * FROM shops_category WHERE id=" . $category_id_escaped . " LIMIT 1";
					$result = mysqli_query($conn,$sql);
					if ($result && mysqli_num_rows($result) == 1)
					{
						$data = mysqli_fetch_array($result);
						if (!$data) {
							echo "Мэдээлэл олдсонгүй.";
						} else {
							$data_id = isset($data["id"]) ? intval($data["id"]) : 0;
							$data_name = isset($data["name"]) ? htmlspecialchars($data["name"]) : '';
						?>
						<input type="hidden" name="id" value="<?php echo htmlspecialchars($data_id);?>">
						<div class="media-list">
						<div class="media">
							<div class="media-body">
							<label for="name">Нэр (*)</label>
							<input type="text" name="name" id="name" value="<?php echo $data_name;?>" class="form-control" required="required">
							</div>
						</div>
						</div>
						<input type="submit" class="btn btn-success btn-lg mg-t-10" value="Засах">
						<?php
						}
					}
					?>
					</form>
				</div>
				</div>

				<div class="btn-group mg-t-10">
				<a href="shops?action=cateogory_delete&id=<?php echo htmlspecialchars($category_id ?? 0);?>" class="btn btn-danger btn-xs"><i class="icon ion-ios-trash"></i> Устгах</a>
				<a href="shops?action=category" class="btn btn-primary btn-xs"><i data-feather="list"></i> Бүх ангилал</a>
				</div>
				<?php
			}
			?>


			<?php
			if ($action =="category_editing")
			{
				?>
				<div class="card">
					<div class="card-body">                
							<?php
							if (isset($_POST["id"])) {
								$category_id = intval(protect($_POST["id"]));
							} else {
								header("location:shops");
								exit;
							}
							$name = isset($_POST["name"]) ? protect($_POST["name"]) : '';
							$name_escaped = mysqli_real_escape_string($conn, $name);
							$category_id_escaped = mysqli_real_escape_string($conn, $category_id);
							$sql = "UPDATE shops_category SET name='$name_escaped' WHERE id=" . $category_id_escaped . " LIMIT 1";
						
							if (mysqli_query($conn,$sql)) 
								{
								?>
								<div class="alert alert-success mg-b-10" role="alert">
									Амжилттай шинэчиллээ.
									<button type="button" class="close" data-dismiss="alert" aria-label="Close">
									<span aria-hidden="true">&times;</span>
									</button>
								</div>
								<?php
								}
								else 
								{
								?>
								<div class="alert alert-danger mg-b-10" role="alert">
								Алдаа гарлаа. <?php echo $conn ? htmlspecialchars(mysqli_error($conn)) : 'Database connection error';?>
									<button type="button" class="close" data-dismiss="alert" aria-label="Close">
									<span aria-hidden="true">&times;</span>
									</button>
								</div>
								<?php
								}


							?>                            
							
						</div>
					</div>
				
				<div class="btn-group mg-t-10">
				<a href="shops?action=category_edit&id=<?php echo htmlspecialchars($category_id ?? 0);?>" class="btn btn-success"><i data-feather="edit"></i> Засах</a>
				<a href="shops?action=category" class="btn btn-primary btn-xs"><i data-feather="list"></i> Бүх ангилал</a>
				</div>
				<?php
			}
			?>


			<?php
			if ($action =="category_delete")
			{
				?>
				<div class="row row-xs mg-t-10">
				
				<div class="col-lg-12 mg-t-10 order-lg-2">
					<div class="card card-product-overview">
					<div class="card-header">
						<h6 class="slim-card-title">Мэдээний ангилал устгах</h6>
					</div><!-- card-header -->
					<div class="card-body">
						<?php
						if (isset($_GET["id"])) $category_id=$_GET["id"]; else header("location:shops");
						$category_id_escaped = mysqli_real_escape_string($conn, $category_id);
						$sql = "SELECT * FROM shops_category WHERE id=" . $category_id_escaped . " LIMIT 1";
						$result = mysqli_query($conn,$sql);
						if ($result && mysqli_num_rows($result) == 1)
						{
							// ORDEr ShALGAH ShAARDLAGATAI

						
							$delete_sql = "DELETE FROM shops_category WHERE id=" . $category_id_escaped;
							if (mysqli_query($conn, $delete_sql)) 
							{
								?>
								<div class="alert alert-success mg-b-10" role="alert">
								Устгагдлаа.
								<button type="button" class="close" data-dismiss="alert" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
								</div>
								<?php
							}
							else 
							{
								?>
								<div class="alert alert-danger mg-b-10" role="alert">
								Алдаа гарлаа. <?php echo $conn ? htmlspecialchars(mysqli_error($conn)) : 'Database connection error';?>
								<button type="button" class="close" data-dismiss="alert" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
								</div>
								<?php
							}
						}
						?>
					</div>
					</div>
				</div>
				</div>
				<div class="btn-group mg-t-10">
				<a href="shops?action=category" class="btn btn-primary btn-xs"><i data-feather="list"></i> Бүх ангилал</a>
				</div>
				<?php
			}
			?>


		</div>
		<?php require_once("views/footer.php");?>
		
		</div>
	</div>

	<!-- core:js -->
	<script src="assets/vendors/core/core.js"></script>
	<!-- endinject -->
  
	<!-- inject:js -->
	<script src="assets/vendors/feather-icons/feather.min.js"></script>
	<script src="assets/js/template.js"></script>
	<script src="assets/vendors/apexcharts/apexcharts.min.js"></script>

	<script src="assets/vendors/chartjs/Chart.min.js"></script>
	<script src="assets/vendors/datatables.net/jquery.dataTables.js"></script>
	<script src="assets/vendors/datatables.net-bs4/dataTables.bootstrap4.js"></script>
	<script src="assets/js/data-table.js"></script>
	<script src="assets/js/jquery.chained.min.js"></script>
	<script src="assets/js/dashboard.js"></script>
	<script src="assets/js/apexcharts.js"></script>

	<script>
	$(document).ready(function() {
		$("#district").chained("#city");
	})
	</script>	<!-- endinject -->

</body>
</html>    