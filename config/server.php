<?php

include ($_SERVER['DOCUMENT_ROOT'] . "/config/access.php");
include ($_SERVER['DOCUMENT_ROOT'] . "/vendor/autoload.php");

try {
    $user = "";
    $pwd = "";

    $server = "mongodb://localhost:27017";

    $connect = new MongoDB\Client($server);
    $db = $connect->test; /** Choose database */
} catch (\Exception $error) {
    http_response_code(500);
    $response = [
        'status' => 'error',
        'message' => 'Error when connect database',
        'error' => $error
    ];
    echo json_encode($response);
    return $response;
}
