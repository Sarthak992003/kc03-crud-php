<?php include 'db.php'; ?>
<!DOCTYPE html>
<html>
<head>
  <title>KC03 CRUD App</title>
 <link rel="stylesheet" href="style.css">
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

.chatbox {
  position: fixed;
  bottom: 80px;
  right: 20px;
  width: 320px;
  background: white;
  border: 1px solid #ccc;
  border-radius: 12px;
  box-shadow: 0 0 12px rgba(0,0,0,0.2);
  z-index: 999;
  overflow: hidden;
  display: flex;
  flex-direction: column;
}

.chatbox.hidden {
  display: none;
}

.chat-header {
  background: #4f46e5;
  color: white;
  padding: 10px;
  font-weight: bold;
  text-align: left;
}

.chat-messages {
  padding: 10px;
  height: 200px;
  overflow-y: auto;
  font-size: 14px;
  background: #f9fafb;
}

.chat-input {
  display: flex;
  border-top: 1px solid #eee;
}

.chat-input input {
  flex: 1;
  border: none;
  padding: 10px;
  font-size: 14px;
}

.chat-input button {
  padding: 10px;
  background: #4f46e5;
  color: white;
  border: none;
  cursor: pointer;
}

/* Floating Button */
.chat-toggle {
  position: fixed;
  bottom: 20px;
  right: 20px;
  background: #4f46e5;
  color: white;
  font-size: 22px;
  width: 50px;
  height: 50px;
  text-align: center;
  line-height: 50px;
  border-radius: 50%;
  box-shadow: 0 0 10px rgba(0,0,0,0.3);
  cursor: pointer;
  z-index: 1000;
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

 <!-- Floating Chat Icon -->
<div id="chatToggleBtn" class="chat-toggle" onclick="toggleChatbox()">💬</div>

<!-- Chat Box -->
<div id="chatContainer" class="chatbox hidden">
  <div class="chat-header">
    Ask Gemini
    <span onclick="toggleChatbox()" style="float:right; cursor:pointer;">✖</span>
  </div>
  <div class="chat-messages" id="chatMessages"></div>
  <div class="chat-input">
    <input type="text" id="chatInput" placeholder="Ask something..." />
    <button onclick="sendToGemini()">Send</button>
  </div>
</div>



<script>
const API_KEY = "AIzaSyDTx2dV0Xa53FHtFSl2qdHtg3dI8TB273Y"; // replace this

function toggleChatbox() {
  const chat = document.getElementById('chatContainer');
  chat.classList.toggle('hidden');
}

async function sendToGemini() {
  const input = document.getElementById('chatInput');
  const message = input.value.trim();
  if (!message) return;

  const chatBox = document.getElementById('chatMessages');
  chatBox.innerHTML += `<div><strong>You:</strong> ${message}</div>`;
  input.value = '';
  chatBox.scrollTop = chatBox.scrollHeight;

  try {
    const response = await fetch(`https://generativelanguage.googleapis.com/v1beta/models/chat-bison-001:generateMessage?key=${API_KEY}`, {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({
        prompt: {
          messages: [{ author: "user", content: message }]
        }
      })
    });

    const data = await response.json();
    const reply = data.candidates?.[0]?.content || "Gemini couldn't reply.";
    chatBox.innerHTML += `<div><strong>Gemini:</strong> ${reply}</div>`;
    chatBox.scrollTop = chatBox.scrollHeight;
  } catch (error) {
    chatBox.innerHTML += `<div><strong>Gemini:</strong> Error: ${error.message}</div>`;
  }
}
</script>






</body>
</html>
