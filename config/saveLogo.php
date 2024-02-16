<?php
session_start();
// Include your database connection file here
include "dbcon.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if file was uploaded without errors
    if (isset($_FILES["logoImage"]) && $_FILES["logoImage"]["error"] == 0) {
        $allowedExtensions = array("jpg", "jpeg", "png", "gif");
        $fileExtension = pathinfo($_FILES["logoImage"]["name"], PATHINFO_EXTENSION);

        // Check file extension
        if (in_array($fileExtension, $allowedExtensions)) {
            $tempName = $_FILES["logoImage"]["tmp_name"];
            $imageName = $_FILES["logoImage"]["name"];

            // Move uploaded file to desired directory
            $uploadDirectory = "../uploads/";
            $destination = $uploadDirectory . $imageName;
            if (move_uploaded_file($tempName, $destination)) {
                // Update image path in the database
                $sqlUpdate = "UPDATE details SET image = '$imageName' WHERE id = 1"; // Assuming the id for the website details is 1
                if (mysqli_query($conn, $sqlUpdate)) {
                     $_SESSION['success_message'] = "New Logo successfully updated!";
                     header("Location: ../admin/index.php");
                     exit();
                } else {
                    $_SESSION['error_message'] = "Error: " . mysqli_error($conn);
                    header("Location: ../admin/index.php");
                    exit();
                }
            } else {
                $_SESSION['error_message'] = "Error uploading file.";
                header("Location: ../admin/index.php");
                exit();
            }
        } else {
            $_SESSION['error_message'] = "Invalid file format. Only JPG, JPEG, PNG, and GIF files are allowed.";
            header("Location: ../admin/index.php");
            exit();
        }
    } else {
        $_SESSION['error_message'] = "Error: " . $_FILES["logoImage"]["error"];
        header("Location: ../admin/index.php");
        exit();
    }
} else {
    $_SESSION['error_message'] = "Invalid request method.";
    header("Location: ../admin/index.php");
    exit();
}
?>
