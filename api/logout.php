<?php
session_start();

if (!isset($_SESSION['verified_user_id'])) {
    $_SESSION['failed_status'] = "Please login first!";
    header('location: ../index.php');
    exit();
}

if (isset($_SESSION['verified_user_id'])) {
    if (isset($_SESSION['verified_status'])) {
        unset($_SESSION['verified_status']);
    }
    if (isset($_SESSION['warning_status'])) {
        unset($_SESSION['warning_status']);
    }
    unset(
        $_SESSION['verified_user_id'],
        $_SESSION['idTokenString'],
        $_SESSION['database_user_id'],
        $_SESSION['verified_admin'],
        $_SESSION['verified_super_admin'],
        $_SESSION['verified_resident']
    );

    $_SESSION['status'] = "Logged out success!";

    if (isset($_SESSION['expired_status'])) {
        $_SESSION['failed_status'] = $_SESSION['expired_status'];
        unset($_SESSION['expired_status']);
    }
}

$redirectPath = (strpos($_SERVER['REQUEST_URI'], '/admin/') !== false) ? '../../index.php' : '../index.php';
header("location: $redirectPath");
exit();
?>