<?php
$servername = "localhost";
$username = "zipszwh1_test123";
$password = "d2[90?%h;0tL";
$dbname = "zipszwh1_test123db";



try {
  $conn = new PDO("mysql:host=$servername;dbname=myDB", $username, $password);
  // set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  echo "Connected successfully";
} catch(PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}
?>
