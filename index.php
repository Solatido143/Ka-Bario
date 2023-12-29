<?php
session_start();
include('api/authIsPrinting.php');
include('includes/header.php');
?>

<?php
include('includes/content.php');
?>

<?php if (!isset($_SESSION['verified_user_id'])) : ?>
    <!-- JS -->
    <script src="js/validation.js"></script>
    <script>
        document.getElementById('acceptTermsNConditions').addEventListener('click', function() {
            // Get the checkbox element
            const checkbox = document.getElementById('flexCheckDefault');

            // Check the checkbox when the button is clicked
            checkbox.checked = true;
        });
        document.getElementById('cancelTermsNConditions').addEventListener('click', function() {
            // Get the checkbox element
            const checkbox = document.getElementById('flexCheckDefault');

            // Check the checkbox when the button is clicked
            checkbox.checked = false;
        });
    </script>
<?php endif; ?>


<?php
include('includes/footer.php');
?>