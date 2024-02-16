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

    <link rel="canonical" href="https://getbootstrap.com/docs/5.0/examples/navbars/">
    <link rel="icon" href="img/cookie.png" type="image/png">
    <link href="../assets/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.14.0/css/all.css">

</head>

<body>
<div class="container-fluid">
    <div class="row">
        <?php include "../includes/sidebar.php"; ?>

        <!-- start of contents -->
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
            <!-- content -->
            <div class="shadow p-3 mb-5 bg-body round">
                <div class="container mt-3">
                    <h2>Class List</h2>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="course" class="form-label">Course</label>
                            <select class="form-select" id="course" name="course">
                                <option value="">Select a Course</option>
                                <option value="BS Computer Engineering">BS Computer Engineering</option>
                                <option value="BS Computer Science">BS Computer Science</option>
                                <option value="BS Information Technology">BS Information Technology</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="year" class="form-label">Year</label>
                            <select class="form-select" id="year" name="year">
                                <option value="">Select a year</option>
                                <option value="I">I</option>
                                <option value="II">II</option>
                                <option value="III">III</option>
                                <option value="IV">IV</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="section" class="form-label">Section</label>
                            <select class="form-select" id="section" name="section">
                                <option value="">Select a section</option>
                                <option value="A">A</option>
                                <option value="B">B</option>
                                <option value="C">C</option>
                                <option value="D">D</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="shadow p-3 mb-5 bg-body round">
                <div class="table-responsive">
                    <table class="table" id="studentTable">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Username</th>
                                <th>Course</th>
                                <th>Year</th>
                                <th>Section</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Prepare and execute SQL query to retrieve all students
                            $stmt = $conn->prepare("SELECT first_name, last_name, username, course, year, section FROM enrollment_info WHERE username LIKE '%@student%' AND status = 'Accepted'");
                            $stmt->execute();
                            $result = $stmt->get_result();

                            // Check if there are any rows returned
                            if ($result->num_rows > 0) {
                                // Output data of each row
                                while ($row = $result->fetch_assoc()) {
                                    // Output data in table rows
                                    echo "<tr>";
                                    echo "<td>" . $row["first_name"] . " " . $row["last_name"] . "</td>";
                                    echo "<td>" . $row["username"] . "</td>";
                                    echo "<td>" . $row["course"] . "</td>";
                                    echo "<td>" . $row["year"] . "</td>";
                                    echo "<td>" . $row["section"] . "</td>";
                                    echo "<td>";
                                    // Action button can go here
                                    echo "<a href='viewGrades.php?username=" . $row["username"] . "' class='btn btn-sm btn-primary'>View</a>";
                                    echo "</td>";
                                    echo "</tr>";
                                }
                            } else {
                                // If no students found, display a message
                                echo "<tr><td colspan='6'>No students found</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Function to filter table based on selected criteria
        function filterTable() {
            var course = document.getElementById("course").value;
            var year = document.getElementById("year").value;
            var section = document.getElementById("section").value;

            var rows = document.getElementById("studentTable").querySelectorAll("tbody tr");

            rows.forEach(function(row) {
                var cells = row.querySelectorAll("td");

                var courseMatch = cells[2].textContent === course || course === "";
                var yearMatch = cells[3].textContent === year || year === "";
                var sectionMatch = cells[4].textContent === section || section === "";

                if (courseMatch && yearMatch && sectionMatch) {
                    row.style.display = "";
                } else {
                    row.style.display = "none";
                }
            });
        }

        // Add event listeners to select elements for filtering
        document.getElementById("course").addEventListener("change", filterTable);
        document.getElementById("year").addEventListener("change", filterTable);
        document.getElementById("section").addEventListener("change", filterTable);
    });
</script>
<script src="../assets/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
