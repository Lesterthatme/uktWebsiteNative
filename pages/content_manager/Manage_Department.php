<?php

include '../../connection/dbconnection.php';
session_start();
include '../../function/content_manager/department_function.php';

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
  <link rel="stylesheet" href="../../assets/bootstrap/css/style.css?=v1.3">
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
              <h5 class="card-title fs-6 mb-2 mb-md-0">Manage Department</h5>
              <button type="button" class="btn btn-sm rounded-2 px-4 btn-dynamic" data-bs-toggle="modal"
                data-bs-target="#exampleModal" data-bs-toggle="tooltip"
                title="Click here to add department">
                <i class="ri-add-line"></i> Add Department
              </button>
            </div>

            <p class="card-text text-muted small">
              Stay informed with the latest updates, important notices, and key announcements. This section keeps you
              connected with recent events, system updates, and essential information to ensure you’re always in the
              loop.
            </p>

            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
              aria-hidden="true">
              <div class="modal-dialog modal-lg">
                <div class="modal-content">
                  <div class="modal-header">
                    <h1 class="modal-title fs-5 text-muted fw-bold" id="exampleModalLabel">Add Department</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <form method="POST" action="Manage_Department.php" enctype="multipart/form-data">
                      <div class="mb-3">
                        <label class="form-label fw-semibold text-muted">Upload About Image:</label>
                        <div class="upload-area" id="uploadArea">
                          <img src="https://cdn-icons-png.flaticon.com/512/126/126477.png" alt="Upload Icon">
                          <p class="mb-0">Drag & Drop <br><span class="text-success">or browse</span></p>
                          <small class="text-muted">Supports: JPEG, JPG, PNG</small>
                          <input type="file" name="dm_image" id="fileInput" class="d-none"
                            accept="image/jpeg, image/jpg, image/png">
                        </div>
                        <div id="previewContainer" class="preview-container d-none">
                          <button type="button" class="delete-btn" id="deleteBtn">&times;</button>
                          <img id="previewImage" class="preview-img" alt="Preview Image">
                        </div>
                      </div>

                      <div class="mb-3">
                        <label for="message" class="form-label fw-semibold text-muted">Department Name:</label>
                        <input type="text" name="dm_name" class="form-control" placeholder="Enter Department Name">
                      </div>
                      <div class="mb-3">
                        <label for="message" class="form-label fw-semibold text-muted">About Department:</label>
                        <textarea class="form-control" name="dm_about" id="message" rows="3"
                          placeholder="Enter About Department"></textarea>
                      </div>
                  </div>
                  <div class="modal-footer">
                    <button type="submit" name="add_department" class="btn btn-dynamic" data-bs-toggle="tooltip"
                      title="Click here to save"><i class="ri-save-fill"></i>
                      Save</button>
                  </div>
                  </form>
                </div>
              </div>
            </div>
            <!-- Department start -->
            <?php

            ?>
            <div class="d-flex flex-wrap justify-content-center gap-4 mt-5">
              <?php
              $query = "SELECT department_id, dm_name, dm_about, dm_image, dm_created, dm_status, ap_id FROM department";
              $result = mysqli_query($conn, $query);

              while ($department = mysqli_fetch_assoc($result)) {
              ?>
                <div class="card department-card" style="width: 18rem;">
                  <div class="image-container" style="position: relative;">
                    <div class="text-center">
                      <!-- Display the department image -->
                      <img src="../../assets/uploads/department_image/<?= htmlspecialchars($department['dm_image']) ?>"
                        class="card-img-top w-50" alt="Department Image">
                    </div>
                    <span
                      class="announcement-status-active <?= ($department['dm_status'] === 'Active') ? 'text-bg-success' : 'text-bg-danger'; ?>">
                      <?= htmlspecialchars($department['dm_status']) ?>
                    </span>

                  </div>
                  <div class="card-body d-flex flex-column" style="min-height: 150px;">
                    <!-- Dropdown menu -->
                    <div class="dropdown three-dots-accord align-self-end">
                      <button class="btn p-0 border-0" type="button" data-bs-toggle="dropdown"
                        aria-expanded="false" data-bs-toggle="tooltip" title="Click here to see the action">
                        <span></span><span></span><span></span>
                      </button>
                      <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                          <a class="dropdown-item text-dark"
                            href="view_department?department_id=<?= $department['department_id'] ?>"
                            data-bs-toggle="tooltip" title="Click here to manage the department"><i class="ri-settings-3-fill"></i> Manage
                          </a>
                        </li>
                        <li>
                          <a class="dropdown-item text-dark edit-btns" href="#" data-bs-toggle="modal"
                            data-bs-target="#editModal" data-id="<?= htmlspecialchars($department['department_id']) ?>"
                            data-status="<?= htmlspecialchars($department['dm_status']) ?>"
                            data-name="<?= htmlspecialchars($department['dm_name']) ?>"
                            data-about="<?= htmlspecialchars($department['dm_about']) ?>"
                            data-image="<?= htmlspecialchars($department['dm_image']) ?>" data-bs-toggle="tooltip"
                            title="Click here to edit the details of this department"><i class="ri-pencil-line"></i> Edit
                          </a>
                        </li>
                      </ul>
                    </div>

                    <!-- Main content -->
                    <div class="mt-2">
                      <h5 class="card-title"><?= htmlspecialchars($department['dm_name']) ?></h5>
                    </div>

                    <!-- Fixed Date at bottom -->
                    <p class="card-text text-muted mt-auto">
                      Date Posted: <?= date("F j, Y", strtotime($department['dm_created'])) ?>
                    </p>
                  </div>
                </div>
              <?php
              }
              ?>
            </div>
          </div>


          <!-- Department end  and Community Development End-->

          <!-- edit modal start -->
          <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
              <div class="modal-content">
                <div class="modal-header">
                  <h1 class="modal-title fs-5 text-muted fw-bold" id="exampleModalLabel">Edit Poster</h1>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <form method="POST" action="Manage_Department.php" enctype="multipart/form-data">
                    <input type="hidden" name="department_id" id="editDepartmentId">
                    <div class="mb-3">
                      <label class="form-label fw-semibold text-muted">Upload Image:</label>
                      <div class="upload-area" id="editUploadArea">
                        <img src="https://cdn-icons-png.flaticon.com/512/126/126477.png" alt="Upload Icon">
                        <p class="mb-0">Drag & Drop <br><span class="text-success">or browse</span></p>
                        <small class="text-muted">Supports: JPEG, JPG, PNG</small>
                        <input type="file" id="editFileInput" name="dm_image" value="<?php echo $dm_image; ?>"
                          class="d-none" accept="image/jpeg, image/jpg, image/png">
                      </div>
                      <div id="editPreviewContainer" class="preview-container d-none">
                        <button type="button" class="delete-btn" id="editDeleteBtn">&times;</button>
                        <img id="editPreviewImage" class="preview-img" alt="Preview Image">
                      </div>
                    </div>
                    <div class="mb-3">
                      <label class="form-label fw-semibold text-muted">Department Name:</label>
                      <input type="text" class="form-control" name="dm_name" value="<?php echo $dm_name; ?>"
                        id="editDepartmentName" required>
                    </div>

                    <div class="mb-3">
                      <label class="form-label fw-semibold text-muted">Department About:</label>
                      <textarea class="form-control" name="dm_about" id="editDepartmentAbout"
                        value="<?php echo $dm_about; ?>" required></textarea>
                    </div>
                    <div class="mb-3">
                      <label for="form-select" class="form-label fw-semibold text-muted">Status:</label>
                      <select id="editDmStatus" name="dm_status" class="form-select">
                        <option value="1">Active</option>
                        <option value="2">Inactive</option>
                      </select>

                    </div>

                    <div class="modal-footer pb-0">
                      <button type="submit" name="update_department" class="btn btn-dynamic" data-bs-toggle="tooltip"
                        title="Click here to save"><i
                          class="ri-save-fill"></i> Save</button>
                    </div>
                  </form>

                </div>
              </div>
            </div>
            <!-- edit modal end -->

            <!-- View  News Modal Structure -->
            <div class="modal fade" id="newsModal" tabindex="-1" aria-labelledby="newsModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-lg">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title fw-bold text-muted" id="newsModalLabel">View News Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body text-center">
                    <img src="../../assets/images/announcement/2.jpg" class="img-fluid rounded mb-3"
                      alt="Announcement Image" style="max-width: 30%; height: auto;">
                    <h5>Songkran New Year, Year of Chosakt</h5>
                    <p class="text-muted">The University of Kratie is preparing for the upcoming Songkran New Year,
                      which marks the Year of Chosak BC. The celebration, scheduled for the entire province, is expected
                      to bring together students, faculty, and local communities.</p>
                  </div>
                </div>
              </div>
            </div>
            <!-- View  News Modal Structure -->
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
  <script src="../../assets/bootstrap/js/drag_and_drop.js"></script>
  <script src="../../assets/bootstrap/js/activeLink.js?v=1.3"></script>
  <script src="../../assets/bootstrap/js/table.js"></script>
  <script src="../../assets/bootstrap/js/site_settings.js"></script>
  <!-- end js -->

  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const editButtons = document.querySelectorAll('.edit-btns');
      const editModal = document.getElementById('editModal');

      const departmentIdField = editModal.querySelector('#editDepartmentId');
      const dmNameField = editModal.querySelector('#editDepartmentName');
      const dmAboutField = editModal.querySelector('#editDepartmentAbout');
      const dmStatusSelect = editModal.querySelector('#editDmStatus');
      const previewImage = editModal.querySelector('#editPreviewImage');
      const editPreviewContainer = editModal.querySelector('#editPreviewContainer');

      editButtons.forEach(button => {
        button.addEventListener('click', () => {
          const departmentId = button.getAttribute('data-id');
          const dmStatus = button.getAttribute('data-status');
          const dmName = button.getAttribute('data-name');
          const dmAbout = button.getAttribute('data-about');
          const dmImage = button.getAttribute('data-image');

          departmentIdField.value = departmentId;
          dmNameField.value = dmName;
          dmAboutField.value = dmAbout;

          // Convert status to match the select values
          if (dmStatus === 'Active') {
            dmStatusSelect.value = "1";
          } else if (dmStatus === 'Inactive') {
            dmStatusSelect.value = "2";
          } else {
            dmStatusSelect.value = ""; // Default empty value if no match
          }

          // Display the selected image
          if (dmImage && dmImage !== 'null' && dmImage !== '') {
            previewImage.src = `../../assets/uploads/department_image/${dmImage}`;
            editPreviewContainer.classList.remove('d-none');
          } else {
            editPreviewContainer.classList.add('d-none');
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
</body>

</html>