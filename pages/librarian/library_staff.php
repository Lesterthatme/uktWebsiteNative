<?php
include 'include/alert.php';
session_start();
if (!isset($_SESSION['session_token'])) {
    header('location:login.php');
    exit;
}
include 'confirmation.php';
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/png" href="../../assets/images/officiallogo (1).png" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>University of Kratie || Admin</title>
    <!-- start css  -->
    <link rel="stylesheet" href="../../assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../assets/bootstrap/css/style.css?=v1.1">
    <!-- end css -->
    <!-- Remix icon -->
    <link rel="stylesheet" href="../../assets/RemixIcon/fonts/remixicon.css">
</head>

<body class="bg-light">

    <!-- include side bar start -->
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
                        <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
                            <!-- Manage Library Staff Title -->
                            <h5 class="card-title fs-6 mb-2 mb-md-0">Manage Library Staff</h5>

                            <!-- Button Group for View & Add Library Staff -->
                            <div class="d-flex gap-2">
                                <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal"
                                    data-bs-target="#staticBackdrop">
                                    View Inactive Library Staff
                                </button>

                                <button type="button" class="btn btn-sm rounded-2 px-4 btn-dynamic"
                                    data-bs-toggle="modal" data-bs-target="#exampleModal">
                                    <i class="ri-add-line"></i> Add Library Staff
                                </button>
                            </div>
                        </div>

                        <p class="card-text text-muted small">
                            Stay informed with the latest updates, important notices, and key announcements. This
                            section keeps you connected with recent events, system updates, and essential information to
                            ensure you’re always in the loop.
                        </p>

                        <!-- Modal for adding library staff start-->
                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5 text-muted fw-bold" id="exampleModalLabel">Add
                                            Library Staff</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="function/librarystaff_function.php" method="POST"
                                            enctype="multipart/form-data">
                                            <div class="mb-3">
                                                <label class="form-label fw-semibold text-muted">Upload Image:</label>
                                                <div class="upload-area" id="uploadArea">
                                                    <img src="https://cdn-icons-png.flaticon.com/512/126/126477.png"
                                                        alt="Upload Icon">
                                                    <p class="mb-0">Drag & Drop <br><span class="text-success">or
                                                            browse</span></p>
                                                    <small class="text-muted">Supports: JPEG, JPG, PNG</small>
                                                    <input type="file" id="fileInput" name="staff_image" class="d-none"
                                                        accept="image/jpeg, image/jpg, image/png">
                                                </div>
                                                <div id="previewContainer" class="preview-container d-none">
                                                    <button type="button" class="delete-btn"
                                                        id="deleteBtn">&times;</button>
                                                    <img id="previewImage" class="preview-img" alt="Preview Image">
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <div class="col-md-4">
                                                    <label for="first-name"
                                                        class="form-label fw-semibold text-muted">First Name:</label>
                                                    <input type="text" id="first-name" name="staff_firstname"
                                                        class="form-control" placeholder="Enter First Name" required>
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="middle-name"
                                                        class="form-label fw-semibold text-muted">Middle Name:</label>
                                                    <input type="text" id="middle-name" name="staff_middlename"
                                                        class="form-control" placeholder="Enter Middle Name">
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="last-name"
                                                        class="form-label fw-semibold text-muted">Last Name:</label>
                                                    <input type="text" id="last-name" name="staff_lastname"
                                                        class="form-control" placeholder="Enter Last Name" required>
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <div class="col-md-4">
                                                    <label for="staff_position">Staff Position:</label>
                                                    <select class="form-control" name="staff_position" required>
                                                        <option value="" disabled selected>Select Position</option>
                                                        <option value="College Librarian III">College Librarian III
                                                        </option>
                                                        <option value="Graduate Studies Librarian">Graduate Studies
                                                            Librarian</option>
                                                        <option value="College Librarian I">College Librarian I</option>
                                                        <option value="Support Staff">Support Staff</option>
                                                        <option value="Library in-charge">Library in-charge</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="email" class="form-label fw-semibold text-muted">Email
                                                        Addess:</label>
                                                    <input type="email" id="email" name="staff_email"
                                                        class="form-control" placeholder="Enter Email Address">
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="contact_number"
                                                        class="form-label fw-semibold text-muted">Contact
                                                        Number:</label>
                                                    <input type="number" id="contact_number" name="staff_contactnumber"
                                                        class="form-control" placeholder="Enter Contact Number"
                                                        required>
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <div class="col-md-4">
                                                    <label for="status"
                                                        class="form-label fw-semibold text-muted">Status:</label>
                                                    <select id="status" name="status" class="form-control" required>
                                                        <option value="Active">Active</option>
                                                        <option value="Inactive">Inactive</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <button type="submit" name="add_librarystaff" class="btn btn-dynamic"><i
                                                    class="ri-save-fill"></i> Save</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Modal for adding library staff end-->

                        <!-- viewing library staff start -->
                        <?php
                        include '../../connection/dbconnection.php';

                        $sql = "SELECT * FROM library_staff WHERE status = 'Active'";
                        $result = $conn->query($sql);
                        ?>

                        <div id="partnerCarousel" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner p-4">
                                <?php
                                $active = true;
                                $count = 0;

                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        if ($count % 5 == 0) {
                                            echo '<div class="carousel-item ' . ($active ? 'active' : '') . '">';
                                            echo '<div class="d-flex flex-wrap justify-content-center gap-4">';
                                            $active = false;
                                        }
                                        ?>
                                        <div class="management_card">
                                            <div class="dropdown three-dots">
                                                <button class="btn p-0 border-0" type="button" data-bs-toggle="dropdown"
                                                    aria-expanded="false">
                                                    <span></span><span></span><span></span>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    <li>
                                                        <a class="dropdown-item edit-btn" href="#" data-bs-toggle="modal"
                                                            data-bs-target="#editModal"
                                                            data-id="<?php echo $row['staff_id']; ?>"
                                                            data-firstname="<?php echo htmlspecialchars($row['staff_firstname']); ?>"
                                                            data-middlename="<?php echo htmlspecialchars($row['staff_middlename']); ?>"
                                                            data-lastname="<?php echo htmlspecialchars($row['staff_lastname']); ?>"
                                                            data-position="<?php echo $row['staff_position']; ?>"
                                                            data-email="<?php echo $row['staff_email']; ?>"
                                                            data-contactnumber="<?php echo $row['staff_contactnumber']; ?>"
                                                            data-status="<?php echo $row['status']; ?>"
                                                            data-image="<?php echo $row['staff_image']; ?>">
                                                            Edit
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item text-danger text-decoration-none"
                                                            href="javascript:void(0);" data-id="<?php echo $row['staff_id']; ?>"
                                                            data-title="<?php echo addslashes($row['staff_firstname'] . ' ' . $row['staff_lastname']); ?>"
                                                            onclick="openDeleteModal(this);">
                                                            Delete
                                                        </a>
                                                    </li>



                                                </ul>
                                            </div>
                                            <img src="<?php echo !empty($row['staff_image']) ? 'assets/uploads/librarystaff_images/' . $row['staff_image'] : 'assets/uploads/librarystaff_images/default.jpg'; ?>"
                                                alt="Profile Image" class="officials_image">
                                            <div class="official_name">
                                                <?php echo htmlspecialchars($row['staff_firstname'] . ' ' . $row['staff_middlename'] . ' ' . $row['staff_lastname']); ?>
                                            </div>
                                            <div class="official_name">
                                                <small
                                                    class="text-dark"><?php echo htmlspecialchars($row['staff_position']); ?></small>
                                            </div>
                                            <div class="official_name">
                                                <small
                                                    class="text-dark"><?php echo htmlspecialchars($row['staff_email']); ?></small>
                                            </div>
                                            <div class="official_name">
                                                <small
                                                    class="text-dark"><?php echo htmlspecialchars($row['staff_contactnumber']); ?></small>
                                            </div>

                                            <div
                                                class="official_status
                                                <?php echo ($row['status'] == 'Inactive') ? 'bg-danger text-white p-1 rounded' : ''; ?>
                                                <?php echo ($row['status'] == 'Active') ? 'bg-success text-white p-1 rounded' : ''; ?>">
                                                <?php echo htmlspecialchars($row['status']); ?>
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
                                    echo '<p class="text-center">No Library Staff found.</p>';
                                }
                                ?>
                            </div>
                        </div>
                        <!-- viewing library staff end-->
                        <?php
                        include '../../connection/dbconnection.php';

                        // Fetch inactive library staff
                        $sql = "SELECT * FROM library_staff WHERE status = 'Inactive'";
                        $result = $conn->query($sql);
                        ?>



                        <!-- Modal -->
                        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false"
                            tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                            <div class="modal-dialog modal-xl">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Inactive Library Staff
                                        </h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <?php
                                            $active = true;
                                            $count = 0;

                                            if ($result->num_rows > 0) {
                                                while ($row = $result->fetch_assoc()) {
                                                    if ($count % 5 == 0) {
                                                        echo '<div class="carousel-item ' . ($active ? 'active' : '') . '">';
                                                        echo '<div class="d-flex flex-wrap justify-content-center gap-4">';
                                                        $active = false;
                                                    }
                                                    ?>
                                                    <div class="management_card">
                                                        <div class="dropdown three-dots">
                                                            <button class="btn p-0 border-0" type="button"
                                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                                <span></span><span></span><span></span>
                                                            </button>
                                                            <ul class="dropdown-menu dropdown-menu-end">
                                                                <li>
                                                                    <a class="dropdown-item edit-btn" href="#"
                                                                        data-bs-toggle="modal" data-bs-target="#editModal"
                                                                        data-id="<?php echo $row['staff_id']; ?>"
                                                                        data-firstname="<?php echo htmlspecialchars($row['staff_firstname']); ?>"
                                                                        data-middlename="<?php echo htmlspecialchars($row['staff_middlename']); ?>"
                                                                        data-lastname="<?php echo htmlspecialchars($row['staff_lastname']); ?>"
                                                                        data-position="<?php echo $row['staff_position']; ?>"
                                                                        data-email="<?php echo $row['staff_email']; ?>"
                                                                        data-contactnumber="<?php echo $row['staff_contactnumber']; ?>"
                                                                        data-status="<?php echo $row['status']; ?>"
                                                                        data-image="<?php echo $row['staff_image']; ?>">
                                                                        Edit
                                                                    </a>
                                                                </li>
                                                                <li>
                                                        <a class="dropdown-item text-danger text-decoration-none"
                                                            href="javascript:void(0);" data-id="<?php echo $row['staff_id']; ?>"
                                                            data-title="<?php echo addslashes($row['staff_firstname'] . ' ' . $row['staff_lastname']); ?>"
                                                            onclick="openDeleteModal(this);">
                                                            Delete
                                                        </a>
                                                    </li>
                                                            </ul>
                                                        </div>
                                                        <img src="<?php echo !empty($row['staff_image']) ? 'assets/uploads/librarystaff_images/' . $row['staff_image'] : 'assets/uploads/librarystaff_images/default.jpg'; ?>"
                                                            alt="Profile Image" class="officials_image">
                                                        <div class="official_name">
                                                            <?php echo htmlspecialchars($row['staff_firstname'] . ' ' . $row['staff_middlename'] . ' ' . $row['staff_lastname']); ?>
                                                        </div>
                                                        <div class="official_name">
                                                            <small
                                                                class="text-dark"><?php echo htmlspecialchars($row['staff_position']); ?></small>
                                                        </div>
                                                        <div class="official_name">
                                                            <small
                                                                class="text-dark"><?php echo htmlspecialchars($row['staff_email']); ?></small>
                                                        </div>
                                                        <div class="official_name">
                                                            <small
                                                                class="text-dark"><?php echo htmlspecialchars($row['staff_contactnumber']); ?></small>
                                                        </div>

                                                        <div
                                                            class="official_status
                                                <?php echo ($row['status'] == 'Inactive') ? 'bg-danger text-white p-1 rounded' : ''; ?>
                                                <?php echo ($row['status'] == 'Active') ? 'bg-success text-white p-1 rounded' : ''; ?>">
                                                            <?php echo htmlspecialchars($row['status']); ?>
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
                                                echo '<p class="text-center">No Inactive Library Staff found.</p>';
                                            }
                                            ?>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <!-- edit modal start -->
                        <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5 text-muted fw-bold" id="exampleModalLabel">Edit
                                            Board of Director</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="function/librarystaff_function.php" method="POST"
                                            enctype="multipart/form-data">
                                            <input type="hidden" name="staff_id" id="editStaffId">

                                            <div class="mb-3 text-center">
                                                <img id="editPreviewImage"
                                                    class="officials_image mt-2 rounded-circle d-block mx-auto" src=""
                                                    width="100" height="100" alt="Current Image">
                                                <label class="form-label fw-semibold text-muted">Upload Image:</label>
                                                <input type="file" name="staff_image" id="editFileInput"
                                                    class="form-control"
                                                    accept="image/jpeg, image/jpg, image/png image/jfif">
                                            </div>

                                            <div class="row mb-3">
                                                <div class="col-md-4">
                                                    <label class="form-label fw-semibold text-muted">First Name:</label>
                                                    <input type="text" name="staff_firstname" id="editFirstName"
                                                        class="form-control" placeholder="Enter Firstname">
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label fw-semibold text-muted">Middle
                                                        Name:</label>
                                                    <input type="text" name="staff_middlename" id="editMiddleName"
                                                        class="form-control" placeholder="Enter Middle Name">
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label fw-semibold text-muted">Last Name:</label>
                                                    <input type="text" name="staff_lastname" id="editLastName"
                                                        class="form-control" placeholder="Enter Last Name">
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <div class="col-md-4">
                                                    <label class="form-label fw-semibold text-muted">Staff
                                                        Position:</label>
                                                    <select class="form-control" id="editStaffPosition"
                                                        name="staff_position" required>
                                                        <option value="" disabled selected>Select Position</option>
                                                        <option value="College Librarian III">College Librarian III
                                                        </option>
                                                        <option value="Graduate Studies Librarian">Graduate Studies
                                                            Librarian</option>
                                                        <option value="College Librarian I">College Librarian I</option>
                                                        <option value="Support Staff">Support Staff</option>
                                                        <option value="Library in-charge">Library in-charge</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label fw-semibold text-muted">Contact
                                                        Number:</label>
                                                    <input type="text" name="staff_contactnumber" id="editContactnumber"
                                                        class="form-control" placeholder="Enter Contact Number">
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label fw-semibold text-muted">Email
                                                        Addres:</label>
                                                    <input type="text" name="staff_email" id="editEmail"
                                                        class="form-control" placeholder="Enter Email Address">
                                                </div>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label fw-semibold text-muted">Status:</label>
                                                <select name="status" id="editStatus" class="form-select">
                                                    <option value="Active">Active</option>
                                                    <option value="Inactive">Inactive</option>
                                                </select>
                                            </div>

                                            <div class="modal-footer">
                                                <button type="submit" name="update_librarystaff"
                                                    class="btn btn-dynamic"><i class="ri-save-fill"></i> Save</button>
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
    <script src="../../assets/bootstrap/js/site_settings.js?v=1.0"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const editButtons = document.querySelectorAll(".edit-btn");

            editButtons.forEach(button => {
                button.addEventListener("click", function () {
                    document.getElementById("editStaffId").value = this.getAttribute("data-id");
                    document.getElementById("editFirstName").value = this.getAttribute("data-firstname");
                    document.getElementById("editMiddleName").value = this.getAttribute("data-middlename");
                    document.getElementById("editLastName").value = this.getAttribute("data-lastname");
                    document.getElementById("editStaffPosition").value = this.getAttribute("data-position");
                    document.getElementById("editEmail").value = this.getAttribute("data-email");
                    document.getElementById("editContactnumber").value = this.getAttribute("data-contactnumber");
                    document.getElementById("editStatus").value = this.getAttribute("data-status");

                    // Handle Image Preview
                    const imageSrc = this.getAttribute("data-image");
                    if (imageSrc) {
                        document.getElementById("editPreviewImage").src = "assets/uploads/librarystaff_images/" + imageSrc;
                    } else {
                        document.getElementById("editPreviewImage").src = "assets/uploads/librarystaff_images/default.jpg";
                    }
                });
            });
        });

        document.getElementById('editFileInput').addEventListener('change', function (event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    document.getElementById('editPreviewImage').src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        });
    </script>
    <!-- end js -->

    <!-- START >> JS SCRIPT IN ALERT -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
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
                case "toast-success": icon.className = "ri-checkbox-circle-line toast-icon"; break;
                case "toast-info": icon.className = "ri-information-line toast-icon"; break;
                case "toast-warning": icon.className = "ri-alert-line toast-icon"; break;
                case "toast-error": icon.className = "ri-close-circle-line toast-icon"; break;
                default: icon.className = "ri-information-line toast-icon"; // Default icon
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
        document.addEventListener("DOMContentLoaded", function () {
            window.openDeleteModal = function (element) {
                var staffId = element.getAttribute('data-id');
                var staffTitle = element.getAttribute('data-title');
                document.getElementById("staffconfirmDelete").setAttribute("href", "function/librarystaff_function.php?delete_id=" + staffId);
                document.getElementById("confirmationModal-staff").style.display = "flex";
            };

            window.closeModal = function () {
                document.getElementById("confirmationModal-staff").style.display = "none";
            };

            window.closeModalOutside = function (event) {
                if (event.target.id === "confirmationModal-staff") {
                    closeModal();
                }
            };
        });
    </script>



</body>

</html>