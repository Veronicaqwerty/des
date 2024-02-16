<?php
session_start();
include "dbcon.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_id'])) {
    $delete_id = $_POST['delete_id'];

    // Delete the data from the database
    $delete_sql = "DELETE FROM messages WHERE id = $delete_id";
    if ($conn->query($delete_sql) === TRUE) {
        $_SESSION['success_message'] = "Inbox deleted successfully!";
        header("Location: ../admin/inbox.php");
        exit();
    } else {
        $_SESSION['error_message'] = "Error deleting message with ID $delete_id: " . $conn->error;
        header("Location: ../admin/inbox.php");
        exit();
    }
}

// Close the database connection
$conn->close();
?>
