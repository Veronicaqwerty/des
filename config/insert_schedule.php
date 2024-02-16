<?php
// Include the database configuration file
include 'dbcon.php';

// Initialize error variable
$error_message = "";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $selectedDate = $_POST['date'];
    $currentDate = date('Y-m-d'); // Get the current date in the same format as your form input

    // Check if the selected date is not earlier than the current date
    if ($selectedDate < $currentDate) {
        $error_message = "Error: Please select a date on or after the current date.";
    } else {
        // Continue processing if the date is valid
        $start_time = $_POST['start_time'];
        $end_time = $_POST['end_time'];
        $slots = $_POST['slots'];

        // SQL to insert data
        $sql = "INSERT INTO enrollment_schedule (date, start_time, end_time, slots)
                VALUES ('$selectedDate', '$start_time', '$end_time', $slots)";

        if ($conn->query($sql) === TRUE) {
            // Redirect back to enrollment.php with success message
            header("Location: ../admin/enrollment.php?success=true");
            exit();
        } else {
            $error_message = "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

// Include the form page
include '../admin/enrollment.php';
?>