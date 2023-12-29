<?php

if (isset($_SESSION['verified_user_id']) && isset($_SESSION['database_user_id'])) {
    $uid = $_SESSION['verified_user_id'];
    $key = $_SESSION['database_user_id'];

    $user = $auth->getUser($uid);
    $ref_user_tbl = 'users';
    $reference = $database->getReference($ref_user_tbl)->getChild($key)->getValue();

    $isEmpty = false;
    foreach ($reference as $field => $value) {
        // Skip 'emailVerified' and 'validID'
        if ($field === 'emailVerified' || $field === 'validID') {
            continue;
        }

        // Check if the value is empty
        if (empty($value)) {
            $isEmpty = true;
            break;
        }
    }

    if ($isEmpty || empty($reference['validID'])) {
        // Handle the case where at least one field is empty
        $_SESSION['warning_status'] = "Update your profile or upload a valid ID";
        header("location: myprofile.php?uid=".$uid."&key=".$key);
        exit();
    } else {
        // Handle the case where all fields are not empty   
        // Check if 'emailVerified' key exists and its value is false
        if (isset($reference['emailVerified']) && ($reference['emailVerified'] === false || $user->emailVerified === false)) {
            // Handle the case where email is not verified
            $_SESSION['warning_status'] = "Wait for admin to verify your account";
            header('location: index.php');
            exit();
        }
    }
}

?>