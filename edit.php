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

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Task</title>
  <style>
/* Google Font */
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap');

* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: 'Poppins', sans-serif;
}

body {
  background: linear-gradient(to right, #f6f9fc, #dbeafe);
  min-height: 100vh;
  display: flex;
  flex-direction: column;
  align-items: center;
  padding: 50px 20px;
  
  
  


}

h2 {
  margin-bottom: 30px;
  font-size: 2rem;
  color: #1e3a8a;
}

form {
  display: flex;
  gap: 10px;
  margin-bottom: 30px;
  flex-wrap: wrap;
  justify-content: center;
}

form input[type="text"] {
  padding: 10px;
  width: 220px;
  border: 1px solid #cbd5e1;
  border-radius: 5px;
  outline: none;
}

form button {
  padding: 10px 20px;
  background-color: #1e40af;
  color: #fff;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  transition: background 0.3s ease;
}

form button:hover {
  background-color: #1d4ed8;
}

table {
  width: 100%;
  max-width: 800px;
  border-collapse: collapse;
  background-color: #ffffff;
  border-radius: 8px;
  overflow: hidden;
  box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

th, td {
  padding: 15px;
  text-align: left;
  border-bottom: 1px solid #e2e8f0;
}

th {
  background-color: #1e40af;
  color: white;
}

a {
  color: #2563eb;
  text-decoration: none;
  font-weight: 500;
}

a:hover {
  text-decoration: underline;
}
body {
  background-image: url('https://s3.ap-south-1.amazonaws.com/awsimages.imagesbazaar.com/1200x1800-new/12207/SM393197.jpg?date=Tue%20Jul%2015%202025%2000:48:47%20GMT+0530%20(India%20Standard%20Time)');
  background-size: cover;
  background-position: center;
  background-repeat: no-repeat;
  background-attachment: fixed;
  min-height: 100vh;
  padding: 50px 20px;
  ;
}


</style>

</head>
<body>
  <h2>Task Manager</h2>

  <form action="add.php" method="POST">
    <input type="text" name="title" placeholder="Title" required>
    <input type="text" name="description" placeholder="Description" required>
    <button type="submit">Add Task</button>
  </form>
</head>
<body>
  <div class= "container">
    <h2>Edit Task</h2>
    <form action="" method="POST">
      <input type="text" name="title" value="<?= $row['title'] ?>" required>
      <input type="text" name="description" value="<?= $row['description'] ?>" required>
      <button type="submit">Update Task</button>
  </div>
</body>
</html>

