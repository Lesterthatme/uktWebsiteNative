<?php
include 'include/alert.php';
session_start();
include 'confirmation.php';
include("../../connection/dbconnection.php");

if (!isset($_SESSION['user_id'])) {
    header('location:login.php');
    exit;
}

if (!isset($_SESSION['session_token'])) {
    header('location:login.php');
    exit;
}

// Get album_id from URL
if (!isset($_GET['libalbum_id']) || empty($_GET['libalbum_id'])) {
    echo "Invalid album.";
    exit;
}

$libalbum_id = intval($_GET['libalbum_id']);

// Fetch album details
$album_query = "SELECT libalbum_name, date_created FROM library_album WHERE libalbum_id = $libalbum_id";
$album_result = mysqli_query($conn, $album_query);
$album = mysqli_fetch_assoc($album_result);

if (!$album) {
    echo "Library Album not found.";
    exit;
}

// Fetch images under this album
$image_query = "SELECT libimage_id, libimage_name, upload_date FROM library_image WHERE libalbum_id = $libalbum_id";
$image_result = mysqli_query($conn, $image_query);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/png" href="../../assets/images/officiallogo (1).png" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>University of Kratie || Admin</title>
    <link rel="stylesheet" href="../../assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../assets/bootstrap/css/style.css">
    <link rel="stylesheet" href="../../assets/RemixIcon/fonts/remixicon.css">
</head>

<body class="bg-light">

    <?php include 'include/sidebar.php'; ?>

    <main class="bg-light">
        <?php include 'include/navbar.php'; ?>
        <div class="p-4">
            <div class="card border-0 pb-5 ps-5 pe-5">
                <div class="card-body">
                    <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
                        <h5 class="mb-0"><?php echo htmlspecialchars($album['libalbum_name']); ?></h5>

                        <button type="button" 
                                class="btn btn-sm rounded-2 px-4 btn-dynamic" 
                                data-bs-toggle="modal"
                                data-bs-target="#exampleModal"
                                data-bs-toggle="tooltip" 
                                data-bs-placement="top" 
                                title="Click to add a new photo">
                            <i class="ri-add-line"></i> Add Photo
                        </button>
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
                                    <form action="function/libraryalbum_function.php" method="POST" enctype="multipart/form-data">
                                        <input type="hidden" name="libalbum_id" value="<?php echo isset($_GET['libalbum_id']) ? $_GET['libalbum_id'] : ''; ?>">

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
                                        <button type="submit" name="add_libphoto" class="btn btn-dynamic float-end" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-title="Save"><i class="ri-save-line"></i> Save</button>
                                    </form>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- modal for adding photo end-->
                </div>

                <div class="row mt-3">
                    <div class="d-flex flex-wrap gap-2">
                        <?php
                        $images = [];
                        if (mysqli_num_rows($image_result) > 0) {
                            while ($image = mysqli_fetch_assoc($image_result)) {
                                $image_path = "assets/uploads/library_gallery/" . $image['libimage_name'];
                                $libimage_id = $image['libimage_id']; // Assuming `image_id` exists in your table
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
                                        onclick="deleteImage(<?php echo $libimage_id; ?>)"
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
    <script src="../../assets/bootstrap/js/activeLink.js?=v1.0"></script>

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
    <!-- script for deleting image start -->
    <script>
        function deleteImage(imageId) {
            if (confirm('Are you sure you want to delete this image?')) {
                window.location.href = `function/libraryalbum_function.php?delete_image=${imageId}`;
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.forEach(function(tooltipTriggerEl) {
                new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });

        document.addEventListener('DOMContentLoaded', function () {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
    </script>

    <!-- script for deleting image end -->
</body>

</html>