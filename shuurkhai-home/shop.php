<?php
// Error reporting for debugging - MUST be first
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
ini_set('log_errors', 1);

// Start output buffering to catch any errors
ob_start();

try {
    // Include required files with error checking
    if (!file_exists("config.php")) {
        throw new Exception("config.php file not found");
    }
    require_once("config.php");

    if (!file_exists("views/helper.php")) {
        throw new Exception("views/helper.php file not found");
    }
    require_once("views/helper.php");

    if (!file_exists("views/init.php")) {
        throw new Exception("views/init.php file not found");
    }
    require_once("views/init.php");
    
    // Check if database connection exists
    if (!isset($conn) || !$conn) {
        throw new Exception("Database connection not established. Error: " . (isset($conn) ? mysqli_connect_error() : "Connection variable not set"));
    }
    
} catch (Exception $e) {
    ob_end_clean();
    http_response_code(500);
    die("FATAL ERROR: " . htmlspecialchars($e->getMessage()) . "<br>File: " . htmlspecialchars($e->getFile()) . "<br>Line: " . $e->getLine());
} catch (Error $e) {
    ob_end_clean();
    http_response_code(500);
    die("FATAL PHP ERROR: " . htmlspecialchars($e->getMessage()) . "<br>File: " . htmlspecialchars($e->getFile()) . "<br>Line: " . $e->getLine());
}
?>

<link href="assets/css/range-slider.css" rel="stylesheet">

<body data-spy="scroll" data-target=".navbar" data-offset="90">

<div class="preloader">
    <div class="centrize full-width">
        <div class="vertical-center">
            <div class="spinner">
                <div class="double-bounce1"></div>
                <div class="double-bounce2"></div>
            </div>
        </div>
    </div>
</div>

<div class="product-listing">
    <div class="container" style="padding-top: 20px;">
        <div class="mb-3">
            <a href="/" class="btn btn-secondary btn-sm">
                <i class="las la-arrow-left"></i> Нүүр рүү буцах
            </a>
        </div>
        <div class="row">
            <div class="col-12 col-lg-3 order-2 order-lg-1 sticky">
                <div id="product-filter-nav" class="product-filter-nav mb-3">
                    <div class="product-category">
                        <h5 class="filter-heading text-center text-lg-left">Ангилал</h5>
                        <ul>
                            <?php
                            // Query-г MariaDB-д зориулж засав
                            if (isset($conn) && $conn) {
                                $result = mysqli_query($conn, "SELECT * FROM `shops_category` ORDER BY `dd` ASC");
                                if ($result) {
                                    while ($data = mysqli_fetch_array($result)) {
                                        $category_id = $data["id"] ?? '';
                                        $category_name = htmlspecialchars((string)($data["name"] ?? ''));
                                        $category_count = $data["count"] ?? '0';
                                        echo '<li><a href="shop?category='.urlencode($category_id).'">'.$category_name.'</a> <span>('.$category_count.')</span></li>';
                                    }
                                }
                            }
                            ?>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-md-12 col-lg-9 order-1 order-lg-2">
                <div class="row">
                    <div class="col-12 product-listing-products">
                        <section class="featured-items padding-bottom" id="featured-items">
                            <div class="row">
                                <?php
                                // Database connection check
                                if (!isset($conn) || !$conn) {
                                    die("Database connection error. Please check config.php");
                                }

                                // SQL Query-г Backticks ашиглан MariaDB-д нийцтэй болгов
                                $sql = "SELECT * FROM `shops`";

                                if (isset($_GET["category"]) && $_GET["category"] !== '') {
                                    $category = mysqli_real_escape_string($conn, $_GET["category"]);
                                    $sql .= " WHERE `category` = '$category'";
                                }

                                $result = mysqli_query($conn, $sql);
                                if (!$result) {
                                    error_log("shop.php SQL ERROR: " . mysqli_error($conn) . " | Query: " . $sql);
                                    echo "<div class='alert alert-danger'>SQL Error: " . htmlspecialchars(mysqli_error($conn)) . "</div>";
                                } else {
                                    while ($data = mysqli_fetch_array($result)) {
                                        ?>
                                        <div class="col-12 col-md-6 col-lg-4 text-center wow slideInUp">
                                            <div class="featured-item-card">
                                                <div class="item-img">
                                                    <img src="<?php echo htmlspecialchars(fix_image_path($data["image"] ?? '')); ?>" class="product-outside-image">
                                                    <div class="item-overlay">
                                                        <div class="item-btns">
                                                            <a href="<?php echo htmlspecialchars($data["url"] ?? '#'); ?>" class="btn btn-view" target="new"><i class="las la-shopping-bag"></i></a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="item-detail">
                                                    <h4 class="item-name"><?php echo htmlspecialchars($data["name"] ?? ''); ?></h4>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                }
                                ?>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once("views/footer.php"); ?>

<span class="scroll-top-arrow"><i class="fas fa-angle-up"></i></span>

<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.0.4/popper.js"></script>
<script src="assets/vendor/js/bundle.min.js"></script>
<script src="assets/js/script.js"></script>

</body>
</html>
