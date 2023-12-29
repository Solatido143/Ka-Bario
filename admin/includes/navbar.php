    <!-- top navbar -->
    <?php
    $ref_tableReq = 'request';
    $fetchdata = $database->getReference($ref_tableReq)->getValue();

    $requestcountTotal = 0;

    $logged_in_user_key = $_SESSION['database_user_id'];
    $logged_in_user_uid = $_SESSION['verified_user_id'];

    $userBarangay = $database->getReference('users')->getChild($logged_in_user_key)->getChild('residentialAddress/barangay')->getValue();

    try {
        $logged_in_user = $auth->getUser($logged_in_user_uid);
        $logged_in_user_customClaims = $logged_in_user->customClaims;
    } catch (\Kreait\Firebase\Exception\Auth\UserNotFound $e) {
        echo $e->getMessage();
        $_SESSION['failed_status'] = 'User not found.';
        header("location: ../../index.php");
        exit();
    } catch (Exception $e) {
        $_SESSION['failed_status'] = 'Something went wrong.';
        header("location: ../../index.php");
        exit();
    }

    if ($fetchdata) {
        foreach ($fetchdata as $row) {
            // Check if the status is false and barangay matches
            if (!$row['status'] && $row['barangay'] == $userBarangay) {
                $requestcountTotal++;
            }
        }
    }

    $emailToVerifiedCount = 0;
    $emailVerifiedCount = 0;
    $unclaimedDocumentCount = 0;

    $ref_users_tbl = 'users';
    $ref_req_tbl = 'request';

    $emailverified_countTotal = $database->getReference($ref_users_tbl)->getValue();
    $unclaimed_countTotal = $database->getReference($ref_req_tbl)->getValue();

    $logged_in_user_key = $_SESSION['database_user_id'];

    if ($emailverified_countTotal) {
        foreach ($emailverified_countTotal as $userrecord) {
            // Check if the user belongs to the same barangay
            if (isset($userrecord['residentialAddress']['barangay']) && $userrecord['residentialAddress']['barangay'] == $userBarangay) {
                if (isset($userrecord['emailVerified']) && $userrecord['emailVerified'] === false && !isset($userrecord['declinedAccount'])) {
                    $emailToVerifiedCount++;
                }
                if (isset($userrecord['emailVerified']) && $userrecord['emailVerified'] === true && !isset($userrecord['declinedAccount'])) {
                    $emailVerifiedCount++;
                }
            }
        }
    }

    if ($unclaimed_countTotal) {
        foreach ($unclaimed_countTotal as $requestrecord) {
            // Check if the user belongs to the same barangay

            if (isset($requestrecord['barangay']) && $requestrecord['barangay'] == $userBarangay) {
                if (isset($requestrecord['isClaimed']) && $requestrecord['isClaimed'] === false) {
                    $unclaimedDocumentCount++;
                }
            }
        }
    }


    ?>
    <nav class="navbar navbar-expand-lg bg-body-secondary sticky-top shadow">
        <div class="container-fluid">
            <a class="navbar-brand mx-5" href="../index.php">
                <img src="../pictures/KABARIO transparent.png" width="64" height="36" id="logo" alt="logo">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
                <div class="offcanvas-header border-bottom">
                    <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Ka-Bario</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>

                <div class="offcanvas-body d-flex flex-column justify-content-between">
                    <ul class="navbar-nav justify-content-start flex-grow-1 pe-3">
                        <li class="nav-item d-lg-none">
                            <a class="nav-link" aria-current="page" href="../index.php">Home</a>
                        </li>
                        <li class="nav-item d-lg-none">
                            <a class="nav-link active" aria-current="page" href="dashboard.php">Dashboard</a>
                        </li>
                        <li class="nav-item d-lg-none">
                            <a class="nav-link" aria-current="page" href="../barangayhome.php">Request Document</a>
                        </li>
                        <li class="nav-item d-lg-none">
                            <a class="nav-link" aria-current="page" href="userRequestlist.php">
                                Users Request
                                <?php if ($requestcountTotal > 0) : ?>
                                    <span class="badge text-bg-danger"><?= $requestcountTotal ?></span>
                                <?php endif; ?>
                            </a>
                        </li>
                        <li class="nav-item d-lg-none">
                            <a class="nav-link" aria-current="page" href="usersClaimDocument.php">
                                Document Claims
                                <?php if ($unclaimedDocumentCount > 0) : ?>
                                    <span class="badge text-bg-danger"><?= $unclaimedDocumentCount ?></span>
                                <?php endif; ?>
                            </a>
                        </li>
                        <li class="nav-item d-lg-none">
                            <a class="nav-link" href="verify_user.php">
                                Verification
                                <?php if ($emailToVerifiedCount > 0) : ?>
                                    <span class="badge text-bg-danger"><?= $emailToVerifiedCount ?></span>
                                <?php endif; ?>
                            </a>
                        </li>
                        <li class="nav-item dropdown dropend d-lg-none">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Admin Management
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="logs.php">Logs</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="userlist.php">List</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="#">Create new Admin</a></li>
                            </ul>
                        </li>
                        <li class="nav-item d-lg-none">
                            <a class="nav-link" href="editor.php">Editor</a>
                        </li>
                        <li class="nav-item d-lg-none">
                            <a class="nav-link" href="datalist.php">Data</a>
                        </li>

                    </ul>
                    <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                        <li class="nav-item d-none d-lg-block">
                            <a class="nav-link" aria-current="page" href="../index.php">Home</a>
                        </li>
                        <li class="nav-item dropdown">
                            <?php
                            include('../api/dbcon.php');
                            $uid = $_SESSION['verified_user_id'];
                            $key = $_SESSION['database_user_id'];
                            $user = $auth->getUser($uid);
                            ?>
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Welcome, <span class="fw-bold"><?= $user->displayName ?></span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <a class="dropdown-item" href="../myprofile.php?key=<?= $key ?>&uid=<?= $uid ?>">Account Settings</a>
                                </li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="../api/logout.php">Logout</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <div class="content position-relative <?php if (isset($_SESSION['has_validID'])) {
                                                echo 'vh-100';
                                            } ?>" aria-live="polite" aria-atomic="true">

        <?php
        include('toast.php');
        if (isset($_SESSION['has_validID'])) {
            echo '
                <div id="id_tab">
                    <button type="button" class="btn-close position-absolute top-0 end-0 m-3" aria-label="Close" onclick="close_validID()" style="z-index: 2;"></button>
                    <div class="d-flex align-items-center justify-content-center bg-secondary position-absolute w-100 p-5" style="z-index: 1;">
                        <img class="img-fluid border shadow" src="api/uploads/validIDs/' . $_SESSION['has_validID'] . '" alt="User Profile Photo">
                    </div>
                </div>
                ';
        }
        unset($_SESSION['has_validID']);
        ?>
        <!-- left navbar -->
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-3 col-xl-2 collapse d-lg-block border-end bg-body-tertiary vh-100">
                    <nav class="navbar navbar-expand-lg bg-body-tertiary">
                        <div class="navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav me-auto mb-2 mb-lg-0 flex-column">
                                <li class="nav-item">
                                    <a class="nav-link active" aria-current="page" href="dashboard.php">Dashboard</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" aria-current="page" href="../barangayhome.php">Request Document</a>
                                </li>
                                <?php if (!isset($logged_in_user_customClaims['super_admin']) || $logged_in_user_customClaims['super_admin'] !== true) : ?>
                                    <li class="nav-item">
                                        <a class="nav-link" aria-current="page" href="userRequestlist.php">
                                            Users Request
                                            <?php if ($requestcountTotal > 0) : ?>
                                                <span class="badge text-bg-danger"><?= $requestcountTotal ?></span>
                                            <?php endif; ?>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" aria-current="page" href="usersClaimDocument.php">
                                            Document Claims
                                            <?php if ($unclaimedDocumentCount > 0) : ?>
                                                <span class="badge text-bg-danger"><?= $unclaimedDocumentCount ?></span>
                                            <?php endif; ?>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="verify_user.php">
                                            Verification
                                            <?php if ($emailToVerifiedCount > 0) : ?>
                                                <span class="badge text-bg-danger"><?= $emailToVerifiedCount ?></span>
                                            <?php endif; ?>
                                        </a>
                                    </li>
                                <?php endif; ?>
                                <li class="nav-item dropdown dropend">
                                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        Admin Management
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="logs.php">Logs</a></li>
                                        <li><a class="dropdown-item" href="userlist.php">List</a></li>
                                        <li><a class="dropdown-item" href="#">Create new Admin</a></li>
                                    </ul>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="editor.php">Editor</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="datalist.php">Data</a>
                                </li>
                            </ul>
                        </div>
                    </nav>
                </div>

                <div class="col-lg-9 col-xl-10 py-3">