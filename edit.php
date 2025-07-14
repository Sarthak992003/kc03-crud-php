<?php
include 'db.php';
$id = $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $title = $_POST['title'];
  $desc = $_POST['description'];
  $conn->query("UPDATE tasks SET title='$title', description='$desc' WHERE id=$id");
  header("Location: index.php");
  exit;
}

$result = $conn->query("SELECT * FROM tasks WHERE id=$id");
$row = $result->fetch_assoc();
?>

<form method="POST">
  <input name="title" value="<?= $row['title'] ?>" required>
  <input name="description" value="<?= $row['description'] ?>" required>
  <button type="submit">Update</button>
</form>
