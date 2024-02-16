<?php
session_start();
include "../config/dbcon.php";

if (!isset($_SESSION['username'])) {

    $_SESSION['alert_message'] = "YOU MUST LOGIN FIRST TO CONTINUE";
    header("Location: ../index.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <title>E-Grades</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/5.0/examples/navbars/">
    <link rel="icon" href="img/cookie.png" type="image/png">
    <link href="../assets/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.14.0/css/all.css">
    <link rel="canonical" href="https://getbootstrap.com/docs/5.1/examples/cheatsheet/">
    
    <style>
        /* Custom styles */


        .custom-input {
            padding: 0.375rem 0.75rem;
            font-size: 0.875rem;
            line-height: 1.5;
            border-radius: 0.25rem;
        }

        #status {
            background-color: #28a745; /* Green background color */
            color: #fff; /* White text color */
        }
    </style>
</head>
<body>
    <?php
    include "../includes/studentNavbar.php";

    // Retrieve student information based on the logged-in user's session
    $username = $_SESSION['username'];

    // Query to fetch student information from the enrollment_info table
    $query_student_info = "SELECT first_name, last_name, course, year, section, status FROM enrollment_info WHERE username = '$username'";
    $result_student_info = mysqli_query($conn, $query_student_info);

    // Check if student information is retrieved successfully
    if ($result_student_info && mysqli_num_rows($result_student_info) > 0) {
        $student_info = mysqli_fetch_assoc($result_student_info);
        $first_name = $student_info['first_name'];
        $last_name = $student_info['last_name'];
        $course = $student_info['course'];
        $year = $student_info['year'];
        $section = $student_info['section'];

        $name = $first_name . ' ' . $last_name;
        
        // Check the status and set the appropriate value
        $status = $student_info['status'] === 'Accepted' ? 'Enrolled' : 'Active';
        $status_class = $status === 'Enrolled' ? 'enrolled-status' : ''; // Add 'enrolled-status' class for green background
    } else {
        // Error retrieving student information
        // You can handle this according to your application's requirements
        echo "Error: Unable to fetch student information.";
        exit();
    }

    // Query to fetch student grades from the studentgrades table
    $query_student_grades = "SELECT subject, prelim, midterm, finals, average, remarks FROM studentgrades WHERE username = '$username'";
    $result_student_grades = mysqli_query($conn, $query_student_grades);

    ?>

    <div class="col-sm p-3 min-vh-100">
        <div class="shadow p-3 mb-5 bg-body rounded">
            <div class="container mt-3">
                <h2>Grades</h2>
                <div class="row">
                    <div class="col-md-6">
                        <div class="row mb-3">
                            <label for="name" class="col-sm-3 col-form-label custom-label">Name:</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control custom-input" id="name" value="<?php echo $name; ?>" readonly>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="course" class="col-sm-3 col-form-label custom-label">Course:</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control custom-input" id="course" value="<?php echo $course; ?>" readonly>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="status" class="col-sm-3 col-form-label custom-label">Status:</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control custom-input <?php echo $status_class; ?>" id="status" value="<?php echo $status; ?>" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row mb-3">
                            <label for="year" class="col-sm-3 col-form-label custom-label">Year:</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control custom-input" id="year" value="<?php echo $year; ?>" readonly>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="section" class="col-sm-3 col-form-label custom-label">Section:</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control custom-input" id="section" value="<?php echo $section; ?>" readonly>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Subject</th>
                                    <th>Instructor</th>
                                    <th>Prelim</th>
                                    <th>Midterm</th>
                                    <th>Finals</th>
                                    <th>Average</th>
                                    <th>Remarks</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
// Display student grades in table rows
if ($result_student_grades && mysqli_num_rows($result_student_grades) > 0) {
    while ($row = mysqli_fetch_assoc($result_student_grades)) {
        // Query to fetch the instructor for each subject
        $query_subjects = "SELECT instructor FROM subjects WHERE course = '$course' AND year = '$year' AND subject = '{$row['subject']}'";
        $result_subjects = mysqli_query($conn, $query_subjects);

        // Check if the query was successful and if there are any rows returned
        if ($result_subjects && mysqli_num_rows($result_subjects) > 0) {
            $row_subject = mysqli_fetch_assoc($result_subjects);
            $instructor = $row_subject['instructor'];
        } else {
            // If no rows were returned, set the instructor to "TBA" (To be announced) or any default value you prefer
            $instructor = "TBA";
        }

        $remarks_color = '';
        switch ($row['remarks']) {
            case 'PASSED':
                $remarks_color = 'green';
                break;
            case 'FAILED':
                $remarks_color = 'red';
                break;
            default:
                $remarks_color = 'yellow';
                break;
        }
        echo "<tr>";
        echo "<td>{$row['subject']}</td>";
        echo "<td>{$instructor}</td>";
        echo "<td>{$row['prelim']}</td>";
        echo "<td>{$row['midterm']}</td>";
        echo "<td>{$row['finals']}</td>";
        echo "<td>{$row['average']}</td>";
        echo "<td class='remarks' style='color: $remarks_color; font-weight:bold;'>{$row['remarks']}</td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='7'>No grades found.</td></tr>";
}
?>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="../assets/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
