<?php
include 'connection/dbconnection.php';
$sql = "SELECT site_banner FROM site_settings";
$result = $conn->query($sql);

$site_banner = ''; // default value
if ($result && $result->num_rows > 0) {
    $settings = $result->fetch_assoc();
    $site_banner = 'assets/uploads/site settings/website banner/' . htmlspecialchars($settings['site_banner']);
}
?>
<style>
    .about-banner {
        position: relative;
        height: 45vh;
        /*background: linear-gradient(to right, rgba(78, 78, 78, 0.64), rgba(0, 70, 0, 0.57)), url('assets/uploads/site settings/website banner/<?php echo htmlspecialchars($settings['site_banner']); ?>')*/
        /*background: linear-gradient(to right, rgba(78, 78, 78, 0.64), rgba(0, 70, 0, 0.57)), url('assets/images/aboutunivprofile.png');*/
        background-size: cover;
        background-position: center;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center ;
        padding: 20px;
        background-attachment: fixed;
    }

    .banner-content {
        max-width: 700px;
    }

    .banner-tag {
        background: white;
        color: darkgreen;
        padding: 5px 10px;
        font-weight: bold;
        display: inline-block;
        border-radius: 5px;
    }

    .about-banner-updated {
        border-bottom: : 4px solid white;
        padding-left: 15px;
        margin-top: 15px;
    }
</style>

<section class="about-banner" style="background-image: linear-gradient(to right, rgba(78, 78, 78, 0.64), rgba(0, 70, 0, 0.57)), url('<?php echo $site_banner; ?>');">
    <div class="banner-content">
        <span class="banner-tag" data-aos="fade-down">ABOUT</span>
        <h1 class="mt-3 fw-bold" data-aos="fade-up" data-aos-delay="200"></h1>
        <p class="about-banner-updated" data-aos="fade-up" data-aos-delay="400">Know more about our university.</p>
    </div>
</section>
