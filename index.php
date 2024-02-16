<?php
// Include your database connection file (dbcon.php)
include "config/dbcon.php";
include "config/loginAuth.php";

// Retrieve images from the carousel table
$sql = "SELECT * FROM carousel";
$result = mysqli_query($conn, $sql);
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.14.0/css/all.css">
</head>
<body>

<?php
include "includes/navbar.php";
?>
<?php
// Check if there is a success message in session
if (isset($_SESSION['alert_message'])) {
    echo '<div class="alert alert-danger alert-dismissible text-center" role="alert"  style="margin: 0">
            <i class="bi bi-exclamation-triangle-fill"></i> ' . $_SESSION['alert_message'] . '
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
    // Remove the success message from session
    unset($_SESSION['alert_message']);
}
?>

<?php
// Check if there are no carousel images available
if (mysqli_num_rows($result) == 0) {
    // Display alternate content if no carousel images are available
    ?>
    <div class="container-fluid p-5 bg-primary text-white text-center">
        <h1>Welcome</h1>
        <p>Your webpage is now ready to be set up. If you are the admin, please click start and setup the website through content management section.</p>
        <div class="mt-4">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#loginModal" type="button">Start</button>
        </div>
    </div>

    <div class="container mt-5">
        <div class="row">
            <div class="col-sm-4">
                <h3>Content Management System</h3>
                <p>Using a CMS is the ability to easily set up and manage website elements such as carousels, blogs, footers, and more. For example, you can easily create and manage a carousel, which is a slideshow of images or other content, to showcase your services on your website. You can also set up and manage a blog, which allows you to regularly publish new content to your website.</p>
            </div>
            <div class="col-sm-4">
                <h3>Basic Messaging System</h3>
                <p>A basic messaging app can be a valuable tool for students or users to communicate with an administrator or other authorized parties. With this app, users can send messages that will be displayed in an inbox, where they can be reviewed and responded to as needed.</p>
            </div>
            <div class="col-sm-4">
                <h3>Digital Enrollment System</h3>
                <p>Enrollment systems typically include a wide range of features, including student registration, course management, academic records management, and reporting. Students can use the system to select and register for courses</p>
            </div>
        </div>
    </div>

    <div class="container mt-5">
        <div class="row">
            <div class="col-sm-4">
                <div class="alert alert-success done" role="alert"> Status : Completed </div>
            </div>
            <div class="col-sm-4">
                <div class="alert alert-success done" role="alert"> Status : Completed </div>
            </div>
            <div class="col-sm-4">
                <div class="alert alert-success done" role="alert"> Status : Completed </div>
            </div>
        </div>
    </div>

    <?php
} else {
    // Display carousel if carousel images are available
    ?>
   
    <div id="myCarousel" class="carousel slide" data-bs-ride="carousel">
        <!-- Carousel Indicators -->
        <div class="carousel-indicators">
            <?php
            $active = "class='active'";
            $slideIndex = 0; // Initialize slide index
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<button type='button' data-bs-target='#myCarousel' data-bs-slide-to='$slideIndex' $active aria-current='true' aria-label='Slide $slideIndex'></button>";
                $active = ""; // Remove 'active' class for subsequent indicators
                $slideIndex++; // Increment slide index
            }
            ?>
        </div>
        <!-- Carousel Inner -->
        <div class="carousel-inner">
            <?php
            mysqli_data_seek($result, 0); // Reset the result pointer
            $active = "active"; // Reset the active class for the first item
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<div class='carousel-item $active'>";
                echo "<img src='subdirectory/{$row['image']}' class='d-block w-100' alt='Slide {$row['id']}'>";
                echo "<div class='carousel-caption'>";
                echo "<h5>{$row['caption']}</h5>";
                echo "<p>{$row['subtitle']}</p>";
                echo "</div>";
                echo "</div>";
                $active = ""; 
            }
            ?>
        </div>
        <!-- Carousel Controls -->
        <button class="carousel-control-prev" type="button" data-bs-target="#myCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#myCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
   <!--  end of carousel -->

<!-- start of cards -->
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col">
            <div class="d-flex justify-content-center">
                <div class="row row-cols-1 row-cols-md-5 g-x3 justify-content-center">
            <?php
            // Retrieve cards from the cards table
            $sqlCards = "SELECT * FROM cards";
            $resultCards = mysqli_query($conn, $sqlCards);

            // Check if there are cards available
            if (mysqli_num_rows($resultCards) > 0) {
                // Loop through each card and display them
                while ($row = mysqli_fetch_assoc($resultCards)) {
                    echo '<div class="card" style="width:300px; margin:15px;">';
                    echo '<img src="uploads/' . $row["image"] . '" class="card-img-top" style="height: 350px; object-fit: cover;" alt="Card Image">';
                    echo '<div class="card-body" style="height: 150px;">';
                    echo '<h5 class="card-title">' . $row["title"] . '</h5>';
                    echo '<p class="card-text">' . $row["caption"] . '</p>';
                    echo '</div>';
                    echo '</div>';
                }
            } else {
                // Handle the case when there are no cards available
            }
            ?>
        </div>
    </div>
</div>
</div>
</div>
<!-- end of cards -->


<!-- start of grid contents -->
<?php
// Fetch data from the grid table
$sql = "SELECT * FROM grid";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    // Output the grid contents
    echo '<div class="container-fluid px-4 py-5" id="featured-3">';
    echo '<div class="row justify-content-center">'; // Centering the grid contents horizontally

    // Loop through each row and output the corresponding column
    while ($row = mysqli_fetch_assoc($result)) {
        // Get the font size and background color from the current row
        $fontSize = $row['size'] . 'px';
        $bgColor = $row['bgcolor'];

        // Output the column with its respective font size and background color
        echo '<div class="col-lg-3 col-md-4 col-sm-6 ">';
        echo '<div class="feature p-5" style="background-color: ' . $bgColor . '; font-size: ' . $fontSize . ';">';
        echo '<div class="feature-icon bg-primary bg-gradient">';
        echo '</div>';
        echo '<h2>' . htmlspecialchars($row["title"]) . '</h2>';
        echo '<p>' . htmlspecialchars($row["caption"]) . '</p>';
        echo '</div>';
        echo '</div>';
    }

    echo '</div>'; // End of row
    echo '</div>'; // End of container
} else {
    // Handle the case when there are no rows in the grid table
}
?>
<!-- end of grid contents -->

<?php
include "includes/footer.php";
?>
</div>

<?php
}
?>

<?php
include "includes/loginModal.php";
?>

<script src="assets/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
