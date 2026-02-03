<!-- start sidebar -->
<?php
include '../../connection/dbconnection.php';

// // Fetch the latest library details
$query = "SELECT library_name, library_logo, library_location, library_contact, library_email, library_website FROM library_university LIMIT 1";
$result = mysqli_query($conn, $query);

// Initialize default values to prevent undefined key warnings
$library_name = "University of Kratie";
$library_logo = "../../assets/images/officiallogo (1).png";
$library_location = "";
$library_contact = "";
$library_email = "";
$library_website = "";

// Check if data exists
if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $library_name = $row['library_name'] ?? $library_name;
    $library_logo = !empty($row['library_logo']) ? 'assets/uploads/Library_images/' . $row['library_logo'] : "../../assets/images/officiallogo (1).png";

    $library_location = $row['library_location'] ?? "";
    $library_contact = $row['library_contact'] ?? "";
    $library_email = $row['library_email'] ?? "";
    $library_website = $row['library_website'] ?? "";
}
else {
    $library_name = "University of Kratie"; // Default name
    $library_logo = "../../assets/images/officiallogo (1).png"; // Default logo
}
?>
<div class="sidebar position-fixed top-0 start-0 bottom-0 bg-white">
<div class="d-flex align-items-center p-2">
    <img src="<?php echo htmlspecialchars($library_logo); ?>" alt="Library Logo" class="sidebar-logo-img me-3"
        style="height: 60px; width: 60px; border-radius: 50%; object-fit: cover; border: 3px solid #007bff;">
    <div class="d-flex flex-column">
        <a href="" class="sidebar-logo fw-bold fs-sm text-decoration-none text-color-default d-block mb-0">
            <?php echo htmlspecialchars($library_name); ?>
        </a>
        <span class="text-muted" style="font-size: 11px;">Librarian Panel</span>
    </div>
</div>

    <ul class="sidebar-menu p-3 mt-2 mb-0">
        <li class="sidebar-menu-divider mt-1 mb-1 text-uppercase">Menu</li>

        <!-- dropdown menu here start -->
        <li class="sidebar-menu-item has-dropdown">
            <a href="">
                <i class="ri-pages-fill sidebar-menu-item-icon"></i>
                Library Page Management
                <i class="ri-arrow-down-s-line sidebar-menu-item-accordion ms-auto"></i>
            </a>
            <ul class="sidebar-dropdown-menu">
                <li class="sidebar-dropdown-menu-item">
                    <a href="University_Library_updates">
                        Library Updates
                    </a>
                </li>
                <li class="sidebar-dropdown-menu-item">
                    <a href="University_Library_resources">
                        Library Resources
                    </a>
                </li>
                <li class="sidebar-dropdown-menu-item">
                    <a href="operating_hours">
                        Operating Hours
                    </a>
                </li>
                <li class="sidebar-dropdown-menu-item">
                    <a href="University_Library_Research_Projects">
                        Research Project
                    </a>
                </li>
            </ul>
        </li>
        <!-- dropdown menu here end -->
        <li class="sidebar-menu-item">
            <a href="library_gallery">
            <i class="ri-gallery-view-2 sidebar-menu-item-icon"></i>
                Library Gallery
            </a>
        </li>
        <li class="sidebar-menu-item">
            <a href="library_staff">
                <i class="ri-group-2-fill sidebar-menu-item-icon"></i>
                Library Staff
            </a>
        </li>
        <!-- dropdown menu here start -->
        <li class="sidebar-menu-item has-dropdown">
            <a href="">
                <i class="ri-book-shelf-fill sidebar-menu-item-icon"></i>
                About
                <i class="ri-arrow-down-s-line sidebar-menu-item-accordion ms-auto"></i>
            </a>
            <ul class="sidebar-dropdown-menu">
                <li class="sidebar-dropdown-menu-item">
                    <a href="library_profile">
                        Library Profile
                    </a>
                </li>
                <li class="sidebar-dropdown-menu-item">
                    <a href="library_history">
                        Library History
                    </a>
                </li>
                <li class="sidebar-dropdown-menu-item">
                    <a href="library_vmgo">
                        Library VMGO
                    </a>
                </li>
            </ul>
        </li>

        <li class="sidebar-menu-item has-dropdown">
            <a href="">
                <i class="ri-archive-line sidebar-menu-item-icon"></i>
                Library Archive
                <i class="ri-arrow-down-s-line sidebar-menu-item-accordion ms-auto"></i>
            </a>
            <ul class="sidebar-dropdown-menu">
                <li class="sidebar-dropdown-menu-item">
                    <a href="library_updatesarchive">
                        Library Updates
                    </a>
                </li>
                <li class="sidebar-dropdown-menu-item">
                    <a href="library_resourcesarchive">
                        Library Resources
                    </a>
                </li>
                <li class="sidebar-dropdown-menu-item">
                    <a href="library_researcharchive">
                        Research Projects
                    </a>
                </li>
                <li class="sidebar-dropdown-menu-item">
                    <a href="library_picturesarchive">
                        Library Pictures
                    </a>
                </li>
            </ul>
        </li>
        <!-- dropdown menu here end -->

        <li class="sidebar-menu-item">
            <a href="Logs">
                <i class="ri-history-line sidebar-menu-item-icon"></i>
                Logs
            </a>
        </li>
    </ul>
    </li>
    <!-- dropdown menu here end -->
    </ul>
</div>
<div class="sidebar-overlay"></div>