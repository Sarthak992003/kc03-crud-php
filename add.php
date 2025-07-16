<?php
include 'db.php';

$title = $_POST['title'];
$desc = $_POST['description'];

$conn->query("INSERT INTO tasks (title, description) VALUES ('$title', '$desc')");
header("Location: index.php");
?>

