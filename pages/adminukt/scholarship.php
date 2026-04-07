<?php
include 'include/session.php';

// Fetch  scholarship
$sql = "SELECT * FROM university_scholarship";
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
  <link rel="stylesheet" href="../../assets/bootstrap/css/style.css">
  <link rel="stylesheet" href="../../assets/RemixIcon/fonts/remixicon.css">

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
</head>

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
              <h5 class="card-title fs-6 mb-2 mb-md-0">Manage Scholarship</h5>
              <button type="button" class="btn btn-sm rounded-2 px-4 btn-dynamic" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-toggle="tooltip"
                data-bs-placement="top" title="Click to add a new scholarship"><i class="ri-add-line"></i> Add Scholarship
              </button>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-xl">
                <div class="modal-content">
                  <div class="modal-header">
                    <h1 class="modal-title fs-5 text-muted fw-bold" id="exampleModalLabel">Add Scholarship</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <form action="../../function/scholarship_function.php" method="POST" enctype="multipart/form-data">
                      <div class="container-fluid">
                        <div class="row">
                          <div class="mb-3 col-12 col-sm-6">
                            <label for="date_added" class="form-label fw-semibold text-muted"><strong>Date:</strong></label>
                            <input type="date" class="form-control" id="date_added" name="date_added" value="<?php echo date('Y-m-d'); ?>" required>
                          </div>

                          <div class="mb-3 col-12 col-sm-6">
                            <label for="status" class="form-label fw-semibold text-muted"><strong>Status:</strong></label>
                            <select class="form-control" id="status" name="status">
                              <option value="Active">Active</option>
                              <option value="Inactive">Inactive</option>
                            </select>
                          </div>

                          <div class="mb-3 col-12">
                            <label for="scholarship_title" class="form-label fw-semibold text-muted"><strong>Scholarship Title:</strong></label>
                            <input type="text" class="form-control" id="scholarship_title" name="scholarship_title" placeholder="Enter Scholarship Title" required>
                          </div>

                          <div class="mb-3 col-12">
                            <label for="description" class="form-label fw-semibold text-muted">
                              <strong>Description:</strong>
                            </label>
                            <textarea class="form-control" id="summernote" name="description"
                              rows="3" placeholder="Enter description" required></textarea>
                          </div>

                          <div class="mb-3 col-12">
                            <label for="image" class="form-label d-flex align-items-center" title="JPEG or PNG only!!">
                              <span class="fw-bold">Upload Image</span>
                              <svg xmlns="http://www.w3.org/2000/svg" class="ms-2" style="cursor:pointer;" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                  d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" />
                              </svg>
                            </label>
                            <input type="file" class="form-control" name="image" accept="image/*" id="image">
                          </div>

                          <div class="col-6 text-start">
                            <button type="submit" name="add_scholarship" class="btn btn-dynamic" data-bs-toggle="tooltip"
                              data-bs-placement="top" value="adminukt" title="Click to save"><i class="ri-save-line"></i> Save
                            </button>
                          </div>

                        </div>
                      </div>

                    </form>
                  </div>
                </div>
              </div>
            </div>
            <!-- container nav -->

            <!-- VIEWING SCHOLARSHIP START-->
            <div class="log_container">

              <?php
              $query = "SELECT scholarship_id, scholarship_title, date_added, `status`, `description`, `image` FROM university_scholarship ORDER BY date_added DESC";
              $result = mysqli_query($conn, $query);
              ?>

              <!-- Select Dropdown -->
              <div class="mb-3">
                <label for="scholarshipSelect" class="form-label fw-bold">Select Scholarship</label>
                <select class="form-select" id="scholarshipSelect" style="width: 500px;">

                  <?php
                  $first = true;
                  while ($row = $result->fetch_assoc()):
                    $tabId = 'scholarship' . $row['scholarship_id'];
                  ?>
                    <option value="<?= $tabId ?>" <?= $first ? 'selected' : '' ?>>
                      <?= htmlspecialchars($row['scholarship_title']) ?>
                    </option>
                  <?php
                    $first = false;
                  endwhile;
                  ?>
                </select>
              </div>

              <!-- Tab Content -->
              <div id="scholarshipTabContent">
                <?php
                mysqli_data_seek($result, 0);
                $first = true;
                while ($row = $result->fetch_assoc()):
                  $tabId = 'scholarship' . $row['scholarship_id'];
                ?>
                  <div class="scholarship-pane" id="<?= $tabId ?>" style="<?= $first ? '' : 'display:none;' ?>">
                    <div class="d-flex justify-content-between align-items-start">
                      <div>
                        <h5><?= htmlspecialchars($row['scholarship_title']) ?></h5>
                        <p class="mb-0"><strong>Date Added:</strong> <?= date('F d, Y', strtotime($row['date_added'])) ?></p>
                        <p><strong>Status:</strong>
                          <?php if ($row['status'] == 'Active'): ?>
                            <span class="badge bg-success">Active</span>
                          <?php elseif ($row['status'] == 'Inactive'): ?>
                            <span class="badge bg-danger">Inactive</span>
                          <?php else: ?>
                            <span class="badge bg-secondary">Unknown</span>
                          <?php endif; ?>
                        </p>
                      </div>

                      <!-- Dropdown Actions -->
                      <div class="dropdown">
                        <button class="btn btn-light btn-sm" type="button" data-bs-toggle="dropdown" title="Click here to see the action">
                          <i class="ri-more-2-fill"></i>
                        </button>
                        <ul class="dropdown-menu">
                          <li>
                            <a href="#editModal<?= $row['scholarship_id'] ?>" class="dropdown-item text-dark" data-bs-toggle="modal" data-bs-toggle="tooltip"
                              data-bs-placement="top" title="Click here to edit this scholarship">
                              <i class="ri-pencil-line"></i> Edit
                            </a>
                          </li>
                          <li>
                            <a class="dropdown-item text-dark delete-scholarship"
                              href="../../function/scholarship_function.php?scholarship_id=<?= $row['scholarship_id'] ?>&loc=adminukt"
                              onclick="return confirm('Are you sure you want to delete this scholarship?')" data-bs-toggle="tooltip"
                              data-bs-placement="top" title="Click here to delete this scholarship">
                              <i class="ri-delete-bin-line"></i> Delete
                            </a>
                          </li>
                        </ul>
                      </div>
                    </div>

                    <p><strong>Description:</strong><?= $row['description'] ?></p>
                    <div>
                      <img src="../../assets/uploads/student/scholarship/<?= $row['image'] ?>" alt="Img" style="max-width:500px;">
                    </div>

                    <!-- Edit Modal -->
                    <div class="modal fade" id="editModal<?= $row['scholarship_id']; ?>" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                      <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title fw-bold">Update Scholarship</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body">

                            <form method="POST" action="../../function/scholarship_function.php" enctype="multipart/form-data">
                              <input type="hidden" name="scholarship_id" value="<?= $row['scholarship_id']; ?>">
                              <div class="mb-3">
                                <label for="date_added" class="form-label"><strong>Date</strong></label>
                                <input type="date" class="form-control" name="date_added"
                                  value="<?= htmlspecialchars($row['date_added']); ?>" required>
                              </div>

                              <div class="mb-3">
                                <label for="status" class="form-label"><strong>Status</strong></label>
                                <select class="form-select" name="status" required>
                                  <option value="Active" <?= $row['status'] == 'Active' ? 'selected' : '' ?>>Active</option>
                                  <option value="Inactive" <?= $row['status'] == 'Inactive' ? 'selected' : '' ?>>Inactive</option>
                                </select>
                              </div>

                              <div class="mb-3">
                                <label for="scholarship_title" class="form-label"><strong>Scholarship Title</strong></label>
                                <input type="text" class="form-control" name="scholarship_title"
                                  value="<?= htmlspecialchars($row['scholarship_title']); ?>" required>
                              </div>

                              <div class="mb-3">
                                <label for="description" class="form-label"><strong>Description</strong></label>
                                <textarea class="form-control summernote1" name="description" rows="3" required><?= htmlspecialchars($row['description']); ?></textarea>
                              </div>

                              <!-- Image Upload -->
                              <div class="mb-3">
                                <label for="scholarship_image" class="form-label"><strong>Image</strong></label>
                                <?php if (!empty($row['image'])): ?>
                                  <div class="mb-2">
                                    <img src="../../assets/uploads/student/scholarship/<?= htmlspecialchars($row['image']); ?>" alt="Scholarship Image" style="max-width:150px;">
                                  </div>
                                <?php endif; ?>
                                <input type="file" class="form-control" name="scholarship_image" accept="image/*">
                                <small class="text-muted">Leave blank if you don't want to change the image.</small>
                              </div>

                              <div class="modal-footer pb-0">
                                <button type="submit" name="update_scholarship" class="btn btn-dynamic" value="adminukt" data-bs-toggle="tooltip"
                                  data-bs-placement="top" title="Click to save"><i class="ri-save-line"></i> Save
                                </button>
                              </div>

                            </form>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                <?php
                  $first = false;
                endwhile;
                ?>
              </div>

              <?php mysqli_close($conn); ?>
            </div>

          </div>
        </div>
        <?php include 'include/footer.php'; ?>
      </div>
    </div>
  </main>

  <!-- start js -->
  <script>
    $('#summernote').summernote({
      placeholder: 'Please Enter Description',
      tabsize: 2,
      height: 120,
      toolbar: [
        ['style', ['style']],
        ['font', ['bold', 'italic', 'underline', 'strikethrough']],
        ['para', ['ol', 'ul']],
        ['insert', ['link']],
        ['view', ['fullscreen', 'codeview']]
      ]
    });

    $(document).ready(function() {
      $('.summernote1').summernote({
        placeholder: 'Please Enter Description',
        tabsize: 2,
        height: 120,
        toolbar: [
          ['style', ['style']],
          ['font', ['bold', 'italic', 'underline', 'strikethrough']],
          ['para', ['ol', 'ul']],
          ['insert', ['link']],
          ['view', ['fullscreen', 'codeview']]
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

  <!-- JS to switch views -->
  <script>
    document.getElementById('scholarshipSelect').addEventListener('change', function() {
      const selected = this.value;
      document.querySelectorAll('.scholarship-pane').forEach(pane => {
        pane.style.display = (pane.id === selected) ? 'block' : 'none';
      });
    });
  </script>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const tabButtons = document.querySelectorAll('#scholarshipTabs .nav-link');

      tabButtons.forEach(btn => {
        btn.addEventListener('shown.bs.tab', function() {
          tabButtons.forEach(b => {
            b.classList.remove('text-success');
            b.classList.add('text-dark');
          });
          this.classList.remove('text-dark');
          this.classList.add('text-success');
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