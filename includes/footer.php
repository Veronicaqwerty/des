<?php
// Fetch data from the informations table
$sql = "SELECT * FROM informations";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    // Output the fetched data into the HTML template
   
    echo '<footer class="text-center text-lg-start bg-dark text-muted" style="padding-top: 30px; margin-top: 10px;">';
    echo '<section>';
    echo '<div class="container text-center text-md-start">';
    echo '<div class="row mt-3">';
    echo '<div class="col-md-3 col-lg-4 col-xl-7 mx-auto mb-4">';
    echo '<h6 class="text-uppercase fw-bold mb-4">';
    echo '<i class="fas fa-gem me-3"></i>' . htmlspecialchars($row["name"]);
    echo '</h6>'; // name
    echo '<p>' . htmlspecialchars($row["description"]) . '</p>'; // description
    echo '</div>';
    echo '<div class="col-md-3 col-lg-3 col-xl-3 mx-auto mb-md-0 mb-4">';
    echo '<h6 class="text-uppercase fw-bold mb-4"> Contact </h6>';
    echo '<p><i class="fas fa-map-marker me-3"></i>' . htmlspecialchars($row["location"]) . '</p>'; // location
    echo '<p><i class="fas fa-envelope me-3"></i>' . htmlspecialchars($row["email"]) . '</p>'; // email
    echo '<p><i class="fas fa-phone me-3"></i>' . htmlspecialchars($row["mobnumber"]) . '</p>'; // mobnumber
    echo '<p><i class="fas fa-fax me-3"></i>' . htmlspecialchars($row["telnumber"]) . '</p>'; // telnumber
    echo '</div>';
    echo '</div>';
    echo '</div>';
    echo '</section>';
    echo '<div class="text-center p-4" style="background-color: rgba(0, 0, 0, 0.5);">';
    echo '&copy; 2024 Copyright : ' . htmlspecialchars($row["name"]);
    echo '</div>'; // name
    echo '</footer>';
} else {
  
}
?>
