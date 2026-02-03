<?php
include '../../connection/dbconnection.php';
session_start();
if (!isset($_SESSION['user_id'])) {
  header('location:login.php');
  exit;
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
  <!-- start css  -->
  <link rel="stylesheet" href="../../assets/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="../../assets/bootstrap/css/style.css?v=2.8">
  <!-- end css -->
  <!-- Remix icon -->
  <link rel="stylesheet" href="../../assets/RemixIcon/fonts/remixicon.css">
  <link href="https://cdn.jsdelivr.net/npm/remixicon/fonts/remixicon.css" rel="stylesheet">
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
        <div class="card border-0">
          <div class="card-body">
            <div class="doc-tabs-container mt-3">
              <ul class="doc-tabs d-flex list-unstyled">
                <li class="me-3">
                  <a class="doc-link active" href="page_management">Highlights</a>
                </li>
                <li class="me-3">
                  <a class="doc-link" href="partnership">Partnership</a>
                </li>
                <li class="me-3">
                  <a class="doc-link" href="calendar">University Calendar</a>
                </li>
                <li class="me-3">
                  <a class="doc-link" href="FaQ">FAQ</a>
                </li>
              </ul>
              <hr class="doc-tabs-divider">
            </div>
            <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
              <h5 class="card-title fs-6 mb-2 mb-md-0">Highlights</h5>
              <button type="button" class="btn btn-sm rounded-2 px-4 btn-dynamic float-end" data-bs-toggle="modal"
                data-bs-target="#addHighlightModal" data-bs-toggle="tooltip" data-bs-placement="top"
                title="Click to add highlights">
                <i class="ri-add-line"></i> Add Highlights
              </button>
            </div>

            <p class="card-text text-muted small">Discover the latest university achievements, events, and important
              updates that shape the academic community</p>


            <!-- Modal to add highlights -->
            <div class="modal fade" id="addHighlightModal" tabindex="-1" aria-labelledby="addHighlightModalLabel"
              aria-hidden="true">
              <div class="modal-dialog">
                <form action="../../function/highlight.php" method="POST">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h1 class="modal-title fw-bold text-muted" id="addHighlightModalLabel" style="font-size: 18px;">
                        Add Highlights</h1>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <div class="mb-3">
                        <label for="icon_class" class="form-label">Select Icon</label>
                        <div class="dropdown">
                          <button class="btn btn-dynamic dropdown-toggle w-100" type="button" id="iconDropdown"
                            data-bs-toggle="dropdown" aria-expanded="false" data-bs-toggle="tooltip"
                            data-bs-placement="top" title="Click here to select icon">
                            Select Icon
                          </button>
                          <div class="dropdown-menu w-100 p-2" id="iconDropdownMenu" aria-labelledby="iconDropdown"
                            style="max-height: 300px; overflow-y: auto; overflow-x: hidden; border: 1px solid #ccc;">
                            <input type="text" id="iconSearch" class="form-control mb-2" placeholder="Search Icon..."
                              onkeyup="filterIcons()" />
                            <ul id="iconList" style="list-style: none; padding: 0; margin: 0;">
                            </ul>
                          </div>
                        </div>
                        <input type="hidden" name="icon_class" id="selectedIconInput" />
                        <p class="mt-3"> Selected Icon: <i id="selectedIconPreview"></i>
                          <span id="selectedIconName" class="fw-bold"></span>
                        </p>
                      </div>
                      <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" name="title" class="form-control" id="title" placeholder="Enter Title"
                          required />
                      </div>
                      <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea name="description" class="form-control" id="description" rows="3"
                          placeholder="Enter Description" required></textarea>
                      </div>
                    </div>
                    <div class="modal-footer">
                      <button type="submit" name="add_highlights" class="btn btn-dynamic btn-md" data-bs-toggle="tooltip"
                        data-bs-placement="top" title="Click to save"><i class="ri-save-fill"></i> Save</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
            <!-- Modal to add highlights end -->

            <!-- viewing highlights start here-->
            <?php
            include '../../connection/dbconnection.php';

            if (!$conn) {
              die("Database connection failed: " . mysqli_connect_error());
            }
            $query = "SELECT * FROM highlight";
            $result = $conn->query($query);

            if (!$result) {
              die("Query failed: " . $conn->error);
            }

            $cards = [];
            while ($row = $result->fetch_assoc()) {
              $cards[] = $row;
            }

            $totalHighlights = count($cards);
            $batches = array_chunk($cards, 3);
            ?>

            <!-- Viewing Highlights Start Here! -->
            <div id="partnerCarousel" class="carousel slide" data-bs-ride="carousel">
              <div class="carousel-inner p-3">
                <?php foreach ($batches as $index => $batch): ?>
                  <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                    <div class="d-flex flex-column flex-md-row justify-content-center flex-wrap">
                      <?php foreach ($batch as $card): ?>
                        <div class="card p-4 custom-card position-relative text-center me-3 mb-3" style="flex: 1 1 100%; max-width: 300px;">
                          <!-- Dropdown menu -->
                          <div class="dropdown three-dots position-absolute top-0 end-0 m-2">
                            <button class="btn p-0 border-0" type="button" data-bs-toggle="dropdown" aria-expanded="false" data-bs-toggle="tooltip"
                              data-bs-placement="top" title="Click here to see the action">
                              <span></span><span></span><span></span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                              <li>
                                <a class="dropdown-item text-dark" href="javascript:void(0);" data-bs-toggle="modal"
                                  data-bs-target="#editHighlightModal" data-id="<?= $card['h_id'] ?>"
                                  data-icon="<?= htmlspecialchars($card['h_icon']) ?>" data-title="<?= htmlspecialchars($card['h_title']) ?>"
                                  data-description="<?= htmlspecialchars($card['h_description']) ?>" data-bs-toggle="tooltip"
                                  data-bs-placement="top" title="Click here to edit this highlights">
                                  <i class="ri-pencil-line"></i> Edit
                                </a>
                              </li>
                              <li>
                                <a class="dropdown-item text-dark" href="javascript:void(0);" onclick="confirmDeletion(<?= $card['h_id'] ?>)"
                                  data-bs-toggle="tooltip" data-bs-placement="top" title="Click here to delete this highlights">
                                  <i class="ri-delete-bin-line"></i> Delete
                                </a>
                              </li>
                            </ul>
                          </div>

                          <!-- Circular icon -->
                          <div class="position-absolute badge-circle bg-white border border-4 border-success rounded-circle d-flex justify-content-center align-items-center"
                            style="top: -40px; left: 50%; transform: translateX(-50%); width: 80px; height: 80px;">
                            <i class="<?= htmlspecialchars($card['h_icon']) ?> icon-flip"
                              style="font-size: 40px; color:rgb(101, 124, 107);"></i>
                          </div>

                          <!-- Card body -->
                          <div class="card-body mt-4">
                            <h5 class="card-title"><?= htmlspecialchars($card['h_title']) ?></h5>
                            <p class="card-text text-justify"><?= htmlspecialchars($card['h_description']) ?></p>
                          </div>
                        </div>
                      <?php endforeach; ?>
                    </div>
                  </div>
                <?php endforeach; ?>
              </div>

              <!-- Indicators -->
              <?php if ($totalHighlights >= 3): ?>
                <div class="carousel-indicators">
                  <?php foreach ($batches as $i => $batch): ?>
                    <button type="button" data-bs-target="#partnerCarousel" data-bs-slide-to="<?= $i ?>"
                      class="<?= $i === 0 ? 'active' : '' ?> bg-success" aria-label="Slide <?= $i + 1 ?>"></button>
                  <?php endforeach; ?>
                </div>
              <?php endif; ?>
            </div> <!-- end here -->

            <?php if ($totalHighlights > 3): ?>
              <button class="carousel-control-prev custom-carousel-btn" type="button"
                data-bs-target="#partnerCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
              </button>
              <button class="carousel-control-next custom-carousel-btn" type="button"
                data-bs-target="#partnerCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
              </button>
            <?php endif; ?>
            <!-- Viewing Highlights End Here -->

            <!-- modal for edit highlights  start-->
            <div class="modal fade" id="editHighlightModal" tabindex="-1" aria-labelledby="editHighlightModalLabel"
              aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                  <form method="POST" action="edit_highlight.php">
                    <div class="modal-header">
                      <h5 class="modal-title" id="editHighlightModalLabel">Edit Highlight</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <input type="hidden" name="h_id" id="modal_h_id">
                      <!-- Icon Selector -->
                      <div class="mb-3">
                        <label for="modal_h_icon" class="form-label">Icon</label>
                        <div class="dropdown">
                          <button type="button" class="btn btn-dynamic dropdown-toggle w-100" id="editIconDropdown"
                            data-bs-toggle="dropdown" aria-expanded="false" data-bs-toggle="tooltip"
                            data-bs-placement="top" title="Click here to select icon">
                            Select Icon
                          </button>
                          <div class="dropdown-menu w-100 p-2" id="editIconDropdownMenu"
                            style="max-height: 300px; overflow-y: auto; overflow-x: hidden; border: 1px solid #ccc;">
                            <input type="text" id="editIconSearch" class="form-control mb-2"
                              placeholder="Search Icon..." onkeyup="filterEditIcons()" />
                            <ul id="editIconList" style="list-style: none; padding: 0; margin: 0;"></ul>
                          </div>
                        </div>
                        <input type="hidden" id="modal_h_icon" name="h_icon" required>
                      </div>
                      <!-- Selected Icon Display -->
                      <div id="selected-icon-display"
                        style="text-align: center; margin-top: 10px; height: 100px; line-height: 100px;"></div>
                      <!-- Title input -->
                      <div class="mb-3">
                        <label for="modal_h_title" class="form-label">Title</label>
                        <input type="text" class="form-control" id="modal_h_title" name="h_title" required>
                      </div>
                      <!-- Description input -->
                      <div class="mb-3">
                        <label for="modal_h_description" class="form-label">Description</label>
                        <textarea class="form-control" id="modal_h_description" name="h_description" rows="3"
                          required></textarea>
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
        </div>
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
  <script src="../../assets/bootstrap/js/activeLink.js"></script>
  <script src="../../assets/bootstrap/js/site_settings.js?v=1.6"></script>
  <script src="../../assets/bootstrap/js/edit_highlight.js"></script>
  <script src="../../assets/bootstrap/js/remix_icon.js"></script>
  <!-- end js -->

  <script>
    function confirmDeletion(h_id) {
      const userConfirmed = confirm("Do you want to delete this highlight?");
      if (userConfirmed) {
        window.location.href = "../../function/highlight.php?h_id=" + h_id;
      }
    }
    // this script is for updating icon start
    document.addEventListener("DOMContentLoaded", function() {
      const editHighlightModal = document.getElementById("editHighlightModal");

      if (editHighlightModal) {
        editHighlightModal.addEventListener("show.bs.modal", function(event) {
          const button = event.relatedTarget;
          const hId = button.getAttribute("data-id");
          const hIcon = button.getAttribute("data-icon");
          const hTitle = button.getAttribute("data-title");
          const hDescription = button.getAttribute("data-description");

          // Populate modal fields
          document.getElementById("modal_h_id").value = hId;
          document.getElementById("modal_h_icon").value = hIcon;
          document.getElementById("modal_h_title").value = hTitle;
          document.getElementById("modal_h_description").value = hDescription;

          // Display the selected icon
          const selectedIconDisplay = document.getElementById("selected-icon-display");
          selectedIconDisplay.innerHTML = hIcon ? `<i class="${hIcon}" style="font-size: 50px;"></i>` : "";
        });
      }

      // Populating Icons into the List
      function populateIcons(iconList) {
        iconList.innerHTML = ""; // Clear previous items

        remixIcons.forEach(icon => {
          const li = document.createElement("li");
          li.innerHTML = `<i class="${icon}" style="font-size: 20px; cursor: pointer;"></i> <span>${icon}</span>`;
          li.style.padding = "5px";
          li.style.cursor = "pointer";
          li.addEventListener("click", function() {
            document.getElementById("modal_h_icon").value = icon; // Update hidden input
            document.getElementById("selected-icon-display").innerHTML = `<i class="${icon}" style="font-size: 50px;"></i>`; // Preview selected icon
          });
          iconList.appendChild(li);
        });
      }
      const editIconList = document.getElementById("editIconList");
      if (editIconList) {
        populateIcons(editIconList);
      }
      // Function to filter icons dynamically
      function filterEditIcons() {
        let search = document.getElementById("editIconSearch").value.toLowerCase();
        let items = editIconList.getElementsByTagName("li");
        Array.from(items).forEach(item => {
          let text = item.textContent || item.innerText;
          item.style.display = text.toLowerCase().includes(search) ? "" : "none";
        });
      }
      // Assign filter function globally
      window.filterEditIcons = filterEditIcons;
    });
    // this script is for updating icon end
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


  <script>
    document.addEventListener("DOMContentLoaded", function() {
      let deleteUrl = "";


      window.openModal = function(event, url) {
        event.preventDefault();
        deleteUrl = url;
        document.getElementById("confirmationModal-Hightlights").style.display = "flex";
        document.getElementById("confirmDelete").setAttribute("href", deleteUrl);
        return false;
      };

      window.closeModal = function() {
        document.getElementById("confirmationModal-Hightlights").style.display = "none";
      };

      window.closeModalOutside = function(event) {
        if (event.target.id === "confirmationModal-Hightlights") {
          closeModal();
        }
      };
    });
  </script>
</body>

</html>