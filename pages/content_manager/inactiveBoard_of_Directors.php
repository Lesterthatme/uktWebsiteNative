<?php
require '../../connection/dbconnection.php';
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
  <title><?php echo htmlspecialchars($settings['websitetitle_cm']); ?></title> 
  <link rel="stylesheet" href="../../assets/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="../../assets/bootstrap/css/style.css?=v1.8">
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
            <div class="doc-tabs-container mt-3">
              <ul class="doc-tabs d-flex list-unstyled">
                <li class="me-3">
                  <a class="doc-link" href="Board_of_Directors">Active</a>
                </li>
                <li class="me-3">
                  <a class="doc-link active" href="inactiveBoard_of_Directors">Inactive</a>
                </li>

              </ul>
              <hr class="doc-tabs-divider">
            </div>
            <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
              <h5 class="card-title fs-6 mb-2 mb-md-0">Manage Board of Director</h5>
              <button type="button" class="btn btn-sm rounded-2 px-4 btn-dynamic" data-bs-toggle="modal"
                data-bs-target="#exampleModal" data-bs-toggle="tooltip" data-bs-placement="top"
                title="Click to add a new board of director">
                <i class="ri-add-line"></i> Add Board of Director
              </button>
            </div>

            <p class="card-text text-muted small">
              Add, edit, and manage Board of Directors information
            </p>

            <!-- Modal for adding board of directors start-->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
              aria-hidden="true">
              <div class="modal-dialog modal-lg">
                <div class="modal-content">
                  <div class="modal-header">
                    <h1 class="modal-title fs-5 text-muted fw-bold" id="exampleModalLabel">Add Board of Director</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body pb-0">
                    <form action="../../function/content_manager/boardofdirector_function.php" method="POST"
                      enctype="multipart/form-data">
                      <div class="mb-3">
                        <label class="form-label fw-semibold text-muted">Upload Image:</label>
                        <div class="upload-area" id="uploadArea">
                          <img src="https://cdn-icons-png.flaticon.com/512/126/126477.png" alt="Upload Icon">
                          <p class="mb-0">Drag & Drop <br><span class="text-success">or browse</span></p>
                          <small class="text-muted">Supports: JPEG, JPG, PNG</small>
                          <input type="file" id="fileInput" name="image" class="d-none"
                            accept="image/jpeg, image/jpg, image/png">
                        </div>
                        <div id="previewContainer" class="preview-container d-none">
                          <button type="button" class="delete-btn" id="deleteBtn">&times;</button>
                          <img id="previewImage" class="preview-img" alt="Preview Image">
                        </div>
                      </div>

                      <div class="row mb-3">
                        <div class="col-md-4">
                          <label for="date" class="form-label fw-semibold text-muted">Date Appointed:</label>
                          <input type="date" id="date_appointed" name="date_appointed" class="form-control" required>
                        </div>
                        <!-- <div class="col-md-6">
                          <label for="status" class="form-label fw-semibold text-muted">Status:</label>
                          <select id="status" name="status" class="form-control" required>
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                          </select>
                        </div> -->
                      </div>

                      <div class="row mb-3">
                        <div class="col-md-4">
                          <label for="first-name" class="form-label fw-semibold text-muted">First Name:</label>
                          <input type="text" id="first-name" name="first_name" class="form-control"
                            placeholder="Enter First Name" required>
                        </div>
                        <div class="col-md-4">
                          <label for="middle-name" class="form-label fw-semibold text-muted">Middle Name:</label>
                          <input type="text" id="middle-name" name="middle_name" class="form-control"
                            placeholder="Enter Middle Name">
                        </div>
                        <div class="col-md-4">
                          <label for="last-name" class="form-label fw-semibold text-muted">Last Name:</label>
                          <input type="text" id="last-name" name="last_name" class="form-control"
                            placeholder="Enter Last Name" required>
                        </div>
                      </div>
                      <div class="modal-footer">
                        <button type="submit" name="add_director" class="btn btn-dynamic float-end"
                          data-bs-toggle="tooltip" data-bs-placement="top" title="Click to save"><i class="ri-save-fill"></i>
                          Save</button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
            <!-- Modal for adding board of directors end-->

            <!-- container nav -->

            <?php
            // Include database connection
            include '../../connection/dbconnection.php';

            // Fetch board of directors data
            $sql = "SELECT * FROM board_of_director WHERE status = 'Inactive'";
            $result = $conn->query($sql);
            ?>

            <div class="p-4 d-flex flex-wrap justify-content-center gap-4">
              <?php
              if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
              ?>
                  <div class="management_card">
                    <div class="dropdown three-dots">
                      <button class="btn p-0 border-0" type="button" data-bs-toggle="dropdown" aria-expanded="false"
                        data-bs-toggle="tooltip" data-bs-placement="top" title="Click here to see the action">
                        <span></span><span></span><span></span>
                      </button>
                      <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                          <a class="dropdown-item edit-btn text-dark" href="#" data-bs-toggle="modal" data-bs-target="#editModal"
                            data-id="<?php echo $row['director_id']; ?>"
                            data-firstname="<?php echo htmlspecialchars($row['first_name']); ?>"
                            data-middlename="<?php echo htmlspecialchars($row['middle_name']); ?>"
                            data-lastname="<?php echo htmlspecialchars($row['last_name']); ?>"
                            data-status="<?php echo $row['status']; ?>"
                            data-appointed="<?php echo $row['date_appointed']; ?>"
                            data-image="<?php echo $row['image']; ?>"
                            data-bs-toggle="tooltip" data-bs-placement="top"
                            title="Click to edit the details of this board of director">
                            <i class="ri-pencil-line"></i> Edit
                          </a>
                        </li>
                        <li>
                          <a class="dropdown-item text-dark text-decoration-none" href="javascript:void(0);"
                            onclick="openDeleteModal(<?= $row['director_id']; ?>, '<?= addslashes($row['first_name'] . ' ' . $row['middle_name'] . ' ' . $row['last_name']); ?>')"
                            data-bs-toggle="tooltip" data-bs-placement="top"
                            title="Click to delete the details of this board of director">
                            <i class="ri-delete-bin-line"></i> Delete
                          </a>
                        </li>
                      </ul>
                    </div>

                    <img
                      src="<?php echo !empty($row['image']) ? '../../assets/uploads/board_of_directors_image/' . $row['image'] : '../../assets/images/default.jpg'; ?>"
                      alt="Profile Image" class="officials_image">
                    <div class="official_name">
                      <?php echo htmlspecialchars($row['first_name'] . ' ' . $row['middle_name'] . ' ' . $row['last_name']); ?>
                    </div>
                    <div class="management-status-inactive <?php echo ($row['status'] == 'Inactive') ? 'management-status-inactive' : ''; ?>">
                      <?php echo htmlspecialchars($row['status']); ?>
                    </div>
                    <p class="position_description text-center">
                      Appointed on: <?php echo date("F j, Y", strtotime($row['date_appointed'])); ?>
                    </p>
                  </div>
              <?php
                }
              } else {
                echo '<p class="text-center">No directors found.</p>';
              }
              ?>
            </div>

            <!-- container nav -->

            <!-- edit modal start -->
            <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-lg">
                <div class="modal-content">
                  <div class="modal-header">
                    <h1 class="modal-title fs-5 text-muted fw-bold" id="exampleModalLabel">Edit Board of Director</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body pb-0">
                    <form action="../../function/content_manager/boardofdirector_function.php" method="POST"
                      enctype="multipart/form-data">
                      <input type="hidden" name="director_id" id="editDirectorId">

                      <div class="mb-3 text-center">
                        <img id="editPreviewImage" class="officials_image mt-2 rounded-circle d-block mx-auto" src=""
                          width="100" height="100" alt="Current Image">
                        <label class="form-label fw-semibold text-muted">Upload Image:</label>
                        <input type="file" name="image" id="editFileInput" class="form-control"
                          accept="image/jpeg, image/jpg, image/png">
                      </div>

                      <div class="row mb-3">
                        <div class="col-md-4">
                          <label class="form-label fw-semibold text-muted">First Name:</label>
                          <input type="text" name="first_name" id="editFirstName" class="form-control"
                            placeholder="Enter Firstname">
                        </div>
                        <div class="col-md-4">
                          <label class="form-label fw-semibold text-muted">Middle Name:</label>
                          <input type="text" name="middle_name" id="editMiddleName" class="form-control"
                            placeholder="Enter Middle Name">
                        </div>
                        <div class="col-md-4">
                          <label class="form-label fw-semibold text-muted">Last Name:</label>
                          <input type="text" name="last_name" id="editLastName" class="form-control"
                            placeholder="Enter Last Name">
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-md-6 mb-3">
                          <label class="form-label fw-semibold text-muted">Date Appointed:</label>
                          <input type="date" name="date_appointed" id="editDateAppointed" class="form-control">
                        </div>

                        <div class="col-md-6 mb-3">
                          <label class="form-label fw-semibold text-muted">Status:</label>
                          <select name="status" id="editStatus" class="form-select">
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                          </select>
                        </div>
                      </div>


                      <div class="modal-footer ">
                        <button type="submit" name="update_director" class="btn btn-dynamic" data-bs-toggle="tooltip" data-bs-placement="top"
                          title="Click to save"><i
                            class="ri-save-fill"></i> Save</button>
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
  <script src="../../assets/bootstrap/js/carousel.js"></script>
  <script src="../../assets/bootstrap/js/drag_and_drop.js?=1.1"></script>
  <script src="../../assets/bootstrap/js/activeLink.js?v=1.1"></script>
  <script src="../../assets/bootstrap/js/table.js"></script>
  <script src="../../assets/bootstrap/js/view_newsmodal.js"></script>
