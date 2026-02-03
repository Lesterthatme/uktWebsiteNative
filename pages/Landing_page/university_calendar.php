
<?php include 'banner.php'; ?>
<?php include 'breadcrumbs.php'; ?>
<?php
// RUN THE QUERY AGAIN for the table
$sql = "SELECT uc_day, UPPER(DATE_FORMAT(STR_TO_DATE(uc_month, '%Y-%m-%d'), '%M')) AS uc_month, uc_title, uc_description FROM university_calendar";
$result = $conn->query($sql);
?>
<!-- Main container -->
<div class="container">
  <div class="row">
    <!-- Main content column (8 columns on large screens) -->
    <div class="col-lg-8" data-aos="fade-up" data-aos-delay="200">
      <div class="log_container mt-5">
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
            <!-- Optional sort dropdown -->
          </div>
        </div>

        <div class="table-container">
          <div class="table-responsive"> <!-- Added table-responsive class -->
            <table class="table text-justify table-bordered" id="activityTable">
              <thead>
                <tr>
                  <th>Month</th>
                  <th>Day</th>
                  <th>Title</th>
                  <th>Description</th>
                </tr>
              </thead>
              <tbody>
                <?php while ($university_calendar = $result->fetch_assoc()): ?>
                  <tr>
                    <td><?= htmlspecialchars($university_calendar['uc_month']) ?></td>
                    <td><?= htmlspecialchars($university_calendar['uc_day']) ?></td>
                    <td><?= htmlspecialchars($university_calendar['uc_title']) ?></td>
                    <td>
                      <?= empty($university_calendar['uc_description']) 
                        ? '<span class="text-muted fst-italic">No description provided</span>' 
                        : htmlspecialchars($university_calendar['uc_description']) ?>
                    </td>
                  </tr>
                <?php endwhile; ?>
              </tbody>
            </table>
          </div> <!-- End of table-responsive -->

          <div class="d-flex justify-content-center">
            <ul class="pagination custom-pagination mt-2"></ul>
          </div>
        </div>
      </div>
    </div>

    <!-- Sidebar column (4 columns on large screens) -->
    <div class="col-lg-4 sidebar" data-aos="fade-up" data-aos-delay="200">
      <?php include 'widgets.php'; ?>
    </div>
  </div>
</div>
<!-- End of main section -->
