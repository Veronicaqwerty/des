<?php
session_start();
// Handle logout
if (isset($_POST['logout'])) {
    // Unset all session variables
    $_SESSION = array();

    // Destroy the session
    if (session_destroy()) {
        // Redirect to the login page or any other desired page after logout
        header("Location: ../index.php");
        exit(); // Ensure that script execution stops after redirect
    } else {
        // Error occurred while destroying the session
        echo "Error: Session destruction failed.";
        // You can also log the error for further investigation
        // error_log("Error: Session destruction failed.", 0);
        exit(); // Exit script execution
    }
} else {
   
}
?>

