<?php
include ('api/admin_auth.php');
include ('includes/header.php');
?>
<!-- UserEdit -->
<div class="container rounded bg-light mb-3">
    <div class="row">

        <div class="col-lg-12 border-bottom">
            <div class="p-3 py-5">
            <?php

                if(isset($_GET['uid']) && isset($_GET['key'])){
                    $uid = $_GET['uid'];
                    $key = $_GET['key'];

                    try {
                        $user = $auth->getUser($uid);
                        $email = $user->email;
                        $role = $user->customClaims;

                        if ($role === null) {
                            $selectedRole = '';
                        } elseif (isset($role['resident']) && $role['resident'] === true) {
                            $selectedRole = 'Resident';
                        } elseif (isset($role['admin']) && $role['admin'] === true) {
                            $selectedRole = 'Admin';
                        } elseif (isset($role['super_admin']) && $role['super_admin'] === true) {
                            $selectedRole = 'Super Admin';
                        } else {
                            $selectedRole = '';
                        }

                        $ref_table = 'users';
                        $table_ref = $database->getReference($ref_table);
                        $matchdata = $table_ref->orderByChild('email')->equalTo($email)->getSnapshot();
                        if ($matchdata->hasChildren()) {
                            foreach ($matchdata->getValue() as $key => $userData) {
                                // $key is the key of the matching user in the 'users' table
                                // $userData is the data associated with that user
                                // echo "Found user with email: $email, Key: $key";
                                // Do something with $key and $userData
                                $userdata = $table_ref->getChild($key)->getValue();
            ?>
                <form class="row needs-validation" novalidate="" method="POST" action="api/edit-user-profile.php">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="text-right"><?=$user->displayName?><p class="text-muted fw-normal text-lowercase fs-6 small d-inline"> <?=$selectedRole?></p></h4>
                        
                        <button class="btn btn-danger float-end" name="go-back" type="button" id="goback">Back</button>
                    </div>
                    <input type="hidden" name="key" value="<?=$key;?>">
                    <input type="hidden" name="uid" value="<?=$uid;?>">
                    <div class="col-md-4 col-lg-12 col-xl-4 mb-3">
                        <label for="fname" class="form-label fw-bold">First name</label>
                        <input type="text" class="form-control" id="fname" name="firstname" value="<?=$userdata['firstName'];?>" required>
                        <div class="invalid-feedback">
                            Please enter your first name.
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-12 col-xl-4 mb-3">
                        <label for="lname" class="form-label fw-bold">Middle name</label>
                        <input type="text" class="form-control" id="Mname" name="middlename" value="" placeholder="(Optional)">
                    </div>
                    <div class="col-md-4 col-lg-12 col-xl-4 mb-3">
                        <label for="lname" class="form-label fw-bold">Last name</label>
                        <input type="text" class="form-control" id="lname" name="lastname" value="<?=$userdata['lastName'];?>" required>
                        <div class="invalid-feedback">
                            Please enter your last name.
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-12 col-xl-4 mb-3">
                        <label for="email" class="form-label fw-bold">Email</label>
                        <input type="text" class="form-control" id="email" name="email" value="<?=$userdata['email'];?>" required>
                        <div class="invalid-feedback">
                            Please enter your email.
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-12 col-xl-4 mb-3">
                        <label for="phoneNumber" class="form-label fw-bold">Phone</label>
                        <input type="text" class="form-control" id="phoneNumber63" name="phonenumber63" value="<?=$user->phoneNumber?>" required>
                        <input type="hidden" class="form-control" id="phoneNumber0" name="phonenumber0" value="<?=$userdata['phoneNumber']?>" required>
                        <div class="invalid-feedback">
                            Please enter your email.
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-12 col-xl-4 mb-3">
                        <label for="emailVerified" class="form-label fw-bold">Verified</label>
                        <input type="text" class="form-control" id="emailVerified" name="emailverified" value="<?=$user->emailVerified ? 'True' : 'False'?>" required readonly>
                        <div class="invalid-feedback">
                            Please enter your email.
                        </div>
                    </div>
                    
                    <div class="col-lg-12 mb-3 d-none d-md-block d-lg-none d-xl-block">
                        <div class="input-group">
                            <span class="input-group-text fw-bold">Residential Address</span>
                            <input type="text" class="form-control" aria-label="housenum" id="houseno" name="housenum" placeholder="House No." value="<?=$userData['residentialAddress']['houseNum']?>" required>
                            <input type="text" class="form-control" aria-label="street" id="street" name="street" placeholder="Street" value="<?=$userData['residentialAddress']['street']?>" required>
                            <input type="text" class="form-control" aria-label="barangay" list="datalistBarangayOptions" id="barangay" name="barangay" placeholder="Barangay" value="<?=$userData['residentialAddress']['barangay']?>" required>
                        </div>
                    </div>
                    <div class="col-lg-12 mb-3 d-md-none d-lg-block d-xl-none">
                        <label for="residentialAddress" class="form-label fw-bold">Residential Address</label>
                        <div class="row" id="residentialAddress">
                            <div class="col-lg-12">
                                <input type="text" class="form-control mb-3" id="houseno" name="housenum" placeholder="House No." value="<?=$userData['residentialAddress']['houseNum']?>" required>
                            </div>
                            <div class="col-lg-12">
                                <input type="text" class="form-control mb-3"id="street" name="street" placeholder="Street" value="<?=$userData['residentialAddress']['street']?>" required>
                            </div>
                            <div class="col-lg-12">
                                <input type="text" class="form-control mb-3" list="datalistBarangayOptions" id="barangay" name="barangay" placeholder="Barangay" value="<?=$userData['residentialAddress']['barangay']?>" required>
                            </div>
                        </div>
                    </div>
                    <datalist id="datalistBarangayOptions">
                        <option value="Bagumbayan">
                        <option value="Balubad">
                        <option value="Bambang">
                        <option value="Matungao">
                        <option value="Maysantol">
                        <option value="Perez">
                        <option value="Pitpitan">
                        <option value="San Francisco">
                        <option value="San Jose (Pob.)">
                        <option value="San Nicolas">
                        <option value="Santa Ana">
                        <option value="Santa Ines">
                        <option value="Taliptip">
                        <option value="Tibig">
                    </datalist>
                    <div class="col-12 mb-3 d-none">
                        <label for="residentdate" class="form-label">Residency Date</label>
                        <select class="form-select" id="residentdate" name="residencydate" aria-label="Default select example" required disabled>
                            <option value="1" <?=($userData['residencyDate'] == '1') ? 'selected' : ''; ?>>Less than 6 months</option>
                            <option value="2" <?=($userData['residencyDate'] == '2') ? 'selected' : ''; ?>>Greater than 6 Months</option>
                        </select>
                        <div class="invalid-feedback">
                            Please choose residency date.
                        </div>
                    </div>
                    <div class="col-lg-12 mb-3">
                        <div class="input-group">
                            <span class="input-group-text fw-bold">Permanent Address</span>
                            <input type="text" class="form-control" aria-label="permanentadress" id="permanentAddress" name="permanentaddress" aria-describedby="permanentAddressHelpBlock" value="<?=$userData['permanentAddress']?>" required>
                        </div>
                        <div class="invalid-feedback">
                            Please enter your permanent address.
                        </div>
                        <div id="permanentAddressHelpBlock" class="form-text">
                            (House # / Block / Street / Barangay / Municipality / Province)
                        </div>
                    </div>
                    <div class="col-12">
                        <button class="btn btn-primary" name="update-user-profile" type="submit">Save Changes</button>
                    </div>
                </form>
            <?php
                            }
                        } else {
                            // echo "No user found with email: $email";
                            $_SESSION['status'] = 'No user found';
                            header("Location: userlist.php");
                            exit();
                        }
                    } catch (\Kreait\Firebase\Exception\Auth\UserNotFound $e) {
                        echo $e->getMessage();
                        $_SESSION['failed_status'] = 'No user found';
                        header('location: userlist.php');
                        exit();
                    } catch (\Kreait\Firebase\Exception\InvalidArgumentException $e) {
                        $_SESSION['failed_status'] = 'UID cannot be empty!';
                        header('location: userlist.php');
                        exit();
                    }
                
            ?>
            </div>
        </div>

        <div class="col-lg-12">
            <div class="p-3 py-5">
                <div class="row">
                    <div class="col-lg-6">
                        <form class="needs-validation" novalidate="" method="POST" action="api/edit-user-profile.php">
                            <?php
                            $user = $auth->getUser($uid);
                            $role = $user->customClaims;

                            if ($role === null) {
                                $selectedRole = '';
                            } elseif (isset($role['resident']) && $role['resident'] === true) {
                                $selectedRole = 'resident';
                            } elseif (isset($role['admin']) && $role['admin'] === true) {
                                $selectedRole = 'admin';
                            } elseif (isset($role['super_admin']) && $role['super_admin'] === true) {
                                $selectedRole = 'super_admin';
                            } else {
                                $selectedRole = '';
                            }

                            ?>
                            <input type="hidden" name="claim_user_id" value="<?=$uid?>">
                            <input type="hidden" name="claim_user_key" value="<?=$key?>">
                            <label for="userRole" class="form-label fw-bold">Role</label>
                            <div class="input-group mb-3">
                                <select class="form-select" id="role_as" name="role_as" required>

                                    <option value="" <?=($selectedRole == '') ? 'selected' : ''; ?>>Choose...</option>
                                    <option value="resident" <?=($selectedRole == 'resident') ? 'selected' : ''; ?>>Resident</option>
                                    <option value="admin" <?=($selectedRole == 'admin') ? 'selected' : ''; ?>>Admin</option>
                                    <option value="super_admin" <?=($selectedRole == 'super_admin') ? 'selected' : ''; ?>>Super Admin</option>
                                    <option value="norole">Remove</option>

                                </select>
                                <button class="btn btn-primary" type="submit" name="btn-submit-role">Confirm</button>
                            </div>
                        </form>
                    </div>
                    <div class="col-lg-6">
                        <form class="needs-validation" novalidate="" method="POST" action="api/edit-user-profile.php">
                            <label for="ena_dis" class="form-label fw-bold">Enable/Disable</label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" id="ena_dis" placeholder="Enable/Disable" aria-label="Enable/Disable" aria-describedby="enabledisable">
                                <button class="btn btn-primary" type="button" id="enabledisable">Toggle</button>
                            </div>
                        </form>
                    </div>
                </div>
                <?php
                } else {
                    $_SESSION['failed_status'] = 'Invalid UID!';
                    header('location: userlist.php');
                    exit();
                }
                ?>
            </div>
        </div>
    </div>
</div>

<script>
    (() => {
        'use strict';
        document.addEventListener('DOMContentLoaded', function () {
            const forms = document.querySelectorAll('.needs-validation');

            Array.from(forms).forEach(form => {
                form.addEventListener('submit', event => {
                    if (!form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();
                    } 

                    form.classList.add('was-validated');
                    
                }, false);
            });
        });
    })();

    const linkButton = document.getElementById('goback');

    // Add a click event listener to the button
    linkButton.addEventListener('click', function() {
        // Navigate to the desired URL when the button is clicked
        window.location.href = 'userlist.php';
    });
</script>
<?php
include ('includes/footer.php');
?>