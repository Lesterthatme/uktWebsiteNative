<?php include 'banner.php'; ?>
<?php include 'breadcrumbs.php'; ?>
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
<?php
include 'connection/dbconnection.php';

$query = "SELECT requirement_id, requirement_title, date_added, status, description 
          FROM admission_requirement WHERE status = 'Active'
          ORDER BY date_added DESC";

$result = mysqli_query($conn, $query);
?>
<div class="container">
    <div class="row">
        <!-- Main content column -->
        <div class="col-lg-8">
            <div class="row">
                <?php
                $query = "SELECT * FROM admission_requirement ORDER BY date_added DESC";
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

                                        <div class="d-flex align-items-center gap-2">
                                            <small class="text-muted">
                                                <?= date("F d, Y", strtotime($row['date_added'])) ?>
                                            </small>

                                            <!-- Copy Button -->
                                            <button
                                                class="btn btn-secondary btn-sm copy-btn"
                                                data-link="#">
                                                Copy
                                            </button>
                                        </div>
                                    </div>
                                    <!-- Content -->
                                    <p class="post-text mb-2 caption">
                                        <?= $row['description'] ?>
                                    </p>
                                    <!-- See More Button -->
                                    <button class="btn btn-link p-0 see-more-btn">See more</button>
                                </div>
                                <!-- Image -->
                                <!--  -->
                                <img src="<?php echo !empty($row['image'])
                                                ? '/ukt/assets/uploads/student/scholarship/' . $row['image']
                                                : 'default.png'; ?>"
                                    class="img-fluid rounded-bottom"
                                    alt="img">

                            </div>
                        </div>
                    <?php
                    }
                } else { ?>
                    <div class="col-12 mt-2">
                        <div class="card shadow-sm border-0 text-center py-5">
                            <div class="card-body">

                                <!-- Icon -->
                                <div class="mb-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor" class="text-muted" viewBox="0 0 16 16">
                                        <path d="M4 1a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V6.5L9.5 1H4zm5 1.5L13.5 7H10a1 1 0 0 1-1-1V2.5z" />
                                    </svg>
                                </div>

                                <!-- Message -->
                                <h5 class="fw-bold mb-2">No Posts Yet</h5>
                                <p class="text-muted mb-3">
                                    There are currently no admission requirements posted.
                                    Please check back later.
                                </p>

                                <!-- Optional Action -->
                                <a href="" class="btn btn-primary btn-sm">
                                    Refresh Page
                                </a>

                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>

        <!-- Sidebar column -->
        <div class="col-lg-4 sidebar mt-0">
            <?php include 'widgets.php'; ?>
        </div>
    </div>
</div>

<script>
    document.querySelectorAll('.copy-btn').forEach(button => {
        button.addEventListener('click', function() {
            const link = this.getAttribute('data-link');

            navigator.clipboard.writeText(link).then(() => {
                this.innerText = "Copied!";

                setTimeout(() => {
                    this.innerText = "Copy";
                }, 2000);
            });
        });
    });
</script>