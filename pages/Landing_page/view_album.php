<?php
include("connection/dbconnection.php");

// Get album_id from URL
if (!isset($_GET['album_id']) || empty($_GET['album_id'])) {
    echo "Invalid album.";
    exit;
}

$album_id = intval($_GET['album_id']);

// Fetch album details
$album_query = "SELECT album_name, date_created FROM university_album WHERE album_id = $album_id";
$album_result = mysqli_query($conn, $album_query);
$album = mysqli_fetch_assoc($album_result);

if (!$album) {
    echo "Album not found.";
    exit;
}

// Fetch images under this album
$image_query = "SELECT image_id, image_name, upload_date FROM university_image WHERE album_id = $album_id";
$image_result = mysqli_query($conn, $image_query);

?>
<style>
    .view_album_banner {
        position: relative;
        height: 45vh;
        background: linear-gradient(to right, rgba(78, 78, 78, 0.64), rgba(0, 70, 0, 0.57)), url('assets/images/aboutunivprofile.png');
        background-size: cover;
        background-position: center;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center ;
        padding: 20px;
        background-attachment: fixed;
    }

    .banner-content {
        max-width: 700px;
    }

   .view-banner-tag {
        background: white;
        color: darkgreen;
        padding: 5px 10px;
        font-weight: bold;
        display: inline-block;
        border-radius: 5px;
    }

    .view_album_banner-updated {
      
        padding-left: 15px;
        margin-top: 15px;
    }
    .gallery-breadcrumb-section {
      background-color: #fff;
      width: 100%;
      box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
      padding: 16px 0;
    }

    .gallery-breadcrumb-wrapper {
      padding: 0 15px;
    }

    .gallery-custom-breadcrumb {
      font-size: 14px;
      color: #6c757d;
      margin-bottom: 0;
      display: flex;
      align-items: center;
      flex-wrap: wrap;
      gap: 6px;
    }

    .gallery-breadcrumb-link {
      color: #6c757d;
      text-decoration: none;
      padding: 6px 8px;
      border-radius: 8px;
      transition: color 0.2s ease-in-out;
      font-weight: 500;
    }

    .gallery-breadcrumb-link:hover {
      color: #14532d;
    }

    .gallery-breadcrumb-active {
      color: #6c757d; /* Secondary color */
      font-weight: 600; /* Semibold */
      cursor: default;
      text-decoration: none;
    }

    .gallery-separator-icon {
      font-size: 16px;
      color: #adb5bd;
    }

    @media (max-width: 576px) {
      .gallery-custom-breadcrumb {
        font-size: 13px;
        gap: 4px;
      }
    }
    
</style>
<?php
include 'connection/dbconnection.php';
$sql = "SELECT site_banner FROM site_settings";
$result = $conn->query($sql);

$site_banner = ''; // default value
if ($result && $result->num_rows > 0) {
    $settings = $result->fetch_assoc();
    $site_banner = 'assets/uploads/site settings/website banner/' . htmlspecialchars($settings['site_banner']);
}
?>
<section class="view_album_banner" style="background-image: linear-gradient(to right, rgba(78, 78, 78, 0.64), rgba(0, 70, 0, 0.57)), url('<?php echo $site_banner; ?>');">
    <div class="view-banner-content">
        <span class="view-banner-tag" data-aos="fade-down">Bulletin</span>
        <h3 class="mt-3 fw-bold view_album-h1" data-aos="fade-up" data-aos-delay="200" style="font-size:3rem"><?=htmlspecialchars($album['album_name']) ?></h3>
        <p class="view_album_banner-updated" data-aos="fade-up" data-aos-delay="400">Know more about our university.</p>
    </div>
</section>

<div class="container-fluid gallery-breadcrumb-section">
    <div class="container gallery-breadcrumb-wrapper">
      <nav aria-label="breadcrumb">
        <div class="gallery-custom-breadcrumb">
            <a href="gallery" class="gallery-breadcrumb-link">Home</a> 
            <i class="ri-arrow-right-s-line gallery-separator-icon"></i>
            <a href="university_gallery" class="gallery-breadcrumb-link">University Gallery</a>
            <i class="ri-arrow-right-s-line gallery-separator-icon"></i>
            <span class="gallery-breadcrumb-active"><?=htmlspecialchars($album['album_name']) ?></span>
        </div>
      </nav>
    </div>
</div>

<div class="container">
    <div class="bg-light p-4 my-5 rounded-3">
        <div class="row mt-3">
            <div class="d-flex flex-wrap gap-2 justify-content-center">
                <?php
                $images = [];
                if (mysqli_num_rows($image_result) > 0) {
                    while ($image = mysqli_fetch_assoc($image_result)) {
                        $image_path = "assets/uploads/university_gallery/" . $image['image_name'];
                        $image_id = $image['image_id'];
                        $images[] = $image_path;
                        ?>
                        <div style="position: relative; width: 200px; height: 200px;">
                            <img src="<?php echo $image_path; ?>" class="gallery-image"
                                data-index="<?php echo count($images) - 1; ?>"
                                style="width: 100%; height: 100%; object-fit: cover; border-radius: 8px; cursor: pointer;">
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
</div>


<!-- Image Popup Modal -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content bg-black">
            <div class="modal-body d-flex justify-content-center align-items-center position-relative"
                style="height: 100vh;">

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

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const modalImage = document.getElementById('modalImage');
            const modal = new bootstrap.Modal(document.getElementById('imageModal'));
            const closeModal = document.getElementById('closeModal');
            let currentIndex = 0;

            // Show image in modal when clicked
            document.querySelectorAll('.gallery-image').forEach(image => {
                image.addEventListener('click', function () {
                    currentIndex = parseInt(this.getAttribute('data-index'));
                    modalImage.src = images[currentIndex];
                    modal.show();
                });
            });

            // Next Image
            document.getElementById('nextImage').addEventListener('click', function () {
                currentIndex = (currentIndex + 1) % images.length;
                modalImage.src = images[currentIndex];
            });

            // Previous Image
            document.getElementById('prevImage').addEventListener('click', function () {
                currentIndex = (currentIndex - 1 + images.length) % images.length;
                modalImage.src = images[currentIndex];
            });

            // Close Modal (when 'X' is clicked)
            closeModal.addEventListener('click', function () {
                modal.hide();
            });

            // Close modal on outside click
            document.getElementById('imageModal').addEventListener('click', function (event) {
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

                    reader.onload = function (e) {

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

                        removeButton.onclick = function () {
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
    <!-- script for deleting image start -->
    <script>
        function deleteImage(imageId) {
            if (confirm('Are you sure you want to delete this image?')) {
                window.location.href = `../../function/album_function.php?delete_image=${imageId}`;
            }
        }

        document.addEventListener('DOMContentLoaded', function () {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.forEach(function (tooltipTriggerEl) {
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