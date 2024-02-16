<?php
session_start();
include "dbcon.php";

// Process the form data
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Validate captcha
    $userCaptcha = trim($_POST["captcha"]); // Convert to lowercase and trim whitespace
    $actualCaptcha = trim($_SESSION["captcha"]); // Convert to lowercase and trim whitespace

    if ($userCaptcha !== $actualCaptcha || strlen($userCaptcha) !== strlen($actualCaptcha)) {
        $_SESSION['error_message'] = "Invalid captcha! Please try again.";
        header("Location: ../contactUs.php");
        exit();
    }

    $sender = $_POST["sender"];
    $email = $_POST["email"];
    $message = $_POST["message"];
    $date_time = date("Y-m-d H:i:s");

    // Insert data into the database and mark the message as unread
    $sql = "INSERT INTO messages (sender, email, message, date_time, status) VALUES ('$sender', '$email', '$message', '$date_time', 'unread')";

    if ($conn->query($sql) === TRUE) {
        $_SESSION['success_message'] = "MESSAGE SENT!";
        header("Location: ../contactUs.php");
        exit();
    } else {
        $_SESSION['error_message'] = "Error: " . $sql . "<br>" . $conn->error;
        header("Location: ../contactUs.php");
        exit();
    }
}

// Close the database connection
$conn->close();
?>
