<?php
include 'connection/dbconnection.php';

$page = isset($_GET['page']) ? $_GET['page'] : 'home';
$pagePath = "pages/Landing_page/$page.php";
if (!preg_match('/^[a-zA-Z0-9_-]+$/', $page)) {
  $pagePath = "pages/Landing_page/home.php";
} elseif (!file_exists($pagePath)) {
  $pagePath = "pages/Landing_page/under_construction.php";
}

// Fetch all site settings start
$settings = [];
$sql = "SELECT * FROM site_settings LIMIT 1";
$result = mysqli_query($conn, $sql);

if ($row = mysqli_fetch_assoc($result)) {
    $settings = $row;

    if (!empty($settings)) {
        $title_admin = htmlspecialchars($settings['websitetitle_admin']);
        $title_cm = htmlspecialchars($settings['websitetitle_cm']);
        $website_tagline = htmlspecialchars($settings['website_tagline']);
        $website_background = htmlspecialchars($settings['website_background']);
    }
}
// Fetch all site settings end
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" type="image/png" href="assets/uploads/site settings/favicon/<?php echo htmlspecialchars($settings['fav_icon']); ?>" />
  <title>University of Kratie</title>
  <link href="assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
  <link href="assets/RemixIcon/fonts/remixicon.css" rel="stylesheet" />
  <!-- Custom CSS -->
  <link rel="stylesheet" href="assets/bootstrap/css/landing_page_updated.css?v=8.1" />
  <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css" />
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap-icons/bootstrap-icons.css" />
  <link rel="stylesheet" href="assets/RemixIcon/fonts/remixicon.css" />
  <!-- AOS Animation -->
  <link rel="stylesheet" href="https://unpkg.com/aos@2.3.1/dist/aos.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.3/dist/css/splide.min.css">
  
</head>
<body class="index-page">

<!-- include navbar -->
<?php include 'landing_page_include/navbar.php'; ?>
<!-- include navbar -->
<main>
  <?php include $pagePath; ?>
</main>
<!-- include footer -->
<?php include 'landing_page_include/footer.php'; ?>
<!-- include footer -->
<!-- Bootstrap Script -->
<script src="assets/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="assets/bootstrap/js/site_settings.js?v=<?= time(); ?>"></script>

<!--<script src="assets/bootstrap/js/landing_nav.js"></script>-->
<script src="assets/bootstrap/js/landingpage.js?v=1.1"></script>
<script src="assets/bootstrap/js/splide.js"></script>
<script src="assets/bootstrap/js/logs.js"></script>
<script src="assets/bootstrap/js/dynamic_pagetitle_newjuly.js?v=12.7"></script>
<!-- AOS Script -->
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.3/dist/js/splide.min.js"></script>
<script
  src="https://cdn.jsdelivr.net/npm/@splidejs/splide-extension-auto-scroll@0.4.0/dist/js/splide-extension-auto-scroll.min.js"></script>
<script>
  AOS.init();
</script>
<script>
  window.addEventListener("scroll", function () {
    let scrollPosition = window.scrollY * 0.1;
    document.querySelector(".president-card").style.backgroundPosition = `center ${scrollPosition * 0.5}px`;
  });
</script>
<script>
  document.addEventListener('DOMContentLoaded', function () {
    new Splide('#calendar_splide', {
      type: 'loop',
      perPage: 2,
      perMove: 1,
      gap: '20px',
      autoplay: true,
      interval: 3000,
      pauseOnHover: true,
      pagination: true,
      arrows: false,
      breakpoints: {
        768: {
          perPage: 1
        }
      }
    }).mount();
  });
</script>


</body>

</html>