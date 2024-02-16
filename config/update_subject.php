<?php
include_once("dbcon.php");

// Get data from AJAX request
$subjectId = $_POST['subject_id'];
$subject = $_POST['subject'];
$course = $_POST['course'];
$instructor = $_POST['instructor'];
$year = $_POST['year'];
$hours = $_POST['hours'];

// Prepare and bind the update statement
$stmt = $conn->prepare("UPDATE subjects SET subject=?, course=?, instructor=?, year=?, hours=? WHERE id=?");
$stmt->bind_param("sssssi", $subject, $course, $instructor, $year, $hours, $subjectId);

// Execute the update statement
if ($stmt->execute()) {
    echo "Success";
} else {
    echo "Error updating subject: " . $stmt->error;
}

// Close the statement and the connection
$stmt->close();
$conn->close();
?>
