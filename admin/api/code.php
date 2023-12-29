<?php
session_start();
include('../../api/dbcon.php');
include('../../api/sanitizedata.php');


if (isset($_POST['removeUnclaimedDocument'])) {
    $requestKey = $_POST['removeUnclaimedDocument'];

    // Get logged-in user data
    $logged_in_user_key = $_SESSION['database_user_id'];
    $logged_in_user_data = $database->getReference('users')->getChild($logged_in_user_key)->getValue();
    $timestamp = date('F j, Y - g:i A');

    // Get reference to the request
    $reference = $database->getReference('request')->getChild($requestKey);
    $documentData = $reference->getValue();

    // Check if the document exists
    if ($documentData) {
        // Log the removal event
        $logData = [
            'user_name' => $logged_in_user_data['firstName'] . " " . $logged_in_user_data['lastName'],
            'timeStamps' => $timestamp,
            'event' => 'Remove Unclaimed Document',
            'description' => 'Remove user email ' . $documentData['email'] . ' Unclaimed Document',
            'userbarangay' => $logged_in_user_data['residentialAddress']['barangay'],
        ];
        $database->getReference($ref_logs_tbl)->push($logData);

        // Remove the request
        $removeRequest = $reference->remove();

        // Check if removal was successful
        if ($removeRequest) {
            // Success, you can redirect or set a success message here
            $_SESSION['status'] = 'Remove Success.';
            header("location: ../userRequestlist.php");
            exit();
        } else {
            // Handle the case where removal failed
            $_SESSION['failed_status'] = 'Failed to remove.';
            header("location: ../userRequestlist.php");
            exit();
        }
    }
}

if (isset($_POST['removeRequest'])) {
    $requestKey = $_POST['removeRequest'];

    // Get logged-in user data
    $logged_in_user_key = $_SESSION['database_user_id'];
    $logged_in_user_data = $database->getReference('users')->getChild($logged_in_user_key)->getValue();
    $timestamp = date('F j, Y - g:i A');

    // Get reference to the request
    $reference = $database->getReference('request')->getChild($requestKey);
    $documentData = $reference->getValue();

    // Check if the document exists
    if ($documentData) {
        // Log the removal event
        $logData = [
            'user_name' => $logged_in_user_data['firstName'] . " " . $logged_in_user_data['lastName'],
            'timeStamps' => $timestamp,
            'event' => 'Remove Request Button',
            'description' => 'Remove user email ' . $documentData['email'] . ' Request',
            'userbarangay' => $logged_in_user_data['residentialAddress']['barangay'],
        ];
        $database->getReference($ref_logs_tbl)->push($logData);

        // Remove the request
        $removeRequest = $reference->remove();

        // Check if removal was successful
        if ($removeRequest) {
            // Success, you can redirect or set a success message here
            $_SESSION['status'] = 'Remove Request Success.';
            header("location: ../userRequestlist.php");
            exit();
        } else {
            // Handle the case where removal failed
            $_SESSION['failed_status'] = 'Failed to remove request.';
            header("location: ../userRequestlist.php");
            exit();
        }
    }
}


if (isset($_POST['users_claimed_btn'])) {
    $documentKey = $_POST['users_claimed_btn'];

    // Check if the document exists
    $documentReference = $database->getReference($ref_req_tbl)->getChild($documentKey);
    $documentData = $documentReference->getValue();

    $email = $documentData['email'];

    $userReference = $database->getReference($ref_user_tbl);
    $userQuery = $userReference->orderByChild('email')->equalTo($email)->getValue();

    $notif = [
        "title" => "DocumentClaimed",
        "message" => "Thank you for using our webApp!",
        "time" => date("Y-m-d H:i:s"),
        "is_read" => false,
    ];

    // Assuming $userQuery has only one element (user)
    foreach ($userQuery as $userKey => $userData) {
        // Assuming 'notif' exists in the user data
        $notifReference = $userReference->getChild($userKey)->getChild('notif');

        // Add the notification to the 'notif' child
        $newNotifKey = $notifReference->push($notif)->getKey();
    }

    $logged_in_user_key = $_SESSION['database_user_id'];
    $logged_in_user_data = $database->getReference('users')->getChild($logged_in_user_key)->getValue();
    $timestamp = date('F j, Y - g:i A');

    // Set properties to push to logs
    $pushLogs = [
        'user_name' => $logged_in_user_data['firstName'] . " " . $logged_in_user_data['lastName'],
        'timeStamps' => $timestamp,
        'event' => 'Claim Button',
        'description' => 'User ' . $documentData['email'] . ' claimed the document',
        'userbarangay' => $logged_in_user_data['residentialAddress']['barangay'],
    ];

    if ($documentData && isset($documentData['isClaimed']) && $documentData['isClaimed'] === false) {
        // Claim the document

        $updateData = [
            'isClaimed' => true,
            'isComplete' => true,
            'usedEmail' => $email,
        ];

        // Remove the 'email' field
        $removeField = 'email';

        try {
            // Update the document
            $database->getReference($ref_logs_tbl)->push($pushLogs);
            $updateComplete = $documentReference->update($updateData);

            // Remove the 'email' field
            $fieldRef = $documentReference->getChild($removeField);
            $fieldisRemove = $fieldRef->remove();

            $_SESSION['status'] = 'Document claimed successfully!';
            header("location: ../usersClaimDocument.php");
            exit();
        } catch (Exception $e) {
            $_SESSION['failed_status'] = 'An error occurred: ' . $e->getMessage();
            header("location: ../usersClaimDocument.php");
            exit();
        }
    }
}


