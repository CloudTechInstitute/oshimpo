<?php
include '../connection/connection.php';
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, ngrok-skip-browser-warning");
header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] === 'GET') {
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $query = "SELECT * FROM parcels WHERE id = $id";

        $result = mysqli_query($conn, $query);

        if ($result) {
            $parcels = [];
            while ($row = mysqli_fetch_assoc($result)) {
                if (isset($row['items'])) {
                    $itemsArray = explode(',', $row['items']);
                    $row['items'] = $itemsArray;
                }

                $parcels[] = $row;
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
        echo json_encode(["status" => "400", "message" => "No ID specified"]);
    }
} else {
    echo json_encode(["status" => "405", "message" => $_SERVER["REQUEST_METHOD"] . " Method not allowed"]);
}
?>