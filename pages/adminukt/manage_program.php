<?php
session_start();
include("../../connection/dbconnection.php");

include '../../function/department_function.php';
if (isset($_GET['department_id'])) {
    $department_id = intval($_GET['department_id']);

    // Fetch department name
    $queryDept = "SELECT dm_name FROM department WHERE department_id = $department_id";
    $resultDept = mysqli_query($conn, $queryDept);

    if ($resultDept && $rowDept = mysqli_fetch_assoc($resultDept)) {
        $department_name = $rowDept['dm_name'];
    } else {
        $department_name = "Unknown Department"; // Fallback text
    }
}


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

        <div class="p-4">
            <div class="row">
                <div class="card border-0 pb-3">
                    <div class="card-body">
                        <div class="doc-tabs-container mt-3">
                            <ul class="doc-tabs d-flex list-unstyled">
                                <li class="me-3">
                                    <a class="doc-link " href="view_department?department_id=<?= $department['department_id'] ?>">Faculty Member</a>
                                </li>
                                <li class="me-3">
                                    <a class="doc-link active" href="manage_program?department_id=<?= $department['department_id'] ?>">Program Offering</a>
                                </li>
                                <li class="me-3">
                                    <a class="doc-link" href="facilities?department_id=<?= $department['department_id'] ?>">Facilities</a>
                                </li>
                            </ul>
                            <hr class="doc-tabs-divider">
                        </div>
                        <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
                            <h5 class="card-title fs-6 mb-2 mb-md-0">Managed <?= htmlspecialchars($department_name) ?> Department </h5>
                            <button type="button" class="btn btn-sm rounded-2 px-4 btn-dynamic" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-toggle="tooltip"
                            title="Click here to add program">
                                <i class="ri-add-line"></i> Add Program
                            </button>
                        </div>
                        <!-- Modal FOR ADDING PROGRAM START-->
                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-xl">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5 text-muted fw-bold" id="exampleModalLabel">Add Admission Requirements</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="../../function/programoffered_function.php" method="POST">
                                            <input type="hidden" name="department_id" value="<?php echo isset($_GET['department_id']) ? $_GET['department_id'] : ''; ?>">
                                            <input type="hidden" name="status" value="Active">
                                            <div class="mb-3">
                                                <label for="date_added" class="form-label fw-semibold text-muted"><strong>Date:</strong></label>
                                                <input type="date" class="form-control" id="date_added" name="date_created" value="<?php echo date('Y-m-d'); ?>" style="width: 150px;" required>
                                            </div>
                                            <!--<div class="mb-3">-->
                                            <!--    <label for="status" class="form-label fw-semibold text-muted"><strong>Status:</strong></label>-->
                                            <!--    <select class="form-control" id="status" name="status" style="width: 150px;">-->
                                            <!--        <option value="Active">Active</option>-->
                                            <!--        <option value="Inactive">Inactive</option>-->
                                            <!--    </select>-->
                                            <!--</div>-->
                                            <div class="mb-3">
                                                <label for="program_name" class="form-label fw-semibold text-muted"><strong>Program Name:</strong></label>
                                                <input type="text" class="form-control" id="program_name" name="program_name" placeholder="Enter Program Name" required>
                                            </div>
                                            <div class="row g-3">
                                                <div class="col-12 col-md-6">
                                                    <label for="course_code" class="form-label fw-semibold text-muted">
                                                        <strong>Course Code:</strong>
                                                    </label>
                                                    <input type="text" class="form-control" id="course_code" name="course_code" placeholder="Enter Course Code" required>
                                                </div>

                                                <div class="col-12 col-md-6">
                                                    <label for="course_duration" class="form-label fw-semibold text-muted">
                                                        <strong>Course Duration:</strong>
                                                    </label>
                                                    <select class="form-control" id="course_duration" name="course_duration" required>
                                                        <option value="" disabled selected>Select Course Duration</option>
                                                        <option value="1 Year">1 Year</option>
                                                        <option value="2 Years">2 Years</option>
                                                        <option value="3 Years">3 Years</option>
                                                        <option value="4 Years">4 Years</option>
                                                        <option value="5 Years">5 Years</option>
                                                        <option value="6 Years">6 Years</option>
                                                        <option value="7 Years">7 Years</option>
                                                    </select>
                                                </div>

                                            </div>

                                            <div class="mb-3 mt-3">
                                                <label for="program_description" class="form-label fw-semibold text-muted"><strong>Program Description:</strong></label>
                                                <textarea class="form-control" id="summernote_add" name="program_description" rows="3" placeholder="Enter Program Description" required></textarea>
                                                <div id="summernote_add"></div>
                                                <script>
                                                    $('#summernote_add').summernote({
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
                                            <div class="mt-3 text-start">
                                                <button type="submit" name="add_program" class="btn btn-dynamic float-end" data-bs-toggle="tooltip"
                                                title="Click to save"><i class="ri-save-line"></i> Save
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- MODAL FOR ADDING PROGRAM END -->

                        <div class="log_container">
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
                            $query = "SELECT program_id, program_name, course_code, course_duration, program_description, date_created, 
                                        status, department_id
                                        FROM program_offering 
                                        WHERE department_id = $department_id";
                            $result = mysqli_query($conn, $query);
                            ?>

                            <div class="table-container">
                                <table class="table table-hover" id="activityTable">
                                    <thead>
                                        <tr>
                                            <th class="text-center">Date Created</th>
                                            <th class="text-center">Program Name</th>
                                            <th class="text-center">Course Code</th>
                                            <th class="text-center">Course Duration</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if ($result->num_rows > 0): ?>
                                            <?php while ($row = $result->fetch_assoc()): ?>
                                                <tr>
                                                    <td class="text-center">
                                                        <?= date('F j, Y', strtotime($row['date_created'])) ?>
                                                    </td>
                                                    <td class="text-center"><?= $row['program_name'] ?></td>
                                                    <td class="text-center"><?= $row['course_code'] ?></td>
                                                    <td class="text-center"><?= $row['course_duration'] ?></td>
                                                    <td class="text-center">
                                                        <?php if ($row['status'] === 'Active'): ?>
                                                            <span class="badge bg-success">Active</span>
                                                        <?php elseif ($row['status'] === 'Inactive'): ?>
                                                            <span class="badge bg-danger">Inactive</span>
                                                        <?php else: ?>
                                                            <span class="badge bg-secondary"><?= htmlspecialchars($row['status']) ?></span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td class="text-center">
                                                        <div class="dropdown">
                                                            <button class="btn btn-light btn-sm" type="button" data-bs-toggle="dropdown" data-bs-toggle="tooltip"
                                                            title="Click here to see the action">
                                                                <i class="ri-more-2-fill"></i>
                                                            </button>
                                                            <ul class="dropdown-menu">
                                                                <li>
                                                                    <a class="dropdown-item text-dark view-requirement" href="#"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#viewModal<?= $row['program_id'] ?>" data-bs-toggle="tooltip"
                                                                        title="Click here to view details">
                                                                        <i class="ri-eye-line"></i> View 
                                                                    </a>
                                                                </li>

                                                                <li>
                                                                    <a href="#editModal<?php echo $row['program_id']; ?>"
                                                                        class="dropdown-item text-dark"
                                                                        data-bs-toggle="modal" data-bs-toggle="tooltip"
                                                                        title="Click here to edit this program">
                                                                        <i class="ri-pencil-line"></i> Edit
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item text-dark delete-program"
                                                                        href="../../function/programoffered_function.php?program_id=<?= $row['program_id'] ?>"
                                                                        onclick="return confirm('Are you sure you want to delete this program?')" data-bs-toggle="tooltip"
                                                                        title="Click here to delete this program">
                                                                        <i class="ri-delete-bin-line"></i> Delete
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </td>
                                                </tr>

                                                <!-- EDIT ADMISSION START-->
                                                <div class="modal fade" id="editModal<?php echo $row['program_id']; ?>" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-xl">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title fw-bold">Update Requirement</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body ">
                                                                <form method="POST" action="../../function/programoffered_function.php">
                                                                    <input type="hidden" name="program_id" value="<?php echo $row['program_id']; ?>">
                                                                    <input type="hidden" name="department_id" value="<?php echo $row['department_id']; ?>">

                                                                    <div class="mb-3">
                                                                        <label for="date_created" class="form-label"><strong>Date</strong></label>
                                                                        <input type="date" class="form-control" style="width: 150px;"
                                                                            name="date_created"
                                                                            value="<?php echo htmlspecialchars($row['date_created']); ?>"
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
                                                                        <label for="program_name" class="form-label"><strong>Program Name</strong></label>
                                                                        <input type="text" class="form-control"
                                                                            name="program_name"
                                                                            value="<?php echo htmlspecialchars($row['program_name']); ?>"
                                                                            required>
                                                                    </div>

                                                                    <div class="row g-3">
                                                                        <div class="col-12 col-md-6">
                                                                            <div class="mb-3">
                                                                                <label for="course_code" class="form-label"><strong>Course Code</strong></label>
                                                                                <input type="text" class="form-control"
                                                                                    name="course_code"
                                                                                    value="<?php echo htmlspecialchars($row['course_code']); ?>"
                                                                                    required>
                                                                            </div>

                                                                        </div>
                                                                        <div class="col-12 col-md-6">
                                                                            <div class="mb-3">
                                                                                <label for="course_duration" class="form-label"><strong>Course Duration</strong></label>
                                                                                <select class="form-control" name="course_duration" required>
                                                                                    <option value="" disabled>Select Course Duration</option>
                                                                                    <option value="1 Year" <?= ($row['course_duration'] == '1 Year') ? 'selected' : ''; ?>>1 Year</option>
                                                                                    <option value="2 Years" <?= ($row['course_duration'] == '2 Years') ? 'selected' : ''; ?>>2 Years</option>
                                                                                    <option value="3 Years" <?= ($row['course_duration'] == '3 Years') ? 'selected' : ''; ?>>3 Years</option>
                                                                                    <option value="4 Years" <?= ($row['course_duration'] == '4 Years') ? 'selected' : ''; ?>>4 Years</option>
                                                                                    <option value="5 Years" <?= ($row['course_duration'] == '5 Years') ? 'selected' : ''; ?>>5 Years</option>
                                                                                    <option value="6 Years" <?= ($row['course_duration'] == '6 Years') ? 'selected' : ''; ?>>6 Years</option>
                                                                                    <option value="7 Years" <?= ($row['course_duration'] == '7 Years') ? 'selected' : ''; ?>>7 Years</option>
                                                                                </select>
                                                                            </div>
                                                                        </div>

                                                                    </div>

                                                                    <div class="mb-3">
                                                                        <label for="program_description" class="form-label"><strong>Program Description</strong></label>
                                                                        <textarea class="form-control summernote1"
                                                                            name="program_description"
                                                                            rows="3"
                                                                            required><?php echo htmlspecialchars($row['program_description']); ?></textarea>
                                                                    </div>

                                                                    <div class="modal-footer pb-0">
                                                                        <button type="submit" name="update_program" class="btn btn-dynamic" data-bs-toggle="tooltip"
                                                                        title="Click to save"><i class="ri-save-line"></i>Save</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- EDIT ADMISSION END-->

                                                <!-- VIEWING MODAL start  -->
                                                <div class="modal fade" id="viewModal<?= $row['program_id'] ?>" tabindex="-1" aria-labelledby="viewModalLabel<?= $row['program_id'] ?>" aria-hidden="true">
                                                    <div class="modal-dialog modal-xl">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title fw-bold text-muted" id="viewModalLabel<?= $row['program_id'] ?>">
                                                                    View Program Offer
                                                                </h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form>
                                                                    <p><strong>Progran Name:</strong> <?= $row['program_name'] ?></p>
                                                                    <p><strong>Course Code:</strong> <?= $row['course_code'] ?></p>
                                                                    <p><strong>Program Description:</strong> <?= $row['program_description'] ?></p>

                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endwhile; ?> <!-- Added this line -->
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="5" class="text-center">No programs found.</td>
                                            </tr>
                                        <?php endif; ?> <!-- Added this line -->
                                    </tbody>

                                </table>

                                <!-- Debugging Output for Row Count -->
                                <div class="d-flex justify-content-center">
                                    <ul class="pagination custom-pagination mt-2"></ul>
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
    <script src="../../assets/bootstrap/js/activeLink.js?=v1.1"></script>

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