<?php include 'banner.php'; ?>
<?php include 'breadcrumbs.php'; ?>
<?php include 'connection/dbconnection.php'; ?>

<div class="container mt-5 pb-5">
  <div class="my-4">
    <!-- List of Forms -->
    <div class="file-grid">
      <?php
      if (!$conn) {
        die("Database connection failed: " . mysqli_connect_error());
      }

      $sql = "SELECT form_id, form_name, form_description, form_path, date_uploaded 
              FROM university_form ORDER BY date_uploaded DESC";
      $result = $conn->query($sql);

      if (!$result) {
        die("Query failed: " . $conn->error);
      }

      $fileIcons = [
        'pdf' => 'ri-file-pdf-line text-danger text-center',
        'doc' => 'ri-file-word-line text-primary',
        'docx' => 'ri-file-word-line text-primary',
        'xls' => 'ri-file-excel-line text-success text-center',
        'xlsx' => 'ri-file-excel-line text-success',
        'csv' => 'ri-file-excel-line text-success',
        'ppt' => 'ri-file-ppt-line text-warning',
        'pptx' => 'ri-file-ppt-line text-warning',
        'txt' => 'ri-file-text-line text-muted',
        'zip' => 'ri-folder-zip-line text-secondary',
        'rar' => 'ri-folder-zip-line text-secondary',
        'default' => 'ri-file-line text-dark'
      ];

      if ($result->num_rows > 0) {
      ?>
        <div class="table-container">
          <div class="table-responsive">
            <table class="table table-bordered" id="studentTable">
              <thead>
                <tr class="text-center">
                  <th>File Name</th>
                  <th>Date Uploaded</th>
                  <th>Attachment</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody class="text-center">
                <?php while ($row = $result->fetch_assoc()) {
                  $form_name = htmlspecialchars($row['form_name']);
                  $form_path = htmlspecialchars($row['form_path']);
                  $date_uploaded = date("d M Y", strtotime($row['date_uploaded']));
                  $fileExt = strtolower(pathinfo($form_path, PATHINFO_EXTENSION));
                  $iconClass = $fileIcons[$fileExt] ?? $fileIcons['default'];
                ?>
                  <tr>
                    <td><?php echo $form_name; ?></td>
                    <td><?php echo $date_uploaded; ?></td>
                    <td><span class="file-icon"><i class="<?php echo $iconClass; ?>"></i></span></td>
                    <td>
                      <a href="uploads/<?php echo $form_path; ?>" download class="download-link">
                        <i class="ri-download-2-line"></i>
                      </a>
                    </td>
                  </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
          <div class="d-flex justify-content-center">
            <ul class="pagination custom-pagination mt-2"></ul>
          </div>
        </div>
      <?php
      } else {
        echo "<p class='text-center text-danger'>No forms available.</p>";
      }
      ?>
    </div>
  </div>
</div>
<script src="assets/bootstrap/js/logs.js"></script>
