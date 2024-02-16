<?php
session_start();
include "../config/dbcon.php";

// Check if the username parameter is set in the URL
if (!isset($_SESSION['username'])) {

    $_SESSION['alert_message'] = "YOU MUST LOGIN FIRST TO CONTINUE";
    header("Location: ../index.php");
    exit();
}

$username = $_GET['username'];

// Check if the username contains '@student'
if (!strpos($username, '@student')) {
    // Redirect back to the previous page if username is not in the correct format
    header("Location: class.php");
    exit();
}

// Retrieve student information from the database
$stmt = $conn->prepare("SELECT first_name, last_name, course, year, section FROM enrollment_info WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    // Redirect back to the previous page if student not found
    header("Location: class.php");
    exit();
}

$row = $result->fetch_assoc();
$firstName = $row['first_name'];
$lastName = $row['last_name'];
$course = $row['course'];
$year = $row['year'];
$section = $row['section'];

// Retrieve subjects of the student based on their year and course
$stmt_subjects = $conn->prepare("SELECT subject, instructor FROM subjects WHERE year = ? AND course = ?");
$stmt_subjects->bind_param("ss", $year, $course);
$stmt_subjects->execute();
$result_subjects = $stmt_subjects->get_result();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <title>View Grades</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/5.0/examples/navbars/">
    <link rel="icon" href="img/cookie.png" type="image/png">
    <link href="../assets/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.14.0/css/all.css">
   <script>
function calculateAverage(row) {
    // Get the input values for prelim, midterm, and finals
    var prelimValue = row.querySelector('input[name="prelim_grade"]').value;
    var midtermValue = row.querySelector('input[name="midterm_grade"]').value;
    var finalsValue = row.querySelector('input[name="finals_grade"]').value;

    // Check if any of the grades are missing or have no grade
    if (prelimValue === '' || midtermValue === '' || finalsValue === '') {
        // Set average and remarks to 'TBA'
        row.querySelector('.average').textContent = 'TBA';
        row.querySelector('.remarks').textContent = 'TBA';
    } else {
        var prelim = parseFloat(prelimValue) || 0;
        var midterm = parseFloat(midtermValue) || 0;
        var finals = parseFloat(finalsValue) || 0;

        // Calculate the average
        var average = (prelim + midterm + finals) / 3;

        // Update the average cell in the same row
        var averageCell = row.querySelector('.average');
        averageCell.textContent = average.toFixed(2);

        // Update the remarks based on the average
        var remarksCell = row.querySelector('.remarks');
        if (average >= 75) {
            remarksCell.textContent = 'PASSED';
            remarksCell.style.color = 'green';
        } if (average <=74) {
            remarksCell.textContent = 'FAILED';
            remarksCell.style.color = 'red';
        } else {
           remarksCell.textContent = 'TBA';
          remarksCell.style.color = 'yellow';
        }
    }
}
</script>

</head>
<body>

