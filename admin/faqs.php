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
			
            <?php  if (isset($_GET["action"])) $action=protect($_GET["action"]); else $action="display";?>

			<div class="page-content">
            <?php if (isset($_GET['action'])) $action=protect($_GET['action']); else $action="display";?>
            <?php if (isset($_GET['id'])) $faqs_id=intval($_GET['id']); ?>

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
                                        $count = 1;
                                        $sql = "SELECT * FROM faqs ORDER BY dd";
                                        $result = mysqli_query($conn,$sql);
                                        if ($result && mysqli_num_rows($result) == 0) {
                                            echo "<td colspan='5'>There are no faqs</td>";
                                        } else if ($result) {
                                            while ($data = mysqli_fetch_array($result))
                                            {
                                                if (!$data) continue;
                                                ?>
                                                <tr>
                                                    <td><?php echo $count++;?></td>       
                                                    <td class="text-wrap"><?php echo htmlspecialchars($data["question"] ?? '');?></td>
                                                    <td class="text-wrap"><?php echo htmlspecialchars($data["answer"] ?? '');?></td>
                                                    <td class="text-wrap"><?php echo htmlspecialchars($data["dd"] ?? '');?></td>
                                                    <td><a href="faqs?action=edit&id=<?php echo htmlspecialchars($data["faqs_id"] ?? '');?>" title="Засах" class="btn btn-warning btn-xs btn-icon text-white"><i data-feather="edit"></i></a></td>
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
                    <a href="faqs?action=add" class="btn btn-success btn-xs mt-3 btn-icon-text"><i data-feather="plus"></i> Асуулт хариулт нэмэх</a>

                    <?php
                } 
                ?>
                
            <?php if($action=="add")
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
                    <?php
                }
                ?>


            <?php if($action=="adding")
                {
                    $question = isset($_POST["question"]) ? protect($_POST["question"]) : '';
                    $answer = isset($_POST["answer"]) ? protect($_POST["answer"]) : '';
                    $dd = isset($_POST["dd"]) ? intval($_POST["dd"]) : 0;
                    
                    $question_escaped = mysqli_real_escape_string($conn, $question);
                    $answer_escaped = mysqli_real_escape_string($conn, $answer);
                    $sql = "INSERT INTO faqs (question,answer,dd) VALUES('$question_escaped','$answer_escaped','$dd')";

                    if (mysqli_query($conn,$sql)) {
                        header('location:faqs');
                        exit;
                    } else {
                        echo $conn ? htmlspecialchars(mysqli_error($conn)) : 'Database connection error';
                    }
                    
                }
                ?>


            <?php if($action=="edit")
                {
                    
                    if (isset($_GET['id']))
                    {
                        $faqs_id = intval($_GET['id']);
                        $faqs_id_escaped = mysqli_real_escape_string($conn, $faqs_id);
                        $sql = "SELECT * FROM faqs WHERE faqs_id='$faqs_id_escaped' LIMIT 1";
                        $result = mysqli_query($conn,$sql);
                        if ($result && mysqli_num_rows($result) > 0) {
                            $data = mysqli_fetch_array($result);
                            if ($data) {
                        ?>
                        <div class="card">
                            <div class="card-body">
                                <form action="faqs?action=editing" method="post" enctype="multipart/form-data">
                                <input type="hidden" name="faqs_id" value="<?php echo htmlspecialchars($faqs_id);?>" />
                                <table  class="table table-hover">
                                <tr>
                                <td>Асуулт</td>
                                <td><input type="text"  class="form-control" name="question" value="<?php echo htmlspecialchars($data["question"] ?? '');?>"/></td>
                                </tr>
                            
                                <tr><td>Хариулт</td>
                                <td><textarea class="form-control" name="answer"><?php echo htmlspecialchars($data["answer"] ?? '');?></textarea></td></tr>
                                
                                <td>Жагсаалтын эрэмбэ</td>
                                <td><input type="number"  class="form-control" name="dd" placeholder="Жагсаалтын эрэмбэ" value="<?php echo htmlspecialchars($data["dd"] ?? 0);?>"/></td></tr>



                                <tr><td><input type="submit" class="btn btn-success" value="Зас" /></td><td></td></tr>

                                </table>

                                <br><br>
                                <a href="faqs?action=delete&faqs_id=<?php echo htmlspecialchars($faqs_id);?>" class="btn btn-danger btn-xs">устгах</a><br />
                                </form>


                                <span>
                                <?php
                                if (isset($_GET['e'])) {
                                    switch($_GET['e'])
                                    {
                                        case "ok": echo "Амжилттай заслаа";break;
                                        case "error": echo "Засахад алдаа гарлаа";break;
                                    }
                                }
                                ?>
                                </span>
                            </div>
                        </div>
                        <?php
                            }
                        }
                    }
                    else {
                        header("location:faqs");
                        exit;
                    }
                }
                ?>



            <?php if($action=="editing")
                {
                    
                    $faqs_id = isset($_POST["faqs_id"]) ? intval($_POST["faqs_id"]) : 0;

                    $question = isset($_POST["question"]) ? protect($_POST["question"]) : '';
                    $answer = isset($_POST["answer"]) ? protect($_POST["answer"]) : '';
                    $dd = isset($_POST["dd"]) ? intval($_POST["dd"]) : 0;
                    
                    $question_escaped = mysqli_real_escape_string($conn, $question);
                    $answer_escaped = mysqli_real_escape_string($conn, $answer);
                    $sql = "UPDATE faqs SET question='$question_escaped',answer='$answer_escaped',dd='$dd' WHERE faqs_id='$faqs_id'";

                    if (mysqli_query($conn,$sql)) {
                        header('location:faqs?action=edit&id='.$faqs_id.'&e=ok');
                        exit;
                    } else {
                        header('location:faqs?action=edit&id='.$faqs_id.'&e=error');
                        exit;
                    }
                }
                ?>


            <?php if($action=="delete")
                {
                    
                    $faqs_id = isset($_GET['faqs_id']) ? intval($_GET['faqs_id']) : 0;
                    if ($faqs_id > 0)    
                    {
                        $faqs_id_escaped = mysqli_real_escape_string($conn, $faqs_id);
                        $sql = "DELETE FROM faqs WHERE faqs_id='$faqs_id_escaped' LIMIT 1";
                        mysqli_query($conn,$sql);  
                    }
                    header('location:faqs');
                    exit;
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