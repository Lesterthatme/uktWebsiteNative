<?php
session_start();

include '../../connection/dbconnection.php';

$sql = "SELECT university_street, city_municipality, university_province, university_country, 
               university_postalcode, university_contactnumber, university_emailaddress
        FROM university_profile 
        WHERE up_id = 1";

$result = mysqli_query($conn, $sql);

if ($row = mysqli_fetch_assoc($result)) {
  // Format address without postal code
  $address = $row['university_street'] . ', ' . $row['city_municipality'] . ', ' .
    $row['university_province'] . ', ' . $row['university_country'];

  // Keep postal code separately for display purposes but not for Google Maps query
  $postal_code = $row['university_postalcode'];
  $contact = $row['university_contactnumber'];
  $email = $row['university_emailaddress'];

  // Encode the address for use in Google Maps, excluding the postal code
  $google_maps_address = urlencode($address);
} else {
  $address = "Not available";
  $postal_code = "Not available";
  $contact = "Not available";
  $email = "Not available";
  $google_maps_address = "";
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
  }
}
// Fetch all site settings end
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <link rel="icon" type="image/png" href="../../assets/uploads/site settings/favicon/<?php echo htmlspecialchars($settings['fav_icon']); ?>" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo htmlspecialchars($settings['websitetitle_admin']); ?></title>
  <link rel="stylesheet" href="../../assets/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="../../assets/bootstrap/css/style.css?=v1.6"> 
  <link rel="stylesheet" href="../../assets/RemixIcon/fonts/remixicon.css">
</head>

<body class="bg-light">

 <!-- include side bar start -->
 <?php include 'include/alert.php'; ?>
  <?php include 'confirmation.php'; ?>
  <?php include 'include/sidebar.php'; ?>
  <!-- include side bar end -->

  <main class="bg-light">

    <!-- include navbar start -->
    <?php include 'include/navbar.php'; ?>
    <!-- include navbar end -->

    <!-- start: Content -->
    <div class="p-4">
      <div class="row">
        <div class="card border-0 pb-3">
          <div class="card-body">
            <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
              <h5 class="card-title fs-6 mb-2 mb-md-0">Contact and Location</h5>
            </div>
            <!-- Page Poster start -->
            <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
              <div class="contact-card">
                <p>
                  <i class="ri-map-pin-2-fill"></i>
                <div>
                  <strong>Address:</strong> <?php echo $address; ?>
                </div>
                </p>
                <p>
                  <i class="ri-phone-fill"></i>
                <div>
                  <strong>Phone:</strong> <?php echo $contact; ?>
                </div>
                </p>
                <p>
                  <i class="ri-mail-fill"></i>
                <div>
                  <strong>Email:</strong> <?php echo $email; ?>
                </div>
                </p>
              </div>
            </div>

            <!-- Page Poster End-->
            <?php if (!empty($google_maps_address)) : ?>
              <div class="map-container">
                <iframe
                  width="100%"
                  height="300"
                  style="border:0"
                  loading="lazy"
                  allowfullscreen
                  referrerpolicy="no-referrer-when-downgrade"
                  src="https://www.google.com/maps/embed/v1/place?key=AIzaSyBBT_caDc1fw74uDxF6-Xi8Eh-Nm3mvj6Q&q=<?php echo $google_maps_address; ?>">
                </iframe>
              </div>
            <?php endif; ?>
          </div>
        </div>
      </div>
      <?php include 'include/footer.php'; ?>
    </div>
  </main>

  <!-- start js -->
  <script src="../../assets/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../../assets/bootstrap/js/jquery-3.7.1.js"></script>
  <script src="../../assets/bootstrap/js/script.js"></script>
  <script src="../../assets/bootstrap/js/page_poster.js"></script>
  <script src="../../assets/bootstrap/js/drag_and_drop.js?=1.1"></script>
  <script src="../../assets/bootstrap/js/activeLink.js?v=1.2"></script>
  <script src="../../assets/bootstrap/js/table.js"></script>
  <script src="../../assets/bootstrap/js/site_settings.js"></script>
  <!-- end js -->
</body>

</html>