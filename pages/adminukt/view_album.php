<?php
include 'include/session.php';


// Get album_id from URL
if (!isset($_GET['album_id']) || empty($_GET['album_id'])) {
    echo "Invalid album.";
    exit;
}

$album_id = intval($_GET['album_id']);


// Fetch album details
$album_query = "SELECT * FROM university_album WHERE album_id = $album_id";
$album_result = mysqli_query($conn, $album_query);
$album = mysqli_fetch_assoc($album_result);

if (!$album) {
    echo "Album not found.";
    exit;
}

// Fetch images under this album
$image_query = "SELECT image_id, image_name, upload_date FROM university_image WHERE album_id = $album_id";
$image_result = mysqli_query($conn, $image_query);


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
</head>

<body class="bg-light">
    <?php include 'include/alert.php'; ?>
    <?php include 'include/sidebar.php'; ?>
    <?php include 'confirmation.php'; ?>

    <main class="bg-light">
        <?php include 'include/navbar.php'; ?>
        <div class="p-4">
            <div class="card border-0 pb-5 ps-5 pe-5">
                <div class="card-body">
                    <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
                        <h5 class="mb-0"><?php echo htmlspecialchars($album['album_name']); ?></h5>
                        <div class="d-flex gap-2"> <!-- Added div to wrap buttons -->
                            <a href="university_album" class="btn btn-sm rounded-2 px-4 btn-outline-secondary"
                                data-bs-toggle="tooltip" data-bs-placement="top" title="Back to the album"><i class="ri-arrow-left-line"></i>
                                Back
                            </a>

                            <button type="button" class="btn btn-sm rounded-2 px-4 btn-dynamic" data-bs-toggle="modal"
                                data-bs-target="#exampleModal" data-bs-toggle="tooltip" data-bs-placement="top"
                                title="Click to add a new photo">
                                <i class="ri-add-line"></i> Add Photo
                            </button>

                            <button class="btn btn-dynamic btn-sm rounded-2 px-4" data-bs-toggle="modal" data-bs-target="#exampleModal1" data-bs-toggle="tooltip" data-bs-placement="top"
                                title="Click to add a new video">
                                <i class="ri-add-line pe-1"></i>Add Video
                            </button>
                        </div>
                    </div>
                    <small>Created on: <?php echo date("F d, Y", strtotime($album['date_created'])); ?></small>
                    <!-- modal for adding photo start-->
                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-xl">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5 text-muted fw-bold" id="exampleModalLabel">Add Photo</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-title="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="../../function/album_function.php?loc=adminukt" method="POST" enctype="multipart/form-data">
                                        <input type="hidden" name="album_id" value="<?php echo isset($_GET['album_id']) ? $_GET['album_id'] : ''; ?>">

                                        <div class="mb-3">
                                            <label for="date_added" class="form-label fw-semibold text-muted"><strong>Date:</strong></label>
                                            <input type="date" class="form-control" id="date_created" name="date_created" value="<?php echo date('Y-m-d'); ?>" style="width: 150px;" required>
                                        </div>
                                        <div class="mb-3">
                                            <div id="imagePreview" class="mt-3 d-flex flex-wrap"></div>
                                            <label for="images" class="form-label fw-semibold text-muted"><strong>Upload Images:</strong></label>
                                            <input type="file" class="form-control" id="images" name="images[]" multiple accept="image/*" onchange="previewImages()" required>
                                        </div>
                                        <hr>
                                        <button type="submit" name="add_photo" class="btn btn-dynamic float-end" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-title="Save"><i class="ri-save-line"></i> Save</button>
                                    </form>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- modal for adding photo end-->
                    <!-- modal for adding video start-->
                    <div class="modal fade" id="exampleModal1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-xl">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5 text-muted fw-bold" id="exampleModalLabel">Add Video</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-title="Close"></button>
                                </div>
                                <div class="modal-body">

                                    <form action="../../function/album_function.php?loc=adminukt" method="POST">

                                        <div class="mb-3">
                                            <label for="date_added" class="form-label fw-semibold text-muted"><strong>Date:</strong></label>
                                            <input type="date" class="form-control" id="date_created" name="date_created" value="<?php echo date('Y-m-d'); ?>" style="width: 150px;" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold text-muted">Add YouTube link</label>

                                            <div id="link-container">
                                                <div class="input-group mb-2 link-row">
                                                    <input type="text" class="form-control link-input" name="link[]" placeholder="Paste YouTube link" required>
                                                    <button type="button" class="btn btn-danger remove-btn" style="display:none;">Remove</button>
                                                </div>
                                            </div>

                                            <button type="button" id="add-link-btn" class="btn btn-sm btn-primary" style="display:none;">
                                                + Add New Link
                                            </button>
                                        </div>
                                        <hr>
                                        <button type="submit" name="add_video" value="<?= $album_id ?>" class="btn btn-dynamic float-end" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-title="Save"><i class="ri-save-line"></i> Save</button>
                                    </form>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- modal for adding video end-->
                </div>
                <div class="row mt-3">
                    <!-- video view -->
                    <div class="container gap-2 mb-2">
                        <div class="row">
                            <?php
                            $videoLink = $conn->prepare("SELECT * FROM university_video WHERE album_id = ?");
                            $videoLink->bind_param('s', $album_id);
                            $videoLink->execute();
                            $result2 = $videoLink->get_result();

                            while ($row = $result2->fetch_assoc()) {
                                // Get YouTube link from DB
                                $video_url = $row['video_link'];

                                // Extract VIDEO ID
                                parse_str(parse_url($video_url, PHP_URL_QUERY), $params);
                                $video_id = $params['v'] ?? '';

                                // Create embed link
                                $embed_url = "https://www.youtube.com/embed/" . $video_id;
                            ?>

                                <div class="col-12 col-sm-12 col-md-6 col-lg-4 ">
                                    <div class="ratio ratio-21x9 ">
                                        <iframe src="<?php echo $embed_url; ?>"
                                            title="YouTube video"
                                            allowfullscreen
                                            style="border-radius: 10px;">
                                        </iframe>
                                        <!-- Trash Icon -->
                                        <button
                                            class="delete-btn"
                                            data-bs-toggle="tooltip"
                                            data-bs-placement="bottom"
                                            data-bs-title="Delete Image"
                                            onclick="deleteVideo(<?= $row['video_id'] ?>, <?= $album_id ?>)"

                                            style="
                                        position: absolute; 
                                        top: 5px; 
                                        right: 5px; 
                                        background-color: rgba(0, 0, 0, 0.6); 
                                        color: #fff; 
                                        border: none; 
                                        border-radius: 50%; 
                                        width: 30px; 
                                        height: 30px; 
                                        display: flex; 
                                        align-items: center; 
                                        justify-content: center;
                                        cursor: pointer;">
                                            <i class="ri-delete-bin-line"></i>
                                        </button>
                                    </div>

                                </div>
                            <?php
                            }
                            ?>
                        </div>
                    </div>
                    <!-- end video view -->

                    <!-- image view -->
                    <div class="d-flex flex-wrap gap-2">
                        <?php
                        $images = [];
                        if (mysqli_num_rows($image_result) > 0) {
                            while ($image = mysqli_fetch_assoc($image_result)) {
                                $image_path = "../../assets/uploads/university_gallery/" . $image['image_name'];
                                $image_id = $image['image_id']; // Assuming `image_id` exists in your table
                                $images[] = $image_path;
                        ?>
                                <div style="position: relative; width: 200px; height: 200px;">
                                    <img src="<?php echo $image_path; ?>"
                                        class="gallery-image"
                                        data-index="<?php echo count($images) - 1; ?>"
                                        style="width: 100%; height: 100%; object-fit: cover; border-radius: 8px; cursor: pointer;">

                                    <!-- Trash Icon -->
                                    <button
                                        class="delete-btn"
                                        data-bs-toggle="tooltip"
                                        data-bs-placement="bottom"
                                        data-bs-title="Delete Image"
                                        onclick="deleteImage(<?php echo $image_id; ?>, <?= $album_id ?>)"
                                        style="
                                        position: absolute; 
                                        top: 5px; 
                                        right: 5px; 
                                        background-color: rgba(0, 0, 0, 0.6); 
                                        color: #fff; 
                                        border: none; 
                                        border-radius: 50%; 
                                        width: 30px; 
                                        height: 30px; 
                                        display: flex; 
                                        align-items: center; 
                                        justify-content: center;
                                        cursor: pointer;">
                                        <i class="ri-delete-bin-line"></i>
                                    </button>
                                </div>
                        <?php
                            }
                        } else {
                            echo "<p class='text-center text-muted'>No images found in this album.</p>";
                        }
                        ?>
                    </div>
                    <!-- end image view -->
                </div>


                <!-- Store image data in JavaScript -->
                <script>
                    const images = <?php echo json_encode($images); ?>;
                </script>

            </div>

            <?php include 'include/footer.php'; ?>
        </div>
        <!-- Image Popup Modal -->
        <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-fullscreen">
                <div class="modal-content bg-black">
                    <div class="modal-body d-flex justify-content-center align-items-center position-relative" style="height: 100vh;">

                        <!-- Close 'X' Button -->
                        <button id="closeModal" class="btn btn-secondary position-absolute top-0 end-0 m-3"
                            style="z-index: 10; width: 40px; height: 40px; border-radius: 50%;">
                            <i class="ri-close-large-line"></i>
                        </button>

                        <!-- Left Arrow -->
                        <button id="prevImage" class="btn btn-dark position-absolute start-0 top-50 translate-middle-y"
                            style="z-index: 10; width: 60px; height: 60px; border-radius: 50%;">
                            <i class="ri-arrow-left-s-line fs-2"></i>
                        </button>

                        <!-- Image -->
                        <img id="modalImage" src="" class="img-fluid" style="max-height: 90vh; max-width: 90vw;" alt="Image">

                        <!-- Right Arrow -->
                        <button id="nextImage" class="btn btn-dark position-absolute end-0 top-50 translate-middle-y"
                            style="z-index: 10; width: 60px; height: 60px; border-radius: 50%;">
                            <i class="ri-arrow-right-s-line fs-2"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </main>
    <script src="../../assets/bootstrap/js/Logs.js?v=1.1"></script>
    <script src="../../assets/bootstrap/js/site_settings.js"></script>
    <script src="../../assets/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../../assets/bootstrap/js/jquery-3.7.1.js"></script>
    <script src="../../assets/bootstrap/js/script.js"></script>
    <script src="../../assets/bootstrap/js/carousel2itemslide.js?=v1.7"></script>
    <script src="../../assets/bootstrap/js/drag_and_drop.js?=v1.0"></script>
    <script src="../../assets/bootstrap/js/activeLink.js?=v1.6"></script>

    <!-- SCRIPT FOR PREVIEW OF THE IMAGE -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const modalImage = document.getElementById('modalImage');
            const modal = new bootstrap.Modal(document.getElementById('imageModal'));
            const closeModal = document.getElementById('closeModal');
            let currentIndex = 0;

            // Show image in modal when clicked
            document.querySelectorAll('.gallery-image').forEach(image => {
                image.addEventListener('click', function() {
                    currentIndex = parseInt(this.getAttribute('data-index'));
                    modalImage.src = images[currentIndex];
                    modal.show();
                });
            });

            // Next Image
            document.getElementById('nextImage').addEventListener('click', function() {
                currentIndex = (currentIndex + 1) % images.length;
                modalImage.src = images[currentIndex];
            });

            // Previous Image
            document.getElementById('prevImage').addEventListener('click', function() {
                currentIndex = (currentIndex - 1 + images.length) % images.length;
                modalImage.src = images[currentIndex];
            });

            // Close Modal (when 'X' is clicked)
            closeModal.addEventListener('click', function() {
                modal.hide();
            });

            // Close modal on outside click
            document.getElementById('imageModal').addEventListener('click', function(event) {
                if (event.target === this) {
                    modal.hide();
                }
            });
        });
    </script>
    <script>
        function previewImages() {
            const previewContainer = document.getElementById('imagePreview');
            const fileInput = document.getElementById('images');
            const files = fileInput.files;
            const maxSize = 25 * 1024 * 1024; // 25MB limit for each image

            previewContainer.innerHTML = '';
            for (let i = 0; i < files.length; i++) {
                const file = files[i];

                if (file.type.startsWith('image/')) {
                    if (file.size > maxSize) {
                        swal({
                            title: "File Too Large!",
                            text: "Some picture size exceeds 25MB! Please check the image size and upload it again.",
                            icon: "warning",
                            button: "OK",
                        }).then(() => {
                            location.reload(); // Reloads the page after clicking OK
                        });
                        return;
                    }

                    const reader = new FileReader();

                    const imageWrapper = document.createElement('div');
                    imageWrapper.classList.add('position-relative', 'm-2', 'd-flex', 'align-items-center', 'justify-content-center');
                    imageWrapper.style.width = '100px';
                    imageWrapper.style.height = '100px';
                    imageWrapper.style.border = '2px solid #ddd';
                    imageWrapper.style.borderRadius = '8px';
                    imageWrapper.style.overflow = 'hidden';

                    const spinner = document.createElement('div');
                    spinner.className = 'spinner-border text-secondary';
                    spinner.setAttribute('role', 'status');
                    spinner.style.width = '2rem';
                    spinner.style.height = '2rem';

                    imageWrapper.appendChild(spinner);
                    previewContainer.appendChild(imageWrapper);

                    reader.onload = function(e) {

                        const imgElement = document.createElement('img');
                        imgElement.src = e.target.result;
                        imgElement.style.width = '100%';
                        imgElement.style.height = '100%';
                        imgElement.style.objectFit = 'cover';
                        imgElement.style.position = 'absolute';
                        imgElement.style.top = '0';
                        imgElement.style.left = '0';

                        const removeButton = document.createElement('span');
                        removeButton.innerHTML = '&times;';
                        removeButton.classList.add('position-absolute', 'top-0', 'end-0', 'bg-danger', 'text-white', 'rounded-circle', 'px-2', 'py-0', 'fw-bold');
                        removeButton.style.cursor = 'pointer';

                        removeButton.onclick = function() {
                            imageWrapper.remove();
                        };

                        imageWrapper.innerHTML = '';
                        imageWrapper.appendChild(imgElement);
                        imageWrapper.appendChild(removeButton);
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
    <!-- end SCRIPT FOR PREVIEW OF THE IMAGE -->
    <!-- script for deleting image start -->
    <script>
        function deleteImage(imageId, id) {
            if (confirm('Are you sure you want to delete this image?')) {
                window.location.href = `../../function/album_function.php?delete_image=${imageId}&loc=adminukt&id=${id}`;
            }
        }

        function deleteVideo(videoId, id) {
            if (confirm('Are you sure you want to delete this image?')) {
                window.location.href = `../../function/album_function.php?delete_video=${videoId}&loc=adminukt&id=${id}`;
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.forEach(function(tooltipTriggerEl) {
                new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });
    </script>
    <!-- script for deleting image end -->

    <!-- script for adding new input for youtube link -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const container = document.getElementById("link-container");
            const addBtn = document.getElementById("add-link-btn");

            // Show "Add New Link" when user types
            container.addEventListener("input", function(e) {
                if (e.target.classList.contains("link-input")) {
                    if (e.target.value.trim() !== "") {
                        addBtn.style.display = "inline-block";
                    }
                }
            });

            // Add new input field
            addBtn.addEventListener("click", function() {
                const newRow = document.createElement("div");
                newRow.classList.add("input-group", "mb-2", "link-row");

                newRow.innerHTML = `
            <input type="text" class="form-control link-input" name="link[]" placeholder="Paste YouTube link" required>
            <button type="button" class="btn btn-danger remove-btn">Remove</button>
        `;

                container.appendChild(newRow);
            });

            // Remove input field
            container.addEventListener("click", function(e) {
                if (e.target.classList.contains("remove-btn")) {
                    e.target.parentElement.remove();
                }
            });
        });
    </script>
    <!-- end of script for adding new input for youtube link -->

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