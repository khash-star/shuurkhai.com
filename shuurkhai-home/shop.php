<?php
// CRITICAL: Error reporting MUST be first, before any output
@ini_set('display_errors', 1);
@ini_set('display_startup_errors', 1);
@error_reporting(E_ALL);

// Immediate error output
register_shutdown_function(function() {
    $error = error_get_last();
    if ($error && in_array($error['type'], [E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR])) {
        echo "<!DOCTYPE html><html><head><title>PHP Fatal Error</title></head><body>";
        echo "<h1>PHP Fatal Error</h1>";
        echo "<p><strong>Message:</strong> " . htmlspecialchars($error['message']) . "</p>";
        echo "<p><strong>File:</strong> " . htmlspecialchars($error['file']) . "</p>";
        echo "<p><strong>Line:</strong> " . $error['line'] . "</p>";
        echo "</body></html>";
    }
});

// Start output immediately to catch early errors
echo "<!-- Shop.php starting -->\n";

try {
    // Check files exist with absolute paths
    $base_dir = __DIR__;
    
    if (!file_exists($base_dir . "/config.php")) {
        throw new Exception("config.php not found in: " . $base_dir);
    }
    require_once($base_dir . "/config.php");

    if (!file_exists($base_dir . "/views/helper.php")) {
        throw new Exception("views/helper.php not found in: " . $base_dir);
    }
    require_once($base_dir . "/views/helper.php");

    if (!file_exists($base_dir . "/views/init.php")) {
        throw new Exception("views/init.php not found in: " . $base_dir);
    }
    require_once($base_dir . "/views/init.php");
    
    // Check if database connection exists
    if (!isset($conn)) {
        throw new Exception("Database connection variable \$conn is not set");
    }
    if (!$conn) {
        $error = mysqli_connect_error();
        throw new Exception("Database connection failed: " . ($error ? $error : "Unknown error"));
    }
    
} catch (Exception $e) {
    http_response_code(500);
    echo "<!DOCTYPE html><html><head><title>Error</title></head><body>";
    echo "<h1>FATAL ERROR</h1>";
    echo "<p>" . htmlspecialchars($e->getMessage()) . "</p>";
    echo "<p><strong>File:</strong> " . htmlspecialchars($e->getFile()) . "</p>";
    echo "<p><strong>Line:</strong> " . $e->getLine() . "</p>";
    echo "</body></html>";
    exit;
} catch (Error $e) {
    http_response_code(500);
    echo "<!DOCTYPE html><html><head><title>PHP Error</title></head><body>";
    echo "<h1>PHP FATAL ERROR</h1>";
    echo "<p>" . htmlspecialchars($e->getMessage()) . "</p>";
    echo "<p><strong>File:</strong> " . htmlspecialchars($e->getFile()) . "</p>";
    echo "<p><strong>Line:</strong> " . $e->getLine() . "</p>";
    echo "</body></html>";
    exit;
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
