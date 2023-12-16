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

    $sql = "UPDATE makanan SET nama='$nama', kehalalan='$kehalalan', jenis='$jenis', ciri='$ciri'
            WHERE id='$id';";

    $result = mysqli_query($conn, $sql);

    if ($result) {
        header("Location: makanan.php");
        exit();
    } else {
        echo "Data Gagal Diupdate " . mysqli_error($conn);
        header("Location: makanan.php");
        exit();
    }
} else {
    echo "Invalid form data";
}
?>
