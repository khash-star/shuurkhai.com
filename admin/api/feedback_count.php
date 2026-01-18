<?php
require_once("../config.php");
require_once("../views/login_check.php");
require_once("../views/helper.php");

header('Content-Type: application/json');

// Count feedback messages
$feedback_count = 0;
$recent_feedbacks = array();

if (isset($conn) && $conn) {
    // Check if role column exists
    $check_role_sql = "SHOW COLUMNS FROM feedback LIKE 'role'";
    $role_exists = false;
    $check_result = mysqli_query($conn, $check_role_sql);
    if ($check_result && mysqli_num_rows($check_result) > 0) {
        $role_exists = true;
    }
    
    // Count active user messages (not admin)
    if ($role_exists) {
        $count_sql = "SELECT COUNT(*) as count FROM feedback WHERE archive=0 AND (role='user' OR role IS NULL OR role='')";
    } else {
        $count_sql = "SELECT COUNT(*) as count FROM feedback WHERE archive=0";
    }
    
    $count_result = mysqli_query($conn, $count_sql);
    if ($count_result) {
        $count_row = mysqli_fetch_array($count_result);
        if ($count_row && isset($count_row["count"])) {
            $feedback_count = intval($count_row["count"]);
        }
    }
    
    // Get recent feedbacks for notification
    if ($feedback_count > 0) {
        if ($role_exists) {
            $recent_sql = "SELECT id, title, content, name, email, timestamp, `read` AS read_status, COALESCE(role, 'user') AS role 
                          FROM feedback 
                          WHERE archive=0 AND (role='user' OR role IS NULL OR role='') 
                          ORDER BY timestamp DESC LIMIT 8";
        } else {
            $recent_sql = "SELECT id, title, content, name, email, timestamp, `read` AS read_status 
                          FROM feedback 
                          WHERE archive=0 
                          ORDER BY timestamp DESC LIMIT 8";
        }
        
        $recent_result = mysqli_query($conn, $recent_sql);
        if ($recent_result) {
            while ($recent_data = mysqli_fetch_array($recent_result)) {
                $recent_feedbacks[] = $recent_data;
            }
        }
    }
}

echo json_encode([
    'count' => $feedback_count,
    'messages' => $recent_feedbacks
]);
?>

