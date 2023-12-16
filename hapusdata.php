<?php
include "db_con.php";

$response = array(); 

if (isset($_GET["del"])) {
    $del = $_GET["del"];

    $sql = "DELETE FROM makanan WHERE id='$del'";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        $response["success"] = true;
        $response["message"] = "Deletion successful";
    } else {
        $response["success"] = false;
        $response["message"] = "Deletion failed: " . mysqli_error($conn);
    }
} else {
    $response["success"] = false;
    $response["message"] = "Invalid request. 'del' parameter not set.";
}

header('Content-Type: application/json');
echo json_encode($response);
exit();
?>
