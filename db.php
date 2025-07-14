<?php
$conn = new mysqli(
  "mysql.railway.internal", // ← Host
  "root",                              // ← Username
  "vazoWsJrBqTkBEQIYJdkXhzRAoJyGdkF",          // ← Password from Railway
  "railway",                           // ← Database name
  3306                                 // ← Port
);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
?>
