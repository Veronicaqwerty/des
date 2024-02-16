
<?php
// Include the database configuration file
include 'dbcon.php';

// Check if the student ID is provided via POST request
if(isset($_POST['id'])) {
    // Sanitize the input to prevent SQL injection
    $studentId = mysqli_real_escape_string($conn, $_POST['id']);

    // Update the status of the student to "Rejected"
    $sql = "UPDATE enrollment_info SET status = 'Rejected' WHERE id = '$studentId'";
    
    if(mysqli_query($conn, $sql)) {
        // Rejection successful
        echo "Student rejected";
    } else {
        // Error handling
        echo "Error: " . mysqli_error($conn);
    }
} else {
    // If student ID is not provided
    echo "Student ID is not provided";
}

// Close the database connection
mysqli_close($conn);
?>