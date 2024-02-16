<?php
session_start(); // Start the session

// Initialize variables to store user input
$username = $password = "";
$usernameErr = $passwordErr = "";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate username
    if (empty($_POST["username"])) {
        $usernameErr = "Username is required";
    } else {
        $username = $_POST["username"];
    }

    // Validate password
    if (empty($_POST["password"])) {
        $passwordErr = "Password is required";
    } else {
        $password = $_POST["password"];
    }

    // If both username and password are provided
    if (!empty($username) && !empty($password)) {
        // Check if the username exists in the enrollment_info table
        $query_student = "SELECT * FROM enrollment_info WHERE username = '$username' AND status = 'Accepted' ";
        $result_student = mysqli_query($conn, $query_student);

        // Check if the username exists in the users table
        $query_user = "SELECT * FROM users WHERE username = '$username'";
        $result_user = mysqli_query($conn, $query_user);

        if (($result_student && mysqli_num_rows($result_student) > 0) || ($result_user && mysqli_num_rows($result_user) > 0)) {
            // User found in either enrollment_info table or users table
            // Check if the username format matches a student
            if ($result_student && mysqli_num_rows($result_student) > 0 && stripos($username, "@student") !== false) {
                // Student login
                // Set session variables for student
                $_SESSION['username'] = $username;
                // Redirect to student/index.php
                header("Location: student/index.php");
                exit();
            } elseif ($result_user && mysqli_num_rows($result_user) > 0 && stripos($username, "@admin") !== false) {
                // Admin login
                // Set session variables for admin
                $_SESSION['username'] = $username;
                // Redirect to admin/index.php
                header("Location: admin/index.php");
                exit();
            } else {
                // Invalid username format
                echo "<script>alert('Invalid username format.');</script>";
            }
        } else {
            // User not found in either table
            echo "<script>alert('Invalid username or password.');</script>";
        }
    }
}

?>
