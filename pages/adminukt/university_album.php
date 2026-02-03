<?php

include '../../connection/dbconnection.php';
session_start();
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
  <!-- start css  -->
  <link rel="stylesheet" href="../../assets/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="../../assets/bootstrap/css/style.css?v=2.9">
  <!-- end css -->
  <!-- Remix icon -->
  <link rel="stylesheet" href="../../assets/RemixIcon/fonts/remixicon.css">
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
            <div class="d-flex flex-wrap justify-content-between align-items-center mb-2">
              <h5 class="card-title fs-6 mb-2 mb-md-0">University Album</h5>
              <button type="button" class="btn btn-sm rounded-2 px-4 btn-dynamic" data-bs-toggle="modal" data-bs-target="#exampleModal"
                data-bs-toggle="tooltip" data-bs-placement="top" title="Click to add new album">
                <i class="ri-add-line"></i> Add Album
              </button>
            </div>
            <p class="card-text text-muted small">This Albums is for University Events</p>
            <!-- modal for adding album start-->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-xl">
                <div class="modal-content">
                  <div class="modal-header">
                    <h1 class="modal-title fs-5 text-muted fw-bold" id="exampleModalLabel">Add Album</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <form action="../../function/album_function.php" method="POST" enctype="multipart/form-data">
                      <div class="mb-3">
                        <label for="date_added" class="form-label fw-semibold text-muted"><strong>Date:</strong></label>
                        <input type="date" class="form-control" id="date_created" name="date_created" value="<?php echo date('Y-m-d'); ?>" style="width: 150px;" required>
                      </div>

                      <!-- <div class="mb-3">
                                                <label for="status" class="form-label fw-semibold text-muted"><strong>Status:</strong></label>
                                                <select class="form-control" id="status" name="status" style="width: 150px;">
                                                    <option value="Active">Active</option>
                                                    <option value="Inactive">Inactive</option>
                                                </select>
                                            </div> -->

                      <div class="mb-3">
                        <label for="album_name" class="form-label fw-semibold text-muted"><strong>Album Name:</strong></label>
                        <input type="text" class="form-control" id="album_name" name="album_name" placeholder="Enter Album Name" required>
                      </div>
                      <div class="mb-3">
                        <label for="album_description" class="form-label fw-semibold text-muted"><strong>Album Description:</strong></label>
                        <textarea class="form-control" id="album_description" name="album_description" placeholder="Enter Album Name" required></textarea>
                      </div>

                      <!-- Image Upload with Preview and Remove Option -->
                      <div class="mb-3">
                        <div id="imagePreview" class="mt-3 d-flex flex-wrap"></div>
                        <label for="images" class="form-label fw-semibold text-muted"><strong>Upload Images:</strong></label>
                        <input type="file" class="form-control" id="images" name="images[]" multiple accept="image/*" onchange="previewImages()" required>

                      </div>

                      <hr>
                      <button type="submit" name="add_album" class="btn btn-dynamic float-end"
                        data-bs-toggle="tooltip" data-bs-placement="top"
                        title="Click to save"><i class="ri-save-line"></i> Save</button>
                    </form>
                  </div>
                </div>
              </div>
            </div>
            <!-- modal for adding album end-->

            <?php
            include("../../connection/dbconnection.php");
            $query = "SELECT * FROM university_album";
            $result = mysqli_query($conn, $query);
            ?>

            <!-- Display Albums -->
            <div class="row">
              <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
  <div class="card announcement-card h-100 w-100" style="cursor: pointer;"
    onclick="window.location='view_album?album_id=<?php echo $row['album_id']; ?>'">

    <?php
    $album_id = $row['album_id'];

    $thumbnail_query = "SELECT image_name FROM university_image WHERE album_id = $album_id LIMIT 1";
    $thumbnail_result = mysqli_query($conn, $thumbnail_query);
    $thumbnail_row = mysqli_fetch_assoc($thumbnail_result);

    $image_count_query = "SELECT COUNT(*) AS image_count FROM university_image WHERE album_id = $album_id";
    $image_count_result = mysqli_query($conn, $image_count_query);
    $image_count_row = mysqli_fetch_assoc($image_count_result);
    $image_count = $image_count_row['image_count'];

    $thumbnail_path = ($thumbnail_row)
      ? "../../assets/uploads/university_gallery/" . $thumbnail_row['image_name']
      : "../../assets/uploads/university_gallery/default_image.jpg";
    ?>

    <div class="image-container" style="position: relative; height: 180px; background: #f8f9fa;">
      <img src="<?php echo $thumbnail_path; ?>" class="card-img-top w-100" alt="Album Thumbnail"
        style="height: 100%; object-fit: cover;">
      <span class="<?php echo ($row['status'] === 'Active') ? 'announcement-status-active' : 'announcement-status-inactive'; ?>">
        <?php echo $row['status']; ?>
      </span>

      <div class="date-label">
        Created on: <?php echo date("F d, Y", strtotime($row['date_created'])); ?>
      </div>
    </div>

    <div class="card-body">
      <div class="dropdown three-dots-accord">
        <button class="btn p-0 border-0 float-end" type="button" data-bs-toggle="dropdown" aria-expanded="false"
          onclick="event.stopPropagation();">
          <span></span><span></span><span></span>
        </button>
        <ul class="dropdown-menu dropdown-menu-end" onclick="event.stopPropagation();">
          <li>
            <a class="dropdown-item text-dark" href="#editModal<?php echo $row['album_id']; ?>" data-bs-toggle="modal">
              <i class="ri-pencil-line"></i> Edit
            </a>
          </li>
          <li>
            <a class="dropdown-item text-dark" href="../../function/album_function.php?album_id=<?php echo $row['album_id']; ?>"
              onclick="return confirm('Are you sure you want to delete this album?')">
              <i class="ri-delete-bin-line"></i> Delete
            </a>
          </li>
        </ul>
      </div>

      <h6 class="card-title"><?php echo htmlspecialchars($row['album_name']); ?></h6>
      <p class="card-text text-muted text-justify">
        <?php echo htmlspecialchars($row['album_description']); ?>
      </p>
      <p class="text-muted mb-0" style="font-size: 13px;">
        <?php
        echo ($image_count == 0) ? "No image" : (($image_count == 1) ? "1 Item" : "$image_count Items");
        ?>
      </p>
    </div>
  </div>
