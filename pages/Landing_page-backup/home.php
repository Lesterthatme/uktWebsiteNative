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
<div class="container section-container">
  <div class="row g-3">
    <?php while ($card = $result->fetch_assoc()): ?>
      <div class="col-lg-4 col-md-6 d-flex" data-aos="fade-up" data-aos-duration="1000">
        <div class="content-item">
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
<?php $conn->close(); ?>
<!-- END >> DISPLAY HIGHLIGHTS -->

<!-- START >> DISPLAY RECTOR -->
<div class="president-card">
  <div class="image-container" data-aos="zoom-out" data-aos-duration="1500">
    <img src="assets/images/rector1.jpg" alt="University President">
  </div>
  <div class="info" data-aos="zoom-out" data-aos-duration="1500">
    <h2>Dr. Laymithuna Ngy</h2>
    <h4>Rector</h4>
    <p>Dr. Laymithuna Ngy is committed to leading the university with excellence, fostering innovation, and ensuring
      academic success for all students.</p>
    <a href="?page=rector">Read More</a>
  </div>
</div>
<!-- END >> DISPLAY RECTOR -->

<!-- START >> DISPLAY PARTNERSHIP -->
<?php
include 'connection/dbconnection.php';
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$query = "SELECT up_link, up_image FROM university_partnership";
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
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Fetch announcements
$sql = "SELECT * FROM announcement LIMIT 3";
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
    while ($announcement = $result->fetch_assoc()) {
      echo '
        <div class="announcement-card" data-aos="fade-up" data-aos-delay="700">
          <img src="assets/uploads/announcement/' . htmlspecialchars($announcement['announcement_image']) . '" />
          <div class="announcement-content">
            <h3 class="announcement-title">' . htmlspecialchars($announcement['announcement_title']) . '</h3>
            <p class="announcement-desc">' . htmlspecialchars($announcement['announcement_description']) . '</p>
            <a href="#" class="announcement-btn">Read More <i class="ri-arrow-right-line"></i></a>
          </div>
        </div>';
    }
    ?>
  </div>

  <div class="view-all-container">
    <a href="?page=read_more" class="view-all-btn">
      VIEW ALL ANNOUNCEMENTS <i class="ri-arrow-right-line"></i>
    </a>
  </div>
</section>

<?php $conn->close(); ?>
<!-- END >> DISPLAY ANNOUNCEMENT -->

<!-- START >> DISPLAY NEWS -->
<?php
include 'connection/dbconnection.php';
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
    while ($news = $result->fetch_assoc()) {
      echo '
        <div class="news-card" data-aos="fade-up" data-aos-delay="800">
          <img src="assets/uploads/news/' . htmlspecialchars($news['news_image']) . '" alt="News Image" />
          <div class="news-content">
            <h3 class="news-title">' . htmlspecialchars($news['news_title']) . '</h3>
            <p class="news-desc">' . htmlspecialchars($news['news_description']) . '</p>
            <a href="#" class="news-btn">Read More <i class="ri-arrow-right-line"></i></a>
          </div>
        </div>';
    }
    ?>
  </div>

  <div class="view-all-container">
    <a href="?page=news" class="view-all-btn">
      VIEW ALL NEWS <i class="ri-arrow-right-line"></i>
    </a>
  </div>
</section>

<?php $conn->close(); ?>
<!-- END >> DISPLAY NEWS -->

<!-- START >> DISPLAY UNIVERSITY CALENDAR --> 
<?php
include 'connection/dbconnection.php';
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$sql = "SELECT uc_day, DATE_FORMAT(STR_TO_DATE(uc_month, '%Y-%m-%d'), '%b') AS uc_month, uc_title, uc_description FROM university_calendar";

$result = $conn->query($sql);
?>

<div class="calendar-container my-3" data-aos="fade-up" data-aos-delay="500">
  <h2>University Calendar</h2>
  <p>Keep track of important university events, academic schedules, and activities with our calendar.</p>

  <div class="container">
    <div class="splide p-5" id="calendar_splide" aria-label="Upcoming University Events">
      <div class="splide__track calendar_track">
        <ul class="splide__list">
          <?php while ($university_calendar = $result->fetch_assoc()) : ?>
            <li class="splide__slide">
              <div class="calendar_event_card d-flex">
                <div class="calendar_event_date">
                  <span><?= htmlspecialchars($university_calendar['uc_day']) ?></span>
                  <small><?= htmlspecialchars($university_calendar['uc_month']) ?></small>
                </div>
                <div>
                  <h3 class="calendar_event_title_text"><?= htmlspecialchars($university_calendar['uc_title']) ?></h3>
                  <p class="calendar_event_desc mb-1"><?= htmlspecialchars($university_calendar['uc_description']) ?></p>
                </div>
              </div>
            </li>
          <?php endwhile; ?>
        </ul>
      </div>
      <div class="splide__pagination"></div>
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
$query = "SELECT * FROM university_album LIMIT 3";
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
            <div class="gallery-item">
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
        <a href="?page=university_album" class="news-btn w-25 mt-5">View University Album</a>
      </div>
    </div>
  </div>
</section>
<?php $conn->close(); ?>
<!-- END >> DISPLAY UNIVERSITY ALBUM -->


<?php
include 'connection/dbconnection.php';
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM faq";
$result = $conn->query($sql);
?>
<section class="faq-container" data-aos="fade-up" data-aos-delay="800">
  <h2 class="faq-title">Frequently Asked Questions</h2>
  <p class="text-center">Explore our FAQ section for answers to common questions about the university, academic
    programs, admissions, and campus life.</p>

  <div class="accordion" id="faqAccordion">
    <?php 
    $faqIndex = 1;
    while ($faq = $result->fetch_assoc()) : 
    ?>
      <div class="accordion-item">
        <h2 class="accordion-header" id="faq<?= $faqIndex ?>-heading">
          <div class="d-flex justify-content-between align-items-center">
            <button class="accordion-button collapsed flex-grow-1 text-start" type="button" data-bs-toggle="collapse"
              data-bs-target="#faq<?= $faqIndex ?>-collapse" aria-expanded="false" aria-controls="faq<?= $faqIndex ?>-collapse">
              <?= htmlspecialchars($faq['faq_question']) ?>
            </button>
            <div class="dropdown three-dots-accord me-3">
              <button class="btn p-0 border-0 bg-none" type="button" data-bs-toggle="dropdown" aria-expanded="false"
                title="More Actions">
                <span></span><span></span><span></span>
              </button>
              <ul class="dropdown-menu dropdown-menu-end">
                <li><a class="dropdown-item" href="#">Edit</a></li>
                <li><a class="dropdown-item text-danger" href="#">Delete</a></li>
              </ul>
            </div>
          </div>
        </h2>
        <div id="faq<?= $faqIndex ?>-collapse" class="accordion-collapse collapse" aria-labelledby="faq<?= $faqIndex ?>-heading"
          data-bs-parent="#faqAccordion">
          <div class="accordion-body">
            <?= htmlspecialchars($faq['faq_answer']) ?>
          </div>
        </div>
      </div>
    <?php 
    $faqIndex++; 
    endwhile; 
    ?>
  </div>
</section>
<!-- END >> DISPLAY FAQ -->

<?php $conn->close(); ?>
