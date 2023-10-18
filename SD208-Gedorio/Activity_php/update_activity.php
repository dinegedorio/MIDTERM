<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "website";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get the data from the request
    $data = json_decode(file_get_contents("php://input"), true);

    if (isset($data["id"])) {
        $activityId = $data["id"];

        // Check if the "status" field is set, if yes, update status
        if (isset($data["status"])) {
            $newStatus = $data["status"];
            $updateSql = "UPDATE activities SET activity_status = ? WHERE id = ?";
            $stmtUpdate = $conn->prepare($updateSql);

            if ($stmtUpdate) {
                $stmtUpdate->bind_param("si", $newStatus, $activityId);

                if ($stmtUpdate->execute()) {
                    $response = ["status" => "success", "message" => "Activity status updated successfully."];
                    echo json_encode($response);
                } else {
                    $response = ["status" => "error", "message" => "Failed to update activity status."];
                    echo json_encode($response);
                }

                $stmtUpdate->close();
            } else {
                $response = ["status" => "error", "message" => "Error in preparing SQL statement for updating status."];
                echo json_encode($response);
            }
        }

        // Check if the other fields are set, if yes, update details
        if (isset($data["activity_name"])) {
            $sql = "UPDATE activities SET 
                    activity_name = ?, 
                    activity_date = ?, 
                    activity_time = ?, 
                    activity_location = ?,
                    activity_ootd = ?
                    WHERE id = ?";

            $stmt = $conn->prepare($sql);

            if ($stmt) {
                $stmt->bind_param("sssssi", 
                    $data["activity_name"],
                    $data["activity_date"],
                    $data["activity_time"],
                    $data["activity_location"],
                    $data["activity_ootd"],
                    $activityId
                );

                if ($stmt->execute()) {
                    $response = ["status" => "success", "message" => "Activity details updated successfully."];
                    echo json_encode($response);
                } else {
                    $response = ["status" => "error", "message" => "Failed to update activity details."];
                    echo json_encode($response);
                }

                $stmt->close();
            } else {
                $response = ["status" => "error", "message" => "Error in preparing SQL statement."];
                echo json_encode($response);
            }
        }
    } else {
        $response = ["status" => "error", "message" => "Invalid data received."];
        echo json_encode($response);
    }
} else {
    $response = ["status" => "error", "message" => "Invalid request method."];
    echo json_encode($response);
}
$conn->close();
?>