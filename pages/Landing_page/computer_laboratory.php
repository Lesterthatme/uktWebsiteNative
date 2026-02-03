<?php include 'banner.php'; ?>
<?php include 'breadcrumbs.php'; ?>
<?php include 'connection/dbconnection.php';

$query = "SELECT comlab_description FROM computer_laboratory WHERE up_id = 1";
$result = mysqli_query($conn, $query);
$comlab_data = mysqli_fetch_assoc($result);

$comlab_description = $comlab_data['comlab_description'] ?? 'No description available.';


// Get the image from universityprofile_image
$imgQuery = "SELECT comlab_image FROM computer_laboratory_image";
$imgResult = mysqli_query($conn, $imgQuery);

$comlab_images = [];
if ($imgResult && mysqli_num_rows($imgResult) > 0) {
    while ($row = mysqli_fetch_assoc($imgResult)) {
        $comlab_images[] = $row['comlab_image'];
    }
}

?>


<div class="container text-center pt-0">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-6" style="max-height: 500px; overflow-y: auto;">
                    <p><?php echo $comlab_description; ?></p>

                </div>

                <!-- Right: Image Carousel start-->
                <div class="col-md-6">
                    <div id="labCarousel" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            <?php if (!empty($comlab_images)): ?>
                                <?php foreach ($comlab_images as $index => $image): ?>
                                    <div class="carousel-item <?php echo $index === 0 ? 'active' : ''; ?>">

                                        <img src="assets/uploads/computer laboratory/<?php echo htmlspecialchars($image); ?>"
                                            class="d-block w-100 img-fluid rounded border mt-3"
                                            alt="Lab Image <?php echo $index + 1; ?>"
                                            style="height: 400px; object-fit: cover;" data-bs-toggle="modal"
                                            data-bs-target="#imageModal"
                                            onclick="showImageInModal(this.src)">
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <!-- Fallback for no image -->
                                <div class="carousel-item active text-center">
                                    <img src="assets/uploads/no-image.png"
                                        class="d-block w-100 img-fluid rounded border mt-3"
                                        alt="No Image Available"
                                        style="height: 400px; object-fit: contain;">
                                    <p class="mt-2">No Image Available</p>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Carousel Controls -->
                        <?php if (!empty($comlab_images) && count($comlab_images) > 1): ?>
                            <button class="carousel-control-prev" type="button" data-bs-target="#labCarousel" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon"></span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#labCarousel" data-bs-slide="next">
                                <span class="carousel-control-next-icon"></span>
                            </button>
                        <?php endif; ?>
                    </div>
                </div>
                <!-- Right: Image Carousel end-->
            </div>
        </div>
    </div>
</div>
<!-- viewing comlab end -->