<?php
include '../../connection/dbconnection.php';
session_start();

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
  <link rel="stylesheet" href="../../assets/bootstrap/css/style.css?=v1.7">
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
        <div class="card border-0">
          <div class="card-body">

            <!-- Page Poster start -->
            <div class="log_container ">
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

              <div class="table-container">
                <table class="table table-hover" id="activityTable">
                  <thead>
                    <tr>
                      <th>Username</th>
                      <th>User Type</th>
                      <th>Description</th>
                      <th>Log Date</th>
                      <th>Log Time</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $query = "SELECT h.description, h.log_date, h.log_time, u.username, u.user_type 
                              FROM history_log h
                              JOIN user_account u ON h.user_id = u.user_id
                              ORDER BY h.log_date DESC, h.log_time DESC";

                    $result = mysqli_query($conn, $query);

                    if (mysqli_num_rows($result) > 0) {
                      while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>
                                <td>{$row['username']}</td>
                                <td>{$row['user_type']}</td>
                                <td>{$row['description']}</td>
                                 <td>" . date('F d Y', strtotime($row['log_date'])) . "</td>
                                <td>" . date('h:i A', strtotime($row['log_time'])) . "</td>
                              </tr>";
                      }
                    } else {
                      echo "<tr><td colspan='5' class='text-center'>No logs available</td></tr>";
                    }
                    ?>
                  </tbody>
                </table>
                <div class="d-flex justify-content-center">
                  <ul class="pagination custom-pagination mt-2"></ul>
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
  <script src="../../assets/bootstrap/js/page_poster.js"></script>
  <script src="../../assets/bootstrap/js/drag_and_drop.js?=1.1"></script>
  <script src="../../assets/bootstrap/js/activeLink.js?v=2.0"></script>
  <script src="../../assets/bootstrap/js/logs.js?v=1.1"></script>
  <script src="../../assets/bootstrap/js/site_settings.js"></script>
  <!-- end js -->

</body>

</html>