<?php
include "dbcon.php";

// Check if the message_id is set in the POST request
if(isset($_POST['message_id'])) {
    // Sanitize the input to prevent SQL injection
    $messageId = mysqli_real_escape_string($conn, $_POST['message_id']);

    // Update the status of the specific message to 'read'
    $sql = "UPDATE messages SET status = 'read' WHERE id = '$messageId'";
    
    if ($conn->query($sql) === TRUE) {
        // If the update was successful, set a success message in the session
        $_SESSION['success_message'] = "Message marked as read";
    } else {
        // If there was an error updating the status, set an error message in the session
        $_SESSION['error_message'] = "Error updating message: " . $conn->error;
    }
} else {
    // If message_id is not set, redirect back to the inbox page
    $_SESSION['error_message'] = "Message ID not provided";
}

// Close the database connection
$conn->close();

// Redirect back to the inbox page
header("Location: inbox.php");
exit();
?>
