<?php require_once("config.php");?>
<?php require_once("views/helper.php");?>
<?php require_once("views/login_check.php");?>
<?php require_once("views/init.php");?>

<link href="assets/css/apps/notes.css" rel="stylesheet" type="text/css" />
<link href="assets/css/elements/breadcrumb.css" rel="stylesheet" type="text/css" />
<link href="assets/css/forms/theme-checkbox-radio.css" rel="stylesheet" type="text/css" />


<body class="sidebar-noneoverflow">
    
    <?php require_once("views/navbar.php");?>



    <div class="main-container" id="container">

        <div class="overlay"></div>
        <div class="cs-overlay"></div>
        <div class="search-overlay"></div>

        <?php require_once("views/sidebar.php");?>


        <div id="content" class="main-content">
            <div class="layout-px-spacing">
                <?php if (isset($_GET["action"])) $action=protect($_GET["action"]); else $action="display"; ?>

                <?
                if ($action=="display")
                {
                
                    $user_id = $_SESSION["c_user_id"];
                    ?>
                    <nav class="breadcrumb-two" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="home">Нүүр</a></li>
                            <li class="breadcrumb-item active"><a href="products">Бараа</a></li>
                        </ol>
                    </nav>

                     
                <div class="row layout-top-spacing">
                    <?
                    $sql = "SELECT products.*,product_category.name category_name FROM products 
                    LEFT JOIN product_category ON products.category=product_category.id 
                    ORDER BY created_date DESC";
                    $result = mysqli_query($conn,$sql);
                    while($data = mysqli_fetch_array($result))
                    {
                        ?>
                        <div class="col-md-3 mt-3">
                            <div class="card component-card_2">
                                <img src="../<?=$data["image"];?>" class="card-img-top" alt="<?=$data["name"];?>">
                                <div class="card-body">
                                    <h5 class="card-title"><?=$data["name"];?></h5>
                                    <p class="card-text" style="max-height:6em; overflow:hidden;"><?=$data["description"];?></p>
                                    <a href="#" class="text-primary bold"><?=$data["category_name"];?></a>
                                    <!-- <a href="#" class="btn btn-primary">Explore More</a> -->
                                </div>
                            </div>
                        </div>
                        <?
                    }
                    ?>
                </div>

                    <?
                }
                ?>



                </div>
            <?php require_once("views/footer.php");?>
        </div>
    </div>

    
    <!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
    <script src="assets/js/libs/jquery-3.1.1.min.js"></script>
    <script src="bootstrap/js/popper.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script src="plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="assets/js/app.js"></script>

    <script>
        $(document).ready(function() {
            App.init();
        });
    </script>
    <script src="plugins/highlight/highlight.pack.js"></script>
    <script src="assets/js/custom.js"></script>
    <!-- END GLOBAL MANDATORY SCRIPTS -->
    
</body>
</html>