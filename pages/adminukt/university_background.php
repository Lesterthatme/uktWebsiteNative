<?php
session_start();
include '../../connection/dbconnection.php';

// Query to get the university profile data
$query = "SELECT university_logo, university_name, university_background FROM university_profile WHERE up_id = 1";
$result = mysqli_query($conn, $query);
$university_data = mysqli_fetch_assoc($result);

$university_logo = $university_data['university_logo'];
$university_name = $university_data['university_name'];
$university_background = $university_data['university_background'];

// Get the image from universityprofile_image
$imgQuery = "SELECT up_image FROM universityprofile_image LIMIT 2";
$imgResult = mysqli_query($conn, $imgQuery);

$up_images = [];
if ($imgResult && mysqli_num_rows($imgResult) > 0) {
  while ($row = mysqli_fetch_assoc($imgResult)) {
    $up_images[] = $row['up_image'];
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
              <h5 class="card-title fs-6 mb-2 mb-md-0">University Background</h5>
              <button type="button" class="btn btn-sm rounded-2 px-4 btn-dynamic" data-bs-toggle="modal"
                data-bs-target="#exampleModal" data-bs-toggle="tooltip"
                data-bs-placement="top" title="Click to update unoversity background">
                <i class="ri-edit-2-line"></i> Edit University Background
              </button>
            </div>

            <!-- Modal for editing background start-->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
              aria-hidden="true">
              <div class="modal-dialog modal-xl">
                <div class="modal-content">
                  <div class="modal-header">
                    <h1 class="modal-title fs-5 text-muted fw-bold" id="exampleModalLabel">Edit University Background
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body pb-0">
                    <form method="POST" action="../../function/university_backgroundfunction.php" enctype="multipart/form-data">
                      <!-- Display existing images if they exist -->
                      <div class="row mb-3">
                        <label><strong>Current University Images</strong></label>
                        <div class="col-md-12">
                          <?php if (!empty($up_images)): ?>
                            <div class="row">
                              <?php foreach ($up_images as $index => $image): ?>
                                <div class="col-md-6 mb-2 d-flex justify-content-center">
                                  <img src="../../assets/uploads/university_image/<?php echo htmlspecialchars($image); ?>"
                                    alt="University Image"
                                    class="img-fluid rounded border mb-2" style="max-width: 80%; height: auto;">
                                </div>
                              <?php endforeach; ?>
                            </div>
                          <?php else: ?>
                            <p>No images uploaded yet.</p>
                          <?php endif; ?>
                        </div>
                      </div>

                      <div class="row">
                        <div class="mb-3">
                          <label for="images"><strong>Upload University Images (Max 2)</strong></label>
                          <input type="file" name="images[]" id="images" class="form-control" accept="image/*" multiple>
                          <small class="text-muted">You can upload up to 2 images.</small>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-md-12 mb-3">
                          <label for=""><strong>University Background Description</strong></label>
                          <textarea id="summernote" name="university_background" class="form-control mb-2"
                            style="height: 20vh;"><?= $university_data['university_background'] ?></textarea>

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
                                ['table', ['table']],
                                ['insert', ['link', 'picture']],
                                ['view', ['undo', 'redo', 'fullscreen', 'codeview', 'help']]
                              ]
                            });
                          </script>
                        </div>
                      </div>
                      <div class="modal-footer">
                        <button type="submit" class="btn btn-dynamic" data-bs-toggle="tooltip"
                          data-bs-placement="top" title="Click to save"><i class="ri-save-fill"></i> Save</button>
                      </div>
                    </form>

                  </div>

                </div>
              </div>
            </div>
            <!-- Modal for editing background end-->

            <!-- viewing university start -->
            <div class="container text-center py-5">
              <div class="row justify-content-center">
                <div class="col-md-8 mb-4">
                  <div class="row">
                    <?php foreach ($up_images as $image): ?>
                      <div class="col-md-6 mb-3">
                        <img src="../../assets/uploads/university_image/<?php echo htmlspecialchars($image); ?>"
                          alt="University Image"
                          class="img-fluid rounded border" />
                      </div>
                    <?php endforeach; ?>
                  </div>
                </div>

                <!-- University name -->
                <div class="col-md-8">
                   <h4 class="fw-bold" style="font-family: 'Times New Roman', Times, serif;">
                    <?php echo htmlspecialchars($university_name); ?>
                </h4>
                </div>

                <!-- Background -->
                <div class="col-md-8">
                  <p><?php echo $university_background; ?></p>
                </div>
              </div>
            </div>
            <!-- viewing university end -->

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
  <script src="../../assets/bootstrap/js/page_poster.js"></script>
  <script src="../../assets/bootstrap/js/drag_and_drop.js?=1.1"></script>
  <script src="../../assets/bootstrap/js/activeLink.js?v=1.2"></script>
  <script src="../../assets/bootstrap/js/table.js"></script>
  <script src="../../assets/bootstrap/js/site_settings.js"></script>
  <!-- end js -->
  <script>
    document.getElementById('images').addEventListener('change', function() {
      if (this.files.length > 2) {
        alert("You can only upload a maximum of 2 images.");
        this.value = ""; // Clear selection
      }
    });
  </script>
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