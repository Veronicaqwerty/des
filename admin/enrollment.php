
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
    <title>CMS</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="canonical" href="https://getbootstrap.com/docs/5.0/examples/navbars/">
    <link rel="icon" href="img/cookie.png" type="image/png">
    <link href="../assets/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</head>
<body>

    <div class="container-fluid">
        <div class="row">
            <?php include "../includes/sidebar.php"; ?>
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

        <div class="col-sm mt-3 ml-3 mr-3">
            <?php
// Check if there is an error message
if (isset($error_message) && !empty($error_message)) {
    echo '<div class="alert alert-danger alert-dismissible text-center" style="margin: 0">
        ' . $error_message . '
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>';
}

// Check if there is a success message
if (isset($_GET['success']) && $_GET['success'] === 'true') {
    echo '<div class="alert alert-success alert-dismissible text-center" style="margin: 0">
        Schedule Added
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>';
}

?>
            <!-- ENROLLMENT SCHEDULING -->
        <div class="col-sm mt-3 ml-3 mr-3 min-vh-80 shadow p-3 mb-5 bg-white rounded">
            <h2>Enrollment Scheduling</h2>
        <div class="table-responsive table-bordered">
            <table class="table">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Start Time</th>
                        <th>End Time</th>
                        <th>Slots</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
<?php



// Fetch data from the database
$sql = "SELECT * FROM enrollment_schedule";
$result = $conn->query($sql);

// Check if there are any records
if ($result->num_rows > 0) {
    // Output data of each row
    while($row = $result->fetch_assoc()) {
        // Check if slots are available
        if ($row['slots'] > 0) {
            echo "<tr>";
            echo "<td>" . $row['date'] . "</td>";
            // Convert start time to 12-hour format
            echo "<td>" . date('h:i A', strtotime($row['start_time'])) . "</td>";
            // Convert end time to 12-hour format
            echo "<td>" . date('h:i A', strtotime($row['end_time'])) . "</td>";
            echo "<td>" . $row['slots'] . "</td>";
            echo "<td>";
            // Delete button with form
            echo "<form action='../config/delete_schedule.php' method='post'>";
            echo "<input type='hidden' name='schedule_id' value='" . $row['id'] . "'>";
            echo "<button type='submit' class='btn btn-danger'>Delete</button>";
            echo "</form>";
            echo "</td>";
            echo "</tr>";
        }
    }
} else {
    echo "<tr><td colspan='5'>No records found</td></tr>";
}

?>

                    <!-- Form for adding new schedule -->
                    <tr>
                        <form action="../config/insert_schedule.php" method="post" id="addScheduleForm">
                            <td><input type="date" class="form-control" name="date" required></td>
                            <td><input type="time" class="form-control" name="start_time" id="start_time" onchange="calculateEndTime()" required></td>
                            <td><input type="time" class="form-control" name="end_time" id="end_time" readonly required></td>
                            <td><input type="number" class="form-control" name="slots" required></td>
                            <td>
                                <button type="submit" class="btn btn-primary">Add</button>
                            </td>
                        </form>
                    </tr>
                </tbody>
            </table>
</div>
</div>

