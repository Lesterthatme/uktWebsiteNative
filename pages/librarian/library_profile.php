<?php
include 'include/alert.php';
session_start();
include '../../connection/dbconnection.php';
if (!isset($_SESSION['session_token'])) {
  header('location:login.php');
  exit;
}
include 'confirmation.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <link rel="icon" type="image/png" href="../../assets/images/officiallogo (1).png" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>University of Kratie || Admin</title>
  <!-- start css  -->
  <link rel="stylesheet" href="../../assets/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="../../assets/bootstrap/css/style.css?=v1.3">
  <!-- end css -->
  <!-- Remix icon -->
  <link rel="stylesheet" href="../../assets/RemixIcon/fonts/remixicon.css">
  <link rel="stylesheet" href="assets/library_style/style.css?=v1.1">

</head>

<body class="bg-light">

  <!-- include side bar start -->
  <?php include 'include/sidebar.php';

  ?>
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
              <h5 class="card-title fs-6 mb-2 mb-md-0">Library Profile</h5>
              <button type="button" class="btn btn-sm rounded-2 px-4 btn-dynamic edit-university-btn"
                data-bs-toggle="modal" data-bs-target="#exampleModal"
                data-id="<?= isset($row['library_id']) ? $row['library_id'] : ''; ?>"
                data-image="<?= isset($row['library_logo']) ? 'assets/uploads/library_images/' . $row['library_logo'] : ''; ?>"
                data-name="<?= isset($row['library_name']) ? htmlspecialchars($row['library_name'], ENT_QUOTES) : ''; ?>"
                data-street="<?= isset($row['library_location']) ? htmlspecialchars($row['library_location'], ENT_QUOTES) : ''; ?>"
                data-contactnumber="<?= isset($row['library_contact']) ? htmlspecialchars($row['library_contact'], ENT_QUOTES) : ''; ?>"
                data-email="<?= isset($row['library_email']) ? htmlspecialchars($row['library_email'], ENT_QUOTES) : ''; ?>"
                data-website="<?= isset($row['library_website']) ? htmlspecialchars($row['library_website'], ENT_QUOTES) : ''; ?>">
                <i class="ri-edit-2-line"></i> Edit University Library Profile
              </button>

            </div>

            <!-- library view start -->
            <?php
            $sql = "SELECT * FROM library_university LIMIT 1";
            $result = $conn->query($sql);

            // Check if data exists
            if ($result->num_rows > 0) {
              $row = $result->fetch_assoc();
              $library_name = $row["library_name"];
              $library_image = $row["library_logo"];
              $library_location = $row["library_location"];
              $library_contact = $row["library_contact"];
              $library_email = $row["library_email"];
              $library_website = $row["library_website"];
            } else {
              echo "<p>No library university profile found.</p>";
              exit;
            }

            $conn->close();
            ?>
            <div class="university_card">
              <img class="rounded-circle pb-3" src="assets/uploads/Library_images/<?php echo htmlspecialchars($library_image); ?>"
                alt="Library University Logo" class="library_logo_up" style="width: 150px; height: auto;">
              <div class="university_info">
                <h4 class="fw-bold"><?php echo htmlspecialchars($library_name); ?></h4>
                <div class="info_list">
                  <p><i class="ri-map-pin-line"></i> Location: <?php echo htmlspecialchars($library_location); ?></p>
                  <p><i class="ri-mail-line"></i> Email: <?php echo htmlspecialchars($library_email); ?></p>
                  <p><i class="ri-phone-line"></i> Contact Number: <?php echo htmlspecialchars($library_contact); ?></p>
                  <p><i class="ri-global-line"></i> Website:
                    <a href="<?php echo htmlspecialchars($library_website); ?>" target="_blank">
                      <?php echo htmlspecialchars($library_website); ?>
                    </a>
                  </p>
                </div>
              </div>
              <!-- library view End-->

              <!-- Modal for edit university profile start-->
              <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h1 class="modal-title fs-5 text-muted fw-bold" id="exampleModalLabel">Edit University Profile</h1>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <form method="POST" action="function/university_libraryfunction.php" enctype="multipart/form-data">
                        <input type="hidden" name="library_id" id="edit-up-id" value="<?php echo isset($row['library_id']) ? $row['library_id'] : ''; ?>">
                        <!-- Image Preview -->
                        <div class="mb-3 text-center">
                          <label class="form-label fw-semibold text-muted">Current Image:</label>
                          <div id="edit-previewContainer">
                            <img src="<?php echo isset($row['library_logo']) && !empty($row['library_logo']) ? 'assets/uploads/Library_images/' . $row['library_logo'] : 'default-image.jpg'; ?>"
                              alt="Library University Logo" width="200">
                          </div>
                        </div>

                        <!-- Upload New Image -->
                        <div class="mb-3">
                          <label class="form-label fw-semibold text-muted">Upload New University Logo:</label>
                          <input type="file" name="library_logo" class="form-control" id="edit-image-input" accept="image/jpeg, image/jpg, image/png">
                        </div>

                        <div class="row mb-3">
                          <div class="col-md-6">
                            <label class="form-label fw-semibold text-muted text-start">Library Name:</label>
                            <input type="text" name="library_name" class="form-control"
                              value="<?php echo isset($row['library_name']) ? htmlspecialchars($row['library_name']) : ''; ?>">
                          </div>

                          <div class="col-md-6">
                            <label class="form-label fw-semibold text-muted text-start">Location:</label>
                            <input type="text" name="library_location" class="form-control"
                              value="<?php echo isset($row['library_location']) ? htmlspecialchars($row['library_location']) : ''; ?>">
                          </div>
                        </div>

                        <div class="row mb-3">
                          <div class="col-md-6">
                            <label class="form-label fw-semibold text-muted">Library Contact Number.</label>
                            <input type="number" class="form-control" name="library_contact"
                              value="<?php echo isset($row['library_contact']) ? htmlspecialchars($row['library_contact']) : ''; ?>">
                          </div>
                          <div class="col-md-6">
                            <label class="form-label fw-semibold text-muted">Email Address</label>
                            <input type="email" class="form-control" name="library_email"
                              value="<?php echo isset($row['library_email']) ? htmlspecialchars($row['library_email']) : ''; ?>">
                          </div>
                        </div>

                        <div class="row mb-3">
                          <div class="col-md-6">
                            <label class="form-label fw-semibold text-muted">Library Website Link:</label>
                            <input type="text" class="form-control" name="library_website"
                              value="<?php echo isset($row['library_website']) ? htmlspecialchars($row['library_website']) : ''; ?>">
                          </div>
                        </div>
                        <div class="modal-footer">
                          <button type="submit" name="update_library" class="btn btn-dynamic">
                            <i class="ri-save-fill"></i> Save
                          </button>
                        </div>
                      </form>

                    </div>
                  </div>
                </div>
              </div>
              <!-- Modal for edit library profile end-->
            </div>

          </div>
        </div>
        <?php include 'include/footer.php'; ?>
      </div>
  </main>

  <!-- start js -->
  <script src="../../assets/script.js"></script> <!-- this script is for disabling multiple login in session -->
  <script src="https://cdn.jsdelivr.net/npm/quill@1.3.6/dist/quill.min.js"></script>
  <script src="../../assets/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../../assets/bootstrap/js/jquery-3.7.1.js"></script>
  <script src="../../assets/bootstrap/js/script.js"></script>
  <script src="../../assets/bootstrap/js/page_poster.js"></script>
  <script src="../../assets/bootstrap/js/drag_and_drop.js?=1.1"></script>
  <script src="../../assets/bootstrap/js/activeLink.js?v=1.2"></script>
  <script src="../../assets/bootstrap/js/table.js"></script>
  <script src="../../assets/bootstrap/js/site_settings.js?v=1.0"></script>

  <!-- end js -->

  <script>
    document.getElementById('edit-image-input').addEventListener('change', function(event) {
      const previewContainer = document.getElementById('edit-previewContainer');
      const file = event.target.files[0];

      if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
          previewContainer.innerHTML = `<img src="${e.target.result}" alt="New Preview Image" width="200">`;
        };
        reader.readAsDataURL(file);
      } else {
        previewContainer.innerHTML = `<img src="<?php echo isset($row['library_logo']) && !empty($row['library_logo']) ? 'assets/uploads/Library_images/' . $row['library_logo'] : 'default-image.jpg'; ?>" alt="Library University Logo" width="200">`;
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