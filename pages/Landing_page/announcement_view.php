<?php
include 'connection/dbconnection.php';
include_once 'landing_page_include/slugify.php';

if (isset($_GET['announcement_slug'])) {
  $slug = $_GET['announcement_slug'];
  $sql = "SELECT * FROM announcement";
  $result = mysqli_query($conn, $sql);

  $announcement = null;
  while ($row = mysqli_fetch_assoc($result)) {
    // Corrected column name from 'announcemennt_title' to 'announcement_title'
    if (slugify($row['announcement_title']) === $slug) {
      $announcement = $row;
      break;
    }
  }

  if (!$announcement) {
    echo "<p class='text-danger text-center mt-5'>Announcement not found.</p>";
    exit;
  }
} else {
  echo "<p class='text-danger text-center mt-5'>No Announcement specified.</p>";
  exit;
}
?>

<?php include 'banner.php'; ?>
<?php include 'breadcrumbs.php'; ?>

<div class="container">
  <div class="row">
    <!-- Main content column (8 columns on large screens) -->
    <div class="col-lg-8">
      <div class="row">
        <div class="col justify-content-center mt-5">
          <div class="news-image">
            <!-- Display the announcement image -->
            <img src="assets/uploads/announcement/<?php echo htmlspecialchars($announcement['announcement_image']); ?>" alt="Announcement Image" class="img-fluid rounded">
          </div>
          <p class="mt-3 fs-6">
            <!-- Display the announcement description -->
            <?php echo nl2br(htmlspecialchars($announcement['announcement_description'])); ?>
          </p>
        </div>
      </div>
    </div>

    <!-- Sidebar column (4 columns on large screens) -->
    <div class="col-lg-4 sidebar mt-0">
      <?php include 'widgets.php'; ?>
    </div>
  </div>
</div>
