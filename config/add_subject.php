<?php
include_once("dbcon.php");


// Get data from AJAX request
$subject = $_POST['subject'];
$course = $_POST['course'];
$instructor = $_POST['instructor'];
$year = $_POST['year'];
$hours = $_POST['hours'];

// Insert the new subject into the database
$sql = "INSERT INTO subjects (subject, course, instructor, year, hours) VALUES ('$subject', '$course', '$instructor', '$year', '$hours')";

if ($conn->query($sql) === TRUE) {
    echo "Success";
} else {
    echo "Error adding subject: " . $conn->error;
}

$conn->close();
?>

