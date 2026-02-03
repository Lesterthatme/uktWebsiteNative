<?php
session_start();
include("../../connection/dbconnection.php");

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
  <title><?php echo htmlspecialchars($settings['websitetitle_cm']); ?></title>
  <!-- start css  -->
  <link rel="stylesheet" href="../../assets/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="../../assets/bootstrap/css/style.css?=v1.6">
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
            <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
              <h5 class="card-title fs-6 mb-2 mb-md-0">Manage News</h5>
              <button type="button" class="btn btn-sm rounded-2 px-4 btn-dynamic" data-bs-toggle="modal"
                data-bs-target="#exampleModal" data-bs-toggle="tooltip"
                data-bs-placement="top" title="Click to add news">
                <i class="ri-add-line"></i> Add News
              </button>
            </div>

            <p class="card-text text-muted small">
              Stay informed with the latest updates, important notices, and key announcements. This section keeps you
              connected with recent events, system updates, and essential information to ensure you’re always in the
              loop.
            </p>

            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
              aria-hidden="true">
              <div class="modal-dialog modal-lg">
                <div class="modal-content">
                  <div class="modal-header">
                    <h1 class="modal-title fs-5 text-muted fw-bold" id="exampleModalLabel">Add News</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <form method="POST" action="../../function/content_manager/news_function.php" enctype="multipart/form-data">
                      <div class="mb-3">
                        <label class="form-label fw-semibold text-muted">Upload Image:</label>
                        <div class="upload-area" id="uploadArea">
                          <img src="https://cdn-icons-png.flaticon.com/512/126/126477.png" alt="Upload Icon">
                          <p class="mb-0">Drag & Drop <br><span class="text-success">or browse</span></p>
                          <small class="text-muted">Supports: JPEG, JPG, PNG</small>
                          <input type="file" name="news_image" id="fileInput" class="d-none"
                            accept="image/jpeg, image/jpg, image/png">
                        </div>
                        <div id="previewContainer" class="preview-container d-none">
                          <button type="button" class="delete-btn" id="deleteBtn">&times;</button>
                          <img id="previewImage" class="preview-img" alt="Preview Image"
                            style="max-width: 100%; border: 2px solid #ccc; border-radius: 8px;">
                        </div>
                      </div>

                      <div class="mb-3">
                        <label for="news_title" class="form-label fw-semibold text-muted">News Title:</label>
                        <input type="text" name="news_title" class="form-control" placeholder="Enter News Title"
                          required>
                      </div>

                      <div class="mb-3">
                        <label for="news_description" class="form-label fw-semibold text-muted">Description:</label>
                        <textarea class="form-control" name="news_description" id="news_description" rows="3"
                          placeholder="Enter News Description" required></textarea>
                      </div>

                      <!-- News Status Dropdown -->
                      <!-- <div class="mb-3">
                        <label for="news_status" class="form-label fw-semibold text-muted">Status:</label>
                        <select name="news_status" class="form-control" required>
                          <option value="Active">Active</option>
                          <option value="Inactive">Inactive</option>
                        </select>
                      </div> -->

                      <div class="modal-footer pb-0">
                        <button type="submit" name="add_news" class="btn btn-dynamic" data-bs-toggle="tooltip"
                          data-bs-placement="top" title="Click to save"><i class="ri-save-fill"></i>
                          Save</button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>

            <!-- VIEWING NEWS START -->
            <div id="partnerCarousel" class="carousel slide" data-bs-ride="carousel">
              <div class="carousel-inner p-4">
                <?php
                include '../../connection/dbconnection.php';
                $query = "SELECT * FROM news ORDER BY news_date DESC";
                $result = mysqli_query($conn, $query);

                $news_data = [];
                while ($row = mysqli_fetch_assoc($result)) {
                  $news_data[] = $row;
                }

                $total_news = count($news_data);
                $chunks = array_chunk($news_data, 3); // Display 3 cards per slide
                $active = "active";

                foreach ($chunks as $news_items) { ?>
                  <div class="carousel-item <?= $active; ?>">
                    <div class="d-flex justify-content-center gap-3 flex-wrap">
                      <?php foreach ($news_items as $row) {
                        $news_id = $row['news_id'];
                        $news_title = $row['news_title'];
                        $news_description = substr($row['news_description'], 0, 120) . '...';
                        $news_date = date("F d, Y", strtotime($row['news_date']));
                        $news_image = $row['news_image'];
                        $news_status = $row['news_status'];
                        $status_class = ($news_status == "Active") ? "announcement-status-active" : "announcement-status-inactive";
                      ?>
                        <div class="card news-card" style="width: 22rem;">
                          <div class="image-container position-relative">
                            <img src="../../assets/uploads/news/<?= $news_image; ?>" class="card-img-top" alt="News Image">
                            <span class="<?= $status_class; ?>"><?= $news_status; ?></span>
                            <div class="date-label">
                              Date Posted: <?= $news_date; ?>
                            </div>
                          </div>
                          <div class="card-body d-flex flex-column">
                            <div class="dropdown three-dots-accord">
                              <button class="btn p-0 border-0 float-end" type="button" data-bs-toggle="dropdown"
                                data-bs-toggle="tooltip" data-bs-placement="top" title="Click here to see the action">
                                <span></span><span></span><span></span>
                              </button>
                              <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                  <a class="dropdown-item text-dark edit-btn" href="#" data-bs-toggle="modal"
                                    data-bs-target="#editModal" data-id="<?= $row['news_id']; ?>"
                                    data-title="<?= htmlspecialchars($news_title); ?>"
                                    data-description="<?= htmlspecialchars($row['news_description'], ENT_QUOTES, 'UTF-8'); ?>"
                                    data-image="../../assets/uploads/news/<?= $news_image; ?>"
                                    data-status="<?= $news_status; ?>" data-date="<?= $row['news_date']; ?>" data-bs-toggle="tooltip"
                                    data-bs-placement="top" title="Click to edit this news">
                                    <i class="ri-pencil-line"></i> Edit
                                  </a>
                                </li>
                                <li>
                                  <a href="javascript:void(0);" class="dropdown-item text-dark text-decoration-none"
                                    data-id="<?= $row['news_id']; ?>"
                                    onclick="openDeleteModal(<?= $row['news_id']; ?>, '<?= addslashes($row['news_title']); ?>')" data-bs-toggle="tooltip"
                                    data-bs-placement="top" title="Click to deelte this news">
                                    <i class="ri-delete-bin-line"></i> Delete
                                  </a>
                                </li>
                              </ul>
                            </div>
                            <h5 class="card-title "><?= $news_title; ?></h5>
                            <p class="card-text text-muted text-justify"><?= $news_description; ?></p>

                            <!-- Read More Button, inside Flexbox container -->
                            <div class="d-flex justify-content-between mt-auto">
                              <button class="news-btn w-100 read-more-btn" data-bs-toggle="modal"
                                data-bs-target="#newsModal" data-title="<?= htmlspecialchars($news_title, ENT_QUOTES); ?>"
                                data-description="<?= htmlspecialchars($row['news_description'], ENT_QUOTES, 'UTF-8'); ?>"
                                data-image="../../assets/uploads/news/<?= $news_image; ?>" data-bs-toggle="tooltip"
                                data-bs-placement="top" title="Click to view this news">
                                Read More <i class="ri-arrow-right-line"></i>
                              </button>
                            </div>
                          </div>

                        </div>
                      <?php } ?>
                    </div>
                  </div>
                <?php
                  $active = "";
                }
                ?>
              </div>

              <!-- INDICATOR START -->
              <div class="carousel-indicators">
                <button type="button" data-bs-target="#partnerCarousel" data-bs-slide-to="0" class="active bg-success"
                  aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#partnerCarousel" data-bs-slide-to="1" class="bg-success"
                  aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#partnerCarousel" data-bs-slide-to="2" class="bg-success"
                  aria-label="Slide 3"></button>
              </div>
              <!-- INDICATOR END -->
            </div>
            <!-- VIEWING NEWS END -->

            <!-- CAROUSEL BUTTON START -->
            <?php if ($total_news > 3): ?>
              <button class="carousel-control-prev custom-carousel-btn" type="button" data-bs-target="#partnerCarousel"
                data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
              </button>
              <button class="carousel-control-next custom-carousel-btn" type="button" data-bs-target="#partnerCarousel"
                data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
              </button>
            <?php endif; ?>
            <!-- CAROUSEL BUTTON END -->
          </div>

          <!-- Edit Modal START-->
          <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
              <div class="modal-content">
                <div class="modal-header">
                  <h1 class="modal-title fs-5 text-muted fw-bold" id="editModalLabel">Edit News</h1>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <form method="POST" action="../../function/content_manager/news_function.php" enctype="multipart/form-data">
                    <input type="hidden" name="news_id" id="edit-news-id">

                    <div class="mb-3">
                      <label class="form-label fw-semibold text-muted">Current Image:</label>
                      <div id="edit-previewContainer" class="text-center">
                        <img id="edit-previewImage" class="img-fluid"
                          style="max-width: 30%; height: auto; border: 2px solid #ccc; border-radius: 8px;">
                      </div>
                    </div>

                    <div class="mb-3">
                      <label class="form-label fw-semibold text-muted">Upload New Image:</label>
                      <input type="file" class="form-control" name="news_image" id="edit-image-input"
                        accept="image/*">
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="mb-3">
                          <label class="form-label fw-semibold text-muted">Date:</label>
                          <input type="date" class="form-control" id="edit-date" name="news_date">
                        </div>
                      </div>
                      <div class="col-md-6">
                        <label class="form-label fw-semibold text-muted">Status:</label>
                        <select class="form-control" id="edit-status" name="news_status" required>
                          <option value="Active">Active</option>
                          <option value="Inactive">Inactive</option>
                        </select>
                      </div>
                    </div>

                    <div class="mb-3">
                      <label class="form-label fw-semibold text-muted">News Title:</label>
                      <input type="text" class="form-control" id="edit-title" name="news_title" required>
                    </div>

                    <div class="mb-3">
                      <label class="form-label fw-semibold text-muted">Description:</label>
                      <textarea class="form-control" id="edit-description" name="news_description" rows="3"
                        required></textarea>
                    </div>
                    <div class="modal-footer pb-0">
                      <button type="submit" name="update_news" class="btn btn-dynamic" data-bs-toggle="tooltip"
                        data-bs-placement="top" title="Click to save">
                        <i class="ri-save-fill"></i> Save
                      </button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
          <!-- edit modal end -->
        </div>
        <!-- View  News Modal Structure -->
        <div class="modal fade" id="newsModal" tabindex="-1" aria-labelledby="newsModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="newsModalLabel">View News Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body text-center">
                <img id="newsImage" src="" class="img-fluid rounded mb-3" alt="News Image">
                <h4 id="newsTitle" class="fw-bold"></h4>
                <p id="newsDescription" class="text-muted text-justify"></p>
              </div>
            </div>
          </div>
        </div>
        <!-- View  News Modal Structure -->
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
  <script src="../../assets/bootstrap/js/drag_and_drop.js?=1.1"></script>
  <script src="../../assets/bootstrap/js/activeLink.js?v=1.0"></script>
  <script src="../../assets/bootstrap/js/table.js"></script>
  <script src="../../assets/bootstrap/js/site_settings.js"></script>
  <script src="../../assets/bootstrap/js/view_newsmodal.js"></script>
  <!-- end js -->

  <script>
    // script for edit modal in news start
    document.addEventListener("DOMContentLoaded", function() {
      const editButtons = document.querySelectorAll(".edit-btn");

      editButtons.forEach(button => {
        button.addEventListener("click", function() {
          const id = this.getAttribute("data-id");
          const title = this.getAttribute("data-title");
          const description = this.getAttribute("data-description");
          const image = this.getAttribute("data-image");
          const status = this.getAttribute("data-status");
          const date = this.getAttribute("data-date"); // GET THE DATE

          document.getElementById("edit-news-id").value = id;
          document.getElementById("edit-title").value = title;
          document.getElementById("edit-description").value = description;
          document.getElementById("edit-status").value = status;
          document.getElementById("edit-previewImage").src = image;
          document.getElementById("edit-date").value = date; // SET THE DATE
        });
      });
    });
    // script for edit modal in news end
    // script for getting immedietly the imgae start
    document.getElementById('edit-image-input').addEventListener('change', function(event) {
      const file = event.target.files[0];
      if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
          document.getElementById('edit-previewImage').src = e.target.result;
        };
        reader.readAsDataURL(file);
      }
    });
    // script for getting immedietly the imgae end
  </script>

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

  <script>
    document.addEventListener("DOMContentLoaded", function() {
      window.openDeleteModal = function(event, news_id) {
        event.preventDefault();
        document.getElementById("modalNewsId").value = news_id; // Set News ID
        document.getElementById("deleteConfirmationModal-news").style.display = "flex";
      };

      window.closeModal = function() {
        document.getElementById("deleteConfirmationModal-news").style.display = "none";
      };

      window.closeModalOutside = function(event) {
        if (event.target.id === "deleteConfirmationModal-news") {
          closeModal();
        }
      };
    });
  </script>


  <script>
    document.addEventListener("DOMContentLoaded", function() {
      window.openDeleteModal = function(news_id, news_title) {
        document.getElementById("modalNewsId").value = news_id;
        document.getElementById("newsTitlePlaceholder").textContent = news_title;
        document.getElementById("deleteConfirmationModal-news").style.display = "flex";
      };

      window.closeModal = function() {
        document.getElementById("deleteConfirmationModal-news").style.display = "none";
      };

      window.closeModalOutside = function(event) {
        if (event.target.id === "deleteConfirmationModal-news") {
          closeModal();
        }
      };
    });
  </script>

</body>

</html>