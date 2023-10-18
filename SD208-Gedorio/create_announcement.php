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
    $announcementTitle = $_POST["announcementTitle"];
    $announcementContent = $_POST["announcementContent"];

    $insertSql = "INSERT INTO announcements (title, content) VALUES (?, ?)";
    $stmt = $conn->prepare($insertSql);
    $stmt->bind_param("ss", $announcementTitle, $announcementContent);

    if ($stmt->execute()) {
        echo "Announcement created successfully!";
    } else {
        echo "Error creating announcement: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>