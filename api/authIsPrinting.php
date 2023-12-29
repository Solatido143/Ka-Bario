<?php

include('dbcon.php');

if (isset($_SESSION['verified_user_id'])) {
    $uid = $_SESSION['verified_user_id'];
    $idTokenString = $_SESSION['idTokenString'];
    $user = $auth->getUser($uid);

    $ref_request_tbl = 'request';

    $reference_request = $database->getReference($ref_request_tbl)->orderByChild('email');
    $query_requests = $reference_request->equalTo($user->email);
    $requests_snapshot = $query_requests->getValue();

    if (!empty($requests_snapshot)) {
        $request_userData = reset($requests_snapshot);
        if (isset($request_userData['isPrinting']) && $request_userData['isPrinting'] == true) {
            $_SESSION['document_status'] = "Admin is already preparing your document";
        } elseif (isset($request_userData['isPrinted']) && $request_userData['isPrinted'] == true) {
            $_SESSION['status'] = "Document has been printed, <b>Claim now!</b>";
        } else {
            $_SESSION['document_status'] = "Please wait to prepare your document";
        }
    }
}
?>