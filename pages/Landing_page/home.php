<!-- START >> DISPLAY PAGE POSTER -->


<?php
include 'connection/dbconnection.php';
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
$query = "SELECT poster_image FROM page_poster ORDER BY poster_date DESC";
$result = $conn->query($query);
?>
<section class="splide poster-carousel mb-5" id="poster-carousel" aria-label="Page Poster Carousel">
  <div class="splide__track">
    <ul class="splide__list">
      <?php while ($poster = $result->fetch_assoc()): ?>
        <li class="splide__slide splide_slide_poster">
          <img src="assets/uploads/poster/<?= htmlspecialchars($poster['poster_image']) ?>" alt="Poster">
        </li>
      <?php endwhile; ?>
    </ul>
  </div>
</section>
<?php $conn->close(); ?>
<!-- END >> DISPLAY PAGE POSTER -->

<!-- START >> DISPLAY HIGHLIGHTS -->
<?php
include 'connection/dbconnection.php';
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$result = $conn->query("SELECT * FROM highlight LIMIT 3");
?>
<div class="container section-container my-4">
  <div class="row g-3">
    <?php while ($card = $result->fetch_assoc()): ?>
      <div class="col-lg-4 col-md-6 d-flex" data-aos="fade-up" data-aos-duration="1000">
        <div class="content-item ">
          <div class="icon-wrapper">
            <i class="<?= $card['h_icon'] ?>"></i>
          </div>
          <h5><?= $card['h_title'] ?></h5>
          <p></strong><br><?= $card['h_description'] ?></p>
        </div>
      </div>
    <?php endwhile; ?>
  </div>
</div>
<?php
include 'connection/dbconnection.php';

if (!$conn) {
  die("Database connection failed: " . mysqli_connect_error());
}

$sql = "SELECT * FROM rector WHERE status = 'Active' LIMIT 1";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
  $card = $result->fetch_assoc();

  // Limit rector details to 150 characters without cutting a word
  $rectorText = strip_tags($card['rector_details']); // remove HTML tags if any
  $maxLength = 350;

  if (strlen($rectorText) > $maxLength) {
    $trimmedText = substr($rectorText, 0, $maxLength);
    $lastSpace = strrpos($trimmedText, ' ');
    $rectorText = substr($trimmedText, 0, $lastSpace) . '...';
  }
  ?>
  <div class="president-card">
    <div class="image-container" data-aos="zoom-out" data-aos-duration="1500">
      <img src="assets/uploads/rector_image/<?= htmlspecialchars($card['image']) ?>" alt="University President">
    </div>
    <div class="info" data-aos="zoom-out" data-aos-duration="1500">
      <h3 class="fw-bold"><?= htmlspecialchars($card['first_name']) ?> <?= htmlspecialchars($card['last_name']) ?></h3>
      <h4>Rector</h4>
        
      <p class="text-justify"><?= htmlspecialchars($rectorText) ?></p>
      <a href="rector" class="btn">Read More</a>
    </div>
  </div>
  <?php
} else {
  echo "<p class='text-center text-danger'>No rector details available.</p>";
}
?>

<!-- END >> DISPLAY RECTOR -->

<!-- START >> DISPLAY PARTNERSHIP -->
<?php
include 'connection/dbconnection.php';
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$query = "SELECT up_link, up_image FROM university_partnership WHERE up_status = 'Active'";
$result = $conn->query($query);
?>

<div class="py-5 my-3" data-aos="fade-up" data-aos-delay="800">
  <div class="container">
    <div class="carousel-section">
      <h2>University Partnership</h2>
      <p>We are proud to collaborate with leading universities and institutions worldwide, fostering academic
        excellence, research development, and student opportunities.</p>
    </div>

    <section class="splide" id="logo-carousel" aria-label="University Partnership Carousel">
      <div class="splide__track">
        <ul class="splide__list">
          <?php while ($partner = $result->fetch_assoc()): ?>
            <li class="splide__slide logo-slide">
              <a href="<?= htmlspecialchars($partner['up_link']) ?>" target="_blank">
                <img src="assets/uploads/partnership/<?= htmlspecialchars($partner['up_image']) ?>"
                  alt="University Partner">
              </a>
            </li>
          <?php endwhile; ?>
        </ul>
      </div>
    </section>
  </div>
