<?php
include '../../connection/dbconnection.php';
session_start();

// Updated query to join university_hymn and university_profile tables
$query = "
    SELECT 
        uh.hymn_id, 
        uh.hymn_author, 
        uh.hymn_title, 
        uh.hymn_lyrics, 
        up.university_logo 
    FROM university_hymn uh
    CROSS JOIN university_profile up
    WHERE uh.hymn_id = 1
    LIMIT 1";
$result = mysqli_query($conn, $query);
$university_data = mysqli_fetch_assoc($result);

$hymn_author = $university_data['hymn_author'];
$hymn_title = $university_data['hymn_title'];
$hymn_lyrics = $university_data['hymn_lyrics'];
$university_logo = $university_data['university_logo'];


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
  <link rel="stylesheet" href="../../assets/bootstrap/css/style.css?=v1.4">
  <link rel="stylesheet" href="../../assets/RemixIcon/fonts/remixicon.css">
  <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-lite.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-lite.min.js"></script>

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
              <h5 class="card-title fs-6 mb-2 mb-md-0">University Hymn</h5>
              <button type="button" class="btn btn-sm rounded-2 px-4 btn-dynamic" data-bs-toggle="modal"
                data-bs-target="#exampleModal" data-bs-toggle="tooltip"
                data-bs-placement="top" title="Click to update university hymn">
                <i class="ri-edit-2-line"></i> Edit University Hymn
              </button>
            </div>

            <!-- Modal for editing background start-->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
              aria-hidden="true">
              <div class="modal-dialog modal-xl">
                <div class="modal-content">
                  <div class="modal-header">
                    <h1 class="modal-title fs-5 text-muted fw-bold" id="exampleModalLabel">Edit University Hymn</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body pb-0">
                    <form method="POST" action="../../function/university_hymnfunction.php" role="dialog">
                      <div class="row">
                        <div class="col-md-12 mb-3">
                          <input type="hidden" name="hymn_id"
                            value="<?= htmlspecialchars($university_data['hymn_id'], ENT_QUOTES, 'UTF-8') ?>">

                          <div class="col-md-6 d-flex align-items-center mb-3">
                            <label class="form-label fw-semibold text-muted me-2 mb-0" for="hymn_title">
                              <strong>Title:</strong></label>
                            <input type="text" id="hymn_title" class="form-control" name="hymn_title"
                              value="<?= htmlspecialchars($university_data['hymn_title'], ENT_QUOTES, 'UTF-8') ?>"
                              required>
                          </div>

                          <div class="col-md-6 d-flex align-items-center mb-3">
                            <label class="form-label fw-semibold text-muted me-2 mb-0" for="hymn_author">
                              <strong>Author:</strong></label>
                            <input type="text" id="hymn_author" class="form-control" name="hymn_author"
                              value="<?= htmlspecialchars($university_data['hymn_author'], ENT_QUOTES, 'UTF-8') ?>"
                              required>
                          </div>

                          <label class="form-label fw-semibold text-muted mt-3 mb-0">Edit Hymn Lyrics</label>
                          <textarea id="summernote" name="hymn_lyrics" class="form-control mb-2" style="height: 20vh;"
                            required><?= htmlspecialchars($university_data['hymn_lyrics'], ENT_QUOTES, 'UTF-8') ?></textarea>

                          <script>
                            $('#summernote').summernote({
                              placeholder: 'Edit hymn lyrics...',
                              tabsize: 2,
                              height: 120,
                              toolbar: [
                                ['style', ['style']],
                                ['font', ['bold', 'italic', 'underline', 'strikethrough', 'superscript', 'subscript', 'clear']],
                                ['fontname', ['fontname']],
                                ['fontsize', ['fontsize']],
                                ['color', ['color']],
                                ['para', ['ol', 'ul', 'paragraph', 'height']],
                                ['insert', ['link']],
                                ['view', ['undo', 'redo', 'help']]
                              ]
                            });
                          </script>
                        </div>
                      </div>
                      <div class="modal-footer">
                        <button type="submit" name="update_hymn" class="btn btn-dynamic" data-bs-toggle="tooltip"
                          data-bs-placement="top"
                          title="Click to save"><i class="ri-save-fill"></i>
                          Save</button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
            <!-- Modal for editing university hymn end -->

            <!-- Page Poster start -->
            <div class="container text-center py-5">
              <div class="row justify-content-center">
                <div class="col-md-8">
                  <img src="../../assets/uploads/university_image/<?php echo $university_logo; ?>"
                    alt="University Logo" class="ub_logo img-fluid">
                  <h4 class="fw-bold"><?php echo $hymn_title; ?></h4>
                  <small><?php echo $hymn_author; ?></small>
                </div>
                <div class="col-md-8">
                  <p class="lead"><?php echo $hymn_lyrics; ?></p>
                </div>
              </div>
            </div>
            <!-- Page Poster End-->
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
  <script src="../../assets/bootstrap/js/site_settings.js?v=1.1"></script>

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
</body>

</html>