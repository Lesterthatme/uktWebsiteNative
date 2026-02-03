<?php
session_start();
include("../../connection/dbconnection.php");
include '../../function/department_function.php';
$department_id = $_GET['department_id'] ?? null;
$department_name = '';

// Check if there is an existing Main Building
$main_building_exists = false;
if ($department_id) {
    $query = "SELECT dm_name FROM department WHERE department_id = $department_id";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $department_name = $row['dm_name'];
    } else {
        $department_name = 'Unknown';
    }

    // Check if a Main Building already exists in the department_facilities table
    $main_building_check = "SELECT 1 FROM department_facilities WHERE department_id = $department_id AND image_type = 'Main Building' LIMIT 1";
    $check_result = mysqli_query($conn, $main_building_check);
    if ($check_result && mysqli_num_rows($check_result) > 0) {
        $main_building_exists = true;
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
        <?php include 'include/navbar.php'; ?>
        <!-- include navbar end -->

        <div class="p-4">
            <div class="row">
                <div class="card border-0 pb-3">
                    <div class="card-body">
                        <div class="doc-tabs-container mt-3">
                            <ul class="doc-tabs d-flex list-unstyled">
                                <li class="me-3">
                                    <a class="doc-link" href="view_department?department_id=<?= $department['department_id'] ?>">Faculty Member</a>
                                </li>
                                <li class="me-3">
                                    <a class="doc-link" href="manage_program?department_id=<?= $department['department_id'] ?>">Program Offering</a>
                                </li>
                                <li class="me-3">
                                    <a class="doc-link active" href="facilities?department_id=<?= $department['department_id'] ?>">Facilities</a>
                                </li>
                            </ul>
                            <hr class="doc-tabs-divider">
                        </div>
                        <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
                            <h5 class="card-title fs-6 mb-2 mb-md-0">Managed <?= htmlspecialchars($department_name) ?> Department Facilities</h5>
                            <button type="button" class="btn btn-sm rounded-2 px-4 btn-dynamic"
                                data-bs-toggle="modal"
                                data-bs-target="#exampleModal"
                                data-bs-toggle="tooltip"
                                title="Click here to add facility">
                                <i class="ri-add-line"></i> Add Facilities
                            </button>

                        </div>

                        <!-- Modal FOR ADDING FACILITITES START-->
                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5 text-muted fw-bold" id="exampleModalLabel">Add Facility</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>

                                    <div class="modal-body">
                                        <form method="POST" action="../../function/facility_function.php" enctype="multipart/form-data">
                                            <input type="hidden" name="department_id" value="<?php echo isset($_GET['department_id']) ? $_GET['department_id'] : ''; ?>">

                                            <div class="container-fluid">
                                                <!-- Upload Area -->
                                                <div class="mb-3">
                                                    <label class="form-label fw-semibold text-muted">Upload Image:</label>
                                                    <div class="upload-area text-center border border-2 border-secondary-subtle rounded p-3"
                                                        style="cursor: pointer;" id="uploadArea">
                                                        <img id="uploadIcon" src="https://cdn-icons-png.flaticon.com/512/126/126477.png" alt="Upload Icon" style="width: 50px;">
                                                        <p id="uploadText" class="mb-0">Drag & Drop <br><span class="text-success">or browse</span></p>
                                                        <small class="text-muted">Supports: JPEG, JPG, PNG</small>
                                                        <input type="file" id="fileInput" name="facility_image" class="d-none"
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

                                                <!-- Facility Name + Type -->
                                                <div class="row g-3 mb-3">
                                                    <div class="col-12 col-md-8">
                                                        <label for="facility_name" class="form-label fw-semibold text-muted">Facility Name:</label>
                                                        <input type="text" class="form-control" id="facility_name" name="facility_name"
                                                            placeholder="Enter Facility Name" required>
                                                    </div>
                                                    <div class="col-12 col-md-4">
                                                        <label for="image_type" class="form-label fw-semibold text-muted">Image Type:</label>
                                                        <select class="form-select" id="image_type" name="image_type" required>
                                                            <option value="" disabled selected>Select Image Type</option>
                                                            <option value="Main Building" <?php echo $main_building_exists ? 'disabled' : ''; ?>>Main Building</option>
                                                            <option value="Facility">Facility</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <!-- Description -->
                                                <div class="mb-3">
                                                    <label for="facility_description" class="form-label fw-semibold text-muted">Facility Description:</label>
                                                    <textarea class="form-control" id="facility_description" name="facility_description" rows="3"
                                                        placeholder="Enter Facility Description"></textarea>
                                                </div>

                                                <!-- Footer -->
                                                <div class="modal-footer pb-0">
                                                    <button type="submit" name="add_facility" class="btn btn-dynamic"
                                                        data-bs-toggle="tooltip" title="Click here to save">
                                                        <i class="ri-save-fill"></i> Save
                                                    </button>
                                                </div>

                                            </div>
                                        </form>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <!-- MODAL FOR ADDING FACILITITES END -->

                        <!-- viewing facility start -->
                        <div class="log_container">
                            <?php
                            // Fetch facilities from the department_facilities table
                            $facility_query = "SELECT * FROM department_facilities WHERE department_id = $department_id";
                            $facility_result = mysqli_query($conn, $facility_query);

                            if ($facility_result && mysqli_num_rows($facility_result) > 0) {
                                $facilities = mysqli_fetch_all($facility_result, MYSQLI_ASSOC);
                            } else {
                                $facilities = [];
                            }
                            ?>
                            <?php
                            $facility_index = 0;
                            $facility_count = count($facilities);
                            ?>

                            <script>
                                const modalIds = [];
                            </script>

                            <div class="row">

                                <?php foreach ($facilities as $index => $facility) : ?>
                                    <div class="col-md-3 mb-4">
                                        <div class="card overflow-hidden" style="position: relative;">
                                            <!-- Dropdown Menu -->
                                            <div class="dropdown" style="position: absolute; top: 10px; right: 10px; z-index: 10;">
                                                <button class="btn btn-light btn-sm" type="button" data-bs-toggle="dropdown" data-bs-toggle="tooltip"
                                                    title="Click here to see the action">
                                                    <i class="ri-more-2-fill"></i>
                                                </button>
                                                <ul class="dropdown-menu">

                                                    <li>
                                                        <a href="#editModal<?= $facility['facility_id']; ?>"
                                                            class="dropdown-item text-dark"
                                                            data-bs-toggle="modal" data-bs-toggle="tooltip"
                                                            title="Click here to edit this facility">
                                                            <i class="ri-pencil-line"></i> Edit
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item text-dark delete-program"
                                                            href="../../function/facility_function.php?facility_id=<?= $facility['facility_id'] ?>"
                                                            onclick="return confirm('Are you sure you want to delete this facility?')" data-bs-toggle="tooltip"
                                                            title="Click here to delete this facility">
                                                            <i class="ri-delete-bin-line"></i> Delete
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>

                                            <!-- Image with isolated modal trigger -->
                                            <img src="../../assets/uploads/department_facility/<?= $facility['facility_image'] ?>"
                                                class="card-img-top"
                                                alt="<?= htmlspecialchars($facility['facility_name']) ?>"
                                                style="position: relative; z-index: 1; cursor:pointer; transition: transform 0.3s ease;"
                                                data-bs-toggle="modal"
                                                data-bs-target="#facilityModal_<?= $index ?>"
                                                onclick="event.stopPropagation();"
                                                onmouseover="this.style.transform='scale(1.05)'"
                                                onmouseout="this.style.transform='scale(1)'">

                                            <!-- Label -->
                                            <?php if ($facility['image_type'] === 'Main Building') : ?>
                                                <span style="position: absolute; top: 10px; left: 10px; z-index: 5; background-color: rgba(0, 123, 255, 0.85); color: white; padding: 4px 10px; font-size: 12px; font-weight: bold; border-radius: 12px;">
                                                    Main Building
                                                </span>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                    <script>
                                        modalIds.push("facilityModal_<?= $index ?>");
                                    </script>

                                    <!-- Modal for viewing facilty start-->
                                    <div class="modal fade" id="facilityModal_<?= $index ?>" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-lg modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title"><?= htmlspecialchars($facility['facility_name']) ?></h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body text-center">
                                                    <img src="../../assets/uploads/department_facility/<?= $facility['facility_image'] ?>" class="img-fluid mb-3" alt="<?= htmlspecialchars($facility['facility_name']) ?>">
                                                    <?php if ($facility['image_type'] === 'Main Building') : ?>
                                                        <p class="fw-bold text-primary">Main Building</p>
                                                    <?php endif; ?>
                                                    <p><?= htmlspecialchars($facility['facility_description']) ?></p>
                                                </div>
                                                <!-- Left Arrow -->
                                                <i onclick="showPrev(<?= $index ?>)"
                                                    class="ri-arrow-left-circle-fill"
                                                    style="position: absolute; top: 50%; left: 15px; transform: translateY(-50%);
                                                    font-size: 2rem; color: rgba(0, 0, 0, 0.6); cursor: pointer; z-index: 1055;">
                                                </i>

                                                <!-- Right Arrow -->
                                                <i onclick="showNext(<?= $index ?>)"
                                                    class="ri-arrow-right-circle-fill"
                                                    style="position: absolute; top: 50%; right: 15px; transform: translateY(-50%);
                                                    font-size: 2rem; color: rgba(0, 0, 0, 0.6); cursor: pointer; z-index: 1055;">
                                                </i>

                                            </div>
                                        </div>
                                    </div>
                                    <!-- Modal for viewing facilty end-->

                                    <!-- Modal for Editing Facility -->
                                    <div class="modal fade" id="editModal<?= $facility['facility_id'] ?>" tabindex="-1" aria-labelledby="editModalLabel<?= $facility['facility_id'] ?>" aria-hidden="true">
                                        <div class="modal-dialog modal-xl">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title fw-bold" id="editModalLabel<?= $facility['facility_id'] ?>">Update Facility</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="../../function/facility_function.php" method="POST" enctype="multipart/form-data">
                                                        <input type="hidden" name="facility_id" value="<?= $facility['facility_id'] ?>">
                                                        <input type="hidden" name="department_id" value="<?= $facility['department_id'] ?>">
                                                        <input type="hidden" name="current_image" value="<?= $facility['facility_image'] ?>">

                                                        <div class="mb-3">
                                                            <label class="form-label"><strong>Current Image</strong></label><br>
                                                            <div class="text-center">
                                                                <img id="previewImage<?= $facility['facility_id'] ?>" src="../../assets/uploads/department_facility/<?= $facility['facility_image'] ?>" class="img-fluid mb-3 rounded" style="max-height: 300px;">
                                                            </div>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label for="facility_image<?= $facility['facility_id'] ?>" class="form-label"><strong>Choose New Image</strong></label>
                                                            <input type="file" name="facility_image" id="facility_image<?= $facility['facility_id'] ?>" class="form-control" onchange="previewImage_edit(event, <?= $facility['facility_id'] ?>)">
                                                        </div>

                                                        <div class="mb-3">
                                                            <label class="form-label"><strong>Facility Name</strong></label>
                                                            <input type="text" name="facility_name" value="<?= htmlspecialchars($facility['facility_name']) ?>" class="form-control" required>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label class="form-label"><strong>Image Type</strong></label>
                                                            <select name="image_type" class="form-select" required>
                                                                <option value="Main Building" <?= $facility['image_type'] == 'Main Building' ? 'selected' : '' ?>>Main Building</option>
                                                                <option value="Facility" <?= $facility['image_type'] == 'Facility' ? 'selected' : '' ?>>Facility</option>
                                                            </select>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label class="form-label"><strong>Facility Description</strong></label>
                                                            <textarea name="facility_description" rows="3" class="form-control" required><?= htmlspecialchars($facility['facility_description']) ?></textarea>
                                                        </div>

                                                        <button type="submit" name="update_facility" class="btn btn-dynamic float-end" title="Click here to save">
                                                            <i class="ri-save-fill"></i> Save</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <!-- viewing facility end -->
                    </div>
                </div>
            </div>
            <?php include 'include/footer.php'; ?>
        </div>
    </main>
    <!-- start js -->

    <script>
        function showPrev(currentIndex) {
            const prevIndex = (currentIndex - 1 + modalIds.length) % modalIds.length;
            bootstrap.Modal.getInstance(document.getElementById(modalIds[currentIndex])).hide();
            new bootstrap.Modal(document.getElementById(modalIds[prevIndex])).show();
        }

        function showNext(currentIndex) {
            const nextIndex = (currentIndex + 1) % modalIds.length;
            bootstrap.Modal.getInstance(document.getElementById(modalIds[currentIndex])).hide();
            new bootstrap.Modal(document.getElementById(modalIds[nextIndex])).show();
        }
    </script>
   
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../../assets/bootstrap/js/Logs.js?v=1.1"></script>
    <script src="../../assets/bootstrap/js/site_settings.js"></script>
    <script src="../../assets/bootstrap/js/script.js"></script>
    <script src="../../assets/bootstrap/js/carousel2itemslide.js?=v1.7"></script>
    <script src="../../assets/bootstrap/js/drag_and_drop.js?=v1.0"></script>
    <script src="../../assets/bootstrap/js/activeLink.js?=v1.1"></script>
     <script>
        function previewImage_edit(event, facilityId) {
            const input = event.target;
            const preview = document.getElementById('previewImage' + facilityId);

            // Check if a file has been selected
            if (input.files && input.files[0]) {
                const reader = new FileReader();

                // When the file is read, update the image preview
                reader.onload = function(e) {
                    preview.src = e.target.result;
                };

                // Read the selected file as a data URL
                reader.readAsDataURL(input.files[0]);
            }
        }
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