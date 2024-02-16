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
    <title>Inbox</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/5.0/examples/navbars/">
    <link rel="icon" href="img/cookie.png" type="image/png">
    <link href="../assets/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.14.0/css/all.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        .unread-row {
            background-color: #ddd !important; /* Red color for unread rows */
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <?php
            include "../includes/sidebar.php";
            ?>
               
            <!-- Start of contents -->
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

                <div class="rounded bg-light p-3 shadow">
                    <div class="container mt-3">
                        <h2>Inbox</h2>
                        <?php
                        // Fetch data from the database
                        $sql = "SELECT id, sender, email, date_time, message, status FROM messages";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            // Display the data in a table
                            echo '<table class="table table-sm table-bordered mt-3">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Sender</th>
                                    <th>Email Address</th>
                                    <th>Date and Time</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>';

                            while ($row = $result->fetch_assoc()) {
                                $rowClass = $row["status"] == 'unread' ? 'unread-row' : ''; // Add unread-row class for unread messages
                                echo '<tr class="' . $rowClass . '">
                                <td>' . $row["id"] . '</td>
                                <td>' . $row["sender"] . '</td>
                                <td>' . $row["email"] . '</td>
                                <td>' . $row["date_time"] . '</td>
                                <td>
                                    <button type="button" class="btn btn-primary btn-sm" onclick="openMessage(\'' . $row["sender"] . '\', \'' . $row["message"] . '\', \'' . $row["id"] . '\')">Open</button>
                                    <form action="../config/deleteMessage.php" method="post" class="d-inline">
                                        <input type="hidden" name="delete_id" value="' . $row["id"] . '">
                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                    </form>
                                </td>
                            </tr>';
                            }

                            echo '</tbody></table>';
                        } else {
                            echo "No messages in the inbox.";

                        }

                        // Close the database connection
                        $conn->close();
                        ?>
                    </div>
                </div>
            </div>
            <!-- End of contents -->

            <!-- The Modal -->
            <div class="modal" id="myModal">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h4 class="modal-title">From: <span id="senderName"></span></h4>
                        </div>
                        <!-- Modal body -->
                        <div class="modal-body">
                            <strong>Message:</strong><br>
                            <div class="container p-4 border border-solid" id="messageContent">
                            </div>
                        </div>
<!-- Modal footer -->
<div class="modal-footer">
    <button type="button" class="btn btn-danger" data-bs-dismiss="modal" onclick="reloadPage()">Close</button>
</div>

                    </div>
                </div>
            </div>

         <script>
    function openMessage(sender, message, messageId) {
        // Open the modal
        var myModal = new bootstrap.Modal(document.getElementById('myModal'));
        myModal.show();

        // Display message content
        document.getElementById('senderName').innerText = sender;
        document.getElementById('messageContent').innerText = message;

        // Update status to 'read' in the database
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "../config/markreadInbox.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                // If the status is updated successfully, you can optionally handle the response
                console.log(xhr.responseText);
                // Remove the unread-row class from the row
                var row = document.querySelector('.unread-row');
                if (row) {
                    row.classList.remove('unread-row');
                }
            }
        };
        xhr.send("message_id=" + messageId);
    }

    function reloadPage() {
        location.reload();
    }
</script>
<script src="../assets/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
