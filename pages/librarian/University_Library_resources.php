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
            <p class="card-text text-muted small"></p>
            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-lg">
                <div class="modal-content">
                  <div class="modal-header">
                    <h1 class="modal-title fs-5 text-muted fw-bold" id="exampleModalLabel">Add Library Resources</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <form action="function/libraryresources_function.php" method="POST">
                      <input type="hidden" name="add_resource" value="1">

                      <div class="mb-3">
                        <label class="form-label"><strong>Resource Type:</strong></label>
                        <select class="form-select" name="resource_type" required>
                          <option value="">Select</option>
                          <option value="Book">Books</option>
                          <option value="Journal">Journal</option>
                          <option value="Magazine">Magazine</option>
                          <option value="E-Books">E-Books</option>
                          <option value="Others">Others</option>
                        </select>
                      </div>

                      <div class="mb-3">
                        <label class="form-label"><strong>Resource Title:</strong></label>
                        <input type="text" class="form-control" name="resource_title" placeholder="Enter Title" required>
                      </div>

                      <div class="mb-3">
                        <label class="form-label"><strong>Author:</strong></label>
                        <input type="text" class="form-control" name="resource_author" placeholder="Enter Author" required>
                      </div>

                      <div class="mb-3">
                        <label class="form-label"><strong>ISBN/ISSN:</strong></label>
                        <input type="text" class="form-control" name="resource_ISBN" placeholder="Enter ISBN/ISSN">
                      </div>

                      <div class="row">
                        <div class="col-md-6">
                          <div class="mb-3">
                            <label class="form-label"><strong>Publication Year</strong></label>
                            <input type="number" class="form-control" name="publication_year" placeholder="Enter Publication Year"
                              min="1000" max="9999" oninput="limitDigits(this)" required>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="mb-3">
                            <label class="form-label"><strong>Resource Status:</strong></label>
                            <select class="form-select" name="resource_status" required>
                              <option value="">Select</option>
                              <option value="Active">Active</option>
                              <option value="Inactive">Inactive</option>
                            </select>
                          </div>
                        </div>
                      </div>
                      <div class="modal-footer">
                        <button type="submit" class="btn btn-dynamic btn-sm" name="add_resource"><i class="ri-save-fill"></i> Save
                        </button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>

            </div>
            <div class="doc-tabs-container ">
              <ul class="doc-tabs d-flex list-unstyled">
                <li class="me-3">
                  <a class="doc-link" href="University_Library_updates">Library Updates</a>
                </li>
                <li class="me-3">
                  <a class="doc-link active" href="University_Library_resources">Library Resources</a>
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
                Library Resources include academic books, research journals, digital databases, e-books, and study materials to support learning and research.
              </p>
            </div>
            <div class="d-flex justify-content-end mt-2 mt-md-0">
              <button type="button" class="btn btn-sm rounded-2 px-4 btn-dynamic" data-bs-toggle="modal" data-bs-target="#exampleModal">
                <i class="ri-add-line"></i> Add Library Resources
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
              <!-- START VIEWING LIBRARY RESOURCES -->
              <?php
              // Include database connection
              include '../../connection/dbconnection.php';

              $sql = "SELECT resource_id, resource_type, resource_title, resource_author, publication_year, resource_ISBN, resource_status 
                FROM library_resources";
              $result = $conn->query($sql);
              ?>

              <div class="table-container">
                <table class="table table-hover text-center align-middle" id="activityTable">
                  <thead>
                    <tr>
                      <th>Resource Type</th>
                      <th>Title</th>
                      <th>Author</th>
                      <th>Publication Year</th>
                      <th>ISBN/ISSN</th>
                      <th>Resource Status</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                      while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                        <td>{$row['resource_type']}</td>
                        <td>{$row['resource_title']}</td>
                        <td>{$row['resource_author']}</td>
                        <td>{$row['publication_year']}</td>
                        <td>{$row['resource_ISBN']}</td>
                         <td>";
                          if ($row['resource_status'] === 'Active') {
                              echo "<span class='badge bg-success'>Active</span>";
                          } elseif ($row['resource_status'] === 'Inactive') {
                              echo "<span class='badge bg-danger'>Inactive</span>";
                          } else {
                              echo "<span class='badge bg-secondary'>Unknown</span>";
                          }
                          echo "</td>
                        <td>
                        <td>
                            <div class='dropdown'>
                                <button class='btn btn-light btn-sm' type='button' data-bs-toggle='dropdown' aria-expanded='false'>
                                    <i class='ri-more-2-fill'></i>
                                </button>
                                <ul class='dropdown-menu'>
                                      <li>
                                        <a class='dropdown-item text-primary view-resource' href='#' 
                                            data-bs-toggle='modal' data-bs-target='#viewBookModal' 
                                            data-id='{$row['resource_id']}' 
                                            data-type='{$row['resource_type']}' 
                                            data-title='{$row['resource_title']}' 
                                            data-author='{$row['resource_author']}' 
                                            data-year='{$row['publication_year']}' 
                                            data-isbn='{$row['resource_ISBN']}'>View
                                        </a>
                                      </li>
                                    <li>
                                      <a class='dropdown-item text-success edit-resource' href='#' 
                                          data-bs-toggle='modal' 
                                          data-bs-target='#editModal'
                                          data-id='{$row['resource_id']}'
                                          data-type='{$row['resource_type']}'
                                          data-title='{$row['resource_title']}'
                                          data-author='{$row['resource_author']}'
                                          data-year='{$row['publication_year']}'
                                          data-isbn='{$row['resource_ISBN']}'
                                          data-status='{$row['resource_status']}'>Edit
                                      </a>
                                    </li>

                                    <li>
                                    <a class='dropdown-item text-danger text-decoration-none' href='javascript:void(0);'
                                       data-id='" . $row['resource_id'] . "' data-title='" . htmlspecialchars($row['resource_title']) . "'
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
                      echo "<tr><td colspan='7'>No records found</td></tr>";
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
              <!-- END VIEWING LIBRARY RESOURCES -->
              <!-- update modal start -->
              <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                <div class="modal-dialog p-2 modal-lg">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title fw-bold text-muted" id="editModalLabel">Edit Library Resource</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <form action="function/libraryresources_function.php" method="POST">
                        <input type="hidden" name="resource_id" id="edit_resource_id"> <!-- Hidden Field -->
                        <input type="hidden" name="update_resource" value="1"> <!-- Update Flag -->

                        <div class="mb-3">
                          <label class="form-label"><strong>Resource Type:</strong></label>
                          <select class="form-select" name="resource_type" id="edit_resource_type" required>
                            <option value="">Select</option>
                            <option value="Book">Books</option>
                            <option value="Journal">Journal</option>
                            <option value="Magazine">Magazine</option>
                            <option value="E-Books">E-Books</option>
                            <option value="Others">Others</option>
                          </select>
                        </div>

                        <div class="mb-3">
                          <label class="form-label"><strong>Resource Title:</strong></label>
                          <input type="text" class="form-control" name="resource_title" id="edit_resource_title" placeholder="Enter Title" required>
                        </div>

                        <div class="mb-3">
                          <label class="form-label"><strong>Author:</strong></label>
                          <input type="text" class="form-control" name="resource_author" id="edit_resource_author" placeholder="Enter Author" required>
                        </div>

                        <div class="mb-3">
                          <label class="form-label"><strong>ISBN/ISSN:</strong></label>
                          <input type="text" class="form-control" name="resource_ISBN" id="edit_resource_isbn" placeholder="Enter ISBN/ISSN">
                        </div>

                        <div class="row">
                          <div class="col-md-6">
                            <div class="mb-3">
                              <label class="form-label"><strong>Publication Year</strong></label>
                              <input type="number" class="form-control" name="publication_year" id="edit_publication_year" placeholder="Enter Year" min="1000" max="9999" required>
                            </div>
                          </div>

                          <div class="col-md-6">
                            <div class="mb-3">
                              <label class="form-label"><strong>Resource Status:</strong></label>
                              <select class="form-select" name="resource_status" id="edit_resource_status" required>
                                <option value="">Select</option>
                                <option value="Active">Active</option>
                                <option value="Inactive">Inactive</option>
                              </select>
                            </div>
                          </div>
                        </div>

                        <div class="modal-footer">
                          <button type="submit" class="btn btn-dynamic btn-sm" name="update_resource"><i class="ri-save-fill"></i> Save</button>
                        </div>
                      </form>


                    </div>
                  </div>
                </div>
              </div>
              <!-- update modal end -->

              <!-- View resources Modal Start -->
              <div class="modal fade" id="viewBookModal" tabindex="-1" aria-labelledby="viewBookModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title fw-bold text-muted" id="viewBookModalLabel">View Library Resource</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <div class="row d-flex justify-content-center">
                        <div class="col-md-8">
                          <div class="row">
                            <p><strong>Resource Type:</strong> <span id="modal-resource-type"></span></p>
                            <p><strong>Title:</strong> <span id="modal-resource-title"></span></p>
                            <p><strong>Author:</strong> <span id="modal-resource-author"></span></p>
                            <p><strong>Publication Year:</strong> <span id="modal-publication-year"></span></p>
                            <p><strong>ISBN/ISSN:</strong> <span id="modal-resource-isbn"></span></p>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <!-- View resources Modal End -->
            </div>
          </div>

        </div>
      </div>
      <?php include 'include/footer.php'; ?>
    </div>
    <!-- container nav -->
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
    // Limit THE YEAR INto 4 digits START
    function limitDigits(input) {
      if (input.value.length > 4) {
        input.value = input.value.slice(0, 4);
      }
    }
    // Limit THE YEAR INto 4 digits END

    document.getElementById("edit_publication_year").addEventListener("input", function() {
      let value = this.value;
      if (value.length > 4) {
        this.value = value.slice(0, 4); // Limit to 4 digits
      }
    });
    // viewing data in modal start
    document.addEventListener("DOMContentLoaded", function() {
      document.querySelectorAll(".view-resource").forEach(function(button) {
        button.addEventListener("click", function() {
          // Get data from the button
          let resourceType = this.getAttribute("data-type");
          let resourceTitle = this.getAttribute("data-title");
          let resourceAuthor = this.getAttribute("data-author");
          let publicationYear = this.getAttribute("data-year");
          let resourceISBN = this.getAttribute("data-isbn");

          // Set modal content
          document.getElementById("modal-resource-type").textContent = resourceType;
          document.getElementById("modal-resource-title").textContent = resourceTitle;
          document.getElementById("modal-resource-author").textContent = resourceAuthor;
          document.getElementById("modal-publication-year").textContent = publicationYear;
          document.getElementById("modal-resource-isbn").textContent = resourceISBN;
        });
      });
    });
    // viewing data in modal end

    // update script start
    $(document).ready(function() {
      $(".edit-resource").click(function() {
        var resource_id = $(this).data('id');
        var resource_type = $(this).data('type');
        var resource_title = $(this).data('title');
        var resource_author = $(this).data('author');
        var publication_year = $(this).data('year');
        var resource_isbn = $(this).data('isbn');
        var resource_status = $(this).data('status');

        $("#edit_resource_id").val(resource_id);
        $("#edit_resource_type").val(resource_type);
        $("#edit_resource_title").val(resource_title);
        $("#edit_resource_author").val(resource_author);
        $("#edit_publication_year").val(publication_year);
        $("#edit_resource_isbn").val(resource_isbn);
        $("#edit_resource_status").val(resource_status);
      });
    });
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
        var resourcesId = element.getAttribute('data-id');
        var resourcesTitle = element.getAttribute('data-title');
        document.getElementById("ResourcesconfirmDelete").setAttribute("href", "function/libraryresources_function.php?delete_id=" + resourcesId);
        document.getElementById("confirmationModal-LibraryResources").style.display = "flex";
      };

      window.closeModal = function () {
        document.getElementById("confirmationModal-LibraryResources").style.display = "none";
      };

      window.closeModalOutside = function (event) {
        if (event.target.id === "confirmationModal-LibraryResources") {
          closeModal();
        }
      };
    });
  </script>
</body>

</html>