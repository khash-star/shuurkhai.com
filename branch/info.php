<? require_once("views/login_check_admin.php");?>
<? require_once("config.php");?>
<? require_once("views/helper.php");?>
<? require_once("views/init.php");?>
<body>
    <!-- Loader starts-->
    <div class="loader-wrapper">
      <div class="theme-loader">    
        <div class="loader-p"></div>
      </div>
    </div>
    <!-- Loader ends-->
    <? if (isset($_GET["action"])) $action=$_GET["action"]; else $action="list"; 
    ?>

    <!-- page-wrapper Start-->
    <div class="page-wrapper compact-wrapper" id="pageWrapper">
      <? require_once("views/admin_header.php");?>
      <!-- Page Body Start-->
      <div class="page-body-wrapper sidebar-icon">
        <? require_once("views/sidemenu_admin.php");?>
        <div class="page-body dashboard-2-main">
          <!-- Container-fluid starts-->
          <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12 col-xl-12 col-lg-12">
                    <? 
                    if ($action=="list")
                    {
                        ?>
                        <section id="basic-datatable">
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <table class="datatables-basic table">
                                            <thead>
                                                <tr>
                                                    <th>№</th>
                                                    <th>Аймаг</th>
                                                    <th>Сум</th>
                                                    <th>Шинэчлэгдсэн</th>
                                                    <th>Үйлдэл</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?
                                                    $count =0;
                                                    $sql = "SELECT info.*,address_city.name city_name,address_district.name district_name
                                                    FROM info 
                                                    LEFT JOIN address_city ON info.city=address_city.id
                                                    LEFT JOIN address_district ON info.district=address_district.id
                                                    ";
                                                    $result = mysqli_query($conn,$sql);
                                                    while ($data = mysqli_fetch_array($result))
                                                    {
                                                        ?>
                                                        <tr>
                                                            <td><?=++$count;?></td>
                                                            <td><?=$data["city_name"];?></td>
                                                            <td><?=$data["district_name"];?></td>
                                                            <td><?=substr($data["updated_date"],0,10);?></td>
                                                            <td>
                                                                <a class="btn btn-success" href="info?action=edit&id=<?=$data["id"];?>">Засах</a>
                                                                <a class="btn btn-primary" href="info?action=detail&id=<?=$data["id"];?>">Дэлгэрэнгүй</a>
                                                            </td>
                                                        </tr>
                                                        <?
                                                    }
                                                    ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>                           
                        </section>
                        <?
                    }
                    ?>

                    <?
                    if ($action == "detail")
                    {
                        $id = $_GET["id"];
                    
                                $sql = "SELECT *
                                FROM info WHERE id='$id'";
                                $result = mysqli_query($conn,$sql);
                                if (mysqli_num_rows($result)==1)
                                {
                                    $data = mysqli_fetch_array($result);                            
                                    $page_name = $data["name"];
                                    $page_content = $data["content"];
                                    $page_timestamp = $data["timestamp"];

                                    ?>
                                    <div class="blog-detail-wrapper">
                                        <div class="row">
                                            <!-- Blog -->
                                            <div class="col-12">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <h4 class="card-title"><?=$page_name;?></h4>
                                                    
                                                        <?=$page_content;?>
                                                        
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                        
                                            
                                        </div>
                                    </div>
                                    <div class="btn-group">
                                        <a href="info?action=edit&id=<?=$id;?>" class="btn btn-success">Засах</a>
                                        <a href="info?action=list" class="btn btn-primary">Жагсаалт</a>
                                    </div>
                                    <?
                                }
                                else 
                                {
                                    ?>
                                    <div class="alert alert-danger" role="alert">
                                        <div class="alert-body">
                                        Хуудас олдсонгүй
                                        </div>
                                    </div>
                                    <?
                                }
                    }
                    ?>

                    <?
                    if ($action=="edit")
                    {
                         $id = $_GET["id"];
                    
                         $sql = "SELECT info.*,address_city.name city_name,address_district.name district_name
                         FROM info 
                         LEFT JOIN address_city ON info.city=address_city.id
                         LEFT JOIN address_district ON info.district=address_district.id
                         WHERE info.id='$id'";
                        $result = mysqli_query($conn,$sql);
                        if (mysqli_num_rows($result)==1)
                        {
                            $data = mysqli_fetch_array($result);
                            $city_name = $data["city_name"];
                            $district_name = $data["district_name"];
                            $description = $data["description"];
                        

                            ?>
                            <section id="input-group-basic">
                                <form action="info?action=editing" method="post" enctype="multipart/form-data">
                                    <input type="hidden" name="id" value="<?=$id;?>">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="card">
                                            
                                                <div class="card-body">
                                                
                                                    <div class="input-group mt-2 mb-2">
                                                        <input type="text" name="city_name" class="form-control" value="<?=$city_name;?>" readonly>
                                                    </div>

                                                    <div class="input-group mt-2 mb-2">
                                                        <input type="text" name="district_name" class="form-control" value="<?=$district_name;?>" readonly>
                                                    </div>


                                                    <div class="input-group mt-2 mb-2">
                                                        <textarea class="form-control"  name="description" id="summernote"><?=$description;?></textarea>
                                                    </div>

                                                    
                                                </div>

                                                

                                            </div>
                                        </div>

                                    </div>
                                    <input type="submit" class="btn btn-success waves-effect waves-float waves-light" value="Хадгалах">

                                </form>
                            </section>
                        <?
                        }
                        else header("location:info?action=list");
                    }
                    ?>


                    <?
                    if ($action=="editing")
                    {
                        $id = $_POST["id"];
                        $description = mysqli_escape_string($conn,$_POST["description"]);

                    

                        $sql = "UPDATE info SET description='$description' WHERE id='$id'";


                        if (mysqli_query($conn,$sql))
                        {
                            ?>
                            <div class="alert alert-success" role="alert">
                                <div class="alert-body">
                                Амжилттай засагдлаа
                                </div>
                            </div>
                            <?
                        }
                        else 
                        {
                            ?>
                            <div class="alert alert-danger" role="alert">
                                <div class="alert-body">
                                Алдаа гарлаа. <?=mysqli_error($conn);?>
                                </div>
                            </div>
                            <?
                        }
                        ?>
                        <a class="btn btn-success" href="info?action=edit&id=<?=$id;?>">Засах</a>
                        <a class="btn btn-primary" href="info?action=detail&id=<?=$id;?>">Дэлгэрэнгүй</a>
                        <a class="btn btn-primary" href="info?action=list">Сумдууд</a>
                        <?
                        
                    }
                    ?>


                </div>               
            </div>           
          </div>
          <!-- Container-fluid Ends-->
        </div>
        <? require_once("views/footer.php");?>
      </div>
    </div>
    <!-- latest jquery-->
    <script src="assets/js/jquery-3.5.1.min.js"></script>
    <!-- feather icon js-->
    <script src="assets/js/icons/feather-icon/feather.min.js"></script>
    <script src="assets/js/icons/feather-icon/feather-icon.js"></script>
    <!-- Sidebar jquery-->
    <script src="assets/js/sidebar-menu.js"></script>
    <script src="assets/js/config.js"></script>
    <!-- Bootstrap js-->
    <script src="assets/js/bootstrap/popper.min.js"></script>
    <script src="assets/js/bootstrap/bootstrap.min.js"></script>
    <!-- Plugins JS start-->
    <script src="assets/js/chart/chartjs/chart.min.js"></script>
    <script src="assets/js/chart/chartist/chartist.js"></script>
    <script src="assets/js/chart/chartist/chartist-plugin-tooltip.js"></script>
    <script src="assets/js/chart/knob/knob.min.js"></script>
    <script src="assets/js/chart/apex-chart/apex-chart.js"></script>
    <script src="assets/js/chart/apex-chart/stock-prices.js"></script>
    <script src="assets/js/prism/prism.min.js"></script>
    <script src="assets/js/clipboard/clipboard.min.js"></script>
    <script src="assets/js/counter/jquery.waypoints.min.js"></script>
    <script src="assets/js/counter/jquery.counterup.min.js"></script>
    <script src="assets/js/counter/counter-custom.js"></script>
    <script src="assets/js/custom-card/custom-card.js"></script>
    <script src="assets/js/owlcarousel/owl.carousel.js"></script>
    <script src="assets/js/owlcarousel/owl-custom.js"></script>
    <script src="assets/js/dashboard/dashboard_2.js"></script>
    <link href="assets/js/summernote/summernote.min.css" rel="stylesheet">
    <script src="assets/js/summernote/summernote.min.js"></script>

    <!-- Plugins JS Ends-->
    <!-- Theme js-->
    <script src="assets/js/script.js"></script>
    <!-- login js-->
    <script>
          $(function() {
                $('#summernote').summernote({
                    height: ($(window).height() - 300),
                    callbacks: {
                        onImageUpload: function(image) {
                            uploadImage(image[0]);
                        }
                    }
                });

                function uploadImage(image) {
                    var data = new FormData();
                    data.append("image", image);
                    $.ajax({
                        url: 'views/uploader.php',
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: data,
                        type: "post",
                        success: function(url) {
                            var image = $('<img>').attr('src', '<?=settings("base_url");?>' + url);
                            $('#summernote').summernote("insertNode", image[0]);
                        },
                        error: function(data) {
                            //alert("adsada");
                            //console.log(data);
                        }
                    });
                };

            });
     
          
            
    </script>
    <!-- Plugin used-->
  </body>
</html>