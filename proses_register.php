<?php
include "config/connection.php";
session_start();

if (isset($_POST['register'])) {
    $uname = mysqli_real_escape_string($conn, $_POST['uname']);
    $upass = $_POST['upass'];
    $confirmpass = $_POST['confirmpass'];
    
    // Check if passwords match
    if ($upass !== $confirmpass) {
        header('Location: register.php?error=Passwords do not match');
        exit();
    }
    
    // Check if username already exists
    $check_query = "SELECT * FROM m_users WHERE username='$uname'";
    $check_result = mysqli_query($conn, $check_query);
    
    if (mysqli_num_rows($check_result) > 0) {
        header('Location: register.php?error=Username already exists');
        exit();
    }
    
    // Insert new user with plain text password (consider password_hash() for production)
    $query = "INSERT INTO m_users (username, password) VALUES ('$uname', '$upass')";
    $result = mysqli_query($conn, $query);
    
    if ($result) {
        $_SESSION['success'] = "Registration successful! Please login.";
        header('Location: login.php');
        exit();
    } else {
        header('Location: register.php?error=Registration failed');
        exit();
    }
}
?>