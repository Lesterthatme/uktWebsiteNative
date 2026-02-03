<?php

require '../../connection/dbconnection.php';
session_start();

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// Fetch  scholarship
$sql = "SELECT * FROM rector";
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
    <link rel="stylesheet" href="../../assets/bootstrap/css/style.css?=v2.4"> 
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

        <!-- start: Content -->
        <div class="p-4">
            <div class="row">
                <div class="card border-0 pb-3">
                    <div class="card-body">
                        <div class="doc-tabs-container mt-3">
                            <ul class="doc-tabs d-flex list-unstyled">
                                <li class="me-3">
                                    <a class="doc-link active" href="rector_page">Active</a>
                                </li>
                                <li class="me-3">
                                    <a class="doc-link" href="inactiverector">Inactive</a>
                                </li>

                            </ul>
                            <hr class="doc-tabs-divider">
                        </div>
                        <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
                            <h5 class="card-title fs-6 mb-2 mb-md-0">Manage Rector</h5>
                            <button type="button" class="btn btn-sm rounded-2 px-4 btn-dynamic" data-bs-toggle="modal"
                                data-bs-target="#exampleModal" data-bs-toggle="tooltip" data-bs-placement="top" 
                                title="Click to add rector"><i class="ri-add-line"></i> Add Rector
                            </button>
                        </div>

                        <p class="card-text text-muted small">
                            Stay informed with the latest updates, important notices, and key announcements. This
                            section keeps you connected with recent events, system updates, and essential information to
                            ensure you’re always in the loop.
                        </p>

                        <!-- Modal for adding Rectors start-->
                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog modal-xl">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5 text-muted fw-bold" id="exampleModalLabel">Add
                                            Rector</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="../../function/rector_function.php" method="POST"
                                            enctype="multipart/form-data">
                                            <div class="mb-3">
                                                <label class="form-label fw-semibold text-muted">Upload Image:</label>
                                                <div class="upload-area" id="uploadArea">
                                                    <img src="https://cdn-icons-png.flaticon.com/512/126/126477.png"
                                                        alt="Upload Icon">
                                                    <p class="mb-0">Drag & Drop <br><span class="text-success">or
                                                            browse</span></p>
                                                    <small class="text-muted">Supports: JPEG, JPG, PNG</small>
                                                    <input type="file" id="fileInput" name="image" class="d-none"
                                                        accept="image/jpeg, image/jpg, image/png">
                                                </div>
                                                <div id="previewContainer" class="preview-container d-none">
                                                    <button type="button" class="delete-btn"
                                                        id="deleteBtn">&times;</button>
                                                    <img id="previewImage" class="preview-img" alt="Preview Image">
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <div class="col-md-2">
                                                    <label for="date" class="form-label fw-semibold text-muted">Date
                                                        Appointed:</label>
                                                    <input type="date" id="date_appointed" name="date_appointed"
                                                        class="form-control" required>
                                                </div>
                                                <!-- <div class="col-md-6">
                                                    <label for="status"
                                                        class="form-label fw-semibold text-muted">Status:</label>
                                                    <select id="status" name="status" class="form-control" required>
                                                        <option value="Active">Active</option>
                                                        <option value="Inactive">Inactive</option>
                                                    </select>
                                                </div> -->
                                            </div>

                                            <div class="row mb-3">
                                                <div class="col-md-4">
                                                    <label for="first-name"
                                                        class="form-label fw-semibold text-muted">First Name:</label>
                                                    <input type="text" id="first-name" name="first_name"
                                                        class="form-control" placeholder="Enter First Name" required>
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="middle-name"
                                                        class="form-label fw-semibold text-muted">Middle Name:</label>
                                                    <input type="text" id="middle-name" name="middle_name"
                                                        class="form-control" placeholder="Enter Middle Name">
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="last-name"
                                                        class="form-label fw-semibold text-muted">Last Name:</label>
                                                    <input type="text" id="last-name" name="last_name"
                                                        class="form-control" placeholder="Enter Last Name" required>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label for="description" class="form-label fw-semibold text-muted"><strong>Details:</strong></label>
                                                <textarea class="form-control" id="summernote" name="rector_details" rows="3" placeholder="Enter description" required></textarea>
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
                                            <button type="submit" name="add_rector" class="btn btn-dynamic float-end"  data-bs-toggle="tooltip" 
                                            data-bs-placement="top" title="Click to save"><i class="ri-save-fill"></i> Save</button>

                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Modal for adding Rectors end-->

                        <!-- container nav -->

                        <?php
                        // Include database connection
                        include '../../connection/dbconnection.php';

                        // Fetch Rectors data
                        $sql = "SELECT * FROM rector WHERE status ='Active'";
                        $result = $conn->query($sql);
                        ?>

                        <div id="partnerCarousel" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner p-4">
                                <?php
                                $active = true;
                                $count = 0; // Count entries per batch

                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        // Open a new carousel-item every 5 entries
                                        if ($count % 5 == 0) {
                                            echo '<div class="carousel-item ' . ($active ? 'active' : '') . '">';
                                            echo '<div class="d-flex flex-wrap justify-content-center gap-4">';
                                            $active = false; // Only first carousel-item is active
                                        }
                                ?>
                                        <div class="management_card">
                                            <div class="dropdown three-dots">
                                                <button class="btn p-0 border-0" type="button" data-bs-toggle="dropdown"
                                                    aria-expanded="false"  data-bs-toggle="tooltip" 
                                                    data-bs-placement="top" title="Click here to see the action">
                                                    <span></span><span></span><span></span>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    <li>
                                                        <a class="dropdown-item text-dark view-requirement" href="#"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#viewModal<?= $row['rector_id'] ?>" data-bs-toggle="tooltip" 
                                                            data-bs-placement="top" title="Click to view the rector details">
                                                            <i class="ri-eye-line"></i> View Details
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="#editModal<?php echo $row['rector_id']; ?>"
                                                            class="dropdown-item text-dark"
                                                            data-bs-toggle="modal"  data-bs-toggle="tooltip" 
                                                            data-bs-placement="top" title="Click to edit details">
                                                            <i class="ri-pencil-line"></i> Edit
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <form method="POST" action="../../function/rector_function.php" style="display:inline;">
                                                            <input type="hidden" name="rector_id" value="<?= $row['rector_id']; ?>">
                                                            <button type="submit" name="delete_rector" class="dropdown-item text-dark"
                                                                onclick="return confirm('Are you sure you want to delete this rector?');"  data-bs-toggle="tooltip" 
                                                                data-bs-placement="top"title="Click to delete rector">
                                                                <i class="ri-delete-bin-line"></i> Delete
                                                            </button>
                                                        </form>
                                                    </li>

                                                </ul>

                                            </div>
                                            <img src="<?php echo !empty($row['image']) ? '../../assets/uploads/rector_image/' . $row['image'] : '../../assets/images/default.jpg'; ?>"
                                                alt="Profile Image" class="officials_image">
                                            <div class="official_name">
                                                <?php echo htmlspecialchars($row['first_name'] . ' ' . $row['middle_name'] . ' ' . $row['last_name']); ?>
                                            </div>
                                            <div
                                                class="management-status-active <?php echo ($row['status'] == 'Inactive') ? 'announcement-status-inactive' : ''; ?>">
                                                <?php echo htmlspecialchars($row['status']); ?>
                                            </div>
                                            <p class="position_description text-center">
                                                Appointed on: <?php echo date("F j, Y", strtotime($row['date_appointed'])); ?>
                                            </p>
                                        </div>
                                        <!-- update modal start -->
                                        <div class="modal fade" id="editModal<?php echo $row['rector_id']; ?>" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-xl">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title fw-bold">Update Rector</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form method="POST" action="../../function/rector_function.php" enctype="multipart/form-data">
                                                            <input type="hidden" name="rector_id" value="<?php echo $row['rector_id']; ?>">
                                                            <div class="mb-3 text-center">
                                                                <img class="editPreviewImage officials_image mt-2 rounded-circle d-block mx-auto"
                                                                    src="<?php echo !empty($row['image']) ? '../../assets/uploads/rector_image/' . htmlspecialchars($row['image']) : '../../assets/images/default.jpg'; ?>"
                                                                    width="100" height="100" alt="Current Image">

                                                                <input type="file" name="image" class="form-control mt-2 preview-image-input" accept="image/jpeg, image/jpg, image/png">
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-4">
                                                                    <div class="mb-3">
                                                                        <label for="date_added" class="form-label"><strong>Date</strong></label>
                                                                        <input type="date" class="form-control" style="width: 150px;"
                                                                            name="date_appointed"
                                                                            value="<?php echo htmlspecialchars($row['date_appointed']); ?>"
                                                                            required>
                                                                    </div>
                                                                </div>
                                                                <div class="col-4">
                                                                    <div class="mb-3">
                                                                        <label for="status" class="form-label"><strong>Status</strong></label>
                                                                        <select class="form-select" name="status" style="width: 150px;" required>
                                                                            <option value="Active" <?php if ($row['status'] == 'Active') echo 'selected'; ?>>Active</option>
                                                                            <option value="Inactive" <?php if ($row['status'] == 'Inactive') echo 'selected'; ?>>Inactive</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>


                                                            <div class="row">
                                                                <div class="col-4">
                                                                    <div class="mb-3">
                                                                        <label for="first_name" class="form-label"><strong>First Name</strong></label>
                                                                        <input type="text" class="form-control"
                                                                            name="first_name"
                                                                            value="<?php echo htmlspecialchars($row['first_name']); ?>"
                                                                            required>
                                                                    </div>

                                                                </div>
                                                                <div class="col-4">
                                                                    <div class="mb-3">
                                                                        <label for="middle_name" class="form-label"><strong>Middle Name</strong></label>
                                                                        <input type="text" class="form-control"
                                                                            name="middle_name"
                                                                            value="<?php echo htmlspecialchars($row['middle_name']); ?>"
                                                                            required>
                                                                    </div>

                                                                </div>
                                                                <div class="col-4">
                                                                    <div class="mb-3">
                                                                        <label for="last_name" class="form-label"><strong>Last Name</strong></label>
                                                                        <input type="text" class="form-control"
                                                                            name="last_name"
                                                                            value="<?php echo htmlspecialchars($row['last_name']); ?>"
                                                                            required>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="description" class="form-label"><strong>Details</strong></label>
                                                                <textarea class="form-control summernote1"
                                                                    name="rector_details"
                                                                    rows="3"
                                                                    required><?php echo ($row['rector_details']); ?></textarea>

                                                            </div>

                                                            <div class="modal-footer pb-0">
                                                                <button type="submit" name="update_rector" class="btn btn-dynamic"
                                                                data-bs-toggle="tooltip" data-bs-placement="top" title="Click to save">
                                                                <i class="ri-save-line"></i>Save</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- update modal end -->

                                        <div class="modal fade" id="viewModal<?= $row['rector_id'] ?>" tabindex="-1" aria-labelledby="viewModalLabel<?= $row['rector_id'] ?>" aria-hidden="true">
                                            <div class="modal-dialog modal-xl">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title fw-bold text-muted" id="viewModalLabel<?= $row['rector_id'] ?>">
                                                            View Details
                                                        </h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form>
                                                            <div class="mb-3">
                                                                <label for="description" class="form-label"><strong>Description</strong></label>
                                                                <p><?= $row['rector_details'] ?></p>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                <?php
                                        $count++;
                                        if ($count % 5 == 0 || $count == $result->num_rows) {
                                            echo '</div>';
                                            echo '</div>';
                                        }
                                    }
                                } else {
                                    echo '<p class="text-center">No Rector found.</p>';
                                }
                                ?>
                            </div>
                        </div>
                        <!-- container nav -->

                    </div>
                </div>
            </div>
            <?php include 'include/footer.php'; ?>
        </div>
    </main>

    <script>
        $(document).ready(function() {
            // Ensure Summernote initializes correctly when the modal opens
            $('.modal').on('shown.bs.modal', function() {
                $(this).find('.summernote1').each(function() {
                    if (!$(this).data('summernote')) { // Prevent re-initialization
                        $(this).summernote({
                            height: 200,
                            placeholder: 'Enter details here...',
                            toolbar: [
                                ['style', ['bold', 'italic', 'underline', 'clear']],
                                ['para', ['ul', 'ol', 'paragraph']],
                                ['insert', ['link', 'picture']],
                                ['view', ['fullscreen', 'codeview']]
                            ]
                        });
                    }
                });
            });

            // Destroy Summernote when modal is closed to avoid duplicates
            $('.modal').on('hidden.bs.modal', function() {
                $(this).find('.summernote1').each(function() {
                    $(this).summernote('destroy');
                });
            });
        });
    </script>

    <!-- start js -->
    <!-- <script src="../../assets/bootstrap/js/jquery-3.7.1.js"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- <script src="../../assets/bootstrap/js/bootstrap.bundle.min.js"></script> -->
    <script src="../../assets/bootstrap/js/script.js"></script>
    <!-- <script src="../../assets/bootstrap/js/carousel.js"></script> -->
    <script src="../../assets/bootstrap/js/drag_and_drop.js?=1.1"></script>
    <script src="../../assets/bootstrap/js/activeLink.js?v=1.1"></script>
    <script src="../../assets/bootstrap/js/table.js"></script>
    <script src="../../assets/bootstrap/js/site_settings.js?v=<?= time(); ?>"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const inputs = document.querySelectorAll('.preview-image-input');

            inputs.forEach(input => {
                input.addEventListener('change', function() {
                    const file = this.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            const img = input.previousElementSibling;
                            if (img && img.tagName.toLowerCase() === 'img') {
                                img.src = e.target.result;
                            }
                        };
                        reader.readAsDataURL(file);
                    }
                });
            });
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const editButtons = document.querySelectorAll(".edit-btn");

            editButtons.forEach(button => {
                button.addEventListener("click", function() {
                    document.getElementById("rector_id").value = this.getAttribute("data-id");
                    document.getElementById("editFirstName").value = this.getAttribute("data-firstname");
                    document.getElementById("editMiddleName").value = this.getAttribute("data-middlename");
                    document.getElementById("editLastName").value = this.getAttribute("data-lastname");
                    document.getElementById("editDateAppointed").value = this.getAttribute("data-appointed");
                    document.getElementById("editStatus").value = this.getAttribute("data-status");

                    // Handle Image Preview
                    const imageSrc = this.getAttribute("data-image");
                    if (imageSrc) {
                        document.getElementById("editPreviewImage").src = "../../assets/uploads/rector_image/" + imageSrc;
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
            window.openDeleteModal = function(rector_id, rector_name) {
                event.preventDefault();
                document.getElementById("modalRectorId").value = rector_id;
                document.getElementById("RectorNamePlaceholder").textContent = rector_name;
                document.getElementById("deleteConfirmationModal-rector").style.display = "flex";
            };

            window.closeModal = function() {
                document.getElementById("deleteConfirmationModal-rector").style.display = "none";
            };

            window.closeModalOutside = function(event) {
                if (event.target.id === "deleteConfirmationModal-rector") {
                    closeModal();
                }
            };
        });
    </script>
    <!-- END >> JS SCRIPT IN ALERT -->
</body>

</html>