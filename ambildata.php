<?php
session_start();
include "db_con.php";

$filterJenis = isset($_GET['jenis']) ? $_GET['jenis'] : null;

$sql = "SELECT * FROM makanan";

if ($filterJenis !== null) {
    $sql .= " WHERE jenis = '$filterJenis'";
}

$result = mysqli_query($conn, $sql);

$dataArray = [];

if ($result) {
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $dataObject = [
                'id' => $row["id"],
                'nama' => $row["nama"],
                'kehalalan' => $row["kehalalan"],
                'jenis' => $row["jenis"],
                'ciri' => explode(',', $row["ciri"]) 
            ];
            $dataArray[] = $dataObject;
        }

        header('Content-Type: application/json');
        echo json_encode($dataArray);
        exit();  
    } else {
        header('Content-Type: application/json');
        echo json_encode($dataArray);
        exit();  
    }
} else {
    echo "Data Gagal diambil " . mysqli_error($conn);
    header("Location: makanan.php");
    exit();
}
?>
