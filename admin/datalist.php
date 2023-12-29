<?php
include('api/admin_auth.php');
include('includes/header.php');
?>

<div class="container">
    <div class="row">
        <div class="col">
            <div class="navbar navbar-expand-lg">
                <p class="h2 text-lg-center text-xl-center d-inline-block">Database</p>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3 mb-md-0">
                                <h4 class="mb-0">
                                    Users
                                </h4>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3 mb-md-0 float-md-end">
                                Search:
                                <input class="form-control me-2 d-inline" style="width: auto;" type="search" placeholder="Search" aria-label="Search">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th class="text-nowrap">ID</th>
                                    <th class="text-nowrap">Full Name</th>
                                    <th class="text-nowrap">Email</th>
                                    <th class="text-nowrap">Phone Number</th>
                                    <th class="text-nowrap">Status</th>
                                    <th class="text-nowrap">Role as</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $authUsers = $auth->listUsers();
                                $ref_users_tbl = 'users';
                                $fetchdata = $database->getReference($ref_users_tbl)->getValue();
                                $i = 1;

                                $logged_in_user_key = $_SESSION['database_user_id'];
                                $logged_in_user_reference = $database->getReference($ref_users_tbl)->getChild($logged_in_user_key);
                                $logged_in_user_data = $logged_in_user_reference->getValue();

                                $logged_in_user_uid = $_SESSION['verified_user_id'];
                                try {
                                    $logged_in_authUser = $auth->getUser($logged_in_user_uid);
                                } catch (\Kreait\Firebase\Exception\Auth\UserNotFound $e) {
                                    echo $e->getMessage();
                                    $_SESSION['failed_status'] = "User not found.";
                                    header("location: {$_SERVER['HTTP_REFERER']}");
                                    exit();
                                }
                                $logged_in_authUser_claims = $logged_in_authUser->customClaims;

                                // if logged in user is super admin
                                if (isset($logged_in_authUser_claims['super_admin']) && $logged_in_authUser_claims['super_admin'] === true) {
                                    foreach ($authUsers as $user) {
                                        $email = $user->email;
                                        $userRecord = findUserRecord($fetchdata, $email);

                                        if ($userRecord && $userRecord['residentialAddress']['barangay'] == $logged_in_user_data['residentialAddress']['barangay']) {
                                            $key = array_search($userRecord, $fetchdata);
                                            $uid = $user->uid;
                                            $claims = $auth->getUser($uid)->customClaims;

                                            if ($claims === null) {
                                                $selectedRole = 'No role';
                                            } elseif (isset($claims['resident']) && $claims['resident'] === true) {
                                                $selectedRole = 'Resident';
                                            } elseif (isset($claims['admin']) && $claims['admin'] === true) {
                                                $selectedRole = 'Admin';
                                            } elseif (isset($claims['super_admin']) && $claims['super_admin'] === true) {
                                                $selectedRole = 'Super Admin';
                                            } else {
                                                $selectedRole = 'No role';
                                            }
                                ?>
                                            <tr>
                                                <td><?= $i++; ?></td>
                                                <td class='text-nowrap'><?= $user->displayName ?></td>
                                                <td class='text-nowrap'><?= $email ?></td>
                                                <td class='text-nowrap'><?= $user->phoneNumber ?></td>
                                                <td class='text-nowrap'><?= $user->emailVerified ? 'Verified' : 'Pending' ?></td>
                                                <td class='text-nowrap'><?= $selectedRole ?></td>
                                            </tr>
                                            <?php
                                        }
                                    }
                                    // if logged in user is admin
                                } elseif (isset($logged_in_authUser_claims['admin']) && $logged_in_authUser_claims['admin'] === true) {
                                    // Output all users with 'admin' claims, excluding 'super_admin', in the same barangay
                                    foreach ($authUsers as $user) {
                                        $email = $user->email;
                                        $userRecord = findUserRecord($fetchdata, $email);

                                        if ($userRecord && $userRecord['residentialAddress']['barangay'] == $logged_in_user_data['residentialAddress']['barangay']) {
                                            $key = array_search($userRecord, $fetchdata);
                                            $claims = $auth->getUser($user->uid)->customClaims;
                                            if ($claims === null) {
                                                $selectedRole = 'No role';
                                            } elseif (isset($claims['resident']) && $claims['resident'] === true) {
                                                $selectedRole = 'Resident';
                                            } elseif (isset($claims['admin']) && $claims['admin'] === true) {
                                                $selectedRole = 'Admin';
                                            } elseif (isset($claims['super_admin']) && $claims['super_admin'] === true) {
                                                $selectedRole = 'Super Admin';
                                            } else {
                                                $selectedRole = 'No role';
                                            }
                                            if (!isset($claims['super_admin'])) {
                                                // Output the table row
                                            ?>
                                                <tr>
                                                    <td><?= $i++ ?></td>
                                                    <td class='text-nowrap'><?= $user->displayName ?></td>
                                                    <td class='text-nowrap'><?= $email ?></td>
                                                    <td class='text-nowrap'><?= $user->phoneNumber ?></td>
                                                    <td class='text-nowrap'><?= $user->emailVerified ? 'Verified' : 'Pending' ?></td>
                                                    <td class='text-nowrap'><?= $selectedRole ?></td>
                                                </tr>
                                <?php
                                            }
                                        }
                                    }
                                }


                                function findUserRecord($data, $email)
                                {
                                    foreach ($data as $key => $record) {
                                        if ($record['email'] === $email) {
                                            return $record;
                                        }
                                    }
                                    return null;
                                }
                                ?>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include('includes/footer.php');
?>