<?php
session_start();
// Include your database connection file here
include "dbcon.php";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $title = $_POST["title"];
    $caption = $_POST["caption"];
    $size = $_POST["size"];
    $bgcolor = $_POST["bgcolor"];

    // Prepare and execute SQL query to insert data into the table
    $sqlInsert = "INSERT INTO grid (title, caption, size, bgcolor) VALUES ('$title', '$caption', '$size', '$bgcolor')";

    if (mysqli_query($conn, $sqlInsert)) {
         $_SESSION['success_message'] = "Grid item successfully added!";
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
