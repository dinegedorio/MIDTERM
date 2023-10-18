<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "website";

// Check if HTTP request method is POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $activityId = $_POST["id"];

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Delete the activity based on its ID
    $sql = "DELETE FROM activities WHERE id = $activityId";

    if ($conn->query($sql) === true) {
        // If the deletion is successful, return a JSON response
        header('Content-Type: application/json');
        echo json_encode(["status" => "success", "message" => "Activity deleted successfully"]);
    } else {
        // If there was an error, return an error response
        header('Content-Type: application/json');
        echo json_encode(["status" => "error", "message" => "Error deleting activity: " . $conn->error]);
    }

    $conn->close();
} else {
    // If the request method is not POST, return an error response
    header('Content-Type: application/json');
    echo json_encode(["status" => "error", "message" => "Invalid request method"]);
}
?>