<?php

use Firebase\Auth\Token\Exception\ExpiredToken;

session_start();
include('../api/dbcon.php');

if (isset($_SESSION['verified_user_id'])) {

    if (isset($_SESSION['verified_admin']) || isset($_SESSION['verified_super_admin'])) {
        
        $uid = $_SESSION['verified_user_id'];
        $idTokenString = $_SESSION['idTokenString'];

        try {
            $verifiedIdToken = $auth->verifyIdToken($idTokenString);
            $user = $auth->getUser($uid);

            $claims = $user->customClaims;
            
            if (isset($claims['admin']) && $claims['admin'] === true) {
                // User is an admins
            } elseif (isset($claims['super_admin']) && $claims['super_admin'] === true) {
                // User is an super admin
            } else {
                header('location: ../api/logout.php');
                exit(0);
            }
            
        } catch (\Kreait\Firebase\Exception\Auth\UserNotFound $e) {
            $_SESSION['failed_status'] = "User not found";
            header('location: ../api/logout.php');
            exit(0);
        } catch (ExpiredToken $e) {
            echo 'The token is invalid: ' . $e->getMessage();
            $_SESSION['expired_status'] = "Token expired. Login again";
            header('location: ../api/logout.php');
            exit();
        }
        

    } else {
        $_SESSION['failed_status'] = "Access Denied! Admin Only.";
        header("location: ../index.php");
        exit();
    }
    
} else {
    $_SESSION['failed_status'] = "Please login first!";
    header('location: ../index.php');
    exit();
}

?>