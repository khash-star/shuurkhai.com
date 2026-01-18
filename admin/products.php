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
          if (isset($_GET["action"])) $action=protect($_GET["action"]); else $action="dashboard";
			$action_title = "Удирдлага"; // Default value
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
				<li class="breadcrumb-item"><a href="products">Бараа</a></li>
				<li class="breadcrumb-item active" aria-current="page"><?php echo htmlspecialchars($action_title);?></li>
				</ol>
			</nav>


			
							<?php
			if ($action =="dashboard")
			{
				$sql = "SELECT * FROM products";
				$result = mysqli_query($conn,$sql);
				$total = mysqli_num_rows($result);
				?>
				<div class="row">
				<div class="col-12 col-xl-12 stretch-card">
					<div class="row flex-grow">
					<div class="col-md-4 grid-margin stretch-card">
						<div class="card">
						<div class="card-body">
							<div class="d-flex justify-content-between align-items-baseline">
							<h6 class="card-title mb-0">Нийт бүртгэлтэй бараа</h6>
							<div class="dropdown mb-2">
								<button class="btn p-0" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
								</button>
								<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
								<a class="dropdown-item d-flex align-items-center" href="product?action=display"><i data-feather="eye" class="icon-sm mr-2"></i> <span class="">Харах</span></a>
								<a class="dropdown-item d-flex align-items-center" href="#"><i data-feather="download" class="icon-sm mr-2"></i> <span class="">Excel татах</span></a>
								</div>
							</div>
							</div>
							<div class="row">
							<div class="col-6 col-md-12 col-xl-5">
								<h4 class="mb-2"><?php echo number_format($total);?></h4>
								<div class="d-flex align-items-baseline">
								<p class="text-success">
									<span>+3.3%</span>
									<i data-feather="arrow-up" class="icon-sm mb-1"></i>
								</p>
								</div>
							</div>
							<div class="col-6 col-md-12 col-xl-7">
								<div id="apexChart1" class="mt-md-3 mt-xl-0"></div>
							</div>
							</div>
						</div>
						</div>
					</div>
					<div class="col-md-4 grid-margin stretch-card">
						<div class="card">
						<div class="card-body">
							<div class="d-flex justify-content-between align-items-baseline">
							<h6 class="card-title mb-0">Үлдэгдэлтэй бараа</h6>
							<div class="dropdown mb-2">
								<button class="btn p-0" type="button" id="dropdownMenuButton1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
								</button>
								<div class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
								<a class="dropdown-item d-flex align-items-center" href="product?action=active"><i data-feather="eye" class="icon-sm mr-2"></i> <span class="">Харах</span></a>
								<a class="dropdown-item d-flex align-items-center" href="#"><i data-feather="download" class="icon-sm mr-2"></i> <span class="">Excel татах</span></a>
								</div>
							</div>
							</div>
							<div class="row">
							<div class="col-6 col-md-12 col-xl-5">
								<h4 class="mb-2">841</h4>
								<div class="d-flex align-items-baseline">
								<p class="text-danger">
									<span>-2.8%</span>
									<i data-feather="arrow-down" class="icon-sm mb-1"></i>
								</p>
								</div>
							</div>
							<div class="col-6 col-md-12 col-xl-7">
								<div id="apexChart2" class="mt-md-3 mt-xl-0"></div>
							</div>
							</div>
						</div>
						</div>
					</div>
					<div class="col-md-4 grid-margin stretch-card">
						<div class="card">
						<div class="card-body">
							<div class="d-flex justify-content-between align-items-baseline">
							<h6 class="card-title mb-0">Эрэлт ихтэй бараа</h6>
							<div class="dropdown mb-2">
								<button class="btn p-0" type="button" id="dropdownMenuButton2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
								</button>
								<div class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
								<a class="dropdown-item d-flex align-items-center" href="product?action=incoming"><i data-feather="eye" class="icon-sm mr-2"></i> <span class="">Харах</span></a>
								<a class="dropdown-item d-flex align-items-center" href="#"><i data-feather="download" class="icon-sm mr-2"></i> <span class="">Excel татах</span></a>
								</div>
							</div>
							</div>
							<div class="row">
							<div class="col-6 col-md-12 col-xl-5">
								<h4 class="mb-2">98</h4>
								<div class="d-flex align-items-baseline">
								<p class="text-success">
									<span>+2.8%</span>
									<i data-feather="arrow-up" class="icon-sm mb-1"></i>
								</p>
								</div>
							</div>
							<div class="col-6 col-md-12 col-xl-7">
								<div id="apexChart3" class="mt-md-3 mt-xl-0"></div>
							</div>
							</div>
						</div>
						</div>
					</div>
					</div>
				</div>
				</div> <!-- row -->
				<div class="row">
				<div class="col-lg-6">
					<div class="card">
					<div class="card-body">
						<h6 class="card-title">Бараа хайх</h6>
						<form action="products?action=search" method="post">
						<div class="form-group">
							<input type="text" class="form-control" id="search" autocomplete="off" placeholder="Баркод, нэр" name="search">
						</div>
						<button type="submit" class="btn btn-primary mr-2">Хайх</button>
						</form>
					</div>
					</div>
				</div>
				<div class="col-lg-6 grid-margin stretch-card">
					<div class="card">
					<div class="card-body">
						<h6 class="card-title">Барааны ангилал</h6>
						<div id="apexDonut"></div>
					</div>
					</div>
				</div>
				</div>
							<?php
			}
			?>

							<?php
			if ($action =="search")
			{
				if(isset($_POST["search"])) $search = $_POST["search"]; else $search="";
				?>
				<div class="row">
				<div class="col-lg-12">
					<div class="card">
					<div class="card-body">
						<h6 class="card-title">Бараа хайх</h6>
						<form action="products?action=search" method="post">
						<div class="form-group">
							<label for="search">Бараа хайх</label>
							<input type="text" class="form-control" id="search" autocomplete="off" placeholder="Барааны нэр, баркод, орц найрлага, хэрэглэх заавар зэргээс хайх" value="<?php echo htmlspecialchars($search ?? '');?>" name="search"> 
						</div>
						<button type="submit" class="btn btn-primary mr-2">Хайх</button>
						</form>
					</div>
					</div>
				</div>
				</div>
							<?php 
				if (strlen($search)>=3)
				{
				?>
				<div class="row mt-3">
					<div class="col-md-12 grid-margin stretch-card">
					<div class="card">
						<div class="card-body">
							<?php
							$sql= "SELECT * FROM products WHERE CONCAT_WS(name,barcode,code,description,description2,short_name) LIKE '%".$search."%'"; ?>
								
							<?php require_once("views/product_table_display.php");?>
						</div>
					</div>
					</div>
				</div>
							<?php
				}
				
				if (strlen($search)<3)
				{
				?>
				<div class="row mt-3">
					<div class="col-lg-12">
					<div class="card">
						<div class="card-body">
						<div class="alert alert-icon-danger" role="alert">
							<i data-feather="alert-circle"></i>
							Хайх утгыг 3 үсгээс их тэмдэгтээр хайна уу.
						</div>
						</div>
					</div>
					</div>
				</div>
				
							<?php
				}
				
			}
			?>

							<?php
			if ($action =="display")
			{
				?>
				<div class="row">
				<div class="col-md-12 grid-margin stretch-card">
					<div class="card">
					<div class="card-body">
							<?php 
						$sql = "SELECT * FROM products"; 
						?>
							<?php require_once("views/product_table_display.php");?>
					</div>
					</div>
				</div>
				</div>
							<?php
			}
			?>

							<?php
			if ($action =="new")
			{
				
				?>
				<div class="card">
				<div class="card-body">
							<?php
					$sql = "SELECT * FROM products ORDER BY created_date DESC LIMIT 100";
					?>
							<?php require_once("views/product_table_display.php");?>
				</div>
				</div>
							<?php
			}
			?>


							<?php
			if ($action =="categorize")
			{
				if (isset($_GET["category"])) $category_id = $_GET["category"]; else header("location:products?action=category");
				?>
				<div class="card">
					<div class="card-body">
							<?php
						$sql= "SELECT * FROM products WHERE category ='".$category_id."'"; ?>
							
							<?php require_once("views/product_table_display.php");?>
					</div>
				</div>
							<?php
			}
			?>

							<?php
			if ($action =="active")
			{
				?>
				<div class="row">
				<div class="col-md-12 grid-margin stretch-card">
					<div class="card">
					<div class="card-body">
							<?php
						$sql = "SELECT * FROM products ORDER BY updated_date DESC LIMIT 100";
						?>
							<?php require_once("views/product_table_display.php");?>
					</div>
					</div>
				</div>
				</div>
							<?php
			}
			?>

							<?php
			if ($action =="add")
			{
				?>
				
				<form action="products?action=adding" method="post" enctype="multipart/form-data">
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
											$sql = "SELECT * FROM product_category";
											$result= mysqli_query($conn,$sql);
											while ($data = mysqli_fetch_array($result))
											{
												?>
												<option value="<?=$data["id"];?>"><?=$data["name"];?></option>
							<?php
											}
											?>
											</select>
											
										</div>
									</div>


								</div>

								</div>
							</div>

							<div class="card mt-3 mb-3">
								<div class="card-body">
									<div class="media-list">
										<div class="media">
											<div class="media-body mg-l-15 mg-t-4">
												<label for="buy">Үнэ</label>
												<input type="text" name="price" id="price" value="" class="form-control">
											</div>
										</div>

										<div class="media">
											<div class="media-body mg-l-15 mg-t-4">
												<label for="sell">Тээврийн зардал</label>
												<input type="text" name="transportation" id="transportation" value="" class="form-control">
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
									
									
									<div class="media">
										<div class="media-body mg-l-15 mg-t-2">
											<label for="country">Үйлдвэрлэсэн улс</label>
											<select class="form-control" name="country" id="country">
											<option value="0" >Тодорхойгүй</option>
							<?php
											$sql = "SELECT * FROM countries";
											$result= mysqli_query($conn,$sql);
											while ($data = mysqli_fetch_array($result))
											{
												?>
												<option value="<?=$data["id"];?>"><?=$data["name"];?></option>
							<?php
											}
											?>
											</select>
											
										</div>
									</div>

									<div class="media">
										<div class="media-body mg-l-15 mg-t-2">
											<label for="weight">Жин</label>
											<input type="text" name="weight"  id="weight" value="" class="form-control">
										</div>
									</div>


									<div class="media">
										<div class="media-body mg-l-15 mg-t-2">
											<label for="description">Тайлбар/</label>
											<textarea id="description" class="form-control" name="description"></textarea>
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
						<h6 class="slim-card-title">Бараа бүртгэл</label>
						</div><!-- card-header -->
						<div class="card-body">
							<?php
							$name = $_POST["name"];
							$url = $_POST["url"];
							$category = $_POST["category"];
							$country = $_POST["country"];
							$weight = $_POST["weight"];
							$description = mysqli_escape_string($conn,$_POST["description"]);
							$price = $_POST["price"];
							$transportation = $_POST["transportation"];
							$target_file ="";

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

							$sql = "INSERT INTO products
							(
								name,
								url,
								image,
								category,
								produced_country,
								weight,
								description,
								price,
								transportation
							) 
							VALUES (
								'$name',
								'$url',
								'$target_file',
								'$category',
								'$country',
								'$weight',
								'$description',
								'$price',
								'$transportation'
							)";                   
							if (mysqli_query($conn,$sql))
								{
								$product_id = mysqli_insert_id($conn);
								mysqli_query ($conn,"UPDATE product_category SET count=count+1 WHERE id='".$category."' LIMIT 1");
								?>
								<div class="alert alert-success mg-b-10" role="alert">
									Амжилттай бүртгэлээ.
									<button type="button" class="close" data-dismiss="alert" aria-label="Close">
									<span aria-hidden="true">&times;</span>
									</button>
								</div>
								<div class="btn-group">
									<a href="products?action=detail&id=<?php echo htmlspecialchars($product_id ?? '');?>" class="btn btn-success"><i data-feather="edit"></i> Дэлгэрэнгүй</a>
									<a href="products?action=edit&id=<?php echo htmlspecialchars($product_id ?? '');?>" class="btn btn-success"><i data-feather="edit"></i> Засах</a>
									<a href="products?action=new" class="btn btn-primary"><i class="icon ion-ios-list"></i> Шинэ барааны жагсаалт</a>
								</div>
							<?php
								}
								else 
								{
								?>
								<div class="alert alert-danger mg-b-10" role="alert">
								алдаа гарлаа. <?php echo htmlspecialchars(mysqli_error($conn));?>
									<button type="button" class="close" data-dismiss="alert" aria-label="Close">
									<span aria-hidden="true">&times;</span>
									</button>
								</div>
								<div class="btn-group">
									<a href="products?action=add" class="btn btn-success"><i data-feather="edit"></i> Ахин оролдох</a>
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
			if ($action =="detail")
			{
				if (isset($_GET["id"])) $product_id=$_GET["id"]; else header("location:products");
				$sql = "SELECT * FROM products WHERE id='$product_id' LIMIT 1";
				$result= mysqli_query($conn,$sql);
				if (mysqli_num_rows($result)==1)
				{
					$data = mysqli_fetch_array($result);
					$name = $data["name"];
					$url = $data["url"];
					$image = $data["image"];
					$category = $data["category"];
					$country = $data["produced_country"];
					$weight = $data["weight"];
					$description = $data["description"];
					$price = $data["price"];
					$transportation = $data["transportation"];
					?>
					<div class="row">
								<div class="col-lg-6">
									<div class="card">
										<div class="card-body">
										<div class="media-list ">
											<div class="media">
												<div class="media-body mg-l-15 mg-t-4">
													<label for="name">Нэр (*)</label>
													<h4><?php echo htmlspecialchars($name ?? '');?></h4>
												</div>
											</div>
											<div class="media">
												<div class="media-body mg-l-15 mg-t-4">
													<label for="short_name">URL</label>
													<h4><?php echo htmlspecialchars($url ?? '');?></h4>
												</div>
											</div>
											<div class="media">
												<div class="media-body mg-l-15 mg-t-2">
													<label for="category">Ангилал</label>
							<?php
														$sql = "SELECT * FROM product_category WHERE id='$category'";
														$result= mysqli_query($conn,$sql);
														$data = mysqli_fetch_array($result);
														$category_name = $data["name"];
													?>
													<h4><?=$category_name;?></h4>													
												</div>
											</div>


										</div>

										</div>
									</div>

									<div class="card mt-3 mb-3">
										<div class="card-body">
											<div class="media-list">
												<div class="media">
													<div class="media-body mg-l-15 mg-t-4">
														<label for="buy">Үнэ</label>
														<h4><?=number_format($price,2);?></h4>
													</div>
												</div>

												<div class="media">
													<div class="media-body mg-l-15 mg-t-4">
														<label for="sell">Тээврийн зардал</label>
														<h4><?=number_format($transportation,2);?></h4>
													</div>
												</div>
											</div>

										</div>
										
									</div>
								</div>
								<div class="col-lg-6">
									<div class="card">
										<div class="card-body">
							<?php if (isset($image) && $image<>"" && file_exists('../'.$image))
										{
											?><img src="../<?php echo htmlspecialchars($image);?>" style="max-width: 100%;"><?php 
										}
										?>
										<div class="media-list">
										
										
											<div class="media">
												<div class="media-body mg-l-15 mg-t-2">
													<label for="category">Үйлдвэрлэсэн улс</label>
							<?php
														$sql = "SELECT * FROM countries WHERE id='$country'";
														$result= mysqli_query($conn,$sql);
														$data = mysqli_fetch_array($result);
														$country_name = $data["name"];
													?>
													<h4><?=$country_name;?></h4>
												</div>
											</div>

											<div class="media">
												<div class="media-body mg-l-15 mg-t-2">
													<label for="weight">Жин</label>
													<h4><?=$weight;?></h4>
												</div>
											</div>

											<div class="media">
												<div class="media-body mg-l-15 mg-t-2">
													<label for="description">Тайлбар</label>
													<p><?=$description;?></p>
												</div>
											</div>

										</div>
									
									</div>
								</div>
							</div> 

					<div class="btn-group">
					<a href="products?action=edit&id=<?=$product_id;?>" class="btn btn-warning btn-icon-text text-white"><i class="icon ion-ios-list"></i> Засах</a>
					<a href="products" class="btn btn-primary btn-icon-text"><i class="icon ion-ios-list"></i> Бүх бараа</a>
					</div>
					
							<?php
				}
				else header("location:products");
			}
			?>



							<?php
			if ($action =="edit")
			{
				if (isset($_GET["id"])) $product_id=$_GET["id"]; else header("location:products");
				?>
				<form action="products?action=editing" method="post" enctype="multipart/form-data">
					<input type="hidden" name="product_id" value="<?=$product_id;?>">
							<?php
						$sql = "SELECT * FROM products WHERE id='$product_id' LIMIT 1";
						$result= mysqli_query($conn,$sql);
						if (mysqli_num_rows($result)==1)
						{
							$data = mysqli_fetch_array($result);
							$product_id = $data["id"];
							$name = $data["name"];
							$url = $data["url"];
							$image = $data["image"];
							$category = $data["category"];
							$country = $data["produced_country"];
							$weight = $data["weight"];
							$description = $data["description"];
							$price = $data["price"];
							$transportation = $data["transportation"];
							
							?>
							<div class="row">
								<div class="col-lg-6">
									<div class="card">
										<div class="card-body">
										<input type="hidden" name="product_id" value="<?=$product_id;?>">
										<div class="media-list ">
											<div class="media">
												<div class="media-body mg-l-15 mg-t-4">
													<label for="name">Нэр (*)</label>
													<input type="text" name="name" id="name" value="<?=$name;?>" class="form-control" required="required">
												</div>
											</div>
											<div class="media">
												<div class="media-body mg-l-15 mg-t-4">
													<label for="url">URL</label>
													<input type="text" name="url" id="url" value="<?=$url;?>" class="form-control">
												</div>
											</div>
											<div class="media">
												<div class="media-body mg-l-15 mg-t-2">
													<label for="category">Ангилал</label>
													<select class="form-control" name="category" id="category">
													<option value="0" <?=($category=='0')?'SELECTED="SELECTED"':'';?>>Ангилаагүй</option>
							<?php
													$sql = "SELECT * FROM product_category";
													$result= mysqli_query($conn,$sql);
													while ($data = mysqli_fetch_array($result))
													{
														?>
														<option value="<?=$data["id"];?>" <?=($data["id"]==$category)?'SELECTED="SELECTED"':'';?>><?=$data["name"];?></option>
							<?php
													}
													?>
													</select>
													
												</div>
											</div>


										</div>

										</div>
									</div>

									<div class="card mt-3 mb-3">
										<div class="card-body">
											<div class="media-list">
												<div class="media">
													<div class="media-body mg-l-15 mg-t-4">
														<label for="price">Үнэ</label>
														<input type="text" name="price" id="price" value="<?=$price;?>" class="form-control">
													</div>
												</div>

												<div class="media">
													<div class="media-body mg-l-15 mg-t-4">
														<label for="transportation">Тээврийн зардал</label>
														<input type="text" name="transportation" id="transportation" value="<?=$transportation;?>" class="form-control">
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
							<?php if ($image<>"" && file_exists("../".$image))
										{
											?><img src="../<?php echo htmlspecialchars($image ?? '');?>" style="max-width: 100%;"><?php
										}
										?>
										<div class="media-list">
											<div class="media">
												<div class="media-body mg-l-15 mg-t-2">
													<label for="image">Зураг</label>
													<input type="file" id="image" name="image" class="form-control">
												</div>
											</div>
											
											<div class="media">
												<div class="media-body mg-l-15 mg-t-2">
													<label for="country">Үйлдвэрлэсэн улс</label>
													<select class="form-control" name="country" id="country">
													<option value="0" >Тодорхойгүй</option>
							<?php
													$sql = "SELECT * FROM countries";
													$result= mysqli_query($conn,$sql);
													while ($data = mysqli_fetch_array($result))
													{
														?>
														<option value="<?=$data["id"];?>" <?=($data["id"]==$country)?'SELECTED="SELECTED"':'';?>><?=$data["name"];?></option>
							<?php
													}
													?>
													</select>
													
												</div>
											</div>

											<div class="media">
												<div class="media-body mg-l-15 mg-t-2">
													<label for="weight">Жин</label>
													<input type="text" name="weight"  id="weight" value="<?=$weight;?>" class="form-control">
												</div>
											</div>


											<div class="media">
												<div class="media-body mg-l-15 mg-t-2">
													<label for="description">Тайлбар</label>
													<textarea id="description" class="form-control" name="description"><?=$description;?></textarea>
												</div>
											</div>


										</div>
									
									</div>
								</div>
							</div> 
						
							<?php
						}
						else
						{
							?>
							<div class="alert alert-danger mg-b-10" role="alert">
								Бараа олдсонгүй.
								<button type="button" class="close" data-dismiss="alert" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<?php
						}
						?>
					</form>
				<div class="btn-group mt-3">
				<a href="#" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#modaldemo"><i class="icon ion-ios-trash"></i> Устгах</a>
				<a href="products" class="btn btn-primary btn-xs"><i class="icon ion-ios-list"></i> Бүх бүтээгдэхүүн</a>
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
						<a href="products?action=delete&id=<?php echo htmlspecialchars($product_id ?? 0);?>" class="btn btn-danger">Тийм устгах</a>
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
						if (isset($_POST["product_id"])) $product_id=$_POST["product_id"]; else header("location:products");
						$sql = "SELECT * FROM products WHERE id='$product_id' LIMIT 1";
						$result= mysqli_query($conn,$sql);
						if (mysqli_num_rows($result)==1)
						{
							$data = mysqli_fetch_array($result);
							$old_category = $data["category"];

							$name = $_POST["name"];
							$url = $_POST["url"];
							$code = $_POST["code"];
							$category = $_POST["category"];
							$country = $_POST["country"];
							$weight = $_POST["weight"];
							$description = mysqli_escape_string($conn,$_POST["description"]);
							$price = $_POST["price"];
							$transportation = $_POST["transportation"];


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
											
											$sql = "UPDATE products SET image='$target_file' WHERE id='$product_id'";
											mysqli_query($conn,$sql);
										}
									}
							}

							$sql = "UPDATE products SET
							name = '$name',
							url = '$url',
							category = '$category',
							produced_country = '$country',
							weight = '$weight',
							description = '$description',
							price = '$price',
							transportation = '$transportation'
							WHERE id='$product_id' LIMIT 1";
							//echo $sql;
						
							if (mysqli_query($conn,$sql)) 
							{
								mysqli_query ($conn,"UPDATE product SET updated_date='".date("Y-m-d")."' WHERE id='$product_id' LIMIT 1");
								mysqli_query ($conn,"UPDATE product_category SET count=count-1 WHERE id='$old_category' LIMIT 1");
								mysqli_query ($conn,"UPDATE product_category SET count=count+1 WHERE id='$category' LIMIT 1");                            
								
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
								Алдаа гарлаа. <?=mysqli_error($conn);?>
								<button type="button" class="close" data-dismiss="alert" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
								</div>
							<?php
							}


							?>                            
							<div class="btn-group">
							<a href="products?action=edit&id=<?=$product_id;?>" class="btn btn-success"><i data-feather="edit"></i> Засах</a>
							<a href="products" class="btn btn-primary"><i class="icon ion-ios-list"></i> Бүх бүтээгдэхүүн</a>
							</div>
							<?php
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
					<form action="products?action=editing" method="post" enctype="multipart/form-data">
					<div class="card">
						<div class="card-header">
						<h6 class="slim-card-title">Бараа устгах</label>
						</div><!-- card-header -->
						<div class="card-body">
							<?php
							if (isset($_GET["id"])) $id=$_GET["id"]; else header("location:products");
							$sql = "SELECT * FROM products WHERE id=$id LIMIT 1";
							$result= mysqli_query($conn,$sql);
							if (mysqli_num_rows($result)==1)
							{
							$data = mysqli_fetch_array($result);
							if (file_exists("../".$data["image"])) unlink("../".$data["image"]);
							// ORDEr ShALGAH ShAARDLAGATAI

							
							if (mysqli_query($conn,"DELETE FROM products WHERE id=$id")) 
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
									Алдаа гарлаа. <?=mysqli_error($conn);?>
									<button type="button" class="close" data-dismiss="alert" aria-label="Close">
									<span aria-hidden="true">&times;</span>
									</button>
								</div>
							<?php
								}


							?>                            
							<div class="btn-group">
								<a href="products" class="btn btn-primary"><i class="icon ion-ios-list"></i> Бусад бараа</a>
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
				$count =1;
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
							$sql = "SELECT * FROM product_category ORDER BY dd,name";
							$result = mysqli_query($conn,$sql);
							if (mysqli_num_rows($result)>0)
							{
								while ($data = mysqli_fetch_array($result))
								{

								?>
								<tr>
									<td><?=$count++;?></td>
									<td><a href="products?action=category_edit&id=<?=$data["id"];?>"><?=$data["name"];?></a></td>
									<td><a href="products?action=categorize&category=<?=$data["id"];?>"><?=$data["count"];?></a></td>
									<td>
									<div class="btn-group">
										<a href="products?action=category_edit&id=<?=$data["id"];?>" title="Засах"><i data-feather="edit"></i></a>

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
				<a href="products?action=category_new" class="btn btn-success mg-t-10"><i class="icon ion-ios-plus"></i> Ангилал нэмэх</a>
							<?php
			}
			?>

							<?php
			if ($action =="category_new")
			{
				?>
				<div class="card">
				<div class="card-body">
					<form action="products?action=category_adding" method="post" enctype="multipart/form-data">
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
							$name = $_POST["name"];

								$sql = "INSERT INTO product_category (name) VALUES ('$name')";
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
									Алдаа гарлаа. <?=mysqli_error($conn);?>
									<button type="button" class="close" data-dismiss="alert" aria-label="Close">
									<span aria-hidden="true">&times;</span>
									</button>
								</div>
							<?php
								}


							?>                            
							<div class="btn-group">
								<a href="products?action=edit&id=<?=$category_id;?>" class="btn btn-success"><i data-feather="edit"></i> Засах</a>
								<a href="products?action=category" class="btn btn-primary"><i data-feather="list"></i> Бүх ангилал</a>
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
					<form action="products?action=category_editing" method="post" enctype="multipart/form-data">
							<?php
					if (isset($_GET["id"])) $category_id=$_GET["id"]; else header("location:products");
					$sql = "SELECT * FROM product_category WHERE id=$category_id LIMIT 1";
					$result= mysqli_query($conn,$sql);
					if (mysqli_num_rows($result)==1)
					{
						$data = mysqli_fetch_array($result);
						?>
						<input type="hidden" name="id" value="<?=$data["id"];?>">
						<div class="media-list">
						<div class="media">
							<div class="media-body">
							<label for="name">Нэр (*)</label>
							<input type="text" name="name" id="name" value="<?=$data["name"];?>" class="form-control" required="required">
							</div>
						</div>
						</div>
						<input type="submit" class="btn btn-success btn-lg mg-t-10" value="Засах">
							<?php
					}
					?>
					</form>
				</div>
				</div>

				<div class="btn-group mg-t-10">
				<a href="products?action=cateogory_delete&id=<?=$category_id;?>" class="btn btn-danger btn-xs"><i class="icon ion-ios-trash"></i> Устгах</a>
				<a href="products?action=category" class="btn btn-primary btn-xs"><i data-feather="list"></i> Бүх ангилал</a>
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
							if (isset($_POST["id"])) $category_id=$_POST["id"]; else header("location:products");
							$name = $_POST["name"];
							$sql = "UPDATE product_category SET name='$name' WHERE id=$category_id LIMIT 1";
						
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
								Алдаа гарлаа. <?=mysqli_error($conn);?>
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
				<a href="products?action=category_edit&id=<?=$category_id;?>" class="btn btn-success"><i data-feather="edit"></i> Засах</a>
				<a href="products?action=category" class="btn btn-primary btn-xs"><i data-feather="list"></i> Бүх ангилал</a>
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
						if (isset($_GET["id"])) $category_id=$_GET["id"]; else header("location:products");
						$sql = "SELECT * FROM product_category WHERE id=$category_id LIMIT 1";
						$result= mysqli_query($conn,$sql);
						if (mysqli_num_rows($result)==1)
						{
							// ORDEr ShALGAH ShAARDLAGATAI

						
							if (mysqli_query($conn,"DELETE FRom product_category WHERE id=$category_id")) 
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
								Алдаа гарлаа. <?=mysqli_error($conn);?>
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
				<a href="products?action=category" class="btn btn-primary btn-xs"><i data-feather="list"></i> Бүх ангилал</a>
				</div>
							<?php
			}
			?>


		</div>
							<?php  require_once("views/footer.php");?>
		
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