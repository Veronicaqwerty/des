<?php
session_start() ;
// Step 1: Establish a connection to the database
include 'dbcon.php';

// Step 2: Retrieve the form data submitted by the user
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the selected appointment ID
    $appointmentId = $_POST['appointment_id'] ?? '';

    // Check if appointment ID is provided
    if ($appointmentId !== '') {
        // Retrieve enrollment form data
        $username = $_POST['username'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $firstName = $_POST['firstName'] ?? '';
        $middleName = $_POST['middleName'] ?? '';
        $lastName = $_POST['lastName'] ?? '';
        $sex = $_POST['sex'] ?? '';
        $course = $_POST['course'] ?? '';
        $year = $_POST['year'] ?? '';
        $birthdate = $_POST['birthdate'] ?? '';
        $homeAddress = $_POST['homeAddress'] ?? '';
        $phoneNumber = $_POST['phoneNumber'] ?? '';
        $guardianName = $_POST['guardianName'] ?? '';
        $guardianPhoneNumber = $_POST['guardianPhoneNumber'] ?? '';
        $guardianAddress = $_POST['guardianAddress'] ?? '';
        $elementarySchool = $_POST['elementarySchool'] ?? '';
        $elementaryGraduationYear = $_POST['elementaryGraduationYear'] ?? '';
        $juniorHighSchool = $_POST['juniorHighSchool'] ?? '';
        $juniorHighGraduationYear = $_POST['juniorHighGraduationYear'] ?? '';
        $seniorHighSchool = $_POST['seniorHighSchool'] ?? '';
        $seniorHighGraduationYear = $_POST['seniorHighGraduationYear'] ?? '';

        // Append "@student" to the username
        $username = $username . "@student";

        // Check if course and year are selected
        if (isset($_POST['course']) && isset($_POST['year'])) {
            // Get the selected course and year
            $selectedCourse = $_POST['course'];
            $selectedYear = $_POST['year'];

            // Check if there are subjects available for the selected course and year
            $sqlSubjects = "SELECT COUNT(*) as subjectCount FROM subjects WHERE course = '$selectedCourse' AND year = '$selectedYear'";
            $resultSubjects = $conn->query($sqlSubjects);
            $rowSubjects = $resultSubjects->fetch_assoc();
            $subjectCount = $rowSubjects['subjectCount'];

            if ($subjectCount == 0) {
                // No subjects available for the selected course and year, set a variable for modal display
                $displayNoSubjectsModal = true;
            }
        }

        if (isset($displayNoSubjectsModal) && $displayNoSubjectsModal) {
            $_SESSION['success_message'] = " No subjects available for enrollment for the selected course and year. Please contact the administration.";
        header("Location: ../enroll.php");
        exit();
            exit; // Stop further processing
        }

        // Step 3: Insert enrollment information into the enrollment_info table
        $enrollmentSql = "INSERT INTO enrollment_info (username, email, password, first_name, middle_name, last_name, sex, course, year, birthdate, home_address, phone_number, guardian_name, guardian_phone_number, guardian_address, elementary_school, elementary_graduation_year, junior_high_school, junior_high_graduation_year, senior_high_school, senior_high_graduation_year, appointment_id)
            VALUES ('$username', '$email', '$password', '$firstName', '$middleName', '$lastName', '$sex', '$course', '$year', '$birthdate', '$homeAddress', '$phoneNumber', '$guardianName', '$guardianPhoneNumber', '$guardianAddress', '$elementarySchool', '$elementaryGraduationYear', '$juniorHighSchool', '$juniorHighGraduationYear', '$seniorHighSchool', '$seniorHighGraduationYear', '$appointmentId')";

        // Execute the INSERT statement for enrollment_info table
        if ($conn->query($enrollmentSql) === TRUE) {
            // Step 4: Update the enrollment_schedule table to decrement slots for the chosen appointment
            $updateSql = "UPDATE enrollment_schedule SET slots = slots - 1 WHERE id = $appointmentId";

            // Execute the UPDATE statement for enrollment_schedule table
            if ($conn->query($updateSql) === TRUE) {
                // Redirect back to enroll.php with a success status
                header("Location: ../enroll.php?success=true");
                exit;
            } else {
                echo "Error updating appointment slots: " . $conn->error;
            }
        } else {
            echo "Error inserting enrollment information: " . $conn->error;
        }
    } else {
        // Handle the case where appointment ID is not provided
        echo "Error: Appointment ID not provided.";
    }

    // Close the database connection
    $conn->close();
}
?>
