<?php
include '../connection/connection.php';

// Allow CORS
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] === 'POST') {
    // Decode JSON data from the request body
    $data = json_decode(file_get_contents('php://input'), true);

    // Check if decoding was successful
    if (json_last_error() === JSON_ERROR_NONE) {
        $parcel_number = "A-00" . rand(1, 50000) . "SHIM" . date("d");
        $from = mysqli_escape_string($conn, $data["from"]);
        $to = mysqli_escape_string($conn, $data["to"]);
        $recipient_name = mysqli_escape_string($conn, $data["recipient_name"]);
        $recipient_number = mysqli_escape_string($conn, $data["recipient_number"]);
        $recipient_address = mysqli_escape_string($conn, $data["recipient_address"]);
        $sender_name = mysqli_escape_string($conn, $data["sender_name"]);
        $sender_number = mysqli_escape_string($conn, $data["sender_number"]);
        $sender_address = mysqli_escape_string($conn, $data["sender_address"]);
        $items = mysqli_escape_string($conn, $data["items"]);
        $status = "Order Placed";
        $date = date("Y-m-d");

        $result = mysqli_query($conn, "INSERT INTO parcels (`parcel_number`,`inception`,`destination`,`sender`,`sender_phone`,`sender_address`,`recipient`,`recipient_address`,`recipient_phone`,`items`,`status`,`date`) 
        VALUES('$parcel_number','$from','$to','$recipient_name','$recipient_number','$recipient_address','$sender_name','$sender_number','$sender_address','$items','$status','$date')");

        if ($result) {
            echo json_encode([
                "status" => "200",
                "message" => "Data submitted successfully",
            ]);
        } else {
            echo json_encode([
                "status" => "400",
                "message" => "Bad request",
            ]);
        }
    } else {
        echo json_encode([
            "status" => "400",
            "message" => "Invalid JSON",
        ]);
    }
} else {
    echo json_encode([
        "status" => "405",
        "message" => $_SERVER["REQUEST_METHOD"] . " Method not allowed",
    ]);
}