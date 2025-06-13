<?php
include "../config/connection.php";
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: ../login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $todo = mysqli_real_escape_string($conn, $_POST['todo']);
    $startdate = $_POST['startdate'];
    $enddate = $_POST['enddate'];
    $user_id = $_SESSION['user_id']; // Ambil user_id dari session
    
    $query = "INSERT INTO t_todos (user_id, todo, start_date, end_date) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("isss", $user_id, $todo, $startdate, $enddate);
    
    if ($stmt->execute()) {
        $_SESSION['success'] = "Task added successfully!";
        header("Location: dashboard.php");
        exit();
    } else {
        $_SESSION['error'] = "Error adding task: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Task | To-Do List App</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="../public/style.css">
</head>
<body>
    <div class="dashboard-container">
        <aside class="sidebar">
            <div class="sidebar-header">
                <h3><i class="fas fa-tasks"></i> To-Do App</h3>
                <p>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?></p>
            </div>
            <nav class="sidebar-nav">
                <a href="dashboard.php"><i class="fas fa-home"></i> Dashboard</a>
                <a href="add_task.php" class="active"><i class="fas fa-plus-circle"></i> Add New Task</a>
                <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
            </nav>
        </aside>

        <main class="main-content">
            <div class="content-header">
                <h2><i class="fas fa-plus-circle"></i> Add New Task</h2>
                <div class="actions">
                    <a href="dashboard.php" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to Dashboard
                    </a>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h3><i class="fas fa-tasks"></i> Task Details</h3>
                </div>
                <div class="card-body">
                    <form action="add_task.php" method="post" class="task-form">
                        <div class="form-group">
                            <label for="todo"><i class="fas fa-tasks"></i> Task Description</label>
                            <input type="text" name="todo" id="todo" required placeholder="Enter task description">
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="startdate"><i class="fas fa-calendar-alt"></i> Start Date</label>
                                <input type="date" name="startdate" id="startdate" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="enddate"><i class="fas fa-calendar-alt"></i> End Date</label>
                                <input type="date" name="enddate" id="enddate" required>
                            </div>
                        </div>
                        
                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Save Task
                            </button>
                            <button type="reset" class="btn btn-secondary">
                                <i class="fas fa-undo"></i> Reset
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>
    
    <script>
        // Set default dates
        document.getElementById('startdate').valueAsDate = new Date();
        let endDate = new Date();
        endDate.setDate(endDate.getDate() + 7);
        document.getElementById('enddate').valueAsDate = endDate;
    </script>
    </div>
            </div>
            <footer class="footer">
                <p>&copy; <?php echo date('Y'); ?> To-Do List App. All rights reserved.</p>
            </footer>
</body>
</html>