<!-- STUDENT APPROVAL REQUEST --><!-- STUDENT APPROVAL REQUEST --><!-- STUDENT APPROVAL REQUEST --><!-- STUDENT APPROVAL REQUEST --><!-- STUDENT APPROVAL REQUEST --><!-- STUDENT APPROVAL REQUEST --><!-- STUDENT APPROVAL REQUEST --><!-- STUDENT APPROVAL REQUEST -->
<!-- STUDENT APPROVAL REQUEST --><!-- STUDENT APPROVAL REQUEST --><!-- STUDENT APPROVAL REQUEST --><!-- STUDENT APPROVAL REQUEST -->
<!-- STUDENT APPROVAL REQUEST -->
<!-- STUDENT APPROVAL REQUEST -->
<div class="col-sm">
    <div class="min-vh-80 shadow p-3 mb-5 bg-white rounded">
        <h2>Student Approval Requests</h2>
        <div class="table-responsive table-bordered">
            <table class="table">
                <thead>
                    <tr>
                        <th>Appointment Date</th>
                        <th>Time</th>
                        <th>Username</th>
                        <th>Name</th>
                        <th>Course</th>
                        <th>Year</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
 

                        // Fetch data from the enrollment_info and appointment_info tables where status is 'Pending'
                        $sql = "SELECT ei.*, es.date AS appointment_date, es.start_time AS appointment_time 
        FROM enrollment_info ei 
        LEFT JOIN enrollment_schedule es ON ei.appointment_id = es.id
        WHERE ei.status = 'Pending' and ei.username like '%@student%' ";


                        $result = $conn->query($sql);

                        // Check if the query was successful
                        if ($result) {
                            // Output data
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>{$row['appointment_date']}</td>";
                                echo "<td>{$row['appointment_time']}</td>";
                                echo "<td>{$row['username']}</td>";
                                echo "<td>{$row['first_name']} {$row['last_name']}</td>";
                                echo "<td>{$row['course']}</td>";
                                echo "<td>{$row['year']}</td>";
                                echo "<td>{$row['status']}</td>"; // Displaying the status
                                echo "<td><button type='button' class='btn btn-primary open-student-approval-modal' data-bs-toggle='modal' data-bs-target='#student-approval-modal' data-student-id='{$row['id']}'>Open</button></td>";
                                echo "</tr>";
                            }
                        } else {
                            // Handle query errors
                            echo "Error: " . $conn->error;
                        }

     
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Student Approval Request Modal -->
<div class="modal fade" id="student-approval-modal" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Student Details</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body" id="student-details-approval-requests"><!-- Student details will be dynamically loaded here using JavaScript -->
            </div>

            <div class="modal-footer">
    <button type="button" class="btn btn-primary enroll-btn">Enroll</button>
    <button type="button" class="btn btn-danger reject-btn">Reject</button>
</div>

        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Function to enroll a student via AJAX
        function enrollStudent(studentId) {
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    // Enrollment successful, close modal and update page
                    document.querySelector('.modal').classList.remove('show');
                    document.querySelector('.modal-backdrop').remove();
                    updatePage();
                }
            };
            xhr.open("POST", "../config/enroll_student.php", true);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhr.send("id=" + studentId);
        }

        // Function to reject a student via AJAX
        function rejectStudent(studentId) {
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    // Rejection successful, close modal and update page
                    document.querySelector('.modal').classList.remove('show');
                    document.querySelector('.modal-backdrop').remove();
                    updatePage();
                }
            };
            xhr.open("POST", "../config/reject_student.php", true);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhr.send("id=" + studentId);
        }

        // Event listener for the "Enroll" button
        var enrollButton = document.querySelector('.enroll-btn');
        enrollButton.addEventListener('click', function() {
            // Perform AJAX request to enroll the student
            var studentId = document.querySelector('.open-student-approval-modal').getAttribute('data-student-id');
            enrollStudent(studentId);
        });

        // Event listener for the "Reject" button
        var rejectButton = document.querySelector('.reject-btn');
        rejectButton.addEventListener('click', function() {
            // Perform AJAX request to reject the student
            var studentId = document.querySelector('.open-student-approval-modal').getAttribute('data-student-id');
            rejectStudent(studentId);
        });

        // Function to update the page after enrollment or rejection
        function updatePage() {
            // Reload the page to reflect the updated enrollment status
            location.reload();
        }

        // Attach click event listener to all "Open" buttons for the Student Approval Requests modal
        var openButtonsApprovalRequests = document.querySelectorAll('.open-student-approval-modal');
        openButtonsApprovalRequests.forEach(function(button) {
            button.addEventListener('click', function() {
                var studentId = button.getAttribute('data-student-id');
                // AJAX call to fetch student details for the Student Approval Requests modal
                var xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        document.getElementById('student-details-approval-requests').innerHTML = this.responseText;
                    }
                };
                xhr.open("POST", "../config/fetch_student_details.php", true);
                xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhr.send("id=" + studentId);
            });
        });

        // Attach click event listener to all "Open" buttons for the Master List modal
        var openButtonsMasterList = document.querySelectorAll('.open-master-list-modal');
        openButtonsMasterList.forEach(function(button) {
            button.addEventListener('click', function() {
                var studentId = button.getAttribute('data-student-id');
                // AJAX call to fetch student details for the Master List modal
                var xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        document.getElementById('student-details-master-list').innerHTML = this.responseText;
                    }
                };
                xhr.open("POST", "../config/fetch_student_details.php", true);
                xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhr.send("id=" + studentId);
            });
        });
    });
</script>


