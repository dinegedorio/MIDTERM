<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "website";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get the data from the request
    $data = json_decode(file_get_contents("php://input"), true);

    if (isset($data["id"]) && isset($data["remarks"])) {
        $activityId = $data["id"];
        $remarks = $data["remarks"];


        // Create a database connection (modify this according to your database setup)
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "website";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Prepare an SQL statement to update the remarks
        $sql = "UPDATE activities SET remarks = ? WHERE id = ?";

        $stmt = $conn->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("si", $remarks, $activityId);

            if ($stmt->execute()) {
                $response = ["status" => "success", "message" => "Remarks saved successfully."];
                echo json_encode($response);
            } else {
                $response = ["status" => "error", "message" => "Failed to save remarks."];
                echo json_encode($response);
            }

            $stmt->close();
        } else {
            $response = ["status" => "error", "message" => "Error in preparing SQL statement."];
            echo json_encode($response);
        }

        $conn->close();
    } else {
        $response = ["status" => "error", "message" => "Invalid data received."];
        echo json_encode($response);
    }
} else {
    $response = ["status" => "error", "message" => "Invalid request method."];
    echo json_encode($response);
}
?>
