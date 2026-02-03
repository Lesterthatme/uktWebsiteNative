<?php
session_start();

include '../../connection/dbconnection.php';

date_default_timezone_set('Asia/Phnom_Penh');

if (isset($_POST['edit_event'])) {
  $uc_id = $_POST['uc_id'];
  $uc_title = $_POST['uc_title'];
  $uc_month = $_POST['uc_month'];
  $uc_day = $_POST['uc_day'];
  $uc_description = $_POST['uc_description'];
  $user_id = $_SESSION['user_id'];

  // Prepare the UPDATE query
  $update_query = "UPDATE university_calendar SET uc_title = ?, uc_month = ?, uc_day = ?, uc_description = ? WHERE uc_id = ?";
  $stmt = $conn->prepare($update_query);
  if (!$stmt) {
    $_SESSION['toastMsg'] = "Database error: " . $conn->error;
    $_SESSION['toastType'] = "toast-error";
    header("Location: calendar");
    exit();
  }
  $stmt->bind_param("ssisi", $uc_title, $uc_month, $uc_day, $uc_description, $uc_id);

  if ($stmt->execute()) {
    // Log the action
    $log_description = "Edited event Title: $uc_title";
    $log_date = date('Y-m-d');
    $log_time = date('H:i:s');

    $log_query = "INSERT INTO history_log (description, log_date, log_time, user_id) VALUES (?, ?, ?, ?)";
    $log_stmt = $conn->prepare($log_query);
    if ($log_stmt) {
      $log_stmt->bind_param("sssi", $log_description, $log_date, $log_time, $user_id);
      $log_stmt->execute();
      $log_stmt->close();
    }

    $_SESSION['toastMsg'] = "Event updated successfully!";
    $_SESSION['toastType'] = "toast-success";
  } else {
    $_SESSION['toastMsg'] = "Error updating event: " . $conn->error;
    $_SESSION['toastType'] = "toast-error";
  }
  $stmt->close();
  header("Location: calendar");
  exit();
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
  <link rel="stylesheet" href="../../assets/bootstrap/css/style.css?v=1.6">
  <!-- end css -->
  <!-- Remix icon -->
  <link rel="stylesheet" href="../../assets/RemixIcon/fonts/remixicon.css">
</head>

<body class="bg-light">

  <!-- include side bar start -->
  <?php include 'include/alert.php'; ?>
  <?php include 'include/sidebar.php'; ?>
  <?php include 'confirmation.php'; ?>
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
                  <a class="doc-link" href="page_management">Highlights</a>
                </li>
                <li class="me-3">
                  <a class="doc-link" href="partnership">Partnership</a>
                </li>
                <li class="me-3">
                  <a class="doc-link active" href="calendar">University Calendar</a>
                </li>
                <li class="me-3">
                  <a class="doc-link" href="FaQ">FAQ</a>
                </li>
              </ul>
              <hr class="doc-tabs-divider">
            </div>
            <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
              <h5 class="card-title fs-6 mb-2 mb-md-0">University Calendar</h5>
              <button type="button" class="btn btn-sm rounded-2 px-4 btn-dynamic float-end" data-bs-toggle="modal"
                data-bs-target="#exampleModal" TOOLTIP: data-bs-toggle="tooltip" data-bs-placement="top"
                title="Click to add a new event">
                <i class="ri-add-line"></i> Add Event in Calendar </button>
            </div>
            <p class="card-text text-muted small">Stay informed with the key academic dates, deadlines and events to
              help you plan your academic journey.</p>
            <!-- Modal to add hightlights start -->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
              aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h1 class="modal-title fw-bold text-muted" id="exampleModalLabel" style="font-size: 18px;">Add Event
                      in Calendar</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <form action="../../function/event_calendar.php" method="POST">
                      <div class="mb-3">
                        <label for="monthInput" class="form-label fw-semibold text-muted">Choose Month:</label>
                        <input type="month" class="form-control" id="monthInput" name="uc_month" required>
                      </div>
                      <div class="mb-3">
                        <label for="dayInput" class="form-label fw-semibold text-muted">Day:</label>
                        <input type="number" class="form-control" id="dayInput" name="uc_day" placeholder="day" min="1"
                          max="31" required>
                      </div>
                      <div class="mb-3">
                        <label for="titleInput" class="form-label fw-semibold text-muted">Event Title:</label>
                        <textarea class="form-control" id="titleInput" name="uc_title"
                          placeholder="Event Title" required></textarea>
                      </div>
                      <div class="mb-3">
                        <label for="descriptionInput" class="form-label fw-semibold text-muted">Description:</label>
                        <textarea class="form-control border border-2 rounded-2" id="descriptionInput"
                          name="uc_description" rows="5" placeholder="Event Description"></textarea>
                      </div>
                      <button type="submit" class="btn btn-dynamic btn-md float-end" data-bs-toggle="tooltip"
                        data-bs-placement="top" title="Click to save">
                        <i class="ri-save-fill"></i> Save
                      </button>
                    </form>
                  </div>
                </div>
              </div>
            </div>
            <!-- Modal to add hightlights end -->
            <div class="log_container mt-4">
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

                  <!-- <select id="sortBy" class="form-select">
                    <option value="">Sort By</option>
                    <option value="date">Sort by Date</option>
                    <option value="time">Sort by Time</option>
                  </select> -->
                </div>
              </div>

              <div class="table-container">
                <table class="table table-hover text-center" id="activityTable">
                  <thead>
                    <tr>
                      <th>Day</th>
                      <th>Month</th>
                      <th>Event Title</th>
                      <th>Event Description</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    include '../../connection/dbconnection.php';

                    // Fetch events from the university_calendar table
                    $query = "SELECT uc_id, uc_title, uc_month, uc_day, uc_description 
                FROM university_calendar 
                ORDER BY uc_month ASC";
                    $result = mysqli_query($conn, $query);

                    if ($result && mysqli_num_rows($result) > 0) {
                      while ($row = mysqli_fetch_assoc($result)) {
                        $uc_id = $row['uc_id'];
                        $day = $row['uc_day'];
                        $month = date("F", strtotime($row['uc_month']));
                        $title = $row['uc_title'];
                        $description = $row['uc_description'];
                    ?>
                        <tr>
                          <td><?php echo $day; ?></td>
                          <td><?php echo $month; ?></td>
                          <td><?php echo $title; ?></td>
                          <td><?php echo !empty($description) ? $description : '<span class="text-muted fst-italic">No description provided</span>'; ?></td>
                          <td class="text-center">
                            <div class="dropdown">
                              <button class="btn btn-light btn-sm" type="button" data-bs-toggle="dropdown" data-bs-toggle="tooltip"
                                data-bs-placement="top" title="Click here to see the action">
                                <i class="ri-more-2-fill"></i>
                              </button>
                              <ul class="dropdown-menu">

                                <li>
                                  <a href="#" class="dropdown-item text-dark" data-bs-toggle="modal" data-bs-target="#editEventModal"
                                    onclick="loadEditEvent(<?php echo $uc_id; ?>)" data-bs-toggle="tooltip"
                                    data-bs-placement="top" title="Click here to edit this event"><i class="ri-pencil-line"></i> Edit</a>
                                </li>
                                <li>
                                  <a href="javascript:void(0);" class="dropdown-item text-dark text-decoration-none"
                                    data-id="<?= $uc_id ?>" onclick="openModal(event, this.dataset.id);" data-bs-toggle="tooltip"
                                    data-bs-placement="top" title="Click here to delete this event"><i class="ri-delete-bin-line"></i>
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
                      echo "<tr><td colspan='4' class='text-center text-muted'>No events found.</td></tr>";
                    }
                    ?>
                  </tbody>
                </table>
                <div class="d-flex justify-content-center">
                  <ul class="pagination custom-pagination mt-2"></ul>
                </div>
              </div>
            </div>
            <!-- container nav -->

            <!-- container nav -->
        

            <!-- Edit Event Modal -->
            <div class="modal fade" id="editEventModal" tabindex="-1" aria-labelledby="editEventModalLabel"
              aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h1 class="modal-title fw-bold text-muted" id="editEventModalLabel" style="font-size: 18px;">Edit
                      Event</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <form id="editEventForm" action="" method="POST">
                      <input type="hidden" name="uc_id" id="editUcId" />
                      <div class="mb-3">
                        <label for="editMonthInput" class="form-label fw-semibold text-muted">Choose Month:</label>
                        <input type="month" class="form-control" id="editMonthInput" name="uc_month" required />
                      </div>
                      <div class="mb-3">
                        <label for="editDayInput" class="form-label fw-semibold text-muted">Day:</label>
                        <input type="number" class="form-control" id="editDayInput" name="uc_day" placeholder="Day"
                          min="1" max="31" maxlength="2"
                          oninput="this.value = this.value.slice(0, 2); this.value = Math.min(Math.max(this.value, 1), 31);"
                          required />
                      </div>
                      <div class="mb-3">
                        <label for="editTitleInput" class="form-label fw-semibold text-muted">Event Title:</label>
                        <textarea class="form-control" id="editTitleInput" name="uc_title"
                          placeholder="Event Title" required></textarea>
                      </div>
                      <div class="mb-3">
                        <label for="editDescriptionInput" class="form-label fw-semibold text-muted">Description:</label>
                        <textarea class="form-control border border-2 rounded-2" id="editDescriptionInput"
                          name="uc_description" rows="5" placeholder="Event Description"></textarea>
                      </div>
                      <button type="submit" name="edit_event" class="btn btn-dynamic btn-md float-end" data-bs-toggle="tooltip"
                        data-bs-placement="top" title="Click to save">
                        <i class="ri-save-fill"></i> Save
                      </button>
                    </form>
                  </div>
                </div>
              </div>
            </div>
            <!-- Modal for edit end-->
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
  <script src="../../assets/bootstrap/js/logs.js"></script>
  <script src="../../assets/bootstrap/js/activeLink.js"></script>
  <script src="../../assets/bootstrap/js/site_settings.js?=v2.5"></script>
  <!-- end js -->

  <!-- script for limiting number into 31 start -->
  <script>
    document.getElementById('dayInput').addEventListener('input', function() {
      if (this.value > 31) this.value = 31;
      if (this.value < 1) this.value = 1;
    });
  </script>
  <!-- script for limiting number into 31 end -->

  <script>
    function loadEditEvent(uc_id) {
      // Send AJAX request to fetch event details
      $.ajax({
        url: '../../function/fetch_event_details.php', // Backend file to fetch event details
        method: 'GET',
        data: {
          uc_id: uc_id
        },
        dataType: 'json',
        success: function(response) {
          if (response.success) {
            // Populate the modal fields with the fetched data
            $('#editUcId').val(response.data.uc_id);
            $('#editMonthInput').val(response.data.uc_month);
            $('#editDayInput').val(response.data.uc_day);
            $('#editTitleInput').val(response.data.uc_title);
            $('#editDescriptionInput').val(response.data.uc_description);
          } else {
            alert('Error: Unable to load event details.');
          }
        },
        error: function() {
          alert('An error occurred while fetching event details.');
        },
      });
    }
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

  <!-- START >> JS SCRIPT IN DELETE CONFIRMATION -->
  <script>
    document.addEventListener("DOMContentLoaded", function() {
      window.openModal = function(event, uc_id) {
        event.preventDefault();
        document.getElementById("modalUcId").value = uc_id; // Set event ID
        document.getElementById("confirmationModal-calendar").style.display = "flex";
      };

      window.closeModal = function() {
        document.getElementById("confirmationModal-calendar").style.display = "none";
      };

      window.closeModalOutside = function(event) {
        if (event.target.id === "confirmationModal-calendar") {
          closeModal();
        }
      };
    });
  </script>
  <!-- END >> JS SCRIPT IN DELETE CONFIRMATION -->
</body>

</html>