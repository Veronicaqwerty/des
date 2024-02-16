<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve selected values from the form
    $course = $_POST['course'];
    $year = $_POST['year'];
    $section = $_POST['section'];
    $username = $_POST['username'];
    
    // Prepare and execute SQL query to retrieve students
    $stmt = $conn->prepare("SELECT first_name, last_name, username FROM enrollment_info WHERE username LIKE '%@student%' AND course = ? AND year = ? AND section = ? AND status = 'Accepted'");
    $stmt->bind_param("sss", $course, $year, $section);
    $stmt->execute();
    $result = $stmt->get_result();

    if username=stripos(@student){
        if status == "Accepted" {

    // Check if there are any rows returned
    if ($result->num_rows > 0) {
        // Output data of each row
        while ($row = $result->fetch_assoc()) {
            // Output data in table rows
            echo "<tr>";
            echo "<td>" . $row["first_name"] . " " . $row["last_name"] . "</td>";
            echo "<td>" . $username . "</td>";
            echo "<td>" . $course . "</td>";
            echo "<td>" . $year . "</td>";
            echo "<td>" . $section . "</td>";
            echo "<td>";
            // Action buttons can go here
            echo "<button class='btn btn-sm btn-primary'>Edit</button>";
            echo "<button class='btn btn-sm btn-danger'>Delete</button>";
            echo "</td>";
            echo "</tr>";
        }
    } else {
        // If no students found, display a message
        echo "<tr><td colspan='6'>No students found</td></tr>";
    }
    $stmt->close();
}
}
}


?>
