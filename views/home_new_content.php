<?php
// Extract only the content section from home_new.php (without navbar and footer)
// This prevents CSS conflicts with old site styles

// Read the home_new.php file
$home_new_path = __DIR__ . '/../shuurkhai-home/views/home_new.php';
if (file_exists($home_new_path)) {
    $content = file_get_contents($home_new_path);
    
    // Find Hero Section start (after navbar and mobile menu)
    $hero_start = strpos($content, '<!-- Hero Section -->');
    // Find Footer start
    $footer_start = strpos($content, '<!-- Footer -->');
    
    if ($hero_start !== false && $footer_start !== false) {
        // Extract content between Hero Section and Footer
        $content_only = substr($content, $hero_start, $footer_start - $hero_start);
        echo $content_only;
    } else {
        // Fallback: include whole file if parsing fails
        include $home_new_path;
    }
}
?>

