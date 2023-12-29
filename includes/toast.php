<div class='toast-container p-3 top-0 start-0' id='toastPlacement' data-original-class='toast-container p-3'>
    <?php
    if (isset($_SESSION['failed_status'])) {
        echo
        "<div class='toast fade show align-items-center text-bg-danger border-0 my-toast' role='alert' aria-live='assertive' aria-atomic='true' id='myToast'>
            <div class='d-flex'>
                <div class='toast-body'>
                " . $_SESSION['failed_status'] . "
                </div>
                <button type='button' class='btn-close me-2 m-auto' data-bs-dismiss='toast' aria-label='Close'></button>
            </div>
        </div>";
        unset($_SESSION['failed_status']);
    }

    if (isset($_SESSION['status']) || isset($_SESSION['document_printed_status']) || isset($_SESSION['verified_status'])) {
    ?>
        <?php if (isset($_SESSION['status'])) : ?>

            <div class='toast fade show align-items-center text-bg-success border-0 my-toast' role='alert' aria-live='assertive' aria-atomic='true' id='myToast'>
                <div class='d-flex'>
                    <div class='toast-body'>
                        <?= $_SESSION['status'] ?>
                    </div>
                    <button type='button' class='btn-close me-2 m-auto' data-bs-dismiss='toast' aria-label='Close'></button>
                </div>
            </div>


        <?php endif; ?>

        <?php if (isset($_SESSION['document_printed_status'])) : ?>

            <div class='toast fade show align-items-center text-bg-success border-0 my-toast' role='alert' aria-live='assertive' aria-atomic='true' id='myToast'>
                <div class='d-flex'>
                    <div class='toast-body'>
                        <?= $_SESSION['document_printed_status'] ?>
                    </div>
                    <button type='button' class='btn-close me-2 m-auto' data-bs-dismiss='toast' aria-label='Close'></button>
                </div>
            </div>

        <?php endif; ?>

        <?php if (isset($_SESSION['verified_status'])) : ?>

            <div class='toast fade show align-items-center text-bg-success border-0 my-toast' role='alert' aria-live='assertive' aria-atomic='true' id='myToast'>
                <div class='d-flex'>
                    <div class='toast-body'>
                        <?= $_SESSION['verified_status'] ?>
                    </div>
                    <button type='button' class='btn-close me-2 m-auto' data-bs-dismiss='toast' aria-label='Close'></button>
                </div>
            </div>

        <?php endif; ?>
    <?php
        unset($_SESSION['status']);
        unset($_SESSION['verified_status']);
        unset($_SESSION['document_printed_status']);
    }

    if (isset($_SESSION['document_status']) || isset($_SESSION['warning_status'])) {
    ?>
        <?php if (isset($_SESSION['document_status'])) : ?>

            <div class='toast fade show align-items-center text-bg-warning border-0 my-toast' role='alert' aria-live='assertive' aria-atomic='true' id='myToast'>
                <div class='d-flex'>
                    <div class='toast-body'>
                        <?= $_SESSION['document_status'] ?>
                    </div>
                    <button type='button' class='btn-close me-2 m-auto' data-bs-dismiss='toast' aria-label='Close'></button>
                </div>
            </div>

        <?php endif; ?>

        <?php if (isset($_SESSION['warning_status'])) : ?>

            <div class='toast fade show align-items-center text-bg-warning border-0 my-toast' role='alert' aria-live='assertive' aria-atomic='true' id='myToast'>
                <div class='d-flex'>
                    <div class='toast-body'>
                        <?= $_SESSION['warning_status'] ?>
                    </div>
                    <button type='button' class='btn-close me-2 m-auto' data-bs-dismiss='toast' aria-label='Close'></button>
                </div>
            </div>

        <?php endif; ?>
    <?php
        unset($_SESSION['document_status']);
        unset($_SESSION['warning_status']);
    }
    ?>
</div>