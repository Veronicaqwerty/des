<?php
// session_start(); // Ensure session is started

// Include necessary files
include "config/dbcon.php";
include "config/loginAuth.php";

// Function to generate random captcha
function generateCaptcha($length = 10) {
    $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    $captcha = '';
    for ($i = 0; $i < $length; $i++) {
        $captcha .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $captcha;
}

// Fetch data from the informations table
$sql = "SELECT * FROM informations";
$result = mysqli_query($conn, $sql);

// Generate and store captcha value on every page load
$_SESSION["captcha"] = generateCaptcha();


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
    <link href="assets/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/index.css" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.14.0/css/all.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>


  <?php
  include "includes/navbar.php";
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
<div class="container py-4">
      <div class="row">
        <!-- Displaying Information -->



 <div class="col-md-6 mb-4">
    <div class="container shadow p-4 mb-5 bg-body rounded" style="margin: 30px; font-size:18px;">

        <?php
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            echo '<ul class="list-group">';
            echo '<li class="list-group-item p-3"><i class="fas fa-user"></i> ' . htmlspecialchars($row["name"]) . '</li>';
            echo '<li class="list-group-item p-3"><i class="fas fa-map-marker"></i> ' . htmlspecialchars($row["location"]) . '</li>';
            echo '<li class="list-group-item p-3"><i class="fas fa-envelope"></i> ' . htmlspecialchars($row["email"]) . '</li>';
            echo '<li class="list-group-item p-3"><i class="fas fa-mobile-alt"></i> ' . htmlspecialchars($row["mobnumber"]) . '</li>';
            echo '<li class="list-group-item p-3"><i class="fas fa-phone"></i> ' . htmlspecialchars($row["telnumber"]) . '</li>';
            echo '</ul>';
        } else {
            echo "No information available";
        }
        ?>
    </div>
</div>


    <!-- Contact Form -->
<div class="col-md-6 mb-4">
    <div class="container shadow p-3 mb-5 bg-body rounded" style="margin: 30px">
        <h2>Contact</h2>
        <form action="config/sendMessage.php" method="post">
            <div class="mb-3 mt-3">
                <label class="form-label" for="sender">Name</label>
                <input type="text" class="form-control" id="sender" placeholder="Enter your name" name="sender" required>
            </div>
            <div class="mb-3">
                <label class="form-label" for="email">Email Address</label>
                <input type="email" class="form-control" id="email" placeholder="Enter your email" name="email" required>
            </div>
            <div class="mb-3">
                <label class="form-label" for="message">Message</label>
                <textarea class="form-control" rows="5" id="message" placeholder="Message"name="message" required></textarea>
            </div>
            <div class="mb-3">
                <div class="input-group">
                  <div class="col">
                    <span class="input-group-text" id="captcha-addon" onmousedown="disableCopy()" onselectstart="return false;"><?php echo $_SESSION["captcha"]; ?></span>
                  </div>
                  <div class="col">
                    <input type="text" class="form-control" id="captcha" placeholder="Enter captcha" name="captcha" required>
                  </div>
                </div>
            </div>
            <div class="d-grid gap-3">
                <button type="submit" class="btn btn-primary btn-block btn-lg">Send ➤</button>
            </div>
        </form>
    </div>
</div>

<!-- end of contact form -->

    </div>
</div>


<?php
include "includes/footer.php";
include "includes/loginModal.php";
?>

</body>
<script>
    function disableCopy() {
        document.getElementById('captcha-addon').innerText = "DISABLED COPYING";
        document.getElementById('captcha-addon').style.color = "red";
    }
</script>
</html>
