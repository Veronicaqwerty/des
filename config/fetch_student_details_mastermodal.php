
<?php
// Include the database configuration file
include 'dbcon.php';

// Check if the ID parameter is set and not empty
if (isset($_POST['id']) && !empty($_POST['id'])) {
    // Sanitize the input to prevent SQL injection
    $student_id = mysqli_real_escape_string($conn, $_POST['id']);

    // Query to fetch student details and associated appointment date and time
    $sql = "SELECT ei.*, ai.appointment_date, ai.appointment_time 
            FROM enrollment_info ei 
            LEFT JOIN appointment_info ai ON ei.appointment_id = ai.appointment_id
            WHERE ei.id = $student_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Fetch student details and appointment information
        $row = $result->fetch_assoc();

        // Construct HTML content to display student details and appointment information with input fields
        $html_content = "
            <h3>Student Details</h3>
            <form method='post' action='../config/update_student.php'> 
                <input type='hidden' name='student_id' value='$student_id'> <!-- Include the student ID as a hidden field -->
                <div class='table-responsive'>
                    <table class='table table-bordered'>
                        <tbody>

                        <tr>
                            <td style='border: 1px solid #bcbcbc;'><label for='username'>Username:</label></td>
                            <td style='border: 1px solid #bcbcbc;'><input type='text' class='form-control' id='username' name='username' value='{$row['username']}'></td>
                        </tr>
                        <tr>
                            <td style='border: 1px solid #bcbcbc;'><label for='email'>Email:</label></td>
                            <td style='border: 1px solid #bcbcbc;'><input type='email' class='form-control' id='email' name='email' value='{$row['email']}'></td>
                        </tr>
                        <tr>
                            <td style='border: 1px solid #bcbcbc;'><label for='password'>Password:</label></td>
                            <td style='border: 1px solid #bcbcbc;'><input type='password' class='form-control' id='password' name='password' value='{$row['password']}'></td>
                        </tr>
                        <tr>
                            <td style='border: 1px solid #bcbcbc;'><label for='first_name'>First Name:</label></td>
                            <td style='border: 1px solid #bcbcbc;'><input type='text' class='form-control' id='first_name' name='first_name' value='{$row['first_name']}'></td>
                        </tr>
                        <tr>
                            <td style='border: 1px solid #bcbcbc;'><label for='middle_name'>Middle Name:</label></td>
                            <td style='border: 1px solid #bcbcbc;'><input type='text' class='form-control' id='middle_name' name='middle_name' value='{$row['middle_name']}'></td>
                        </tr>
                        <tr>
                            <td style='border: 1px solid #bcbcbc;'><label for='last_name'>Last Name:</label></td>
                            <td style='border: 1px solid #bcbcbc;'><input type='text' class='form-control' id='last_name' name='last_name' value='{$row['last_name']}'></td>
                        </tr>
                        <tr>
                            <td style='border: 1px solid #bcbcbc;'><label for='sex'>Sex:</label></td>
                            <td style='border: 1px solid #bcbcbc;'>
                                <select class='form-control' id='sex' name='sex'>
                                    <option value='Male' " . ($row['sex'] == 'Male' ? 'selected' : '') . ">Male</option>
                                    <option value='Female' " . ($row['sex'] == 'Female' ? 'selected' : '') . ">Female</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td style='border: 1px solid #bcbcbc;'><label for='course'>Course:</label></td>
                            <td style='border: 1px solid #bcbcbc;'>
                            <select class='form-control' id='course' name='course'>
                                    <option value='BS Information Technology' " . ($row['course'] == 'BS Information Technology' ? 'selected' : '') . ">BS Information Technology</option>
                                    <option value='BS Computer Science' " . ($row['course'] == 'BS Computer Science' ? 'selected' : '') . ">BS Computer Science</option>
                                    <option value='BS Computer Engineering' " . ($row['course'] == 'BS Computer Engineering' ? 'selected' : '') . ">BS Computer Engineering</option>
                                </select>
                                </td>
                        </tr>
                        <tr>
                            <td style='border: 1px solid #bcbcbc;'><label for='year'>Year:</label></td>
                            <td style='border: 1px solid #bcbcbc;'>
                            <select class='form-control' id='year' name='year'>
                                    <option value='I' " . ($row['year'] == 'I' ? 'selected' : '') . ">I</option>
                                    <option value='II' " . ($row['year'] == 'II' ? 'selected' : '') . ">II</option>
                                    <option value='III' " . ($row['year'] == 'III' ? 'selected' : '') . ">III</option>
                                    <option value='IV' " . ($row['year'] == 'IV' ? 'selected' : '') . ">IV</option>
                                </select></td>
                        </tr>
                        <tr>
                            <td style='border: 1px solid #bcbcbc;'><label for='birthdate'>Birthdate:</label></td>
                            <td style='border: 1px solid #bcbcbc;'><input type='date' class='form-control' id='birthdate' name='birthdate' value='{$row['birthdate']}'></td>
                        </tr>
                        <tr>
                            <td style='border: 1px solid #bcbcbc;'><label for='home_address'>Home Address:</label></td>
                            <td style='border: 1px solid #bcbcbc;'><textarea class='form-control' id='home_address' name='home_address'>{$row['home_address']}</textarea></td>
                        </tr>
                        <tr>
                            <td style='border: 1px solid #bcbcbc;'><label for='phone_number'>Phone Number:</label></td>
                            <td style='border: 1px solid #bcbcbc;'><input type='text' class='form-control' id='phone_number' name='phone_number' value='{$row['phone_number']}'></td>
                        </tr>
                        <tr>
                            <td style='border: 1px solid #bcbcbc;'><label for='guardian_name'>Guardian Name:</label></td>
                            <td style='border: 1px solid #bcbcbc;'><input type='text' class='form-control' id='guardian_name' name='guardian_name' value='{$row['guardian_name']}'></td>
                        </tr>
                        <tr>
                            <td style='border: 1px solid #bcbcbc;'><label for='guardian_phone_number'>Guardian Phone Number:</label></td>
                            <td style='border: 1px solid #bcbcbc;'><input type='text' class='form-control' id='guardian_phone_number' name='guardian_phone_number' value='{$row['guardian_phone_number']}'></td>
                        </tr>
                        <tr>
                            <td style='border: 1px solid #bcbcbc;'><label for='guardian_address'>Guardian Address:</label></td>
                            <td style='border: 1px solid #bcbcbc;'><textarea class='form-control' id='guardian_address' name='guardian_address'>{$row['guardian_address']}</textarea></td>
                        </tr>
                        <tr>
                            <td style='border: 1px solid #bcbcbc;'><label for='elementary_school'>Elementary School:</label></td>
                            <td style='border: 1px solid #bcbcbc;'><input type='text' class='form-control' id='elementary_school' name='elementary_school' value='{$row['elementary_school']}'></td>
                        </tr>
                        <tr>
                            <td style='border: 1px solid #bcbcbc;'><label for='elementary_graduation_year'>Elementary Graduation Year:</label></td>
                            <td style='border: 1px solid #bcbcbc;'><input type='text' class='form-control' id='elementary_graduation_year' name='elementary_graduation_year' value='{$row['elementary_graduation_year']}'></td>
                        </tr>
                        <tr>
                            <td style='border: 1px solid #bcbcbc;'><label for='junior_high_school'>Junior High School:</label></td>
                            <td style='border: 1px solid #bcbcbc;'><input type='text' class='form-control' id='junior_high_school' name='junior_high_school' value='{$row['junior_high_school']}'></td>
                        </tr>
                        <tr>
                            <td style='border: 1px solid #bcbcbc;'><label for='junior_high_graduation_year'>Junior High Graduation Year:</label></td>
                            <td style='border: 1px solid #bcbcbc;'><input type='text' class='form-control' id='junior_high_graduation_year' name='junior_high_graduation_year' value='{$row['junior_high_graduation_year']}'></td>
                        </tr>
                        <tr>
                            <td style='border: 1px solid #bcbcbc;'><label for='senior_high_school'>Senior High School:</label></td>
                            <td style='border: 1px solid #bcbcbc;'><input type='text' class='form-control' id='senior_high_school' name='senior_high_school' value='{$row['senior_high_school']}'></td>
                        </tr>
                        <tr>
                            <td style='border: 1px solid #bcbcbc;'><label for='senior_high_graduation_year'>Senior High Graduation Year:</label></td>
                            <td style='border: 1px solid #bcbcbc;'><input type='text' class='form-control' id='senior_high_graduation_year' name='senior_high_graduation_year' value='{$row['senior_high_graduation_year']}'></td>
                        </tr>
                        <!-- Add more rows for other input fields -->
                    </tbody>
                    </table>
                    </div>
                <div class='modal-footer'>
    <!-- Update button -->
    <button type='submit' class='btn btn-success update-button'>Update</button>

</div>


            </form>
        ";

        // Output HTML content
        echo $html_content;
    } else {
        echo "<p>No student found with the provided ID.</p>";
    }
} else {
    echo "<p>Invalid request.</p>";
}

