
<?php
// Include the database configuration file
include 'dbcon.php';

// Check if enrollment ID and status are set in the request
if (isset($_POST['id']) && isset($_POST['status'])) {
    // Sanitize input to prevent SQL injection
    $enrollmentId = $_POST['id'];
    $status = $_POST['status'];

    // Update status in the database
    $sql = "UPDATE enrollment_info SET status = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $status, $enrollmentId);
    
    if ($stmt->execute()) {
        echo "Status updated successfully";
    } else {
        echo "Error updating status: " . $conn->error;
    }

    // Close the database connection
    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request";
}
?>