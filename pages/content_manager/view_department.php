<?php
require '../../connection/dbconnection.php';
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
  <link rel="stylesheet" href="../../assets/bootstrap/css/style.css?=v1.4">
  <!-- end css -->
  <!-- Remix icon -->
  <link rel="stylesheet" href="../../assets/RemixIcon/fonts/remixicon.css">
</head>

<body class="bg-light">

  <!-- include side bar start -->
  <?php include 'include/alert.php'; ?>
  <?php include 'confirmation.php'; ?>
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
            <div class="doc-tabs-container mt-3">
              <ul class="doc-tabs d-flex list-unstyled">
                <li class="me-3">
                  <a class="doc-link active" href="view_department?department_id=<?= $department['department_id'] ?>">Faculty Member</a>
                </li>
                <li class="me-3">
                  <a class="doc-link" href="manage_program?department_id=<?= $department['department_id'] ?>">Program Offering</a>
                </li>
                <li class="me-3">
                  <a class="doc-link" href="facilities?department_id=<?= $department['department_id'] ?>">Facilities</a>
                </li>
              </ul>
              <hr class="doc-tabs-divider">
            </div>
            <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
              <h5 class="card-title fs-6 mb-2 mb-md-0">View <?php echo htmlspecialchars($department['dm_name']); ?>
                Department</h5>
              <button type="button" class="btn btn-sm rounded-2 px-4 btn-dynamic" data-bs-toggle="modal" data-bs-target="#exampleModal"  data-bs-toggle="tooltip"
              title="Click here to add faculty member"><i class="ri-add-line"></i> Add Faculty Member
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
                    <h1 class="modal-title fs-5 text-muted fw-bold " id="exampleModalLabel">Add Faculty Member</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <!-- START >> FORM For Add Faculty Member -->
                    <form action="view_department.php?department_id=<?php echo $deptId; ?>" method="post"
                      enctype="multipart/form-data">
                      <input type="hidden" name="department_id" value="<?php echo $deptId; ?>">
                      <div class="mb-3">
                        <label class="form-label fw-semibold text-muted">Upload About Image:</label>
                        <div class="upload-area" id="uploadArea">
                          <img src="https://cdn-icons-png.flaticon.com/512/126/126477.png" alt="Upload Icon">
                          <p class="mb-0">Drag & Drop <br><span class="text-success">or browse</span></p>
                          <small class="text-muted">Supports: JPEG, JPG, PNG</small>
                          <input type="file" id="fileInput" name="fm_image" class="d-none"
                            accept="image/jpeg, image/jpg, image/png">
                        </div>
                        <div id="previewContainer" class="preview-container d-none">
                          <button type="button" class="delete-btn" id="deleteBtn">&times;</button>
                          <img id="previewImage" class="preview-img" alt="Preview Image">
                        </div>
                      </div>

                      <div class="mb-3">
                        <label for="message" class="form-label fw-semibold text-muted">Firstname:</label>
                        <input type="text" class="form-control" name="fm_firstname" placeholder="Enter First Name"
                          required>
                      </div>
                      <div class="mb-3">
                        <label for="message" class="form-label fw-semibold text-muted">Middlename:</label>
                        <input type="text" class="form-control" name="fm_mname" placeholder="Enter Middle Name"
                          required>
                      </div>
                      <div class="mb-3">
                        <label for="message" class="form-label fw-semibold text-muted">Lastname:</label>
                        <input type="text" class="form-control" name="fm_lastname" placeholder="Enter Last Name"
                          required>
                      </div>
                      <div class="mb-3">
                        <label for="message" class="form-label fw-semibold text-muted">Position:</label>
                        <input type="text" class="form-control" name="fm_position" placeholder="Enter Position"
                          required>
                      </div>
                      <div class="mb-3">
                        <label for="message" class="form-label fw-semibold text-muted">Email:</label>
                        <input type="email" class="form-control" name="fm_email" placeholder="Enter Email" required>
                      </div>
                      <div class="mb-3">
                        <label for="message" class="form-label fw-semibold text-muted">Contact Number:</label>
                        <input type="number" class="form-control" name="fm_number" placeholder="Enter Contact Number"
                          required>
                      </div>
                  </div>
                  <div class="modal-footer">
                    <button type="submit" class="btn btn-dynamic" name="add_facultymem" data-bs-toggle="tooltip"
                    title="Click here to save"><i class="ri-save-fill"></i>
                      Save</button>
                  </div>
                  </form>
                  <!-- END >> FORM For Add Faculty Member -->
                </div>
              </div>
            </div>
            <!-- Department start -->
            <div class="d-flex flex-wrap justify-content-center gap-4 mt-5">
              <?php
              $facultyQuery = "SELECT * FROM faculty_member WHERE department_id = $deptId";
              $facultyResult = mysqli_query($conn, $facultyQuery);

              if ($facultyResult && mysqli_num_rows($facultyResult) > 0) {
                while ($faculty_member = mysqli_fetch_assoc($facultyResult)) {
              ?>
                  <div class="card faculty_members text-center p-2 shadow-sm" style="width: 250px; border-radius: 10px;">
                    <div class="image-container" style="position: relative;">
                      <div class="text-center">
                        <img
                          src="../../assets/uploads/faculty_member/<?php echo htmlspecialchars($faculty_member['fm_image']); ?>"
                          class="card-img-top mx-auto mt-3" alt="Faculty Photo"
                          style="width: 200px; height: 200px; object-fit: cover;">
                      </div>
                      <span
                        class="announcement-status-<?php echo strtolower($faculty_member['fm_status']) == 'active' ? 'active' : 'inactive'; ?>">
                        <?php echo htmlspecialchars($faculty_member['fm_status']); ?>
                      </span>
                    </div>
                    <div class="card-body">
                      <div class="dropdown three-dots-accord mt-4">
                        <button class="btn p-0 border-0 float-end" type="button" data-bs-toggle="dropdown"
                          aria-expanded="false"  data-bs-toggle="tooltip"
                          title="Click here to see the action">
                          <span></span><span></span><span></span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                          <!-- View modal button -->
                          <a class="dropdown-item text-dark view-profile-btn" href="#"
                            data-bs-toggle="modal" data-bs-target="#viewModal"
                            data-id="<?= $faculty_member['fm_id'] ?>"
                            data-firstname="<?= htmlspecialchars($faculty_member['fm_firstname']) ?>"
                            data-mname="<?= htmlspecialchars($faculty_member['fm_mname']) ?>"
                            data-lastname="<?= htmlspecialchars($faculty_member['fm_lastname']) ?>"
                            data-position="<?= htmlspecialchars($faculty_member['fm_position']) ?>"
                            data-email="<?= htmlspecialchars($faculty_member['fm_email']) ?>"
                            data-number="<?= htmlspecialchars($faculty_member['fm_number']) ?>"
                            data-image="../../assets/uploads/faculty_member/<?= htmlspecialchars($faculty_member['fm_image']) ?>"
                            data-status="<?= htmlspecialchars($faculty_member['fm_status']) ?>" data-bs-toggle="tooltip"
                            title="Click here to view profile">
                            <i class="ri-eye-line"></i> View Profile
                          </a>
                          <!-- View modal button -->
                          <li>
                            <a class="dropdown-item edit-btns text-dark" href="#" data-bs-toggle="modal" data-bs-target="#editModal"
                              data-id="<?= $faculty_member['fm_id'] ?>"
                              data-firstname="<?= htmlspecialchars($faculty_member['fm_firstname']) ?>"
                              data-mname="<?= htmlspecialchars($faculty_member['fm_mname']) ?>"
                              data-lastname="<?= htmlspecialchars($faculty_member['fm_lastname']) ?>"
                              data-position="<?= htmlspecialchars($faculty_member['fm_position']) ?>"
                              data-email="<?= htmlspecialchars($faculty_member['fm_email']) ?>"
                              data-number="<?= htmlspecialchars($faculty_member['fm_number']) ?>"
                              data-image="<?= htmlspecialchars($faculty_member['fm_image']) ?>"
                              data-status="<?= htmlspecialchars($faculty_member['fm_status']) ?>"
                              data-department="<?= htmlspecialchars($faculty_member['department_id']) ?>" data-bs-toggle="tooltip"
                              title="Click here to edit profile">
                              <i class="ri-pencil-line"></i> Edit
                            </a>
                          </li>

                          <li>
                            <a class="dropdown-item text-dark text-decoration-none" href="javascript:void(0);"
                              data-id="<?= $faculty_member['fm_id'] ?>"
                              data-name="<?= $faculty_member['fm_firstname'] . ' ' . $faculty_member['fm_lastname'] ?>"
                              onclick="openDeleteModal(this)" data-bs-toggle="tooltip"
                              title="Click here to delete this faculty member">
                              <i class="ri-delete-bin-line"></i> Delete
                            </a>
                          </li>

                        </ul>
                      </div>
                      <div class="mt-2">
                        <h5 class="card-title ms-4">
                          <?php echo htmlspecialchars($faculty_member['fm_firstname'] . ' ' . $faculty_member['fm_mname'] . ' ' . $faculty_member['fm_lastname']); ?>
                        </h5>
                        <p class="card-text text-muted"><?php echo htmlspecialchars($faculty_member['fm_position']); ?></p>
                      </div>
                    </div>
                  </div>
              <?php
                }
              } else {
                echo "<p class='text-center text-muted'>No faculty members found.</p>";
              }
              ?>
            </div>

            <!-- edit modal start -->
            <?php
            require '../../connection/dbconnection.php';
            $fm_id = isset($_GET['fm_id']) ? $_GET['fm_id'] : '';

            if (!empty($fm_id)) {
              $query = "SELECT * FROM faculty_member WHERE fm_id = ?";
              $stmt = mysqli_prepare($conn, $query);
              mysqli_stmt_bind_param($stmt, "i", $fm_id);
              mysqli_stmt_execute($stmt);
              $result = mysqli_stmt_get_result($stmt);

              if ($row = mysqli_fetch_assoc($result)) {

                $fm_firstname = $row['fm_firstname'];
                $fm_mname = $row['fm_mname'];
                $fm_lastname = $row['fm_lastname'];
                $fm_position = $row['fm_position'];
                $fm_email = $row['fm_email'];
                $fm_number = $row['fm_number'];
                $fm_image = $row['fm_image'];
              } else {
                echo "<p style='color:red;'>No record found!</p>";
              }
            }

            ?>
            <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-lg">
                <div class="modal-content">
                  <div class="modal-header">
                    <h1 class="modal-title fs-5 text-muted fw-bold" id="exampleModalLabel">Edit Poster</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <form action="view_department.php" method="post" enctype="multipart/form-data">
                      <input type="hidden" name="fm_id" value="<?php echo $fm_id; ?>">
                      <input type="hidden" name="department_id" value="<?php echo htmlspecialchars($deptId); ?>">

                      <div class="mb-3">
                        <label class="form-label fw-semibold text-muted">Upload your File:</label>
                        <div class="upload-area" id="editUploadArea">
                          <img src="https://cdn-icons-png.flaticon.com/512/126/126477.png" alt="Upload Icon">
                          <p class="mb-0">Drag & Drop <br><span class="text-success">or browse</span></p>
                          <small class="text-muted">Supports: JPEG, JPG, PNG</small>
                          <input name="fm_image" value="<?php echo $fm_image; ?>" type="file" id="editFileInput"
                            class="d-none" accept="image/jpeg, image/jpg, image/png">
                        </div>
                        <div id="editPreviewContainer" class="preview-container d-none">
                          <button type="button" class="delete-btn" id="editDeleteBtn">&times;</button>
                          <img id="editPreviewImage" class="preview-img" alt="Preview Image">
                        </div>
                        <div class="mb-3">
                          <label for="message" class="form-label fw-semibold text-muted">Firstname:</label>
                          <input type="text" class="form-control" value="<?php echo $fm_firstname; ?>"
                            name="fm_firstname" placeholder="Enter First Name" required>
                        </div>
                        <div class="mb-3">
                          <label for="message" class="form-label fw-semibold text-muted">Middlename:</label>
                          <input type="text" class="form-control" value="<?php echo $fm_mname; ?>" name="fm_mname"
                            placeholder="Enter Middle Name" required>
                        </div>
                        <div class="mb-3">
                          <label for="message" class="form-label fw-semibold text-muted">Lastname:</label>
                          <input type="text" class="form-control" value="<?php echo $fm_lastname; ?>" name="fm_lastname"
                            placeholder="Enter Last Name" required>
                        </div>
                        <div class="mb-3">
                          <label for="message" class="form-label fw-semibold text-muted">Position:</label>
                          <input type="text" class="form-control" value="<?php echo $fm_position; ?>" name="fm_position"
                            placeholder="Enter Position" required>
                        </div>
                        <div class="mb-3">
                          <label for="message" class="form-label fw-semibold text-muted">Email:</label>
                          <input type="email" class="form-control" value="<?php echo $fm_email; ?>" name="fm_email"
                            placeholder="Enter Email" required>
                        </div>
                        <div class="mb-3">
                          <label for="message" class="form-label fw-semibold text-muted">Contact Number:</label>
                          <input type="number" class="form-control" value="<?php echo $fm_number; ?>" name="fm_number"
                            placeholder="Enter Contact Number" required>
                        </div>
                        <div class="mb-3">
                          <label for="form-select" class="form-label fw-semibold text-muted">Status:</label>
                          <label for="form-select" class="form-label fw-semibold text-muted">Status:</label>
                          <select id="editDmStatus" name="fm_status" value="<?php echo $fm_status; ?>"
                            class="form-select">
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                          </select>

                        </div>
                      </div>
                      <div class="modal-footer">
                        <button type="submit" name="update_facultymem" class="btn btn-dynamic" data-bs-toggle="tooltip"
                        title="Click here to save"><i class="ri-save-fill"></i> Save</button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
            <!-- edit modal end -->

            <!-- View Profile Modal start-->
            <div class="modal fade" id="viewModal" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-lg">
                <div class="modal-content">
                  <div class="modal-header">
                    <h1 class="modal-title fs-5 text-muted fw-bold" id="viewModalLabel">Faculty Profile</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <div class="text-center">
                      <img id="facultyImage" class="img-fluid rounded mb-3"
                        src="" alt="Faculty Image" style="width: 150px; height: 150px; object-fit: cover;">
                    </div>
                    <h5 id="facultyName" class="text-center"></h5>
                    <p id="facultyPosition" class="text-center text-muted"></p>
                    <ul class="list-group">
                      <li class="list-group-item"><strong>Email:</strong> <span id="facultyEmail"></span></li>
                      <li class="list-group-item"><strong>Contact Number:</strong> <span id="facultyNumber"></span></li>
                      <li class="list-group-item"><strong>Status:</strong> <span id="facultyStatus"></span></li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
            <!-- View Profile Modal Structure end-->

          </div>
        </div>
  </main>

  <!-- start js -->
  <script src="../../assets/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../../assets/bootstrap/js/jquery-3.7.1.js"></script>
  <script src="../../assets/bootstrap/js/script.js"></script>
  <script src="../../assets/bootstrap/js/page_poster.js"></script>
  <script src="../../assets/bootstrap/js/drag_and_drop.js"></script>
  <script src="../../assets/bootstrap/js/activeLink.js?v=1.4"></script>
  <script src="../../assets/bootstrap/js/table.js"></script>
  <script src="../../assets/bootstrap/js/site_settings.js"></script>
  <!-- end js -->
  <script>
    $(document).ready(function() {
      $('.edit-btns').on('click', function() {
        var id = $(this).data('id');
        var firstname = $(this).data('firstname');
        var mname = $(this).data('mname');
        var lastname = $(this).data('lastname');
        var position = $(this).data('position');
        var email = $(this).data('email');
        var number = $(this).data('number');
        var image = $(this).data('image');
        var departmentId = $(this).data('department');
        var status = $(this).data('status'); // Get the status value

        // Populate the modal form
        $('#editModal input[name="fm_id"]').val(id);
        $('#editModal input[name="fm_firstname"]').val(firstname);
        $('#editModal input[name="fm_mname"]').val(mname);
        $('#editModal input[name="fm_lastname"]').val(lastname);
        $('#editModal input[name="fm_position"]').val(position);
        $('#editModal input[name="fm_email"]').val(email);
        $('#editModal input[name="fm_number"]').val(number);
        $('#editModal input[name="department_id"]').val(departmentId);
        $('#editModal select[name="fm_status"]').val(status); // Set the status dropdown

        // Populate modal fields
        upIdInput.value = upId;
        upNameInput.value = upName;
        upLinkInput.value = upLink;
        upStatusSelect.value = upStatus;

        if (image) {
          $('#editPreviewImage').attr('src', '../../assets/uploads/faculty_member/' + image);
          $('#editPreviewContainer').removeClass('d-none');
        } else {
          $('#editPreviewContainer').addClass('d-none');
        }
      });
    });


    // view profile modal script start here
    document.addEventListener("DOMContentLoaded", function() {
      const viewProfileButtons = document.querySelectorAll(".view-profile-btn");

      viewProfileButtons.forEach(button => {
        button.addEventListener("click", function() {
          document.getElementById("facultyImage").src = this.getAttribute("data-image");
          document.getElementById("facultyName").textContent = this.getAttribute("data-firstname") + " " + this.getAttribute("data-mname") + " " + this.getAttribute("data-lastname");
          document.getElementById("facultyPosition").textContent = this.getAttribute("data-position");
          document.getElementById("facultyEmail").textContent = this.getAttribute("data-email");
          document.getElementById("facultyNumber").textContent = this.getAttribute("data-number");
          document.getElementById("facultyStatus").textContent = this.getAttribute("data-status");
        });
      });
    });
    // view profile modal script start end
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

  <!-- START >> JS SCRIPT DELETE CONFIRMATION -->
  <script>
    document.addEventListener("DOMContentLoaded", function() {
      window.openDeleteModal = function(element) {
        event.preventDefault();
        var fmId = element.getAttribute('data-id');
        var fmName = element.getAttribute('data-name');
        document.getElementById("modalFacultyId").value = fmId;
        document.getElementById("facultyNamePlaceholder").textContent = fmName;
        document.getElementById("deleteConfirmationModal-faculty").style.display = "flex";
      };

      window.closeModal = function() {
        document.getElementById("deleteConfirmationModal-faculty").style.display = "none";
      };

      window.closeModalOutside = function(event) {
        if (event.target.id === "deleteConfirmationModal-faculty") {
          closeModal();
        }
      };
    });
  </script>
  <!-- END >> JS SCRIPT DELETE CONFIRMATION -->
</body>

</html>