<?php 
session_start();
include ('dbcon.php');
include ('sanitizedata.php');
date_default_timezone_set('Asia/Manila');

if (isset($_POST['register-btn'])) {
    $fname = sanitize_data($_POST['firstname']);
    $lname = sanitize_data($_POST['lastname']);
    $phonenumber = sanitize_data($_POST['phonenumber']);
    $emailaddress = sanitize_data($_POST['emailaddress']);
    $housenum = sanitize_data($_POST['housenum']);
    $street = sanitize_data($_POST['street']);
    $barangay = sanitize_data($_POST['barangay']);
    $residencydate = sanitize_data($_POST['residencydate']);
    $permanentaddress = sanitize_data($_POST['permanentaddress']);
    $identification = sanitize_data($_POST['identification']);
    $password = sanitize_data($_POST['password']);
    $confirmpassword = sanitize_data($_POST['confirmPassword']);

    // Define validation criteria
    $valid = true;
    $error_messages = array();

    if (empty($fname) && empty($lname)) {
        $valid = false;
        $error_messages[] = "Full name is required.";
    }
    if (empty($phonenumber)) {
        $valid = false;
        $error_messages[] = "Phone number is required.";
    }
    if (empty($emailaddress)) {
        $valid = false;
        $error_messages[] = "Email address is required.";
    }
    if (empty($housenum)) {
        $valid = false;
        $error_messages[] = "House number is required.";
    }
    if (empty($street)) {
        $valid = false;
        $error_messages[] = "Street name is required.";
    }
    if (empty($barangay)) {
        $valid = false;
        $error_messages[] = "Barangay is required.";
    }
    if (empty($residencydate)) {
        $valid = false;
        $error_messages[] = "Residency date is required.";
    }
    if (empty($permanentaddress)) {
        $valid = false;
        $error_messages[] = "Permanent address is required.";
    }
    if (empty($password)) {
        $valid = false;
        $error_messages[] = "Password is required.";
    }
    if (empty($confirmpassword) !== empty($password) ) {
        $valid = false;
        $error_messages[] = "Password is not the same.";
    }

    // Add more validation rules for other fields here

    if ($valid) {
        // All data is valid, proceed with further processing
        // Insert data into the database or perform other actions

        $postData = [
            "firstName" => $fname,
            "lastName" => $lname,
            "phoneNumber" => $phonenumber,
            "email" => $emailaddress,
            'emailVerified' => false,
            "occupation" => '',
            "age" => '',
            "birthdate" => '',
            "civilstatus" => '',
            "gender" => '',
            "validID" => '',
            'residentialAddress' => [
                "houseNum" => $housenum,
                "street" => $street,
                "barangay" => $barangay
            ],
            "residencyDate" => $residencydate,
            "permanentAddress" => $permanentaddress,
        ];
        
        $userProperties = [
            'email' => $emailaddress,
            'emailVerified' => false,
            'phoneNumber' => '+63'.$phonenumber,
            'password' => $password,
            'displayName' => $fname . ' ' . $lname,
        ];

        $notif = [
            "title" => "New User",
            "message" => "Welcome, ".$fname,
            "time" => date("Y-m-d H:i:s"),
            "is_read" => false,
        ];

        // Initialize variables
        $emailExists = false;
        $phoneNumberExists = false;

        $ref_user_tbl = "users";
        $reference = $database->getReference($ref_user_tbl);
        // Query the database to check if the email or phone number already exists
        $dataSnapshot = $reference->getSnapshot();

        foreach ($dataSnapshot->getValue() as $key => $value) {
            if ($value['email'] === $emailaddress) {
                $emailExists = true;
            }
            if ($value['phoneNumber'] === $phonenumber) {
                $phoneNumberExists = true;
                break; // No need to continue checking once a match is found
            }
        }
        // Check email and phone number existence and display appropriate messages
        if ($emailExists && $phoneNumberExists) {
            $_SESSION['failed_status'] = "Email and Phone number already exist!";
            header ('location: ../index.php');
            exit();
        } else if ($phoneNumberExists) {
            $_SESSION['failed_status'] = "Phone number already exists!";
            header ('location: ../index.php');
            exit();
        } else if ($emailExists) {
            $_SESSION['failed_status'] = "Email already exists!";
            header ('location: ../index.php');
            exit();
        } else {
            // Email and phone number are unique, proceed with data insertion
            $postRef_result = $reference->push($postData);
            $new_key = $postRef_result->getKey();
            $createdUser = $auth->createUser($userProperties);
            
            if ($createdUser) {
                $uid = $createdUser->uid;
                $auth->setCustomUserClaims($uid, ['resident' => true]);
                $_SESSION['status'] = "Successfully signed up! Please Log in.";
                header ('location: ../index.php');
                exit();
            } else {
                $_SESSION['failed_status'] = "Something went wrong, please try again.";
                header ('location: ../index.php');
                exit();
            }
            
            $notifRef = $database->getReference($ref_user_tbl)->getChild($new_key)->getChild('notif')->push($notif);
            // Perform any other actions you need for successful data insertion
        }
    } else {
        $error_message_string = '';
        foreach ($error_messages as $error) {
            $error_message_string .= $error . "<br>";
        }

        // Set the session variable with the error messages
        $_SESSION['failed_status'] = $error_message_string;
        header ('location: ../index.php');
        exit();
    }

} else {
    $_SESSION['failed_status'] = "Not Allowed";
    header ('location: ../index.php');
    exit();
}
?>