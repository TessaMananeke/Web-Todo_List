<?php
include "../config/connection.php";
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: ../login.php");
    exit();
}

if (!isset($_GET['id'])) {
    header("Location: dashboard.php");
    exit();
}

$id = intval($_GET['id']);
$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM t_todos WHERE id = ? AND user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $id, $user_id);
$stmt->execute();
$result = $stmt->get_result();
$task = $result->fetch_assoc();

if (!$task) {
    $_SESSION['error'] = "Task not found!";
    header("Location: dashboard.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $todo = mysqli_real_escape_string($conn, $_POST['todo']);
    $startdate = $_POST['startdate'];
    $enddate = $_POST['enddate'];
    $completed = isset($_POST['completed']) ? 1 : 0;
    
    $query = "UPDATE t_todos SET todo = ?, start_date = ?, end_date = ?, completed = ? WHERE id = ? AND user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssiii", $todo, $startdate, $enddate, $completed, $id, $user_id);
    
    if ($stmt->execute()) {
        $_SESSION['success'] = "Task updated successfully!";
        header("Location: dashboard.php");
        exit();
    } else {
        $_SESSION['error'] = "Error updating task: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Task | To-Do List App</title>
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
                <a href="add_task.php"><i class="fas fa-plus-circle"></i> Add New Task</a>
                <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
            </nav>
        </aside>

        <main class="main-content">
            <div class="content-header">
                <h2><i class="fas fa-edit"></i> Edit Task</h2>
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
                    <form action="edit_task.php?id=<?php echo $id; ?>" method="post" class="task-form">
                        <div class="form-group">
                            <label for="todo"><i class="fas fa-tasks"></i> Task Description</label>
                            <input type="text" name="todo" id="todo" required 
                                   value="<?php echo htmlspecialchars($task['todo']); ?>">
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="startdate"><i class="fas fa-calendar-alt"></i> Start Date</label>
                                <input type="date" name="startdate" id="startdate" required
                                       value="<?php echo $task['start_date']; ?>">
                            </div>
                            
                            <div class="form-group">
                                <label for="enddate"><i class="fas fa-calendar-alt"></i> End Date</label>
                                <input type="date" name="enddate" id="enddate" required
                                       value="<?php echo $task['end_date']; ?>">
                            </div>
                        </div>
                        
                        <div class="form-group checkbox-group">
                            <input type="checkbox" name="completed" id="completed" 
                                   <?php echo $task['completed'] ? 'checked' : ''; ?>>
                            <label for="completed">Mark as completed</label>
                        </div>
                        
                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Update Task
                            </button>
                            <a href="dashboard.php" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>
    </div>
            </div>
            <footer class="footer">
                <p>&copy; <?php echo date('Y'); ?> To-Do List App. All rights reserved.</p>
            </footer>
</body>
</html>