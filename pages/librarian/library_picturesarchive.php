<?php
session_start();
include '../../connection/dbconnection.php';

if (!isset($_SESSION['session_token'])) {
  header('location:login.php');
  exit;
}

$user_id = $_SESSION['user_id'];

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
                  <a class="doc-link" href="library_updatesarchive">Library Updates Archive</a>
                </li>
                <li class="me-3">
                  <a class="doc-link" href="library_resourcesarchive">Library Resources Archive</a>
                </li>
                <li class="me-3">
                  <a class="doc-link" href="library_researcharchive">Research Projects</a>
                </li>
                <li class="me-3">
                  <a class="doc-link active" href="library_picturesarchive">Library Images</a>
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

              // SQL Query with Proper Conditions
              $query =  "SELECT 
              libraryarchive_id, 
              record_id, 
              original_table,
              archived_at, 
              JSON_UNQUOTE(JSON_EXTRACT(archive_description, '$.libimage_name')) AS libimage_name,
              JSON_UNQUOTE(JSON_EXTRACT(archive_description, '$.libalbum_name')) AS libalbum_name
           FROM library_archive
           ORDER BY archived_at DESC"; 

              $result = $conn->query($query);

              if (!$result) {
                echo "<div class='alert alert-danger'>Error: " . $conn->error . "</div>";
              }
              ?>

              <div class="table-container">
                <table class="table table-hover text-center align-middle" id="activityTable">
                  <thead>
                    <tr>
                      <th>Type</th>
                      <th>File</th>
                      <th>Date Archived</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                      while ($row = $result->fetch_assoc()) {
                        $libimage_name = htmlspecialchars($row['libimage_name']);
                        $libalbum_name = htmlspecialchars($row['libalbum_name']);
                        $archived_at = date("F j, Y, g:i A", strtotime($row['archived_at']));
                        $original_table = htmlspecialchars($row['original_table']);

                        // Identify Type
                        $type = ($original_table === 'library_album') ? 'Album' : 'Library Image';

                        // Display File based on Original Table
                        if ($original_table === 'library_album') {
                          $file_display = $libalbum_name;  // Show file name for albums
                        } else {
                          $image_src = "assets/uploads/library_gallery/" . $libimage_name;
                          $file_display = "<img src='$image_src' alt='$libimage_name' 
                                         style='width: 60px; height: 60px; object-fit: cover; border-radius: 5px;'>";
                        }

                        echo "<tr>
                            <td>$type</td>
                            <td>$file_display</td>
                            <td>$archived_at</td>
                            <td>
                                <div class='dropdown'>
                                    <button class='btn btn-light btn-sm' type='button' 
                                            data-bs-toggle='dropdown' aria-expanded='false'>
                                        <i class='ri-more-2-fill'></i>
                                    </button>
                                    <ul class='dropdown-menu'>
                                        <li>
                                            <a class='dropdown-item text-success' 
                                               href='function/restore_function.php?restoreimage_id=" . $row['record_id'] . "' 
                                               onclick='return confirm(\"Do you want to restore this item?\")'>
                                               Restore
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                          </tr>";
                      }
                    } else {
                      echo "<tr><td colspan='4'>No archived items available</td></tr>";
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
  <script src="../../assets/bootstrap/js/site_settings.js?v=1.0"></script>
  <script src="../../assets/bootstrap/js/logs.js"></script>
  <script src="../../assets/script.js"></script> <!-- this script is for disabling multiple login in session -->
  <script src="../../assets/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../../assets/bootstrap/js/jquery-3.7.1.js"></script>
  <script src="../../assets/bootstrap/js/script.js"></script>
  <script src="../../assets/bootstrap/js/page_poster.js"></script>
  <script src="../../assets/bootstrap/js/drag_and_drop.js?=1.1"></script>
  <script src="../../assets/bootstrap/js/activeLink.js?v=1.2"></script>
  <!-- end js -->

  
</body>

</html>