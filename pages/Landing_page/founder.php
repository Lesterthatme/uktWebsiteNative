<?php include 'banner.php'; ?>
<?php include 'breadcrumbs.php'; ?>

<?php
include 'connection/dbconnection.php';

$sql = "SELECT * FROM university_founder";
$result = $conn->query($sql);
?>

<div class="container my-5" data-aos="fade-up" data-aos-delay="200">
    <div class="univ-management-container">
        <?php
        if ($result && $result->num_rows > 0) {
            while ($card = $result->fetch_assoc()) {
                ?>
                <div class="univ-management-item">
                    <img src="assets/uploads/founder_image/<?= htmlspecialchars($card['image']) ?>" alt="Person">
                    <div class="univ-management-details">
                        <h3><?= htmlspecialchars($card['founder_fname']) ?>         <?= htmlspecialchars($card['founder_lname']) ?></h3>
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
