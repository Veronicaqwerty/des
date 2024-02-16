<?php
session_start();
include "dbcon.php";

// Check if the form is submitted and delete button is clicked
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["delete"])) {
    // Check if the image id is set
    if (isset($_POST["id"])) {
        $id = $_POST["id"];

        // Delete the image from the carousel table
        $sql = "DELETE FROM carousel WHERE id = '$id'";

        if (mysqli_query($conn, $sql)) {
               $_SESSION['success_message'] = "Carousel item deleted successfully!";
        } else {
            $_SESSION['success_message'] = "Error deleting record: " . mysqli_error($conn);
        }
        // Redirect back to index.php
        header("Location: ../admin/index.php");
        exit();
    } else {
        $_SESSION['success_message'] = "Image ID is required!";
        // Redirect back to index.php
        header("Location: ../admin/index.php");
        exit();
    }
}
?>
