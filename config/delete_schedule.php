
<?php
// Include the database configuration file
include 'dbcon.php';

// Check if schedule_id is set and not empty
if(isset($_POST['schedule_id']) && !empty($_POST['schedule_id'])) {
    // Sanitize schedule_id to prevent SQL injection
    $schedule_id = mysqli_real_escape_string($conn, $_POST['schedule_id']);

    // SQL to delete record
    $sql = "DELETE FROM enrollment_schedule WHERE id = $schedule_id";

    if ($conn->query($sql) === TRUE) {
        // Record deleted successfully
        // Redirect back to enrollment.php with success message
        header("Location: ../admin/enrollment.php");
        exit();
    } else {
        // Error deleting record
        echo "Error deleting record: " . $conn->error;
    }
} else {
    // Redirect to enrollment.php if schedule_id is not set or empty
    header("Location: ../admin/enrollment.php");
    exit();
}

// Close database connection
$conn->close();
?>