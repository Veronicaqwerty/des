<?php
session_start();
// Include database connection file
include "dbcon.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["cardImage"])) {
    $title = $_POST['title'];
    $caption = $_POST['caption'];
    $targetDir = "../uploads/"; // Directory where you want to store the uploaded card images
    $targetFile = $targetDir . basename($_FILES["cardImage"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
    
    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["cardImage"]["tmp_name"]);
    if ($check === false) {
        $_SESSION['success_message'] = "File is not an image.";
        header("Location: ../admin/index.php");
        exit();
    }
    
    // Check file size (you can adjust the maximum file size as needed)
    if ($_FILES["cardImage"]["size"] > 1500000) {
        $_SESSION['success_message'] = "Sorry, your file is too large.";
        header("Location: ../admin/index.php");
        exit();
    }
    
    // Allow only certain file formats
    if (!in_array($imageFileType, array("jpg", "png", "jpeg", "webp", "gif"))) {
        $_SESSION['success_message'] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        header("Location: ../admin/index.php");
        exit();
    }
    
    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        $_SESSION['success_message'] = "Sorry, your file was not uploaded.";
        header("Location: ../admin/index.php");
        exit();
    } else {
        // if everything is ok, try to upload file
        if (move_uploaded_file($_FILES["cardImage"]["tmp_name"], $targetFile)) {
            // File uploaded successfully, now insert its details into the database
            $imagePath = $targetFile;
            
            // Prepare and bind the SQL statement
            $sql = "INSERT INTO cards (image, title, caption) VALUES (?, ?, ?)";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "sss", $imagePath, $title, $caption);
            
            // Execute the statement
            if (mysqli_stmt_execute($stmt)) {
                $_SESSION['success_message'] = "New record inserted successfully!";
                header("Location: ../admin/index.php");
                exit();
            } else {
                $_SESSION['success_message'] = "Error: " . $sql . "<br>" . mysqli_error($conn);
                header("Location: ../admin/index.php");
                exit();
            }

            // Close the statement
            mysqli_stmt_close($stmt);
        } else {
            $_SESSION['success_message'] = "Sorry, there was an error uploading your file.";
            header("Location: ../admin/index.php");
            exit();
        }
    }
} else {
    $_SESSION['success_message'] = "Invalid request.";
    header("Location: ../admin/index.php");
    exit();
}
?>
