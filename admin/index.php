<?php
session_start();
include "../config/dbcon.php";
if (!isset($_SESSION['username'])) {

    $_SESSION['alert_message'] = "YOU MUST LOGIN FIRST TO CONTINUE";
    header("Location: ../index.php");
    exit();
}




// Retrieve images from the carousel table
$sql = "SELECT * FROM carousel";
$resultCarousel = mysqli_query($conn, $sql);

// Retrieve cards from the cards table
$sql = "SELECT * FROM cards";
$resultCards = mysqli_query($conn, $sql);

// Fetch data from the database
$sql = "SELECT * FROM informations";
$resultInfo = $conn->query($sql);

if ($resultInfo->num_rows > 0) {
    // Output data of each row
    $row = $resultInfo->fetch_assoc();
    $name = $row["name"];
    $location = $row["location"];
    $email = $row["email"];
    $mobileNumber = $row["mobnumber"];
    $telephoneNumber = $row["telnumber"];
    $description = $row["description"];
} else {
    echo "0 results";
}
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
    <link href="../assets/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.14.0/css/all.css">

      <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<!-- Bootstrap JavaScript -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</head>
<style>
.card {
    margin-bottom: 20px;
  
}

.card-img-top {
    height: 200px; /* Adjust the height as needed */
   
    padding: 10px;

}

.card-button {
    width: 50px; /* Adjust the width as needed */
    height: 40px; /* Adjust the height as needed */
}

</style>
<body>
    <div class="container-fluid">
        <div class="row">
            <?php include "../includes/sidebar.php"; ?>
            <!-- start of contents -->
             <div class="col-sm mt-3 ml-3 mr-3">
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
                    <!-- content -->

                    <!-- start website details -->
                     <!--  start of update logo -->
                    <div class="col-sm">
                   
                    <div class="min-vh-80 shadow p-3 mb-5 bg-white rounded">
                        <div class="text-center">
                            <h3>Update Logo</h3>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#updateLogoModal">
                                Update
                            </button>
                        </div>

                        <!-- Update Logo Modal -->
                        <div class="modal fade" id="updateLogoModal" tabindex="-1" aria-labelledby="updateLogoModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="updateLogoModalLabel">Update Website Logo</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form id="updateLogoForm" enctype="multipart/form-data" method="post" action="../config/saveLogo.php">
                                            <div class="mb-3">
                                                <label for="logoImage" class="form-label">Select Logo Image</label>
                                                <input type="file" class="form-control" id="logoImage" name="logoImage" accept="image/*" required>
                                            </div>
                                            <button type="submit" class="btn btn-primary">Upload</button>
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-center align-items-center mt-3">
                            <!-- Display Logo Image -->
                            <?php
                            // Fetch logo image path from the database
                            $sqlLogo = "SELECT image FROM details WHERE id = 1"; // Assuming the id for the website details is 1
                            $resultLogo = mysqli_query($conn, $sqlLogo);

                            // Check if there are any results
                            if ($resultLogo && mysqli_num_rows($resultLogo) > 0) {
                                $rowLogo = mysqli_fetch_assoc($resultLogo);
                                $logoImage = $rowLogo['image'];
                                echo '<img src="../uploads/' . $logoImage . '" alt="Website Logo" style="max-width: 300px; max-height: 250px;">';
                            } else {
                                // No logo image found
                                echo '<p>No logo image found</p>';
                            }
                            ?>
                        </div>
                    </div>
                </div>
                    <!-- end of update logo -->
                
                    <!-- start of table informations -->
