<?php
include('api/admin_auth.php');
include('includes/header.php');
?>

<div class="container">
    <div class="row navbar">
        <div class="col">
            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" data-bs-toggle="tab" href="#logsTab">Logs</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#transactionsTab">Transaction History</a>
                </li>
            </ul>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="tab-content">

                <div id="logsTab" class="card tab-pane fade show active">

                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="logsTable" class="table table-bordered table-striped mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-nowrap">ID</th>
                                        <th class="text-nowrap">Username</th>
                                        <th class="text-nowrap">Event</th>
                                        <th class="text-nowrap">Description</th>
                                        <th class="text-nowrap">Timestamp</th>
                                    </tr>
                                </thead>
                                
                                <tbody>
                                    <?php
                                    $ref_logs_tbl = 'logs';
                                    $fetchdata = $database->getReference($ref_logs_tbl)->getValue();

                                    $ref_users_tbl = 'users';
                                    $loggged_in_user_key = $_SESSION['database_user_id'];
                                    $logged_in_user_reference = $database->getReference($ref_users_tbl)->getChild($loggged_in_user_key);
                                    $logged_in_user_data = $logged_in_user_reference->getValue();

                                    $logged_in_user_uid = $_SESSION['verified_user_id'];
                                    try {
                                        $logged_in_user = $auth->getUser($logged_in_user_uid);
                                    } catch (\Kreait\Firebase\Exception\Auth\UserNotFound $e) {
                                        echo $e->getMessage();
                                        $_SESSION['failed_status'] = 'User not found';
                                        header("location: ../index.php");
                                        exit();
                                    }

                                    // Initialize the counter
                                    $i = 0;

                                    if ($fetchdata && $logged_in_user_data) {
                                        foreach ($fetchdata as $requestkey => $row) {
                                            if (isset($logged_in_user_data['residentialAddress']['barangay']) && isset($row['userbarangay']) && $logged_in_user_data['residentialAddress']['barangay'] == $row['userbarangay']) {
                                                $i++;
                                                $count = $i;
                                            }
                                        }
                                        foreach ($fetchdata as $requestkey => $row) {
                                            if (isset($logged_in_user_data['residentialAddress']['barangay']) && isset($row['userbarangay']) && $logged_in_user_data['residentialAddress']['barangay'] == $row['userbarangay']) {
                                            ?>
                                                <tr>
                                                    <td class="text-nowrap"><?=$count--?></td>
                                                    <td class="text-nowrap"><?= $row['user_name'] ?></td>
                                                    <td class="text-nowrap"><?= $row['event'] ?></td>
                                                    <td class="text-nowrap"><?= $row['description'] ?></td>
                                                    <td class="text-nowrap"><?= $row['timeStamps'] ?></td>
                                                </tr>
                                    <?php
                                            }
                                        }
                                    }
                                    ?>
                                </tbody>


                                <tfoot>
                                    <th class="text-nowrap">ID</th>
                                    <th class="text-nowrap">Username</th>
                                    <th class="text-nowrap">Event</th>
                                    <th class="text-nowrap">Description</th>
                                    <th class="text-nowrap">Timestamp</th>
                                </tfoot>
                            </table>
                        </div>
                    </div>

                </div>

                <div id="transactionsTab" class="card tab-pane fade">

                    <div class="card-header">
                        <h4 class="mb-0">
                            Latest Completed Request
                        </h4>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <tbody>
                                    <?php
                                    $ref_req_tbl = 'request';
                                    $fetchdata = $database->getReference($ref_req_tbl)->getValue();
                                    $hasCompletedRequests = false;

                                    $logged_in_user_key = $_SESSION['database_user_id'];
                                    $logged_in_user_reference = $database->getReference($ref_users_tbl)->getChild($logged_in_user_key);
                                    $logged_in_user_data = $logged_in_user_reference->getValue();

                                    if ($fetchdata) {
                                        foreach ($fetchdata as $requestkey => $row) {
                                            if (isset($row['isClaimed']) && $row['isClaimed'] === true && $logged_in_user_data['residentialAddress']['barangay'] == $row['barangay']) {
                                                $hasCompletedRequests = true;
                                    ?>
                                                <tr>
                                                    <td class="text-nowrap"><?= $row['displayName'] ?></td>
                                                    <td class="text-nowrap"><?= $row['address'] ?></td>
                                                    <td class="text-nowrap"><?= $row['documentType'] ?></td>
                                                    <td class="text-nowrap bg-success"><?= $row['isClaimed'] ? 'Complete' : 'Pending' ?></td>
                                                </tr>
                                        <?php
                                            }
                                        }
                                    }

                                    if (!$hasCompletedRequests) {
                                        ?>
                                        <tr>
                                            <td class="text-nowrap fw-bolder">None</td>
                                        </tr>
                                    <?php
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
</div>



<?php
include('includes/footer.php');
?>