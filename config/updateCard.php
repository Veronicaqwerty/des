<?php
session_start();
include "dbcon.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    // Validate form data
    $id = $_POST['id'];
    $title = $_POST['title'];
    $caption = $_POST['caption'];

    // Prepare and bind the SQL statement
    $sql = "UPDATE cards SET title = ?, caption = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        // Bind parameters to the prepared statement
        mysqli_stmt_bind_param($stmt, "ssi", $title, $caption, $id);

        // Execute the prepared statement
        if (mysqli_stmt_execute($stmt)) {
            $_SESSION['success_message'] = "Card Item successfully updated!";
            header("Location: ../admin/index.php");
            exit();
        } else {
            $_SESSION['error_message'] = "Error updating record: " . mysqli_stmt_error($stmt);
            header("Location: ../admin/index.php");
            exit();
        }

        // Close the prepared statement
        mysqli_stmt_close($stmt);
    } else {
        $_SESSION['error_message'] = "Error preparing statement: " . mysqli_error($conn);
        header("Location: ../admin/index.php");
        exit();
    }
} else {
    // Redirect to home page if accessed directly without POST request or update button not set
    header("Location: ../index.php");
    exit();
}
?>
