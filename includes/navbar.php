<?php
// Fetch logo image path from the database
$sqlLogo = "SELECT image FROM details WHERE id = 1"; // Assuming the id for the website details is 1
$resultLogo = mysqli_query($conn, $sqlLogo);

// Check if there are any results
if ($resultLogo && mysqli_num_rows($resultLogo) > 0) {
    $rowLogo = mysqli_fetch_assoc($resultLogo);
    $logoImage = $rowLogo['image'];
    $logoSrc = "uploads/$logoImage";
} else {
    // No logo image found, use default
    $logoSrc = "img/cookie.png"; // Default logo path
}
?>
<nav class="navbar navbar-expand-sm navbar-dark bg-dark custom-navbar" aria-label="Ninth navbar example">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php">
            <img src="<?php echo $logoSrc; ?>" alt="Logo" width="50" height="50" class="d-inline-block align-text-top">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExample07XL" aria-controls="navbarsExample07XL" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarsExample07XL">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active custom-nav-link" aria-current="page" href="index.php">Home</a>
                </li> 
                <li class="nav-item">
                    <a class="nav-link custom-nav-link "  href="contactUs.php">Contact Us</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link custom-nav-link" href="enroll.php">Enroll Now</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle  custom-nav-link" href="#" id="dropdown07XL" data-bs-toggle="dropdown" aria-expanded="false">More</a>
                    <ul class="dropdown-menu" aria-labelledby="dropdown07XL">
                        <li>
                            <a class="dropdown-item custom-nav-link"  data-bs-toggle="modal" data-bs-target="#loginModal">Login</a>
                        </li>
                    </ul>
                </li>
            </ul>

        </div>
    </div>
</nav>
<style>
    .custom-navbar {
        height: 90px; /* Adjust the height as per your preference */
    }
     .custom-nav-link {
        font-size: 20px; /* Adjust the font size as per your preference */
    }
</style>
