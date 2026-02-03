<?php
include '../../connection/dbconnection.php';
session_start();
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
  <link rel="stylesheet" href="../../assets/bootstrap/css/style.css?=v1.6">
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
    <?php include 'include/navbar.php'; ?>
    <!-- include navbar end -->
    <!-- start: Content -->
    <div class="p-4">
      <div class="row">
        <div class="card border-0 pb-3">
          <div class="card-body">
            <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
              <h5 class="card-title fs-6 mb-2 mb-md-0">Manage Announcements</h5>
              <button type="button" class="btn btn-sm rounded-2 px-4 btn-dynamic"
                data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-toggle="tooltip"
                data-bs-placement="top" title="Click to add a new announcement">
                <i class="ri-add-line"></i> Add Announcement
              </button>
            </div>
            <p class="card-text text-muted small">
              Stay informed with the latest updates, important notices, key announcements. This section keeps you
              connected with recent events, system updates, and essential information to ensure you’re always in the
              loop.
            </p>
          </div>

          <!-- Modal -->
          <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
              <div class="modal-content">
                <div class="modal-header">
                  <h1 class="modal-title fs-5 text-muted fw-bold" id="exampleModalLabel">Add Announcement</h1>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pb-0">
                  <form method="POST" action="../../function/announcement_function.php" enctype="multipart/form-data">
                    <div class="mb-3">
                      <label class="form-label fw-semibold text-muted">Upload Image:</label>
                      <div class="upload-area" id="uploadArea"
                        style="position: relative; text-align: center; border: 2px dashed #ccc; padding: 20px; cursor: pointer;">
                        <!-- Placeholder content -->
                        <img id="uploadIcon" src="https://cdn-icons-png.flaticon.com/512/126/126477.png"
                          alt="Upload Icon" style="width: 50px;">
                        <p id="uploadText" class="mb-0">Drag & Drop <br><span class="text-success">or browse</span></p>
                        <small class="text-muted">Supports: JPEG, JPG, PNG</small>
                        <input type="file" id="fileInput" name="announcement_image" class="d-none"
                          accept="image/jpeg, image/jpg, image/png">
                      </div>
                      <div id="previewContainer" class="preview-container d-none"
                        style="position: relative; margin-top: 20px;">
                        <button type="button" class="delete-btn btn btn-danger btn-sm" id="deleteBtn"
                          style="position: absolute; top: -10px; right: -10px;">&times;</button>
                        <img id="previewImage" class="preview-img img-fluid" alt="Preview Image"
                          style="max-width: 100%; border: 2px solid #ccc; border-radius: 8px;">
                      </div>
                    </div>

                    <div class="mb-3">
                      <label for="title" class="form-label fw-semibold text-muted">Title:</label>
                      <input type="text" class="form-control" id="title" name="announcement_title"
                        placeholder="Enter Announcement Title" required>
                    </div>

                    <div class="mb-3">
                      <label for="description" class="form-label fw-semibold text-muted">Description:</label>
                      <textarea class="form-control" id="description" name="announcement_description" rows="3"
                        placeholder="Enter Announcement Description" required></textarea>
                    </div>

                    <!-- <div class="mb-3">
                      <label for="status" class="form-label fw-semibold text-muted">Status:</label>
                      <select class="form-control" id="status" name="announcement_status" required>
                        <option value="" disabled selected>Select Status</option>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                      </select>
                    </div> -->

                    <div class="modal-footer">
                      <button type="submit" name="add_announcement" class="btn btn-md btn-dynamic" data-bs-toggle="tooltip"
                        data-bs-placement="top" title="Click to save">
                        <i class="ri-save-fill"></i> Save
                      </button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
          <!-- container nav -->
          <!-- carousel view start -->
          <div id="partnerCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner p-4">
              <div class="carousel-item active">
                <div class="d-flex flex-wrap justify-content-center gap-4">
                  <?php
                  include '../../connection/dbconnection.php';
                  $sql = "SELECT * FROM announcement";
                  $result = $conn->query($sql);
                  ?>
                  <div class="row">
                    <?php
                    if ($result->num_rows > 0) {
                      while ($row = $result->fetch_assoc()) {
                        $title = $row['announcement_title'];
                        // $description = $row['announcement_description'];
                        $description = substr($row['announcement_description'], 0, 120) . '...';
                        $date_posted = date('F j, Y', strtotime($row['announcement_date']));
                        $time_posted = date('g:i A', strtotime($row['announcement_time']));
                        $image = $row['announcement_image'];
                        $status = $row['announcement_status'];
                        $status_label = $status === 'active' ? 'announcement-status-active' : 'announcement-status-inactive';
                    ?>

                        <div class="card announcement-card ms-4 mb-5" style="width: 20rem;">
                          <div class="image-container" style="position: relative;">
                            <img src="../../assets/uploads/announcement/<?php echo $image; ?>" class="card-img-top"
                              alt="Announcement Image">
                            <span class="<?php echo $status_label; ?>"><?php echo ucfirst($status); ?></span>
                            <div class="date-label">
                              Posted: <?php echo $date_posted . ' at ' . $time_posted; ?>
                            </div>
                          </div>
                          <div class="card-body">
                            <div class="dropdown three-dots-accord">
                              <button class="btn p-0 border-0 float-end" type="button" data-bs-toggle="dropdown"
                                aria-expanded="false" data-bs-toggle="tooltip"
                                data-bs-placement="top" title="Click here to see the action">
                                <span></span><span></span><span></span>
                              </button>
                              <ul class="dropdown-menu dropdown-menu-end">
                                <!-- <li>
                                  <a class="dropdown-item text-dark view-btn" href="#" data-bs-toggle="modal"
                                    data-bs-target="#viewModal" data-title="<?php echo htmlspecialchars($title); ?>"
                                    data-description="<?php echo htmlspecialchars($description); ?>"
                                    data-image="../../assets/uploads/announcement/<?php echo $image; ?>" data-bs-toggle="tooltip"
                                    data-bs-placement="top"
                                    title="Click to view this announcement"><i class="ri-eye-line"></i> View
                                  </a>
                                </li> -->

                                <li>
                                  <a class="dropdown-item text-dark edit-btn" href="#" data-bs-toggle="modal"
                                    data-bs-target="#editModal"
                                    data-id="<?php echo $row['announcement_id']; ?>"
                                    data-title="<?php echo htmlspecialchars($title); ?>"
                                     data-description="<?= htmlspecialchars($row['announcement_description'], ENT_QUOTES, 'UTF-8'); ?>"
                                    
                                    data-image="../../assets/uploads/announcement/<?php echo $image; ?>"
                                    data-status="<?php echo $status; ?>"
                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                    title="Click to edit this announcement"><i class="ri-pencil-line"></i> Edit
                                  </a>
                                </li>

                                <li>
                                  <a href="javascript:void(0);" class="dropdown-item text-dark text-decoration-none"
                                    data-id="<?= $row['announcement_id']; ?>" onclick="openModal(event, this.dataset.id);" data-bs-toggle="tooltip"
                                    data-bs-placement="top"
                                    title="Click to delete this announcement"><i class="ri-delete-bin-line"></i>
                                    Delete
                                  </a>
                                </li>

                              </ul>
                            </div>
                            <h5 class="card-title"><?php echo htmlspecialchars($title); ?></h5>
                            <p class="card-text text-muted text-justify"><?php echo htmlspecialchars($description); ?></p>

                          </div>
                          <div class="d-flex justify-content-between mt-auto p-3">
                            <button class="news-btn w-100 read-more-btn" data-bs-toggle="modal"
                              data-bs-target="#viewModal"
                              data-title="<?= htmlspecialchars($title, ENT_QUOTES); ?>"
                              data-description="<?= htmlspecialchars($row['announcement_description'], ENT_QUOTES, 'UTF-8'); ?>"
                       
                              data-image="../../assets/uploads/announcement/<?= $image; ?>"
                              data-bs-toggle="tooltip"  data-bs-placement="top"
                              title="Click to view this announcement"
                              onclick="setModalContent(this)">
                              Read More <i class="ri-arrow-right-line"></i>
                            </button>
                          </div>

                        </div>
                    <?php
                      }
                    } else {
                      echo "<p>No announcements available.</p>";
                    }
                    $conn->close();
                    ?>
                  </div>
                </div>
              </div>
            </div>

            <script>
              function setModalContent(button) {
                const title = button.getAttribute('data-title');
                const description = button.getAttribute('data-description');
                const image = button.getAttribute('data-image');

                // Set the modal content
                document.getElementById('modalTitle').value = title;
                document.getElementById('modalDescription').value = description;
                document.getElementById('modalImage').src = image;
              }
            </script>

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

            <div class="carousel-indicators">
              <button type="button" data-bs-target="#partnerCarousel" data-bs-slide-to="0" class="active bg-success"
                aria-current="true" aria-label="Slide 1"></button>
              <button type="button" data-bs-target="#partnerCarousel" data-bs-slide-to="1" class="bg-success"
                aria-label="Slide 2"></button>
            </div>
          </div>
          <!-- carousel view end -->

          <!-- container nav -->

          <!-- Edit Modal -->
          <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
              <div class="modal-content">
                <div class="modal-header">
                  <h1 class="modal-title fs-5 text-muted fw-bold" id="editModalLabel">Edit Announcement</h1>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pb-0">
                  <form method="POST" action="../../function/announcement_function.php" enctype="multipart/form-data">
                    <input type="hidden" name="announcement_id" id="edit-announcement-id">

                    <div class="mb-3">
                      <label class="form-label fw-semibold text-muted">Current Image:</label>
                      <div id="edit-previewContainer" class="text-center">
                        <img id="edit-previewImage" class="img-fluid"
                          style="max-width: 30%; height: auto; border: 2px solid #ccc; border-radius: 8px;">
                      </div>
                    </div>

                    <div class="mb-3">
                      <label class="form-label fw-semibold text-muted">Upload New Image:</label>
                      <input type="file" class="form-control" name="announcement_image" id="edit-image-input"
                        accept="image/*">
                    </div>

                    <div class="mb-3">
                      <label class="form-label fw-semibold text-muted">Title:</label>
                      <input type="text" class="form-control" id="edit-title" name="announcement_title" required>
                    </div>

                    <div class="mb-3">
                      <label class="form-label fw-semibold text-muted">Description:</label>
                      <textarea class="form-control" id="edit-description" name="announcement_description" rows="3"
                        required></textarea>
                    </div>

                    <div class="mb-3">
                      <label class="form-label fw-semibold text-muted">Status:</label>
                      <select class="form-control" id="edit-status" name="announcement_status" required>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                      </select>
                    </div>

                    <div class="modal-footer">
                      <button type="submit" name="update_announcement" class="btn btn-dynamic btn-md" data-bs-toggle="tooltip"
                        data-bs-placement="top" title="Click to save">
                        <i class="ri-save-fill"></i> Save
                      </button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- edit modal end -->

        <!-- View Modal Structure start-->
        <div class="modal fade" id="viewModal" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title fw-bold text-muted" id="viewModalLabel">View Announcement Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <form>
                  <div class="mb-3 text-center">
                    <img id="modalImage" src="" alt="View Image" class="img-fluid rounded shadow"
                      style="max-width: 50%; height: auto;">
                  </div>
                  <div class="mb-3">
                    Posted: <?php echo $date_posted . ' at ' . $time_posted; ?>
                  </div>
                  <div class="mb-3">
                    <label for="modalTitle" class="form-label fw-semibold text-muted">Title:</label>
                    <input id="modalTitle" type="text" class="form-control" placeholder="Title" disabled>
                  </div>
                  <div class="mb-3">
                    <label for="modalDescription" class="form-label fw-semibold text-muted">Description:</label>
                    <textarea id="modalDescription" class="form-control" rows="3" placeholder="Description"
                      disabled></textarea>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
        <!-- View Modal Structure end-->
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
  <script src="../../assets/bootstrap/js/carousel.js"></script>
  <script src="../../assets/bootstrap/js/drag_and_drop.js?=v1.1"></script>
  <script src="../../assets/bootstrap/js/activeLink.js"></script>
  <script src="../../assets/bootstrap/js/site_settings.js?v=1.0"></script>
  <script src="../../assets/bootstrap/js/view_announcement_modal.js"></script>

  <!-- end js -->

  <script>
    // script for edit modal in announcement start
    document.addEventListener("DOMContentLoaded", function() {
      document.querySelectorAll('.edit-btn').forEach(button => {
        button.addEventListener('click', function() {
          const id = this.getAttribute("data-id");
          const title = this.getAttribute("data-title");
          const description = this.getAttribute("data-description");
          const image = this.getAttribute("data-image");
          const status = this.getAttribute("data-status");

          document.getElementById("edit-announcement-id").value = id;
          document.getElementById("edit-title").value = title;
          document.getElementById("edit-description").value = description;
          document.getElementById("edit-status").value = status;
          document.getElementById("edit-previewImage").src = image;
        });
      });
    });
    // script for edit modal in announcement end

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

  <script>
    document.addEventListener("DOMContentLoaded", function() {
      window.openModal = function(event, announcement_id) {
        event.preventDefault();
        document.getElementById("modalAnnouncementId").value = announcement_id; // Set Announcement ID
        document.getElementById("confirmationModal-announcement").style.display = "flex";
      };

      window.closeModal = function() {
        document.getElementById("confirmationModal-announcement").style.display = "none";
      };

      window.closeModalOutside = function(event) {
        if (event.target.id === "confirmationModal-announcement") {
          closeModal();
        }
      };
    });
  </script>
</body>

</html>