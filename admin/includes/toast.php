<div class='toast-container p-3 top-0 end-0' id='toastPlacement' data-original-class='toast-container p-3'>
<?php
    if(isset($_SESSION['status'])) {
        echo 
        "<div class='toast fade show align-items-center text-bg-success border-0 my-toast' role='alert' aria-live='assertive' aria-atomic='true' id='myToast'>
            <div class='d-flex'>
                <div class='toast-body'>
                ".$_SESSION['status']."
                </div>
                <button type='button' class='btn-close me-2 m-auto' data-bs-dismiss='toast' aria-label='Close'></button>
            </div>
        </div>";
        unset($_SESSION['status']);
    }
    if(isset($_SESSION['failed_status'])) {
        echo 
        "<div class='toast fade show align-items-center text-bg-danger border-0 my-toast' role='alert' aria-live='assertive' aria-atomic='true' id='myToast'>
            <div class='d-flex'>
                <div class='toast-body'>
                ".$_SESSION['failed_status']."
                </div>
                <button type='button' class='btn-close me-2 m-auto' data-bs-dismiss='toast' aria-label='Close'></button>
            </div>
        </div>";
        unset($_SESSION['failed_status']);
    }
?>
</div>