<script src="../../assets/bootstrap/js/site_settings.js?v=<?= time(); ?>"></script>
  <!-- end js -->

  <script>
    document.addEventListener("DOMContentLoaded", function() {
      const editButtons = document.querySelectorAll(".edit-btn");

      editButtons.forEach(button => {
        button.addEventListener("click", function() {
          document.getElementById("editDirectorId").value = this.getAttribute("data-id");
          document.getElementById("editFirstName").value = this.getAttribute("data-firstname");
          document.getElementById("editMiddleName").value = this.getAttribute("data-middlename");
          document.getElementById("editLastName").value = this.getAttribute("data-lastname");
          document.getElementById("editDateAppointed").value = this.getAttribute("data-appointed");
          document.getElementById("editStatus").value = this.getAttribute("data-status");

          // Handle Image Preview
          const imageSrc = this.getAttribute("data-image");
          if (imageSrc) {
            document.getElementById("editPreviewImage").src = "../../assets/uploads/board_of_directors_image/" + imageSrc;
          } else {
            document.getElementById("editPreviewImage").src = "../../assets/images/default.jpg";
          }
        });
      });
    });

    document.getElementById('editFileInput').addEventListener('change', function(event) {
      const file = event.target.files[0];
      if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
          document.getElementById('editPreviewImage').src = e.target.result;
        };
        reader.readAsDataURL(file);
      }
    });
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
      window.openDeleteModal = function(director_id, director_name) {
        document.getElementById("modalDirectorId").value = director_id;
        document.getElementById("directorNamePlaceholder").textContent = director_name;
        document.getElementById("deleteConfirmationModal-director").style.display = "flex";
      };

      window.closeModal = function() {
        document.getElementById("deleteConfirmationModal-director").style.display = "none";
      };

      window.closeModalOutside = function(event) {
        if (event.target.id === "deleteConfirmationModal-director") {
          closeModal();
        }
      };
    });
  </script>

</body>

</html>