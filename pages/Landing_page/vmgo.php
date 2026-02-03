<?php
include 'connection/dbconnection.php';

$query = "SELECT university_mission, university_vision, university_goal FROM university_vmgo";
$result = mysqli_query($conn, $query);

if (!$result) {
  die("Query Failed: " . mysqli_error($conn));
}

$mission = $vision = $goal = "";

if ($row = mysqli_fetch_assoc($result)) {
  $mission = $row['university_mission'];
  $vision = $row['university_vision'];
  $goal = $row['university_goal'];
}
?>

<?php include 'banner.php'; ?>
<?php include 'breadcrumbs.php'; ?>

<div class="container">
    <div class="row my-5 justify-content-center">
        <div class="col-md-4 mb-2">
            <div class="vmgo_card vision">
                <i class="ri-eye-line"></i>
                <h5>VISION</h5>
                <?php echo ($vision); ?>
            </div>
        </div>

        <div class="col-md-4 mb-2">
            <div class="vmgo_card mission">
                <i class="ri-flag-line"></i>
                <h5>MISSION</h5>
                <?php echo ($mission); ?>
            </div>
        </div>

        <div class="col-md-4 mb-2">
            <div class="vmgo_card goal">
                <i class="ri-trophy-line"></i>
                <h5>GOALS</h5>
                <?php echo ($goal); ?>
            </div>
        </div>
    </div>
</div>




