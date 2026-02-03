<?php
session_start();

include '../../connection/dbconnection.php';

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
// Fetch admission requirements
$sql = "SELECT * FROM university_form";
$result = $conn->query($sql);

// Fetch admission requirements
$sql = "SELECT * FROM admission_requirement ";
$result = $conn->query($sql);

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
  <link rel="stylesheet" href="../../assets/bootstrap/css/style.css?v=2.0">
  <link rel="stylesheet" href="../../assets/RemixIcon/fonts/remixicon.css">
</head>

<body class="bg-light">

   <!-- include side bar start -->
   <?php include 'include/alert.php';?>
  <?php include 'confirmation.php';?>
  <?php include 'include/sidebar.php';?>
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
              <h5 class="card-title fs-6 mb-2 mb-md-0">Downloadable Forms</h5>
              <button type="button" class="btn btn-sm rounded-2 px-4 btn-dynamic" data-bs-toggle="modal"
                data-bs-target="#exampleModal" data-bs-toggle="tooltip"
                data-bs-placement="top" title="Click to add a new form">
                <i class="ri-add-line"></i> Add Form
              </button>
            </div>
            <p class="card-text text-muted small">Upload and managed downloadable forms.</p>
            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
              aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h1 class="modal-title fs-5 text-muted fw-bold" id="exampleModalLabel">Add Form</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <form action="../../function/downloadable_formfunction.php" method="POST"
                      enctype="multipart/form-data">
                      <div class="mb-3">
                        <label class="form-label fw-semibold text-muted"><strong>Form Name:</strong></label>
                        <input type="text" name="form_name" class="form-control" placeholder="Enter Form Name" required>
                      </div>

                      <div class="mb-3">
                        <label class="form-label fw-semibold text-muted"><strong>Description:</strong></label>
                        <textarea name="form_description" class="form-control" rows="3" placeholder="Enter Form Description" required></textarea>
                      </div>

                      <div class="mb-3">
                        <label class="form-label fw-semibold text-muted"><strong>Upload Forms:</strong></label>
                        <input type="file" name="form_path" id="formFileInput" class="form-control mt-2"
                          accept=".pdf, .doc, .docx, .xls, .xlsx, .csv, .ppt, .pptx, .txt, .zip, .rar" required>
                        <small class="text-muted">Supports: PDF, DOC, DOCX, XLS, XLSX, CSV, PPT, PPTX, TXT, ZIP,
                          RAR</small>
                      </div>
                      <input type="hidden" name="ap_id" value="1">

                      <div class="modal-footer pb-0">
                        <button type="submit" name="add_form" class="btn btn-dynamic" data-bs-toggle="tooltip"
                          data-bs-placement="top" title="Click to save"><i class="ri-save-fill"></i>
                          Save</button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
            <!-- container nav -->

            <!-- container nav --> <!-- Start viewing form function -->
            <?php
            include '../../connection/dbconnection.php';

            if (!$conn) {
              die("Database connection failed: " . mysqli_connect_error());
            }

            $sql = "SELECT form_id, form_name, form_description, form_path, date_uploaded FROM university_form ORDER BY date_uploaded DESC";
            $result = $conn->query($sql);

            if (!$result) {
              die("Query failed: " . $conn->error);
            }

            ?>
            <div class="dl_forms-container mt-5">
              <div class="row justify-content-center">
                <div class="col-lg-8 col-md-10">
                  <div class="file-grid">
                    <?php
                    $fileIcons = [
                      'pdf' => 'ri-file-pdf-line text-danger',
                      'doc' => 'ri-file-word-line text-primary',
                      'docx' => 'ri-file-word-line text-primary',
                      'xls' => 'ri-file-excel-line text-success',
                      'xlsx' => 'ri-file-excel-line text-success',
                      'csv' => 'ri-file-excel-line text-success',
                      'ppt' => 'ri-file-ppt-line text-warning',
                      'pptx' => 'ri-file-ppt-line text-warning',
                      'txt' => 'ri-file-text-line text-muted',
                      'zip' => 'ri-folder-zip-line text-secondary',
                      'rar' => 'ri-folder-zip-line text-secondary',
                      'default' => 'ri-file-line text-dark'
                    ];

                    if ($result->num_rows > 0) {
                      while ($row = $result->fetch_assoc()) {
                        $form_id = $row['form_id'];
                        $form_name = $row['form_name'];
                        $form_path = $row['form_path'];
                        $form_description = $row['form_description'];
                        $date_uploaded = date("M d Y", strtotime($row['date_uploaded']));

                        // Extract file extension
                        $fileExt = strtolower(pathinfo($form_path, PATHINFO_EXTENSION));
                        $iconClass = $fileIcons[$fileExt] ?? $fileIcons['default'];

                        $correctedFormPath = "../" . $form_path;

                    ?>

                        <div class="container">
                          <div class="row">
                            <div class="col-12 col-md-3 col-lg-3 mb-4">
                              <div class="file-card" style="width: 300px;">
                                <div class="file-info d-flex align-items-center gap-2">
                                  <a href="<?php echo $correctedFormPath; ?>" download class="text-decoration-none text-dark d-flex align-items-center gap-2" data-bs-toggle="tooltip" data-bs-placement="top" title="Click here to download the form">
                                    <span class="file-icon"><i class="<?php echo $iconClass; ?>"></i></span>
                                    <div>
                                      <strong><?php echo htmlspecialchars($form_name); ?></strong><br>
                                      <small><?php echo $date_uploaded; ?></small>
                                    </div>
                                  </a>
                                </div>

                                <div class="dropdown">
                                  <button class="btn btn-light btn-sm" type="button" data-bs-toggle="dropdown"
                                    aria-expanded="false" data-bs-toggle="tooltip"
                                    data-bs-placement="top" title="Click here to see the action">
                                    <i class="ri-more-2-fill"></i>
                                  </button>
                                  <ul class="dropdown-menu dropdown-menu-end" style="width: 100px;"> <!-- Decreased width -->
                                    <li>
                                      <a href="#viewModal<?= $form_id ?>" class="dropdown-item text-dark" data-bs-toggle="modal" title="View form description">
                                      <i class="ri-eye-line"></i> View
                                      </a>
                                    </li>
                                    <li>
                                      <a href="#editModal<?php echo $row['form_id']; ?>"
                                        class="dropdown-item text-dark text-decoration-none"
                                        data-bs-toggle="modal" data-bs-toggle="tooltip"
                                        data-bs-placement="top" title="Click here to edit this form">
                                        <i class="ri-pencil-line"></i> Edit
                                      </a>
                                    </li>
                                    <li>
                                      <a class="dropdown-item text-dark text-decoration-none" href="javascript:void(0);"
                                        data-id="<?= $row['form_id'] ?>"
                                        data-name="<?= htmlspecialchars($row['form_name'], ENT_QUOTES, 'UTF-8') ?>"
                                        onclick="return openModal(event, this.dataset.id, this.dataset.name);" data-bs-toggle="tooltip"
                                        data-bs-placement="top" title="Click here to delete this form">
                                        <i class="ri-delete-bin-line"></i> Delete
                                      </a>
                                    </li>
                                  </ul>
                                </div>

                              </div>
                            </div>
                          </div>
                        </div>

                        <!-- View Modal -->
                        <div class="modal fade" id="viewModal<?= $form_id ?>" tabindex="-1" aria-labelledby="viewModalLabel<?= $form_id ?>" aria-hidden="true">
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="viewModalLabel<?= $form_id ?>">Form Description</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                              </div>
                              <div class="modal-body">
                                <p><?= nl2br(htmlspecialchars($form_description)) ?></p>
                              </div>
                            </div>
                          </div>
                        </div>
                        <!-- End View Modal -->

                        <!-- EDIT ADMISSION START-->
                        <div class="modal fade" id="editModal<?php echo $row['form_id']; ?>" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                          <div class="modal-dialog modal-xl">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title fw-bold">Update Form</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                              </div>
                              <div class="modal-body">
                                <form method="POST" action="../../function/downloadable_formfunction.php">
                                  <input type="hidden" name="form_id" value="<?php echo $row['form_id']; ?>">

                                  <div class="mb-3">
                                    <label for="form_name" class="form-label"><strong>File Name</strong></label>
                                    <input type="text" class="form-control"
                                      name="form_name"
                                      value="<?php echo ($row['form_name']); ?>"
                                      required>
                                  </div>

                                  <div class="mb-3">
                                    <label for="description" class="form-label"><strong>Form Description</strong></label>
                                    <textarea class="form-control"
                                      name="form_description"
                                      rows="3"
                                      required><?php echo ($row['form_description']); ?></textarea>
                                  </div>

                                  <div class="modal-footer pb-0">
                                    <button type="submit" name="update_form" class="btn btn-dynamic" data-bs-toggle="tooltip"
                                      data-bs-placement="top" title="Click to save"><i class="ri-save-line"></i>Save</button>
                                  </div>
                                </form>
                              </div>
                            </div>
                          </div>
                        </div>
                        <!-- EDIT ADMISSION END-->
                    <?php
                      }
                    } else {
                      echo "<p class='text-center'>No forms available.</p>";
                    }
                    ?>
                  </div>
                </div>
              </div>
            </div>
            <!-- End Viewing Form Function -->
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
  <!-- <script src="../../assets/bootstrap/js/page_poster.js"></script> -->
  <!-- <script src="../../assets/bootstrap/js/drag_and_drop.js?=1.1"></script> -->
  <script src="../../assets/bootstrap/js/activeLink.js?v=1.0"></script>
  <script src="../../assets/bootstrap/js/confirmation.js"></script>
  <script src="../../assets/bootstrap/js/site_settings.js"></script>
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
      window.openModal = function(event, form_id, form_name) {
        event.preventDefault();
        document.getElementById("modalFormId").value = form_id;
        document.getElementById("FormNamePlaceholder").textContent = form_name;
        document.getElementById("deleteConfirmationModal-Form").style.display = "flex";
      };

      window.closeModal = function() {
        document.getElementById("deleteConfirmationModal-Form").style.display = "none";
      };

      window.closeModalOutside = function(event) {
        if (event.target.id === "deleteConfirmationModal-Form") {
          closeModal();
        }
      };
    });
  </script>


</body>

</html>