
<?php
// Include the database configuration file
include 'dbcon.php';

// Check if the ID parameter is set and not empty
if (isset($_POST['id']) && !empty($_POST['id'])) {
    // Sanitize the input to prevent SQL injection
    $student_id = mysqli_real_escape_string($conn, $_POST['id']);

    // Query to fetch student details and associated appointment date and time
    $sql = "SELECT ei.*, es.date AS appointment_date, es.start_time AS appointment_time 
        FROM enrollment_info ei 
        LEFT JOIN enrollment_schedule es ON ei.appointment_id = es.id
        WHERE ei.status = 'Pending' and ei.username like '%@student%' ";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Fetch student details and appointment information
        $row = $result->fetch_assoc();

        // Construct HTML content to display student details and appointment information with input fields
        $html_content = "
            <h3>Student Details</h3>
            <div class='table-responsive'>
                <table class='table table-bordered'>
                    <tbody>
                        <tr>

                            <td style='border: 1px solid #bcbcbc;'><label for='appointment_date'>Appointment Date:</label></td>
                            <td style='border: 1px solid #bcbcbc;'><input type='date' class='form-control' id='appointment_date' name='appointment_date' value='{$row['appointment_date']}' readonly></td>
                        </tr>
                        <tr>
                            <td style='border: 1px solid #bcbcbc;'><label for='appointment_time'>Appointment Time:</label></td>
                            <td style='border: 1px solid #bcbcbc;'><input type='time' class='form-control' id='appointment_time' name='appointment_time' value='{$row['appointment_time']}' readonly></td>
                        </tr>
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
                            <td style='border: 1px solid #bcbcbc;'><input type='text' class='form-control' id='course' name='course' value='{$row['course']}'></td>
                        </tr>
                        <tr>
                            <td style='border: 1px solid #bcbcbc;'><label for='year'>Year:</label></td>
                            <td style='border: 1px solid #bcbcbc;'><input type='text' class='form-control' id='year' name='year' value='{$row['year']}'></td>
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
