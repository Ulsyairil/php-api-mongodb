<?php

include_once ($_SERVER['DOCUMENT_ROOT'] . "/config/server.php");

try {
    // Validation
    $id = $_POST['id'];
    $name = $_POST['name'];
    $gender = $_POST['gender'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];

    if ($id == "") {
        $response = [
            'status' => 'error',
            'message' => 'ID must be filled'
        ];
        http_response_code(422);
        echo json_encode($response);
    } else if($name == "") {
        $response = [
            'status' => 'error',
            'message' => 'Name must be filled'
        ];
        http_response_code(422);
        echo json_encode($response);
    } else if($gender == "") {
        $response = [
            'status' => 'error',
            'message' => 'Gender must be filled'
        ];
        http_response_code(422);
        echo json_encode($response);
    } else if($gender != "man" && $gender != "woman") {
        $response = [
            'status' => 'error',
            'message' => 'Gender must choose men or woman'
        ];
        http_response_code(422);
        echo json_encode($response);
    } else if($address == "") {
        $response = [
            'status' => 'error',
            'message' => 'Address must be filled'
        ];
        http_response_code(422);
        echo json_encode($response);
    } else if($phone == "") {
        $response = [
            'status' => 'error',
            'message' => 'Phone number must be filled'
        ];
        http_response_code(422);
        echo json_encode($response);
    } else {
        $collection = $db->profiles;
        $check = $collection->findOne([
            'user_id' => $id
        ]);
        if ($check != null) {
            $response = [
                'status' => 'error',
                'message' => 'ID not found'
            ];
            http_response_code(422);
            echo json_encode($response);
        } else {
            $profile = $collection->updateOne(
                ['user_id' => new \MongoDB\BSON\ObjectID($id)],
                [ '$set' => [
                        'name' => $name,
                        'gender' => $gender,
                        'address' => $address,
                        'phone' => $phone
                    ]
                ]
            );
            $response = [
                'status' => 'success',
                'message' => 'Profile has been update'
            ];
            http_response_code(200);
            echo json_encode($response);
        } 
    }

    
} catch (\Exception $error) {
    http_response_code(500);
    $response = [
        'status' => 'error',
        'message' => 'Error when update profile',
        'error' => $error
    ];
    echo json_encode($response);
}
