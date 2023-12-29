<?php
include ('api/auth.php');
include ('api/authedituserfirst.php');
include ('api/authisPrinting.php');
include ('includes/header.php');

?>

<div class="requestForms py-3">
    <div class="container">
        <h1 class="mb-3 text-uppercase">Request a Form</h1>
        <div class="row">
            <div class="col-lg-4 col-md-6 mb-3">
                <a href="#" data-bs-toggle="modal" data-bs-target="#modalRequest" data-request-type="Barangay Clearance" class="text-decoration-none">
                    <div class="cardbody-style p-0">
                        <p class="text-center mb-0 file-icon">
                            <i class="fa-solid fa-file"></i>
                        </p>
                    </div>
                </a>
                <h4 class="text-center text-nowrap">Barangay Clearance</h4>
            </div>

            <div class="col-lg-4 col-md-6 mb-3">
                <a href="#" data-bs-toggle="modal" data-bs-target="#modalRequest" data-request-type="Barangay Indigency" class="text-decoration-none">
                    <div class="cardbody-style p-0">
                        <p class="text-center mb-0 file-icon">
                            <i class="fa-solid fa-file"></i>
                        </p>
                    </div>
                </a>
                <h4 class="text-center text-nowrap">Barangay Indigency</h4>
            </div>

            <div class="col-lg-4 col-md-6 mb-3">
                <a href="#" data-bs-toggle="modal" data-bs-target="#modalRequest" data-request-type="Electrical" class="text-decoration-none">
                    <div class="cardbody-style p-0">
                        <p class="text-center mb-0 file-icon">
                            <i class="fa-solid fa-file"></i>
                        </p>
                    </div>
                </a>
                <h4 class="text-center text-nowrap">Electrical</h4>
            </div>

            <div class="col-lg-4 col-md-6 mb-3">
                <a href="#" data-bs-toggle="modal" data-bs-target="#modalRequest" data-request-type="Barangay ID" class="text-decoration-none">
                    <div class="cardbody-style p-0">
                        <p class="text-center mb-0 file-icon">
                            <i class="fa-solid fa-file"></i>
                        </p>
                    </div>
                </a>
                <h4 class="text-center text-nowrap">Barangay ID</h4>
            </div>

            <div class="col-lg-4 col-md-6 mb-3">
                <a href="#" data-bs-toggle="modal" data-bs-target="#modalRequest" data-request-type="Certificate of Residency" class="text-decoration-none">
                    <div class="cardbody-style p-0">
                        <p class="text-center mb-0 file-icon">
                            <i class="fa-solid fa-file"></i>
                        </p>
                    </div>
                </a>
                <h4 class="text-center text-nowrap">Certificate of Residency</h4>
            </div>

            <div class="col-lg-4 col-md-6 mb-3">
                <a href="#" data-bs-toggle="modal" data-bs-target="#modalRequest" data-request-type="Barangay Cedula" class="text-decoration-none">
                    <div class="cardbody-style p-0">
                        <p class="text-center mb-0 file-icon">
                            <i class="fa-solid fa-file"></i>
                        </p>
                    </div>
                </a>
                <h4 class="text-center text-nowrap">Barangay Cedula</h4>    
            </div>
        </div>
    </div>
    <?php 
        include ('includes/modal.php')
    ?>
</div>

<script>
    // Modal Display user clicked
    // Get the element
    const modalRequest = document.querySelector("#modalRequest");

    // Get the element inside the modal where you want to display the selected option
    const RequestLabel = document.querySelector("#modalRequestLabel");

    // Attach an event listener to the modal when it's shown
    modalRequest.addEventListener("show.bs.modal", function (event) {
        // Get the anchor tag that triggered the modal
        var link = event.relatedTarget;

        // Get the value of the data-request-type attribute
        var requestType = link.getAttribute("data-request-type");

        // Set the selected option in the modal
        RequestLabel.textContent = requestType + " Request Form";

        var requestTypeInput = document.getElementById("requestType");
        requestTypeInput.value = requestType;
    });

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
</script>

<?php
include ('includes/footer.php');
?>