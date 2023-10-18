<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "website";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $activity_name = $_POST["activity_name"]; 
    $activity_date = $_POST["activity_date"]; 
    $activity_time = $_POST["activity_time"]; 
    $activity_location = $_POST["activity_location"]; 
    $activity_ootd = $_POST["activity_ootd"]; 
    
    $sql = "INSERT INTO activities (activity_name, activity_date, activity_time, activity_location, activity_ootd)
    VALUES ('$activity_name', '$activity_date', '$activity_time', '$activity_location', '$activity_ootd')";
    if ($conn->query($sql) === TRUE) {
        $response = array('status' => 'success', 'message' => 'Activity added successfully');
        echo json_encode($response);
    } else {
        $response = array('status' => 'error', 'message' => "Error: " . $sql . "<br>" . $conn->error);
        echo json_encode($response);
    }
}
$conn->close()

?>
