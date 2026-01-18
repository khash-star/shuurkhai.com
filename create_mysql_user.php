<?php
/**
 * MySQL User Creation Script
 * Run this file once to create the 'shuurkhai' user and database
 * 
 * IMPORTANT: Delete this file after use for security!
 */

// XAMPP default root usually has no password
$root_user = 'root';
$root_pass = ''; // Change if you set a root password

$new_user = 'shuurkhai';
$new_pass = 'ppZl6H8{wGUA';
$new_database = 'shuurkhai';

// Connect as root
$conn = @mysqli_connect('localhost', $root_user, $root_pass);

if (!$conn) {
    die("❌ Could not connect to MySQL as root. Error: " . mysqli_connect_error() . "\n<br>Please check your XAMPP MySQL is running.");
}

echo "✅ Connected to MySQL as root<br><br>";

// Create database if not exists
$sql = "CREATE DATABASE IF NOT EXISTS `$new_database` CHARACTER SET utf8 COLLATE utf8_general_ci";
if (mysqli_query($conn, $sql)) {
    echo "✅ Database '$new_database' created or already exists<br>";
} else {
    echo "❌ Error creating database: " . mysqli_error($conn) . "<br>";
}

// Create user if not exists
$sql = "CREATE USER IF NOT EXISTS '$new_user'@'localhost' IDENTIFIED BY '$new_pass'";
if (mysqli_query($conn, $sql)) {
    echo "✅ User '$new_user' created or already exists<br>";
} else {
    // If user exists, try to update password
    $sql = "ALTER USER '$new_user'@'localhost' IDENTIFIED BY '$new_pass'";
    if (mysqli_query($conn, $sql)) {
        echo "✅ User '$new_user' password updated<br>";
    } else {
        echo "⚠️ User might already exist. Trying to grant privileges...<br>";
    }
}

// Grant all privileges on the database
$sql = "GRANT ALL PRIVILEGES ON `$new_database`.* TO '$new_user'@'localhost'";
if (mysqli_query($conn, $sql)) {
    echo "✅ Privileges granted to '$new_user' on database '$new_database'<br>";
} else {
    echo "❌ Error granting privileges: " . mysqli_error($conn) . "<br>";
}

// Flush privileges
mysqli_query($conn, "FLUSH PRIVILEGES");
echo "✅ Privileges flushed<br><br>";

// Test connection with new user
mysqli_close($conn);
$test_conn = @mysqli_connect('localhost', $new_user, $new_pass, $new_database);

if ($test_conn) {
    echo "<br><strong style='color: green;'>✅ SUCCESS! Connection test with '$new_user' passed!</strong><br>";
    echo "You can now use the application. <strong>Please delete this file (create_mysql_user.php) for security!</strong><br>";
    mysqli_close($test_conn);
} else {
    echo "<br><strong style='color: red;'>❌ Connection test failed: " . mysqli_connect_error() . "</strong><br>";
    echo "Please check the error above and try again.<br>";
}

?>
