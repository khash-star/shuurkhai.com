<?php require_once("config.php");?>
<?php require_once("views/helper.php");?>
<?php require_once("views/login_check.php");?>
<?php require_once("views/init.php");?>
    
    <link rel="stylesheet" href="assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css" />
    <link rel="stylesheet" href="assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css" />
    <link rel="stylesheet" href="assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css" />
    <link rel="stylesheet" href="assets/vendor/libs/select2/select2.css" />

                    <?php                                 
    if (isset($_GET["action"])) $action=$_GET["action"]; else $action="list";
    ?>

    
    <body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
      <div class="layout-container">
        <!-- Menu -->

                    <?php                                  require_once("views/sidebar.php");?>

        <!-- / Menu -->

        <!-- Layout container -->
        <div class="layout-page">
          <!-- Navbar -->
          
          <?php require_once("views/header.php");?>


          <!-- / Navbar -->

          <!-- Content wrapper -->
          <div class="content-wrapper">
            <!-- Content -->

            <div class="container-xxl flex-grow-1 container-p-y">
                <div class="d-flex justify-content-between">
                    <h4 class="py-3 mb-4"><span class="text-muted fw-light">FAQs/</span> list</h4>

                    <div class="mt-3">
                        <div class="btn-group">
                            <button
                            type="button"
                            class="btn btn-primary dropdown-toggle"
                            data-bs-toggle="dropdown"
                            aria-expanded="false">
                            Menu
                            </button>
                            <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="?action=grid">All questions</a></li>
                            <li><a class="dropdown-item" href="?action=new">Add question</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                
                <?php 
                if ($action=="list")
                {
                    ?><!-- Basic table -->
                    <section id="basic-datatable">
                        <div class="row">
                            <div class="col-12">
                                <div class="card">

                                    <table class="datatables-basic table">
                                    <thead>
                                        <tr>
                                        <th class="wd-5p">№</th>
                                        <th class="wd-30p">Question</th>
                                        <th class="wd-10p">Answer</th>
                                        <th class="wd-5p">Prior</th>
                                        <th class="wd-5p">-</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                    <?php                                 
                                        $count =1;
                                        $sql = "SELECT *FROM faqs ORDER BY dd";
                                        $result = mysqli_query($conn,$sql);
                                        if (mysqli_num_rows($result)>0)
                                        {
                                        while ($data = mysqli_fetch_array($result))
                                        {

                                            ?>
                                            <tr>
                                            <td><?=$count++;?></td>
                                            <td><?=$data["question"];?></td>
                                            <td><?=$data["answer"];?></td>
                                            <td><?=$data["dd"];?></td>
                                            <td class="tx-18">
                                                <div class="btn-group">
                                                    <a href="?action=edit&id=<?=$data["id"];?>"  class="btn btn-success btn-icon btn-sm" title="Edit"><i class="fa fa-edit"></i></a>
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
                    </section>
                    <!--/ Basic table -->
                    <?php                                 
                }
                ?>

                    <?php                                 
                if ($action=="edit")
                {
                    $faq_id = $_GET["id"];
                    $sql = "SELECT *FROM faqs WHERE id=$faq_id LIMIT 1";
                    $result = mysqli_query($conn,$sql);
                    if (mysqli_num_rows($result)==1)
                    {
                        $data = mysqli_fetch_array($result);
                        ?>
                    
                        <section id="input-group-basic">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4 class="card-title">Edit</h4>
                                        </div>
                                        <div class="card-body">
                                            <form action="?action=editing" method="post" enctype="multipart/form-data">
                                                <input type="hidden" name="id" value="<?=$data["id"];?>">
                                                <div class="media-list mg-t-25">
                                                    <div class="media">
                                                        <div class="media-body mg-l-15 mt-3">
                                                            <h6 class="tx-14 tx-gray-700">Question</h6>
                                                            <input type="text" name="question" value="<?=$data["question"];?>" class="form-control" required>
                                                        </div>
                                                    </div>


                                                    <div class="media">
                                                        <div class="media-body mg-l-15 mt-3">
                                                            <h6 class="tx-14 tx-gray-700">Answer</h6>
                                                            <input type="text" name="answer" value="<?=$data["answer"];?>" class="form-control" required>
                                                        </div>
                                                    </div>

                                                    <div class="media">
                                                        <div class="media-body mg-l-15 mt-3">
                                                            <h6 class="tx-14 tx-gray-700">Priority</h6>
                                                            <input type="number" name="dd" value="<?=$data["dd"];?>" class="form-control" required>
                                                        </div>
                                                    </div>
                                                </div><!-- media-list -->
                                                                                                    
                                                <div class="btn-group mt-3">
                                                    <button type="submit" class="btn btn-success">Save</button>
                                                    <a href="faqs" class="btn btn-primary"> Return</a>
                                                    <a href="?action=delete&id=<?=$faq_id;?>" class="btn btn-danger"> Delete</a>

                                                </div>
                                            </form>                                       
                                        </div>
                                    </div>
                                </div>
                        
                            
                            </div>
                        </section>
                    <?php                                 
                    }
                }
                ?>


                    <?php                                 
            if ($action=="editing")
            {
                if (isset($_POST["id"])) $faq_id=$_POST["id"]; else header("location:faqs");
            
                $question = $_POST["question"];
                $answer = $_POST["answer"];

                $sql = "UPDATE faqs SET question='$question',answer='$answer' WHERE id=$faq_id LIMIT 1";
                //  echo $sql;
                if (mysqli_query($conn,$sql))
                    {
                    ?>
                    <div class="alert alert-success" role="alert">
                            <div class="alert-body">
                            Амжилттай засагдлаа
                            </div>
                        </div>
                    <?php                                 
                    }
                    else 
                    {
                    ?>
                    <div class="alert alert-danger" role="alert">
                        <div class="alert-body">
                        Error occured <?=mysqli_error($conn);?>
                        </div>
                    </div>
                    <?php                                 
                    }

                ?>                            
                <div class="btn-group">
                    <a href="?action=edit&id=<?=$faq_id;?>" class="btn btn-success"><i class="icon ion-edit"></i> Edit</a>
                    <a href="faqs" class="btn btn-primary"><i class="icon ion-ios-list"></i> Return</a>
                </div>   
                <?php                                 
            }
            ?>

                    <?php                                 
            if ($action=="new")
            {
                ?>
                
                    <section id="input-group-basic">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">Create</h4>
                                    </div>
                                    <div class="card-body">
                                        <form action="?action=adding" method="post" enctype="multipart/form-data">
                                            <div class="media-list mg-t-25">
                                                <div class="media">
                                                    <div class="media-body mg-l-15 mt-3">
                                                        <h6 class="tx-14 tx-gray-700">Question</h6>
                                                        <input type="text" name="question" value="" class="form-control" placeholder="Question" required>
                                                    </div>
                                                </div>


                                                <div class="media">
                                                    <div class="media-body mg-l-15 mt-3">
                                                        <h6 class="tx-14 tx-gray-700">Answer</h6>
                                                        <input type="text" name="answer" class="form-control" placeholder="Answer" required>
                                                    </div>
                                                </div>

                                                <div class="media">
                                                    <div class="media-body mg-l-15 mt-3">
                                                        <h6 class="tx-14 tx-gray-700">Priority</h6>
                                                        <input type="number" name="dd" value="0" class="form-control" required>
                                                    </div>
                                                </div>

                                            </div><!-- media-list -->
                                                                                                
                                            <div class="btn-group mt-3">
                                                <button type="submit" class="btn btn-success">Save</button>
                                                <a href="faqs" class="btn btn-primary"><i class="icon ion-ios-list"></i> Return</a>
                                                        </div>
                                                    </form>                                       
                                                </div>
                                            </div>

                                           
                                        </div>
                                    
                                    
                                    </div>
                                </section>
                    <?php                                 
                
                }
                ?>

                    <?php                                 
                if ($action=="adding")
                {
                
                    $question = $_POST["question"];
                    $answer = $_POST["answer"];

                    $sql = "INSERT INTO faqs (question,answer) VALUES('$question','$answer')";
                    //  echo $sql;
                    if (mysqli_query($conn,$sql))
                        {
                        ?>
                        <div class="alert alert-success" role="alert">
                                <div class="alert-body">
                                Created successfully
                                </div>
                            </div>
                    <?php                                 
                        }
                        else 
                        {
                        ?>
                        <div class="alert alert-danger" role="alert">
                            <div class="alert-body">
                            Error occured
                            </div>
                        </div>
                    <?php                                 
                        }

                    ?>                            
                    <div class="btn-group">
                        <a href="?action=edit&id=<?=$faq_id;?>" class="btn btn-success"><i class="icon ion-edit"></i> Edit</a>
                        <a href="faqs" class="btn btn-primary"><i class="icon ion-ios-list"></i> Return</a>
                    </div>   
                <?php                                 
                }
                ?>

                    <?php                                 
                if ($action=="delete")
                {
                    $faq_id = $_GET["id"];
                    $sql = "SELECT *FROM faqs WHERE id=$faq_id LIMIT 1";
                    $result = mysqli_query($conn,$sql);
                    if (mysqli_num_rows($result)==1)
                    {
                        $sql = "DELETE FROM faqs WHERE id=$faq_id LIMIT 1";
                        //  echo $sql;
                    if (mysqli_query($conn,$sql))
                        {
                        ?>
                            <div class="alert alert-success" role="alert">
                                <div class="alert-body">
                                Deleted
                                </div>
                            </div>
                    <?php                                 
                        }
                        else 
                        {
                        ?>
                        <div class="alert alert-danger" role="alert">
                            <div class="alert-body">
                                Error occured 
                            </div>
                        </div>
                    <?php                                 
                        }

                    ?>                            
                    <div class="btn-group">
                        <a href="faqs" class="btn btn-primary"><i class="icon ion-ios-list"></i> Return</a>
                    </div>   
                <?php                                 
                    }
                    else 
                    header("location:faqs");
                }
                ?>

              </div>
            </div>
            <!-- / Content -->

                <?php require_once("views/footer.php");?>


            <div class="content-backdrop fade"></div>
          </div>
          <!-- Content wrapper -->
        </div>
        <!-- / Layout page -->
      </div>

      <!-- Overlay -->
      <div class="layout-overlay layout-menu-toggle"></div>

      <!-- Drag Target Area To SlideIn Menu On Small Screens -->
      <div class="drag-target"></div>
    </div>
    <!-- / Layout wrapper -->

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->

    <script src="assets/vendor/libs/jquery/jquery.js"></script>
    <script src="assets/vendor/libs/popper/popper.js"></script>
    <script src="assets/vendor/js/bootstrap.js"></script>
    <script src="assets/vendor/libs/node-waves/node-waves.js"></script>
    <script src="assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="assets/vendor/libs/hammer/hammer.js"></script>
    <script src="assets/vendor/libs/i18n/i18n.js"></script>
    <script src="assets/vendor/libs/typeahead-js/typeahead.js"></script>
    <script src="assets/vendor/js/menu.js"></script>

    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="assets/vendor/libs/moment/moment.js"></script>
    <script src="assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js"></script>
    <script src="assets/vendor/libs/select2/select2.js"></script>
    <script src="assets/vendor/libs/@form-validation/umd/bundle/popular.min.js"></script>
    <script src="assets/vendor/libs/@form-validation/umd/plugin-bootstrap5/index.min.js"></script>
    <script src="assets/vendor/libs/@form-validation/umd/plugin-auto-focus/index.min.js"></script>
    <script src="assets/vendor/libs/cleavejs/cleave.js"></script>
    <script src="assets/vendor/libs/cleavejs/cleave-phone.js"></script>

    <!-- Main JS -->
    <script src="assets/js/main.js"></script>

    <!-- Page JS -->
    <!-- <script src="assets/js/app-user-list.js"></script> -->
  </body>
</html>
