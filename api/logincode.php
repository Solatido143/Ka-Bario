<?php
session_start();

include('dbcon.php');
include('sanitizedata.php');

if (isset($_POST['login-btn'])) {
    $email = sanitize_data($_POST['email']);
    $password = sanitize_data($_POST['password']);
    $errorMessage = '';

    try {
        // Authenticate the user
        $signInResult = $auth->signInWithEmailAndPassword($email, $password);
        $idTokenString = $signInResult->idToken();

        // Verify the token
        $verifiedIdToken = $auth->verifyIdToken($idTokenString);
        $uid = $verifiedIdToken->claims()->get('sub');
        $user = $auth->getUser($uid);

        // Get user claims
        $claims = $user->customClaims;

        // Get the user's data from the Realtime Database using the email
        $ref_table = 'users'; // Set your database reference path
        $userRef = $database->getReference($ref_table)->orderByChild('email')->equalTo($email)->getValue();

        if (!empty($claims)) {

            if (!empty($userRef)) {
                $userKey = key($userRef);
                $userData = reset($userRef);
                
                if (isset($userData['emailVerified']) && ($userData['emailVerified'] === true || $user->emailVerified === true)) {
                    $_SESSION['verified_status'] = "Your account has been verified";
                } else {
                    $_SESSION['warning_status'] = "Your account is not yet verified";
                }
                // Set appropriate session variables based on user roles
                $_SESSION['idTokenString'] = $idTokenString;
                $_SESSION['verified_user_id'] = $uid;
                $_SESSION['database_user_id'] = $userKey;
                
                $_SESSION['status'] = "Logged in success, WELCOME";

                if (isset($claims['resident']) && $claims['resident'] === true) {
                    $_SESSION['verified_resident'] = true;
                    header("location: ../barangayhome.php");
                } elseif (isset($claims['admin']) && $claims['admin'] === true) {
                    $_SESSION['verified_admin'] = true;
                    header("location: ../admin/dashboard.php");
                } elseif (isset($claims['super_admin']) && $claims['super_admin'] === true) {
                    $_SESSION['verified_super_admin'] = true;
                    header("location: ../admin/dashboard.php");
                }

                
                exit();
            } else {
                $errorMessage = 'No information discovered in the email.';
            }
        } else {
            $errorMessage = 'Did you register this account?';
        }

    } catch (\Kreait\Firebase\Exception\Auth\UserNotFound $e) {
        $errorMessage = 'Email not registered';
    } catch (\Kreait\Firebase\Exception\Auth\FailedToVerifyToken $e) {
        $errorMessage = 'An error occurred, please try again later.';
    } catch (Exception $e) {
        $errorMessage = 'Invalid email or password';
    }

    // Handle errors
    error_log($errorMessage);
    $_SESSION['failed_status'] = $errorMessage;
    header("location: {$_SERVER['HTTP_REFERER']}");
    exit();
} else {
    $_SESSION['failed_status'] = "Not Allowed";
    header("location: {$_SERVER['HTTP_REFERER']}");
    exit();
}
?>
