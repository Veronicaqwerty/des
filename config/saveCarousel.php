<?php
session_start();
// Define the saveCarousel function
function saveToCarousel($imagePath) {
    // Database connection
    include "dbcon.php"; // Make sure this file contains your database connection logic
    
    // Insert the image path into the carousel table
    $sql = "INSERT INTO carousel (image) VALUES ('$imagePath')";
    
    if (mysqli_query($conn, $sql)) {
        // Image path inserted successfully
        return true;
    } else {
        // Error inserting image path
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        return false;
    }
    
    // Close the database connection
    mysqli_close($conn);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["image"])) {
    $targetDir = "../uploads/"; // Directory where you want to store the uploaded images
    $targetFile = $targetDir . basename($_FILES["image"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
    
    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if ($check !== false) {
        // Allow certain file formats
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif") {
            $_SESSION['error_message'] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            header("Location: ../admin/index.php");
            exit();
        }
    } else {
        $_SESSION['error_message'] = "File is not an image.";
        header("Location: ../admin/index.php");
        exit();
    }
    
    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        $_SESSION['error_message'] = "Sorry, your file was not uploaded.";
        header("Location: ../admin/index.php");
        exit();
    } else {
        // if everything is ok, try to upload file
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
            // File uploaded successfully, now insert its details into the database
            $imagePath = $targetFile;
            // Call your function to save to the carousel table passing $imagePath
            if (saveToCarousel($imagePath)) {
                $_SESSION['success_message'] = "New Carousel Item successfully added!";
                header("Location: ../admin/index.php");
                exit();
            } else {
                $_SESSION['error_message'] = "Error adding Carousel Item.";
                header("Location: ../admin/index.php");
                exit();
            }
        } else {
            $_SESSION['error_message'] = "Sorry, there was an error uploading your file.";
            header("Location: ../admin/index.php");
            exit();
        }
    }
}
?>
