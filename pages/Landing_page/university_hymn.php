<?php include 'banner.php'; ?>
<?php include 'breadcrumbs.php'; ?>
<?php
include 'connection/dbconnection.php';

$query = "
    SELECT 
        uh.hymn_id, 
        uh.hymn_author, 
        uh.hymn_title, 
        uh.hymn_lyrics, 
        up.university_logo 
    FROM university_hymn uh
    CROSS JOIN university_profile up
    WHERE uh.hymn_id = 1
    LIMIT 1";

$result = mysqli_query($conn, $query);

if (!$result) {
    die("Query Failed: " . mysqli_error($conn));
}

$university_data = mysqli_fetch_assoc($result);

$hymn_author = $university_data['hymn_author'];
$hymn_title = $university_data['hymn_title'];
$hymn_lyrics = $university_data['hymn_lyrics'];
$university_logo = $university_data['university_logo'];
?>

<div class="container">
    <div class="row">
        <div class="col-lg-8">
            <div class="row">
                <div class="col justify-content-center text-center p-4 my-3">
                    <h4 class="fw-bold mt-4"><?php echo htmlspecialchars($hymn_title); ?></h4>
                    <small><?php echo htmlspecialchars($hymn_author); ?></small>
                    <p class="lead mt-3"><?php echo $hymn_lyrics; ?></p> 
                </div>
            </div>
        </div>
        <div class="col-lg-4 sidebar mt-0">
            <?php include 'widgets.php'; ?>
        </div>
    </div>
</div>
