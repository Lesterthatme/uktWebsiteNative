<?php
include 'connection/dbconnection.php';

function slugify($text) {
  $text = preg_replace('~[^\pL\d]+~u', '-', $text);
  $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
  $text = preg_replace('~[^-\w]+~', '', $text);
  $text = trim($text, '-');
  $text = preg_replace('~-+~', '-', $text);
  return strtolower($text);
}

if (isset($_GET['news_slug'])) {
  $slug = $_GET['news_slug'];
  $sql = "SELECT * FROM news";
  $result = mysqli_query($conn, $sql);

  $news = null;
  while ($row = mysqli_fetch_assoc($result)) {
    if (slugify($row['news_title']) === $slug) {
      $news = $row;
      break;
    }
  }

  if (!$news) {
    echo "<p class='text-danger text-center mt-5'>News not found.</p>";
    exit;
  }
} else {
  echo "<p class='text-danger text-center mt-5'>No news specified.</p>";
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
            <img src="assets/uploads/news/<?php echo htmlspecialchars($news['news_image']); ?>" alt="News Image" class="img-fluid rounded">
          </div>
          <!--<h6 class="mt-4 fw-bold text-center"><?php echo htmlspecialchars($news['news_title']); ?></h6>-->
          <p class="mt-3 fs-6 text-justify">
            <?php echo nl2br(htmlspecialchars($news['news_description'])); ?>
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
