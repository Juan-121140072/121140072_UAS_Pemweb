<?php
session_start();
include "db_con.php";

$response = array("success" => false, "message" => "");

if (isset($_POST['username']) && isset($_POST['password'])) {
    function validate($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $username = validate($_POST['username']);
    $password = validate($_POST['password']);

    if (empty($username)) {
        $_SESSION['error'] = "User Name is required";
    } else if (empty($password)) {
        $_SESSION['error'] = "Password is required";
    } else {
        $sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) === 1) {
            $row = mysqli_fetch_assoc($result);
            if ($row['username'] === $username && $row['password'] === $password) {
                $response['success'] = true;
                $response['message'] = "Login successful";
            } else {
                $_SESSION['error'] = "Incorrect Username or Password";
            }
        } else {
            $_SESSION['error'] = "Incorrect Username or Password";
        }
    }
} else {
    $_SESSION['error'] = "Invalid request";
}

echo json_encode($response);
?>
