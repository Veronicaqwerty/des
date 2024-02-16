<?php
session_start();
// Include your database connection file here
include "dbcon.php";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["update"])) {
    // Check if all required fields are set
    if (isset($_POST["id"], $_POST["title"], $_POST["caption"], $_POST["size"], $_POST["bgcolor"])) {
        // Retrieve form data
        $id = $_POST["id"];
        $title = $_POST["title"];
        $caption = $_POST["caption"];
        $size = $_POST["size"];
        $bgcolor = $_POST["bgcolor"];

        // Prepare and execute SQL query to update data in the table
        $sqlUpdate = "UPDATE grid SET title='$title', caption='$caption', size='$size', bgcolor='$bgcolor' WHERE id=$id";

        if (mysqli_query($conn, $sqlUpdate)) {
            $_SESSION['success_message'] = "Grid Item successfully updated!";
            header("Location: ../admin/index.php");
            exit();
        } else {
            $_SESSION['error_message'] = "Error: " . mysqli_error($conn);
            header("Location: ../admin/index.php");
            exit();
        }
    } else {
        $_SESSION['error_message'] = "All fields are required!";
        header("Location: ../admin/index.php");
        exit();
    }
} else {
    $_SESSION['error_message'] = "Invalid request method.";
    header("Location: ../index.php");
    exit();
}
?>
