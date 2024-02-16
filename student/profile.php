<?php
session_start();
include "../config/dbcon.php";


if (!isset($_SESSION['username'])) {

    $_SESSION['alert_message'] = "YOU MUST LOGIN FIRST TO CONTINUE";
    header("Location: ../index.php");
    exit();
}
// Update password
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $retype_new_password = $_POST['retype_new_password'];

    $username = $_SESSION['username'];

    // Check if the current password matches the one stored in the database
    $query_check_password = "SELECT password FROM enrollment_info WHERE username = '$username'";
    $result_check_password = mysqli_query($conn, $query_check_password);

    if ($result_check_password && mysqli_num_rows($result_check_password) > 0) {
        $row = mysqli_fetch_assoc($result_check_password);
        $password_hash = $row['password'];

        if ($current_password === $password_hash) {
            // Current password is correct, update the password
            if ($new_password === $retype_new_password) {
                // New passwords match, update the password in the database
                $query_update_password = "UPDATE enrollment_info SET password = '$new_password' WHERE username = '$username'";
                $result_update_password = mysqli_query($conn, $query_update_password);

                if ($result_update_password) {
                    echo "<script>alert('Password updated successfully');</script>";
                } else {
                    echo "<script>alert('Error updating password');</script>";
                }
            } else {
                echo "<script>alert('New passwords do not match');</script>";
            }
        } else {
            echo "<script>alert('Incorrect current password');</script>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <title>Profile</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/5.0/examples/navbars/">
    <link rel="icon" href="img/cookie.png" type="image/png">
    <link href="../assets/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.14.0/css/all.css">
    <link rel="canonical" href="https://getbootstrap.com/docs/5.1/examples/cheatsheet/">

</head>
<body>
    <?php
    include "../includes/studentNavbar.php";

    // Retrieve student information based on the logged-in user's session
    $username = $_SESSION['username'];

    // Query to fetch student information from the enrollment_info table
    $query_student_info = "SELECT * FROM enrollment_info WHERE username = '$username'";
    $result_student_info = mysqli_query($conn, $query_student_info);

    // Check if student information is retrieved successfully
    if ($result_student_info && mysqli_num_rows($result_student_info) > 0) {
        $student_info = mysqli_fetch_assoc($result_student_info);
?>
    <div class="col-sm p-3 min-vh-100">
        <div class="shadow p-3 mb-5 bg-body rounded">
            <div class="container mt-3 text-center">
                <h2>Basic Profile</h2>
                <div class="row">
                    <div class="col-md-6">
                        <div class="row mb-3">
                            <label for="username" class="col-sm-6 col-form-label">Username:</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="username" value="<?php echo $student_info['username']; ?>" readonly>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="first_name" class="col-sm-6 col-form-label">First Name:</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="first_name" value="<?php echo $student_info['first_name']; ?>" readonly>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="middle_name" class="col-sm-6 col-form-label">Middle Name:</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="middle_name" value="<?php echo $student_info['middle_name']; ?>" readonly>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="last_name" class="col-sm-6 col-form-label">Last Name:</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="last_name" value="<?php echo $student_info['last_name']; ?>" readonly>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="sex" class="col-sm-6 col-form-label">Sex:</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="sex" value="<?php echo $student_info['sex']; ?>" readonly>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="course" class="col-sm-6 col-form-label">Course:</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="course" value="<?php echo $student_info['course']; ?>" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row mb-3">
                            <label for="year" class="col-sm-6 col-form-label">Year:</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="year" value="<?php echo $student_info['year']; ?>" readonly>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="section" class="col-sm-6 col-form-label">Section:</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="section" value="<?php echo $student_info['section']; ?>" readonly>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="birthdate" class="col-sm-6 col-form-label">Birthdate:</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="birthdate" value="<?php echo $student_info['birthdate']; ?>" readonly>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="home_address" class="col-sm-6 col-form-label">Home Address:</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="home_address" value="<?php echo $student_info['home_address']; ?>" readonly>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="phone_number" class="col-sm-6 col-form-label">Phone Number:</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="phone_number" value="<?php echo $student_info['phone_number']; ?>" readonly>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="email" class="col-sm-6 col-form-label">Email:</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="email" value="<?php echo $student_info['email']; ?>" readonly>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="guardian_name" class="col-sm-6 col-form-label">Guardian Name:</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="guardian_name" value="<?php echo $student_info['guardian_name']; ?>" readonly>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="guardian_phone_number" class="col-sm-6 col-form-label">Guardian Phone Number:</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="guardian_phone_number" value="<?php echo $student_info['guardian_phone_number']; ?>" readonly>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="guardian_address" class="col-sm-6 col-form-label">Guardian Address:</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="guardian_address" value="<?php echo $student_info['guardian_address']; ?>" readonly>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="elementary_school" class="col-sm-6 col-form-label">Elementary School:</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="elementary_school" value="<?php echo $student_info['elementary_school']; ?>" readonly>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="elementary_graduation_year" class="col-sm-6 col-form-label">Elementary Graduation Year:</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="elementary_graduation_year" value="<?php echo $student_info['elementary_graduation_year']; ?>" readonly>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="junior_high_school" class="col-sm-6 col-form-label">Junior High School:</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="junior_high_school" value="<?php echo $student_info['junior_high_school']; ?>" readonly>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="junior_high_graduation_year" class="col-sm-6 col-form-label">Junior High Graduation Year:</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="junior_high_graduation_year" value="<?php echo $student_info['junior_high_graduation_year']; ?>" readonly>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="senior_high_school" class="col-sm-6 col-form-label">Senior High School:</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="senior_high_school" value="<?php echo $student_info['senior_high_school']; ?>" readonly>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="senior_high_graduation_year" class="col-sm-6 col-form-label">Senior High Graduation Year:</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="senior_high_graduation_year" value="<?php echo $student_info['senior_high_graduation_year']; ?>" readonly>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="shadow p-3 mb-5 bg-body rounded">
            <div class="container mt-3 text-center">
                <h2>Change Password</h2>
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <div class="row mb-3">
                        <label for="current_password" class="col-sm-6 col-form-label">Current Password:</label>
                        <div class="col-sm-6">
                            <input type="password" class="form-control" id="current_password" name="current_password" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="new_password" class="col-sm-6 col-form-label">New Password:</label>
                        <div class="col-sm-6">
                            <input type="password" class="form-control" id="new_password" name="new_password" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="retype_new_password" class="col-sm-6 col-form-label">Retype New Password:</label>
                        <div class="col-sm-6">
                            <input type="password" class="form-control" id="retype_new_password" name="retype_new_password" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col text-end"> 
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
<?php
    }
?>
<script src="../assets/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
