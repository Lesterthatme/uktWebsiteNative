
<?php include 'banner.php'; ?>
<?php include 'breadcrumbs.php'; ?>
<?php
include 'connection/dbconnection.php';
include_once 'landing_page_include/slugify.php';
$sql = "SELECT announcement_id, announcement_image, announcement_title, announcement_description FROM announcement";
$result = mysqli_query($conn, $sql);
?>

<div class="container">
  <div class="row">
    <!-- Main content column (8 columns on large screens) -->
    <div class="col-lg-8" data-aos="fade-up" data-aos-delay="200">
      <div class="row">
        <div class="announcement-container my-5 text-center">
          <?php
          if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
            //   $announcement_id = $row['announcement_id'];
              $announcement_image = !empty($row['announcement_image']) ? $row['announcement_image'] : 'default.jpg';
              $announcement_title = htmlspecialchars($row['announcement_title']);
              $announcement_description = nl2br(htmlspecialchars($row['announcement_description']));
               $announcement_slug = slugify($row['announcement_title']);
              ?>
              <div class="announcement-card">
                <img src="assets/uploads/announcement/<?php echo $announcement_image; ?>" alt="Announcement Image" />
                <div class="announcement-content">
                  <h3 class="announcement-title"><?php echo $announcement_title; ?></h3>
                  <p class="announcement-desc"><?php echo $announcement_description; ?></p>
                  <a href="announcement_view?announcement_slug=<?php echo $announcement_slug; ?>" class="news-btn">
                    Read More <i class="ri-arrow-right-line"></i>
                  </a>

                </div>
              </div>
              <?php
            }
          } else {
            echo "<p class='text-muted'>No announcements available.</p>";
          }
          ?>
        </div>
      </div>
    </div>

    <!-- Sidebar column (4 columns on large screens) -->
    <div class="col-lg-4 sidebar" data-aos="fade-up" data-aos-delay="200">
      <?php include 'widgets.php'; ?>
    </div>
  </div>
</div>
</section>