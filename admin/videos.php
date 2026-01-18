<?php
    require_once("config.php");
    require_once("views/helper.php");
    require_once("views/login_check.php");
    require_once("views/init.php");
?>
<body class="sidebar-dark">
	<div class="main-wrapper">
		<?php  require_once("views/navbar.php"); ?>
	
		<div class="page-wrapper">
            <?php  require_once("views/sidebar.php"); ?>
			
            <?php  
            if (isset($_GET["action"])) {
                $action = protect($_GET["action"]);
            } else {
                $action = "display";
            }
            if (isset($_GET['id'])) {
                $id = intval(protect($_GET['id']));
            } else {
                $id = 0;
            }
            ?>

			<div class="page-content">

            <?php if ($action=="display")
                { 
                    ?>
                    <a href="videos?action=add" class="btn btn-success btn-xs mb-3 btn-icon-text"><i data-feather="plus"></i> Видео нэмэх</a>

                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-striped">
                                    <thead>
                                        <tr>
                                            <th>№</th>
                                            <th>Нэр</th>
                                            <th>Линк</th>
                                            <th>Текст</th>
                                            <th>Үйлдэл</th>
                                        </tr>

                                    </thead>
                                    <tbody>
                                        <?php
                                        $count=1;
                                        $sql="SELECT * FROM videos";
                                        $result=mysqli_query($conn,$sql);
                                        if ($result) {
                                            if (mysqli_num_rows($result)==0) {
                                                echo "<td colspan='5'>There are no videos</td>";
                                            } else {
                                                while ($data=mysqli_fetch_array($result))
                                                {
                                                    if (!$data) continue;

                                            ?>
                                            <tr>
                                                <td><?php echo $count++;?></td>       
                                                <td class="text-wrap"><?php echo htmlspecialchars($data["name"] ?? '');?></td>
                                                <td class="text-wrap"><a href="<?php echo htmlspecialchars($data["url"] ?? '');?>" target="_blank"><i class="red" data-feather="youtube"></i></a></td>
                                                <td class="text-wrap"><?php echo htmlspecialchars($data["description"] ?? '');?></td>
                                                <td><a href="videos?action=edit&id=<?php echo htmlspecialchars($data["id"] ?? 0);?>" title="Засах" class="btn btn-warning btn-icon"><i data-feather="edit"></i></a></td>
                                            </tr>
                                            <?php
                                                }
                                            }
                                        }
                                        ?>      
                                    </tbody>
                                </table>
                            </div>
                
                        </div>
                        
                    </div>
                    <a href="videos?action=add" class="btn btn-success btn-xs mt-3 btn-icon-text"><i data-feather="plus"></i> Видео нэмэх</a>

                    <?php
                } 
                ?>
                
            <?php if($action=="add")
                {
                    ?>
                    <div class="card">
                        <div class="card-body">
                            <form action="videos?action=adding" method="post" enctype="multipart/form-data">
                                <table  class="table table-hover">
                                    <tr>
                                        <td width="25%">Нэр</td>
                                        <td width="75%"><input type="text"  class="form-control" name="name" placeholder="Нэр" /></td>
                                    </tr>
                                    <tr>
                                        <td>Хаяг</td>
                                        <td width="75%"><input type="text"  class="form-control" name="url" placeholder="https://www.youtube.com/watch?v=kRLGTpKjg04" /></td>
                                    </tr>
                                    <tr>
                                        <td>Тайлбар</td>
                                        <td><textarea name="description" class="form-control"></textarea></td></tr>
                                
                                    </tr>
                                    <tr>
                                        <td><input type="submit" class="btn btn-success" value="Нэмэх" /></td>
                                        <td></td>
                                    </tr>
                                </table>
                            </form>
                        </div>
                    </div>
                    <?php
                }
                ?>


            <?php if($action=="adding")
                {
                    $name = isset($_POST["name"]) ? protect($_POST["name"]) : '';
                    $url = isset($_POST["url"]) ? protect($_POST["url"]) : '';
                    $description = isset($_POST["description"]) ? protect($_POST["description"]) : '';
                    
                    $name_escaped = mysqli_real_escape_string($conn, $name);
                    $url_escaped = mysqli_real_escape_string($conn, $url);
                    $description_escaped = mysqli_real_escape_string($conn, $description);
                    
                    $sql="INSERT INTO videos (name,url,description) VALUES('$name_escaped','$url_escaped','$description_escaped')";

                    if (mysqli_query($conn,$sql)) {
                        header('location:videos');
                        exit;
                    } else {
                        echo $conn ? htmlspecialchars(mysqli_error($conn)) : 'Database connection error';
                    }
                    
                }
                ?>


            <?php if($action=="edit")
                {
                    ?>
                    <span>
                    <?php
                    if (isset($_GET['e']))
                    {
                        switch($_GET['e'])
                        {
                            case "ok": echo "Амжилттай заслаа";break;
                            case "error": echo "Засахад алдаа гарлаа";break;
                        }
                    }
                    ?>
                    </span>
                    <?php
                    if (isset($_GET['id']) && $id > 0)
                    {
                        $id_escaped = mysqli_real_escape_string($conn, $id);
                        $sql="SELECT * FROM videos WHERE id=".$id_escaped." LIMIT 1";
                        $result=mysqli_query($conn,$sql);
                        if ($result && mysqli_num_rows($result) == 1) {
                            $data=mysqli_fetch_array($result);
                            if (!$data) {
                                header("location:videos");
                                exit;
                            }
                            ?>
                        <div class="card">
                            <div class="card-body">
                                <form action="videos?action=editing" method="post" enctype="multipart/form-data">
                                <input type="hidden" name="id" value="<?php echo htmlspecialchars($id);?>" />
                                <table  class="table table-hover">
                                    <tr>
                                        <td width="25%">Нэр</td>
                                        <td width="75%"><input type="text"  class="form-control" name="name" placeholder="Нэр" value="<?php echo htmlspecialchars($data["name"] ?? '');?>"/></td>
                                    </tr>
                                    <tr>
                                        <td>Хаяг</td>
                                        <td width="75%"><input type="text"  class="form-control" name="url" placeholder="https://www.youtube.com/watch?v=kRLGTpKjg04" value="<?php echo htmlspecialchars($data["url"] ?? '');?>"/></td>
                                    </tr>
                                    <tr>
                                        <td>Тайлбар</td>
                                        <td><textarea name="description" class="form-control"><?php echo htmlspecialchars($data["description"] ?? '');?></textarea></td>
                                    </tr>
                                    <tr>
                                        <td><input type="submit" class="btn btn-success" value="Хадгалах" /></td>
                                        <td></td>
                                    </tr>

                                </table>

                                <br><br>
                                <a href="videos?action=delete&id=<?php echo htmlspecialchars($id);?>" class="btn btn-danger btn-xs">устгах</a><br />
                                </form>
                            </div>
                        </div>
                        <?php
                        } else {
                            header("location:videos");
                            exit;
                        }
                    }
                    else {
                        header("location:videos");
                        exit;
                    }
                }
                ?>



            <? if($action=="editing")
                {
                    
                    $id=$_POST["id"];

                    $name=$_POST["name"];
                    $url=$_POST["url"];
                    $description=$_POST["description"];                    

                    
                    $sql="UPDATE videos SET name='$name',url='$url',description='$description' WHERE id='".$id."'";

                    if (mysqli_query($conn,$sql)) header('location:videos?action=edit&id='.$id.'&e=ok');
                    else header('location:videos?action=edit&id='.$id.'&e=error');
                }
                ?>


            <? if($action=="delete")
                {
                    
                    $id=$_GET['id'];
                    if ($id!="")    
                    {
                     $sql="DELETE FROM videos WHERE id='$id' LIMIT 1";
                     mysqli_query($conn,$sql);  
                    }
                    header('location:videos');
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
	<!-- endinject -->

</body>
</html>    