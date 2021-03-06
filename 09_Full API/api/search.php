<?php
    // Template for new API files
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");

    // Allow GET
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Allow-Credentials: true");

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
    $searchInput = isset($_GET['query']) ? $_GET['query'] : null;

    if($searchInput != null) {
        $sql = "SELECT * FROM users WHERE firstName LIKE('$searchInput%')";
        $result = $conn->mySQL->query($sql);

        while($row = $result->fetch_object()) {
            $user['id'] = $row->id;
            $user['name'] = $row->firstName;
            $user['age'] = $row->age;
            $user['country'] = $row->country;
            $user['gender'] = $row->gender;
            $data[] = $user;
        }
    }
    // END


    // Check if there are any content in the data array, then return it
    if(sizeof($data) > 0) {
        // Add the data array to the json array
        $json['status'] = "success";
        $json['data'] = $data;
    } else {
        // Set status and message accordingly if no data was found
        $json['status'] = "failed";
        $json['message'] = "no data was found";
    }

    // Convert the json array into JSON format, end print the result (can be used for fetch call from frontend)
    echo json_encode($json);
?>