<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <?php include "../includes/sidebar.php"; ?>

        <!-- Content -->
        <div class="col-sm p-3 min-vh-100">
           <?php
                // Check if there is a success message in session
                if (isset($_SESSION['success_message'])) {
                    echo '<div class="alert alert-success alert-dismissible" role="alert">
                    ' . $_SESSION['success_message'] . '
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>';
                    // Remove the success message from session
                    unset($_SESSION['success_message']);
                }
                ?>   

             <div class="shadow p-3 mb-5 bg-body round">
                <div class="container mt-3">
                    <h2>E-Grades</h2>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name" class="form-label">Name:</label>
                                <input type="text" class="form-control" id="name" value="<?php echo $firstName . ' ' . $lastName; ?>" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="course" class="form-label">Course:</label>
                                <input type="text" class="form-control" id="course" value="<?php echo $course; ?>" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="year" class="form-label">Year:</label>
                                <input type="text" class="form-control" id="year" value="<?php echo $year; ?>" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="section" class="form-label">Section:</label>
                                <input type="text" class="form-control" id="section" value="<?php echo $section; ?>" readonly>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="shadow p-3 mb-5 bg-body round">
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
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Populate table rows with subjects -->
<!-- Inside your PHP section where you populate table rows with subjects -->
<?php
while ($row_subjects = $result_subjects->fetch_assoc()) {
    // Fetch existing grades for the subject from the database
    $subject = $row_subjects['subject'];
    $stmt_grades = $conn->prepare("SELECT prelim, midterm, finals, average, remarks FROM studentgrades WHERE username = ? AND course = ? AND year = ? AND subject = ?");
    $stmt_grades->bind_param("ssss", $username, $course, $year, $subject);
    $stmt_grades->execute();
    $result_grades = $stmt_grades->get_result();
    $row_grades = $result_grades->fetch_assoc();
    ?>
    <tr>
        <td><?php echo $row_subjects['subject']; ?></td>
        <td><?php echo $row_subjects['instructor']; ?></td>
        <td><input type="text" class="form-control" name="prelim_grade" oninput="calculateAverage(this.parentNode.parentNode)" value="<?php echo !empty($row_grades['prelim']) ? $row_grades['prelim'] : 'TBA'; ?>"></td>
<td><input type="text" class="form-control" name="midterm_grade" oninput="calculateAverage(this.parentNode.parentNode)" value="<?php echo !empty($row_grades['midterm']) ? $row_grades['midterm'] : 'TBA'; ?>"></td>
<td><input type="text" class="form-control" name="finals_grade" oninput="calculateAverage(this.parentNode.parentNode)" value="<?php echo !empty($row_grades['finals']) ? $row_grades['finals'] : 'TBA'; ?>"></td>
<td class="average"><?php echo !empty($row_grades['average']) ? $row_grades['average'] : 'TBA'; ?></td>
<td class="remarks" style="color: 
    <?php 
    if ($row_grades['remarks'] === 'PASSED') {
        echo 'green';
    } elseif ($row_grades['remarks'] === 'FAILED') {
        echo 'red';
    } else {
        echo 'yellow';
    }
    ?>
; font-weight:bold;"><?php echo !empty($row_grades['remarks']) ? $row_grades['remarks'] : 'TBA'; ?></td>


        <td><button class="btn btn-sm btn-primary" id="save">Save</button></td>
    </tr>
<?php } ?>

                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>
<script>
document.addEventListener("DOMContentLoaded", function() {
    // Add event listeners to all save buttons
    var saveButtons = document.querySelectorAll('#save');
    saveButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            var row = this.parentNode.parentNode;
            var prelimGrade = row.querySelector('input[name="prelim_grade"]').value;
            var midtermGrade = row.querySelector('input[name="midterm_grade"]').value;
            var finalsGrade = row.querySelector('input[name="finals_grade"]').value;
            var average = row.querySelector('.average').textContent;
            var remarks = row.querySelector('.remarks').textContent;
            var subject = row.querySelector('td:first-child').textContent; // Get the subject name

            // AJAX request to insert data into studentgrades table
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "../config/saveGrades.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        // Handle success
                        console.log(xhr.responseText);
                        // Parse the response to check if the save was successful
                        var response = JSON.parse(xhr.responseText);
                        if (response.success) {
                            // Show success message
                            var successMessage = document.createElement('div');
                            successMessage.classList.add('alert', 'alert-success', 'alert-dismissible');
                            successMessage.innerHTML = response.message + '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
                            document.body.prepend(successMessage);
                        } else {
                            // Show error message if save was not successful
                            console.error('Save operation failed');
                        }
                    } else {
                        // Handle error
                        console.error(xhr.statusText);
                    }
                }
            };
            // Include subject in the data being sent
            var data = "prelim_grade=" + prelimGrade + "&midterm_grade=" + midtermGrade + "&finals_grade=" + finalsGrade + "&average=" + average + "&remarks=" + remarks + "&username=<?php echo $username; ?>&course=<?php echo $course; ?>&year=<?php echo $year; ?>&subject=" + encodeURIComponent(subject);
            xhr.send(data);
        });
    });
});

</script>

<script src="../assets/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
