<?php
require '../../connection/dbconnection.php';
session_start();

// Fetch admission requirements
$sql = "SELECT * FROM admission_requirement ";
$result = $conn->query($sql);

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
  <link rel="stylesheet" href="../../assets/bootstrap/css/style.css?v=3.1">
  <!-- end css -->
  <!-- Remix icon -->
  <link rel="stylesheet" href="../../assets/RemixIcon/fonts/remixicon.css">


</head>

<body class="bg-light">

  <!-- include side bar start -->
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
            </div>
            <p class="card-text text-muted small"></p>
            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h1 class="modal-title fs-5 text-muted fw-bold" id="exampleModalLabel">Add Form</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">

                    <form>
                      <div class="mb-3">
                        <label class="form-label fw-semibold text-muted">Upload Forms:</label>
                        <div class="upload-area" id="formUploadArea">
                          <img src="https://cdn-icons-png.flaticon.com/512/126/126477.png" alt="Upload Icon" width="50">
                          <p class="mb-0">Drag & Drop <br><span class="text-success">or browse</span></p>
                          <small class="text-muted">Supports: PDF, DOC, DOCX</small>
                          <input type="file" id="formFileInput" class="d-none" accept=".pdf, .doc, .docx">
                        </div>
                        <div id="fileContainer" class="mt-3"></div>
                      </div>
                    </form>

                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-success"><i class="ri-save-fill"></i> Save</button>
                  </div>
                </div>
              </div>
            </div>
            <!-- container nav -->

            <div class="doc-tabs-container mt-3">
              <ul class="doc-tabs d-flex list-unstyled">
                <li class="me-3">
                  <a class="doc-link" href="pending_account">Pending</a>
                </li>
                <li class="me-3">
                  <a class="doc-link active" href="approved_account">Approved</a>
                </li>


              </ul>
              <hr class="doc-tabs-divider">
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

                  <div class="float-end">
                    <!-- <h5 class="card-title fs-6 mb-2 mb-md-0">Highlights</h5> -->
                    <button type="button" class="btn btn-sm rounded-2 px-4 btn-dynamic float-end MT-1"
                      data-bs-toggle="modal" data-bs-target="#addUser" data-bs-toggle="tooltip"
                      data-bs-placement="top" title="Click to add content manager">
                      <i class="ri-add-line"></i> Add User </button>
                  </div>
                </div>
                 <!-- START >> ADD USER MODAL -->
                 <div class="modal fade" id="addUser" tabindex="-1" aria-labelledby="exampleModalLabel"
                  aria-hidden="true">
                  <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h1 class="modal-title fs-5 text-muted fw-bold" id="exampleModalLabel">Add Form</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">

                        <form action="../../function/add_accountfunction.php" method="POST"
                          enctype="multipart/form-data">
                          <div class="profile-pic-container">
                            <img src="../../assets/images/profile (1).png" alt="Profile Picture" id="profile-pic">
                            <label for="profile-upload" class="upload-icon">
                              <i class="ri-camera-fill"></i>
                            </label>
                            <input type="file" id="profile-upload" name="image" accept="image/*"
                              onchange="previewImage(event)">

                          </div>
                          <div class="row mb-3">
                            <div class="col-md-4">
                              <label for="first_name" class="form-label"><strong>First Name</strong></label>
                              <input type="text" class="form-control" id="first_name" name="first_name"
                                placeholder="Enter Firstname" required>
                            </div>
                            <div class="col-md-4">
                              <label for="middle_name" class="form-label"><strong>Middle Name</strong></label>
                              <input type="text" class="form-control" id="middle_name" name="middle_name"
                                placeholder="Enter Middlename">
                            </div>
                            <div class="col-md-4">
                              <label for="last_name" class="form-label"><strong>Last Name</strong></label>
                              <input type="text" class="form-control" id="last_name" name="last_name"
                                placeholder="Enter Lastname" required>
                            </div>
                          </div>

                          <div class="row mb-3">
                            <div class="col-md-4">
                              <label for="birthday_name" class="form-label"><strong>Birthday</strong></label>
                              <input type="date" class="form-control" id="birthday" name="birthday" required>
                            </div>
                            <div class="col-md-4">
                              <label for="age" class="form-label"><strong>Age</strong></label>
                              <input type="number" class="form-control" id="age" name="age" min="10" max="100"
                                style="width: 60px;">
                            </div>
                            <div class="col-md-4">
                              <label for="sex" class="form-label"><strong>Sex</strong></label>
                              <select class="form-control" id="sex" name="sex" required>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                              </select>
                            </div>
                          </div>

                          <div class="row mb-3">
                            <div class="col-md-8">
                              <label for="full_address" class="form-label"><strong>Address:</strong></label>
                              <input type="text" class="form-control" id="full_address" name="full_address"
                                placeholder="House number / Street / Municipality / Province / Country" required>
                            </div>

                            <div class="col-md-4">
                              <label for="contact_number" class="form-label"><strong>Contact number:</strong></label>
                              <input type="number" class="form-control" id="contact_number" name="contact_number"
                                placeholder="Enter contact number" required>
                            </div>
                          </div>

                          <hr>

                          <div class="row mb-3">
                            <div class="col-md-4">
                              <label for="email" class="form-label"><strong>Email</strong></label>
                              <input type="email" class="form-control" id="email" name="email"
                                placeholder="Enter e-mail" required>
                            </div>
                            <div class="col-md-4">
                              <label for="username" class="form-label"><strong>Username</strong></label>
                              <input type="text" class="form-control" id="username" name="username"
                                placeholder="Enter username" required>
                            </div>
                            <div class="col-md-4">
                              <label for="password" class="form-label"><strong>Password</strong></label>
                              <input type="password" class="form-control" id="password" name="password"
                                placeholder="Enter password" required>
                            </div>
                          </div>

                          <!-- <div class="mb-3">
                            <label for="role" class="form-label"><strong>Role</strong></label>
                            <select class="form-control w-auto" id="role" name="role" required
                              style="min-width: 180px;">
                              <option value="content_manager" selected>Content Manager</option>
                              <option value="librarian" selected>Librarian</option>
                            </select>
                          </div> -->
                      </div>
                      <div class="modal-footer">
                        <button type="submit" name="add_account" class="btn btn-dynamic"  data-bs-toggle="tooltip" 
                        data-bs-placement="top" title="Click to save"><i class="ri-save-fill"></i>
                          Save</button>
                      </div>
                    </div>
                    </form>
                  </div>
                </div>
                <!-- END >> ADD USER MODAL -->

              </div>
              <?php
              include '../../connection/dbconnection.php';

              $query = "SELECT ua.user_id, ua.username, ua.email, ua.image, ua.user_type, ua.account_status,
                           ap.ap_firstname, ap.ap_mi, ap.ap_lastname, ap.birthday, ap.age, ap.sex
                           FROM user_account ua
                           LEFT JOIN authorized_person ap ON ua.user_id = ap.user_id
                           WHERE ua.account_status = 'approved'";

              $result = $conn->query($query);
              ?>

              <!-- Viewing Approved Accounts Start -->
              <div class="table-container">
                <table class="table table-hover" id="activityTable" style="width: 100%;">
                  <thead>
                    <tr>
                      <th class="text-center">Image</th>
                      <th class="text-center">Full Name</th>
                      <th class="text-center">User Type</th>
                      <th class="text-center">Account Status</th>
                      <th class="text-center">Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php if ($result->num_rows > 0): ?>
                      <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                          <td class="text-center">
                            <img src="../../assets/uploads/profile_pic/<?= (!empty($row['image']) && file_exists("../../assets/uploads/profile_pic/" . $row['image']))
                                                                          ? htmlspecialchars($row['image']) : 'profile (1).png' ?>"
                              alt="User" class="img-fluid rounded"
                              style="width: 40px; height: 40px; object-fit: cover;">
                          </td>
                          <td class="text-center">
                            <?= htmlspecialchars($row['ap_firstname'] . ' ' . ($row['ap_mi'] ? $row['ap_mi'] . ' ' : '') . $row['ap_lastname']) ?>
                          </td>
                          <td class="text-center"><?= htmlspecialchars($row['user_type']) ?></td>
                          <td class="text-center">
                            <?php
                            $status = isset($row['account_status']) ? strtolower($row['account_status']) : 'unknown';
                            $badgeClass = ($status === 'pending') ? 'status-badge-danger' : 'status-badge';
                            ?>
                            <span class="<?= htmlspecialchars($badgeClass) ?>">
                              <?= htmlspecialchars(ucfirst($status)) ?>
                            </span>
                          </td>
                          <td class="text-center">
                            <div class="dropdown">
                              <button class="btn btn-light btn-sm" type="button" data-bs-toggle="dropdown" aria-expanded="false"
                                data-bs-toggle="tooltip" data-bs-placement="top"
                                title="Click here to see the action">
                                <i class="ri-more-2-fill"></i>
                              </button>
                              <ul class="dropdown-menu">
                                <li>
                                  <a class="dropdown-item text-dark view-profile" href="#" data-bs-toggle="modal"
                                    data-bs-target="#profileModal<?= $row['user_id'] ?>" data-bs-toggle="tooltip" data-bs-placement="top"
                                    title="Click to view profile">
                                    <i class="ri-eye-line"></i> View Profile
                                  </a>
                                </li>
                                <li>
                                  <a class="dropdown-item text-dark" href="../../function/block_user.php?user_id=<?= $row['user_id'] ?>"
                                    onclick="return confirm('Are you sure you want to block this user?');" data-bs-toggle="tooltip" data-bs-placement="top"
                                    title="Click to blocked the user">
                                    <i class="ri-user-forbid-fill"></i> Block User
                                  </a>
                                </li>

                              </ul>
                            </div>
                          </td>
                        </tr>

                        <!-- Start Modal for Each User -->
                        <div class="modal fade" id="profileModal<?= $row['user_id'] ?>" tabindex="-1" aria-labelledby="profileModalLabel<?= $row['user_id'] ?>" aria-hidden="true">
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title fw-bold text-muted" id="profileModalLabel<?= $row['user_id'] ?>">Profile Details</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                              </div>
                              <div class="modal-body text-center">
                                <img src="../../assets/uploads/profile_pic/<?= (!empty($row['image']) && file_exists("../../assets/uploads/profile_pic/" . $row['image']))
                                                                              ? htmlspecialchars($row['image']) : 'default-profile.jpeg' ?>"
                                  alt="Profile Picture" class="rounded-circle" width="100">
                                <h5 class="mt-2"><?= htmlspecialchars($row['ap_firstname'] . ' ' . ($row['ap_mi'] ? $row['ap_mi'] . ' ' : '') . $row['ap_lastname']) ?></h5>
                                <p class="text-muted"><?= htmlspecialchars($row['email']) ?></p>
                                <hr>
                                <p><strong>Role:</strong> <?= htmlspecialchars($row['user_type']) ?></p>
                                <p><strong>Birthday:</strong> <?= htmlspecialchars($row['birthday']) ?></p>
                                <p><strong>Age:</strong> <?= htmlspecialchars($row['age']) ?></p>
                                <p><strong>Sex:</strong> <?= htmlspecialchars($row['sex']) ?></p>

                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                              </div>
                            </div>
                          </div>
                        </div>
                        <!-- End Modal -->

                      <?php endwhile; ?>
                    <?php else: ?>
                      <tr>
                        <td colspan="5" class="text-center text-warning">No approved accounts found.</td>
                      </tr>
                    <?php endif; ?>
                  </tbody>
                </table>
                <div class="d-flex justify-content-center">
                  <ul class="pagination custom-pagination mt-2"></ul>
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
  <script src="../../assets/bootstrap/js/carousel.js?=v1.0"></script>
  <script src="../../assets/bootstrap/js/formDrag_and_Drop.js"></script>
  <script src="../../assets/bootstrap/js/activeLink.js?v=1.5"></script>
  <script src="../../assets/bootstrap/js/logs.js"></script>
  <script src="../../assets/bootstrap/js/site_settings.js?v=1.4"></script>
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