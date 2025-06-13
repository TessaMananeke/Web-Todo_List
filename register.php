<?php
include "config/connection.php";
if (isset($_GET['error'])) {
    echo "<script>alert('".$_GET['error']."')</script>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | To-Do List App</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="public/style.css">
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <h2><i class="fas fa-tasks"></i> To-Do List App</h2>
                <p>Create New Account</p>
            </div>
            <form action="proses_register.php" method="post" class="login-form">
                <div class="form-group">
                    <label for="username"><i class="fas fa-user"></i> Username</label>
                    <input type="text" name="uname" id="username" required>
                </div>
                <div class="form-group">
                    <label for="userpass"><i class="fas fa-lock"></i> Password</label>
                    <input type="password" name="upass" id="userpass" required>
                </div>
                <div class="form-group">
                    <label for="confirmpass"><i class="fas fa-lock"></i> Confirm Password</label>
                    <input type="password" name="confirmpass" id="confirmpass" required>
                </div>
                <button type="submit" name="register" class="login-btn">
                    <i class="fas fa-user-plus"></i> Register
                </button>
                <div class="register-link">
                    Already have an account? <a href="login.php">Login here</a>
                </div>
            </form>
            </div>
            </div>
            <footer class="footer">
                <p>&copy; <?php echo date('Y'); ?> To-Do List App. All rights reserved.</p>
            </footer>
        </div>
    </div>
</body>
</html>