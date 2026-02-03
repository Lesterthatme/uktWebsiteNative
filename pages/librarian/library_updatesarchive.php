<?php
include 'include/alert.php';
session_start();
include '../../connection/dbconnection.php';

if (!isset($_SESSION['session_token'])) {
  header('location:login.php');
  exit;
}

$user_id = $_SESSION['user_id']; // Replace with actual session user_id

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
  <link rel="stylesheet" href="../../assets/bootstrap/css/style.css?=v1.7">
  <!-- end css -->
  <!-- Remix icon -->
  <link rel="stylesheet" href="../../assets/RemixIcon/fonts/remixicon.css">
</head>

<body class="bg-light">

  <!-- include side bar start -->
  <?php include 'include/sidebar.php'; ?>
  <!-- include side bar end -->

  <main class="bg-light">
    <!-- include navbar start -->
    <?php include 'include/navbar.php'; ?>
    <!-- include navbar end -->

    <!-- start: Content -->
    <div class="p-4">
      <div class="row">
        <div class="card border-0">
          <div class="card-body">
          <div class="doc-tabs-container mt-3">
              <ul class="doc-tabs d-flex list-unstyled">
                <li class="me-3">
                  <a class="doc-link active" href="library_updatesarchive">Library Updates Archive</a>
                </li>
                <li class="me-3">
                  <a class="doc-link" href="library_resourcesarchive">Library Resources Archive</a>
                </li>
                <li class="me-3">
                  <a class="doc-link" href="library_researcharchive">Research Projects</a>
                </li>
                <li class="me-3">
                  <a class="doc-link" href="library_picturesarchive">Library Images</a>
                </li>

              </ul>
              <hr class="doc-tabs-divider">
            </div>
       
            <!-- View Archive start -->
            <div class="log_container mt-3">
              <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-3">
                <div class="d-flex align-items-center mb-md-0">
                  <label class="me-2">Show</label>
                  <select id="entriesSelect" class="form-select custom-dropdown">
                    <option value="5">5</option>
                    <option value="10" selected>10</option>
                    <option value="15">15</option>
                    <option value="20">20</option>
                  </select>
                  <label class="ms-2 me-3">entries</label>
                </div>
                <div class="search-container me-2">
                  <i class="ri-search-line"></i>
                  <input type="text" id="searchBar" class="form-control" placeholder="Search">
                </div>
                <div class="d-flex align-items-center ms-md-auto mt-1">

                  <select id="sortBy" class="form-select">
                    <option value="">Sort By</option>
                    <option value="date">Sort by Date</option>
                    <option value="time">Sort by Time</option>
                  </select>
                </div>
              </div>

              <?php
              include '../../connection/dbconnection.php';

              // Fetch archived data
              $query = "SELECT 
                  libraryarchive_id, 
                  record_id, 
                  archived_at, 
                  JSON_UNQUOTE(JSON_EXTRACT(archive_description, '$.update_image')) AS update_image,
                  JSON_UNQUOTE(JSON_EXTRACT(archive_description, '$.update_title')) AS update_title,
                  JSON_UNQUOTE(JSON_EXTRACT(archive_description, '$.update_category')) AS update_category,
                  JSON_UNQUOTE(JSON_EXTRACT(archive_description, '$.posted_date')) AS posted_date
              FROM library_archive
              WHERE original_table = 'library_updates'
              ORDER BY archived_at DESC";
              $result = $conn->query($query);
              ?>

              <div class="table-container">
                <table class="table table-hover text-center align-middle" id="activityTable">
                  <thead>
                    <tr>
                      <th>Image</th>
                      <th>Title</th>
                      <th>Category</th>
                      <th>Date</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                      <?php
                      if ($result->num_rows > 0) {
                          while ($row = $result->fetch_assoc()) {
                              $update_image = $row['update_image'] ? "assets/uploads/Libraryupdate_images/" . $row['update_image'] : "assets/uploads/Libraryupdate_images/profile (1).png";
                              $update_title = htmlspecialchars($row['update_title']);
                              $update_category = ucfirst(htmlspecialchars($row['update_category']));
                              $posted_date = strtotime($row['posted_date']);
                              $display_date = $posted_date ? date("F j, Y", $posted_date) : "N/A";
                              $record_id = $row['record_id'];
                              echo "<tr>
                                  <td>
                                      <img src='$update_image' alt='update_cover' class='img-fluid rounded' style='width: 40px; height: 40px; object-fit: cover;'>
                                  </td>
                                  <td>$update_title</td>
                                  <td>$update_category</td>
                                  <td>$display_date</td>
                                  <td>
                                      <div class='dropdown'>
                                          <button class='btn btn-light btn-sm' type='button' data-bs-toggle='dropdown' aria-expanded='false'>
                                              <i class='ri-more-2-fill'></i>
                                          </button>
                                          <ul class='dropdown-menu'>
                                              <li>
                                                  <a class='dropdown-item text-success' href='function/restore_function.php?restoreupdate_id=$record_id' onclick='return confirm(\"Do you want to restore this record?\")'>Restore</a>
                                              </li>
                                          </ul>
                                      </div>
                                  </td>
                              </tr>";
                          }
                      } else {
                          echo "<tr><td colspan='5'>No archived updates available</td></tr>";
                      }
                      ?>
                  </tbody>

                </table>
                <div class="d-flex justify-content-center">
                  <ul class="pagination custom-pagination mt-2"></ul>
                </div>
              </div>
              <?php $conn->close(); ?>
            </div>
          </div>
        </div>
      </div>
      <?php include 'include/footer.php'; ?>
    </div>
  </main>

  <!-- start js -->
  <script src="../../assets/bootstrap/js/logs.js"></script>
  <script src="../../assets/script.js"></script> <!-- this script is for disabling multiple login in session -->
  <script src="../../assets/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../../assets/bootstrap/js/jquery-3.7.1.js"></script>
  <script src="../../assets/bootstrap/js/script.js"></script>
  <script src="../../assets/bootstrap/js/page_poster.js"></script>
  <script src="../../assets/bootstrap/js/drag_and_drop.js?=1.1"></script>
  <script src="../../assets/bootstrap/js/activeLink.js?v=1.2"></script>
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