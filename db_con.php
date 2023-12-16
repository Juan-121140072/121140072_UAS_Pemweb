<?php

$sname= "localhost";
$uname= "root";
$password= "";
$db_name= "uas_pemweb";

$conn = mysqli_connect($sname, $uname, $password, $db_name);

// Check koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }
  ?>