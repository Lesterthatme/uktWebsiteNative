<?php include 'banner.php'; ?>
<?php include 'breadcrumbs.php'; ?>

<div class="container" data-aos="fade-up" data-aos-delay="200">

    <?php
    include 'connection/dbconnection.php';

    if (!$conn) {
        die("Database connection failed: " . mysqli_connect_error());
    }
    $sql = "SELECT * FROM rector WHERE status = 'Active' ORDER BY date_appointed DESC LIMIT 1";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $card = $result->fetch_assoc();
        ?>
        <div class="rector-container mt-4 p-4">
            <div class="row align-items-center">
                <div class="col-md-4 text-center">
                    <img src="assets/uploads/rector_image/<?= htmlspecialchars($card['image']) ?>" alt="Rector"
                        class="rector-image img-fluid">
                </div>
                <div class="col-md-8">
                    <div class="rector-title mt-3">Dr. <?= htmlspecialchars($card['first_name']) ?>
                        <?= htmlspecialchars($card['last_name']) ?>
                    </div>
                    <p class="rector-description mt-3">
                        <?= $card['rector_details'] ?> <!-- Summernote content rendered as HTML -->
                    </p>
                </div>
            </div>
        </div>
        <?php
    } else {
        echo "<p class='text-center text-danger'>No active rector data available.</p>";
    }
    ?>


    <h3 class="mt-5 section-title"><i class="ri-group-line"></i> Previous Rector</h3>
    <?php
    include 'connection/dbconnection.php';

    if (!$conn) {
        die("Database connection failed: " . mysqli_connect_error());
    }
    $sql = "SELECT * FROM rector WHERE status = 'Active' ORDER BY date_appointed DESC LIMIT 100 OFFSET 1";
    $result = $conn->query($sql);
    ?>

    <div class="univ-management-container my-5">
        <?php
        if ($result && $result->num_rows > 0) {
            while ($card = $result->fetch_assoc()) {
                ?>
                <div class="univ-management-item">
                    <img src="assets/uploads/rector_image/<?= htmlspecialchars($card['image']) ?>" alt="Person">
                    <div class="univ-management-details">
                        <h3><?= htmlspecialchars($card['first_name']) ?><?= htmlspecialchars($card['last_name']) ?></h3>
                        <p>សម្ដេច ហ៊ុន សែន</p>
                    </div>
                </div>
                <?php
            }
        } else {
            echo "<p class='text-center text-danger'>No additional active rectors found.</p>";
        }
        ?>
    </div>

</div>