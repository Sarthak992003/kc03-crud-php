<?php include 'db.php'; ?>
<!DOCTYPE html>
<html>
<head>
  <title>KC03 CRUD App</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <h2>Task Manager</h2>

  <form action="add.php" method="POST">
    <input type="text" name="title" placeholder="Title" required>
    <input type="text" name="description" placeholder="Description" required>
    <button type="submit">Add Task</button>
  </form>

  <table>
    <tr><th>Title</th><th>Description</th><th>Actions</th></tr>
    <?php
      $result = $conn->query("SELECT * FROM tasks ORDER BY id DESC");
      while ($row = $result->fetch_assoc()):
    ?>
    <tr>
      <td><?= $row['title'] ?></td>
      <td><?= $row['description'] ?></td>
      <td>
        <a href="edit.php?id=<?= $row['id'] ?>">Edit</a> |
        <a href="delete.php?id=<?= $row['id'] ?>" onclick="return confirm('Delete this task?')">Delete</a>
      </td>
    </tr>
    <?php endwhile; ?>
  </table>
</body>
</html>
