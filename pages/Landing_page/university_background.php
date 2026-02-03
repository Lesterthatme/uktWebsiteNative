<?php include 'banner.php'; ?>
<?php include 'breadcrumbs.php'; ?>
<?php
include 'connection/dbconnection.php';
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$query = "SELECT university_logo, university_name, university_background FROM university_profile WHERE up_id = 1";
$result = mysqli_query($conn, $query);
$university_data = mysqli_fetch_assoc($result);

$university_logo = $university_data['university_logo'];
$university_name = $university_data['university_name'];
$university_background = $university_data['university_background'];

// Get the image from universityprofile_image start
$imgQuery = "SELECT up_image FROM universityprofile_image LIMIT 2";
$imgResult = mysqli_query($conn, $imgQuery);

$up_images = [];
if ($imgResult && mysqli_num_rows($imgResult) > 0) {
  while ($row = mysqli_fetch_assoc($imgResult)) {
    $up_images[] = $row['up_image'];
  }
}
// Get the image from universityprofile_image end
?>

<!--<div class="container mt-5">-->
<!--    <div class="row">-->
<!--        <div class="col justify-content-center text-center">-->
<!--            <img class="university_logo_up"-->
<!--                src="assets/uploads/university_image/<?php echo htmlspecialchars($university['university_logo']); ?>"-->
<!--                alt="<?php echo htmlspecialchars($university['university_name']); ?> Logo">-->
<!--            <div class="mt-3 summernote-content">-->
<!--                <?php echo $university['university_background']; ?>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<!--    <?php $conn->close(); ?>-->
<!--</div>-->

 <!-- viewing university start -->
            <div class="container text-center py-5">
              <div class="row justify-content-center">
                <div class="col-md-12 mb-4">
                  <div class="row">
                    <?php foreach ($up_images as $image): ?>
                      <div class="col-md-6 mb-3">
                        <img src="assets/uploads/university_image/<?php echo htmlspecialchars($image); ?>"
                          alt="University Image"
                          class="img-fluid rounded border" />
                      </div>
                    <?php endforeach; ?>
                  </div>
                </div>

                <!-- University name -->
                <div class="col-md-12">
                 <h4 class="fw-bold">
                    <?php echo htmlspecialchars($university_name); ?>
                 </h4>
                </div>

                <!-- Background -->
                <div class="col-md-12">
                  <p><?php echo $university_background; ?></p>
                </div>
              </div>
            </div>
            <!-- viewing university end -->
