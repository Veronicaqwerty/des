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
?>

<nav class="navbar navbar-expand-sm navbar-dark bg-dark" aria-label="Ninth navbar example">
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
                    <a class="nav-link active" aria-current="page" href="index.php">Home</a>
                </li> 
                <li class="nav-item">
                    <a class="nav-link" href="grade.php">E-Grades</a>

                </li>
                <li class="nav-item">
                    <a class="nav-link" href="profile.php">Profile</a>
                </li>
                
                    </ul>
                </li>
            </ul>
            <div class="dropdown">
            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
              Settings
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
              <li>
                     <form id="logoutForm" method="post" action="../config/logout.php">
                        <button name="logout" type="submit" onclick="confirmLogout()" class="dropdown-item">Logout</button>
                    </form>
                </li>
            </ul>
          </div>
        </div>
    </div>
</nav>
