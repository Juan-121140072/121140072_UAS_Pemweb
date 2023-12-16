<?php
session_start();
include "db_con.php";

if (isset($_POST["id"]) && isset($_POST["nama"]) && isset($_POST["kehalalan"]) && isset($_POST["jenis"]) && isset($_POST["ciri"])) {
    $id = mysqli_real_escape_string($conn, $_POST["id"]);
    $nama = mysqli_real_escape_string($conn, $_POST["nama"]);
    $kehalalan = mysqli_real_escape_string($conn, $_POST["kehalalan"]);
    $jenis = mysqli_real_escape_string($conn, $_POST["jenis"]);

    $ciriValues = isset($_POST["ciri"]) ? $_POST["ciri"] : array();
    $ciri = implode(", ", $ciriValues);

    $sql = "INSERT INTO makanan (id, nama, kehalalan, jenis, ciri)
            VALUES ('$id', '$nama', '$kehalalan', '$jenis', '$ciri');";

    $result = mysqli_query($conn, $sql);

    if ($result) {
        header("Location: makanan.php");
        exit();
    } else {
        echo "Data Gagal Diinput " . mysqli_error($conn);
        header("Location: makanan.php");
        exit();
    }
} else {
    echo "Invalid form data";
}
?>
