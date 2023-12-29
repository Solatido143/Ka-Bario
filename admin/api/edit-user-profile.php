<?php
session_start();
include('../../api/dbcon.php');
include('../../api/sanitizedata.php');

if (isset($_POST['btn-submit-role'])) {
    $uid = $_POST['claim_user_id'];
    $key = $_POST['claim_user_key'];
    $role = $_POST['role_as'];

    try {
        $user = $auth->getUser($uid);
    } catch (\Kreait\Firebase\Exception\Auth\UserNotFound $e) {
        echo $e->getMessage();
        exit();
    }

    $msg = '';

    if ($role == 'admin') {
        $auth->setCustomUserClaims($uid, ['admin' => true]);
        $msg = "User {$user->displayName} set role as Admin";
    } elseif ($role == 'super_admin') {
        $auth->setCustomUserClaims($uid, ['super_admin' => true]);
        $msg = "User {$user->displayName} set role as Super Admin";
    } elseif ($role == 'resident') {
        $auth->setCustomUserClaims($uid, ['resident' => true]);
        $msg = "User {$user->displayName} set role as Resident";
    } elseif ($role == 'norole') {
        $auth->setCustomUserClaims($uid, null);
        $msg = "User {$user->displayName} role remove";
    }

    $_SESSION['status'] = $msg ? $msg : 'Something went wrong.';
    header("location: {$_SERVER["HTTP_REFERER"]}");
    exit();
}


if (isset($_POST['update-user-profile'])) {
    $key = $_POST['key'];
    $uid = $_POST['uid'];
    $fname = sanitize_data($_POST['firstname']);
    $lname = sanitize_data($_POST['lastname']);
    $phonenumber = sanitize_data($_POST['phonenumber0']);
    $emailaddress = sanitize_data($_POST['email']);
    $housenum = sanitize_data($_POST['housenum']);
    $street = sanitize_data($_POST['street']);
    $barangay = sanitize_data($_POST['barangay']);
    $permanentaddress = sanitize_data($_POST['permanentaddress']);

    $valid = true;
    $error_messages = [];

    if (empty($fname) || empty($lname)) {
        $valid = false;
        $error_messages[] = "Full name is required.";
    }
    if (empty($phonenumber)) {
        $valid = false;
        $error_messages[] = "Phone Number cannot be empty value.";
    }
    if (empty($housenum)) {
        $valid = false;
        $error_messages[] = "House Number cannot be empty value.";
    }
    if (empty($street)) {
        $valid = false;
        $error_messages[] = "Street cannot be empty value.";
    }
    if (empty($barangay)) {
        $valid = false;
        $error_messages[] = "Barangay cannot be empty value.";
    }
    if (empty($permanentaddress)) {
        $valid = false;
        $error_messages[] = "Permanent Address cannot be empty value.";
    }

    if ($valid) {
        $updateData = [
            "firstName" => $fname,
            "lastName" => $lname,
            "phoneNumber" => $phonenumber,
            "email" => $emailaddress,
            'residentialAddress' => [
                "houseNum" => $housenum,
                "street" => $street,
                "barangay" => $barangay
            ],
            "permanentAddress" => $permanentaddress,
        ];

        $userUpdateProperties = [
            'displayName' => $fname . ' ' . $lname,
            'phoneNumber' => '+63' . $phonenumber,
            'email' => $emailaddress
        ];

        $updatedUser = $auth->updateUser($uid, $userUpdateProperties);

        $ref_table = 'users/' . $key;
        $updatequery_result = $database->getReference($ref_table)->update($updateData);

        if ($updatequery_result) {
            $_SESSION['status'] = 'Update Success';
        } else {
            $_SESSION['status'] = 'Update Failed';
        }
    } else {
        $error_message_string = implode("<br>", $error_messages);
        $_SESSION['failed_status'] = $error_message_string;
    }

    header("location: ../useredit.php?uid=$uid&key=$key");
    exit();
}
?>