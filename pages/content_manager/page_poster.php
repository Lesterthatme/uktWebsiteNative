<?php
session_start();
include("../../connection/dbconnection.php");

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
  <title><?php echo htmlspecialchars($settings['websitetitle_cm']); ?></title>
  <!-- start css  -->
  <link rel="stylesheet" href="../../assets/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="../../assets/bootstrap/css/style.css?=v1.2">
  <!-- end css -->
  <!-- Remix icon -->
  <link rel="stylesheet" href="../../assets/RemixIcon/fonts/remixicon.css">
</head>

<body class="bg-light">

    <!-- include side bar start -->
    <?php include 'include/alert.php';?>
  <?php include 'confirmation.php';?>
  <?php include 'include/sidebar.php'; ?>
  <!-- include side bar end -->

  <main class="bg-light">

    <!-- include navbar start -->
    <?php include 'include/navbar.php';?>
    <!-- include navbar end -->

    <!-- start: Content -->
    <div class="p-4">
      <div class="row">
        <div class="card border-0 pb-3">
          <div class="card-body">
            <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
              <h5 class="card-title fs-6 mb-2 mb-md-0">Manage Page Poster</h5>
              <button type="button" class="btn btn-sm rounded-2 px-4 btn-dynamic" data-bs-toggle="modal" data-bs-target="#exampleModal"
              data-bs-toggle="tooltip" data-bs-placement="top" title="Click to add poster">
                <i class="ri-add-line"></i> Add Poster
              </button>
            </div>

            <p class="card-text text-muted small">
              Stay informed with the latest updates, important notices, and key announcements. This section keeps you connected with recent events, system updates, and essential information to ensure you’re always in the loop.
            </p>

            <!-- Modal for adding image start-->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-lg">
                <div class="modal-content">
                  <div class="modal-header">
                    <h1 class="modal-title fs-5 text-muted fw-bold" id="exampleModalLabel">Add Poster</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body pb-0">
                  <form method="POST" action="../../function/content_manager/poster_function.php" enctype="multipart/form-data">
                      <!-- Image Upload -->
                      <div class="mb-3">
                        <label class="form-label fw-semibold text-muted">Upload Image:</label>
                        <div class="upload-area" id="uploadArea">
                          <img src="https://cdn-icons-png.flaticon.com/512/126/126477.png" alt="Upload Icon">
                          <p class="mb-0">Drag & Drop <br><span class="text-success">or browse</span></p>
                          <small class="text-muted">Supports: JPEG, JPG, PNG</small>
                          <input type="file" id="fileInput" name="poster_image" class="d-none"
                            accept="image/jpeg, image/jpg, image/png">
                        </div>
                        <div id="previewContainer" class="preview-container d-none">
                          <button type="button" class="delete-btn" id="deleteBtn">&times;</button>
                          <img id="previewImage" class="preview-img" alt="Preview Image">
                        </div>
                      </div>
                      <!-- <div class="mb-3">
                        <label class="form-label fw-semibold text-muted">Poster Status:</label>
                        <select name="poster_status" class="form-control" required>
                          <option value="Active">Active</option>
                          <option value="Inactive">Inactive</option>
                        </select>
                      </div> -->
                      <div class="modal-footer ">
                        <button type="submit" name="add_poster" class="btn btn-dynamic"  data-bs-toggle="tooltip" 
                         data-bs-placement="top" title="Click to save"><i class="ri-save-fill"></i>
                          Save </button>
                      </div>
                    </form>

                  </div>
                </div>
              </div>
            </div>
            <!-- Modal for adding image end -->

            <!-- View Page Poster start -->
            <?php
            include '../../connection/dbconnection.php';
            $carousel_items = [];
            $query = "SELECT poster_id, poster_image, poster_status, poster_date FROM page_poster ORDER BY poster_date DESC";
            $result = $conn->query($query);
            if ($result->num_rows > 0) {
              $carousel_items = [];
              while ($row = $result->fetch_assoc()) {
                $carousel_items[] = $row;
              }
            } else {
              echo '<div class="text-center text-muted py-5">No posters available.</div>';
            }
            ?>
            <div id="partnerCarousel" class="carousel slide" data-bs-ride="carousel">
              <div class="carousel-inner p-4">
                <?php
                if (!empty($carousel_items)) {
                  $isActive = true;
                  foreach ($carousel_items as $item) {
                    $poster_date = date('F d, Y', strtotime($item['poster_date']));
                    $status_class = ($item['poster_status'] == 'Active') ? 'announcement-status-active' : 'announcement-status-inactive';
                    $image_path = "../../assets/uploads/poster/" . htmlspecialchars($item['poster_image']);
                ?>
                    <div class="carousel-item <?php echo $isActive ? 'active' : ''; ?>">
                      <div class="d-flex flex-wrap justify-content-center gap-4">
                        <div class="poster-container">
                          <span class="<?php echo $status_class; ?>"><?php echo $item['poster_status']; ?></span>
                          <div class="dropdown three-dots-poster">
                            <button class="btn p-0 border-0" type="button" data-bs-toggle="dropdown" aria-expanded="false"
                            data-bs-toggle="tooltip" data-bs-placement="top" title="Click here to see the action">
                              <span></span><span></span><span></span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                              <li>
                                <a class="dropdown-item text-dark edit-btn" href="#"
                                  data-bs-toggle="modal"
                                  data-bs-target="#editModal"
                                  data-id="<?php echo $item['poster_id']; ?>"
                                  data-image="<?php echo $image_path; ?>"
                                  data-status="<?php echo $item['poster_status']; ?>"
                                  data-date="<?php echo $item['poster_date']; ?>" data-bs-toggle="tooltip" 
                                  data-bs-placement="top" title="Click here to edit this poster">
                                  <i class="ri-pencil-line"></i> Edit
                                </a>
                              </li>

                              <li>
                                <a href="javascript:void(0);"
                                  class="dropdown-item text-dark text-decoration-none"
                                  data-id="<?= $item['poster_id'] ?>"
                                  onclick="openModal(event, this.dataset.id);" data-bs-toggle="tooltip" 
                                  data-bs-placement="top" title="Click to delete this poster">
                                  <i class="ri-delete-bin-line"></i> Delete
                                </a>
                              </li>
                            </ul>
                          </div>

                          <img src="<?php echo $image_path; ?>"
                            alt="Event Poster"
                            class="poster img-fluid"
                            style="width: 100%; max-height: 400px; object-fit: cover; border-radius: 10px;">

                          <span class="date-label">DATE POSTED: <?php echo $poster_date; ?></span>
                        </div>
                      </div>
                    </div>
                <?php
                    $isActive = false; 
                  }
                }
                ?>
              </div>

              <!-- Carousel Indicators -->
              <div class="carousel-indicators">
                <?php
                foreach ($carousel_items as $index => $item) {
                  $activeClass = ($index === 0) ? 'active' : '';
                  echo "<button type='button' data-bs-target='#partnerCarousel' 
              data-bs-slide-to='$index' 
              class='$activeClass bg-success'
              aria-label='Slide " . ($index + 1) . "'
              aria-current='" . ($index === 0 ? 'true' : 'false') . "'>
              </button>";
                }
                ?>
              </div>
            </div>

            <!-- Conditionally Render Carousel Controls -->
            <?php if (count($carousel_items) > 1) { ?>
              <button class="carousel-control-prev custom-carousel-btn" type="button" data-bs-target="#partnerCarousel"
                data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
              </button>
              <button class="carousel-control-next custom-carousel-btn" type="button" data-bs-target="#partnerCarousel"
                data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
              </button>
            <?php } ?>

           <!-- View Page Poster End-->

            <!-- edit modal start -->
            <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-lg">
                <div class="modal-content">
                  <div class="modal-header">
                    <h1 class="modal-title fs-5 text-muted fw-bold" id="editModalLabel">Edit News</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body pb-0">
                  <form method="POST" action="../../function/content_manager/poster_function.php" enctype="multipart/form-data">
                      <input type="hidden" name="poster_id" id="edit-poster-id">
                      <input type="hidden" class="form-control" id="edit-date" name="poster_date" readonly>
                      <div class="mb-3">
                        <label class="form-label fw-semibold text-muted">Current Image:</label>
                        <div id="edit-previewContainer" class="text-center">
                          <img id="edit-previewImage" class="img-fluid"
                            style="max-width: 30%; height: auto; border: 2px solid #ccc; border-radius: 8px;">
                        </div>
                      </div>

                      <div class="mb-3">
                        <label class="form-label fw-semibold text-muted">Upload New Image:</label>
                        <input type="file" class="form-control" name="poster_image" id="edit-image-input"
                          accept="image/*">
                      </div>
                      <div class="mb-3">
                        <label class="form-label fw-semibold text-muted">Status:</label>
                        <select class="form-control" id="edit-status" name="poster_status" required>
                          <option value="Active">Active</option>
                          <option value="Inactive">Inactive</option>
                        </select>
                      </div>
                      <div class="modal-footer">
                        <button type="submit" name="update_poster" class="btn btn-dynamic"  data-bs-toggle="tooltip" 
                        data-bs-placement="top" title="Click to save">
                          <i class="ri-save-fill"></i> Save
                        </button>
                      </div>
                    </form>

                  </div>
                </div>
              </div>
            </div>
            <!-- edit modal end -->

          </div>
        </div>
      </div>
      <?php include 'include/footer.php'; ?>
    </div>
  </main>

  <!-- start js -->
  <script src="../../assets/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../../assets/bootstrap/js/jquery-3.7.1.js"></script>
  <script src="../../assets/bootstrap/js/script.js"></script>
  <script src="../../assets/bootstrap/js/page_poster.js"></script>
  <script src="../../assets/bootstrap/js/drag_and_drop.js?=1.1"></script>
  <script src="../../assets/bootstrap/js/activeLink.js?v=1.0"></script>
  <script src="../../assets/bootstrap/js/confirmation.js"></script>
  <script src="../../assets/bootstrap/js/site_settings.js"></script>

  <script>
    // script for edit modal in news start
    document.addEventListener("DOMContentLoaded", function() {
      const editButtons = document.querySelectorAll(".edit-btn");

      editButtons.forEach(button => {
        button.addEventListener("click", function() {
          const id = this.getAttribute("data-id");
          const image = this.getAttribute("data-image");
          const status = this.getAttribute("data-status");
          const date = this.getAttribute("data-date"); // GET THE DATE
          document.getElementById("edit-poster-id").value = id;
          document.getElementById("edit-status").value = status;
          document.getElementById("edit-previewImage").src = image;
          document.getElementById("edit-date").value = date; // SET THE DATE
        });
      });
    });
    // script for edit modal in news end
    // script for getting immedietly the imgae start
    document.getElementById('edit-image-input').addEventListener('change', function(event) {
      const file = event.target.files[0];
      if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
          document.getElementById('edit-previewImage').src = e.target.result;
        };
        reader.readAsDataURL(file);
      }
    });
    // script for getting immedietly the imgae end
  </script>

  <!-- end js -->

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


  <!-- START >> JS SCRIPT DELETE CONFIRMATION  -->
  <script>
    document.addEventListener("DOMContentLoaded", function() {
      window.openModal = function(event, poster_id) {
        event.preventDefault();
        document.getElementById("modalPosterId").value = poster_id; // Set poster ID
        document.getElementById("confirmationModal").style.display = "flex";
      };

      window.closeModal = function() {
        document.getElementById("confirmationModal").style.display = "none";
      };

      window.closeModalOutside = function(event) {
        if (event.target.id === "confirmationModal") {
          closeModal();
        }
      };
    });
  </script>

  <!-- END >> JS SCRIPT DELETE CONFIRMATION  -->



</body>

</html>