<?php
include "../config/connection.php";
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: ../login.php");
    exit();
}

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $user_id = $_SESSION['user_id'];
    
    $query = "DELETE FROM t_todos WHERE id = ? AND user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $id, $user_id);
    
    if ($stmt->execute()) {
        $_SESSION['success'] = "Task deleted successfully!";
    } else {
        $_SESSION['error'] = "Error deleting task: " . $conn->error;
    }
}

header("Location: dashboard.php");
exit();
?>