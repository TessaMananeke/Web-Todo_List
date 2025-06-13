<?php
include "config/connection.php";
if (isset($_GET['wrong'])) {
    echo "<script>alert('Invalid username or password')</script>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | To-Do List App</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="public/style.css">
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <h2><i class="fas fa-tasks"></i> To-Do List App</h2>
                <p>User Login</p>
            </div>
            <form action="proses_login.php" method="post" class="login-form">
                <div class="form-group">
                    <label for="username"><i class="fas fa-user"></i> Username</label>
                    <input type="text" name="uname" id="username" required>
                </div>
                <div class="form-group">
                    <label for="userpass"><i class="fas fa-lock"></i> Password</label>
                    <input type="password" name="upass" id="userpass" required>
                </div>
                <button type="submit" name="login" class="login-btn">
                    <i class="fas fa-sign-in-alt"></i> Login
                </button>
                <div class="register-link">
                Don't have an account? <a href="register.php">Register here</a>
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