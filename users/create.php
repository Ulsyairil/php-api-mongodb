<?php

include_once ($_SERVER['DOCUMENT_ROOT'] . "/config/server.php");

try {
    // Validation
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    if ($username == "") {
        $response = [
            'status' => 'error',
            'message' => 'Username must be filled'
        ];
        http_response_code(422);
        echo json_encode($response);
    } else if($email == "") {
        $response = [
            'status' => 'error',
            'message' => 'Email must be filled'
        ];
        http_response_code(422);
        echo json_encode($response);
    } else if($password == "") {
        $response = [
            'status' => 'error',
            'message' => 'Password must be filled'
        ];
        http_response_code(422);
        echo json_encode($response);
    } else {
        $collection = $db->users;
        $checkUsername = $collection->findOne([
            'username' => $username
        ]);
        $checkEmail = $collection->findOne([
            'email' => $email
        ]);
        if ($checkUsername != null) {
            $response = [
                'status' => 'error',
                'message' => 'Username already exists'
            ];
            http_response_code(422);
            echo json_encode($response);
        } else if($checkEmail != null) {
            $response = [
                'status' => 'error',
                'message' => 'Email already exists'
            ];
            http_response_code(422);
            echo json_encode($response);
        } else {
            $password = password_hash($password, PASSWORD_BCRYPT);
            $user = $collection->insertOne([
                'username' => $username,
                'email' => $email,
                'password' => $password,
            ]);

            $collection = $db->profiles;
            $profile = $collection->insertOne([
                'user_id' => $user->getInsertedId()
            ]);

            $response = [
                'status' => 'success',
                'message' => 'User has been add',
                'data' => $user->getInsertedId()
            ];
            http_response_code(200);
            echo json_encode($response);
        }
    }
} catch (\Exception $error) {
    http_response_code(500);
    $response = [
        'status' => 'error',
        'message' => 'Error when create user',
        'error' => $error
    ];
    echo json_encode($response);
}