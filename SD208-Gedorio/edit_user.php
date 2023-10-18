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
    $userId = $_POST["editUserId"];
    $fullName = $_POST["editFullName"];
    $email = $_POST["editEmail"];
    $gender = $_POST["editGender"];
    $age = $_POST["editAge"];

    // Update user details in the database
    $updateSql = "UPDATE users SET full_name = '$fullName', email = '$email', gender = '$gender', age = '$age' WHERE id = $userId"; 
    
    if ($conn->query($updateSql) === TRUE) {
        // User details updated successfully
        header("Location: admin.php"); // Redirect back to the admin page
        exit();
    } else {
        echo "Error updating user: " . $conn->error;
    }
}

$conn->close();
?>
