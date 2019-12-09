<?php

error_reporting(0);
$AUTH_USER = 'admin';
$AUTH_PW = 'QzYRFykEDMZ9q5iwHDzbMgy3BNQ4b2fz'; /** Make your own password (Optional using md5) */

try {
    header('Cache-Control: no-cache, must-revalidate, max-age=0');
    $has_supplied_credentials = !(empty($_SERVER['PHP_AUTH_USER']) && empty($_SERVER['PHP_AUTH_PW']));
    $is_not_authenticated = (!$has_supplied_credentials ||
        $_SERVER['PHP_AUTH_USER'] != $AUTH_USER ||
        $_SERVER['PHP_AUTH_PW']   != $AUTH_PW);
    if ($is_not_authenticated) {
        http_response_code(200);
        header('HTTP/1.1 401 Authorization Required');
        header('WWW-Authenticate: Basic realm="Access denied"');
        $response = [
            'status' => 'error',
            'message' => "You don't have access this site"
        ];
        echo json_encode($response);
        exit;
    }
} catch (\Exception $error) {
    http_response_code(500);
    $response = [
        'status' => 'error',
        'message' => 'Error when access',
        'error' => $error
    ];
    echo json_encode($response);
}