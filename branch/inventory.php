<? require_once("views/login_check.php");?>
<? require_once("config.php");?>
<? require_once("views/helper.php");?>
<? require_once("views/init.php");?>
    <script src="assets/js/FileSaver.js"></script>
    <script src="assets/js/tableExport.min.js"></script>



<body>
    <!-- Loader starts-->
    <!-- <div class="loader-wrapper">
      <div class="theme-loader">    
        <div class="loader-p"></div>
      </div>
    </div> -->
    <!-- Loader ends-->
    <!-- page-wrapper Start-->
    <div class="page-wrapper compact-wrapper" id="pageWrapper">
      <? require_once("views/header.php");?>
      <!-- Page Body Start-->
      <div class="page-body-wrapper sidebar-icon">
        <? require_once("views/sidemenu.php");?>
        <div class="page-body dashboard-2-main">
          <!-- Container-fluid starts-->
          <div class="container-fluid">
                <?  
                if (isset($_GET["action"])) $action =$_GET["action"]; else $action = "list";

            
                if ($action=="list")
                    {
                    ?>
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                    <div class="col-sm-12">
                                    <a class="btn btn-pill btn-warning btn-sm" href="?action=new">+ Scan parcel </a>
                                    <a class="btn btn-pill btn-success btn-sm" href="?action=prepare_all">Prepare all parcels </a>
                                    <table class="table table-stripe table-hover">
                                        <thead>
                                            <tr>
                                                <th>№</th>
                                                <th width="100px">image</th>
                                                <th>Track</th>
                                                <th>Created</th>
                                                <th>Comment</th>                                                
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?
                                            $count=$sum_weight =0;
                                            $sql= "SELECT branch_inventories.*
                                            FROM branch_inventories 
                                            WHERE branch_inventories.branch='$g_logged_id' AND status='new' ORDER BY id DESC";
                                            $result = mysqli_query($conn,$sql);
                                            while ($inventory = mysqli_fetch_array($result))
                                            {
                                                ?>
                                                <tr>
                                                    <td><?=++$count;?></td>
                                                    <td width="100px">
                                                        <?
                                                        if (($inventory["image"]!="") && file_exists('../'.$inventory["image"])) echo '<a href="../'.$inventory["image"].'" target="new"><img src="../'.$inventory["image"].'" class="w-100"></a>';?>
                                                    </td>
                                                    <td><?=$inventory["track"];?></td>
                                                    <td><?=substr($inventory["created_date"],0,10);?></td>
                                                    <td><?=$inventory["comment"];?></td>
                                                    <td><?=$inventory["status"];?></td>
                                                    <td>
                                                        <div class="btn-group">
                                                            <a href="?action=delete&id=<?=$inventory["id"];?>" class="btn btn-danger btn-sm">Delete</a>
                                                            <a href="?action=prepare&id=<?=$inventory["id"];?>" class="btn btn-warning btn-sm">Prepare</a>
                                                        </div>
                                                    </td>
                                                    
                                                </tr>
                                                <?
                                                $sum_weight+=$inventory["weight"];
                                            }
                                            ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th></th>
                                                <th colspan="2">Total: <?=$count;?></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>   
                                                <th></th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                    </div>                               
                            </div>                                                    
                        </div>
                    </div>
                    <?
                    }

                if ($action=="new")
                    {
                            ?>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="card">
                                        <div class="card-body">
                                            <form action="?action=adding" method="POST" enctype="multipart/form-data">
                                                <fieldset id="personal-details ">
                                                    <div class="form-group required">
                                                        <label class="control-label">Track</label>
                                                        <input type="text" name="track" value="" class="form-control" required tabindex="0" autofocus>                                            
                                                    </div>

                                                    <!-- <i class="text-danger">Weight in KG. Eg: 0.5</i>
                                                    <div class="form-group required">
                                                        <label class="control-label">Weight</label>
                                                        <input type="text" name="weight" value="" class="form-control" required>                                            
                                                    </div> -->

                                                    <div class="form-group required">
                                                        <label class="control-label">Comment</label>
                                                        <textarea name="comment" class="form-control"></textarea>                                                        
                                                    </div>

                                                    <i class="text-danger">Parcel photo is optional, if need provide</i>   
                                                    <div class="form-group required">
                                                        <label class="control-label">Photo</label>
                                                        <input type="file" name="image">  
                                                    </div>         
                                                </fieldset>
                                                <br>
                                                <input type="submit" class="btn btn-success" value="Save">
                                            </form>
                                        </div>
                                    </div>                                    
                                </div>
                            </div>
                            <?
                        
                    }


                if ($action=="adding")
                    {
                        ?>
                            <div class="row">
                                <div class="col-sm-12">
                                    <?
                                    $track = trim($_POST["track"]);
                                    // $weight = floatval($_POST["weight"]);  
                                    $comment = mysqli_escape_string($conn,$_POST["comment"]);
                                    $image = '';
                                    if(isset($_FILES['image']) && $_FILES['image']['name']!="")
                                    {
                                        if ($_FILES['image']['name']!="")
                                            {                        
                                                @$folder = date("Ym");
                                                if(!file_exists('../uploads/'.$folder))
                                                mkdir ( '../uploads/'.$folder);
                                                $target_dir = '../uploads/'.$folder;
                                                $target_file = $target_dir."/".@date("his").rand(0,1000). basename($_FILES["image"]["name"]);
                                                move_uploaded_file($_FILES['image']['tmp_name'], $target_file);
                                                $image  = substr($target_file,3);
                                            }
                                    }                                

                                    $sql = "SELECT *FROM branch_inventories WHERE track='$track'";
                                    $result = mysqli_query($conn,$sql);
                                    if (mysqli_num_rows($result)==0)
                                    {
                                        $sql = "INSERT INTO branch_inventories 
                                        (track,comment,image,branch)
                                        VALUE ('$track','$comment','$image','$g_logged_id')";
                                        if (mysqli_query($conn,$sql))
                                        {
                                            $inventory_id = mysqli_insert_id($conn);                                                                   
                                            echo '<div class="alert alert-success">Succesfully added</div>';       
                                            // header("location:?action=list");
                                            ?>
                                            <script>
                                                window.location.replace("inventory?action=new");
                                            </script>
                                            <?

                                        }
                                        else 
                                        echo '<div class="alert alert-danger">Error occured '.mysqli_error($conn).'</div>';      
                                    }
                                    else 
                                    echo '<div class="alert alert-danger">Already exists</div>';                                            

                                    ?>
                                    <a href="?action=list" class="btn btn-primary">List</a>
                                </div>
                            </div>                    
                        <?
                        
                        $order_id = tracksearch($track);
                        if ($order_id<>"")
                        {
                            $sql = "SELECT * FROM orders WHERE order_id = '$order_id'";
                            $result = mysqli_query($conn,$sql);
                            $data = mysqli_fetch_array($result);
                            $status= $data["status"];
                                if ($status=="weight_missing") 
                                {
                                    $sql = "UPDATE orders SET status='received',received_date='".date("Y-m-d H:i:s")."' WHERE order_id = '$order_id'";
                                    mysqli_query($conn,$sql);
                                }
                        }               

                    }

                if ($action=="detail")
                    {
                        if (isset($_GET["id"])) $inventory_id = $_GET["id"]; //else header("location:inventory");
                        $sql = "SELECT *FROM branch_inventories WHERE id='$inventory_id' AND `branch`='$g_logged_id' LIMIT 1";
                        // echo $sql;
                        $result = mysqli_query($conn,$sql);
                        if (mysqli_num_rows($result)==1)
                        {
                            $inventory = mysqli_fetch_array($result);
                            $track = $inventory["track"];
                            $image = $inventory["image"];
                            $weight = $inventory["weight"];                        
                            $comment = $inventory["comment"];                        
                            ?>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="card">
                                        <div class="card-body">
                                                <fieldset id="personal-details ">
                                                    <div class="form-group required">
                                                        <label class="control-label">Track</label>
                                                        <input type="text" name="track" value="<?=$track;?>" class="form-control" readonly>                                            
                                                    </div>

                                                    <div class="form-group required">
                                                        <label class="control-label">Weight</label>
                                                        <input type="text" name="weight" value="<?=$weight;?>" class="form-control" readonly>                                            
                                                    </div>

                                                    <div class="form-group required">
                                                        <label class="control-label">Comment</label>
                                                        <textarea name="comment" class="form-control" readonly><?=$comment;?></textarea>                                                        
                                                    </div>

                                                    <div class="form-group required">
                                                        <label class="control-label">Photo</label>
                                                    </div>         
                                                </fieldset>
                                            </form>
                                        </div>
                                    </div>                                    
                                </div>
                                <div class="col-lg-6">
                                    <?
                                    if (($inventory["image"]!="") && file_exists('../'.$inventory["image"])) echo '<a href="../'.$inventory["image"].'" target="new"><img src="../'.$inventory["image"].'" class="w-100"></a>';
                                    ?>                                                
                                </div>
                            </div>

                            <a class="btn btn-success btn-sm" href="?action=edit">Edit</a>
                            <a class="btn btn-primary btn-sm" href="?action=list">List</a>
                            <a class="btn btn-danger btn-sm" href="?action=delete&id=<?=$inventory_id;?>">Delete</a>

                            <?
                        }
                        else header("location:inventory");
                    }


                if ($action=="delete")
                    {
                        ?>
                        <div class="row">
                            <div class="col-lg-12">
                                <?
                                if (isset($_GET["id"])) $inventory_id = $_GET["id"]; else header("location:inventory");
                                    $sql = "SELECT *FROM branch_inventories WHERE id='$inventory_id' AND `branch`='$g_logged_id' LIMIT 1";
                                    $result = mysqli_query($conn,$sql);
                                    if (mysqli_num_rows($result)==1)
                                    {
                                        $inventory = mysqli_fetch_array($result);
                                        $inventory_image = $inventory["image"];
                                        $sql = "DELETE FROM branch_inventories WHERE id='$inventory_id' AND `branch`='$g_logged_id'";
                                        if (mysqli_query($conn,$sql))
                                        {
                                            if (($inventory["image"]!="") && file_exists('../'.$inventory["image"])) unlink('../'.$inventory["image"]);
                                          
                                            echo '<div class="alert alert-success">Deleted</div>';    
                                        }
                                        else 
                                        echo '<div class="alert alert-danger">Delete error '.mysqli_error($conn).'</div>';       
                                    }
                                    else    echo '<div class="alert alert-danger">Not found</div>';       

                                ?>
                                <a href="inventory" class="btn btn-primary">List</a>
                            </div>
                        </div>
                        <?
                    }
                
                    
                if ($action=="prepare")
                    {
                        ?>
                        <div class="row">
                            <div class="col-lg-12">
                                <?
                                if (isset($_GET["id"])) $inventory_id = $_GET["id"]; else header("location:inventory");
                                    $sql = "SELECT *FROM branch_inventories WHERE id='$inventory_id' AND `branch`='$g_logged_id' LIMIT 1";
                                    $result = mysqli_query($conn,$sql);
                                    if (mysqli_num_rows($result)==1)
                                    {
                                        $inventory = mysqli_fetch_array($result);
                                        $inventory_image = $inventory["image"];
                                        $sql = "UPDATE branch_inventories SET status='prepare' WHERE id='$inventory_id' AND `branch`='$g_logged_id'";
                                        if (mysqli_query($conn,$sql))
                                        {                                     
                                            echo '<div class="alert alert-success">Prepared</div>';    
                                        }
                                        else 
                                        echo '<div class="alert alert-danger">Change error '.mysqli_error($conn).'</div>';       
                                    }
                                    else    echo '<div class="alert alert-danger">Not found</div>';       

                                ?>
                                <a href="inventory" class="btn btn-primary">List</a>
                            </div>
                        </div>
                        <?
                    }
                

                if ($action=="prepare_all")
                    {
                        ?>
                        <div class="row">
                            <div class="col-lg-12">
                                <?
                                    $sql = "UPDATE branch_inventories SET status ='prepare'  WHERE status='new'";
                                    $result = mysqli_query($conn,$sql);
                                    if (mysqli_num_rows($result)==1)
                                    {
                                            echo '<div class="alert alert-success">Prepared</div>';    
                                    }
                                    else 
                                    echo '<div class="alert alert-danger">Change error '.mysqli_error($conn).'</div>';       

                                ?>
                                <a href="?action=list" class="btn btn-primary">List</a>
                                <a href="?action=prepared" class="btn btn-primary">Prepared List</a>
                            </div>
                        </div>
                        <?
                    }
                
                if ($action=="prepared")
                    {
                        ?>
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                        <div class="col-sm-12">
                                            <?
                                                if (mysqli_num_rows(mysqli_query($conn,"SELECT id FROM branch_inventories WHERE branch_inventories.branch='$g_logged_id' AND status='prepare'"))>=1)
                                                { ?><a class="btn btn-pill btn-danger" data-bs-toggle="modal" data-bs-target="#tranport"><i data-feather="truck" height="14"></i> Tranport</a><? };
                                            ?>
                                            

                                            <button class="btn btn-pill btn-warning" onclick="export_table();"><i data-feather="file" height="14"></i> Export</button>
                                        <table class="table table-stripe table-hover" id="table">
                                            <thead>
                                                <tr>
                                                    <th>№</th>
                                                    <th width="100px">image</th>
                                                    <th>Track</th>
                                                    <th>Comment</th>                                                
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?
                                                $count=$sum_weight =0;
                                                $sql= "SELECT branch_inventories.*
                                                FROM branch_inventories 
                                                WHERE branch_inventories.branch='$g_logged_id' AND status='prepare' ORDER BY id DESC";
                                                $result = mysqli_query($conn,$sql);
                                                while ($inventory = mysqli_fetch_array($result))
                                                {
                                                    ?>
                                                    <tr>
                                                        <td><?=++$count;?></td>
                                                        <td width="100px">
                                                            <?
                                                            if (($inventory["image"]!="") && file_exists('../'.$inventory["image"])) echo '<a href="../'.$inventory["image"].'" target="new"><img src="../'.$inventory["image"].'" class="w-100"></a>';?>
                                                        </td>
                                                        <td><?=$inventory["track"];?></td>
                                                        <td><?=$inventory["comment"];?></td>
                                                        <td><?=$inventory["status"];?></td>
                                                        <td>
                                                            <div class="btn-group">
                                                                <a href="?action=unprepare&id=<?=$inventory["id"];?>" class="btn btn-warning btn-sm">To Inventory</a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <?
                                                    $sum_weight+=$inventory["weight"];
                                                }
                                                ?>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th></th>
                                                    <th colspan="2">Total: <?=$count;?></th>
                                                    <th></th>
                                                    <th></th>   
                                                    <th></th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                        </div>                               
                                </div>                                                    
                            </div>
                        </div>

                        <div class="modal fade" id="tranport" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <form action="?action=transport" method="post">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Transport</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                    
                                            <input type="hidden" name="count" value="<?=$count;?>">
                                            <input type="hidden" name="sum_weight" value="<?=$sum_weight;?>">
                                            <div class="row">
                                                <div class="col-xl-12 col-md-3 col-sm-6 box-col-3 des-xl-25 rate-sec">
                                                    <div class="card income-card card-primary">                                 
                                                        <div class="card-body text-center">                                  
                                                            <div class="round-box">
                                                            <i data-feather="archive"></i>
                                                            </div>
                                                            <h5><?=$count;?></h5>
                                                            <p>Total items</a>                                          
                                                        </div>
                                                        </div>
                                                    </div>                                            
                                            </div>
                                            <div class="form-group required">
                                                <label class="control-label">Driver</label>
                                                <input type="text" name="driver" value="" class="form-control" required>                                            
                                            </div>

                                            <div class="form-group required">
                                                <label class="control-label">Contact</label>
                                                <input type="text" name="contact" value="" class="form-control" required>                                            
                                            </div>

                                            <div class="form-group required">
                                                <label class="control-label">Addition information</label>
                                                <textarea name="comment" class="form-control"></textarea>                                                        
                                            </div>
                                        
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <input type="submit" class="btn btn-success" value="Finalize">
                                    </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <?
                    }
                

                if ($action=="unprepare")
                    {
                        ?>
                        <div class="row">
                            <div class="col-lg-12">
                                <?
                                if (isset($_GET["id"])) $inventory_id = $_GET["id"]; else header("location:inventory");
                                    $sql = "SELECT *FROM branch_inventories WHERE id='$inventory_id' AND `branch`='$g_logged_id' LIMIT 1";
                                    $result = mysqli_query($conn,$sql);
                                    if (mysqli_num_rows($result)==1)
                                    {
                                        $inventory = mysqli_fetch_array($result);
                                        $inventory_image = $inventory["image"];
                                        $sql = "UPDATE branch_inventories SET status='new' WHERE id='$inventory_id' AND `branch`='$g_logged_id'";
                                        if (mysqli_query($conn,$sql))
                                        {                                     
                                            echo '<div class="alert alert-success">Put in inventory</div>';    
                                        }
                                        else 
                                        echo '<div class="alert alert-danger">Change error '.mysqli_error($conn).'</div>';       
                                    }
                                    else    echo '<div class="alert alert-danger">Not found</div>';       

                                ?>
                                    <a href="?action=list" class="btn btn-primary">Inventory list</a>
                                    <a href="?action=prepared" class="btn btn-primary">Prepared list</a>
                            </div>
                        </div>
                        <?
                    } 
                if ($action=="transport")
                    {
                        ?>
                            <div class="row">
                                <div class="col-sm-12">
                                    <?
                                    $driver = $_POST["driver"];
                                    $contact = floatval($_POST["contact"]);  
                                    $comment = mysqli_escape_string($conn,$_POST["comment"]);
                                    $items = $_POST["count"];
                                    $sum_weight = $_POST["sum_weight"];

                                    $sql = "INSERT INTO branch_transport
                                    (driver,contact,comment,branch,items,sum_weight)
                                    VALUE ('$driver','$contact','$comment','$g_logged_id','$items','$sum_weight')";
                                    if (mysqli_query($conn,$sql))
                                    {
                                        $transport = mysqli_insert_id($conn);
                                        
                                        $sql = "UPDATE branch_inventories
                                        SET status='transport', transport='$transport' WHERE branch='$g_logged_id' AND status='prepare'";
                                        mysqli_query($conn,$sql);
                                        ?>
                                        <div class="alert alert-success">Transport sent</div>
                                        <?

                                    }
                                    else 
                                    echo '<div class="alert alert-danger">Error occured '.mysqli_error($conn).'</div>';       

                                    ?>
                                    <a href="?action=list" class="btn btn-primary">Inventory list</a>
                                    <a href="?action=prepared" class="btn btn-primary">Prepared list</a>
                                </div>
                            </div>                    
                        <?
                    }

                    

                ?>
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

    <script src="assets/js/FileSaver.js"></script>
    <script src="assets/js/tableExport.min.js"></script>


    <!-- Plugins JS Ends-->
    <!-- Theme js-->
    <script src="assets/js/script.js"></script>

    <script>
            function export_table()
            {
                var tempTable = $("#table").html();
            
                $(".excludeExport").remove();                
                $('#table').tableExport({
                 type: 'excel'
               });
            }

        // $("table").tableExport();
    </script>


    <!-- login js-->
    <!-- Plugin used-->
  </body>
</html>