if (isset($_POST['printcomplete'])) {

    $user_key = $_POST['userKey'];
    $user_req_key = $_POST['requestKey'];
    $ref_req_tbl = 'request'; // Make sure to set your reference table

    $reference = $database->getReference($ref_req_tbl);

    $fieldToRemove = 'isPrinting';

    // Get the data of the child
    $childData = $reference->getChild($user_req_key)->getValue();

    $requestData = $database->getReference('request')->getChild($user_req_key)->getValue();

    $logged_in_user_key = $_SESSION['database_user_id'];
    $logged_in_user_data = $database->getReference('users')->getChild($logged_in_user_key)->getValue();
    $timestamp = date('F j, Y - g:i A');

    // Set properties to push to logs (logs)
    $pushLogs = [
        'user_name' => $logged_in_user_data['firstName'] . " " . $logged_in_user_data['lastName'],
        'timeStamps' => $timestamp,
        'event' => 'Complete Button',
        'description' => 'Complete the printing proccess of user email ' . $requestData['email'],
        'userbarangay' => $logged_in_user_data['residentialAddress']['barangay'],
    ];

    $timedate = date("Y-m-d H:i:s");

    // Check if it's Monday to Friday and time is between 8 am and 5 pm
    if (date('N') >= 1 && date('N') <= 5 && date('H') >= 8 && date('H') <= 17) {
        // Create the notification data
        $notif = [
            "title" => "Print Complete",
            "message" => "Your document is ready. You can claim it until 5 pm today.",
            "time" => $timedate,
            "is_read" => false,
        ];

        // Add the notification to the database
        $notif_reference = $database->getReference($ref_user_tbl)->getChild($user_key)->getChild('notif');
        $printcomplete_notif = $notif_reference->push($notif);
    } else {
        // Create the notification data
        $notif = [
            "title" => "Document Available",
            "message" => "Your document is available for claiming.<br>Please claim it during office hours (Monday to Friday, 8 am to 5 pm).",
            "time" => $timedate,
            "is_read" => false,
        ];

        // Add the notification to the database
        $notif_reference = $database->getReference($ref_user_tbl)->getChild($user_key)->getChild('notif');
        $document_available_notif = $notif_reference->push($notif);
    }


    // Check if the field exists in the data
    if (isset($childData[$fieldToRemove])) {
        // Reference to the specific child you want to remove
        $fieldRef = $reference->getChild($user_req_key)->getChild($fieldToRemove);

        // Remove the child
        $fieldisRemove = $fieldRef->remove();

        if ($fieldisRemove) {
            $updates = [
                'isPrinted' => true,
                'status' => true,
                'isClaimed' => false,
            ];

            try {
                $database->getReference($ref_req_tbl)->getChild($user_req_key)->update($updates);
                $database->getReference($ref_logs_tbl)->push($pushLogs);
                $_SESSION['status'] = 'Success!';
                header("location: ../userRequestlist.php");
                exit();
            } catch (Exception $e) {
                $_SESSION['failed_status'] = 'Error occurred!';
                header("location: ../userRequestlist.php");
                exit();
            }
        }
    } else {
        // Handle the case where the 'isPrinting' field doesn't exist
        $_SESSION['failed_status'] = 'Print it first!';
        header("location: ../userRequestlist.php");
        exit();
    }
}


