

<?php include 'banner.php'; ?>
<?php include 'breadcrumbs.php'; ?>
<?php
include 'connection/dbconnection.php';
include_once 'landing_page_include/slugify.php';
$query = "SELECT news_id, news_image, news_title, news_description FROM news ORDER BY news_date DESC";
$result = mysqli_query($conn, $query);

?>
<div class="container">
  <div class="row">
    <!-- Main content column -->
    <div class="col-lg-8" data-aos="fade-up" data-aos-delay="200">
      <div class="row">
        <section class="news-section p-4 my-3">
          <div class="news-container text-center">
          <?php
          if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
              $news_image = !empty($row['news_image']) ? $row['news_image'] : 'default.jpg';
              $news_title = htmlspecialchars($row['news_title']);
              $news_description = nl2br(htmlspecialchars($row['news_description']));
              $news_slug = slugify($row['news_title']);
          ?>
              <div class="news-card">
                <img src="assets/uploads/news/<?php echo $news_image; ?>" alt="News Image" />
                <div class="news-content">
                  <h3 class="news-title"><?php echo $news_title; ?></h3>
                  <p class="news-desc"><?php echo $news_description; ?></p>
                  <a href="news_view?news_slug=<?php echo $news_slug; ?>" class="news-btn">
                    Read More <i class="ri-arrow-right-line"></i>
                  </a>
                </div>
              </div>
          <?php
            }
          } else {
            echo "<p class='text-muted'>No news articles available.</p>";
          }
          ?>
          </div>
        </section>
      </div>
    </div>
    <!-- Sidebar column -->
    <div class="col-lg-4 sidebar" data-aos="fade-up" data-aos-delay="200">
      <?php include 'widgets.php'; ?>
    </div>
  </div>
</div>


