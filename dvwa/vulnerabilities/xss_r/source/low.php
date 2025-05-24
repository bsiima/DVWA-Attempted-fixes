<?php

// Enable built-in browser protections
header("X-XSS-Protection: 1; mode=block");
header("Content-Security-Policy: default-src 'self'; script-src 'none'");

// Strict sanitization using htmlspecialchars
if (array_key_exists("name", $_GET) && $_GET['name'] !== NULL) {
    $safe_name = htmlspecialchars($_GET['name'], ENT_QUOTES, 'UTF-8');
    $html = '<pre>Hello ' . $safe_name . '</pre>';
    echo $html;
}

?>