if (isset($_POST['printdocument'])) {
    $user_key = $_POST['userKey'];
    $user_req_key = $_POST['requestKey'];
    $document = sanitize_data($_POST['requestType']);

    $displayName = sanitize_data($_POST['displayName']);
    $occupation = sanitize_data($_POST['occupation']);
    $age = sanitize_data($_POST['age']);
    $gender = sanitize_data($_POST['gender']);
    $civilstatus = sanitize_data($_POST['civilstatus']);
    $address = sanitize_data($_POST['address']);
    $purpose = sanitize_data($_POST['purpose']);
    $otherpurpose = sanitize_data($_POST['otherpurposetextarea']);

    $validYearDate = sanitize_data($_POST['validYearDate']);
    $day = sanitize_data($_POST['day']);
    $month = sanitize_data($_POST['month']);
    $year = sanitize_data($_POST['year']);

    $ref_req_tbl = 'request';

    $postData = [
        'validYearDate' => $validYearDate,
        'occupation' => $occupation,
        'day' => $day,
        'month' => $month,
        'year' => $year,
        'displayName' => $displayName,
        'age' => $age,
        'gender' => $gender,
        'civilstatus' => $civilstatus,
        'address' => $address,
        'purpose' => $purpose,
        'otherPurpose' => $otherpurpose,
        'isPrinting' => true,
    ];

    $requestData = $database->getReference('request')->getChild($user_req_key)->getValue();

    $logged_in_user_key = $_SESSION['database_user_id'];
    $logged_in_user_data = $database->getReference('users')->getChild($logged_in_user_key)->getValue();
    $timestamp = date('F j, Y - g:i A');

    // Set properties to push to logs (logs)
    $pushLogs = [
        'user_name' => $logged_in_user_data['firstName'] . " " . $logged_in_user_data['lastName'],
        'timeStamps' => $timestamp,
        'event' => 'Print Button',
        'description' => 'Tried to print the document of user email' . $requestData['email'],
        'userbarangay' => $logged_in_user_data['residentialAddress']['barangay'],
    ];

    // Remove empty values from the updateData array
    $updateData = array_filter($postData, function ($value) {
        return $value !== '' && $value !== null;
    });

    if (!empty($updateData)) {
        try {
            $database->getReference($ref_logs_tbl)->push($pushLogs);
            // Reference to the specific node using $user_req_key // Update the data
            $database->getReference($ref_req_tbl)->getChild($user_req_key)->update($updateData);



            $notifRef = $database->getReference($ref_user_tbl)->getChild($user_key)->getChild('notif');
            $notifQuery = $notifRef->orderByChild('title')->equalTo('PrintingByAdmin')->getSnapshot();
            if ($notifQuery->hasChildren()) {
                // echo working...
            } else {
                $notif = [
                    "title" => "Verify",
                    "message" => "Wait for admin to verify your account",
                    "time" => date("Y-m-d H:i:s"),
                    "is_read" => false,
                ];
                $database->getReference($ref_user_tbl)->getChild($user_key)->getChild('notif')->push($notif);
            }

            if ($document == 'Barangay Indigency') {
                header("location: ../barangay/taliptip/forms/barangayIndigency.php?key=$user_req_key");
            } elseif ($document == 'Barangay Clearance') {
                header("location: ../barangay/taliptip/forms/barangayClearance.php?key=$user_req_key");
            }
            echo '<script type="text/javascript">window.location.href = "' . $_SERVER["HTTP_REFERER"] . '";</script>';
            exit();
        } catch (Exception $e) {
            $_SESSION['failed_status'] = 'Error updating!';
            header("location: {$_SERVER["HTTP_REFERER"]}");
            exit();
        }
    }
}

if (isset($_POST['verifyUserbtn'])) {

    $uid = $_POST['uid'];
    $key = $_POST['key'];

    $logged_in_user_uid = $_SESSION['verified_user_id'];
    $logged_in_user_key = $_SESSION['database_user_id'];
    $logged_in_user_data = $database->getReference('users')->getChild($logged_in_user_key)->getValue();
    $timestamp = date('F j, Y - g:i A');

    try {
        $user = $auth->getUser($uid);
        $logged_in_user = $auth->getUser($logged_in_user_uid);
        $logged_in_user_name = $logged_in_user->displayName;
    } catch (\Kreait\Firebase\Exception\Auth\UserNotFound $e) {
        // Handle the case where the user is not found
        echo $e->getMessage();
        $_SESSION['failed_status'] = "User not found.";
        header("location: verifiy_user.php");
        exit();
    }

    // Set properties to push to logs (logs)
    $pushLogs = [
        'user_name' => $logged_in_user_name,
        'timeStamps' => $timestamp,
        'event' => 'Verify Button',
        'description' => 'Verified the account of user email' . $user->email,
        'userbarangay' => $logged_in_user_data['residentialAddress']['barangay'],
    ];

    $notif = [
        "title" => "VerifyByAdmin",
        "message" => "Your account has been verified",
        "time" => date("Y-m-d H:i:s"),
        "is_read" => false,
    ];



    // Set properties to update (emailVerified)
    $properties = [
        'emailVerified' => true,
    ];

    // Update the user in Firebase Authentication
    $updatedUser = $auth->updateUser($uid, $properties);

    if ($updatedUser) {
        // Update the user's emailVerified status in the Realtime Database
        $ref_user_tbl = 'users';
        $ref_logs_tbl = 'logs';
        $user_ref = $database->getReference($ref_user_tbl)->getChild($key);
        $user_data = $user_ref->getValue();

        if ($user_data) {
            // Update the emailVerified status in the user's data
            $user_data['emailVerified'] = true;

            // Update the user data in the Realtime Database
            $database->getReference($ref_user_tbl)->getChild($key)->update($user_data);
            $database->getReference($ref_user_tbl)->getChild($key)->getChild('notif')->push($notif);
            $database->getReference($ref_logs_tbl)->push($pushLogs);

            // Success message and redirection
            $_SESSION['status'] = "User " . $user->email . " successfully verified";
            header("Location: ../verify_user.php");
            exit();
        } else {
            // Handle the case where the user with the specified key is not found in the database
            echo "User not found in the database.";
            $_SESSION['failed_status'] = "User not found in the database.";
            header("location: ../verify_user.php");
            exit();
        }
    } else {
        // Handle the case where the user in Firebase Authentication cannot be updated
        $_SESSION['failed_status'] = "Failed to update user in Firebase Authentication.";
        header("location: ../verify_user.php");
        exit();
    }
}

