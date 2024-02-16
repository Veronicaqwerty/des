<?php
session_start();
include "dbcon.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete'])) {
    // Get the ID of the card to delete
    $id = $_POST['id'];

    // Delete the card from the database
    $sql = "DELETE FROM cards WHERE id = '$id'";
    if (mysqli_query($conn, $sql)) {
         $_SESSION['success_message'] = "Card item deleted successfully!";
    } else {
        $_SESSION['success_message'] = "Error deleting record: " . mysqli_error($conn);
    }
    // Redirect back to index.php
    header("Location: ../admin/index.php");
    exit();
} else {
    // Redirect to home page if accessed directly without POST request or delete button not set
    header("Location: ../index.php");
    exit();
}
?>
