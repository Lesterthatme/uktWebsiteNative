<?php
session_start();
include '../../connection/dbconnection.php';

// Query to get the university profile data
$query = "SELECT comlab_description FROM computer_laboratory WHERE up_id = 1";
$result = mysqli_query($conn, $query);
$comlab_data = mysqli_fetch_assoc($result);

$comlab_description = $comlab_data['comlab_description'] ?? 'No description available.';


// Get the image from universityprofile_image
$imgQuery = "SELECT comlab_image FROM computer_laboratory_image";
$imgResult = mysqli_query($conn, $imgQuery);

$comlab_images = [];
if ($imgResult && mysqli_num_rows($imgResult) > 0) {
    while ($row = mysqli_fetch_assoc($imgResult)) {
        $comlab_images[] = $row['comlab_image'];
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
    <link rel="stylesheet" href="../../assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../assets/bootstrap/css/style.css?=v1.4">
    <link rel="stylesheet" href="../../assets/RemixIcon/fonts/remixicon.css">
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-lite.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-lite.min.js"></script>
</head>

<body class="bg-light">

    <!-- include side bar start -->
    <?php include 'include/alert.php'; ?>
    <?php include 'include/alert.php'; ?>
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
                            <h5 class="card-title fs-6 mb-2 mb-md-0">Manage Computer Laboratory</h5>
                            <!-- Dropdown Actions -->
                            <div class="dropdown">
                                <button class="btn btn-light btn-sm" type="button" data-bs-toggle="dropdown" title="Click here to see the action">
                                    <i class="ri-more-2-fill"></i>
                                </button>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="#add_image" class="dropdown-item text-dark" data-bs-toggle="modal"
                                            data-bs-placement="top" title="Click to add comlab image" data-bs-toggle="tooltip">
                                            <i class="ri-add-line"></i> Add computer lab. image
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#comlab_description" class="dropdown-item text-dark" data-bs-toggle="modal"
                                            data-bs-placement="top" title="Click to update comlab description" data-bs-toggle="tooltip">
                                            <i class="ri-pencil-line"></i> Edit computer lab. description
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <!-- viewing comlab start -->
                        <div class="container text-center pt-0">
                            <div class="row justify-content-center">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-6" style="max-height: 500px; overflow-y: auto;">
                                            <p><?php echo $comlab_description; ?></p>
                                        </div>

                                        <!-- Right: Image Carousel start-->
                                        <div class="col-md-6">
                                            <div id="labCarousel" class="carousel slide" data-bs-ride="carousel">
                                                <div class="carousel-inner">
                                                    <?php if (!empty($comlab_images)): ?>
                                                        <?php foreach ($comlab_images as $index => $image): ?>
                                                            <div class="carousel-item <?php echo $index === 0 ? 'active' : ''; ?>">

                                                                <!-- Trash Icon Button -->
                                                                <form action="../../functio/comlab_function.php" method="POST"
                                                                style="position: absolute; top: 10px; right: 10px; z-index: 10;">
                                                                <input type="hidden" name="comlab_image" value="<?php echo htmlspecialchars($image); ?>">

                                                                <button type="submit" name="delete_comlab_image"
                                                                    class="btn btn-dark rounded-circle d-flex align-items-center justify-content-center p-2 mt-3"
                                                                    style="width: 40px; height: 40px;"
                                                                    onclick="return confirm('Are you sure you want to delete this image?');"
                                                                    data-bs-toggle="tooltip" data-bs-placement="top" title="Delete this image">
                                                                    <i class="ri-delete-bin-line"></i>
                                                                </button>
                                                            </form>

                                                                <img src="../../assets/uploads/computer laboratory/<?php echo htmlspecialchars($image); ?>"
                                                                    class="d-block w-100 img-fluid rounded border mt-3"
                                                                    alt="Lab Image <?php echo $index + 1; ?>"
                                                                    style="height: 400px; object-fit: cover;" data-bs-toggle="modal"
                                                                    data-bs-target="#imageModal"
                                                                    onclick="showImageInModal(this.src)">
                                                            </div>
                                                        <?php endforeach; ?>
                                                    <?php else: ?>
                                                        <!-- Fallback for no image -->
                                                        <div class="carousel-item active text-center">
                                                            <img src="../../assets/uploads/no-image.png"
                                                                class="d-block w-100 img-fluid rounded border mt-3"
                                                                alt="No Image Available"
                                                                style="height: 400px; object-fit: contain;">
                                                            <p class="mt-2">No Image Available</p>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>

                                                <!-- Carousel Controls -->
                                                <?php if (!empty($comlab_images) && count($comlab_images) > 1): ?>
                                                    <button class="carousel-control-prev" type="button" data-bs-target="#labCarousel" data-bs-slide="prev">
                                                        <span class="carousel-control-prev-icon"></span>
                                                    </button>
                                                    <button class="carousel-control-next" type="button" data-bs-target="#labCarousel" data-bs-slide="next">
                                                        <span class="carousel-control-next-icon"></span>
                                                    </button>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        <!-- Right: Image Carousel end-->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- viewing comlab end -->

                        <!-- Modal for Viewing Full Image -->
                        <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                <div class="modal-content bg-transparent border-0">
                                    <div class="modal-body text-center p-0">
                                        <img id="modalImage" src="" class="img-fluid rounded shadow" style="max-height: 80vh; object-fit: contain;" alt="Full Image">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal for adding comlab image start-->
                        <div class="modal fade" id="add_image" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-xl">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5 text-muted fw-bold" id="exampleModalLabel">Add Computer Laboratory Image</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body pb-0">
                                        <form method="POST" action="../../function/comlab_function.php" enctype="multipart/form-data">

                                            <!-- Image preview -->
                                            <div class="row" id="preview_container"></div>
                                            <div class="mb-3">
                                                <label for="comlab_images" class="form-label fw-bold">Select Images</label>
                                                <input type="file" name="comlab_images[]" id="comlab_images" class="form-control" accept="image/*" multiple required>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" name="add_comlab_images" class="btn btn-dynamic" data-bs-toggle="tooltip"
                                                    data-bs-placement="top" title="Click to save">
                                                    <i class="ri-save-line"></i> Save
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Modal for adding comlab image end-->


                        <!-- Modal for editing comlab description start-->
                        <div class="modal fade" id="comlab_description" tabindex="-1" aria-labelledby="exampleModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog modal-xl">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5 text-muted fw-bold" id="exampleModalLabel">Edit Computer Laboratory Description
                                        </h1>
                                    </div>
                                    <div class="modal-body pb-0">
                                        <form method="POST" action="../../function/comlab_function.php" enctype="multipart/form-data">
                                            <div class="row">
                                                <div class="col-md-12 mb-3">
                                                    <label for=""><strong>Computer Lab. Description</strong></label>
                                                    <textarea id="summernote" name="comlab_description" class="form-control mb-2"
                                                        style="height: 20vh;"><?= $comlab_data['comlab_description'] ?></textarea>

                                                    <div id="summernote"></div>
                                                    <script>
                                                        $('#summernote').summernote({
                                                            placeholder: 'Hello stand alone ui',
                                                            tabsize: 2,
                                                            height: 120,
                                                            toolbar: [
                                                                ['style', ['style']],
                                                                ['font', ['bold', 'italic', 'underline', 'strikethrough', 'superscript', 'subscript', 'clear']],
                                                                ['fontname', ['fontname']],
                                                                ['fontsize', ['fontsize']],
                                                                ['color', ['color']],
                                                                ['para', ['ol', 'ul', 'paragraph', 'height']],
                                                                ['view', ['undo', 'redo', 'fullscreen', 'codeview', 'help']]
                                                            ]
                                                        });
                                                    </script>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" name="update_comlab" class="btn btn-dynamic" data-bs-toggle="tooltip"
                                                    data-bs-placement="top" title="Click to save"><i class="ri-save-fill"></i> Save</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Modal for editing comlab description end-->

                    </div>
                </div>
            </div>
            <?php include 'include/footer.php'; ?>
        </div>
    </main>

    <!-- start js -->
    <script src="https://cdn.jsdelivr.net/npm/quill@1.3.6/dist/quill.min.js"></script>
    <script src="../../assets/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../../assets/bootstrap/js/jquery-3.7.1.js"></script>
    <script src="../../assets/bootstrap/js/script.js"></script>
    <script src="../../assets/bootstrap/js/activeLink.js?v=1.3"></script>
    <script src="../../assets/bootstrap/js/site_settings.js"></script>
    <!-- end js -->
    <!-- START >> JS SCRIPT IN ALERT -->

    <script>
        function showImageInModal(src) {
            document.getElementById('modalImage').src = src;
        }
    </script>

    <script>
        document.getElementById('comlab_images').addEventListener('change', function(event) {
            const previewContainer = document.getElementById('preview_container');
            previewContainer.innerHTML = ''; // Clear old previews

            const files = event.target.files;
            for (let file of files) {
                if (!file.type.startsWith('image/')) continue;

                const reader = new FileReader();
                reader.onload = function(e) {
                    const col = document.createElement('div');
                    col.classList.add('col-md-3', 'mb-3');
                    col.innerHTML = `<img src="${e.target.result}" class="img-fluid rounded border" alt="Preview Image">`;
                    previewContainer.appendChild(col);
                };
                reader.readAsDataURL(file);
            }
        });
    </script>
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