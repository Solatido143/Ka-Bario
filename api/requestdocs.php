<?php
date_default_timezone_set('Asia/Manila');
include ('auth.php');
include ('dbcon.php');
include ('sanitizedata.php');

if (isset($_POST['sendRequest'])) { 
    $uid = $_SESSION['verified_user_id'];
    $key = $_SESSION['database_user_id'];

    $user = $auth->getUser($uid);

    $requestType = sanitize_data($_POST['requestType']);
    $purpose = sanitize_data($_POST['purpose']);
    $otherpurpose = sanitize_data($_POST['otherpurposetextarea']);
    $submissionDateTime = date("F j, Y h:i A");

    $name = $user->displayName;
    $email = $user->email;

    $ref_user_table = "users";
    $userData = $database->getReference($ref_user_table)->getChild($key)->getValue();

    $ref_req_table = "request";
    // Check if the user has already sent a request
    $existingRequest = $database->getReference($ref_req_table)->orderByChild("email")->equalTo($email)->getValue();

    if ($existingRequest) {
        // User has already sent a request
        $_SESSION['failed_status'] = "You have already sent a request.";
        header("location: {$_SERVER["HTTP_REFERER"]}");
        exit();
    } else {
        // User hasn't sent a request, proceed to create a new request
        
        $docRequestData = [
            "email" => $email,
            "submitRequestDateTime" => $submissionDateTime,
            "status" => false,

            "firstName" => $userData['firstName'],
            "lastName" => $userData['lastName'],
            "occupation" => $userData['occupation'],
            "phoneNumber" => $userData['phoneNumber'],
            "displayName" => $name,
            "documentType" => $requestType,
            "purpose" => $purpose,
            "otherPurpose" => $otherpurpose,
            "age" => $userData['age'],
            "gender" => $userData['gender'],
            "civilstatus" => $userData['civilstatus'],
            "address" => $userData['residentialAddress']['houseNum'] . ' ' . $userData['residentialAddress']['street'] . ' ' . $userData['residentialAddress']['barangay'],
            "barangay" => $userData['residentialAddress']['barangay'],
        ];
        
        if ($docRequestData) {
            // Request successfully created
            $_SESSION['status'] = "Request sent successfully!";
            $_SESSION['document_status'] = "Please wait, preparing your document";
            header("location: ../barangayhome.php");
            exit();
        } else {
            // Error handling if the request creation fails
            $_SESSION['failed_status'] = "Failed to send request. Please try again.";
            header("location: ../barangayhome.php");
            exit();
        }
    }
}



?>