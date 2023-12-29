<?php
include('api/admin_auth.php');
include('includes/header.php');
?>
<div class="container">

    <div class="row">
        <div class="col">
            <div class="navbar navbar-expand-lg">
                <p class="h2 text-lg-center text-xl-center d-inline-block">VERIFY</p>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">
                        Users
                    </h4>
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
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $authUsers = $auth->listUsers();
                                $ref_users_tbl = 'users';
                                $fetchdata = $database->getReference($ref_users_tbl)->getValue();

                                $loggged_in_user_key = $_SESSION['database_user_id'];
                                $logged_in_user_reference = $database->getReference($ref_users_tbl)->getChild($loggged_in_user_key);
                                $logged_in_user_data = $logged_in_user_reference->getValue();
                                $i = 1;
                                $needToVerify = false;
                                foreach ($authUsers as $user) {
                                    $email = $user->email;
                                    $userRecord = findUserRecord($fetchdata, $email);
                                    // Check if emailVerified is false
                                    if ($userRecord && !$userRecord['emailVerified'] && !$user->emailVerified && (!isset($userRecord['declinedAccount']))  && $logged_in_user_data['residentialAddress']['barangay'] == $userRecord['residentialAddress']['barangay']) {
                                        
                                        $needToVerify = true;
                                        $key = array_search($userRecord, $fetchdata);
                                        $uid = $user->uid;
                                        include('includes/modal.php')
                                ?>
                                        <tr>
                                            <td><?= $i++; ?></td>
                                            <td class='text-nowrap'><?= $user->displayName ?></td>
                                            <td class='text-nowrap'><?= $user->email ?></td>
                                            <td class='text-nowrap'><?= $user->phoneNumber ?></td>
                                            <td class='text-nowrap'><?= $user->emailVerified ? 'Verified' : 'Pending' ?></td>
                                            <td class='text-nowrap'>
                                                <a href="#" class='btn btn-primary' data-bs-toggle="modal" data-bs-target="#verifyUsermodalform_<?= $key ?>">Check</i></a>
                                            </td>
                                        </tr>
                                    <?php
                                    }
                                }
                                if (!$needToVerify) {
                                    ?>
                                    <tr>
                                        <td class="text-nowrap" colspan="7">No Account need to Verify for your barangay at the moment.</td>
                                    </tr>
                                <?php

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


    <script>
        function close_validID() {
            // Get the element with id 'id_tab'
            var idTab = document.getElementById('id_tab');

            // Set the display property to 'none' to hide the element
            idTab.style.display = 'none';
        }
    </script>
    <?php
    include('includes/footer.php');
    ?>