<!-- MASTER LIST -->
<div class="col-sm-12">
    <div class="min-vh-80 shadow p-3 mb-5 bg-white rounded">
        <h2>Master List</h2>
        <div class="table-responsive table-bordered">
            <table class="table" id="master-list-table">
                <thead>
                    <tr>
                        <th>Username</th>
                        <th>Name</th>
                        <th>Course</th>
                        <th>Year</th>
                        <th>Section</th>
                        <th>Status</th>
                        <th style="width: 15%">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
              

                        // Fetch data from the enrollment_info and appointment_info tables where status is 'Accepted'
                        $sql = "SELECT ei.*, ai.appointment_date, ai.appointment_time FROM enrollment_info ei 
                                LEFT JOIN appointment_info ai ON ei.appointment_id = ai.appointment_id
                                WHERE ei.status = 'Accepted' and ei.username like '%@student%' ";

                        $result = $conn->query($sql);

                        // Check if the query was successful
                        if ($result) {
                            // Output data
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>{$row['username']}</td>";
                                echo "<td>{$row['first_name']} {$row['last_name']}</td>";
                                echo "<td>{$row['course']}</td>";
                                echo "<td>{$row['year']}</td>";
                                echo "<td>{$row['section']}</td>";
                                echo "<td>{$row['status']}</td>"; // Displaying the status
                                echo "<td>
                                <form method='post' action='../drop_student.php'>
                                <input type='hidden' name='student_id' value='{$row['id']}'>
                                <button type='submit' class='btn btn-danger' onclick='return confirm(\"Are you sure you want to drop this student?\")'>Drop</button>
                                </form><button type='button' class='btn btn-primary open-master-list-modal' data-bs-toggle='modal' data-bs-target='#master-list-modal' data-record-id='{$row['id']}'>Open</button></td>";
                                echo "</tr>";
                            }
                        } else {
                            // Handle query errors
                            echo "Error: " . $conn->error;
                        }

                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- MODAL MASTER LIST-->
<div class="modal fade" id="master-list-modal" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body" id="student-details-master-list">
<div class="form-group">
        <label for="input-box">Updated Information:</label>
        <input type="text" class="form-control" id="input-box" placeholder="Enter updated information">
    </div>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Attach click event listener to all "Open" buttons for the Master List modal
        var openButtonsMasterList = document.querySelectorAll('.open-master-list-modal');
        openButtonsMasterList.forEach(function(button) {
            button.addEventListener('click', function() {
                var studentId = button.getAttribute('data-record-id');
                // AJAX call to fetch student details for the Master List modal
                var xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        document.getElementById('student-details-master-list').innerHTML = this.responseText;
                    }
                };
                xhr.open("POST", "../config/fetch_student_details_mastermodal.php", true);
                xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhr.send("id=" + studentId);
            });
        });
    });

</script>







<!-- SUBJECTS -->
<!-- SUBJECTS -->
<div class="col-sm">
    <div class="min-vh-80 shadow p-3 mb-5 bg-white rounded">
        <h2>Subjects</h2>
        <div class="table-responsive table-bordered">
            <table class="table">
                <thead>
                    <tr>
                        <th style="width: 15%">Subject</th>
                        <th style="width: 15%">Course</th>
                        <th style="width: 15%">Instructor</th>
                        <th style="width: 10%">Year</th>
                        <th style="width: 10%">Hours</th>
                        <th style="width: 15%">Actions</th>
                    </tr>
                </thead>
                <tbody>
<?php

// Fetch data from the subjects table
$sql = "SELECT * FROM subjects";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Output data of each row
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . "<input type='text' class='form-control' value='" . $row['subject'] . "' name='subject' required>" . "</td>";

        echo "<td><select class='form-control' name='course' required>";
// Check if the current row's course matches the option, then mark it as selected
echo "<option selected disabled value=''>Select course...</option>";