<form method="POST" action="../config/saveDetails.php">
  <div id="footer" class="shadow p-3 mb-5 bg-body rounded">
    <h3 style="text-align: center;"> School Profile </h3>
    <div class="container mt-3">
      <div class="table-responsive">
        <table class="table table-borderless">
          <thead>
            <tr>
              <th>Category</th>
              <th>Details</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td><i class="fas fa-user"></i> Name</td>
              <td>
                <div class="input-group" style="width:280px">
                  <input type="text" placeholder="Enter school name here" class="form-control" name="name" value="<?php echo $name; ?>">
                  <span class="input-group-text"><i class="fas fa-user"></i></span>
                </div>
              </td>
            </tr>

            <tr>
              <td><i class="fas fa-map-marker-alt"></i> Location</td>
              <td>
                <div class="input-group" style="width:280px">
                  <input type="text" placeholder="Enter school location here" class="form-control" name="location" value="<?php echo $location; ?>">
                  <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                </div>
              </td>
            </tr>

            <tr>
              <td><i class="fas fa-envelope"></i> Email Address</td>
              <td>
                <div class="input-group" style="width:280px">
                  <input type="email" placeholder="Enter email address here" class="form-control" name="email" value="<?php echo $email; ?>">
                  <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                </div>
              </td>
            </tr>

            <tr>
              <td><i class="fas fa-mobile-alt"></i> Mobile Number</td>
              <td>
                <div class="input-group" style="width:280px">
                  <input type="tel" placeholder="Enter mobile number" class="form-control" name="mobileNumber" value="<?php echo $mobileNumber; ?>">
                  <span class="input-group-text"><i class="fas fa-mobile-alt"></i></span>
                </div>
              </td>
            </tr>

            <tr>
              <td><i class="fas fa-phone"></i> Telephone Number</td>
              <td>
                <div class="input-group" style="width:280px">
                  <input type="tel" placeholder="Enter telephone number" class="form-control" name="telephoneNumber" value="<?php echo $telephoneNumber; ?>">
                  <span class="input-group-text"><i class="fas fa-phone"></i></span>
                </div>
              </td>
            </tr>

            <tr>
              <td><i class="fas fa-comment"></i> Description</td>
              <td>
                <div class="input-group" style="width:280px">
                  <textarea class="form-control" placeholder="Enter description" name="description"><?php echo $description; ?></textarea>
                  <span class="input-group-text"><i class="fas fa-comment"></i></span>
                </div>
              </td>
            </tr>

            <tr>
              <td></td>
              <td>
                <button style="float: right" type="submit" class="btn btn-primary">
                  <i class="fas fa-save"></i>
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</form>


                    <!-- end of table informations -->
                    <!-- end of website details -->
                 

                    <!-- start of carousel images -->
                    <div class="col-sm">
                   
                    <div class="min-vh-80 shadow p-3 mb-5 bg-white rounded">
                        <div class="text-center">
                            <h3>Cover Page</h3>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#uploadCarouselModal">
                                Upload
                            </button>
                        </div>  

                        <!-- Upload Carousel Modal -->
    <div class="modal fade" id="uploadCarouselModal" tabindex="-1" aria-labelledby="uploadModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="uploadModalLabel">Upload Image</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <!-- Modal Body with Form -->
                <form id="uploadForm" enctype="multipart/form-data" method="post" action="../config/saveCarousel.php">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="image" class="form-label">Select Image</label>
                            <input type="file" class="form-control" id="image" name="image" accept="image/*" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
                <!-- End of Modal Body with Form -->
            </div>
        </div>
    </div>
                        <div class="row">
                            <div class="d-flex justify-content-center">
                            <div class="row row-cols-1 row-cols-md-5 g-x3">
                                <?php
                                // Check if there are carousel images
                                if (mysqli_num_rows($resultCarousel) > 0) {
                                    // Display carousel images
                                    while ($row = mysqli_fetch_assoc($resultCarousel)) {
                                        echo '<div class="card" style="width:300px; margin:15px;">';
                                        echo '<img src="' . $row["image"] . '" class="card-img-top" alt="Image">';
                                        echo '<div class="card-body">';
                                        echo '<form method="post" action="../config/updateCarousel.php">';
                                        echo '<input type="hidden" name="id" value="' . $row["id"] . '">';
                                        echo '<div class="mb-3">';
                                        echo '<input type="text" placeholder="Insert a title" class="form-control" id="caption' . $row["id"] . '" name="caption" value="' . $row["caption"] . '">';
                                        echo '</div>';
                                       echo '<div class="mb-3">';
echo '<textarea placeholder="Insert a caption" class="form-control" id="subtitle' . $row["id"] . '" name="subtitle">' . $row["subtitle"] . '</textarea>';
echo '</div>';
;
                                        echo '<div class="d-flex justify-content-center">';
                                        echo '<button type="submit" name="update" class="btn btn-primary me-2 card-button"> <i class="fas fa-save"></i></button>';
                                        echo '<form method="post" action="">';
                                        echo '<input type="hidden" name="id" value="' . $row["id"] . '">';
                                        echo '<button formaction="../config/deleteCarousel.php" type="submit" name="delete" class="btn btn-danger card-button"> <i class="fa fa-trash"></i></button>';
                                        echo '</form>';
                                        echo '</div>';
                                        echo '</form>';
                                        echo '</div>';
                                        echo '</div>';
                                    }
                                } else {
                                    // Display a placeholder image
                                    echo '<div class="card-body">';
                                    echo '<img src="../img/empty.gif" class="card-img-top" alt="Empty" style="width:400px; height:200px;>';
                                    echo '<div class="card-body">';
                                    echo '<p class="text-center fw-bold">You can upload a cover photo for your website homepage</p>';
                                    echo '</div>';
                                    echo '</div>';
                                }
                                ?>
                            </div>
                        </div>
                    </div>
            
                 
                   
                
                <!--  end of carousel images -->
            </div>
             
                <!-- start of cards images -->
  <div class="col-sm">
                   
                    <div class="min-vh-80 shadow p-3 mb-5 bg-white rounded">
                    <div class="text-center">
                        <h3>Cards and Images</h3>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#uploadCardModal">
                            Upload
                        </button>
                    </div>
                    <!-- Upload Card Modal -->
                    <div class="modal fade" id="uploadCardModal" tabindex="-1" aria-labelledby="uploadModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="uploadModalLabel">Upload Card Image</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form id="uploadCardForm" enctype="multipart/form-data" method="post" action="../config/insertCard.php">
                                        <div class="mb-3">
                                            <label for="cardImage" class="form-label">Select Image</label>
                                            <input type="file" class="form-control" id="cardImage" name="cardImage" accept="image/*" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="title" class="form-label">Title</label>
                                            <input type="text" class="form-control" id="title" name="title" required>
                                        </div>
                                        <div class="mb-3">
    <label for="caption" class="form-label">Caption</label>
    <textarea required="" placeholder="Insert a caption" class="form-control" id="caption" name="caption"></textarea>
