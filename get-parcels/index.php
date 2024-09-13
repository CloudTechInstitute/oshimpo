<?php
include '../connection/connection.php';
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, ngrok-skip-browser-warning");
header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] === 'GET') {

    $result = mysqli_query($conn, "SELECT * FROM parcels");
    if ($result) {
        $parcels = [];
        while ($row = mysqli_fetch_assoc($result)) {
            // Split the 'items' field by commas into an array
            if (isset($row['items'])) {
                $itemsArray = explode(',', $row['items']); // Split items by commas
                $row['items'] = $itemsArray; // Replace 'items' with the array
                $row['item_count'] = count($itemsArray); // Count the items and store in 'item_count'
            } else {
                $row['item_count'] = 0; // If no items field, set item_count to 0
            }

            $parcels[] = $row; // Add modified row to parcels array
        }

        if (!empty($parcels)) {
            echo json_encode(["status" => "200", "message" => "Data fetched successfully", "parcels" => $parcels]);
        } else {
            echo json_encode(["status" => "404", "message" => "No parcel found"]);
        }
    } else {
        echo json_encode(["status" => "500", "message" => "Failed to fetch parcels"]);
    }
} else {
    echo json_encode(["status" => "405", "message" => $_SERVER["REQUEST_METHOD"] . " Method not allowed"]);
}