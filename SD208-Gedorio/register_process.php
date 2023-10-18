<?php
include 'config.php';

if (isset($_POST['register'])) {
    $full_name = $_POST['full_name'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $age = $_POST['age'];
    $gender = $_POST['gender'];

    // Check if the username already exists
    $check_username_sql = "SELECT * FROM users WHERE username = '$username'";
    $result = $conn->query($check_username_sql);

    if ($result->num_rows > 0) {
        // Username already exists, handle this case 
        echo "Error: Username already exists.";
    } else {
        // Username is unique, proceed with registration
        $insert_sql = "INSERT INTO users (full_name, username, email, password, age, gender) VALUES ('$full_name', '$username', '$email', '$password', '$age', '$gender')";

        if ($conn->query($insert_sql) === TRUE) {
            // Registration successful
            header('Location: index.php?registration_successful=true');
            exit();
        } else {
            // Handle the case where the insert query fails
            echo "Error: " . $insert_sql . "<br>" . $conn->error;
        }
    }

    $conn->close();

    exit();
}
?>
