<?php
header('Content-Type: application/json');
require_once 'config.php';
require_once 'helper.php';
require_once 'google/vendor/autoload.php';

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'PUT' || $_SERVER['REQUEST_METHOD'] == 'POST') {       
    $input = json_decode(file_get_contents('php://input'), true);    

    $response['response'] = 0;
    $response['error_msg'] = "";

    // Retrieve the title and body from input
    $title = protection($input["title"]);
    $body = protection($input["body"]);

    // FCM API URL
    $url = 'https://fcm.googleapis.com/v1/projects/shuurkhai-app/messages:send';
    
    try {
    $credentialsFilePath =  $_SERVER['DOCUMENT_ROOT'] . '/api/shuurkhai-app-firebase-adminsdk-f91yl-231ab5ccaf.json';
    if (!file_exists($credentialsFilePath)) {
        throw new Exception("Credentials file not found.");
    }

    $client = new Google_Client();
    $client->setAuthConfig($credentialsFilePath);
    $client->addScope('https://www.googleapis.com/auth/firebase.messaging');
    $client->refreshTokenWithAssertion();
    $token = $client->getAccessToken();

    if (!$token) {
        throw new Exception("Failed to get access token.");
    }
    } catch (Exception $e) {
        $response['response'] = 500;
        $response['error_msg'] = "Google Client error: " . $e->getMessage();
        echo json_encode($response);
        exit();
    }

    // Obtain the Bearer token
    $apiKey = $token['access_token'];

    // Compile headers for the request
    $headers = [
        'Authorization: Bearer ' . $apiKey,
        'Content-Type: application/json'
    ];

    // Prepare notification and data payload
    $notifData = [
        'title' => $title,
        'body' => $body,
    ];

    // Build the API body based on FCM v1 structure
    $apiBody = [
        'message' => [
            'topic' => 'all',  // Send to 'all' topic
            'notification' => $notifData,
            'android' => [
                'notification' => [
                    'click_action' => "FLUTTER_NOTIFICATION_CLICK"
                ]
            ],
        ]
    ];

    // Initialize curl with the prepared headers and body
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($apiBody));

    // Execute call and save result
    $result = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    echo $result;
    if ($httpCode == 200) {
        $response['response'] = 200;
        $response['error_msg'] = "Sent!";
    } else {
        $response['response'] = $httpCode;
        $response['error_msg'] = "Failed to send notification.";
    }
} else {
    $response['response'] = 500;
    $response['error_msg'] = "Invalid request method.";
}

echo json_encode($response);
?>
