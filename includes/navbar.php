<nav class="navbar navbar-expand-lg sticky-top bg-body-tertiary shadow bg-body-tertiary">
    <div class="container">
        <a class="navbar-brand" href="./index.php">
            <img src="./pictures/KABARIO transparent.png" width="64" height="36" id="logo" alt="logo">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="fa-solid fa-bars"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0 text-center" id="navList">
                <?php if (basename($_SERVER['PHP_SELF']) == 'index.php') : ?>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#top">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="#features">Features</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="#abouts">Abouts</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="#services">Services</a>
                    </li>

                <?php else : ?>
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="./index.php">Home</a>
                    </li>

                <?php endif; ?>

                <?php if (!isset($_SESSION['verified_user_id'])) : ?>
                    <li class="nav-item ms-lg-2">
                        <a class="btn btn-primary rounded-pill fw-medium w-100" role="button" href="#" data-bs-toggle="modal" data-bs-target="#modalLogin" style>Get Started</a>
                    </li>

                <?php else : ?>

                    <?php
                    include('api/dbcon.php');

                    function formatTimeAgo($timestamp)
                    {
                        $currentTime = time();
                        $timeDifference = $currentTime - strtotime($timestamp);

                        $seconds = $timeDifference;
                        $minutes = round($seconds / 60);           // value 60 is seconds
                        $hours   = round($seconds / 3600);         // value 3600 is 60 minutes * 60 sec
                        $days    = round($seconds / 86400);        // value 86400 is 24 hours * 60 minutes * 60 sec
                        $weeks   = round($seconds / 604800);       // value 604800 is 7 days * 24 hours * 60 minutes * 60 sec
                        $months  = round($seconds / 2629440);      // value 2629440 is ((365+365+365+365+366)/5/12) days * 24 hours * 60 minutes * 60 sec
                        $years   = round($seconds / 31553280);     // value 31553280 is ((365+365+365+365+366)/5) days * 24 hours * 60 minutes * 60 sec

                        if ($seconds <= 60) {
                            return "Just now";
                        } elseif ($minutes <= 60) {
                            return ($minutes == 1) ? "1 min ago" : "$minutes mins ago";
                        } elseif ($hours <= 24) {
                            return ($hours == 1) ? "1 hr ago" : "$hours hrs ago";
                        } elseif ($days <= 7) {
                            return ($days == 1) ? "yesterday" : "$days days ago";
                        } elseif ($weeks <= 4.3)  // 4.3 == 30/7
                        {
                            return ($weeks == 1) ? "a week ago" : "$weeks weeks ago";
                        } elseif ($months <= 12) {
                            return ($months == 1) ? "a month ago" : "$months months ago";
                        } else {
                            return ($years == 1) ? "more than a year ago" : "$years years ago";
                        }
                    }

                    $loggedin_user_uid = $_SESSION['verified_user_id'];
                    $loggedin_user_key = $_SESSION['database_user_id'];
                    $loggedin_user = $auth->getUser($loggedin_user_uid);

                    $loggedin_user_claims = $loggedin_user->customClaims;

                    $reference = $database->getReference($ref_user_tbl)->getChild($loggedin_user_key)->getChild('notif');
                    $notifData = $reference->getValue();
                    ?>

                    <li id="notifDropdown" class="nav-item dropdown">
                        <a class="nav-link" role="button" id="notificationLink" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa-solid fa-bell position-relative">
                                <?php
                                // Check if $notifData is not empty
                                if (!empty($notifData)) {
                                    $showNotificationDot = false;

                                    // Check each notification for is_read
                                    foreach ($notifData as $notifKey => $notification) {
                                        if (isset($notification['is_read']) && $notification['is_read'] === false) {
                                            $showNotificationDot = true;
                                            break; // No need to check further, we found one unread notification
                                        }
                                    }

                                    // Display the notification dot if any unread notifications were found
                                    if ($showNotificationDot) :
                                ?>
                                        <span id="notifDot" class="position-absolute top-0 start-100 translate-middle p-1 bg-danger border border-light rounded-circle">
                                            <span class="visually-hidden"></span>
                                        </span>
                                <?php
                                    endif;
                                }
                                ?>
                            </i>
                        </a>

                        <ul class="dropdown-menu dropdown-menu-lg-end text-start">
                            <!-- Header with "Mark All as Read" button and title -->
                            <li>
                                <div class="d-flex justify-content-between align-items-center px-3 py-2 bg-light gap-5">
                                    <span class="fw-bold">Notifications</span>
                                    <button class="btn btn-sm btn-outline-primary text-nowrap" onclick="markAllAsRead()">Mark All as Read</button>
                                </div>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <?php
                            if ($notifData) {
                                $reversedNotifData = array_reverse($notifData); // Reverse the order of notifications
                                foreach ($reversedNotifData as $notifKey => $notif) {
                            ?>
                                    <li>
                                        <a class="dropdown-item" href="#">
                                            <?= $notif['message'] ?>
                                            <small class="text-dark-emphasis text-primary" style="font-size: 0.75rem;"><?= formatTimeAgo($notif['time']) ?></small>
                                        </a>
                                    </li>
                                <?php
                                }
                            } else {
                                ?>
                                <!-- Display a message when there are no notifications -->
                                <li>
                                    <a class="dropdown-item" href="#">No notification at the moment</a>
                                </li>
                            <?php
                            } ?>
                        </ul>

                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <?= $user->displayName ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-lg-end text-center">
                            <?php if (isset($loggedin_user_claims['admin']) && $loggedin_user_claims['admin'] === true || isset($loggedin_user_claims['super_admin']) && $loggedin_user_claims['super_admin'] === true) : ?>
                                <li class="nav-item">
                                    <a class="nav-link" aria-current="page" href="admin/dashboard.php">Dashboard</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" aria-current="page" href="barangayhome.php">Request Form</a>
                                </li>
                            <?php else : ?>
                                <li class="nav-item">
                                    <a class="nav-link" aria-current="page" href="barangayhome.php">Request Form</a>
                                </li>
                            <?php endif; ?>
                            <li class="nav-item">
                                <a class="nav-link" aria-current="page" href="myprofile.php?uid=<?= $loggedin_user_uid ?>&key=<?= $loggedin_user_key ?>">Account Settings</a>
                            </li>
                            <li class="nav-item px-5 px-sm-4 px-md-3 px-lg-2">
                                <a class="nav-link active bg-primary text-light rounded-pill fw-bold" href="api/logout.php"><i class="fa-solid fa-right-from-bracket"></i></a>
                            </li>
                        </ul>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>