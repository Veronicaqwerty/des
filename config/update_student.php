<?php
echo "update_student.php is being executed.";

// Include the database configuration file
include 'dbcon.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if all required fields are set
    if (isset($_POST['student_id']) && !empty($_POST['student_id']) &&
        isset($_POST['username']) && !empty($_POST['username']) &&
        isset($_POST['email']) && !empty($_POST['email']) &&
        isset($_POST['password']) && !empty($_POST['password']) &&
        isset($_POST['first_name']) && !empty($_POST['first_name']) &&
        isset($_POST['middle_name']) && !empty($_POST['middle_name']) &&
        isset($_POST['last_name']) && !empty($_POST['last_name']) &&
        isset($_POST['sex']) && !empty($_POST['sex']) &&
        isset($_POST['course']) && !empty($_POST['course']) &&
        isset($_POST['year']) && !empty($_POST['year']) &&
        isset($_POST['birthdate']) && !empty($_POST['birthdate']) &&
        isset($_POST['home_address']) && !empty($_POST['home_address']) &&
        isset($_POST['phone_number']) && !empty($_POST['phone_number']) &&
        isset($_POST['guardian_name']) && !empty($_POST['guardian_name']) &&
        isset($_POST['guardian_phone_number']) && !empty($_POST['guardian_phone_number']) &&
        isset($_POST['guardian_address']) && !empty($_POST['guardian_address']) &&
        isset($_POST['elementary_school']) && !empty($_POST['elementary_school']) &&
        isset($_POST['elementary_graduation_year']) && !empty($_POST['elementary_graduation_year']) &&
        isset($_POST['junior_high_school']) && !empty($_POST['junior_high_school']) &&
        isset($_POST['junior_high_graduation_year']) && !empty($_POST['junior_high_graduation_year']) &&
        isset($_POST['senior_high_school']) && !empty($_POST['senior_high_school']) &&
        isset($_POST['senior_high_graduation_year']) && !empty($_POST['senior_high_graduation_year'])
    ) {
        // Sanitize and validate input
        $student_id = mysqli_real_escape_string($conn, $_POST['student_id']);
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);
        $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
        $middle_name = mysqli_real_escape_string($conn, $_POST['middle_name']);
        $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
        $sex = mysqli_real_escape_string($conn, $_POST['sex']);
        $course = mysqli_real_escape_string($conn, $_POST['course']);
        $year = mysqli_real_escape_string($conn, $_POST['year']);
        $birthdate = mysqli_real_escape_string($conn, $_POST['birthdate']);
        $home_address = mysqli_real_escape_string($conn, $_POST['home_address']);
        $phone_number = mysqli_real_escape_string($conn, $_POST['phone_number']);
        $guardian_name = mysqli_real_escape_string($conn, $_POST['guardian_name']);
        $guardian_phone_number = mysqli_real_escape_string($conn, $_POST['guardian_phone_number']);
        $guardian_address = mysqli_real_escape_string($conn, $_POST['guardian_address']);
        $elementary_school = mysqli_real_escape_string($conn, $_POST['elementary_school']);
        $elementary_graduation_year = mysqli_real_escape_string($conn, $_POST['elementary_graduation_year']);
        $junior_high_school = mysqli_real_escape_string($conn, $_POST['junior_high_school']);
        $junior_high_graduation_year = mysqli_real_escape_string($conn, $_POST['junior_high_graduation_year']);
        $senior_high_school = mysqli_real_escape_string($conn, $_POST['senior_high_school']);
        $senior_high_graduation_year = mysqli_real_escape_string($conn, $_POST['senior_high_graduation_year']);

        // Prepare and execute the SQL update statement
        $sql = "UPDATE enrollment_info SET 
                username = '$username', 
                email = '$email', 
                password = '$password',
                first_name = '$first_name',
                middle_name = '$middle_name',
                last_name = '$last_name',
                sex = '$sex',
                course = '$course',
                year = '$year',
                birthdate = '$birthdate',
                home_address = '$home_address',
                phone_number = '$phone_number',
                guardian_name = '$guardian_name',
                guardian_phone_number = '$guardian_phone_number',
                guardian_address = '$guardian_address',
                elementary_school = '$elementary_school',
                elementary_graduation_year = '$elementary_graduation_year',
                junior_high_school = '$junior_high_school',
                junior_high_graduation_year = '$junior_high_graduation_year',
                senior_high_school = '$senior_high_school',
                senior_high_graduation_year = '$senior_high_graduation_year'
                WHERE id = $student_id";

        if ($conn->query($sql) === TRUE) {
            // Update successful
            echo "Student information updated successfully";
            // Redirect back to enrollment.php
            header("Location: ../admin/enrollment.php");
            exit();
        } else {
            // Error handling
            echo "Error updating student information: " . $conn->error;
        }
    } else {
        // Missing required fields
        echo "Please fill out all required fields";
    }
} else {
    // Invalid request method
    echo "Invalid request method";
}

// Close the database connection
$conn->close();
?>