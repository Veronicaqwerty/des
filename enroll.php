<?php
include "config/dbcon.php";
include "config/loginAuth.php";



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <title>Enroll</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="canonical" href="https://getbootstrap.com/docs/5.0/examples/navbars/">
    <link rel="icon" href="img/cookie.png" type="image/png">
    <link href="assets/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!-- Bootstrap JavaScript -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
   <style>
        /* Add the desired padding to the container */
        .content-container {
            padding: 0 250px;
        }
        th {
        font-size: 20px; /* Adjust the font size as needed */
        padding: 10px; /* Adjust the padding as needed */
    }
    td {
        font-size: 20px; /* Adjust the font size as needed */
        padding: 10px; /* Adjust the padding as needed */
    }
    
    </style>
<body>
    <?php include "./includes/navbar.php"; ?>
    <!-- Add this code to your enroll.php page where you want the modal to appear -->
<div class="modal fade" id="noSubjectsModal" tabindex="-1" role="dialog" aria-labelledby="noSubjectsModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="noSubjectsModalLabel">No Subjects Available</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        No subjects available for enrollment for the selected course and year. Please contact the administration.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<?php
// Check if the success query parameter is present
if (isset($_GET['success']) && $_GET['success'] === 'true') {
    echo '<div class="alert alert-success alert-dismissible text-center" style="margin: 0">
    YOUR SUBMISSION IS WAITING FOR APPROVAL, YOU CAN PROCEED TO THE REGISTRAR TO ENROLL YOUR APPLICATION AND ACCOUNT
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
';
}
?>
<?php
  // Check if there is a success message in session
  if (isset($_SESSION['success_message'])) {
    echo '<div class="alert alert-success alert-dismissible text-center" role="alert"  style="margin: 0">
            ' . $_SESSION['success_message'] . '
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
    // Remove the success message from session
    unset($_SESSION['success_message']);
  }
?>  


 <div class="content-container">
<!-- <div class="container-fluid" style="margin-top: 60px;"> -->
    <div class="row" style="margin-top: 30px;">
        <div class="col-sm mt-3 ml-3 mr-3" >
            <div class="min-vh-80 shadow p-3 mb-5 bg-white rounded">
                <form action="config/insert_enrollment.php" method="POST" onsubmit="setAppointmentId()">

                    <h2>Select Your Appointment Schedule</h2>
    <div class="table-responsive table-bordered">
        <table class="table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Slots</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
// Include the database configuration file
include './config/dbcon.php';

// Fetch data from the enrollment_schedule table
$sql = "SELECT * FROM enrollment_schedule WHERE slots > 0";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Output data of each row
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        // Convert date string to DateTime object
$date = new DateTime($row['date']);

// Format the date as "F d, Y | l" (e.g., "February 22, 2024 | Thursday")
$formattedDate = $date->format("F d, Y | l");

// Format the time as "h:i A - h:i A" (e.g., "06:50 AM - 07:50 AM")
$formattedTime = date("h:i A", strtotime($row['start_time'])) . " - " . date("h:i A", strtotime($row['end_time']));

echo "<td>" . $formattedDate . "</td>";
echo "<td>" . $formattedTime . "</td>";

        echo "<td>" . $row['slots'] . "</td>";
       echo "<td><input type='radio' name='appointment_id' value='" . $row['id'] . "' required></td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='4'>No appointment schedules available.</td></tr>";
}
$conn->close();
?>

            </tbody>
        </table>
    </div>
    <!-- Hidden input fields to store the selected appointment time and date -->
    <input type="hidden" name="appointment_time" id="appointment_time">
    <input type="hidden" name="appointment_date" id="appointment_date">
    <input type="hidden" name="appointment_id" id="appointment_id">
</div>
            </div>
        </div>
    <!-- </div> -->



    <script>