</div>

<?php $conn->close(); ?>
<!-- END >> DISPLAY PARTNERSHIP -->

<!-- START >> DISPLAY ANNOUNCEMENT -->
<?php
include 'connection/dbconnection.php';
include_once 'landing_page_include/slugify.php';
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM announcement WHERE announcement_status = 'Active' LIMIT 3";
$result = $conn->query($sql);
?>

<section class="announcement p-4 my-3" data-aos="fade-up" data-aos-delay="900">
  <h2>Announcements</h2>
  <p>
    Get the latest updates on academic schedules, events, and important university news. Stay informed and never miss an
    announcement!
  </p>

  <div class="announcement-container">
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


  <div class="view-all-container">
    <a href="announcements" class="view-all-btn">
      <span>VIEW ALL ANNOUNCEMENTS</span> <i class="ri-arrow-right-line"></i>
    </a>
  </div>
</section>

<?php $conn->close(); ?>
<!-- END >> DISPLAY ANNOUNCEMENT -->

<!-- START >> DISPLAY NEWS -->
<?php
include 'connection/dbconnection.php';
include_once 'landing_page_include/slugify.php';
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
$query = "SELECT * FROM news WHERE news_status = 'Active' ORDER BY news_date DESC LIMIT 3";
$result = $conn->query($query);
?>

<!-- START >> DISPLAY NEWS -->
<section class="news-section p-4" data-aos="fade-up" data-aos-delay="800">
  <h2>Latest News</h2>
  <p class="news-text-muted">
    Stay updated with the latest university news, events, and achievements.
  </p>

  <div class="news-container">
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


  <div class="view-all-container ">
    <a href="news" class="view-all-btn ">
      <span>VIEW ALL NEWS </span><i class="ri-arrow-right-line"></i>
    </a>
  </div>
</section>

<?php $conn->close(); ?>
<!-- END >> DISPLAY NEWS -->

<!-- START >> DISPLAY UNIVERSITY CALENDAR -->
<!-- START >> DISPLAY UNIVERSITY CALENDAR -->
<?php
include 'connection/dbconnection.php';
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
$sql = "SELECT uc_day, UPPER(DATE_FORMAT(STR_TO_DATE(uc_month, '%Y-%m-%d'), '%M')) AS uc_month, uc_title, uc_description FROM university_calendar LIMIT 5";



$result = $conn->query($sql);
?>

<div class="calendar-container my-3" data-aos="fade-up" data-aos-delay="500">
  <h2>University Calendar</h2>
  <p>Keep track of important university events, academic schedules, and activities with our calendar.</p>

  <div class="container">
    <div class="row justify-content-center g-4">
      <?php while ($university_calendar = $result->fetch_assoc()): ?>
        <div class="col-12 col-sm-6 col-md-4 col-lg-3 col-xl-2 text-center">
          <div class="calendar-card">
            <div class="calendar-month"><?= htmlspecialchars($university_calendar['uc_month']) ?></div>
            <div class="calendar-day"><?= htmlspecialchars($university_calendar['uc_day']) ?></div>
          </div>
          <div class="calendar-label"><?= htmlspecialchars($university_calendar['uc_title']) ?></div>
          <!--<p class="calendar_event_desc text-center"><?= htmlspecialchars($university_calendar['uc_description']) ?></p>-->
        </div>
      <?php endwhile; ?>
    </div>
     <div class="view-all-container">
    <a href="university_calendar" class="view-all-btn">
      VIEW UNIVERSITY CALENDAR <i class="ri-arrow-right-line"></i>
    </a>
  </div>
  </div>
</div>
<?php $conn->close(); ?>

<!-- END >> DISPLAY UNIVERSITY CALENDAR -->

