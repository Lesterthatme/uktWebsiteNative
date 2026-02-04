<style>
    .footer {
        position: relative;
        /* background: url('../../images/univ.jpg') center center/cover no-repeat; */
        background-attachment: fixed;
        /* Sticky background */
        color: white;
        padding: 40px 0;
        text-align: left;
        font-family: 'Poppins', sans-serif;
    }
</style>

<?php
include 'connection/dbconnection.php';
$sql = "SELECT website_footerbg FROM site_settings";
$result = $conn->query($sql);

$website_footerbg = '';
if ($result && $result->num_rows > 0) {
    $settings = $result->fetch_assoc();
    $website_footerbg = 'assets/uploads/site settings/website footer/' . htmlspecialchars($settings['website_footerbg']);
}
?>
<footer class="footer" style="background:url('<?php echo $website_footerbg; ?>')center center/cover no-repeat;background-attachment: fixed;">
    <div class="container">
        <div class="row">
            <?php
            include 'connection/dbconnection.php';

            $sql = "SELECT university_street, city_municipality, university_province, university_country, 
               university_postalcode, university_contactnumber, university_emailaddress
        FROM university_profile 
        WHERE up_id = 1";

            $result = mysqli_query($conn, $sql);
            if ($result && mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                $address = $row['university_street'] . ", " . $row['city_municipality'] . ", " . $row['university_province'] . ", " . $row['university_country'] . ", " . $row['university_postalcode'];
                $contact = $row['university_contactnumber'];
                $email = $row['university_emailaddress'];
            } else {
                $address = "No profile available";
                $contact = "No contact number available";
                $email = "No email available";
            }

            ?>

            <!-- University Info -->
            <div class="col-lg-4 col-md-6">
                <img src="assets/images/officiallogo (1).png" alt="University Logo" class="footer-logo">
                <h4 class="footer-text">UNIVERSITY OF KRATIE</h4>
                <p><strong>Contact Us</strong></p>
                <p><?php echo $address; ?></p>
                <p>Phone: <?php echo $contact; ?></p>
                <p>Email: <a href="mailto:<?php echo $email; ?>"><?php echo $email; ?></a></p>
            </div>


            <!-- More Links -->
            <div class="col-lg-2 col-md-6">
                <h5>More</h5>
                <ul class="footer-links">
                    <li><a href="home">Home</a></li>
                    <li><a href="university_background">University Background</a></li>
                    <li><a href="forms">Student Forms</a></li>
                    <li><a href="job_opportunities">Job Opportunities</a></li>
                </ul>
            </div>

            <!-- Colleges -->
            <div class="col-lg-3 col-md-6">
                <h5>Academics</h5>
                <ul class="footer-links">
                    <?php
                    include 'connection/dbconnection.php';

                    $query = "SELECT * FROM department WHERE dm_status = 'Active' ORDER BY dm_name ASC";

                    $result = mysqli_query($conn, $query);
                    if ($result) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            // Convert department name to a URL-friendly slug
                            $department_slug = strtolower(str_replace(" ", "-", $row['dm_name']));

                            echo "<li><a href='colleges?department_slug=" . urlencode($department_slug) . "'>" . $row['dm_name'] . "</a></li>";
                        }
                    } else {
                        echo "<li><a href='#'>No Departments Found</a></li>";
                    }
                    ?>

                </ul>
            </div>

            <!-- University Partnerships -->
            <div class="col-lg-3 col-md-6">
                <h5>University Partnership</h5>
                <ul class="footer-links">
                    <?php
                    include 'connection/dbconnection.php';

                    $query = "SELECT * FROM university_partnership WHERE up_status = 'Active' ORDER BY up_name ASC";

                    $result = mysqli_query($conn, $query);

                    if ($result) {
                        while ($partner = mysqli_fetch_assoc($result)) {
                            echo "<li><a href='" . htmlspecialchars($partner['up_link']) . "'>" . htmlspecialchars($partner['up_name']) . "</a></li>";
                        }
                    } else {
                        echo "<li><a href='#'>No Partnerships Found</a></li>";
                    }
                    ?>
                </ul>
            </div>

        </div>
        <div class="footer-bottom mt-4">
            <p class="mb-1">Copyright &copy;2025. All Rights Reserved </p>
            <p class="mb-0">Developed by <a href="developers" class="fw-bold text-decoration-none">SCI-GAMES Dev</a></p>
            <button id="translateBtn" class="btn btn-sm text-light">
                <span class="notranslate">English </span> | <span class="notranslate"> Khmer</span>
            </button>
            <?php include 'pages/adminukt/include/translator.php'; ?>


        </div>
</footer>