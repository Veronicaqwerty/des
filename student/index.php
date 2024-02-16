
<?php
session_start();
include "../config/dbcon.php";



if (!isset($_SESSION['username'])) {

    $_SESSION['alert_message'] = "YOU MUST LOGIN FIRST TO CONTINUE";
    header("Location: ../index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <title>Student Portal</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/5.0/examples/navbars/">
    <link rel="icon" href="img/cookie.png" type="image/png">
    <link href="../assets/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.14.0/css/all.css">
     <link rel="canonical" href="https://getbootstrap.com/docs/5.1/examples/cheatsheet/">
    <style>
        .card {
            margin-bottom: 20px;
        }

        .card-img-top {
            height: 200px;
            padding: 10px;
        }

        .card-button {
            width: 50px;
            height: 40px;
        }
    </style>
</head>
<body>
    <?php
    include "../includes/studentNavbar.php";
    ?>
    <div class="col-sm p-3 min-vh-100">
        <div class="shadow p-3 mb-5 bg-body rounded">
            <div class="container mt-3 text-center">
                <h2> Welcome to Sample University </h2>
                <p> Digital Enrollement System </p>
            </div>
        </div>
   </div>



<script src="../assets/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
