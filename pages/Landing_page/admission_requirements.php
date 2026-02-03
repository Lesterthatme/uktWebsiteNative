
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
                <div class="col justify-content-center mt-5">
                    <?php
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            $title = htmlspecialchars($row['requirement_title']);
                            $description = $row['description']; // Keep HTML
                            $date_added = date("F d, Y", strtotime($row['date_added']));
                            ?>
                            <div class="card mb-4 shadow-sm">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo $title; ?></h5>
                                    <p class="card-text text-muted"><small>Date Added: <?php echo $date_added; ?></small></p>
                                    <p class="card-text"><?php echo $description; ?></p> <!-- Renders stored HTML -->
                                </div>
                            </div>
                            <?php
                        }
                    } else {
                        echo "<div class='alert alert-warning'>No Information as of now.</div>";
                    }
                    ?>
                </div>
            </div>
        </div>

        <!-- Sidebar column -->
        <div class="col-lg-4 sidebar mt-0">
            <?php include 'widgets.php'; ?>
        </div>
    </div>
</div>
