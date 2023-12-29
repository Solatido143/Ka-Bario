</div>

<!-- JS -->

<script src="js/firebaseSDK.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Function to close the toast after a certain amount of time (e.g., 3000 milliseconds or 3 seconds)
        function closeToast(toastElement, index) {
            if (toastElement) {
                setTimeout(() => {
                    // Hide the toast after 3 seconds
                    toastElement.classList.remove('show');
                    toastElement.classList.add('hide');
                }, 3000 * (index + 1)); // Adjust the delay based on the index
            }
        }

        // Select all elements with the class 'my-toast'
        const toasts = document.querySelectorAll('.my-toast');

        // Iterate over each toast and call the function to close it
        toasts.forEach(function(toast, index) {
            closeToast(toast, index);
        });


        // Get the notification link element
        var notificationLink = document.getElementById('notificationLink');

        // Attach a click event listener to the notification link
        notificationLink.addEventListener('click', function() {
            // Remove the notification dot
            var notifDot = document.getElementById('notifDot');
            if (notifDot) {
                notifDot.remove();
            }
        });
    });

    function markAllAsRead() {
        // AJAX request to update the database
        $.ajax({
            type: 'POST',
            url: 'api/code.php', // Replace with the actual PHP script to handle the update
            data: {
                markAllRead: true
            }, // Additional data you want to send to the server
            success: function(response) {
                // Handle the response from the server (if needed)
                console.log(response);

                // After successfully marking all as read, you might want to update the DOM or perform any other actions
            },
            error: function(error) {
                // Handle errors (if needed)
                console.error(error);
            }
        });
    }
</script>



<script>
    // Get the full URL of the current page
    var currentURL = window.location.href;

    // Split the URL by '/' and get the last part (the page name)
    var urlParts = currentURL.split('/');
    var pageName = urlParts[urlParts.length - 1];
</script>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>


</body>

</html>