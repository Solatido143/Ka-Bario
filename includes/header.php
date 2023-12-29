<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- CSS only -->
    <link rel="stylesheet" href="css/index.css">
    <style>
        /* X-Small devices (landscape phones, 320px and up) */
        @media (min-width: 320px) {}

        /* Small devices (landscape phones, 576px and up) */
        @media (min-width: 576px) {}

        /* Medium devices (tablets, 768px and up) */
        @media (min-width: 768px) {}

        /* Large devices (desktops, 992px and up) */
        @media (min-width: 992px) {
            .border-lg-end {
                border-right: 1px solid #dee2e6;
            }
        }

        /* X-Large devices (large desktops, 1200px and up) */
        @media (min-width: 1200px) {}

        /* XX-Large devices (larger desktops, 1400px and up) */
        @media (min-width: 1400px) {}

        .services-body {
            transition: all .3s ease-out 0s;
        }

        .services-body:hover {
            background-color: rgba(215, 213, 213, 0.904);
        }

        .file-icon {
            font-size: 8.5rem;
            -webkit-text-stroke: 2px black;
            /* WebKit browsers */
            text-stroke: 2px black;
        }
    </style>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">

    <!--Fontawesome-->
    <script src="https://kit.fontawesome.com/cf9a2f60ee.js" crossorigin="anonymous"></script>

    <!-- Include jQuery from a CDN -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>


    <link rel="icon" type="image/x-icon" href="./pictures/KABARIO transparent.png">
    <title>Ka-Bario</title>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const nav = document.querySelector('nav'); // Change the selector if necessary
            const navHeight = nav.clientHeight; // Get the computed height of the nav element

            // Update the custom property value
            document.documentElement.style.setProperty('--navbar-height', `${navHeight}px`);

            // Get the list of navigation links
            const navLinks = document.querySelectorAll('#navList .nav-link');

            // Add a click event listener to each navigation link
            navLinks.forEach(link => {
                link.addEventListener('click', (e) => {
                    // Remove the "active" class from all navigation links
                    navLinks.forEach(link => {
                        link.classList.remove('active');
                    });

                    // Add the "active" class to the clicked navigation link
                    link.classList.add('active');
                });
            });
        });
    </script>


</head>

<body id="top">
    <?php include('navbar.php') ?>

    <div class="content position-relative" aria-live="polite" aria-atomic="true">
        <?php
        include('toast.php')
        ?>