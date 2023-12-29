            </div>
        </div>
    </div>
</div>

<!-- Include jQuery from a CDN -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

<!-- JS -->
<script>
    $(document).ready(function () {
        $('a[data-bs-toggle="tab"]').on('shown.bs.tab', function (e) {
            var targetTab = $(e.target).attr("href"); // activated tab
            console.log("Switching to tab:", targetTab);

            // Fade out all tabs and then fade in the target tab
            $(".tab-pane").fadeOut(300, function () {
                $(targetTab).fadeIn(300);
            });
        });
    });

</script>

<script>
    function setFormTarget(event) {
        var form = event.target;
        var clickedButton = event.submitter;

        if (clickedButton && clickedButton.name === 'printdocument') {
            form.target = '_blank';
        } else {
            form.target = '_self'; // or you can remove the target attribute
        }
    }
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Function to close the toast after a certain amount of time (e.g., 3000 milliseconds or 3 seconds)
        function closeToast() {
            const toast = document.querySelector('.my-toast');
            if (toast) {
                setTimeout(() => {
                    // Hide the toast after 3 seconds
                    toast.classList.remove('show');
                    toast.classList.add('hide');
                }, 3000);
            }
        }

        // Call the function to close the toast
        closeToast();

    });
</script>

<script>
    // Get the full URL of the current page
    var currentURL = window.location.href;

    // Split the URL by '/' and get the last part (the page name)
    var urlParts = currentURL.split('/');
    var pageName = urlParts[urlParts.length - 1];
</script>

<script>
        // Initialize DataTables
        $(document).ready(function() {
            $('#logsTable').DataTable({
                "order": [[0, 'desc']] // Order by the first column (ID) in descending order
            });
            
        });
    </script>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
<!-- Include jQuery and DataTables JS -->
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
</body>

</html>