<?php
session_start();
include "../config/dbcon.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get POST data
    $prelimGrade = $_POST['prelim_grade'];
    $midtermGrade = $_POST['midterm_grade'];
    $finalsGrade = $_POST['finals_grade'];
    $average = $_POST['average'];
    $remarks = $_POST['remarks'];
    $username = $_POST['username'];
    $course = $_POST['course'];
    $year = $_POST['year'];
    $subject = $_POST['subject'];

    // Check if the record already exists for the student and subject
    $stmt_check = $conn->prepare("SELECT id FROM studentgrades WHERE username = ? AND course = ? AND year = ? AND subject = ?");
    $stmt_check->bind_param("ssss", $username, $course, $year, $subject);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();

    if ($result_check->num_rows > 0) {
        // If the record exists, update the existing record
        $stmt = $conn->prepare("UPDATE studentgrades SET prelim = ?, midterm = ?, finals = ?, average = ?, remarks = ? WHERE username = ? AND course = ? AND year = ? AND subject = ?");
        $stmt->bind_param("sssssssss", $prelimGrade, $midtermGrade, $finalsGrade, $average, $remarks, $username, $course, $year, $subject);
    } else {
        // If the record doesn't exist, insert a new record
        $stmt = $conn->prepare("INSERT INTO studentgrades (prelim, midterm, finals, average, remarks, username, course, year, subject) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssssss", $prelimGrade, $midtermGrade, $finalsGrade, $average, $remarks, $username, $course, $year, $subject);
    }

    if ($stmt->execute()) {
        // Set success message in session
        $_SESSION['success_message'] = "Grades saved successfully!";
    } else {
        echo "Error saving grades: " . $stmt->error;
    }
} else {
    echo "Invalid request method!";
}
?>