function setAppointmentId() {
    var appointmentRadios = document.getElementsByName("appointment_id");
    var selectedAppointmentId = "";

    // Loop through radio buttons to find the selected one
    for (var i = 0; i < appointmentRadios.length; i++) {
        if (appointmentRadios[i].checked) {
            selectedAppointmentId = appointmentRadios[i].value;
            break;
        }
    }

    // Set the value of the hidden input field
    document.getElementById("appointment_id").value = selectedAppointmentId;
}
            </script>

    <!-- Ensure to call the JavaScript function on form submission -->
    <script>
        // Call the setAppointmentId function before form submission
        document.querySelector("form").addEventListener("submit", setAppointmentId);
    </script>



    <div class="row">
        <div class="col-sm mt-3 ml-3 mr-3">
            <div class="min-vh-80 shadow p-3 mb-5 bg-white rounded">
                <h2>I. Create Your Student Portal Account</h2>
                <div class="card">
                    <div class="card-body">
                            <div class="form-group">
                                <div class="input-group">
    <input type="text" placeholder="Username" class="form-control" id="username" name="username" required>
    <input type="text" class="form-control" id="display-username" value="@student" readonly>
</div>

<script>
    // Get the input field for username
    var usernameInput = document.getElementById("username");
    
    // Get the input field to display the combined username
    var displayUsernameInput = document.getElementById("display-username");
    
    // Add event listener to the username input field
    usernameInput.addEventListener("input", function() {
        // Get the value entered by the user
        var enteredUsername = usernameInput.value;
        
       
    });
</script>

                            </div>
                            <div class="form-group">
                                <label for="email">Email Address</label>
                                <input type="email" placeholder="Email Address" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" placeholder="Password" class="form-control" id="password" name="password" required>
                            </div>
                    </div>
                </div>
            </div>
        </div>


<div class="row">
        <div class="col-sm mt-3 ml-3 mr-3">
            <div class="min-vh-80 shadow p-3 mb-5 bg-white rounded">
                <h2>I. Create Your Student Portal Account</h2>
                <h2>II. Educational Attainment</h2>
                <div class="card">
                    <div class="card-body">
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label for="elementarySchool">Elementary</label>
                                    <input type="text" class="form-control" id="elementarySchool" name="elementarySchool" placeholder="School Name" required>
                                </div>
                                <div class="col-md-6">
                                    <label>&nbsp;</label>
                                    <input type="number" class="form-control" id="elementaryGraduationYear" name="elementaryGraduationYear" placeholder="Graduation Year" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label for="juniorHighSchool">Junior High School</label>
                                    <input type="text" class="form-control" id="juniorHighSchool" name="juniorHighSchool" placeholder="School Name" required>
                                </div>
                                <div class="col-md-6">
                                    <label>&nbsp;</label>
                                    <input type="number" class="form-control" id="juniorHighGraduationYear" name="juniorHighGraduationYear" placeholder="Graduation Year" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label for="seniorHighSchool">Senior High School</label>
                                    <input type="text" class="form-control" id="seniorHighSchool" name="seniorHighSchool" placeholder="School Name" required>
                                </div>
                                <div class="col-md-6">
                                    <label>&nbsp;</label>
                                    <input type="number" class="form-control" id="seniorHighGraduationYear" name="seniorHighGraduationYear" placeholder="Graduation Year" required>
                                </div>
                            </div>
                    </div>
                </div>
            
        </div>

<div class="row">
        <div class="col-sm mt-3 ml-3 mr-3">
            <div class="min-vh-80 shadow p-3 mb-5 bg-white rounded">
                <h2>I. Create Your Student Portal Account</h2>
                <h2>III. Enrollment Form</h2>
                <div class="card">
                    <div class="card-body">
                            <div>
                                <div class="col-md">
                                    <label for="firstName">First Name</label>
                                    <input type="text" placeholder="First Name" class="form-control" id="firstName" name="firstName" required>
                                </div>
                                <div class="col-md
                                ">
                                    <label for="middleName">Middle Name</label>
                                    <input type="text" placeholder="Middle Name" class="form-control" id="middleName" name="middleName" required>
                                </div>
                                <div class="col-md">
                                    <label for="lastName">Last Name</label>
                                    <input type="text" placeholder="Last Name" class="form-control" id="lastName" name="lastName" required>
                                </div>
                                <div class="col-md">
    <label for="sex">Sex</label>
    <select class="form-control" id="sex" name="sex" required onchange="disableChooseOption(this)">
        <option disabled selected>Choose...</option>
        <option>Male</option>
        <option>Female</option>
    </select>