</div>

                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="d-flex justify-content-center">
                                <div class="row row-cols-1 row-cols-md-5 g-x3">
                                    <?php
                                    if (mysqli_num_rows($resultCards) > 0) {
                                        while ($row = mysqli_fetch_assoc($resultCards)) {
                                            echo '<div class="card" style="width:300px; margin:15px;">';
                                            echo '<img src="' . htmlspecialchars($row["image"]) . '" class="card-img-top" alt="Image">';
                                            echo '<div class="card-body">';
                                            echo '<form method="post" action="../config/updateCard.php">';
                                            echo '<input type="hidden" name="id" value="' . $row["id"] . '">';
                                            echo '<div class="mb-3 text-center">';
                                            echo '<input type="text" placeholder="Insert a title" class="form-control" id="title' . $row["id"] . '" name="title" value="' . htmlspecialchars($row["title"]) . '">';
                                            echo '</div>';
     echo '<div class="mb-3 text-center">';
echo '<label for="caption' . $row["id"] . '" class="form-label">Caption</label>';
echo '<textarea required="" placeholder="Insert a caption" class="form-control" id="caption' . $row["id"] . '" name="caption">' . htmlspecialchars($row["caption"]) . '</textarea>';
echo '</div>';

                                            echo '<div class="d-flex justify-content-center">';
                                            echo '<button type="submit" name="update" class="btn btn-primary me-2 card-button"><i class="fas fa-save"></i></button>';
                                            echo '</form>';
                                            echo '<form method="post" action="../config/deleteCard.php">';
                                            echo '<input type="hidden" name="id" value="' . $row["id"] . '">';
                                            echo '<button type="submit" name="delete" class="btn btn-danger card-button"><i class="fa fa-trash"></i></button>';
                                            echo '</form>';
                                            echo '</div>';
                                            echo '</div>'; // Close card-body
                                            echo '</div>'; // Close card
                                        }
                                    } else {
                                        // Display a placeholder image
                                        echo '<div class="card-body text-center" style="width:450px; height:300px;">';
                                        echo '<img src="../img/empty2.gif" class="card-img-top" alt="Empty">';
                                        echo '<div class="card-body">';
                                        echo '<p class="text-center fw-bold">You can upload cards and images to showcase on your home page</p>';
                                        echo '</div>';
                                        echo '</div>';
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
                <!-- end of cards images -->
                
                <!-- start of grid contents -->
                 <div class="col-sm">
                   
                    <div class="min-vh-80 shadow p-3 mb-5 bg-white rounded">
                    <div class="text-center">
                        <h3>Grid Contents</h3>
                    </div>
                    <div class="row">
                        <div class="d-flex justify-content-center">
                            <div class="row row-cols-1 row-cols-md-5 g-x3">
                                <div class="card" style="width:300px; margin:15px;">
                                    <div class="card-body">
                                        <form id="addCardForm" action="../config/saveGrid.php" method="POST">
                                            <div class="mb-3 text-center"> 
                                                <label for="titleInput" class="form-label"><h6>Title</h6></label>
                                                <input type="text" placeholder="Insert a title" class="form-control" id="titleInput" name="title">
                                            </div>
                                           <div class="mb-3 text-center">
    <label for="captionInput" class="form-label"><h6>Caption</h6></label>
    <textarea required="" placeholder="Insert a caption" class="form-control" id="captionInput" name="caption"></textarea>
</div>

                                            <div class="mb-3 text-center"> 
                                                <label for="fontSizeInput" class="form-label"><h6>Font Size</h6></label>
                                                <input type="number" placeholder="Insert size" class="form-control" id="fontSizeInput" name="size">
                                            </div>
                                            <div class="mb-3 text-center">
                                                <label for="bgColorInput" class="form-label"><h6>Background Color</h6></label>
                                                <input type="color" class="form-control" id="bgColorInput" name="bgcolor">
                                            </div>
                                            <div class="text-center">
                                                <button type="submit" class="btn btn-primary card-button"><i class="fa fa-plus"></i></button>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                                <?php
                                // Fetch data from the grid table
                                $sql = "SELECT * FROM grid";
                                $result = mysqli_query($conn, $sql);
                                if (mysqli_num_rows($result) > 0) {
                                    // Output data of each row
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        // Generate HTML for each card
                                        echo '<div class="card" style="width:300px; margin:15px;">';
                                        echo '<div class="card-body">';
                                        echo '<form action="../config/updateGrid.php" method="post">';
                                        echo '<input type="hidden" name="id" value="' . htmlspecialchars($row["id"]) . '">';
                                        echo '<div class="mb-3 text-center">';
                                        echo '<label for="captionInput" class="form-label"><h6>Title</h6></label>';
                                        echo '<input type="text" placeholder="Insert a title" class="form-control" id="captionInput" name="title" value="' . htmlspecialchars($row["title"]) . '">';
                                        echo '</div>';
     echo '<div class="mb-3 text-center">';
echo '<label for="captionInput" class="form-label"><h6>Caption</h6></label>';
echo '<textarea required="" placeholder="Insert a caption" class="form-control" id="captionInput" name="caption">' . htmlspecialchars($row["caption"]) . '</textarea>';
echo '</div>';

                                        echo '<div class="mb-3 text-center">';
                                        echo '<label for="fontSizeInput" class="form-label"><h6>Font Size</h6></label>';
                                        echo '<input type="number" placeholder="Insert size" class="form-control" id="fontSizeInput" name="size" value="' . htmlspecialchars($row["size"]) . '">';
                                        echo '</div>';
                                        echo '<div class="mb-3 text-center">';
                                        echo '<label for="bgColorInput" class="form-label"><h6>Background Color</h6></label>';
                                        echo '<input type="color" class="form-control" id="bgColorInput" name="bgcolor" value="' . htmlspecialchars($row["bgcolor"]) . '">';
                                        echo '</div>';
                                        echo '<div class="d-flex justify-content-center">';
                                        echo '<button type="submit" name="update" class="btn btn-primary me-2 card-button"><i class="fas fa-save"></i></button>';
                                        echo '</form>';
                                        echo '<form method="post" action="../config/deleteGrid.php">';
                                        echo '<input type="hidden" name="id" value="' . htmlspecialchars($row["id"]) . '">';
                                        echo '<button type="submit" name="delete" class="btn btn-danger card-button"><i class="fa fa-trash"></i></button>';
                                        echo '</form>';
                                        echo '</div>';
                                        echo '</div>';
                                        echo '</div>';
                                    }
                                } else {

                                }
                                ?>
                          
                        </div>
                        <!-- end of grid contents -->
                    </div>
                </div>
            </div>
        </div>
             <!--  end of contents -->
         </div>
     </div>

 </body>
 <script src="../assets/dist/js/bootstrap.bundle.min.js"></script>
 </html>

