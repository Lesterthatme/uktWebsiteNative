<?php
include '../../connection/dbconnection.php';
session_start();
include '../../function/content_manager/partnership_function.php';

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
  <link rel="stylesheet" href="../../assets/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="../../assets/bootstrap/css/style.css?=v2.8">
  <link rel="stylesheet" href="../../assets/RemixIcon/fonts/remixicon.css">
</head>

<body class="bg-light">

  <!-- include side bar start -->
  <?php include 'include/alert.php'; ?>
  <?php include 'confirmation.php'; ?>
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
            <div class="doc-tabs-container mt-3">
              <ul class="doc-tabs d-flex list-unstyled">
                <li class="me-3">
                  <a class="doc-link" href="page_management">Highlights</a>
                </li>
                <li class="me-3">
                  <a class="doc-link active" href="partnership">Partnership</a>
                </li>
                <li class="me-3">
                  <a class="doc-link" href="calendar">University Calendar</a>
                </li>
                <li class="me-3">
                  <a class="doc-link" href="FaQ">FAQ</a>
                </li>
              </ul>
              <hr class="doc-tabs-divider">
            </div>
            <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
              <h5 class="card-title fs-6 mb-2 mb-md-0">Partnership</h5>
              <button type="button" class="btn btn-sm rounded-2 px-4 btn-dynamic" data-bs-toggle="modal"
                data-bs-target="#exampleModal"  data-bs-toggle="tooltip" data-bs-placement="top" 
                title="Click to add new partnership">
                <i class="ri-add-line"></i> Add Partnership
              </button>
            </div>

            <p class="card-text text-muted small">Learn about our collaborations with institutions and industries that strengthen research, education and innovation.</p>
            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
              aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h1 class="modal-title fs-5 text-muted fw-bold" id="exampleModalLabel">Add University Partnership
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <form action="partnership.php" method="POST" enctype="multipart/form-data">
                      <div class="mb-3">
                        <label class="form-label fw-semibold text-muted">Upload your File:</label>
                        <div class="upload-area" id="uploadArea">
                          <img src="https://cdn-icons-png.flaticon.com/512/126/126477.png" alt="Upload Icon">
                          <p class="mb-0">Drag & Drop <br><span class="text-success">or browse</span></p>
                          <small class="text-muted">Supports: JPEG, JPG, PNG</small>
                          <input type="file" id="fileInput" name="up_image" class="d-none"
                            accept="image/jpeg, image/jpg, image/png">
                        </div>
                        <div id="previewContainer" class="preview-container d-none">
                          <button type="button" class="delete-btn" id="deleteBtn">&times;</button>
                          <img id="previewImage" class="preview-img" alt="Preview Image">
                        </div>
                      </div>

                      <div class="mb-3">
                        <label for="message" class="form-label fw-semibold text-muted">University Partnership
                          Name:</label>
                        <input type="text" class="form-control" name="up_name"
                          placeholder="Enter University Partnership Name">
                      </div>
                      <div class="mb-3">
                        <label for="message" class="form-label fw-semibold text-muted">Website Link:</label>
                        <input type="text" class="form-control" name="up_link" placeholder="Enter Website Link">
                      </div>
                  </div>
                  <div class="modal-footer">

                    <button type="submit" name="add_partnership" class="btn btn-dynamic" data-bs-toggle="tooltip" 
                    data-bs-placement="top" title="Click to save"><i class="ri-save-fill"></i>
                      Save</button>
                  </div>
                  </form>
                </div>
              </div>
            </div>
            <!-- START > MAIN CONTENT -->
            <?php 
            include '../../connection/dbconnection.php';
            $query = "SELECT up_link, up_id, up_name, up_image, up_date, up_time, up_status FROM university_partnership";
            $result = $conn->query($query);
            $first_item = true;
            ?>

            <div id="partnerCarousel" class="carousel slide" data-bs-ride="carousel">
              <div class="carousel-inner p-4">
                <div class="carousel-item <?= $first_item ? 'active' : '' ?>">
                  <div class="d-flex flex-wrap justify-content-center gap-4">
                    <?php if ($result && $result->num_rows > 0): ?>
                      <?php while ($row = $result->fetch_assoc()): ?>
                        <?php
                        $up_link = $row['up_link'];
                        $up_name = $row['up_name'];
                        $up_image = $row['up_image'];
                        $up_date = date("F j, Y", strtotime($row['up_date']));
                        $up_time = date("g:i A", strtotime($row['up_time']));
                        $up_status = $row['up_status'];
                        $status_badge = $up_status === 'Active' ? 'status-badge text-bg-success' : 'status-badge text-bg-danger';
                        ?>

                        <div class="partner-card">
                          <div class="dropdown three-dots">
                          <button class="btn p-0 border-0" type="button" data-bs-toggle="dropdown" aria-expanded="false" data-bs-toggle="tooltip" 
                            data-bs-placement="top" title="Click here to see the action">
                              <span></span><span></span><span></span>
                            </button>
                            <!-- DROPDOWN EDIT/DELETE -->
                            <ul class="dropdown-menu dropdown-menu-end">
                              <!-- Edit Option -->
                              <li>
                                <a class="dropdown-item edit-btn text-dark" href="#" data-bs-toggle="modal"
                                  data-bs-target="#editModal" data-id="<?= $row['up_id'] ?>"
                                  data-name="<?= htmlspecialchars($row['up_name']) ?>"
                                  data-link="<?= htmlspecialchars($row['up_link']) ?>"
                                  data-status="<?= htmlspecialchars($row['up_status']) ?>"
                                  data-image="<?= htmlspecialchars($row['up_image']) ?>" data-bs-toggle="tooltip" 
                                  data-bs-placement="top" title="Click here to edit this partnership details">
                                  <i class="ri-pencil-line"></i> Edit
                                </a>
                              </li>

                              <li>
                                <a class="dropdown-item text-dark text-decoration-none" href="javascript:void(0);"
                                  data-id="<?= $row['up_id'] ?>" onclick="return openModal(event, this.dataset.id);" data-bs-toggle="tooltip" 
                                  data-bs-placement="top" title="Click here to delete this partnership">
                                  <i class="ri-delete-bin-line"></i> Delete
                                </a>
                              </li>
                              <!-- DELETE BUTTON -->
                            </ul>
                            </ul>
                            <!-- DROPDOWN EDIT/DELETE -->
                          </div>
                          <img src="../../assets/uploads/partnership/<?= htmlspecialchars($up_image) ?>"
                            alt="University Logo" class="university-logo">
                          <h6 class="mt-2"><?= htmlspecialchars($up_name) ?></h6>
                          <p class="text-muted">Date Created: <?= htmlspecialchars($up_date) ?> at
                            <?= htmlspecialchars($up_time) ?>
                          </p>
                          <p class="text-muted">
                            Website link:
                            <a href="<?= strpos($up_link, 'http') === 0 ? htmlspecialchars($up_link) : 'https://' . htmlspecialchars($up_link) ?>" target="_blank">
                              <?= htmlspecialchars($up_link) ?>
                            </a>
                          </p>

                          <p>Status: <span class="status-badge <?= $status_badge ?>"><?= htmlspecialchars($up_status) ?></span></p>
                        </div>

                      <?php endwhile; ?>
                    <?php else: ?>
                      <p class="text-center">No university partnerships found.</p>
                    <?php endif; ?>
                  </div>
                </div>
              </div>

              <!-- Carousel Controls -->
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

              <!-- Carousel Indicators -->
              <div class="carousel-indicators">
                <button type="button" data-bs-target="#partnerCarousel" data-bs-slide-to="0" class="active bg-success"
                  aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#partnerCarousel" data-bs-slide-to="1" class="bg-success"
                  aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#partnerCarousel" data-bs-slide-to="2" class="bg-success"
                  aria-label="Slide 3"></button>
              </div>
            </div>

            <!-- Edit Event Modal -->
            <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
              <div class="modal-dialog p-2">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title fw-bold text-muted" id="editModalLabel">Edit Partnership</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>

                  <div class="modal-body">
                    <form method="POST" action="partnership.php" enctype="multipart/form-data">
                      <input type="hidden" name="up_id" value="<?php echo $up_id; ?>">

                      <div class="mb-3">
                        <label class="form-label fw-semibold text-muted">Upload your File:</label>
                        <div class="upload-area" id="editUploadArea">
                          <img src="https://cdn-icons-png.flaticon.com/512/126/126477.png" alt="Upload Icon">
                          <p class="mb-0">Drag & Drop <br><span class="text-success">or browse</span></p>
                          <small class="text-muted">Supports: JPEG, JPG, PNG</small>
                          <input name="up_image" value="<?php echo $up_image; ?>" type="file" id="editFileInput"
                            class="d-none" accept="image/jpeg, image/jpg, image/png">
                        </div>
                        <div id="editPreviewContainer" class="preview-container d-none">
                          <button type="button" class="delete-btn" id="editDeleteBtn">&times;</button>
                          <img id="editPreviewImage" class="preview-img" alt="Preview Image">
                        </div>

                      </div>

                      <div class="mb-3">
                        <label for="message" class="form-label fw-semibold text-muted">University Partnership
                          Name:</label>
                        <input name="up_name" value="<?php echo $up_name; ?>" type="text" class="form-control"
                          placeholder="Enter University Partnership Name">
                      </div>
                      <div class="mb-3">
                        <label for="message" class="form-label fw-semibold text-muted">Website Link:</label>
                        <input type="text" class="form-control" name="up_link" value="<?php echo $up_link; ?>"
                          placeholder="Enter Website Link">
                      </div>

                      <div class="mb-3">
                        <label for="form-select" class="form-label fw-semibold text-muted">Status:</label>
                        <select class="form-select border border-2 rounded-2" name="up_status" required>
                          <option value="Active" <?php echo ($up_status == 'Active') ? 'selected' : ''; ?>>Active</option>
                          <option value="Inactive" <?php echo ($up_status == 'Inactive') ? 'selected' : ''; ?>>Inactive
                          </option>
                        </select>
                      </div>
                      <div class="modal-footer pb-0">
                        <button type="submit" name="update_partnership" class="btn btn-dynamic" data-bs-toggle="tooltip" 
                        data-bs-placement="top" title="Click to save">
                        <i class="ri-save-fill"></i>
                          Save</button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
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
  <script src="../../assets/bootstrap/js/carousel.js"></script>
  <script src="../../assets/bootstrap/js/drag_and_drop.js?=v1.0"></script>
  <script src="../../assets/bootstrap/js/activeLink.js"></script>
  <script src="../../assets/bootstrap/js/site_settings.js?=v1.5"></script>
  <!-- end js -->
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const editButtons = document.querySelectorAll('.edit-btn');
      const editModal = document.getElementById('editModal');

      // Modal form fields
      const upIdInput = editModal.querySelector('input[name="up_id"]');
      const upNameInput = editModal.querySelector('input[name="up_name"]');
      const upLinkInput = editModal.querySelector('input[name="up_link"]');
      const upStatusSelect = editModal.querySelector('select[name="up_status"]');
      const previewImage = editModal.querySelector('#editPreviewImage');

      editButtons.forEach(button => {
        button.addEventListener('click', () => {
          const upId = button.getAttribute('data-id');
          const upName = button.getAttribute('data-name');
          const upLink = button.getAttribute('data-link');
          const upStatus = button.getAttribute('data-status'); // Ensure this is set correctly
          const upImage = button.getAttribute('data-image');

          upIdInput.value = upId;
          upNameInput.value = upName;
          upLinkInput.value = upLink;
          upStatusSelect.value = upStatus; // This should now work

          if (upImage) {
            previewImage.src = `../../assets/uploads/partnership/${upImage}`;
            previewImage.parentElement.classList.remove('d-none');
          } else {
            previewImage.parentElement.classList.add('d-none');
          }
        });
      });
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


  <script>
    document.addEventListener("DOMContentLoaded", function() {
      window.openModal = function(event, up_id) {
        event.preventDefault();
        document.getElementById("modalUpId").value = up_id; // Set the hidden input value
        document.getElementById("confirmationModal-partnership").style.display = "flex"; // Show modal
      };

      window.closeModal = function() {
        document.getElementById("confirmationModal-partnership").style.display = "none"; // Hide modal
      };

      window.closeModalOutside = function(event) {
        if (event.target.id === "confirmationModal-partnership") {
          closeModal();
        }
      };
    });
  </script>
</body>

</html>