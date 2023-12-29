<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- CSS only -->
    <link rel="stylesheet" href="../css/index.css">
    <style>
        /* X-Small devices (landscape phones, 320px and up) */
        @media (min-width: 320px) {}
        /* Small devices (landscape phones, 576px and up) */
        @media (min-width: 576px) {}
        /* Medium devices (tablets, 768px and up) */
        @media (min-width: 768px) {} 
        /* Large devices (desktops, 992px and up) */
        @media (min-width: 992px) {}
        /* X-Large devices (large desktops, 1200px and up) */
        @media (min-width: 1200px) {}
        /* XX-Large devices (larger desktops, 1400px and up) */
        @media (min-width: 1400px) {}

        
    </style>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    
    <!--Fontawesome-->
    <script src="https://kit.fontawesome.com/cf9a2f60ee.js" crossorigin="anonymous"></script>

    <!-- Include jQuery from a CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    
    <link rel="icon" type="image/x-icon" href="../pictures/KABARIO transparent.png">
    <title>Ka-Bario | View ID</title>
    

</head>
<body id="top" class="m-0 border-0 bd-example m-0 border-0">
    <?php
        include ('api/admin_auth.php');
        include ('../api/dbcon.php');
        if (isset($_GET['uid']) && isset($_GET['key'])) {
            $uid = $_GET['uid'];
            $key = $_GET['key'];

            $ref_tbl = 'users';
            $reference = $database->getReference($ref_tbl);
            $user_data = $reference->getChild($key)->getValue();
            if ($user_data['validID']) {
                $_SESSION['has_validID'] = $user_data['validID'];
                header('location: verify_user.php');
                exit();
            } else {
                $_SESSION['failed_status'] = $uid->displayName . "Don't have Valid ID";
                header('location: verify_user.php');
                exit();
            }
        }
    ?>
<?php
include('includes/footer.php');
?>