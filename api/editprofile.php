<?php
session_start();
include('dbcon.php');
include('sanitizedata.php');

if (isset($_POST['upload-img'])) {
    $key = isset($_POST['key']) ? $_POST['key'] : '';
    $uid = isset($_POST['uid']) ? $_POST['uid'] : '';
    $upload_type = isset($_POST['upload_type']) ? $_POST['upload_type'] : '';

    // Validate and sanitize inputs
    $upload_type = filter_input(INPUT_POST, 'upload_type', FILTER_SANITIZE_STRING);

    $user = $auth->getUser($uid);

    $random_no = rand(1111, 9999);

    if ($upload_type == 'validID') {
        $validID = isset($_FILES['uploadimage']['name']) ? $_FILES['uploadimage']['name'] : '';
        $validID = str_replace(' ', '_', $validID);

        if (!empty($validID)) {
            // Additional file upload checks
            if ($_FILES['uploadimage']['error'] !== UPLOAD_ERR_OK) {
                $_SESSION['failed_status'] = "File upload failed. Please try again.";
                header("location: {$_SERVER["HTTP_REFERER"]}");
                exit();
            }

            $allowedFileTypes = ['jpg', 'jpeg', 'png', 'gif'];
            $fileExtension = strtolower(pathinfo($validID, PATHINFO_EXTENSION));

            if (!in_array($fileExtension, $allowedFileTypes)) {
                $_SESSION['failed_status'] = "Invalid file type. Please upload a valid image.";
                header("location: {$_SERVER["HTTP_REFERER"]}");
                exit();
            }

            $ref_tbl_validID = 'users'; // Update with your actual reference table
            $reference_validID = $database->getReference($ref_tbl_validID);
            $existingValidID = $reference_validID->getChild($key)->getValue()['validID'];

            if (!empty($existingValidID)) {
                // Delete the existing validID file
                $existingValidIDPath = '../admin/api/uploads/validIDs/' . $existingValidID;
                unlink($existingValidIDPath);
            }

            $validID_photoName = $random_no . '_' . $validID;
            $filename_validID_dir = '../admin/api/uploads/validIDs/' . $validID_photoName;

            if (move_uploaded_file($_FILES['uploadimage']['tmp_name'], $filename_validID_dir)) {
                // Update the 'validID' field in the database
                $properties_validID = [
                    'validID' => $validID_photoName,
                ];

                // Update 'validID' directly using the $key
                $reference_validID->getChild($key)->update($properties_validID);

                $_SESSION['status'] = "Valid ID Upload Complete";
                header("location: {$_SERVER["HTTP_REFERER"]}");
                exit();
            } else {
                $_SESSION['failed_status'] = "File upload failed. Please try again.";
                header("location: {$_SERVER["HTTP_REFERER"]}");
                exit();
            }
        } else {
            $_SESSION['failed_status'] = "No valid ID selected";
            header("location: {$_SERVER["HTTP_REFERER"]}");
            exit();
        }
    }
    
    if ($upload_type == 'displayPicture') {

        $profilephoto = isset($_FILES['uploadimage']['name']) ? $_FILES['uploadimage']['name'] : '';
        $profilephoto = str_replace(' ', '_', $profilephoto);
    
        $new_image = $random_no.$profilephoto;
        $old_image = $user->photoUrl;
    
        if (!empty($profilephoto)) {
            $filename = 'uploads/displayPics/'.$new_image;
    
            if (file_exists($filename)) {
                $filename = 'uploads/displayPics/' . $random_no . '_' . $profilephoto;
            }
        } else {
            $_SESSION['failed_status'] = "No photo selected";
            header("location: {$_SERVER["HTTP_REFERER"]}");
            exit();
        }
    
        $properties = [
            'photoUrl' => $filename,
        ];
    
        $updatedUser = $auth->updateUser($uid, $properties);
    
        if ($updatedUser) {
    
            if ($profilephoto !== NULL) {
                move_uploaded_file($_FILES['uploadimage']['tmp_name'], "uploads/displayPics/".$new_image);
                if ($old_image !== NULL) {
                    unlink($old_image);
                }
            }
            $_SESSION['status'] = "Display Picture Update Complete";
            header("location: {$_SERVER["HTTP_REFERER"]}");
            exit();
        } else {
            error_log('Firebase update error: ' . $auth->getLastError());
            $_SESSION['status'] = "Upload Failed";
            header("location: {$_SERVER["HTTP_REFERER"]}");
            exit();
        }
    }
}