if (isset($_POST['declineUserbtn'])) {
    $uid = $_POST['uid'];
    $key = $_POST['key'];

    $ref_users_tbl = 'users';
    $user_ref = $database->getReference($ref_users_tbl)->getChild($key);
    $user_data = $user_ref->getValue();

    // Get logged-in user data
    $logged_in_user_key = $_SESSION['database_user_id'];
    $logged_in_user_data = $database->getReference('users')->getChild($logged_in_user_key)->getValue();
    $timestamp = date('F j, Y - g:i A');

    if (!empty($user_data)) {
        try {
            // Retrieve user information from Firebase
            $user = $auth->getUser($uid);

            // Update user data in the Realtime Database
            $updates = [
                'declinedAccount' => true,
            ];

            $logData = [
                'user_name' => $logged_in_user_data['firstName'] . " " . $logged_in_user_data['lastName'],
                'timeStamps' => $timestamp,
                'event' => 'Decline an Account',
                'description' => 'Declined user email ' . $user_data['email'] . ' account',
                'userbarangay' => $logged_in_user_data['residentialAddress']['barangay'],
            ];
            $database->getReference($ref_logs_tbl)->push($logData);

            $user_ref->update($updates);

            $_SESSION['status'] = "User account declined.";
            header("Location: ../verify_user.php");
            exit();
        } catch (\Kreait\Firebase\Exception\Auth\UserNotFound $e) {
            // Handle the case where the user is not found
            echo $e->getMessage();
            $_SESSION['failed_status'] = "User not found.";
            header("location: ../verify_user.php");
            exit();
        } catch (Exception $e) {
            // Handle other exceptions
            echo $e->getMessage();
            $_SESSION['failed_status'] = "An error occurred. Please try again later.";
            header("location: ../verify_user.php");
            exit();
        }
    } else {
        $_SESSION['failed_status'] = "User not found.";
        header("location: ../verify_user.php");
        exit();
    }
}

if (isset($_POST['user_list_delete_btn'])) {
    $uid = $_POST['user_list_delete_btn'];

    // Retrieve user details from Firebase Authentication
    $user = $auth->getUser($uid);
    $user_email = $user->email;

    // Check if the user exists in the database
    $user_data = $database->getReference('users')->orderByChild('email')->equalTo($user_email)->getValue();

    $user_request_data = $database->getReference('request')->orderByChild('uid')->equalTo($user->uid)->getValue();

    if ($user_request_data) {
        foreach ($user_request_data as $user_key => $user_request_info) {
            $database->getReference('request')->getChild($user_key)->remove();
        }
    }
    if ($user_data) {
        // Remove user-specific data from the Realtime Database
        foreach ($user_data as $user_key => $user_info) {
            $database->getReference('users')->getChild($user_key)->remove();
        }

        try {
            // Attempt to delete the user from Firebase Authentication
            $auth->deleteUser($uid);
            $_SESSION['status'] = "Deletion success";
            header("location: {$_SERVER["HTTP_REFERER"]}");
            exit();
        } catch (\Kreait\Firebase\Exception\Auth\UserNotFound $e) {
            $_SESSION['failed_status'] = "No user found in Firebase Authentication";
            header("location: {$_SERVER["HTTP_REFERER"]}");
            exit();
        } catch (\Kreait\Firebase\Exception\AuthException $e) {
            $_SESSION['failed_status'] = "Error deleting user from Firebase Authentication";
            header("location: {$_SERVER["HTTP_REFERER"]}");
            exit();
        } catch (Exception $e) {
            $_SESSION['failed_status'] = "Unexpected error during deletion";
            header("location: {$_SERVER["HTTP_REFERER"]}");
            exit();
        }
    } else {
        $_SESSION['failed_status'] = "User not found in the Database";
        header("location: {$_SERVER["HTTP_REFERER"]}");
        exit();
    }
}