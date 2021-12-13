<?php
    // Template for new API files
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");

    // Allow GET
    header("Access-Control-Allow-Methods: GET");
    header("Access-Control-Allow-Credentials: true");

    // Allow POST
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 600");

    // Require the needed resources for doing API calls
    // Note: Remember to change to the correct folder path (../../folder/filename.php)
    require_once (dirname(__FILE__) . "/../config.php");
    require_once (ROOT . "/src/mysql.php");
    
    // Create json and data arrays
    $json = [];
    $data = [];

    // Instantiate a new MySQL database object, and connect
    $conn = new MySQL();
//    $conn->SetServer("host", "username", "passowrd");
//    $conn->SetDatabase("Name of database");
    $conn->Connect();


    // +--------------------------------------------+
    // | IMPLEMENT the actual API call content here |
    // +--------------------------------------------+

    // START
    $authToken = CheckAuthToken();

    if($authToken == null || $authToken == false) {
        $json['status'] = "failed";
        $json['message'] = "Unauthorized access";
    } else {
        unset($authToken['login']);
        $data = $authToken;
        
        // Check if there are any content in the data array, then return it
        if(sizeof($data) > 0) {
            // Add the data array to the json array
            $json['status'] = "success";
            $json['message'] = "User data can be found in the 'data' variable";
            $json['data'] = $data;
        } else {
            // Set status and message accordingly if no data was found
            $json['status'] = "failed";
            $json['message'] = "no data was found";
        }
    }

    // Convert the json array into JSON format, end print the result (can be used for fetch call from frontend)
    echo json_encode($json);
    

    
    function CheckAuthToken() {
        foreach(getallheaders() as $key => $value) {
            if($key === "Authentication") {
                $jsonString = base64_decode($value);
                $userData = json_decode($jsonString, true);

                if($userData['login'] == true) {
                    return $userData;
                } else {
                    return false;
                }
            }
        }
    }
?>