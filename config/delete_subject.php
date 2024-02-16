<?php
include_once("dbcon.php");

// Get data from AJAX request
$subjectId = $_POST['subject_id'];

// Delete the subject from the database
$sql = "DELETE FROM subjects WHERE id = $subjectId";

if ($conn->query($sql) === TRUE) {
    echo "Success";
} else {
    echo "Error deleting subject: " . $conn->error;
}

$conn->close();
?>
