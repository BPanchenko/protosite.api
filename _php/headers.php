<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, PATH, DELETE, OPTIONS");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Max-Age: 0");
header("Cache-Control: public, max-age=0, must-revalidate");
header("Expires: " . gmdate('D, d М Y H:i:s', time() + 1800) . " GMT");
header("Content-Type: application/json; charset=utf-8");
?>