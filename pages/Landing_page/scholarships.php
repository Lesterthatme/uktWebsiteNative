<?php include 'banner.php'; ?>
<?php include 'breadcrumbs.php'; ?>

<!-- Summernote Styles & Scripts -->
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
<?php
include 'connection/dbconnection.php';


?>
<style>
    .post-text {
        max-height: 80px;
        /* limit height */
        overflow: hidden;
        transition: max-height 0.3s ease;
    }

    .post-text.expanded {
        max-height: 1000px;

    }

    .see-more-btn {
        display: none;

    }
</style>

<div class="container">
    <div class="row">
        <!-- Main content column -->
        <div class="col-lg-8 mt-5 ">
            <div class="row">
                <?php
                $query = "SELECT * FROM university_scholarship ORDER BY date_added DESC";
                $result = mysqli_query($conn, $query);
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                ?>
                        <div class="col-12 mb-3">
                            <div class="card shadow-sm border-0">

                                <div class="card-body">

                                    <!-- Header -->
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <h2 class="mb-0 fw-bold"><?= $row['scholarship_title'] ?></h2>
                                        <small class="text-muted"><?= date("F d, Y", strtotime($row['date_added'])) ?></small>
                                    </div>


                                    <!-- Content -->
                                    <p class="post-text mb-2 caption">
                                        <?= $row['description'] ?>

                                    </p>


                                    <!-- See More Button -->
                                    <button class="btn btn-link p-0 see-more-btn">See more</button>

                                </div>

                                <!-- Image -->
                                <img src="<?php echo !empty($row['image'])
                                                ? '/ukt/assets/uploads/student/scholarship/' . $row['image']
                                                : 'default.png'; ?>"
                                    class="img-fluid rounded-bottom"
                                    alt="img">

                            </div>
                        </div>
                <?php
                    }
                }
                ?>


            </div>
        </div>

        <!-- Sidebar column -->
        <div class="col-lg-4 sidebar mt-0">
            <?php include 'widgets.php'; ?>
        </div>
    </div>
</div>
<script src="/ukt/assets/js/scholarship.js" defer></script>