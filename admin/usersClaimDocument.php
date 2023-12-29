<?php

use Kreait\Firebase\Value\Email;

include('api/admin_auth.php');
include('includes/header.php');
?>

<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">
                        Unclaimed Documents
                    </h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <?php
                        $ref_req_tbl = 'request';
                        $fetchdata = $database->getReference($ref_req_tbl)->getValue();

                        $ref_users_tbl = 'users';
                        $loggged_in_user_key = $_SESSION['database_user_id'];
                        $logged_in_user_reference = $database->getReference($ref_users_tbl)->getChild($loggged_in_user_key);
                        $logged_in_user_data = $logged_in_user_reference->getValue();
                        ?>

                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th class="text-nowrap">ID</th>
                                    <th class="text-nowrap">Full Name</th>
                                    <th class="text-nowrap">Email</th>
                                    <th class="text-nowrap">Phone Number</th>
                                    <th class="text-nowrap">Document</th>
                                    <th>Claimed</th>
                                    <th>Remove</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                $hasUnclaimedDocuments = false;
                                if ($fetchdata) {


                                    foreach ($fetchdata as $requestkey => $row) {
                                        if (isset($row['isClaimed']) && $row['isClaimed'] === false && $logged_in_user_data['residentialAddress']['barangay'] == $row['barangay']) {
                                            $hasUnclaimedDocuments = true;
                                ?>
                                            <tr>
                                                <td class='text-nowrap'><?= $i++ ?></td>
                                                <td class='text-nowrap'><?= $row['displayName'] ?></td>
                                                <td class='text-nowrap'><?= $row['email'] ?></td>
                                                <td class='text-nowrap'><?= $row['phoneNumber'] ?></td>
                                                <td class="text-nowrap"><?= $row['documentType'] ?></td>
                                                <form action="api/code.php" method="POST">
                                                    <td class='text-nowrap'>
                                                        <button type='submit' name='users_claimed_btn' value='<?= $requestkey ?>' class="btn btn-primary">Claimed</button>
                                                    </td>
                                                    <td class='text-nowrap'>
                                                        <button type='submit' id="removeUnclaimedDocument" name="removeUnclaimedDocument" class="btn btn-danger" value="<?= $requestkey ?>">Remove</button>
                                                    </td>
                                                </form>
                                            </tr>
                                        <?php
                                        }
                                    }

                                    if (!$hasUnclaimedDocuments) {
                                        ?>
                                        <tr>
                                            <td class="text-nowrap" colspan="7">No unclaimed documents for your barangay at the moment.</td>
                                        </tr>
                                <?php
                                    }
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