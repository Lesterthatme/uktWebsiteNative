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
  <link rel="icon" type="image/png" href="../../assets/images/officiallogo (1).png" />
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
            <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
            </div>
            <p class="card-text text-muted small"></p>
            <!-- staart adding research-->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
              aria-hidden="true">
              <div class="modal-dialog modal-lg">
                <div class="modal-content">
                  <div class="modal-header">
                    <h1 class="modal-title fs-5 text-muted fw-bold" id="exampleModalLabel">Add Research Project</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <form action="function/libraryresearch_function.php" method="POST">
                      <div class="mb-3">
                        <label for="title" class="form-label fw-semibold text-muted"><strong>Title:</strong></label>
                        <input type="text" class="form-control" id="title" name="research_title"
                          placeholder="Enter Title" required>
                      </div>

                      <div class="mb-3">
                        <label for="researchers" class="form-label fw-semibold text-muted"><strong>Author(s):</strong></label>
                        <textarea class="form-control" id="researchers" name="researchers"
                          placeholder="Enter Author/s Name" rows="3" required></textarea>
                      </div>

                      <div class="mb-3">
                        <label for="research_adviser" class="form-label"><strong>Research Adviser:</strong></label>
                        <input type="text" class="form-control" id="research_adviser" name="research_adviser"
                          placeholder="Enter Research Adviser" required>
                      </div>

                      <div class="mb-3">
                        <label for="date_published" class="form-label"><strong>Publication Year:</strong></label>
                        <select class="form-select" id="date_published" name="date_published" required>
                          <option value="" disabled selected>Select Year</option>
                          <?php
                          $startYear = 2000;
                          $currentYear = date("Y") + 1;
                          $endYear = 2040;

                          if ($currentYear >= 2040) {
                            $endYear = $currentYear + 5;
                          }

                          for ($year = $startYear; $year <= $endYear; $year++) {
                            echo "<option value='$year'>$year</option>";
                          }
                          ?>
                        </select>
                      </div>

                      <div class="mb-3">
                        <label for="research_type" class="form-label fw-semibold text-muted"><strong>Research
                            Type:</strong></label>
                        <select class="form-control" id="research_type" name="research_type">
                          <option value="" disabled selected>Select Research Type</option>
                          <option value="Capstone">Capstone</option>
                          <option value="Thesis">Thesis</option>
                        </select>
                      </div>
                      <div class="modal-footer">
                      <button type="submit" name="add_research" class="btn btn-dynamic btn-sm float-end"><i class="ri-save-fill"></i>
                      Save</button>
                    </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- end adding research-->

            <div class="doc-tabs-container mt-3">
              <ul class="doc-tabs d-flex list-unstyled">
                <li class="me-3">
                  <a class="doc-link" href="University_Library_updates">Library Updates</a>
                </li>
                <li class="me-3">
                  <a class="doc-link " href="University_Library_resources">Library Resources</a>
                </li>
                <li class="me-3">
                  <a class="doc-link" href="operating_hours">Operating Hours</a>
                </li>
                <li class="me-3">
                  <a class="doc-link active" href="University_Library_Research_Projects">Research Projects</a>
                </li>

              </ul>
              <hr class="doc-tabs-divider">
            </div>

            <div class="d-flex flex-column flex-md-row align-items-md-center mb-3">
              <p class="mb-2 mb-md-0 flex-grow-1">
                Research Project/Thesis involves in-depth study, data collection, and analysis to explore and solve
                academic or real-world problems, contributing to knowledge in a specific field.
              </p>
            </div>
            <div class="d-flex justify-content-end mt-2 mt-md-0">
              <button type="button" class="btn btn-sm rounded-2 px-4 btn-dynamic" data-bs-toggle="modal"
                data-bs-target="#exampleModal">
                <i class="ri-add-line"></i> Add Research Project
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
              $query = "SELECT research_id, research_title, researcher_name, research_adviser, publication_year, research_type 
                         FROM research_project ORDER BY publication_year DESC";
              $result = $conn->query($query);
              ?>

              <div class="table-container">
                <table class="table table-hover text-center align-middle" id="activityTable">
                  <thead>
                    <tr>
                      <th>Title</th>
                      <th>Author(s)</th>
                      <th>Publication Year</th>
                      <th>Research Type</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                      while ($row = $result->fetch_assoc()) {
                        ?>
                        <tr>
                          <td><?php echo htmlspecialchars($row['research_title']); ?></td>
                          <td><?php echo htmlspecialchars($row['researcher_name']); ?></td>
                          <td><?php echo htmlspecialchars($row['publication_year']); ?></td>
                          <td><?php echo htmlspecialchars($row['research_type']); ?></td>
                          <td>
                            <div class="dropdown">
                              <button class="btn btn-light btn-sm" type="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                <i class="ri-more-2-fill"></i>
                              </button>
                              <ul class="dropdown-menu">
                                <li>
                                  <a class="dropdown-item text-primary" href="#" data-bs-toggle="modal"
                                    data-bs-target="#viewBookModal" onclick="loadBookDetails(
                                        '<?php echo addslashes($row['research_title']); ?>', 
                                        '<?php echo addslashes($row['researcher_name']); ?>',
                                        '<?php echo addslashes($row['research_adviser']); ?>',
                                        '<?php echo addslashes($row['publication_year']); ?>',
                                        '<?php echo addslashes($row['research_type']); ?>'
                                    )">
                                    View
                                  </a>
                                </li>
                                <li>
                                  <a class="dropdown-item text-success" href="#" data-bs-toggle="modal"
                                    data-bs-target="#editModal" onclick="loadResearchDetails(
                                        '<?php echo $row['research_id']; ?>',
                                        '<?php echo addslashes($row['research_title']); ?>',
                                        '<?php echo addslashes($row['researcher_name']); ?>',
                                        '<?php echo addslashes($row['research_adviser']); ?>',
                                        '<?php echo addslashes($row['publication_year']); ?>',
                                        '<?php echo $row['research_type']; ?>'
                                      )">
                                    Edit
                                  </a>
                                </li>

                                <!-- Delete Button -->
                                <li>
                                  <a href="javascript:void(0);" class="dropdown-item text-danger text-decoration-none"
                                    data-id="<?= $row['research_id']; ?>"
                                    data-title="<?= addslashes($row['research_title']); ?>" onclick="openDeleteModal(this)">
                                    Delete
                                  </a>
                                </li>
                              </ul>
                            </div>
                          </td>
                        </tr>
                        <?php
                      }
                    } else {
                      echo "<tr><td colspan='5'>No research projects found.</td></tr>";
                    }
                    ?>
                  </tbody>
                </table>
                <div class="d-flex justify-content-center">
                  <ul class="pagination custom-pagination mt-2"></ul>
                </div>
              </div>
              <?php
              $conn->close();
              ?>

              <!-- edit research start -->
              <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                <div class="modal-dialog p-2 modal-lg">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title fw-bold text-muted" id="editModalLabel">Edit Research Project</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <form action="function/libraryresearch_function.php" method="POST">
                        <input type="hidden" id="edit_research_id" name="research_id">

                        <div class="mb-3">
                          <label class="form-label fw-semibold text-muted">Title:</label>
                          <input type="text" class="form-control" id="edit_title" name="research_title" required>
                        </div>

                        <div class="mb-3">
                          <label class="form-label fw-semibold text-muted">Author(s):</label>
                          <textarea class="form-control" id="edit_researchers" name="researcher_name" rows="3"
                            required></textarea>
                        </div>

                        <div class="mb-3">
                          <label class="form-label fw-semibold text-muted">Research Adviser:</label>
                          <input type="text" class="form-control" id="edit_adviser" name="research_adviser" required>
                        </div>

                        <div class="mb-3">
                          <label class="form-label">Publication Year</label>
                          <select class="form-select" id="edit_year" name="publication_year" required>
                            <option value="" disabled selected>Select Year</option>
                            <?php
                            $startYear = 2000;
                            $currentYear = date("Y") + 1;
                            $endYear = 2040;
                            if ($currentYear >= 2040) {
                              $endYear = $currentYear + 5;
                            }

                            for ($year = $startYear; $year <= $endYear; $year++) {
                              echo "<option value='$year'>$year</option>";
                            }
                            ?>
                          </select>
                        </div>
                        <div class="mb-3">
                          <label class="form-label fw-semibold text-muted">Research Type:</label>
                          <select class="form-select" id="edit_type" name="research_type" required>
                            <option value="Capstone">Capstone</option>
                            <option value="Thesis">Thesis</option>
                          </select>
                        </div>

                    </div>
                    <div class="modal-footer">
                      <button type="submit" name="update_research" class="btn btn-dynamic btn-sm"><i class="ri-save-fill"></i>
                        Save</button>
                    </div>
                    </form>

                  </div>
                </div>
              </div>
              <!-- edit research End -->

              <!-- View Research Modal Start -->
              <div class="modal fade" id="viewBookModal" tabindex="-1" aria-labelledby="viewBookModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title fw-bold text-muted" id="viewBookModalLabel">View Research Project</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <div class="row d-flex justify-content-center">
                        <div class="col-md-12">
                          <div class="row">
                            <p><strong>Title:</strong> <span id="modalTitle"></span></p>
                            <p><strong>Author(s):</strong> <span id="modalResearcher"></span></p>
                            <p><strong>Research Adviser:</strong> <span id="modalAdviser"></span></p>
                            <p><strong>Research Type:</strong> <span id="modalType"></span></p>
                            <p><strong>Publication Year:</strong> <span id="modalPublicationYear"></span></p>
                            <!-- Using the correct field -->
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <!-- View Research Modal End -->
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
  <script src="../../assets/bootstrap/js/activeLink.js?v=2.1"></script>
  <script src="../../assets/bootstrap/js/logs.js"></script>
  <script src="../../assets/bootstrap/js/site_settings.js?v=1.0"></script>
  <script>
    // script for viewing modal start
    function loadBookDetails(title, researcher, adviser, publicationYear, type) {
      document.getElementById("modalTitle").innerText = title;
      document.getElementById("modalResearcher").innerText = researcher;
      document.getElementById("modalAdviser").innerText = adviser;
      document.getElementById("modalPublicationYear").innerText = publicationYear; // Uses year directly
      document.getElementById("modalType").innerText = type;
    }
    // script for viewing modal end
    // update script start
    function loadResearchDetails(id, title, researchers, adviser, year, type) {
      document.getElementById("edit_research_id").value = id;
      document.getElementById("edit_title").value = title;
      document.getElementById("edit_researchers").value = researchers;
      document.getElementById("edit_adviser").value = adviser;
      document.getElementById("edit_year").value = year;
      document.getElementById("edit_type").value = type;
    }
    // update script end
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
        var researchId = element.getAttribute('data-id');
        var researchTitle = element.getAttribute('data-title');

        // Update the confirmation message with the title
        document.getElementById("researchTitleDisplay").textContent =
          `Do you want to remove the research project "${researchTitle}"? This action cannot be undone.`;

        // Update the delete URL
        document.getElementById("ResearchconfirmDelete").setAttribute("href",
          "function/libraryresearch_function.php?delete_id=" + researchId);

        // Show the modal
        document.getElementById("confirmationModal-Research-Projects").style.display = "flex";
      };

      window.closeModal = function () {
        document.getElementById("confirmationModal-Research-Projects").style.display = "none";
      };

      window.closeModalOutside = function (event) {
        if (event.target.id === "confirmationModal-Research-Projects") {
          closeModal();
        }
      };
    });
  </script>
</body>

</html>