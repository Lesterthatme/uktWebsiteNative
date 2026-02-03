<?php include 'banner.php'; ?>
<?php include 'breadcrumbs.php'; ?>
<?php
include 'connection/dbconnection.php';
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM university_profile LIMIT 1";
$result = $conn->query($sql);
$university = $result->fetch_assoc();
?>
<div class="container">
    <div class="row">
        <!-- Main content column (8 columns on large screens) -->
<!-- Main content column -->
<!-- Main content column -->
<div class="col-12 col-lg-8">
    <div class="py-5">
        <div class="container">
            <div class="row justify-content-center">
                <!-- University Logo centered at the top -->
                <div class="col-12 text-center mb-4">
                    <img src="assets/uploads/university_image/<?php echo htmlspecialchars($university['university_logo']); ?>" 
                         alt="University Logo" 
                         class="img-fluid university_logo_up" 
                         style="max-height: 600px;">
                </div>

                <!-- University Info -->
                <div class="col-12">
                    <h4 class="fw-bold text-center"><?php echo htmlspecialchars($university['university_name']); ?></h4>
<div class="info_list mx-auto" style="max-width: 600px;">
    <?php
    // Define info items
    $infoItems = [
        ['ri-user-line', 'Rector', $university['university_president']],
        [
            'ri-map-pin-line',
            'Address',
            $university['university_street'] . ', ' .
            $university['city_municipality'] . ', ' .
            $university['university_province'] . ', ' .
            $university['university_country']
        ],
        ['ri-map-pin-line', 'Postal Code', $university['university_postalcode']],
        ['ri-mail-line', 'Email', $university['university_emailaddress']],
        ['ri-phone-line', 'Telephone', $university['university_contactnumber']],
        ['ri-global-line', 'Website', '<a href="' . htmlspecialchars($university['university_website']) . '" target="_blank">' . htmlspecialchars($university['university_website']) . '</a>'],
        ['ri-facebook-circle-line', 'Facebook', '<a href="' . htmlspecialchars($university['fb_link']) . '" target="_blank">' . htmlspecialchars($university['fb_link']) . '</a>'],
        ['ri-youtube-fill', 'Youtube', '<a href="' . htmlspecialchars($university['youtube_link']) . '" target="_blank">' . htmlspecialchars($university['youtube_link']) . '</a>'],
        ['ri-calendar-line', 'Year Established', $university['university_yearestablished']], 
    ];

    foreach ($infoItems as $item) {
        echo '<div class="row mb-2 align-items-start">';
        echo '  <div class="col-1 text-end"><i class="' . $item[0] . '"></i></div>';
        echo '  <div class="col-11">' . $item[1] . ': ' . $item[2] . '</div>';
        echo '</div>';
    }
    ?>
</div>

                </div>
            </div>
        </div>
    </div>
</div>



<?php $conn->close(); ?>

        <!-- Sidebar column (4 columns on large screens) -->
        <div class="col-lg-4 sidebar mt-0">
            <?php include 'widgets.php'; ?>
        </div>
    </div>
</div>



