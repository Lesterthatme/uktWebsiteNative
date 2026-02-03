<?php include 'include/alert.php';

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
  <link rel="stylesheet" href="../../assets/bootstrap/css/style.css?=v1.2">
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
              <h5 class="card-title fs-6 mb-2 mb-md-0">Partnership</h5>
              <button type="button" class="btn btn-sm rounded-2 px-4 btn-success" data-bs-toggle="modal" data-bs-target="#exampleModal">
                <i class="ri-add-line"></i> Add Partnership
              </button>
            </div>

            <p class="card-text text-muted small">Learn about our collaborations with institutions and industries that strengthen research, education and innovation.</p>
            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-xl">
                <div class="modal-content">
                  <div class="modal-header">
                    <h1 class="modal-title fs-5 text-muted fw-bold" id="exampleModalLabel">Add University Partnership</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <form>
                      <div class="mb-3">
                        <label class="form-label fw-semibold text-muted">Upload Image:</label>
                        <div class="upload-area" id="uploadArea">
                          <img src="https://cdn-icons-png.flaticon.com/512/126/126477.png" alt="Upload Icon">
                          <p class="mb-0">Drag & Drop <br><span class="text-success">or browse</span></p>
                          <small class="text-muted">Supports: JPEG, JPG, PNG</small>
                          <input type="file" id="fileInput" class="d-none" accept="image/jpeg, image/jpg, image/png">
                        </div>
                        <div id="previewContainer" class="preview-container d-none">
                          <button type="button" class="delete-btn" id="deleteBtn">&times;</button>
                          <img id="previewImage" class="preview-img" alt="Preview Image">
                        </div>
                      </div>

                      <div class="mb-3">
                        <label for="message" class="form-label fw-semibold text-muted">University Partnership Name:</label>
                        <input type="text" class="form-control" placeholder="Enter University Partnership Name">
                      </div>
                      <div class="mb-3">
                        <label for="message" class="form-label fw-semibold text-muted">Website Link:</label>
                        <input type="text" class="form-control" placeholder="Enter Website Link">
                      </div>

                    </form>

                  </div>
                  <div class="modal-footer">

                    <button type="button" class="btn btn-success"><i class="ri-save-fill"></i> Save</button>
                  </div>
                </div>
              </div>
            </div>
            <!-- container nav -->


            <!-- container nav -->


            <button class="toast-button toast-success-btn" onclick="showToast('toast-success', 'Success', 'Operation completed successfully.')">Show Success Toast</button>
            <button class="toast-button toast-info-btn" onclick="showToast('toast-info', 'Info', 'Here is some important information.')">Show Info Toast</button>
            <button class="toast-button toast-warning-btn" onclick="showToast('toast-warning', 'Warning', 'Be careful! Something needs attention.')">Show Warning Toast</button>
            <button class="toast-button toast-error-btn" onclick="showToast('toast-error', 'Error', 'Something went wrong!')">Show Error Toast</button>


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
  <script src="../../assets/bootstrap/js/drag_and_drop.js?=v1.0"></script>
  <script src="../../assets/bootstrap/js/activeLink.js"></script>
  <script src="../../assets/bootstrap/js/toast_msg.js"></script>
  <!-- end js -->
</body>

</html>