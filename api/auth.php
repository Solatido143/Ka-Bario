<?php

use Firebase\Auth\Token\Exception\ExpiredToken;

session_start();
include('dbcon.php');

if (isset($_SESSION['verified_user_id'])) {
    $uid = $_SESSION['verified_user_id'];
    $idTokenString = $_SESSION['idTokenString'];
    $user = $auth->getUser($uid);

    try {
        $verifiedIdToken = $auth->verifyIdToken($idTokenString);
    } catch (ExpiredToken $e) {
        echo 'The token is invalid: ' . $e->getMessage();
        $_SESSION['expired_status'] = "Token expired logging out. Login again";
        header('location: api/logout.php');
        exit();
    }

    $key = $_SESSION['database_user_id'];
    $reference = $database->getReference($ref_user_tbl)->getChild($key)->getValue();
    if (isset($reference['declinedAccount']) && $reference['declinedAccount'] === true) {
        $_SESSION['failed_status'] = "Your account has been declined";
        header("location: index.php");
        exit();
    }

    if (isset($reference['emailVerified']) && $reference['emailVerified'] === false && isset($reference['validID']) && $reference['validID'] !== '' && isset($reference['gender']) && $reference['gender'] !== '') {
        $notifRef = $database->getReference($ref_user_tbl)->getChild($key)->getChild('notif');
        $notifQuery = $notifRef->orderByChild('title')->equalTo('Verify')->getSnapshot();
        if ($notifQuery->hasChildren()) {
            // echo working...
        } else {
            $notif = [
                "title" => "Verify",
                "message" => "Wait for admin to verify your account",
                "time" => date("Y-m-d H:i:s"),
                "is_read" => false,
            ];
            $notifRef = $database->getReference($ref_user_tbl)->getChild($key)->getChild('notif')->push($notif);

        }
    }
} else {
    $_SESSION['failed_status'] = "Please login first!";
    header('location: index.php');
    exit();
}