echo "<option " . (($row['course'] == 'BS Computer Engineering') ? 'selected' : '') . ">BS Computer Engineering</option>";
echo "<option " . (($row['course'] == 'BS Information Technology') ? 'selected' : '') . ">BS Information Technology</option>";
echo "<option " . (($row['course'] == 'BS Computer Science') ? 'selected' : '') . ">BS Computer Science</option>";
echo "</select></td>";


        echo "<td>" . "<input type='text' class='form-control' value='" . $row['instructor'] . "' name='instructor' required>" . "</td>";

        echo "<td>" . "<select class='form-control' name='year' required>";
        // Check if the current row's year matches the option, then mark it as selected
        echo "<option " . (($row['year'] == 'I') ? 'selected' : '') . ">I</option>";
        echo "<option " . (($row['year'] == 'II') ? 'selected' : '') . ">II</option>";
        echo "<option " . (($row['year'] == 'III') ? 'selected' : '') . ">III</option>";
        echo "<option " . (($row['year'] == 'IV') ? 'selected' : '') . ">IV</option>";
        echo "</select>" . "</td>";

        echo "<td>" . "<input type='text' class='form-control' value='" . $row['hours'] . "' name='hours' required>" . "</td>";

        echo "<td>";
        echo "<button type='button' class='btn btn-primary update-btn'>Update</button>";
        echo "<button type='button' class='btn btn-danger -btn'>Delete</button>";
        echo "</td>";

        // Store the subject ID in a data attribute for later use in JavaScript
        echo "<td style='display: none;' data-subject-id='" . $row['id'] . "'></td>";

        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='6'>No subjects found.</td></tr>";
}
?>


 <!-- Add the form for adding a new subject in the last row -->
    <tr>
    <td>
        <input type="text" class="form-control" placeholder="Type a subject" name="subject" required>
    </td>
    <td >
        <select class="form-control" name="course" required>
            <option selected disabled>Select a course</option>
            <option>BS Computer Engineering</option>
            <option>BS Information Technology</option>
            <option>BS Computer Science</option>
        </select>
    </td>
    <td >
        <input type="text" class="form-control" placeholder="Type instructor" name="instructor" required>
    </td>
    <td>
        <select class="form-control" name="year" required>
            <option selected disabled>Select a year</option>
            <option>I</option>
            <option>II</option>
            <option>III</option>
            <option>IV</option>
        </select>
    </td>
    <td>
        <input type="text" class="form-control" placeholder="Type hours" name="hours" required>
    </td>
    <td>
        <button type="submit" class="btn btn-success add-btn">Add</button>
    </td>

                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
    // Update button click event
    $('.update-btn').click(function() {
        var row = $(this).closest('tr');
        var subjectId = row.find('[data-subject-id]').data('subject-id');
        var subject = row.find('[name="subject"]').val();
        var course = row.find('[name="course"]').val();
        var instructor = row.find('[name="instructor"]').val();
        var year = row.find('[name="year"]').val();
        var hours = row.find('[name="hours"]').val();

        // AJAX call to update subject
        $.ajax({
            url: '../config/update_subject.php',
            method: 'POST',
            data: {
                subject_id: subjectId,
                subject: subject,
                course: course,
                instructor: instructor,
                year: year,
                hours: hours
            },
            success: function(response) {
                // Handle success response
                console.log(response);
                // Reload the page after a successful update
                location.reload();
            },
            error: function(xhr, status, error) {
                // Handle error response
                console.error(error);
            }
        });
    });
// Add button click event
$('.add-btn').click(function() {
    // Get new subject data from the last row
    var row = $(this).closest('tr');
    var subject = row.find('[name="subject"]').val();
    var course = row.find('[name="course"]').val();
    var instructor = row.find('[name="instructor"]').val();
    var year = row.find('[name="year"]').val();
    var hours = row.find('[name="hours"]').val();

    // Validate input fields
    if (subject.trim() === '' || course === null || instructor.trim() === '' || year === null || hours.trim() === '') {
        // Display an error message or handle the validation failure as per your UI requirements
        console.error("Please fill in all required fields");
        return;
    }

    // AJAX call to add new subject
    $.ajax({
        url: '../config/add_subject.php',
        method: 'POST',
        data: {
            subject: subject,
            course: course,
            instructor: instructor,
            year: year,
            hours: hours
        },
        success: function(response) {
            // Handle success response
            console.log(response);
            // Reload the page after a successful add
            location.reload();
        },
        error: function(xhr, status, error) {
            // Handle error response
            console.error(error);
        }
    });
});



    // Delete button click event
    $('.delete-btn').click(function() {
        var row = $(this).closest('tr');
        var subjectId = row.find('[data-subject-id]').data('subject-id');

        // AJAX call to delete subject
        $.ajax({
            url: '../config/delete_subject.php',
            method: 'POST',
            data: {
                subject_id: subjectId
            },
            success: function(response) {
                // Handle success response
                console.log(response);
                row.remove(); // Remove row from UI
            },
            error: function(xhr, status, error) {
                // Handle error response
                console.error(error);
            }
        });
    });
});

</script>


</body>
<script src="../assets/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function calculateEndTime() {
        var startTime = document.getElementById('start_time').value;
        var start = new Date("01/01/2022 " + startTime);
        start.setHours(start.getHours() + 1);
        var endHour = ('0' + start.getHours()).slice(-2);
        var endMinute = ('0' + start.getMinutes()).slice(-2);
        document.getElementById('end_time').value = endHour + ":" + endMinute;
    }
</script>
</html>
