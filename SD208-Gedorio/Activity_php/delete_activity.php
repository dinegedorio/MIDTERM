<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "website";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ensure that the request contains JSON data
    $data = json_decode(file_get_contents('php://input'));

    if ($data === null) {
        // Invalid or empty JSON data
        $response = array(
            'status' => 'error',
            'message' => 'Invalid JSON data.'
        );
    } else {
        // Extracted activity ID from the JSON data
        $activityId = $data->id;

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "DELETE FROM activities WHERE id = $activityId";

        if ($conn->query($sql) === TRUE) {
            $response = array(
                'status' => 'success',
                'message' => 'Activity deleted successfully.'
            );
        } else {
            $response = array(
                'status' => 'error',
                'message' => 'Error deleting activity: ' . $conn->error
            );
        }

        $conn->close();
    }
} else {
    // Request method is not POST
    $response = array(
        'status' => 'error',
        'message' => 'Invalid request method. Expected POST.'
    );
}

// response content type to JSON
header('Content-Type: application/json');

// Output for JSON response
echo json_encode($response);
?>