</div>


                <!-- EDIT ADMISSION START-->
                <div class="modal fade" id="editModal<?php echo $row['album_id']; ?>" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title fw-bold">Update Album</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                        <form action="../../function/album_function.php" method="POST" enctype="multipart/form-data">
                          <input type="hidden" name="album_id" value="<?php echo $row['album_id']; ?>">
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
                            <label for="album_name" class="form-label"><strong>Album Name</strong></label>
                            <input type="text" class="form-control"
                              name="album_name" value="<?php echo htmlspecialchars($row['album_name']); ?>"
                              required>
                          </div>

                          <div class="mb-3">
                            <label for="album_description" class="form-label"><strong>Album Description</strong></label>
                            <textarea class="form-control" name="album_description" rows="4" required><?php echo htmlspecialchars($row['album_description']); ?></textarea>
                          </div>
                          <hr>
                          <button type="submit" name="update_album" class="btn btn-dynamic float-end" data-bs-toggle="tooltip"
                            data-bs-placement="top"
                            title="Click to save"><i class="ri-save-line"></i> Save</button>

                        </form>

                      </div>
                    </div>
                  </div>
                </div>
                <!-- EDIT ADMISSION END-->
              <?php endwhile; ?>
            </div>

            <!-- modal for adding album start-->
          </div>
        </div>
        <?php include 'include/footer.php'; ?>
      </div>
  </main>
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  <script src="../../assets/bootstrap/js/Logs.js?v=1.1"></script>
  <script src="../../assets/bootstrap/js/site_settings.js"></script>
  <script src="../../assets/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../../assets/bootstrap/js/jquery-3.7.1.js"></script>
  <script src="../../assets/bootstrap/js/script.js"></script>
  <script src="../../assets/bootstrap/js/carousel2itemslide.js?=v1.7"></script>
  <script src="../../assets/bootstrap/js/drag_and_drop.js?=v1.0"></script>
  <script src="../../assets/bootstrap/js/activeLink.js?=v1.2"></script>


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

      input.files = dt.files;
    }
  </script>


</body>

</html>