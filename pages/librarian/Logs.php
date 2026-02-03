<?php
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

            <!-- Page Poster start -->
            <div class="log_container">
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
                  <input type="text" id="searchBar" class="form-control" placeholder="Search logs...">
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
                      <th>Usertype</th>
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
                              WHERE u.user_type = 'Librarian' 
                              AND h.user_id = ?
                              ORDER BY h.log_date DESC, h.log_time DESC";

                    $stmt = mysqli_prepare($conn, $query);
                    mysqli_stmt_bind_param($stmt, "i", $user_id);
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);

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
                      echo "<tr><td colspan='4' class='text-center'>No logs available</td></tr>";
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
</body>

</html>
