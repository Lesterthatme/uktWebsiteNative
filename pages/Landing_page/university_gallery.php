<?php include 'banner.php'; ?>
<?php include 'breadcrumbs.php'; ?>
<section class="my-5">
    <?php
include 'connection/dbconnection.php';
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
$query = "SELECT * FROM university_album WHERE status = 'Active' LIMIT 3";
$result = $conn->query($query);
?>
  <div class="container">
    <div class="container gallery-container" data-aos="zoom-in" data-aos-delay="200">
      
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
    </div>
  </div>
</section>