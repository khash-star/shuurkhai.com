<?php
/**
 * GitHub Webhook Deployment Script
 * 
 * SECURITY: Энэ файлыг public_html-ийн гадна байрлуулах эсвэл .htaccess дээр хамгаалах
 * 
 * Usage:
 * 1. GitHub → Settings → Webhooks → Add webhook
 * 2. Payload URL: https://shuurkhai.com/deploy.php
 * 3. Secret: (энэ script дээрх $secret-тэй ижил байх)
 * 4. Content type: application/json
 * 5. Events: Just the push event
 */

// SECURITY: Secret key (GitHub webhook дээрх secret-тэй ижил байх)
$secret = 'CHANGE_THIS_TO_RANDOM_SECRET_KEY';

// Get payload
$payload = file_get_contents('php://input');
$signature = $_SERVER['HTTP_X_HUB_SIGNATURE_256'] ?? '';

// Verify signature
if (empty($signature)) {
    http_response_code(403);
    die('No signature provided');
}

// Calculate expected signature
$expected_signature = 'sha256=' . hash_hmac('sha256', $payload, $secret);

// Verify signature
if (!hash_equals($expected_signature, $signature)) {
    http_response_code(403);
    die('Invalid signature');
}

// Parse payload
$data = json_decode($payload, true);

// Only process push events
if (!isset($data['ref']) || $data['ref'] !== 'refs/heads/main') {
    http_response_code(200);
    die('Not a main branch push');
}

// Log deployment
$logFile = __DIR__ . '/logs/deployment.log';
$logDir = dirname($logFile);
if (!is_dir($logDir)) {
    mkdir($logDir, 0755, true);
}

$logMessage = date('Y-m-d H:i:s') . " - Deployment triggered by: " . ($data['pusher']['name'] ?? 'unknown') . "\n";
file_put_contents($logFile, $logMessage, FILE_APPEND);

// Get repository path (adjust this to your actual path)
$repoPath = __DIR__; // Current directory (should be where git repo is)

// Change to repository directory
chdir($repoPath);

// Git pull
$output = [];
$returnVar = 0;
exec('git pull origin main 2>&1', $output, $returnVar);

// Log output
$logMessage = "Git pull output:\n" . implode("\n", $output) . "\n";
file_put_contents($logFile, $logMessage, FILE_APPEND);

// Composer install (if composer.json exists)
if (file_exists($repoPath . '/composer.json')) {
    exec('composer install --no-dev --optimize-autoloader 2>&1', $output, $returnVar);
    $logMessage = "Composer install output:\n" . implode("\n", $output) . "\n";
    file_put_contents($logFile, $logMessage, FILE_APPEND);
}

// Clear cache (if cache directory exists)
if (is_dir($repoPath . '/cache')) {
    exec('rm -rf ' . $repoPath . '/cache/* 2>&1', $output, $returnVar);
    $logMessage = "Cache cleared\n";
    file_put_contents($logFile, $logMessage, FILE_APPEND);
}

// Success
http_response_code(200);
echo json_encode([
    'status' => 'success',
    'message' => 'Deployment completed',
    'timestamp' => date('Y-m-d H:i:s')
]);