if (isset($_POST['update-profile'])) {
    $key = $_POST['key'];
    $uid = $_POST['uid'];

    $fname = sanitize_data($_POST['firstname']);
    $lname = sanitize_data($_POST['lastname']);

    $gender = sanitize_data($_POST['genderRadioOption']);
    $phonenumber = sanitize_data($_POST['phonenumber']);
    $emailaddress = sanitize_data($_POST['emailaddress']);
    $occupation = sanitize_data($_POST['occupation']);
    $civilstatus = sanitize_data($_POST['civilstatusRadioOption']);
    $housenum = sanitize_data($_POST['housenum']);
    $street = sanitize_data($_POST['street']);
    $barangay = sanitize_data($_POST['barangay']);
    $permanentaddress = sanitize_data($_POST['permanentaddress']);

    $birthdate = sanitize_data($_POST['birthdate']);
    $birthdateDateTime = DateTime::createFromFormat('m/d/Y', $birthdate);

    $newpassword = sanitize_data($_POST['password']);
    $confirmnewpassword = sanitize_data($_POST['confirmpassword']);

    if ($birthdateDateTime) {
        // Get the current date
        $currentDate = new DateTime();
        // Calculate the difference between birthdate and current date
        $ageInterval = $currentDate->diff($birthdateDateTime);
        // Get the age from the difference
        $age = $ageInterval->y;
    
    } else {
        // Handle invalid date format
        $_SESSION['failed_status'] = 'Invalid date format';
        header("location: {$_SERVER["HTTP_REFERER"]}");
        exit();
    }

    // Check if the new password matches the confirmation
    if ($newpassword !== $confirmnewpassword) {
        $_SESSION['failed_status'] = 'Password and Confirm password do not match';
        header("location: {$_SERVER["HTTP_REFERER"]}");
        exit();
    } elseif (!empty($newpassword)) {
        $updatedUser = $auth->changeUserPassword($uid, $newpassword);
    }

    // Initialize the properties array
    $updateProperties = [
        'displayName' => $fname . ' ' . $lname,
        'phoneNumber' => '+63' . $phonenumber,
        'email' => $emailaddress,
    ];

    // Prepare the data to update
    $updateData = [
        "firstName" => $fname,
        "lastName" => $lname,
        "gender" => $gender,
        "birthdate" => $birthdate,
        "age" => $age,
        "phoneNumber" => $phonenumber,
        "occupation" => $occupation,
        "email" => $emailaddress,
        "civilstatus" => $civilstatus,
        "permanentAddress" => $permanentaddress,
        'residentialAddress' => [
            "houseNum" => $housenum,
            "street" => $street,
            "barangay" => $barangay,
        ],
    ];

    // Remove empty values from the updateData array
    $updateData = array_filter($updateData, function ($value) {
        return $value !== '' && $value !== null;
    });

    // Update both user and user data, but only if there are changes
    if (!empty($updateData) && !empty($updateProperties)) {
        try {
            $updateduserData = $database->getReference('users/' . $key)->update($updateData);
            $updatedUser = $auth->updateUser($uid, $updateProperties);

            if ($updateduserData && $updatedUser) {
                $_SESSION['status'] = 'Update success!';
            } else {
                $_SESSION['failed_status'] = 'Something went wrong, please try again.';
            }
            
        } catch (Exception $e) {
            $_SESSION['failed_status'] = 'Error updating!';
        }
    }

    header("location: {$_SERVER["HTTP_REFERER"]}");
    exit();
}

?>