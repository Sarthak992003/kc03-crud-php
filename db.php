<?php
$conn = new mysqli(
  "yamabiko.proxy.rlwy.net",   // Host
  "root",                      // User
  "vazoWsJrBqTkBEQIYJdkXhzRAoJyGdkF",   // Password (from Railway)
  "railway",                   // Database name
  57099                        // Port
);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
?>
