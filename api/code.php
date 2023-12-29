<?php
session_start();
include('dbcon.php');
// your_update_script.php

// Check if it's a POST request and the 'markAllRead' parameter is set
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['markAllRead'])) {
    // Your logic to update the database goes here

    // Example: Set all notifications as 'read' in the database
    // Replace this with your actual database update logic
    $loggedin_user_key = $_SESSION['database_user_id'];
    $reference = $database->getReference($ref_user_tbl)->getChild($loggedin_user_key)->getChild('notif');

    // Get all notifications
    $notifications = $reference->getValue();

    // Iterate through each notification and mark it as read
    foreach ($notifications as $notifKey => $notification) {

        if (isset($notification['is_read']) && $notification['is_read'] === false) {
            $notification['is_read'] = true;
            $reference->getChild($notifKey)->set($notification);
        }
    }
} else {
    // Invalid request
    http_response_code(400);
    echo json_encode(['error' => 'Invalid request']);
}
