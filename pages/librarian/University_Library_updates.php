<?php
include 'include/alert.php';
session_start();
if (!isset($_SESSION['session_token'])) {
  header('location:login.php');
  exit;
}
include 'confirmation.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <link rel="icon" type="image/png" href="../../assets/images/officiallogo (1).png"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>University of Kratie || Librarian</title>
  <!-- start css  -->
  <link rel="stylesheet" href="../../assets/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="../../assets/bootstrap/css/style.css?v=2.8">
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
            <p class="card-text text-muted small"></p>
            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
              aria-hidden="true">
              <div class="modal-dialog modal-lg">
                <div class="modal-content">
                  <!-- button for adding update start -->
                  <div class="modal-header">
                    <h1 class="modal-title fs-5 text-muted fw-bold button-primary" id="exampleModalLabel">Add Library
                      Update</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <!-- button for adding update end -->
                  <!-- modal for adding updates start -->
                  <div class="modal-body">
                    <form action="function/libraryupdates_function.php" method="POST" enctype="multipart/form-data">
                      <div class="mb-3">
                        <label class="form-label fw-semibold text-muted">Upload Image:</label>
                        <div class="upload-area" id="uploadArea">
                          <img src="https://cdn-icons-png.flaticon.com/512/126/126477.png" alt="Upload Icon">
                          <p class="mb-0">Drag & Drop <br><span class="text-success">or browse</span></p>
                          <small class="text-muted">Supports: JPEG, JPG, PNG</small>
                          <input type="file" name="update_image" id="fileInput" class="d-none"
                            accept="image/jpeg, image/jpg, image/png">
                        </div>
                        <div id="previewContainer" class="preview-container d-none">
                          <button type="button" class="delete-btn" id="deleteBtn">&times;</button>
                          <img id="previewImage" class="preview-img" alt="Preview Image">
                        </div>
                      </div>

                      <div class="mb-3">
                        <label class="form-label"><strong>Date:</strong></label>
                        <input type="date" class="form-control" name="posted_date" id="date_published"
                          style="max-width: 10rem;" required>
                      </div>

                      <div class="mb-3">
                        <label class="form-label"><strong>Category:</strong></label>
                        <select class="form-select" name="update_category" id="category" required>
                          <option value="">Select</option>
                          <option value="announcement">Announcement</option>
                          <option value="news">News</option>
                        </select>
                      </div>

                      <div class="mb-3">
                        <label class="form-label fw-semibold text-muted"><strong>Title:</strong></label>
                        <input type="text" class="form-control" name="update_title" placeholder="Enter Title" required>
                      </div>

                      <div class="mb-3">
                        <label class="form-label fw-semibold text-muted"><strong>Description:</strong></label>
                        <textarea class="form-control" name="update_description" id="message" rows="3"
                          placeholder="Enter Description" required></textarea>
                      </div>

                      <div class="modal-footer">
                        <button type="submit" name="add_update" class="btn btn-dynamic btn-sm"><i class="ri-save-fill"></i> Add Update</button>
                      </div>
                   


                  </div>
                  <!-- modal for adding updates end -->

                </div>
                 </form>
              </div>
            </div>
            <!-- container nav -->

            <div class="doc-tabs-container mt-3">
              <ul class="doc-tabs d-flex list-unstyled">
                <li class="me-3">
                  <a class="doc-link active" href="University_Library_updates">Library Updates</a>
                </li>
                <li class="me-3">
                  <a class="doc-link" href="University_Library_resources">Library Resources</a>
                </li>
                <li class="me-3">
                  <a class="doc-link" href="operating_hours">Operating Hours</a>
                </li>
                <li class="me-3">
                  <a class="doc-link" href="University_Library_Research_Projects">Research Projects</a>
                </li>

              </ul>
              <hr class="doc-tabs-divider">
            </div>

            <div class="d-flex flex-column flex-md-row align-items-md-center mb-3">
              <p class="mb-2 mb-md-0 flex-grow-1">
                Library Updates provide the latest news on new books, digital resources, services, and facility
                improvements to enhance learning and research.
              </p>
            </div>
            <div class="d-flex justify-content-end mt-2 mt-md-0">
              <button type="button" class="btn btn-sm rounded-2 px-4 btn-dynamic" data-bs-toggle="modal"
                data-bs-target="#exampleModal">
                <i class="ri-add-line"></i> Add Library Update
              </button>
            </div>

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

              $query = "SELECT update_id, update_image, update_category, update_title, update_description, posted_date FROM library_updates ORDER BY posted_date DESC";
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
                        $update_image = $row['update_image'] ? "assets/uploads/Libraryupdate_images/" . $row['update_image'] : "../assets/uploads/Libraryupdate_images/profile (1).png";
                        $update_title = htmlspecialchars($row['update_title']);
                        $update_category = ucfirst($row['update_category']);
                        $update_description = htmlspecialchars($row['update_description']);
                        $posted_date = strtotime($row['posted_date']);
                        $current_time = time();
                        $time_difference = $current_time - $posted_date;

                        // Show "Updated" if within the last 24 hours
                        if ($time_difference < 86400) {
                          $display_date = "<span class='text-success fw-bold'>Updated</span>";
                        } else {
                          $display_date = date("F j, Y", $posted_date);
                        }

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
                                      <a class='dropdown-item text-primary view-btn'
                                        href='#'
                                        data-bs-toggle='modal'
                                        data-bs-target='#viewBookModal'
                                        data-title='$update_title'
                                        data-category='$update_category'
                                        data-description='$update_description'
                                        data-date='" . date("F j, Y", $posted_date) . "'
                                        data-image='$update_image'>
                                          View
                                      </a>
                                  </li>
                                  <li>
                                      <a class='dropdown-item text-success edit-btn'
                                        href='#'
                                        data-bs-toggle='modal'
                                        data-bs-target='#editModal'
                                        data-id='" . $row['update_id'] . "'
                                        data-title='" . htmlspecialchars($row['update_title']) . "'
                                        data-category='" . $row['update_category'] . "'
                                        data-description='" . htmlspecialchars($row['update_description']) . "'
                                        data-date='" . date("Y-m-d", strtotime($row["posted_date"])) . "'
                                        data-image='$update_image'>
                                          Edit
                                      </a>
                                  </li>
                                  <li>
                                      <a class='dropdown-item text-danger text-decoration-none' href='javascript:void(0);'
                                        data-id='" . $row['update_id'] . "' data-title='" . htmlspecialchars($row['update_title']) . "'
                                        onclick='openDeleteModal(this)'>
                                          Delete
                                      </a>
                                  </li>
                              </ul>
                          </div>
                      </td>
                  </tr>";
                      }
                    } else {
                      echo "<tr><td colspan='5'>No updates available</td></tr>";
                    }
                    ?>
                  </tbody>

                </table>
                <div class="d-flex justify-content-center">
                  <ul class="pagination custom-pagination mt-2"></ul>
                </div>
              </div>

              <?php $conn->close(); ?>
              <!-- start updating the data using the modal -->
              <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                <div class="modal-dialog p-2 modal-lg">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title fw-bold text-muted" id="editModalLabel">Edit Library Update</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <form id="editForm" method="POST" action="function/libraryupdates_function.php"
                        enctype="multipart/form-data">
                        <input type="hidden" id="edit_update_id" name="update_id">
                        <div class="mb-3">
                          <label class="form-label fw-semibold text-muted">Upload Image:</label>
                          <div class="upload-area" id="editUploadArea">
                            <img id="editPreviewImage" class="preview-img" alt="Preview Image">
                            <input type="file" name="update_image" id="editFileInput" class="d-none"
                              accept="image/jpeg, image/jpg, image/png">
                          </div>
                        </div>
                        <div class="mb-3">
                          <label class="form-label fw-semibold text-muted">Title:</label>
                          <input type="text" id="edit_title" name="update_title" class="form-control" required>
                        </div>
                        <div class="mb-3">
                          <label class="form-label fw-semibold text-muted">Description:</label>
                          <textarea id="edit_description" name="update_description" class="form-control" rows="3"
                            required></textarea>
                        </div>
                        <div class="mb-3">
                          <label class="form-label">Category</label>
                          <select id="edit_category" name="update_category" class="form-select" required>
                            <option value="">Select</option>
                            <option value="announcement">Announcement</option>
                            <option value="news">News</option>
                          </select>
                        </div>
                        <div class="mb-3">
                          <label class="form-label">Date</label>
                          <input type="date" id="edit_date_published" name="posted_date" class="form-control" required>
                        </div>
                        <div class="modal-footer">
                          <button type="submit" name="update" class="btn btn-dynamic btn-sm"><i class="ri-save-fill"></i>
                            Save</button>
                        </div>
                      </form>

                    </div>
                  </div>
                </div>
              </div>
              <!-- end updating the data using the modal -->

              <!-- View Start Modal -->
              <div class="modal fade" id="viewBookModal" tabindex="-1" aria-labelledby="viewBookModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-lg">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title fw-bold text-muted" id="viewBookModalLabel">Library Update Details</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <div class="row">
                        <div class="col-md-6">
                          <img id="libraryUpdate" src="../../assets/images/announcement_library.jpg" alt="libraryUpdate"
                            class="img-fluid rounded">
                        </div>
                        <div class="col-md-6">
                          <h4 id="bookTitle">Title Here</h4>
                          <p><strong>Category:</strong> <span id="bookCategory">Category Here</span></p>
                          <p><strong>Date:</strong> <span id="bookDate">Date Here</span></p>
                          <p><strong>Description:</strong> <span id="libraryDescription">Date Here</span></p>
                        </div>
                      </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                  </div>
                </div>
              </div>
              <!-- View End Modal -->

            </div>
          </div>
        </div>
        <?php include 'include/footer.php'; ?>
      </div>
    </div>
  </main>

  <!-- start js -->

  <script src="../../assets/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../../assets/bootstrap/js/jquery-3.7.1.js"></script>
  <script src="../../assets/bootstrap/js/script.js"></script>
  <script src="../../assets/bootstrap/js/carousel.js"></script>
  <script src="../../assets/bootstrap/js/drag_and_drop.js?=v1.1"></script>
  <script src="../../assets/bootstrap/js/activeLink.js?v=1.6"></script>
  <script src="../../assets/bootstrap/js/logs.js?v=1.4"></script>
  <script src="../../assets/bootstrap/js/site_settings.js?v=1.0"></script>

  <script>
    document.addEventListener("DOMContentLoaded", function () {
      // Get all view buttons
      const viewButtons = document.querySelectorAll(".view-btn");

      viewButtons.forEach(button => {
        button.addEventListener("click", function () {
          // Get data attributes from the clicked button
          let title = this.getAttribute("data-title");
          let category = this.getAttribute("data-category");
          let date = this.getAttribute("data-date");
          let image = this.getAttribute("data-image");
          let description = this.getAttribute("data-description");
          // Update modal content
          document.getElementById("bookTitle").textContent = title;
          document.getElementById("bookCategory").textContent = category;
          document.getElementById("bookDate").textContent = date;
          document.getElementById("libraryUpdate").src = image;
          document.getElementById("libraryDescription").textContent = description;

        });
      });
    });

    document.addEventListener("DOMContentLoaded", function () {
      document.querySelectorAll(".edit-btn").forEach(button => {
        button.addEventListener("click", function () {
          const id = this.getAttribute("data-id");
          const title = this.getAttribute("data-title");
          const category = this.getAttribute("data-category");
          const description = this.getAttribute("data-description");
          const date = this.getAttribute("data-date");
          const image = this.getAttribute("data-image");

          document.getElementById("edit_update_id").value = id;
          document.getElementById("edit_title").value = title;
          document.getElementById("edit_description").value = description;
          document.getElementById("edit_category").value = category;
          document.getElementById("edit_date_published").value = date;
          document.getElementById("editPreviewImage").src = image;
        });
      });
    });

    // automatically get the data script start
    document.addEventListener("DOMContentLoaded", function () {
      let today = new Date().toISOString().split('T')[0];
      document.getElementById("date_published").value = today;
    });
    // automatically get the data script end
  </script>
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

  <script>
    document.addEventListener("DOMContentLoaded", function () {
      window.openDeleteModal = function (element) {
        var updateId = element.getAttribute('data-id');
        var updateTitle = element.getAttribute('data-title');
        document.getElementById("UpdatesconfirmDelete").setAttribute("href", "function/libraryupdates_function.php?delete_id=" + updateId);
        document.getElementById("confirmationModal-LibraryUpdates").style.display = "flex";
      };

      window.closeModal = function () {
        document.getElementById("confirmationModal-LibraryUpdates").style.display = "none";
      };

      window.closeModalOutside = function (event) {
        if (event.target.id === "confirmationModal-LibraryUpdates") {
          closeModal();
        }
      };
    });
  </script>

</body>

</html>