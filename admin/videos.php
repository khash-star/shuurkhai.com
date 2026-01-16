<?
    require_once("config.php");
    require_once("views/helper.php");
    require_once("views/login_check.php");
    require_once("views/init.php");
?>
<body class="sidebar-dark">
	<div class="main-wrapper">
		<?  require_once("views/navbar.php"); ?>
	
		<div class="page-wrapper">
            <?  require_once("views/sidebar.php"); ?>
			
            <?  if (isset($_GET["action"])) $action=protect($_GET["action"]); else $action="display";?>

			<div class="page-content">
            <? if (isset($_GET['action'])) $action=$_GET['action']; else $action="display";?>
            <? if (isset($_GET['id'])) $id=$_GET['id']; ?>

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
                                        if (mysqli_num_rows($result)==0) echo "<td colspan='5'>There are no videos</td>";
                                        while ($data=mysqli_fetch_array($result))
                                        {

                                            ?>
                                            <tr>
                                                <td><?=$count++;?></td>       
                                                <td class="text-wrap"><?=$data["name"];?></td>
                                                <td class="text-wrap"><a href="<?=$data["url"];?>"><i class="red" data-feather="youtube"></i></a></td>
                                                <td class="text-wrap"><?=$data["description"];?></td>
                                                <td><a href="videos?action=edit&id=<?=$data["id"];?>" title="Засах" class="btn btn-warning btn-icon"><i data-feather="edit"></i></a></td>
                                            </tr>
                                            <?
                                        }
                                        ?>      
                                    </tbody>
                                </table>
                            </div>
                
                        </div>
                        
                    </div>
                    <a href="videos?action=add" class="btn btn-success btn-xs mt-3 btn-icon-text"><i data-feather="plus"></i> Видео нэмэх</a>

                    <?
                } 
                ?>
                
            <? if($action=="add")
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
                    <?
                }
                ?>


            <? if($action=="adding")
                {
                    $name=$_POST["name"];
                    $url=$_POST["url"];
                    $description=$_POST["description"];                    
                    
                    $sql="INSERT INTO videos (name,url,description) VALUES('$name','$url','$description')";

                    if (mysqli_query($conn,$sql)) header('location:videos');
                    else echo mysqli_error($conn);//header('location:faqs_add.php?m=e');
                    
                }
                ?>


            <? if($action=="edit")
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
                    <?
                    if (isset($_GET['id']))
                    {
                        $id = $_GET['id'];
                        $sql="SELECT * FROM videos WHERE id='$id' LIMIT 1";
                        $result=mysqli_query($conn,$sql);
                        $data=mysqli_fetch_array($result);
                        ?>
                        <div class="card">
                            <div class="card-body">
                                <form action="videos?action=editing" method="post" enctype="multipart/form-data">
                                <input type="hidden" name="id" value="<?=$id;?>" />
                                <table  class="table table-hover">
                                    <tr>
                                        <td width="25%">Нэр</td>
                                        <td width="75%"><input type="text"  class="form-control" name="name" placeholder="Нэр" value="<?=$data["name"];?>"/></td>
                                    </tr>
                                    <tr>
                                        <td>Хаяг</td>
                                        <td width="75%"><input type="text"  class="form-control" name="url" placeholder="https://www.youtube.com/watch?v=kRLGTpKjg04" value="<?=$data["url"];?>"/></td>
                                    </tr>
                                    <tr>
                                        <td>Тайлбар</td>
                                        <td><textarea name="description" class="form-control"><?=$data["description"];?></textarea></td></tr>
                                
                                    </tr>
                                    <tr>
                                        <td><input type="submit" class="btn btn-success" value="Хадгалах" /></td>
                                        <td></td>
                                    </tr>

                                </table>

                                <br><br>
                                <a href="videos?action=delete&id=<?=$id;?>" class="btn btn-danger btn-xs">устгах</a><br />
                                </form>
                            </div>
                        </div>
                        <?
                    }
                    else header("location:videos");
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
      <? require_once("views/footer.php");?>
		
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