<?php if (basename($_SERVER['PHP_SELF']) == 'index.php') : ?>
    <!-- Login Modal -->
    <div class="modal fade" id="modalLogin" tabindex="-1" aria-labelledby="ModalLoginLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header flex-column-reverse">
                    <h1 class="modal-title fs-5 text-center" id="ModalLoginLabel">Login</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="needs-validation" novalidate="" action="api/logincode.php" method="POST" id="loginForm">
                        <div class="form-floating mb-3">
                            <input type="email" class="form-control" id="floatingInputEmail loginEmail" name="email" placeholder="Email or Phone" required>
                            <label for="floatingInputEmail">Email</label>
                            <div class="invalid-feedback">
                                Enter an email.
                            </div>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="password" class="form-control" id="floatingPassword loginPassword" placeholder="Password" name="password" required>
                            <label for="floatingPassword">Password</label>
                            <div class="invalid-feedback">
                                Enter a password.
                            </div>
                        </div>
                        <div class="container-fluid d-flex justify-content-center">
                            <button type="submit" name="login-btn" class="btn btn-primary w-100">Login</button>
                        </div>
                    </form>
                </div>
                <div class="modal-footer justify-content-center">
                    <p class="text-center"> Don't have an account? <a href="#" id="signupModalLink" data-bs-toggle="modal" data-bs-target="#modalSignup">Sign Up</a></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Signup Modal -->
    <div class="modal fade" id="modalSignup" tabindex="-1" aria-labelledby="ModalSignupLabel" aria-hidden="true">

        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">

            <div class="modal-content">

                <div class="modal-header flex-column-reverse">
                    <h1 class="modal-title fs-5 text-center" id="ModalSignupLabel">Signup</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <form class="needs-validation" novalidate="" action="api/signupcode.php" method="POST" id="signupForm">
                        <div class="container-fluid p-0">
                            <div class="row">

                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="Fname" class="form-label">First name</label>
                                        <input type="text" class="form-control" id="Fname" name="firstname" placeholder="John" required>
                                        <div class="invalid-feedback">
                                            Please enter your first name.
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="Lname" class="form-label">Last name</label>
                                        <input type="text" class="form-control" id="Lname" name="lastname" placeholder="Doe" required>
                                        <div class="invalid-feedback">
                                            Please enter your last name
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="phoneNumber" class="form-label">Phone number</label>
                                        <input type="text" class="form-control" id="phoneNumber" name="phonenumber" placeholder="09123456789" required pattern="[0-9]{11}">
                                        <div class="invalid-feedback">
                                            Please enter a valid phone number.
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="signUpeMail" class="form-label">Email address</label>
                                        <input type="email" class="form-control" id="signUpeMail" name="emailaddress" placeholder="name@example.com" required>
                                        <div class="invalid-feedback">
                                            Please enter a valid email address.
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="mb-3">
                                        <label for="residentialAddress" class="form-label">Residential Address</label>
                                        <div class="row" id="residentialAddress">
                                            <div class="col-lg-4 col-12">
                                                <input type="text" class="form-control mb-3" id="houseno" name="housenum" placeholder="House No." required>
                                            </div>
                                            <div class="col-lg-4 col-12">
                                                <input type="text" class="form-control mb-3" id="street" name="street" placeholder="Street" required>
                                            </div>
                                            <div class="col-lg-4 col-12">
                                                <select class="form-select mb-3" id="barangay" name="barangay" aria-label="barangay-list" required>
                                                    <option value="" selected>Select Barangay
                                                    <option value="Bagumbayan">Bagumbayan
                                                    <option value="Balubad">Balubad
                                                    <option value="Bambang">Bambang
                                                    <option value="Matungao">Matungao
                                                    <option value="Maysantol">Maysantol
                                                    <option value="Perez">Perez
                                                    <option value="Pitpitan">Pitpitan
                                                    <option value="San Francisco">San Francisco
                                                    <option value="San Jose (Pob.)">San Jose (Pob.)
                                                    <option value="San Nicolas">San Nicolas
                                                    <option value="Santa Ana">Santa Ana
                                                    <option value="Santa Ines">Santa Ines
                                                    <option value="Taliptip">Taliptip
                                                    <option value="Tibig">Tibig
                                                </select>
                                            </div>
                                            <div class="col">
                                                <select class="form-select" name="residencydate" aria-label="Default select example" required>
                                                    <option value="" selected>Residency date</option>
                                                    <option value="1">Less than 6 months</option>
                                                    <option value="2">Greater than 6 Months</option>
                                                </select>
                                                <div class="invalid-feedback">
                                                    Please choose residency date.
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 mb-3">
                                    <label for="permanentAddress" class="form-label">Permanent Address</label>
                                    <input type="text" class="form-control" id="permanentAddress" name="permanentaddress" aria-describedby="permanentAddressHelpBlock" required>
                                    <div class="invalid-feedback">
                                        Please enter your permanent address.
                                    </div>
                                    <div id="permanentAddressHelpBlock" class="form-text">
                                        (House # / Block / Street / Barangay / Municipality / Province)
                                    </div>

                                </div>

                                <div class="col-12 mb-3 d-none">
                                    <label for="formFile" class="form-label d-none">Upload an ID</label>
                                    <input type="hidden" class="form-control" id="formFile" name="identification" value="">
                                </div>

                                <div class="col-12 mb-3">
                                    <label for="inputSignupPassword" class="form-label">Password</label>
                                    <input type="password" id="inputSignupPassword" name="password" class="form-control" aria-describedby="passwordHelpBlock" required oninput="validatePassword(this)">
                                    <div class="invalid-feedback">
                                        Please enter a valid password.
                                    </div>
                                    <div id="passwordHelpBlock" class="form-text">
                                        Your password must be 8-20 characters long and include a mix of uppercase and lowercase letters, numbers, and special characters.
                                    </div>
                                    <div id="passwordStrength" class="form-text" style="display: none;">
                                        Password strength: <span id="strengthIndicator"></span>
                                    </div>
                                    <div id="lengthIndicator" class="form-text" style="display: none;"></div>
                                    <div id="uppercaseLowercaseIndicator" class="form-text" style="display: none;"></div>
                                    <div id="numberIndicator" class="form-text" style="display: none;"></div>
                                    <div id="specialCharacterIndicator" class="form-text" style="display: none;"></div>
                                </div>

                                <div class="col-12 mb-3">
                                    <label for="inputConfirmPassword" class="form-label">Confirm Password</label>
                                    <input type="password" id="inputConfirmPassword" name="confirmPassword" class="form-control" required oninput="validateConfirmPassword(this)">
                                    <div id="confirmPasswordIndicator" class="form-text" style="display: none;"></div>
                                </div>

                                <div class="col-12 mb-3 d-flex justify-content-center align-items-center">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" required>
                                        <label class="form-check-label" for="flexCheckDefault">
                                            I agree to the <a href="#" data-bs-toggle="modal" data-bs-target="#modalTermsNPrivacy">Terms of Service</a> and <a href="#" data-bs-toggle="modal" data-bs-target="#modalTermsNPrivacy">Privacy Policy</a>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="container-fluid d-flex justify-content-center">
                                <button type="submit" name="register-btn" class="register-btn btn btn-primary w-100">Register</button>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="modal-footer justify-content-center">
                    <p class="text-center"> Already have an account?&nbsp<a href="#" id="loginModalLink" data-bs-toggle="modal" data-bs-target="#modalLogin">Click here!</a></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Terms and Services / Privacy Policy -->
    <div class="modal fade" id="modalTermsNPrivacy" tabindex="-1" aria-labelledby="modalTermsNPrivacy" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header d-block">
                    <div class="flex flex-column text-center">
                        <h1 class="modal-title fs-5" id="modalTermsNPrivacyLabel">Terms and Conditions</h1>
                        <p class="text-dark-emphasis mb-0">for Online Document Processing and Requesting</p>
                    </div>
                </div>
                <div class="modal-body">
                    <p>
                        1. <b>Acceptance of Terms</b><br>
                        By using our online document processing and requesting service (Ka-Bario), you agree to comply with and be bound by these terms and conditions.
                        <br><br>
                        2. <b>User Registration</b><br>
                        a. Users must register and provide accurate information.<br>
                        b. Users are responsible for maintaining the confidentiality of their account information.
                        <br><br>
                        3. <b>Document Requests</b><br>
                        a. Users may request documents through the Service.<br>
                        b. Users must provide accurate and complete information for document processing.
                        <br><br>
                        4. <b>Fees and Payments</b><br>
                        a. Users agree to pay any applicable fees for document processing and delivery.<br>
                        b. Payments are non-refundable unless otherwise specified.
                        <br><br>
                        5. <b>Processing Time</b><br>
                        a. The processing time for documents may vary.<br>
                        b. Users agree to allow sufficient time for processing.
                        <br><br>
                        6. <b>Document Accuracy</b><br>
                        a. We make every effort to provide accurate documents.<br>
                        b. Users are responsible for verifying the accuracy of the documents received.
                        <br><br>
                        7. <b>Privacy</b><br>
                        a. User data may be collected and processed as outlined in the Privacy Policy.<br>
                        b. Users consent to the collection and processing of their data.
                        <br><br>
                        8. <b>Intellectual Property</b><br>
                        a. Documents provided through the Service are for personal use only.<br>
                        b. Users may not reproduce or distribute documents without permission.
                        <br><br>
                        9. <b>Disclaimers</b><br>
                        a. The Service is provided "as is" without warranties of any kind.<br>
                        b. We assume no responsibility for the use of documents obtained through the Service.
                        <br><br>
                        10. <b>Limitation of Liability</b><br>
                        a. We shall not be liable for any damages arising from the use of the Service.<br>
                        b. Users agree to indemnify and hold us harmless from any claims.
                        <br><br>
                        11. <b>Termination</b><br>
                        a. We may terminate or suspend user accounts for violation of these terms.<br>
                        b. Users may terminate their account at any time.
                        <br><br>
                        12. <b>Governing Law</b><br>
                        a. These terms and conditions shall be governed by the laws of [Jurisdiction].<br>
                        b. Any disputes shall be resolved in the [Jurisdiction] courts.
                        <br><br>
                        13. <b>Modifications</b><br>
                        a. We reserve the right to modify these terms and conditions.<br>
                        b. Users will be notified of changes, and continued use implies acceptance.
                        <br><br>
                        14. <b>Contact</b><br>
                        For questions or concerns about these terms, contact [Contact Information].
                        <br><br>
                        By using the Ka-Bario, you acknowledge that you have read, understood, and agreed to these terms and conditions.
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="cancelTermsNConditions" data-bs-toggle="modal" data-bs-target="#modalSignup">Cancel</button>
                    <button type="button" class="btn btn-primary" id="acceptTermsNConditions" data-bs-toggle="modal" data-bs-target="#modalSignup">Accept</button>
                </div>
            </div>
        </div>
    </div>

<?php elseif (basename($_SERVER['PHP_SELF']) == 'barangayhome.php') : ?>

    <div class="modal fade" id="modalRequest" tabindex="-1" aria-labelledby="modalRequestLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">

                <div class="modal-header flex-column-reverse">
                    <h1 class="modal-title fs-5 text-center" id="modalRequestLabel">Request form</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form class="needs-validation" novalidate="" action="api/requestdocs.php" method="POST" id="reqForm">
                    <div class="modal-body">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="floatingInputPurpose loginPurpose" name="purpose" placeholder="Purpose" required>
                            <label for="floatingInputPurpose">Purpose</label>
                            <div class="invalid-feedback">
                                Requires a purpose.
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="otherpurposetextarea" class="form-label">Other purpose <span class="text-dark-emphasis">(optional)</span></label>
                            <textarea class="form-control" id="otherpurposetextarea" name="otherpurposetextarea" rows="3" placeholder=""></textarea>
                        </div>
                        <div>
                            <input type="hidden" name="requestType" id="requestType" value="">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="container-fluid d-flex justify-content-center">
                            <button type="submit" name="sendRequest" class="btn btn-primary w-100">Send</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

<?php endif ?>