<?php 
include "../config/connection.php";
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: ../login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM t_todos WHERE user_id = $user_id ORDER BY completed ASC, end_date ASC";
$result = mysqli_query($conn, $query);

// Display success/error messages
if (isset($_SESSION['success'])) {
    echo '<div class="alert alert-success"><i class="fas fa-check-circle"></i> '.$_SESSION['success'].'</div>';
    unset($_SESSION['success']);
}
if (isset($_SESSION['error'])) {
    echo '<div class="alert alert-danger"><i class="fas fa-exclamation-circle"></i> '.$_SESSION['error'].'</div>';
    unset($_SESSION['error']);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | To-Do List App</title>
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
                <a href="dashboard.php" class="active"><i class="fas fa-home"></i> Dashboard</a>
                <a href="add_task.php"><i class="fas fa-plus-circle"></i> Add New Task</a>
                <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
            </nav>
        </aside>

        <main class="main-content">
            <div class="content-header">
                <h2><i class="fas fa-tachometer-alt"></i> Dashboard</h2>
                <div class="actions">
                    <a href="add_task.php" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Add Task
                    </a>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h3><i class="fas fa-list"></i> Task List</h3>
                </div>
                <div class="card-body">
                    <?php if (mysqli_num_rows($result) > 0) { ?>
                    <table class="task-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Task</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Status</th>
                                <th>Days Left</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $counter = 1;
                            while ($row = mysqli_fetch_assoc($result)) {
                                $today = new DateTime();
                                $endDate = new DateTime($row['end_date']);
                                $daysLeft = $today->diff($endDate)->format('%r%a');
                                
                                $statusClass = '';
                                if ($row['completed'] == 1) {
                                    $status = 'Completed';
                                    $statusClass = 'completed';
                                } elseif ($daysLeft < 0) {
                                    $status = 'Overdue';
                                    $statusClass = 'overdue';
                                } else {
                                    $status = 'Pending';
                                    $statusClass = 'pending';
                                }
                            ?>
                            <tr class="<?php echo $statusClass; ?>">
                                <td><?php echo $counter++; ?></td>
                                <td><?php echo htmlspecialchars($row['todo']); ?></td>
                                <td><?php echo date('M d, Y', strtotime($row['start_date'])); ?></td>
                                <td><?php echo date('M d, Y', strtotime($row['end_date'])); ?></td>
                                <td>
                                    <span class="status-badge <?php echo $statusClass; ?>">
                                        <?php echo $status; ?>
                                    </span>
                                </td>
                                <td><?php echo $daysLeft; ?></td>
                                <td class="actions">
                                    <a href="edit_task.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-edit">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <a href="delete_task.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-delete" onclick="return confirm('Are you sure you want to delete this task?')">
                                        <i class="fas fa-trash"></i> Delete
                                    </a>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    <?php } else { ?>
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i> No tasks found. Add your first task!
                        </div>
                    <?php } ?>
                </div>
            </div>
        </main>
    </div>
    <footer class="footer">
        <p>&copy; <?php echo date('Y'); ?> To-Do List App. All rights reserved.</p>
    </footer>
</body>
</html>