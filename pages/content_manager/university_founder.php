<?php
require '../../connection/dbconnection.php';
session_start();

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// Fetch  scholarship
$sql = "SELECT * FROM university_founder";
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
    <link rel="stylesheet" href="../../assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../assets/bootstrap/css/style.css?=v1.1">
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

        <!-- start: Content -->
        <div class="p-4">
            <div class="row">
                <div class="card border-0 pb-3">
                    <div class="card-body">

                        <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
                            <h5 class="card-title fs-6 mb-2 mb-md-0">Manage University Founder</h5>
                            <button type="button" class="btn btn-sm rounded-2 px-4 btn-dynamic" data-bs-toggle="modal"
                                data-bs-target="#exampleModal" data-bs-toggle="tooltip"
                                data-bs-placement="top" title="Click to add university founder">
                                <i class="ri-add-line"></i> Add University Founder
                            </button>
                        </div>

                        <p class="card-text text-muted small">
                            Manage and update information about the university's founder,
                            including biography, photo, and notable achievements
                        </p>

                        <!-- Modal for adding founder start-->
                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog modal-xl">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5 text-muted fw-bold" id="exampleModalLabel">Add
                                            University Founder</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="../../function/content_manager/founder_function.php" method="POST"
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
                                                <div class="col-md-6">
                                                    <label for="date" class="form-label fw-semibold text-muted">Date
                                                        founded:</label>
                                                    <input type="date" id="date_appointed" name="date_founded"
                                                        class="form-control" required style="width: 300px;">

                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <div class="col-md-4">
                                                    <label for="first-name"
                                                        class="form-label fw-semibold text-muted">First Name:</label>
                                                    <input type="text" id="first-name" name="founder_fname"
                                                        class="form-control" placeholder="Enter First Name" required>
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="middle-name"
                                                        class="form-label fw-semibold text-muted">Middle Name:</label>
                                                    <input type="text" id="middle-name" name="founder_mname"
                                                        class="form-control" placeholder="Enter Middle Name">
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="last-name"
                                                        class="form-label fw-semibold text-muted">Last Name:</label>
                                                    <input type="text" id="last-name" name="founder_lname"
                                                        class="form-control" placeholder="Enter Last Name" required>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label for="description" class="form-label fw-semibold text-muted"><strong>Founder Details:</strong></label>
                                                <textarea class="form-control" id="summernote" name="founder_description" rows="3" placeholder="Enter description" required></textarea>
                                                <div id="summernote"></div>
                                                <script>
                                                    $('#summernote').summernote({
                                                        placeholder: 'Please Enter Description',
                                                        tabsize: 2,
                                                        height: 120,
                                                        toolbar: [
                                                            ['style', ['bold', 'italic', 'underline', 'clear']],
                                                            ['para', ['ul', 'ol', 'paragraph']],
                                                            ['insert', ['link']],
                                                            ['view', ['fullscreen', 'codeview']]
                                                        ]
                                                    });
                                                </script>
                                            </div>
                                            <button type="submit" name="add_founder" class="btn btn-dynamic float-end" data-bs-toggle="tooltip"
                                                data-bs-placement="top" title="Click to save"><i class="ri-save-fill"></i> Save
                                            </button>

                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Modal for adding founder end-->

                        <!-- viewing university founder start -->
                        <?php
                        include '../../connection/dbconnection.php';

                        $sql = "SELECT * FROM university_founder";
                        $result = $conn->query($sql);
                        ?>

                        <div class="container py-4">
                            <div class="d-flex flex-wrap justify-content-center gap-4">
                                <?php
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                ?>
                                        <div class="management_card">
                                            <!-- Dropdown Menu -->
                                            <div class="dropdown three-dots">
                                                <button class="btn p-0 border-0" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <span></span><span></span><span></span>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    <li>
                                                        <a class="dropdown-item text-dark view-requirement" href="#" data-bs-toggle="modal"
                                                            data-bs-target="#viewModal<?= $row['founder_id'] ?>">
                                                            <i class="ri-eye-line"></i> View
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="#editModal<?= $row['founder_id']; ?>" class="dropdown-item text-dark"
                                                            data-bs-toggle="modal">
                                                            <i class="ri-pencil-line"></i> Edit
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <form method="POST" action="../../function/content_manager/founder_function.php" style="display:inline;">
                                                            <input type="hidden" name="founder_id" value="<?= $row['founder_id']; ?>">
                                                            <button type="submit" name="delete_founder" class="dropdown-item text-dark"
                                                                onclick="return confirm('Are you sure you want to delete this founder?');">
                                                                <i class="ri-delete-bin-line"></i> Delete
                                                            </button>
                                                        </form>
                                                    </li>
                                                </ul>
                                            </div>

                                            <!-- Founder Info -->
                                            <img src="<?= !empty($row['image']) ? '../../assets/uploads/founder_image/' . $row['image'] : '../../assets/images/default.jpg'; ?>"
                                                alt="Profile Image" class="officials_image">
                                            <div class="official_name">
                                                <?= htmlspecialchars($row['founder_fname'] . ' ' . $row['founder_mname'] . ' ' . $row['founder_lname']); ?>
                                            </div>
                                            <p class="position_description text-justify">
                                                Date Founded: <?= date("F j, Y", strtotime($row['date_founded'])); ?>
                                            </p>
                                        </div>

                                        <!-- Edit Modal -->
                                        <div class="modal fade" id="editModal<?= $row['founder_id']; ?>" tabindex="-1">
                                            <div class="modal-dialog modal-xl">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title fw-bold">Update University Founder</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form method="POST" action="../../function/content_manager/founder_function.php" enctype="multipart/form-data">
                                                            <input type="hidden" name="founder_id" value="<?= $row['founder_id']; ?>">
                                                            <div class="mb-3 text-center">
                                                                <img class="editPreviewImage officials_image mt-2 rounded-circle d-block mx-auto"
                                                                    src="<?= !empty($row['image']) ? '../../assets/uploads/founder_image/' . htmlspecialchars($row['image']) : '../../assets/images/default.jpg'; ?>"
                                                                    width="100" height="100" alt="Current Image">
                                                                <input type="file" name="image" class="form-control mt-2 preview-image-input" accept="image/jpeg, image/jpg, image/png">
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-4 mb-3">
                                                                    <label for="date_founded"><strong>Date Founded</strong></label>
                                                                    <input type="date" class="form-control" name="date_founded"
                                                                        value="<?= htmlspecialchars($row['date_founded']); ?>" required>
                                                                </div>
                                                            </div>

                                                            <div class="row">

                                                                <div class="col-4 mb-3">
                                                                    <label><strong>First Name</strong></label>
                                                                    <input type="text" class="form-control" name="founder_fname"
                                                                        value="<?= htmlspecialchars($row['founder_fname']); ?>" required>
                                                                </div>
                                                                <div class="col-4 mb-3">
                                                                    <label><strong>Middle Name</strong></label>
                                                                    <input type="text" class="form-control" name="founder_mname"
                                                                        value="<?= htmlspecialchars($row['founder_mname']); ?>" required>
                                                                </div>
                                                                <div class="col-4 mb-3">
                                                                    <label><strong>Last Name</strong></label>
                                                                    <input type="text" class="form-control" name="founder_lname"
                                                                        value="<?= htmlspecialchars($row['founder_lname']); ?>" required>
                                                                </div>
                                                            </div>

                                                            <div class="mb-3">
                                                                <label><strong>Founder Details</strong></label>
                                                                <textarea class="form-control summernote1" name="founder_description" rows="3"
                                                                    required><?= htmlspecialchars($row['founder_description']); ?></textarea>
                                                            </div>

                                                            <div class="modal-footer">
                                                                <button type="submit" name="update_founder" class="btn btn-dynamic">
                                                                    <i class="ri-save-line"></i> Save
                                                                </button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- View Modal -->
                                        <div class="modal fade" id="viewModal<?= $row['founder_id'] ?>" tabindex="-1">
                                            <div class="modal-dialog modal-xl">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title fw-bold text-muted">View Details</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                        <div class="modal-body">
                                                        <?= $row['founder_description']; ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                <?php
                                    }
                                } else {
                                    echo '<p class="text-center">No University Founder found.</p>';
                                }
                                ?>
                            </div>
                        </div>

                        <!-- viewing university founder end -->

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
                                ['insert', ['link']],
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

    <!-- <script>
        function previewImage1(input) {
            const file = input.files[0];
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
        }
    </script> -->

    <!-- start js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../../assets/bootstrap/js/script.js"></script>
    <script src="../../assets/bootstrap/js/carousel.js"></script>
    <script src="../../assets/bootstrap/js/drag_and_drop.js?=1.1"></script>
    <script src="../../assets/bootstrap/js/activeLink.js?v=1.1"></script>
    <script src="../../assets/bootstrap/js/table.js"></script>
    <script src="../../assets/bootstrap/js/site_settings.js?=v1.5"></script>

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
                    document.getElementById("founder_id").value = this.getAttribute("data-id");
                    document.getElementById("editFirstName").value = this.getAttribute("data-firstname");
                    document.getElementById("editMiddleName").value = this.getAttribute("data-middlename");
                    document.getElementById("editLastName").value = this.getAttribute("data-lastname");
                    document.getElementById("editDateAppointed").value = this.getAttribute("data-appointed");

                    // Handle Image Preview
                    const imageSrc = this.getAttribute("data-image");
                    if (imageSrc) {
                        document.getElementById("editPreviewImage").src = "../../assets/uploads/founder_image/" + imageSrc;
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
            window.openDeleteModal = function(founder_id, founder_name) {
                event.preventDefault();
                document.getElementById("modalFounderId").value = founder_id;
                document.getElementById("FounderNamePlaceholder").textContent = founder_name;
                document.getElementById("deleteConfirmationModal-founder").style.display = "flex";
            };

            window.closeModal = function() {
                document.getElementById("deleteConfirmationModal-founder").style.display = "none";
            };

            window.closeModalOutside = function(event) {
                if (event.target.id === "deleteConfirmationModal-founder") {
                    closeModal();
                }
            };
        });
    </script>
    <!-- END >> JS SCRIPT IN ALERT -->
</body>

</html>