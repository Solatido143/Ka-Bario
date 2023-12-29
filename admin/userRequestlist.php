<?php
include('api/admin_auth.php');
include('includes/header.php');
?>

<div class="container vh-100">
    <div class="row">
        <div class="col">
            <div class="navbar navbar-expand-lg">
                <p class="h2 text-lg-center text-xl-center d-inline-block">Users Request</p>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
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
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Document Request</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th>Check</th>
                                    <th>Remove</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                $hasRequests = false;

                                if ($fetchdata) {
                                    foreach ($fetchdata as $requestkey => $row) {
                                        if (!$row['status'] && $logged_in_user_data['residentialAddress']['barangay'] == $row['barangay']) {
                                            include('includes/modal.php');
                                            $hasRequests = true;
                                ?>
                                            <tr>
                                                <td class='text-nowrap'><?= $i++ ?></td>
                                                <td class='text-nowrap'><?= $row['displayName'] ?></td>
                                                <td class='text-nowrap'><?= $row['documentType'] ?></td>
                                                <td class='text-nowrap'><?= $row['submitRequestDateTime'] ?></td>
                                                <td class="text-nowrap"><?= $row['status'] ? 'Complete' : 'Pending' ?></td>
                                                <td class='text-nowrap'>
                                                    <a href='#' class='btn btn-primary' data-bs-toggle="modal" data-bs-target="#userRequestmodalform_<?= $requestkey ?>">Check</a>
                                                </td>
                                                <td class='text-nowrap'>
                                                    <form action="api/code.php" method="POST">
                                                        <button type='submit' id="removeRequest" name="removeRequest" class="btn btn-danger" value="<?=$requestkey?>">Remove</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        <?php
                                        }
                                    }

                                    if (!$hasRequests) {
                                        ?>
                                        <tr>
                                            <td class="text-nowrap" colspan="7">No pending requests for your barangay at the moment.</td>
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
