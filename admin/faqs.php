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
            <? if (isset($_GET['id'])) $faqs_id=$_GET['id']; ?>

            <?php if ($action=="display")
                { 
                    ?>
                    <a href="faqs?action=add" class="btn btn-success btn-xs mb-3 btn-icon-text"><i data-feather="plus"></i> Асуулт хариулт нэмэх</a>

                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-striped">
                                    <thead>
                                        <tr>
                                            <th>№</th>
                                            <th>Асуулт</th>
                                            <th>Хариулт</th>
                                            <th>Ж/э</th>
                                            <th>Action</th>
                                        </tr>

                                    </thead>
                                    <tbody>
                                        <?php
                                        $count=1;
                                        $sql="SELECT * FROM faqs ORDER BY dd";
                                        $result=mysqli_query($conn,$sql);
                                        if (mysqli_num_rows($result)==0) echo "<td colspan='4'>There are no faqs</td>";
                                        while ($data=mysqli_fetch_array($result))
                                        {

                                            ?>
                                            <tr>
                                                <td><?=$count++;?></td>       
                                                <td class="text-wrap"><?=$data["question"];?></td>
                                                <td class="text-wrap"><?=$data["answer"];?></td>
                                                <td class="text-wrap"><?=$data["dd"];?></td>
                                                <td><a href="faqs?action=edit&id=<?=$data["faqs_id"];?>" title="Засах" class="btn btn-warning btn-xs btn-icon text-white"><i data-feather="edit"></i></a></td>
                                            </tr>
                                            <?
                                        }
                                        ?>      
                                    </tbody>
                                </table>
                            </div>
                
                        </div>
                        
                    </div>
                    <a href="faqs?action=add" class="btn btn-success btn-xs mt-3 btn-icon-text"><i data-feather="plus"></i> Асуулт хариулт нэмэх</a>

                    <?
                } 
                ?>
                
            <? if($action=="add")
                {
                    ?>
                    <div class="card">
                        <div class="card-body">
                            <form action="faqs?action=adding" method="post" enctype="multipart/form-data">
                                <table  class="table table-hover">
                                <tr>
                                <td>Асуулт</td>
                                <td><input type="text"  class="form-control" name="question" placeholder="Асуулт" /></td></tr>
                                <tr><td>Хариулт</td>
                                <td><textarea class="form-control" name="answer"></textarea></td></tr>
                                <td>Жагсаалтын эрэмбэ</td>
                                <td><input type="number"  class="form-control" name="dd" placeholder="Жагсаалтын эрэмбэ" value="0" /></td></tr>
                            

                            <tr><td><input type="submit" class="btn btn-success" value="Нэмэх" /></td><td></td></tr>
                            </table>
                            </form>
                        </div>
                    </div>
                    <?
                }
                ?>


            <? if($action=="adding")
                {
                    $question=mysqli_escape_string($conn,$_POST["question"]);
                    $answer=mysqli_escape_string($conn,$_POST["answer"]);
                    $dd=$_POST["dd"];
                    
                    
                    $sql="INSERT INTO faqs (question,answer,dd) VALUES('$question','$answer','$dd')";

                    if (mysqli_query($conn,$sql)) header('location:faqs');
                    else echo mysqli_error($conn);//header('location:faqs_add.php?m=e');
                    
                }
                ?>


            <? if($action=="edit")
                {
                    
                    if (isset($_GET['id']))
                    {
                        $faqs_id = $_GET['id'];
                        $sql="SELECT * FROM faqs WHERE faqs_id='$faqs_id' LIMIT 1";
                        $result=mysqli_query($conn,$sql);
                        $data=mysqli_fetch_array($result);
                        ?>
                        <div class="card">
                            <div class="card-body">
                                <form action="faqs?action=editing" method="post" enctype="multipart/form-data">
                                <input type="hidden" name="faqs_id" value="<?=$faqs_id;?>" />
                                <table  class="table table-hover">
                                <tr>
                                <td>Асуулт</td>
                                <td><input type="text"  class="form-control" name="question" value="<?=$data["question"]?>"/></td>
                                </tr>
                            
                                <tr><td>Хариулт</td>
                                <td><textarea class="form-control" name="answer"><?=$data["answer"]?></textarea></td></tr>
                                
                                <td>Жагсаалтын эрэмбэ</td>
                                <td><input type="number"  class="form-control" name="dd" placeholder="Жагсаалтын эрэмбэ" value="<?=$data["dd"]?>"/></td></tr>



                                <tr><td><input type="submit" class="btn btn-success" value="Зас" /></td><td></td></tr>

                                </table>

                                <br><br>
                                <a href="faqs?action=delete&faqs_id=<?=$faqs_id;?>" class="btn btn-danger btn-xs">устгах</a><br />
                                </form>


                                <span>
                                <?php
                                switch($_GET['e'])
                                {case "ok": echo "Амжилттай заслаа";break;
                                case "error": echo "Засахад алдаа гарлаа";break;
                                }
                                ?>
                                </span>
                            </div>
                        </div>
                        <?
                    }
                    else header("location:faqs");
                }
                ?>



            <? if($action=="editing")
                {
                    
                    $faqs_id=$_POST["faqs_id"];

                    $question=mysqli_escape_string($conn,$_POST["question"]);
                    $answer=mysqli_escape_string($conn,$_POST["answer"]);
                    $dd=$_POST["dd"];                    
                    
                    $sql="UPDATE faqs SET question='$question',answer='$answer',dd='$dd' WHERE faqs_id='".$faqs_id."'";

                    if (mysqli_query($conn,$sql)) header('location:faqs?action=edit&id='.$faqs_id.'&e=ok');
                    else header('location:faqs?action=edit&id='.$faqs_id.'&e=error');
                }
                ?>


            <? if($action=="delete")
                {
                    
                    $faqs_id=$_GET['faqs_id'];
                    if ($faqs_id!="")    
                    {
                     $sql="DELETE FROM faqs WHERE faqs_id='$faqs_id' LIMIT 1";
                     mysqli_query($conn,$sql);  
                    }
                    header('location:faqs');
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