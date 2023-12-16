<?php

$sname= "localhost";
$uname= "id21680724_juan";
$password= "passwordDB123!";
$db_name= "id21680724_uas_pemweb";

$conn = mysqli_connect($sname, $uname, $password, $db_name);

// Check koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }
  ?>