</div>
<div class="col-md">
    <label for="course">Course</label>
    <select class="form-control" id="course" name="course" required onchange="disableChooseOption(this)" required>
        <option disabled selected>Choose...</option>
        <option>BS Information Technology</option>
        <option>BS Computer Science</option>
        <option>BS Computer Engineering</option>
    </select>
</div>
<div class="col-md">
    <label for="year">Year</label>
    <select class="form-control" id="year" name="year" required onchange="disableChooseOption(this)" required>
        <option disabled selected>Choose...</option>
        <option>I</option>
        <option>II</option>
        <option>III</option>
        <option>IV</option>                                  
    </select>
</div>

                                <div class="col-md">
                                    <label for="birthdate">Birthdate</label>
                                    <input type="date" placeholder="Birthdate" class="form-control" name="birthdate" required>
                                </div>

                               <div class="col-md">
                                <label for="homeAddress">Home Address</label>
                                <textarea class="form-control" id="homeAddress" name="homeAddress" rows="4" required></textarea>
                            </div>


                                <div class="col-md">
                                    <label for="phoneNumber">Phone Number</label>
                                    <input type="text" placeholder="Phone Number" class="form-control" id="phoneNumber" name="phoneNumber" required>
                                </div>


                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label for="guardianName">Guardian Name</label>
                                             <input type="text" placeholder="Guardian Name" class="form-control" id="guardianName" name="guardianName" required>
                                         </div>
                                         <div class="col-md-4">
                                            <label for="guardianPhoneNumber">Guardian Phone Number</label>
                                            <input type="text" placeholder="Guardian PhoneNumber" class="form-control" id="guardianPhoneNumber" name="guardianPhoneNumber" required>
                                        </div>
                                         </div>
                                     </div>


                                <div class="col-md">
                                    <label for="guardianAddress">Guardian Address</label>
                                    <textarea class="form-control adjustable-input" id="guardianAddress" name="guardianAddress" rows="4" required></textarea>
                                </div>

                        <!-- Data Privacy Notice -->
                            <div class="form-group">
                                <h4>Data Privacy Notice</h4>
                                <p>
                                    Before you submit any personal information to our website, please take a moment to read this data privacy notice. We are committed to protecting your personal information and ensuring that your privacy is respected. We comply with the Data Privacy Act of the Philippines and other applicable data protection laws.
                                </p>
                                <h5>What personal information do we collect?</h5>
                                <p>We may collect personal information such as your name, email address, phone number, and other details that you provide when you fill out a form or interact with our website.</p>
                                <h5>How do we use your personal information?</h5>
                                <p>We may use your personal information to provide you with the services or information that you have requested, to respond to your inquiries, and to improve our website and services. We may also use your personal information for other purposes that are compatible with the original purpose of collection or as required by law.</p>
                                <h5>Do we share your personal information?</h5>
                                <p>We do not sell, trade, or otherwise transfer your personal information to outside parties unless we provide you with advance notice or as required by law.</p>
                                <h5>How do we protect your personal information?</h5>
                                <p>We implement a variety of security measures to protect your personal information from unauthorized access, use, or disclosure. We use industry-standard encryption technology and other reasonable measures to safeguard your personal information.</p>
                                <h5>What are your rights?</h5>
                                <p>You have the right to access, correct, and delete your personal information that we have collected. You may also withdraw your consent to our processing of your personal information at any time. To exercise your rights, please contact us using the contact details provided on our website.</p>
                                <h5>Changes to this notice</h5>
                                <p>We may update this data privacy notice from time to time. Any changes will be posted on our website, and the revised notice will apply to personal information collected after the date it is posted.</p>
                                <h5>Contact us</h5>
                                <p>If you have any questions or concerns about our data privacy practices, please contact us by clicking this  <a href="contactUs.php">link</a>.</p>
                            </div>

                            <!-- Submit Button -->
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                       

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include "includes/loginModal.php";

?>
<script>
function disableChooseOption(selectElement) {
    var options = selectElement.options;
    for (var i = 0; i < options.length; i++) {
        if (options[i].value === 'Choose...') {
            options[i].disabled = true;
        }
    }
}
</script>
<script src="assets/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
