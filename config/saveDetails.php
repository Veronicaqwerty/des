<?php
session_start();
// Include your database connection file here
include "dbcon.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $id = 1;
    $name = $_POST["name"];
    $location = $_POST["location"];
    $email = $_POST["email"];
    $mobileNumber = $_POST["mobileNumber"];
    $telephoneNumber = $_POST["telephoneNumber"];
    $description = $_POST["description"];

    // Prepare and execute SQL query to update data in the table
    $sqlUpdate = "UPDATE informations SET name='$name',location='$location', email='$email', mobnumber='$mobileNumber', telnumber='$telephoneNumber', description='$description' WHERE id='$id'";

    if (mysqli_query($conn, $sqlUpdate)) {
          $_SESSION['success_message'] = "New information successfully updated!";
          header("Location: ../admin/index.php");
          exit();
    } else {
        $_SESSION['error_message'] = "Error: " . mysqli_error($conn);
        header("Location: ../admin/index.php");
        exit();
    }
} else {
    $_SESSION['error_message'] = "Invalid request method.";
    header("Location: ../admin/index.php");
    exit();
}
?>
