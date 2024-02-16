<?php
// Fetch logo image path from the database
$sqlLogo = "SELECT image FROM details WHERE id = 1"; // Assuming the id for the website details is 1
$resultLogo = mysqli_query($conn, $sqlLogo);

// Check if there are any results
if ($resultLogo && mysqli_num_rows($resultLogo) > 0) {
    $rowLogo = mysqli_fetch_assoc($resultLogo);
    $logoImage = $rowLogo['image'];
    $logoSrc = "../uploads/$logoImage";
} else {
    // No logo image found, use default
    $logoSrc = "img/cookie.png"; // Default logo path
}


// Fetch the number of unread messages from your database
$sqlUnreadMessages = "SELECT COUNT(*) AS unread_messages FROM messages WHERE status = 'unread'";
$resultUnreadMessages = mysqli_query($conn, $sqlUnreadMessages);

// Check if there are any results
if ($resultUnreadMessages && mysqli_num_rows($resultUnreadMessages) > 0) {
    $rowUnreadMessages = mysqli_fetch_assoc($resultUnreadMessages);
    $unreadMessagesCount = $rowUnreadMessages['unread_messages'];
} else {
    // No unread messages found
    $unreadMessagesCount = 0;
}
?>

<div class="col-sm-auto bg-dark sticky-top">
    <div class="d-flex flex-sm-column flex-row flex-nowrap bg-dark align-items-center sticky-top">
        <a href="../admin/index.php" class="d-block p-3 link-dark text-decoration-none" title="" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Icon-only">
            <img src="<?php echo $logoSrc; ?>" alt="Logo" width="50" height="50" class="d-inline-block align-text-top">
        </a>
        <ul class="nav nav-pills nav-flush flex-sm-column flex-row flex-nowrap mb-auto mx-auto text-center justify-content-between w-100 px-3 align-items-center">
            <li class="nav-item">
                <a href="index.php" class="nav-link py-3 px-2" title="" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Content Management">
                    <i class="bi bi-files text-primary fs-1"></i>
                </a>
            </li>
            <li>
                <a href="enrollment.php" class="nav-link py-3 px-2" title="" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Digital Enrollment">
                    <i class="bi bi-journal text-success fs-1"></i>
                </a>
            </li>
            <li>
                <a href="class.php" class="nav-link py-3 px-2" title="" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Classroom">
                    <i class="bi bi-house-door text-warning fs-1"></i>
                </a>
            </li>
            <li>
                <a href="inbox.php" id="inboxLink" class="nav-link py-3 px-2 position-relative" title="Inbox" data-bs-toggle="tooltip" data-bs-placement="right">
                    <i class="bi bi-inbox text-danger fs-1"></i>
                    <?php if ($unreadMessagesCount > 0): ?>
                        <span id="unreadBadge" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                            <?php echo $unreadMessagesCount; ?>
                            <span class="visually-hidden">unread messages</span>
                        </span>
                    <?php endif; ?>
                </a>
            </li>
        </ul>
        <div class="dropdown">
            <a href="#" class="d-flex align-items-center justify-content-center p-3 link-dark text-decoration-none dropdown-toggle" id="dropdownUser3" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="bi-person-circle text-info h2"></i>
            </a>
            <ul class="dropdown-menu text-small shadow" aria-labelledby="dropdownUser3">
                <li>
                     <form id="logoutForm" method="post" action="../config/logout.php">
                        <button name="logout" type="submit" onclick="confirmLogout()" class="dropdown-item">Logout</button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</div>
<script type="text/javascript">
    function confirmLogout() {
        if (confirm("Are you sure you want to logout?")) {
            // If user confirms, submit the logout form
            document.getElementById('logoutForm').submit();
        }
    }
</script>
<script>
    // Add an event listener to the open message button inside the modal
    function openMessage(sender, message) {
        document.getElementById('senderName').innerText = sender;
        document.getElementById('messageContent').innerText = message;
        // Open the modal
        var myModal = new bootstrap.Modal(document.getElementById('myModal'));
        myModal.show();

        // Update the status of messages to 'read' using AJAX
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                // Decrement the unread message count and update the badge text
                var unreadBadge = document.getElementById("unreadBadge");
                if (unreadBadge) {
                    var unreadMessagesCount = parseInt(unreadBadge.innerText);
                    if (unreadMessagesCount > 0) {
                        unreadBadge.innerText = (unreadMessagesCount - 1).toString();
                    }
                }
            }
        };
        xhr.open("GET", "../config/markreadInbox.php", true);
        xhr.send();
    }
</script>
