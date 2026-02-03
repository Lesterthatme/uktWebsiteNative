<?php
include 'include/alert.php';
session_start();
include '../../connection/dbconnection.php';
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
    <title>University of Kratie || Librarian</title>
    <!-- start css  -->
    <link rel="stylesheet" href="../../assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../assets/bootstrap/css/style.css?=v1.3">
    <!-- end css -->
    <!-- Remix icon -->
    <link rel="stylesheet" href="../../assets/RemixIcon/fonts/remixicon.css">
    <link rel="stylesheet" href="assets/library_style/style.css?=v1.1">

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
                    <div class="d-flex flex-wrap justify-content-between align-items-center mb-2">
                            <h5 class="card-title fs-6 mb-2 mb-md-0">Library University Album</h5>
                            <button type="button" class="btn btn-sm rounded-2 px-4 btn-dynamic" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                <i class="ri-add-line"></i> Add Album
                            </button>
                        </div>
                        <p class="card-text text-muted small">This Albums is for Library University Events</p>
                          <!-- modal for adding album start-->
                          <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-xl">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5 text-muted fw-bold" id="exampleModalLabel">Add Album</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="function/libraryalbum_function.php" method="POST" enctype="multipart/form-data">
                                            <div class="mb-3">
                                                <label for="date_created" class="form-label fw-semibold text-muted"><strong>Date:</strong></label>
                                                <input type="date" class="form-control" id="date_created" name="date_created" value="<?php echo date('Y-m-d'); ?>" style="width: 150px;" required>
                                            </div>

                                            <div class="mb-3">
                                                <label for="status" class="form-label fw-semibold text-muted"><strong>Status:</strong></label>
                                                <select class="form-control" id="status" name="status" style="width: 150px;">
                                                    <option value="Active">Active</option>
                                                    <option value="Inactive">Inactive</option>
                                                </select>
                                            </div>

                                            <div class="mb-3">
                                                <label for="libalbum_name" class="form-label fw-semibold text-muted"><strong>Album Name:</strong></label>
                                                <input type="text" class="form-control" id="libalbum_name" name="libalbum_name" placeholder="Enter Album Name" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="album_description" class="form-label fw-semibold text-muted"><strong>Album Description:</strong></label>
                                                <textarea class="form-control" id="libalbum_description" name="libalbum_description" placeholder="Enter Album Name" required></textarea>
                                            </div>

                                            <!-- Image Upload with Preview and Remove Option -->
                                            <div class="mb-3">
                                                <div id="imagePreview" class="mt-3 d-flex flex-wrap"></div>
                                                <label for="images" class="form-label fw-semibold text-muted"><strong>Upload Images:</strong></label>
                                                <input type="file" class="form-control" id="images" name="images[]" multiple accept="image/*" onchange="previewImages()" required>

                                            </div>

                                            <hr>
                                            <button type="submit" name="add_libalbum" class="btn btn-dynamic float-end"><i class="ri-save-line"></i> Save</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                        include("../../connection/dbconnection.php");
                        $query = "SELECT * FROM library_album";
                        $result = mysqli_query($conn, $query);
                        ?>

                        <div class="row">
                            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                                <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                                    <div class="card text-center h-100 shadow"
                                        onclick="window.location='library_images?libalbum_id=<?php echo $row['libalbum_id']; ?>'"
                                        style="cursor: pointer; max-width: 400px; margin: 0 auto;">

                                        <!-- Thumbnail Image -->
                                        <?php
                                        $libalbum_id = $row['libalbum_id'];

                                        // Thumbnail Query
                                        $thumbnail_query = "SELECT libimage_name FROM library_image WHERE libalbum_id = $libalbum_id LIMIT 1";
                                        $thumbnail_result = mysqli_query($conn, $thumbnail_query);
                                        $thumbnail_row = mysqli_fetch_assoc($thumbnail_result);

                                        // Image Count Query
                                        $image_count_query = "SELECT COUNT(*) AS image_count FROM library_image WHERE libalbum_id = $libalbum_id";
                                        $image_count_result = mysqli_query($conn, $image_count_query);
                                        $image_count_row = mysqli_fetch_assoc($image_count_result);
                                        $image_count = $image_count_row['image_count'];

                                        // Image Path & Style
                                        if ($thumbnail_row) {
                                            $thumbnail_path = "assets/uploads/library_gallery/" . $thumbnail_row['libimage_name'];
                                        } else {
                                            $thumbnail_path = "assets/uploads/library_gallery/images/default_image.jpg";
                                        }
                                        ?>
                                        <div style="height: 180px; background: #f8f9fa;">
                                            <img src="<?php echo $thumbnail_path; ?>" class="card-img-top w-100"
                                                alt="Album Thumbnail" style="height: 100%; object-fit: cover;">
                                        </div>

                                        <div class="card-body position-relative p-2 d-flex flex-column">
                                            <!-- Dropdown -->
                                            <div class="dropdown position-absolute top-0 end-0 m-2">
                                                <button class="btn btn-light btn-sm" type="button" data-bs-toggle="dropdown" onclick="event.stopPropagation();">
                                                    <i class="ri-more-2-fill"></i>
                                                </button>
                                                <ul class="dropdown-menu" onclick="event.stopPropagation();">
                                                <li>
                                                        <a href="#editModal<?php echo $row['libalbum_id']; ?>" class="dropdown-item text-warning"
                                                            data-bs-toggle="modal">Edit Album</a>
                                                    </li>
                                                    <li>
                                                    <a class="dropdown-item text-danger delete-program"
                                                            href="function/libraryalbum_function.php?libalbum_id=<?= $row['libalbum_id'] ?>"
                                                            onclick="event.stopPropagation(); return confirm('Are you sure you want to delete this album?')">
                                                            Delete Album
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>

                                            <div class="text-start flex-grow-1">
                                                <h6 class="card-title"><?php echo ($row['libalbum_name']); ?></h6>
                                                <small class="text-justify text-muted d-block"><?php echo ($row['libalbum_description']); ?></small>
                                                <p class="text-muted" style="font-size: 13px;">
                                                    <?php
                                                    if ($image_count == 0) {
                                                        echo "No image";
                                                    } elseif ($image_count == 1) {
                                                        echo "1 Item";
                                                    } else {
                                                        echo "$image_count Items";
                                                    }
                                                    ?>
                                                </p>
                                            </div>

                                            <!-- STATUS BADGE + DATE (Left-Aligned, at Bottom) -->
                                            <div class="mt-auto text-start">
                                                <span class="badge <?php echo ($row['status'] === 'Active') ? 'bg-success' : 'bg-danger'; ?>">
                                                    <?php echo ($row['status']); ?>
                                                </span>
                                                <br>
                                                <small class="card-text">Created on: <?php echo date("F d, Y", strtotime($row['date_created'])); ?></small>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <!-- EDIT album START-->
                                <div class="modal fade" id="editModal<?php echo $row['libalbum_id']; ?>" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title fw-bold">Update Album</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="function/libraryalbum_function.php" method="POST" enctype="multipart/form-data">
                                                    <input type="hidden" name="libalbum_id" value="<?php echo $row['libalbum_id']; ?>">
                                                    <div class="mb-3">
                                                        <label for="date_added" class="form-label"><strong>Date</strong></label>
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
                                                        <label for="requirement_title" class="form-label"><strong>Album Name</strong></label>
                                                        <input type="text" class="form-control"
                                                            name="libalbum_name" value="<?php echo htmlspecialchars($row['libalbum_name']); ?>"
                                                            required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="album_description" class="form-label"><strong>Album Description</strong></label>
                                                        <textarea class="form-control" name="libalbum_description" rows="4" required><?php echo htmlspecialchars($row['libalbum_description']); ?></textarea>

                                                    </div>
                                                    <hr>
                                                    <div class="modal-footer">
                                                        <button type="submit" name="update_libalbum" class="btn btn-dynamic"><i class="ri-save-line"></i>Update Album</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- EDIT ADMISSION END-->
                            <?php endwhile; ?>
                        </div>

                        <!-- Modal for edit library profile end-->
                    </div>

                </div>
            </div>
            <?php include 'include/footer.php'; ?>
        </div>
    </main>

    <!-- start js -->
    <script src="../../assets/script.js"></script> <!-- this script is for disabling multiple login in session -->
    <script src="https://cdn.jsdelivr.net/npm/quill@1.3.6/dist/quill.min.js"></script>
    <script src="../../assets/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../../assets/bootstrap/js/jquery-3.7.1.js"></script>
    <script src="../../assets/bootstrap/js/script.js"></script>
    <script src="../../assets/bootstrap/js/page_poster.js"></script>
    <script src="../../assets/bootstrap/js/drag_and_drop.js?=1.1"></script>
    <script src="../../assets/bootstrap/js/activeLink.js?v=1.3"></script>
    <script src="../../assets/bootstrap/js/table.js"></script>
    <script src="../../assets/bootstrap/js/site_settings.js?v=1.0"></script>

    <script>
        function previewImages() {
            const previewContainer = document.getElementById('imagePreview');
            const fileInput = document.getElementById('images');
            const files = fileInput.files;

            previewContainer.innerHTML = ''; // Clear previous previews

            for (let i = 0; i < files.length; i++) {
                const file = files[i];

                if (file.type.startsWith('image/')) {
                    const reader = new FileReader();

                    reader.onload = function(e) {
                        const imageWrapper = document.createElement('div');
                        imageWrapper.classList.add('position-relative', 'm-2');
                        imageWrapper.style.width = '100px';
                        imageWrapper.style.height = '100px';

                        const imgElement = document.createElement('img');
                        imgElement.src = e.target.result;
                        imgElement.style.width = '100%';
                        imgElement.style.height = '100%';
                        imgElement.style.objectFit = 'cover';
                        imgElement.style.borderRadius = '8px';
                        imgElement.style.border = '2px solid #ddd';

                        const removeButton = document.createElement('span');
                        removeButton.innerHTML = '&times;';
                        removeButton.classList.add('position-absolute', 'top-0', 'end-0', 'bg-danger', 'text-white', 'rounded-circle', 'px-2', 'py-0', 'fw-bold');
                        removeButton.style.cursor = 'pointer';

                        removeButton.onclick = function() {
                            imageWrapper.remove();
                            removeFile(i); // Remove file from FileList
                        };

                        imageWrapper.appendChild(imgElement);
                        imageWrapper.appendChild(removeButton);
                        previewContainer.appendChild(imageWrapper);
                    };

                    reader.readAsDataURL(file);
                }
            }
        }

        function removeFile(index) {
            const dt = new DataTransfer();
            const input = document.getElementById('images');
            const {
                files
            } = input;

            for (let i = 0; i < files.length; i++) {
                if (i !== index) {
                    dt.items.add(files[i]);
                }
            }

            input.files = dt.files; // Update the input's files
        }
    </script>

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

</body>

</html>