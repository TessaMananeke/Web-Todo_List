<?php
include "config/connection.php";
session_start();

if (isset($_POST['login'])) {
    $uname = mysqli_real_escape_string($conn, $_POST['uname']);
    $upass = $_POST['upass'];
    
    $query = "SELECT * FROM m_users WHERE username='$uname'";
    $result = mysqli_query($conn, $query);
    
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        
        // Verify password (plain text comparison for now - consider password_hash() for production)
        if ($upass === $row['password']) {
            $_SESSION['admin'] = true;
            $_SESSION['username'] = $row['username'];
            $_SESSION['user_id'] = $row['id'];
            header('Location: admin/dashboard.php');
            exit();
        }
    }
    
    header('Location: login.php?wrong=1');
    exit();
}
?>