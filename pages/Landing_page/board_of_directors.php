<?php include 'banner.php'; ?>
<?php include 'breadcrumbs.php'; ?>

<!-- START >> DISPLAY BOARD OF DIRECTORS -->
<?php
include 'connection/dbconnection.php';

$sql = "SELECT * FROM board_of_director WHERE status = 'Active'";
$result = $conn->query($sql);
?>

<div class="container my-5" data-aos="fade-up" data-aos-delay="200">
    <div class="univ-management-container">
        <?php
        if ($result && $result->num_rows > 0) {
            while ($card = $result->fetch_assoc()) {
                ?>
                <div class="univ-management-item">
                    <img src="assets/uploads/board_of_directors_image/<?= htmlspecialchars($card['image']) ?>" alt="Person">
                    <div class="univ-management-details">
                        <h3><?= htmlspecialchars($card['first_name']) ?>         <?= htmlspecialchars($card['last_name']) ?></h3>
                    </div>
                </div>
                <?php
            }
        } else {
            echo "<p class='text-center text-danger'>No active board members found.</p>";
        }
        ?>
    </div>
</div>
<!-- END >> DISPLAY BOARD OF DIRECTORS -->