// Close the database connection
$conn->close();
?>
<!-- JavaScript -->
<script>
    // Attach click event listener to the "Update" button
    var updateButton = document.querySelector('.update-button');
    updateButton.addEventListener('click', function() {
        // Fetch updated information from form fields
        var formData = new FormData(document.querySelector('form'));

        // AJAX call to update the information
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (this.readyState == 4) {
                if (this.status == 200) {
                    // Handle success response if needed
                    console.log('Information updated successfully');
                    // Close the modal or do other actions
                } else {
                    // Handle server-side errors or other issues
                    console.error('Error updating information:', this.status, this.statusText);
                }
            }
        };
        xhr.open("POST", "update_student.php", true);
        xhr.send(formData);
    });

     // Function to confirm dropping a student
    function confirmDrop(studentId) {
        var confirmation = confirm("Are you sure you want to drop this student?");
        if (confirmation) {
            // User confirmed, proceed with dropping the student
            dropStudent(studentId);
        }
    }

    // Function to drop the student via AJAX
    function dropStudent(studentId) {
        // AJAX call to delete the information
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (this.readyState == 4) {
                try {
                    var response = JSON.parse(this.responseText);

                    if (response.status === 'success') {
                        // Handle success response if needed
                        console.log(response.message);
                        // Close the modal or do other actions

                        // Reload the page after dropping the student
                        window.location.href = window.location.href;
                    } else {
                        // Handle server-side errors or other issues
                        console.error('Error deleting information:', response.message);
                    }
                } catch (e) {
                    console.error('Error parsing response:', e);
                }
            }
        };
        xhr.open("POST", "drop_student.php", true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.send("id=" + studentId);
    }
</script>