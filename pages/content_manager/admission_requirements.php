<?php
session_start();
include '../../function/partnership_function.php';
include("../../connection/dbconnection.php");

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
  <title><?php echo htmlspecialchars($settings['websitetitle_cm']); ?></title>
  <!-- start css  -->
  <link rel="stylesheet" href="../../assets/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="../../assets/bootstrap/css/style.css">
  <!-- end css -->
  <!-- Remix icon -->
  <link rel="stylesheet" href="../../assets/RemixIcon/fonts/remixicon.css">

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
</head>

</head>

<body class="bg-light">

  <!-- include side bar start -->
  <?php include 'include/alert.php';?>
  <?php include 'confirmation.php';?>
  <?php include 'include/sidebar.php';?>
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
              <h5 class="card-title fs-6 mb-2 mb-md-0">Admission Requirements</h5>
              <button type="button" class="btn btn-sm rounded-2 px-4 btn-dynamic" data-bs-toggle="modal" data-bs-target="#exampleModal"
              data-bs-toggle="tooltip" data-bs-placement="top" title="Click to add admission requirement">
                <i class="ri-add-line"></i> Add Requirements
              </button>
            </div>
            <p class="card-text text-muted small">Learn about our collaborations with institutions and industries that strengthen research, education and innovation.</p>
            <!-- Modal FOR ADDING START-->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-xl">
                <div class="modal-content">
                  <div class="modal-header">
                    <h1 class="modal-title fs-5 text-muted fw-bold" id="exampleModalLabel">Add Admission Requirements</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <form action="../../function/content_manager/admission_requirementfunction.php" method="POST">
                      <div class="mb-3">
                        <label for="date_added" class="form-label fw-semibold text-muted"><strong>Date:</strong></label>
                        <input type="date" class="form-control" id="date_added" name="date_added" value="<?php echo date('Y-m-d'); ?>" style="width: 150px;" required>
                      </div>
                      <!-- <div class="mb-3">
                        <label for="status" class="form-label fw-semibold text-muted"><strong>Status:</strong></label>
                        <select class="form-control" id="status" name="status" style="width: 150px;">
                          <option value="Active">Active</option>
                          <option value="Inactive">Inactive</option>
                        </select>
                      </div> -->
                      <div class="mb-3">
                        <label for="requirement_title" class="form-label fw-semibold text-muted"><strong>Requirements Title:</strong></label>
                        <input type="text" class="form-control" id="requirement_title" name="requirement_title" placeholder="Enter Requirements Title" required>
                      </div>
                      <div class="mb-3">
                        <label for="description" class="form-label fw-semibold text-muted"><strong>Description:</strong></label>
                        <textarea class="form-control" id="summernote" name="description" rows="3" placeholder="Enter description" required></textarea>
                        <div id="summernote"></div>
                        <script>
                          $('#summernote').summernote({
                            placeholder: 'Please Enter Description',
                            tabsize: 2,
                            height: 120,
                            toolbar: [
                              ['style', ['style']],
                              ['font', ['bold', 'italic', 'underline', 'strikethrough', 'superscript', 'subscript', 'clear']],
                              ['fontname', ['fontname']],
                              ['fontsize', ['fontsize']],
                              ['color', ['color']],
                              ['para', ['ol', 'ul', 'paragraph', 'height']],
                              ['insert', ['link']],
                              ['view', ['undo', 'redo', 'fullscreen', 'codeview', 'help']]
                            ]
                          });
                        </script>
                      </div>

                      <button type="submit" name="add_requirement" class="btn btn-dynamic float-end"
                      data-bs-toggle="tooltip" data-bs-placement="top" title="Click to save"><i class="ri-save-line"></i> Save </button>
                    </form>
                  </div>
                </div>
              </div>
            </div>
            <!-- MODAL FOR ADDING END -->

            <!-- VIEWING ADMISSION START-->
            <div class="log_container ">
              <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-3">
                <div class="d-flex align-items-center mb-md-0">
                  <label class="me-2">Show</label>
                  <select id="entriesSelect" class="form-select custom-dropdown">
                    <option value="5">5</option>
                    <option value="10" selected>10</option>
                    <option value="15">15</option>
                    <option value="20">20</option>
                  </select>
                  <label class="ms-2 me-3">entries</label>
                </div>
                <div class="search-container me-2">
                  <i class="ri-search-line"></i>
                  <input type="text" id="searchBar" class="form-control" placeholder="Search">
                </div>
                <div class="d-flex align-items-center ms-md-auto mt-1">

                  <select id="sortBy" class="form-select">
                    <option value="">Sort By</option>
                    <option value="date">Sort by Date</option>
                    <option value="time">Sort by Time</option>
                  </select>
                </div>
              </div>

              <?php
              include("../../connection/dbconnection.php");

              // Fetch admission requirements
              $query = "SELECT requirement_id, requirement_title, date_added, status, description FROM admission_requirement ORDER BY date_added DESC";
              $result = mysqli_query($conn, $query);
              ?>

              <div class="table-container">
                <table class="table table-hover" id="activityTable">
                  <thead>
                    <tr>
                      <th class="text-center">Date</th>
                      <th class="text-center">Requirement Title</th>
                      <th class="text-center">Status</th>
                      <th class="text-center">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php if ($result->num_rows > 0): ?>
                      <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                          <td class="text-center"><?= date('F d, Y', strtotime($row['date_added'])) ?></td>
                          <td class="text-center"><?= $row['requirement_title'] ?></td>
                          <td class="text-center">
                            <?php
                            if ($row['status'] === 'Active') {
                              echo '<span class="badge bg-success">Active</span>';
                            } elseif ($row['status'] === 'Inactive') {
                              echo '<span class="badge bg-danger">Inactive</span>';
                            } else {
                              echo '<span class="badge bg-secondary">Unknown</span>';
                            }
                            ?>
                          </td>
                          <td class="text-center">
                            <div class="dropdown">
                              <button class="btn btn-light btn-sm" type="button" data-bs-toggle="dropdown"  data-bs-toggle="tooltip" 
                              data-bs-placement="top" title="Click here to see the action">
                                <i class="ri-more-2-fill"></i>
                              </button>
                              <ul class="dropdown-menu">
                                <li>
                                  <a class="dropdown-item text-dark view-requirement" href="#"
                                    data-bs-toggle="modal"
                                    data-bs-target="#viewModal<?= $row['requirement_id'] ?>"  data-bs-toggle="tooltip" 
                                    data-bs-placement="top" title="Click to view details">
                                    <i class="ri-eye-line"></i> View 
                                  </a>
                                </li>
                                <li>
                                  <a href="#editModal<?php echo $row['requirement_id']; ?>"
                                    class="dropdown-item text-dark"
                                    data-bs-toggle="modal"  data-bs-toggle="tooltip" 
                                    data-bs-placement="top" title="Click to edit this admission requirements">
                                    <i class="ri-pencil-line"></i> Edit
                                  </a>
                                </li>
                                <li>
                                  <a class="dropdown-item text-dark delete-requirement"
                                    href="../../function/content_manager/admission_requirementfunction.php?requirement_id=<?= $row['requirement_id'] ?>"
                                    onclick="return confirm('Are you sure you want to delete this requirement?')" data-bs-toggle="tooltip" 
                                    data-bs-placement="top" title="Click delete this admission requirements">
                                    <i class="ri-delete-bin-line"></i> Delete
                                  </a>
                                </li>
                              </ul>
                            </div>
                          </td>
                        </tr>

                        <!-- EDIT ADMISSION START-->
                        <div class="modal fade" id="editModal<?php echo $row['requirement_id']; ?>" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                          <div class="modal-dialog modal-xl">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title fw-bold">Update Requirement</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                              </div>
                              <div class="modal-body">
                                <form method="POST" action="../../function/content_manager/admission_requirementfunction.php">
                                  <input type="hidden" name="requirement_id" value="<?php echo $row['requirement_id']; ?>">
                                  <div class="mb-3">
                                    <label for="date_added" class="form-label"><strong>Date</strong></label>
                                    <input type="date" class="form-control" style="width: 150px;"
                                      name="date_added"
                                      value="<?php echo htmlspecialchars($row['date_added']); ?>"
                                      required>
                                  </div>
                                  <div class="mb-3">
                                    <label for="status" class="form-label"><strong>Status</strong></label>
                                    <select class="form-select" name="status" style="width: 150px;" required>
                                      <option value="Active" <?php if ($row['status'] == 'Active') echo 'selected'; ?>>Active</option>
                                      <option value="Inactive" <?php if ($row['status'] == 'Inactive') echo 'selected'; ?>>Inactive</option>
                                    </select>
                                  </div>
                                  <div class="mb-3">
                                    <label for="requirement_title" class="form-label"><strong>Requirement Title</strong></label>
                                    <input type="text" class="form-control"
                                      name="requirement_title"
                                      value="<?php echo htmlspecialchars($row['requirement_title']); ?>"
                                      required>
                                  </div>

                                  <div class="mb-3">
                                    <label for="description" class="form-label"><strong>Description</strong></label>
                                    <textarea class="form-control summernote1"
                                      name="description"
                                      rows="3"
                                      required><?php echo htmlspecialchars($row['description']); ?></textarea>
                                  </div>

                                  <div class="modal-footer pb-0">
                                    <button type="submit" name="update_requirement" class="btn btn-dynamic"
                                    data-bs-toggle="tooltip" data-bs-placement="top" title="Click to save"><i class="ri-save-line"></i>Save</button>
                                  </div>
                                </form>
                              </div>
                            </div>
                          </div>
                        </div>
                        <!-- EDIT ADMISSION END-->

                        <!-- VIEWING MODAL start  -->
                        <div class="modal fade" id="viewModal<?= $row['requirement_id'] ?>" tabindex="-1" aria-labelledby="viewModalLabel<?= $row['requirement_id'] ?>" aria-hidden="true">
                          <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title fw-bold text-muted" id="viewModalLabel<?= $row['requirement_id'] ?>">
                                  View Admission Requirements
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                              </div>
                              <div class="modal-body">
                                <form>
                                  <p><strong>Requirement Title:</strong> <?= $row['requirement_title'] ?></p>
                                  <p><strong>Date Added:</strong> <?= date('F d, Y', strtotime($row['date_added'])) ?></p>
                                  <p><strong>Description:</strong> <?= $row['description'] ?></p>

                                </form>
                              </div>
                            </div>
                          </div>
                        </div>
                      <?php endwhile; ?>
                    <?php else: ?>
                      <tr>
                        <td colspan="4" class="text-center">No admission requirements available</td>
                      </tr>
                    <?php endif; ?>
                  </tbody>
                </table>

                <!-- Pagination (if needed) -->
                <div class="d-flex justify-content-center">
                  <ul class="pagination custom-pagination mt-2"></ul>
                </div>
              </div>
              <?php mysqli_close($conn); ?>
              <!-- VIEWING ADMISSION END-->

            </div>
          </div>
        </div>
        <?php include 'include/footer.php'; ?>
      </div>
  </main>

  <!-- start js -->
  <script>
    $(document).ready(function() {
      $('.summernote1').summernote({
        placeholder: 'Enter description here...',
        tabsize: 2,
        height: 150,
        toolbar: [
          ['style', ['style']],
          ['font', ['bold', 'italic', 'underline', 'strikethrough', 'superscript', 'subscript', 'clear']],
          ['fontname', ['fontname']],
          ['fontsize', ['fontsize']],
          ['color', ['color']],
          ['para', ['ol', 'ul', 'paragraph', 'height']],
          ['insert', ['link']],
          ['view', ['undo', 'redo', 'fullscreen', 'codeview', 'help']]
        ]
      });
    });
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="../../assets/bootstrap/js/logs.js?v=1.1"></script>
  <script src="../../assets/bootstrap/js/site_settings.js"></script>
  <script src="../../assets/bootstrap/js/script.js"></script>
  <script src="../../assets/bootstrap/js/carousel2itemslide.js?=v1.7"></script>
  <script src="../../assets/bootstrap/js/drag_and_drop.js?=v1.0"></script>
  <script src="../../assets/bootstrap/js/activeLink.js?=v1.0"></script>

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