<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "website";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the activity ID from the query parameters
$activityId = $_GET["id"];

// Retrieve the activity details from the database
$sql = "SELECT * FROM activities WHERE id='$activityId'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $activity = array(
        "activity_name" => $row["activity_name"],
        "activity_date" => $row["activity_date"],
        "activity_time" => $row["activity_time"],
        "activity_location" => $row["activity_location"],
        "activity_ootd" => $row["activity_ootd"]
    );
    $response = array("status" => "success", "activity" => $activity);
    echo json_encode($response);
} else {
    $response = array("status" => "error", "message" => "Activity not found.");
    echo json_encode($response);
}

$conn->close();
?>
