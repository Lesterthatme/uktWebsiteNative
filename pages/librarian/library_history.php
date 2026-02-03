<?php
include 'include/alert.php';
session_start();
if (!isset($_SESSION['session_token'])) {
  header('location:login.php');
  exit;
}
include '../../connection/dbconnection.php';

// Query to get the library profile data
$query = "SELECT library_logo, library_name, library_history FROM library_university WHERE library_id = 1";
$result = mysqli_query($conn, $query);
$library_data = mysqli_fetch_assoc($result);

$library_logo = $library_data['library_logo'];
$library_name = $library_data['library_name'];
$library_history = $library_data['library_history'];
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
  <link rel="stylesheet" href="../../assets/bootstrap/css/style.css?=v1.4">
  <!-- end css -->
  <!-- Remix icon -->
  <link rel="stylesheet" href="../../assets/RemixIcon/fonts/remixicon.css">
  <!-- Summernote CSS -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-lite.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-lite.min.js"></script>

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
              <h5 class="card-title fs-6 mb-2 mb-md-0">University Library History</h5>
              <button type="button" class="btn btn-sm rounded-2 px-4 btn-dynamic" data-bs-toggle="modal" data-bs-target="#exampleModal">
                <i class="ri-edit-2-line"></i> Edit University Library History
              </button>
            </div>

            <!-- Modal for editing background start-->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-xl">
                <div class="modal-content">
                  <div class="modal-header">
                    <h1 class="modal-title fs-5 text-muted fw-bold" id="exampleModalLabel">Edit Library University History</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <form method="POST" action="function/libraryhistory_function.php" role="dialog">
                      <div class="row">
                        <div class="col-md-12 mb-3">
                          <label for="">Description</label>
                          <textarea id="summernote" name="library_history" class="form-control mb-2" style="height: 20vh;"><?= $library_data['library_history'] ?></textarea>

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
                        <button type="submit" class="btn btn-dynamic"><i class="ri-save-fill"></i> Save</button>
                      </div>
                    </form>
                  </div>

                </div>
              </div>
            </div>
            <!-- Modal for editing background end-->

            <!-- Page Poster start -->
            <div class="container text-center py-5">
              <div class="row justify-content-center">
                <div class="col-md-8">
                  <img src="<?php echo htmlspecialchars($library_logo); ?>" alt="Library Logo" class="sidebar-logo-img me-3 ub_logo img-fluid"
                    alt="University Logo" class="ub_logo img-fluid">
                  <h4 class="fw-bold"><?php echo $library_name; ?></h4>
                </div>
                <div class="col-md-8">
                  <p class="lead"><?php echo $library_history; ?></p>
                  <button class="btn btn-dynamic mt-2" data-bs-toggle="modal" data-bs-target="#newsModal">Read More</button>
                </div>
              </div>
            </div>

            <!-- Page Poster End-->

            <!-- read more  News Modal Structure -->
            <div class="modal fade" id="newsModal" tabindex="-1" aria-labelledby="newsModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-lg">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title fw-bold text-muted" id="newsModalLabel">View Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body text-center">

                    <h5 class="text-muted fw-semibold">Library University Background</h5>
                    <p class="lead"><?php echo $library_history; ?></p>
                  </div>
                </div>
              </div>
            </div>
            <!-- read more  News Modal Structure -->
          </div>
        </div>
      </div>
      <?php include 'include/footer.php'; ?>
    </div>
  </main>

  <!-- start js -->
  <script src="../../assets/script.js"></script>
  <!-- this script is for disabling multiple login in session -->
  <script src="https://cdn.jsdelivr.net/npm/quill@1.3.6/dist/quill.min.js"></script>
  <script src="../../assets/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../../assets/bootstrap/js/jquery-3.7.1.js"></script>
  <script src="../../assets/bootstrap/js/script.js"></script>
  <script src="../../assets/bootstrap/js/page_poster.js"></script>
  <script src="../../assets/bootstrap/js/drag_and_drop.js?=1.1"></script>
  <script src="../../assets/bootstrap/js/activeLink.js?v=1.2"></script>
  <script src="../../assets/bootstrap/js/table.js"></script>
  <script src="../../assets/bootstrap/js/site_settings.js?v=1.0"></script>

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

</body>

</html>