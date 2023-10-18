<?php
session_start();
include 'config.php';

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $adminUsername = "admin";
    $adminPassword = "admin12345";

    // Check if the user is an admin
    if ($username === $adminUsername && $password === $adminPassword) {
        header("Location: admin.php");
        exit();
    } else {
        $sql = "SELECT * FROM users WHERE username='$username'";
        $result = $conn->query($sql);

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            if (password_verify($password, $row['password'])) {
                // Store the username in a session variable
                $_SESSION['username'] = $username;

                $user_id = $row['id'];
                $updateStatusSql = "UPDATE users SET status = 1 WHERE id = $user_id";
                if ($conn->query($updateStatusSql) === TRUE) {
                    header("Location: userpage.php");
                    exit();
                } else {
                    echo '<script>alert("Error updating user status.");</script>';
                    echo '<script>window.location.href = "index.php";</script>';
                }
            } else {
                echo '<script>alert("Invalid password.");</script>';
                echo '<script>window.location.href = "index.php";</script>';
            }
        } else {
            echo '<script>alert("User not found.");</script>';
            echo '<script>window.location.href = "index.php";</script>';
        }
    }
}
?>