<?php
session_start();
error_reporting(0);

define("LOCALHOST", "127.0.0.1:3307");
define("USERNAME", "root");
define("PASSWORD", "");
define("SELECTED_DB", "db_todo_list");

$conn = new mysqli(LOCALHOST, USERNAME, PASSWORD, SELECTED_DB);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$conn->set_charset("utf8mb4");
?>