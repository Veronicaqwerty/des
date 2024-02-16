<?php
session_start();
include "dbcon.php";
// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["update"])) {
    // Check if all required fields are set
    if (isset($_POST["id"], $_POST["caption"], $_POST["subtitle"])) {
        $id = $_POST["id"];
        $caption = $_POST["caption"];
        $subtitle = $_POST["subtitle"];

        // Update the carousel table
        $sql = "UPDATE carousel SET caption = '$caption', subtitle = '$subtitle' WHERE id = '$id'";

        if (mysqli_query($conn, $sql)) {
              $_SESSION['success_message'] = "Carousel item updated successfully!";
              header("Location: ../admin/index.php");
              exit();
        } else {
            $_SESSION['error_message'] = "Error updating record: " . mysqli_error($conn);
            header("Location: ../admin/index.php");
            exit();
        }
    } else {
         $_SESSION['error_message'] = "All fields are required!";
         header("Location: ../admin/index.php");
         exit();
    }
}
?>
