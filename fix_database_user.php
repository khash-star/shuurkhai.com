<?php
/**
 * Fix Database User Script
 * This will create the MySQL user if it doesn't exist
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h2>Fixing MySQL User for Shuurkhai</h2>";

// Try to connect as root (XAMPP default has no password)
$root_user = 'root';
$root_pass = ''; // XAMPP default

$new_user = 'shuurkhai';
$new_pass = 'ppZl6H8{wGUA';
$new_database = 'shuurkhai';

echo "<h3>Step 1: Connecting as root...</h3>";
$conn = @mysqli_connect('localhost', $root_user, $root_pass);

if (!$conn) {
    echo "❌ Could not connect as root. Trying with common XAMPP passwords...<br>";
    // Try common XAMPP passwords
    $passwords = ['', 'root', 'password'];
    $connected = false;
    foreach ($passwords as $pass) {
        $conn = @mysqli_connect('localhost', $root_user, $pass);
        if ($conn) {
            $root_pass = $pass;
            $connected = true;
            break;
        }
    }
    if (!$connected) {
        die("❌ Could not connect to MySQL. Please check if MySQL is running in XAMPP.<br>");
    }
}

echo "✅ Connected to MySQL as root<br><br>";

// Check if database exists
echo "<h3>Step 2: Checking database...</h3>";
$db_check = mysqli_query($conn, "SHOW DATABASES LIKE '$new_database'");
if (mysqli_num_rows($db_check) == 0) {
    $sql = "CREATE DATABASE `$new_database` CHARACTER SET utf8 COLLATE utf8_general_ci";
    if (mysqli_query($conn, $sql)) {
        echo "✅ Database '$new_database' created<br>";
    } else {
        echo "❌ Error creating database: " . mysqli_error($conn) . "<br>";
    }
} else {
    echo "✅ Database '$new_database' already exists<br>";
}

// Check if user exists
echo "<h3>Step 3: Checking/creating user...</h3>";
$user_check = mysqli_query($conn, "SELECT User FROM mysql.user WHERE User='$new_user' AND Host='localhost'");
if (mysqli_num_rows($user_check) == 0) {
    // User doesn't exist, create it
    $sql = "CREATE USER '$new_user'@'localhost' IDENTIFIED BY '$new_pass'";
    if (mysqli_query($conn, $sql)) {
        echo "✅ User '$new_user' created<br>";
    } else {
        echo "❌ Error creating user: " . mysqli_error($conn) . "<br>";
    }
} else {
    // User exists, update password
    $sql = "ALTER USER '$new_user'@'localhost' IDENTIFIED BY '$new_pass'";
    if (mysqli_query($conn, $sql)) {
        echo "✅ User '$new_user' password updated<br>";
    } else {
        echo "⚠️ Could not update password: " . mysqli_error($conn) . "<br>";
    }
}

// Grant privileges
echo "<h3>Step 4: Granting privileges...</h3>";
$sql = "GRANT ALL PRIVILEGES ON `$new_database`.* TO '$new_user'@'localhost'";
if (mysqli_query($conn, $sql)) {
    echo "✅ Privileges granted<br>";
} else {
    echo "❌ Error granting privileges: " . mysqli_error($conn) . "<br>";
}

// Flush privileges
mysqli_query($conn, "FLUSH PRIVILEGES");
echo "✅ Privileges flushed<br><br>";

// Test connection
echo "<h3>Step 5: Testing connection...</h3>";
mysqli_close($conn);
$test_conn = @mysqli_connect('localhost', $new_user, $new_pass, $new_database);

if ($test_conn) {
    echo "<h2 style='color: green;'>✅ SUCCESS! Database user is ready!</h2>";
    echo "<p>You can now access the admin panel:</p>";
    echo "<a href='admin/' style='background: #007bff; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>Go to Admin Panel</a>";
    mysqli_close($test_conn);
} else {
    echo "<h2 style='color: red;'>❌ Connection test failed!</h2>";
    echo "<p>Error: " . mysqli_connect_error() . "</p>";
    echo "<p><strong>Alternative solution:</strong> You can temporarily use 'root' user in config.php</p>";
}

?>
