<?php
include "../config/connection.php";
session_start();

if(isset($_POST['proses'])) {
    $id = $_POST['id'];
    $user_id = $_SESSION['user_id'];
    $todo = $_POST['todo'];
    $startdate = $_POST['startdate'];
    $enddate = $_POST['enddate'];
    $completed = isset($_POST['completed']) ? 1 : 0;
    
    $query = "UPDATE t_todos SET todo = ?, start_date = ?, end_date = ?, completed = ? WHERE id = ? AND user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssssii", $todo, $startdate, $enddate, $completed, $id, $user_id);
    
    if ($stmt->execute()) {
        $_SESSION['success'] = "Task updated successfully!";
        header("Location: dashboard.php");
        exit();
    } else {
        $_SESSION['error'] = "Error updating task: " . $conn->error;
    }
}
?>