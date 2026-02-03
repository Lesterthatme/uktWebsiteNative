<?php

session_start();
include '../../connection/dbconnection.php';

$sql = "SELECT * FROM university_profile LIMIT 1";
$result = $conn->query($sql);

// Check if data exists
if ($result->num_rows > 0) {
  $row = $result->fetch_assoc();
} else {
  $row = null;
}

// Fetch all site settings start
$settings = [];
$sql = "SELECT * FROM site_settings LIMIT 1";
$result = mysqli_query($conn, $sql);

if ($row = mysqli_fetch_assoc($result)) {
  $settings = $row;

  if (!empty($settings)) {
    $title_admin = htmlspecialchars($settings['websitetitle_admin']);
    $title_cm = htmlspecialchars($settings['websitetitle_cm']);
  }
}
// Fetch all site settings end
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <link rel="icon" type="image/png" href="../../assets/uploads/site settings/favicon/<?php echo htmlspecialchars($settings['fav_icon']); ?>" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo htmlspecialchars($settings['websitetitle_admin']); ?></title>
  <link rel="stylesheet" href="../../assets/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="../../assets/bootstrap/css/style.css?=v2.3">
  <link rel="stylesheet" href="../../assets/RemixIcon/fonts/remixicon.css">
</head>

<body class="bg-light">

  <!-- include side bar start -->
  <?php include 'include/alert.php'; ?>
  <?php include 'include/alert.php'; ?>
  <?php include 'include/sidebar.php'; ?>
  <!-- include side bar end -->

  <main class="bg-light">

    <!-- include navbar start -->
    <?php include 'include/navbar.php';

    ?>
    <!-- include navbar end -->

    <!-- start: Content -->
    <div class="p-4">
      <div class="row">
        <div class="card border-0 pb-3">
          <div class="card-body">
            <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
              <h5 class="card-title fs-6 mb-2 mb-md-0">University Profile</h5>
              <button type="button" class="btn btn-sm rounded-2 px-4 btn-dynamic edit-university-btn"
                data-bs-toggle="modal" data-bs-target="#exampleModal"
                data-id="<?= $row ? $row['up_id'] : ''; ?>"
                data-image="<?= $row ? '../../assets/uploads/university_image/' . $row['university_logo'] : ''; ?>"
                data-name="<?= $row ? htmlspecialchars($row['university_name'], ENT_QUOTES) : ''; ?>"
                data-street="<?= $row ? htmlspecialchars($row['university_street'], ENT_QUOTES) : ''; ?>"
                data-city="<?= $row ? htmlspecialchars($row['city_municipality'], ENT_QUOTES) : ''; ?>"
                data-province="<?= $row ? htmlspecialchars($row['university_province'], ENT_QUOTES) : ''; ?>"
                data-country="<?= $row ? htmlspecialchars($row['university_country'], ENT_QUOTES) : ''; ?>"
                data-postalcode="<?= $row ? htmlspecialchars($row['university_postalcode'], ENT_QUOTES) : ''; ?>"
                data-contactnumber="<?= $row ? htmlspecialchars($row['university_contactnumber'], ENT_QUOTES) : ''; ?>"
                data-email="<?= $row ? htmlspecialchars($row['university_emailaddress'], ENT_QUOTES) : ''; ?>"
                data-website="<?= $row ? htmlspecialchars($row['university_website'], ENT_QUOTES) : ''; ?>"
                data-fb="<?= $row ? htmlspecialchars($row['fb_link'], ENT_QUOTES) : ''; ?>"
                data-year="<?= $row ? htmlspecialchars($row['university_yearestablished'], ENT_QUOTES) : ''; ?>"
                data-president="<?= $row ? htmlspecialchars($row['university_president'], ENT_QUOTES) : ''; ?>"
                data-bs-toggle="tooltip" data-bs-placement="top" title="Click to update university profile">
                <i class="ri-edit-2-line"></i> Edit University Profile
              </button>

            </div>

            <!-- Page Poster start -->
            <?php
            $sql = "SELECT * FROM university_profile LIMIT 1";
            $result = $conn->query($sql);

            // Check if data exists
            if ($result->num_rows > 0) {
              $row = $result->fetch_assoc();
              $university_logo = $row["university_logo"];
              $university_name = $row["university_name"];
              $university_street = $row["university_street"];
              $city_municipality = $row["city_municipality"];
              $university_province = $row["university_province"];
              $university_country = $row["university_country"];
              $university_email = $row["university_emailaddress"];
              $university_contact = $row["university_contactnumber"];
              $university_website = $row["university_website"];
              $university_fb = $row["fb_link"];
              $university_youtube = $row["youtube_link"];
              $university_postalcode = $row["university_postalcode"];
              $university_yearestablished = $row["university_yearestablished"];
              $university_president = $row["university_president"];
            } else {
              echo "<p>No university profile found.</p>";
              exit;
            }

            $conn->close();
            ?>
            <div class="university_card">
              <img src="../../assets/uploads/university_image/<?php echo htmlspecialchars($university_logo); ?>" alt="University Logo" class="university_logo_up">
              <h4 class="fw-bold"><?php echo htmlspecialchars($university_name); ?></h4>
              <div class="university_info d-flex justify-content-center align-items-center">
                <div class="info_list">
                  <p><i class="ri-user-line"></i> Rector: <?php echo htmlspecialchars($university_president); ?></p>
                  <p><i class="ri-map-pin-line"></i>
                    Address: <?php echo htmlspecialchars($university_street . ', ' . $city_municipality . ', ' . $university_province . ', ' . $university_country); ?>
                  </p>
                  <p><i class="ri-map-pin-line"></i> Postal Code: <?php echo htmlspecialchars($university_postalcode); ?></p>
                  <!-- Contact Info -->
                  <p><i class="ri-mail-line"></i> Email: <?php echo htmlspecialchars($university_email); ?></p>
                  <p><i class="ri-phone-line"></i> Telephone: <?php echo htmlspecialchars($university_contact); ?></p>
                  <!-- Website -->
                  <p><i class="ri-global-line"></i> Website:&nbsp;
                    <a href="<?php echo htmlspecialchars($university_website); ?>" target="_blank">
                      <?php echo htmlspecialchars($university_website); ?>
                    </a>
                  </p>
                  <!-- Other Details -->
                  <p><i class="ri-facebook-fill"></i> Facebook:&nbsp;
                    <a href="<?php echo htmlspecialchars($university_fb); ?>" target="_blank">
                      <?php echo htmlspecialchars($university_fb); ?>
                    </a>
                  </p>
                  <p><i class="ri-youtube-fill"></i> Youtube:&nbsp;
                    <a href="<?php echo htmlspecialchars($university_youtube); ?>" target="_blank">
                      <?php echo htmlspecialchars($university_youtube); ?>
                    </a>
                  </p>
                  <p><i class="ri-calendar-line"></i> Year Established: <?php echo htmlspecialchars($university_yearestablished); ?></p>
                </div>
              </div>
            </div>
            <!-- Page Poster End-->

            <!-- Modal for edit university profile start-->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-xl">
                <div class="modal-content">
                  <div class="modal-header">
                    <h1 class="modal-title fs-5 text-muted fw-bold" id="exampleModalLabel">Edit University Profile</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body pb-0">
                    <form method="POST" action="../../function/content_manager/university_profilefunction.php" enctype="multipart/form-data">
                      <input type="hidden" name="up_id" id="edit-up-id" value="<?php echo isset($row['up_id']) ? $row['up_id'] : ''; ?>">
                      <!-- Image Preview -->
                      <div class="mb-3 text-center">
                        <label class="form-label fw-semibold text-muted">Current Image:</label>
                        <div id="edit-previewContainer">
                          <img src="<?php echo isset($row['university_logo']) && !empty($row['university_logo']) ? '../../assets/uploads/university_image/' . $row['university_logo'] : 'default-image.jpg'; ?>"
                            alt="University Image" width="200">
                        </div>
                      </div>

                      <!-- Upload New Image -->
                      <div class="mb-3">
                        <label class="form-label fw-semibold text-muted">Upload New University Logo:</label>
                        <input type="file" name="university_logo" class="form-control" id="edit-image-input" accept="image/jpeg, image/jpg, image/png">
                      </div>

                      <div class="row mb-3">
                        <div class="col-md-6">
                          <label class="form-label fw-semibold text-muted">Name of University</label>
                          <input type="text" name="university_name" class="form-control"
                            value="<?php echo isset($row['university_name']) ? htmlspecialchars($row['university_name']) : ''; ?>">
                        </div>
                        <div class="col-md-6">
                          <label class="form-label fw-semibold text-muted">Street</label>
                          <input type="text" class="form-control" name="university_street"
                            value="<?php echo isset($row['university_street']) ? htmlspecialchars($row['university_street']) : ''; ?>">
                        </div>
                      </div>

                      <div class="row mb-3">
                        <div class="col-md-6">
                          <label class="form-label fw-semibold text-muted">City/Municipality</label>
                          <input type="text" class="form-control" name="city_municipality"
                            value="<?php echo isset($row['city_municipality']) ? htmlspecialchars($row['city_municipality']) : ''; ?>">
                        </div>
                        <div class="col-md-6">
                          <label class="form-label fw-semibold text-muted">Province</label>
                          <input type="text" class="form-control" name="university_province"
                            value="<?php echo isset($row['university_province']) ? htmlspecialchars($row['university_province']) : ''; ?>">
                        </div>
                      </div>

                      <div class="row mb-3">
                        <div class="col-md-6">
                          <label class="form-label fw-semibold text-muted">Country</label>
                          <input type="text" class="form-control" name="university_country"
                            value="<?php echo isset($row['university_country']) ? htmlspecialchars($row['university_country']) : ''; ?>">
                        </div>
                        <div class="col-md-6">
                          <label class="form-label fw-semibold text-muted">Postal or Zip Code</label>
                          <input type="text" class="form-control" name="university_postalcode"
                            value="<?php echo isset($row['university_postalcode']) ? htmlspecialchars($row['university_postalcode']) : ''; ?>">
                        </div>
                      </div>

                      <div class="row mb-3">
                        <div class="col-md-6">
                          <label class="form-label fw-semibold text-muted">Telephone No.</label>
                          <input type="text" class="form-control" name="university_contactnumber"
                            value="<?php echo isset($row['university_contactnumber']) ? htmlspecialchars($row['university_contactnumber']) : ''; ?>">
                        </div>
                        <div class="col-md-6">
                          <label class="form-label fw-semibold text-muted">Email Address</label>
                          <input type="email" class="form-control" name="university_emailaddress"
                            value="<?php echo isset($row['university_emailaddress']) ? htmlspecialchars($row['university_emailaddress']) : ''; ?>">
                        </div>
                      </div>

                      <div class="row mb-3">
                        <div class="col-md-6">
                          <label class="form-label fw-semibold text-muted">Website Address</label>
                          <input type="text" class="form-control" name="university_website"
                            value="<?php echo isset($row['university_website']) ? htmlspecialchars($row['university_website']) : ''; ?>">
                        </div>
                        <div class="col-md-6">
                          <label class="form-label fw-semibold text-muted">Facebook Link</label>
                          <input type="text" class="form-control" name="fb_link"
                            value="<?php echo isset($row['fb_link']) ? htmlspecialchars($row['fb_link']) : ''; ?>">
                        </div>
                      </div>

                      <div class="row pb-0 mb-3">
                        <div class="col-md-6">
                          <label class="form-label fw-semibold text-muted">Youtube Link</label>
                          <input type="text" class="form-control" name="youtube_link"
                            value="<?php echo isset($row['youtube_link']) ? htmlspecialchars($row['youtube_link']) : ''; ?>">
                        </div>
                        <div class="col-md-6">
                          <label class="form-label fw-semibold text-muted">Year Established</label>
                          <input type="text" class="form-control" name="university_yearestablished"
                            value="<?php echo isset($row['university_yearestablished']) ? htmlspecialchars($row['university_yearestablished']) : ''; ?>">
                        </div>
                      </div>

                      <div class="row pb-0">
                        <div class="col-md-6">
                          <label class="form-label fw-semibold text-muted">Name of President</label>
                          <input type="text" class="form-control" name="university_president"
                            value="<?php echo isset($row['university_president']) ? htmlspecialchars($row['university_president']) : ''; ?>">
                        </div>
                      </div>

                      <div class="modal-footer">
                        <button type="submit" name="update_university" class="btn btn-dynamic"
                          data-bs-toggle="tooltip" data-bs-placement="top"
                          title="Click to save"> <i class="ri-save-fill"></i> Save
                        </button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
            <!-- Modal for edit university profile start-->
          </div>
        </div>
      </div>
      <?php include 'include/footer.php'; ?>
    </div>
  </main>

  <!-- start js -->
  <script src="../../assets/script.js"></script> <!-- this script is for disabling multiple login in session -->
  <script src="../../assets/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../../assets/bootstrap/js/jquery-3.7.1.js"></script>
  <script src="../../assets/bootstrap/js/script.js"></script>
  <script src="../../assets/bootstrap/js/page_poster.js"></script>
  <script src="../../assets/bootstrap/js/drag_and_drop.js?=1.1"></script>
  <script src="../../assets/bootstrap/js/activeLink.js?v=1.1"></script>
  <script src="../../assets/bootstrap/js/table.js"></script>
  <script src="../../assets/bootstrap/js/site_settings.js"></script>
  <!-- end js -->

  <script>
    document.getElementById('edit-image-input').addEventListener('change', function(event) {
      const file = event.target.files[0]; // Get the selected file
      if (file) {
        const reader = new FileReader(); // Create a FileReader object
        reader.onload = function(e) {
          const previewContainer = document.getElementById('edit-previewContainer');
          previewContainer.innerHTML = `<img src="${e.target.result}" alt="Preview" width="200">`;
        };
        reader.readAsDataURL(file); // Read the file as a Data URL
      }
    });
  </script>

  <!-- START >> JS SCRIPT IN ALERT -->
  <script>
    document.addEventListener("DOMContentLoaded", function() {
      console.log("Checking for toast message...");

      <?php if (isset($_SESSION['toastMsg']) && $_SESSION['toastMsg'] != "") { ?>
        let toastType = "<?php echo $_SESSION['toastType']; ?>";
        let message = "<?php echo $_SESSION['toastMsg']; ?>";

        // If success, show "Success", else show "Failed"
        let title = (toastType === "toast-success") ? "Success" : "Failed";

        console.log("Toast Found:", title, message);
        showToast(toastType, title, message);

        // Unset session variables after displaying the toast
        <?php unset($_SESSION['toastMsg']);
        unset($_SESSION['toastType']); ?>
      <?php } else { ?>
        console.log("No toast message found.");
      <?php } ?>
    });

    function showToast(type, title, message) {
      let toast = document.getElementById("toastBox");
      let icon = document.getElementById("toastIcon");
      let titleElement = document.getElementById("toastTitle");
      let messageElement = document.getElementById("toastMessage");

      if (!toast) {
        console.error("Toast box element not found!");
        return;
      }

      // Remove previous styles
      toast.classList.remove("toast-show", "toast-success", "toast-info", "toast-warning", "toast-error");

      // Add new class
      toast.classList.add(type, "toast-show");

      // Set title and message
      titleElement.textContent = title;
      messageElement.textContent = message;

      // Set icon based on type
      switch (type) {
        case "toast-success":
          icon.className = "ri-checkbox-circle-line toast-icon";
          break;
        case "toast-info":
          icon.className = "ri-information-line toast-icon";
          break;
        case "toast-warning":
          icon.className = "ri-alert-line toast-icon";
          break;
        case "toast-error":
          icon.className = "ri-close-circle-line toast-icon";
          break;
        default:
          icon.className = "ri-information-line toast-icon"; // Default icon
      }

      // Show toast
      toast.style.display = "flex";

      // Hide after 3 seconds
      setTimeout(closeToast, 3000);
    }

    function closeToast() {
      let toast = document.getElementById("toastBox");
      toast.classList.remove("toast-show");
      setTimeout(() => {
        toast.style.display = "none";
      }, 500);
    }
  </script>
  <!-- END >> JS SCRIPT IN ALERT -->
</body>

</html>