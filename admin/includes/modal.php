<?php if (basename($_SERVER['PHP_SELF']) == 'userRequestlist.php') : ?>
    <div class="modal fade" id="userRequestmodalform_<?= $requestkey ?>" tabindex="-1" aria-labelledby="modalRequestLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
            <div class="modal-content">
                <div class="modal-header flex-column-reverse">
                    <h1 class="modal-title fs-5 text-center" id="modalRequestLabel"><?= $row['documentType'] ?></h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <?php
                $email = $row['email'];

                try {
                    $user = $auth->getUserByEmail($email);
                    $uid = $user->uid;
                } catch (\Kreait\Firebase\Exception\Auth\UserNotFound $e) {
                    echo $e->getMessage();
                    $_SESSION['failed_status'] = "User Not Found";
                    header("location: {$_SERVER["HTTP_REFERER"]}");
                    exit();
                }
                $ref_user_tbl = 'users';
                $reference = $database->getReference($ref_user_tbl);
                $query = $reference->orderByChild('email')->equalTo($email);
                $result = $query->getValue();

                if ($result > 0) {
                    foreach ($result as $user_key => $value) {
                ?>
                        <form class="needs-validation" novalidate="" action="api/code.php" method="POST" id="reqForm_<?= $user_key ?>" onsubmit="setFormTarget(event)">
                            <div class="modal-body">
                                <input type="hidden" name="userKey" value="<?= $user_key ?>">
                                <input type="hidden" name="requestKey" value="<?= $requestkey ?>">
                                <input type="hidden" name="requestType" value="<?= $row['documentType'] ?>">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" name="displayName" id="floatingInputName" placeholder="John Doe" value="<?= $row['displayName'] ?>">
                                            <label for="floatingInputName">Full Name</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" name="age" id="floatingInputAge" placeholder="" value="<?= $value['age'] ?>">
                                            <label for="floatingInputAge">Age</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" name="gender" id="floatingInputAge" placeholder="" value="<?= $value['gender'] ?>">
                                            <label for="floatingInputAge">Gender</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" name="civilstatus" id="floatingInputAge" placeholder="" value="<?= $value['civilstatus'] ?>">
                                            <label for="floatingInputAge">Civil</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" name="address" id="floatingInputAge" placeholder="" value="<?=
                                                                                                                                                $value['residentialAddress']['houseNum'] . ' ' .
                                                                                                                                                    $value['residentialAddress']['street'] . ' ' .
                                                                                                                                                    $value['residentialAddress']['barangay']
                                                                                                                                                ?>">
                                            <label for="floatingInputAge">Address</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" name="purpose" id="floatingInputAge" placeholder="" value="<?= $row['purpose'] ?>">
                                            <label for="floatingInputAge">Purpose</label>
                                        </div>
                                    </div>

                                    <?php if ($row['documentType'] == 'Barangay Clearance') : ?>
                                        <div class="col-lg-6">
                                            <div class="form-floating mb-3">
                                                <input type="text" class="form-control" name="occupation" id="floatingInputOccupation" placeholder="" value="<?= $row['occupation'] ?>">
                                                <label for="floatingInputAge">Occupation</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-floating mb-3">
                                                <input type="number" class="form-control" name="validYearDate" id="floatingInputValidDate" placeholder="" value="<?= date('Y'); ?>" min="<?= date('Y'); ?>">
                                                <label for="floatingInputAge">Valid until</label>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <label for="otherpurposetextarea" class="form-label">Other purpose</label>
                                            <textarea class="form-control" id="otherpurposetextarea" name="otherpurposetextarea" rows="1" placeholder=""><?= $row['otherPurpose'] ?></textarea>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <?php
                                        // Set the default timezone to Asia/Manila
                                        date_default_timezone_set('Asia/Manila');
                                        // Get the current date
                                        $currentDate = date('Y-m-d');
                                        // Extract day, month, and year
                                        list($year, $month, $day) = explode('-', $currentDate);
                                        ?>
                                        <div class="input-group mb-3">
                                            <span class="input-group-text">Date</span>
                                            <input type="text" name="day" aria-label="day" class="form-control" placeholder="01" value="<?= $day ?>">
                                            <input type="text" name="month" aria-label="month" class="form-control" placeholder="January" value="<?= date('F', strtotime($currentDate)) ?>">
                                            <input type="text" name="year" aria-label="year" class="form-control" placeholder="2003" value="<?= $year ?>">
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="modal-footer">
                                <div class="container-fluid">
                                    <div class="row text-center">
                                        <div class="col-lg-6">
                                            <button type="submit" name="printcomplete" class="btn btn-success">Complete</button>
                                        </div>
                                        <div class="col-lg-6">
                                            <button type="submit" name="printdocument" class="btn btn-primary">Print</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>

                <?php
                    }
                }
                ?>
            </div>
        </div>
    </div>

<?php elseif (basename($_SERVER['PHP_SELF']) == 'verify_user.php') : ?>
    <div class="modal fade" id="verifyUsermodalform_<?= $key ?>" tabindex="-1" aria-labelledby="verifyUserLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
            <div class="modal-content">
                <div class="modal-header flex-column-reverse">
                    <h1 class="modal-title fs-5 text-center" id="verifyUserLabel">Verify <?= $userRecord['firstName'] ?></h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form class="needs-validation" novalidate="" action="api/code.php" method="POST" id="reqForm_<?= $key ?>">
                    <div class="modal-body">
                        <input type="hidden" name="key" value="<?= $key ?>">
                        <input type="hidden" name="uid" value="<?= $uid ?>">

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="floatingInputName" placeholder="John Doe" value="<?= $user->displayName ?>" readonly>
                                    <label for="floatingInputName">Full Name</label>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="floatingInputAge" placeholder="" value="<?= !empty($userRecord['age']) ? $userRecord['age'] : ''; ?>" readonly>
                                    <label for="floatingInputAge">Age</label>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="floatingInputGender" placeholder="" value="<?= $userRecord['gender'] ?>" readonly>
                                    <label for="floatingInputGender">Gender</label>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="floatingInputCivil" placeholder="" value="<?= $userRecord['civilstatus'] ?>" readonly>
                                    <label for="floatingInputCivil">Civil</label>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="floatingInputAddress" placeholder="" value="<?= $userRecord['residentialAddress']['houseNum'] . ' ' . $userRecord['residentialAddress']['street'] . ' ' . $userRecord['residentialAddress']['barangay']; ?>" readonly>
                                    <label for="floatingInputAddress">Address</label>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="floatingInputRecidencyDate" placeholder="" value="<?php echo ($userRecord['residencyDate'] == 2) ? 'More than 6 months' : 'Less than 6 months'; ?>" readonly>
                                    <label for="floatingInputRecidencyDate">Recidency Date</label>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <a class="btn btn-success" href="viewID.php?uid=<?= $uid ?>&key=<?= $user_key ?>">View ID</a>
                        <button type="submit" name="verifyUserbtn" class="btn btn-primary ">Verify</button>
                        <button type="submit" name="declineUserbtn" class="btn btn-danger">Decline</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php endif; ?>