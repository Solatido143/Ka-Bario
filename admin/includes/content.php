<div class="container">
    <div class="row text-light">
        <div class="col-12">
            <div class="navbar navbar-expand-lg">
                <p class="h2 text-lg-center text-xl-center d-inline-block text-dark">Services</p>
            </div>
        </div>
        <div class="col-sm-6 col-lg-6 col-md-6 col-xl-4 col-xxl-3 mb-3">
            <div class="box bg-success d-flex flex-column justify-content-between" style="padding:20px; border-radius: 8px; min-height:200px;">
                <a href="#" class="text-decoration-none text-dark">
                    <h5 class="text-light" aria-describedby="notesverify">Verified Accounts</h5>
                    <div id="notesverify" class="form-text">
                        with valid ID.
                    </div>
                </a>
                <div class="h1 text-center"><?= $emailVerifiedCount ?></div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-6 col-md-6 col-xl-4 col-xxl-3 mb-3">
            <div class="box bg-warning d-flex flex-column justify-content-between" style="padding:20px; border-radius: 8px; min-height:200px;">
                <a href="#" class="text-decoration-none text-dark">
                    <h5 class="text-light" aria-describedby="notesverify">Requesting Documents</h5>
                    <div id="notesverify" class="form-text">
                        Needed to be print.
                    </div>
                </a>
                <div class="h1 text-center"><?= $requestcountTotal ?></div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-6 col-md-6 col-xl-4 col-xxl-3 mb-3">
            <div class="box bg-primary d-flex flex-column justify-content-between" style="padding:20px; border-radius: 8px; min-height:200px;">
                <a href="#" class="text-decoration-none text-dark">
                    <h5 class="text-light" aria-describedby="notesverify">Pending Accounts</h5>
                    <div id="notesverify" class="form-text">
                        needed to be checked.
                    </div>
                </a>
                <div class="h1 text-center"><?= $emailToVerifiedCount ?></div>
            </div>
        </div>

        <?php
        $declinedAccount = 0;

        $reference = $database->getReference($ref_users_tbl);
        $tbl_data = $reference->getValue();

        

        if ($tbl_data) {
            foreach ($tbl_data as $userRecord) {
                // Check if the user belongs to the same barangay

                if (isset($userRecord['residentialAddress']['barangay']) && $userRecord['residentialAddress']['barangay'] == $userBarangay) {
                    if (isset($userRecord['declinedAccount']) && $userRecord['declinedAccount'] === true) {
                        $declinedAccount++;
                    }
                }
            }
        }
        ?>
        <div class="col-sm-6 col-lg-6 col-md-6 col-xl-4 col-xxl-3 mb-3">
            <div class="box bg-danger d-flex flex-column justify-content-between" style="background-color: grey; padding:20px; border-radius: 8px; min-height:200px;">
                <a href="#" class="text-decoration-none text-dark">
                    <h5 class="text-light" aria-describedby="notesverify">Declined Accounts</h5>
                    <div id="notesverify" class="form-text">
                        not in the masterlist.
                    </div>
                </a>
                <div class="h1 text-center"><?= $declinedAccount ?></div>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="card">
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
                                $ref_table = 'request';
                                $fetchdata = $database->getReference($ref_table)->getValue();
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