<!-- START >> DISPLAY UNIVERSITY ALBUM -->
<?php
include 'connection/dbconnection.php';
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
$query = "SELECT * FROM university_album WHERE status = 'Active' LIMIT 3";
$result = $conn->query($query);
?>
<section class="gallery my-5 py-5">
  <div class="container">
    <div class="container gallery-container">
      <h2 class="mb-4" data-aos="fade-up">Explore Our University Moments</h2>
      <p class="text-center" data-aos="fade-up" data-aos-delay="100">
        Discover the best memories from campus life, graduation day, sports events, and more. Click an album to explore
        the images inside.
      </p>

      <div class="row g-4">
        <?php while ($row = $result->fetch_assoc()): ?>
          <?php
          $album_id = $row['album_id'];
          $thumbnail_query = "SELECT image_name FROM university_image WHERE album_id = $album_id LIMIT 1";
          $thumbnail_result = mysqli_query($conn, $thumbnail_query);
          $thumbnail_row = mysqli_fetch_assoc($thumbnail_result);

          // Determine image path
          $thumbnail_path = ($thumbnail_row)
            ? "assets/uploads/university_gallery/" . htmlspecialchars($thumbnail_row['image_name'])
            : "assets/uploads/university_gallery/default_image.jpg";
          ?>
          <div class="col-md-4" data-aos="zoom-in" data-aos-delay="200">
            <div class="gallery-item" style="cursor: pointer;"
              onclick="window.location='view_album?album_id=<?php echo $album_id; ?>'">
              <img src="<?php echo $thumbnail_path; ?>" alt="<?php echo htmlspecialchars($row['album_name']); ?>">
              <div class="gallery-overlay">
                <h3><?php echo htmlspecialchars($row['album_name']); ?></h3>
                <span><?php echo htmlspecialchars($row['album_description']); ?></span>
              </div>
            </div>
          </div>
        <?php endwhile; ?>
      </div>
      <div class="text-center" data-aos="fade-up" data-aos-delay="500">
        <a href="university_gallery" class="news-btn w-25 mt-5">View University Album</a>
      </div>
    </div>
  </div>
</section>
<?php $conn->close(); ?>
<!-- END >> DISPLAY UNIVERSITY ALBUM -->

<!-- START >> DISPLAY FAQ-->
<?php
include 'connection/dbconnection.php';
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM faq WHERE faq_status = 'Active'";
$result = $conn->query($sql);
?>

<section class="faq-container" data-aos="fade-up" data-aos-duration="2000">
  <h2 class="faq-title">Frequently Asked Questions</h2>
  <p class="text-center">Explore our FAQ section for answers to common questions about the university, academic
    programs, admissions, and campus life.</p>

  <?php
  $faqIndex = 1;
  while ($faq = $result->fetch_assoc()):
    ?>
    <div class="accordion" id="faqAccordion<?= $faqIndex ?>">
      <div class="accordion-item">
        <h3 class="accordion-header" id="faq<?= $faqIndex ?>-heading">
          <div class="d-flex justify-content-between align-items-center">
            <button class="accordion-button collapsed flex-grow-1 text-start" type="button" data-bs-toggle="collapse"
              data-bs-target="#faq<?= $faqIndex ?>-collapse" aria-expanded="false"
              aria-controls="faq<?= $faqIndex ?>-collapse">
              <?= htmlspecialchars($faq['faq_question']) ?>
            </button>
          </div>
        </h3>
        <div id="faq<?= $faqIndex ?>-collapse" class="accordion-collapse collapse"
          aria-labelledby="faq<?= $faqIndex ?>-heading" data-bs-parent="#faqAccordion<?= $faqIndex ?>">
          <div class="accordion-body">
            <?= htmlspecialchars($faq['faq_answer']) ?>
          </div>
        </div>
      </div>
    </div>
    <?php
    $faqIndex++;
  endwhile;
  ?>
</section>

<?php $conn->close(); ?>
<!-- END >> DISPLAY FAQ-->