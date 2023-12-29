<?php
if (isset($_GET['uid']) && isset($_GET['key'])) {
    $uid = $_GET['uid'];
    $key = $_GET['key'];

    try {
        $user = $auth->getUser($uid);
    } catch (\Kreait\Firebase\Exception\Auth\UserNotFound $e) {
        echo $e->getMessage();
        $_SESSION['failed_status'] = 'No user found';
        // header('location: index.php');
        exit();
    }

    $claims = $user->customClaims;

    if ($claims === null) {
        $userRole = 'No role';
    } elseif (isset($claims['resident']) && $claims['resident'] === true) {
        $userRole = 'Resident';
    } elseif (isset($claims['admin']) && $claims['admin'] === true) {
        $userRole = 'Admin';
    } elseif (isset($claims['super_admin']) && $claims['super_admin'] === true) {
        $userRole = 'Super Admin';
    }

    $getuserData = $database->getReference($ref_user_tbl)->getChild($key)->getValue();

    if (empty($getuserData)) {
        $_SESSION['failed_status'] = 'No user found';
        // header('location: ../api/logout.php');
        exit();
    } else {
?>
        <div class="container rounded bg-light mt-3 mb-3 shadow border">
            <div class="row">

                <div class="col-lg-4 col-xl-3 border-lg-end">
                    <div class="d-flex flex-column align-items-center text-center p-3 py-5">
                        <?php
                        if ($user->photoUrl !== NULL) {
                        ?>

                            <img class="rounded-circle mt-5 object-fit-contain border shadow mb-3" width="150px" height="150px" src="api/<?= $user->photoUrl ?>" alt="User Profile Photo">

                        <?php
                        } else {
                        ?>

                            <img class="rounded-circle mt-5 mb-3" width="150px" src="https://st3.depositphotos.com/15648834/17930/v/600/depositphotos_179308454-stock-illustration-unknown-person-silhouette-glasses-profile.jpg">

                        <?php
                        }
                        ?>
                        <span class="fw-bold"><?= $user->displayName; ?></span>
                        <span class="text-dark-emphasis"><?= $user->email; ?></span>
                        <span class="text-dark-emphasis"><?= $user->phoneNumber; ?></span>
                        <span class="text-dark-emphasis"><?= $getuserData['emailVerified'] && $user->emailVerified ? 'Verified' : 'Non-Verified' ?></span>
                        <span class="text-dark-emphasis">You are a <b class="text-primary"><?= $userRole; ?></b></span>
                    </div>
                </div>

                <div class="col-lg-8 col-xl-6 border-lg-end">
                    <div class="p-3 py-5">
                        <form class="row needs-validation" novalidate="" method="POST" action="./api/editprofile.php">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h4 class="text-right">Profile Settings</h4>
                            </div>

                            <input type="hidden" name="uid" value="<?= $uid ?>">
                            <input type="hidden" name="key" value="<?= $key ?>">

                            <div class="Fnameinput col-md-6 col-lg-12 col-xl-6 mb-3">
                                <label for="Fname" class="form-label">First name</label>
                                <input type="text" class="form-control" id="Fname" name="firstname" value="<?= $getuserData['firstName'] ?>" required>
                                <div class="invalid-feedback">
                                    Please enter your first name.
                                </div>
                            </div>
                            <div class="Lnameinput col-md-6 col-lg-12 col-xl-6 mb-3">
                                <label for="Lname" class="form-label">Last name</label>
                                <input type="text" class="form-control" id="Lname" name="lastname" value="<?= $getuserData['lastName'] ?>" required>
                                <div class="invalid-feedback">
                                    Please enter your last name.
                                </div>
                            </div>

                            <div class="genderinput col-lg-6 mb-3 d-flex align-items-center">
                                <label for="genderRadioOptions" class="form-label me-3">Gender:</label>
                                <div id="genderRadioOptions" class="d-inline-block">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="genderRadioOption" id="maleRadio" value="Male" required <?= ($getuserData['gender'] == 'Male') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="maleRadio">Male</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="genderRadioOption" id="femaleRadio" value="Female" required <?= ($getuserData['gender'] == 'Female') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="femaleRadio">Female</label>
                                    </div>
                                </div>
                            </div>

                            <div class="birthinput col-md-6 col-lg-12 col-xl-6 mb-3">
                                <div class="mb-3">
                                    <label for="exampleFormControlInput1" class="form-label">Birthdate <span class="text-dark-emphasis">(MM/DD/YYYY)</span></label>
                                    <input type="text" name="birthdate" id="birthdate" class="form-control" value="<?= $getuserData['birthdate'] ?>" placeholder="MM/DD/YYYY" required pattern="^(0[1-9]|1[0-2])\/(0[1-9]|[12][0-9]|3[01])\/\d{4}$">
                                    <div class="invalid-feedback" id="birthdate-error">
                                        Enter your birthdate.
                                    </div>
                                </div>
                            </div>

                            <div class="phonenumberinput col-md-6 col-lg-12 col-xl-6 mb-3">
                                <label for="phoneNumber" class="form-label">Phone number</label>
                                <input type="text" class="form-control" id="phoneNumber" name="phonenumber" placeholder="09123456789" pattern="[0-9]{11}" value="<?= $getuserData['phoneNumber'] ?>" required>
                                <div class="invalid-feedback">
                                    Please enter a valid phone number.
                                </div>
                            </div>

                            <div class="emailinput col-md-6 col-lg-12 col-xl-6 mb-3">
                                <label for="signUpeMail" class="form-label">Email address</label>
                                <input type="email" class="form-control" id="signUpeMail" name="emailaddress" placeholder="name@example.com" value="<?= $getuserData['email'] ?>" required readonly>
                                <div class="invalid-feedback">
                                    Please enter a valid email address.
                                </div>
                            </div>

                            <div class="statusinput col-12 mb-3">
                                <label for="civilstatus" class="form-label me-3">Civil Status:</label>
                                <div id="civilstatus" class="d-inline-block">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="civilstatusRadioOption" id="singleRadio" value="Single" required <?= ($getuserData['civilstatus'] == 'Single') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="singleRadio">Single</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="civilstatusRadioOption" id="marriedRadio" value="Married" required <?= ($getuserData['civilstatus'] == 'Married') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="marriedRadio">Married</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="civilstatusRadioOption" id="divorcedRadio" value="Divorced" required <?= ($getuserData['civilstatus'] == 'Divorced') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="divorcedRadio">Divorced</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="civilstatusRadioOption" id="othersRadio" value="Others" required <?= ($getuserData['civilstatus'] == 'Others') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="othersRadio">Others</label>
                                    </div>
                                </div>
                            </div>

                            <div class="resAdd col-lg-12">
                                <div class="mb-3">
                                    <label for="residentialAddress" class="form-label">Residential Address</label>
                                    <div class="row" id="residentialAddress">
                                        <div class="col-md-4 col-lg-12 col-xl-4">
                                            <input type="text" class="form-control mb-3" id="houseno" name="housenum" placeholder="House No." value="<?= $getuserData['residentialAddress']['houseNum'] ?>" required>
                                        </div>
                                        <div class="col-md-4 col-lg-12 col-xl-4">
                                            <input type="text" class="form-control mb-3" id="street" name="street" placeholder="Street" value="<?= $getuserData['residentialAddress']['street'] ?>" required>
                                        </div>
                                        <div class="col-md-4 col-lg-12 col-xl-4">
                                            <select class="form-select mb-3" id="barangay" name="barangay" aria-label="barangay-list" required>
                                                <option value="Bagumbayan" <?= ($getuserData['residentialAddress']['barangay'] == 'Bagumbayan') ? 'selected' : ''; ?>>Bagumbayan
                                                <option value="Balubad" <?= ($getuserData['residentialAddress']['barangay'] == 'Balubad') ? 'selected' : ''; ?>>Balubad
                                                <option value="Bambang" <?= ($getuserData['residentialAddress']['barangay'] == 'Bambang') ? 'selected' : ''; ?>>Bambang
                                                <option value="Matungao" <?= ($getuserData['residentialAddress']['barangay'] == 'Matungao') ? 'selected' : ''; ?>>Matungao
                                                <option value="Maysantol" <?= ($getuserData['residentialAddress']['barangay'] == 'Maysantol') ? 'selected' : ''; ?>>Maysantol
                                                <option value="Perez" <?= ($getuserData['residentialAddress']['barangay'] == 'Perez') ? 'selected' : ''; ?>>Perez
                                                <option value="Pitpitan" <?= ($getuserData['residentialAddress']['barangay'] == 'Pitpitan') ? 'selected' : ''; ?>>Pitpitan
                                                <option value="San Francisco" <?= ($getuserData['residentialAddress']['barangay'] == 'San Francisco') ? 'selected' : ''; ?>>San Francisco
                                                <option value="San Jose (Pob.)" <?= ($getuserData['residentialAddress']['barangay'] == 'San Jose (Pob.)') ? 'selected' : ''; ?>>San Jose (Pob.)
                                                <option value="San Nicolas" <?= ($getuserData['residentialAddress']['barangay'] == 'San Nicolas') ? 'selected' : ''; ?>>San Nicolas
                                                <option value="Santa Ana" <?= ($getuserData['residentialAddress']['barangay'] == 'Santa Ana') ? 'selected' : ''; ?>>Santa Ana
                                                <option value="Santa Ines" <?= ($getuserData['residentialAddress']['barangay'] == 'Santa Ines') ? 'selected' : ''; ?>>Santa Ines
                                                <option value="Taliptip" <?= ($getuserData['residentialAddress']['barangay'] == 'Taliptip') ? 'selected' : ''; ?>>Taliptip
                                                <option value="Tibig" <?= ($getuserData['residentialAddress']['barangay'] == 'Tibig') ? 'selected' : ''; ?>>Tibig
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <label for="residentdate" class="form-label">Residency Date</label>
                                <select class="form-select" id="residentdate" name="residencydate" aria-label="Default select example" required>
                                    <option value="1" <?= ($getuserData['residencyDate'] == '1') ? 'selected' : ''; ?>>Less than 6 months
                                    <option value="2" <?= ($getuserData['residencyDate'] == '2') ? 'selected' : ''; ?>>Greater than 6 Months
                                </select>
                                <div class="invalid-feedback">
                                    Please choose residency date.
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="occupation" class="form-label">Occupation</label>
                                    <input type="text" class="form-control" id="occupation" name="occupation" placeholder="Occupation" value="<?= ucwords($getuserData['occupation']) ?>" required>
                                    <div class="valid-feedback">
                                        Nice!
                                    </div>
                                    <div class="invalid-feedback">
                                        You dont have a job? Student?
                                    </div>
                                </div>

                            </div>

                            <div class="permaAddinput col-12 mb-3">
                                <label for="permanentAddress" class="form-label">Permanent Address</label>
                                <input type="text" class="form-control" id="permanentAddress" name="permanentaddress" aria-describedby="permanentAddressHelpBlock" value="<?= $getuserData['permanentAddress'] ?>" required>
                                <div class="invalid-feedback">
                                    Please enter your permanent address.
                                </div>
                                <div id="permanentAddressHelpBlock" class="form-text">
                                    (House # / Block / Street / Barangay / Municipality / Province)
                                </div>
                            </div>

                            <div class="newpassinput col-12 mb-3">
                                <label for="inputnewPassword" class="form-label">New Password</label>
                                <div class="input-group">
                                    <input type="password" id="inputnewPassword" name="password" class="form-control" oninput="newPassword(this)">
                                    <button type="button" class="btn btn-outline-secondary" onclick="togglePasswordVisibility('inputnewPassword')">
                                        <i id="passwordVisibilityIcon" class="fa-solid fa-eye-slash"></i>
                                    </button>
                                    <div class="invalid-feedback">Please enter a valid password.</div>
                                    <div class="invalid-feedback" id="passwordError"></div>
                                </div>

                            </div>

                            <div class="cfrmpassinput col-12 mb-3">
                                <label for="confirmPassword" class="form-label">Confirm password</label>
                                <div class="input-group">
                                    <input type="password" id="confirmPassword" name="confirmpassword" class="form-control" oninput="newPasswordConfirmation(this)">
                                    <button type="button" class="btn btn-outline-secondary" onclick="toggleretypePasswordVisibility('confirmPassword')">
                                        <i id="retypepasswordVisibilityIcon" class="fa-solid fa-eye-slash"></i>
                                    </button>
                                    <div class="invalid-feedback" id="confirmPasswordError">
                                    </div>
                                </div>
                            </div>


                            <div class="logoutbtn col-12">
                                <button class="btn btn-primary" name="update-profile" type="submit">Save Changes</button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="col-lg-12 col-xl-3">
                    <div class="p-3 py-5">
                        <form class="row needs-validation justify-content-lg-end justify-content-xl-start" novalidate="" method="POST" action="./api/editprofile.php" enctype="multipart/form-data">
                            <input type="hidden" name="uid" value="<?= $uid ?>">
                            <input type="hidden" name="key" value="<?= $key ?>">

                            <?php if (isset($getuserData['occupation']) && $getuserData['occupation'] !== 'Student' || $getuserData['occupation'] !== 'student') : ?>
                                <div class="col-lg-8 col-xl-12 mb-3">
                                    <label for="formFiledp" class="form-label">Upload Image</label>
                                    <input type="file" class="form-control" id="formFiledp" name="uploadimage" value="" required>
                                </div>

                                <div class="col-lg-8 col-xl-12">
                                    <div class="input-group">
                                        <select class="form-select" id="uploadTypeGroup" name="upload_type" required>
                                            <option value="" selected>Upload type</option>
                                            <option value="validID">Valid ID</option>
                                            <option value="displayPicture">Profile Picture</option>
                                        </select>
                                        <button class="btn btn-primary" name="upload-img" type="submit">Upload</button>
                                    </div>
                                </div>

                            <?php elseif (isset($getuserData['occupation']) && $getuserData['occupation'] == 'Student') : ?>
                                <div class="col-lg-8 col-xl-12 mb-3">
                                    <label for="formFiledp" class="form-label">Upload Image</label>
                                    <input type="file" class="form-control" id="formFiledp" name="uploadimage" value="" multiple required>
                                </div>

                                <div class="col-lg-8 col-xl-12">
                                    <div class="input-group">
                                        <select class="form-select" id="uploadTypeGroup" name="upload_type" required>
                                            <option value="" selected>Upload type</option>
                                            <option value="twosecondaryvalidID">2 Secondary ID</option>
                                            <option value="displayPicture">Profile Picture</option>
                                        </select>
                                        <button class="btn btn-primary" name="upload-img" type="submit">Upload</button>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </form>
                    </div>
                </div>
            </div>
        </div>
<?php
    }
} else {
    $_SESSION['failed_status'] = 'Invalid ID!';
    // header('location: index.php');
    exit();
}
?>