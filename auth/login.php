<?php
session_start();

if (isset($_SESSION['user'])) {
    header("Location: dashboard.php");
    exit();
}

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    include("../connect.php");
    $query = "SELECT * FROM USER WHERE U_Name = '$username' AND Password = '$password'";
    $result = mysqli_query($conn, $query);
    $user = mysqli_fetch_assoc($result);
    if (!$user) {
        header("Location: login.html?error=1");
        exit();
    } else {
        $_SESSION['user'] = $username;
        header("Location: /dashboard/");
        exit();
    }
}
?>