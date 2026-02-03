<?php
include '../../connection/dbconnection.php';

// Fetch University Details (Assuming only one university exists)
$query = "SELECT university_name, university_logo FROM university_profile LIMIT 1";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    $university = $result->fetch_assoc();
    $university_name = $university['university_name'];
    $university_logo = $university['university_logo'];
} else {
    // Default values in case no university is found
    $university_name = "University Name";
    $university_logo = "default-logo.png";
}
?>

<!-- start sidebar -->
<div class="sidebar position-fixed top-0 start-0 bottom-0 bg-white">
    <div class="d-flex align-items-center p-2">
        <img src="../../assets/uploads/university_image/<?php echo htmlspecialchars($university_logo); ?>"
            alt="University Logo" class="sidebar-logo-img me-3" style="height: 50px; width: 50px;">
        <div class="d-flex flex-column">
            <a href="" class="sidebar-logo fw-bold fs-sm text-decoration-none text-color-default d-block mb-0">
                <?php echo htmlspecialchars($university_name); ?>
            </a>
            <span class="text-muted" style="font-size: 11px;">Content Manager Panel</span>
        </div>
    </div>
    <ul class="sidebar-menu p-3 mt-2 mb-0">
        <li class="sidebar-menu-divider mt-1 mb-1 text-uppercase">Menu</li>
        <!-- dropdown menu here start -->
        <li class="sidebar-menu-item has-dropdown">
            <a href="">
                <i class="ri-pages-fill sidebar-menu-item-icon"></i>
                Page Management
                <i class="ri-arrow-down-s-line sidebar-menu-item-accordion ms-auto"></i>
            </a>
            <ul class="sidebar-dropdown-menu">
                <li class="sidebar-dropdown-menu-item">
                    <a href="page_management">
                        Highlights
                    </a>
                </li>
                <li class="sidebar-dropdown-menu-item">
                    <a href="partnership">
                        Partnership
                    </a>
                </li>
                <li class="sidebar-dropdown-menu-item">
                    <a href="calendar">
                        University Calendar
                    </a>
                </li>
                <li class="sidebar-dropdown-menu-item">
                    <a href="FaQ">
                        FAQ
                    </a>
                </li>
            </ul>
        </li>
        <!-- dropdown menu here end -->

        <li class="sidebar-menu-item">
            <a href="announcement">
                <i class="ri-megaphone-fill sidebar-menu-item-icon"></i>
                Announcement
            </a>
        </li>
        <li class="sidebar-menu-item">
            <a href="university_album">
                <i class="ri-gallery-view-2 sidebar-menu-item-icon"></i>
                University Gallery
            </a>
        </li>
        <li class="sidebar-menu-item">
            <a href="news">
                <i class="ri-news-fill sidebar-menu-item-icon"></i>
                News
            </a>
        </li>
        <li class="sidebar-menu-item">
            <a href="job_opportunities">
                <i class="ri-user-search-fill sidebar-menu-item-icon"></i>
                Job Opportunities
            </a>
        </li>
        <li class="sidebar-menu-item">
            <a href="message">
                <i class="ri-mail-fill sidebar-menu-item-icon"></i>
                Message
            </a>
        </li>
        <li class="sidebar-menu-item">
            <a href="page_poster">
                <i class="ri-image-line sidebar-menu-item-icon"></i>
                Page Poster
            </a>
        </li>

        <!-- <li class="sidebar-menu-divider mt-3 mb-1 text-uppercase">Menu</li> -->

        <!-- dropdown menu here start -->
        <li class="sidebar-menu-item has-dropdown">
            <a href="">
                <i class="ri-school-fill sidebar-menu-item-icon"></i>
                Department
                <i class="ri-arrow-down-s-line sidebar-menu-item-accordion ms-auto"></i>
            </a>
            <ul class="sidebar-dropdown-menu">
                <li class="sidebar-dropdown-menu-item">
                    <a href="Manage_Department">
                        Manage Department
                    </a>
                    <?php
                    include '../../connection/dbconnection.php';

                    $query = "SELECT * FROM department WHERE dm_status = 'Active'";
                    $result = mysqli_query($conn, $query);

                    if ($result) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<li class='sidebar-dropdown-menu-item'>";
                            echo "<a href='view_department?department_id=" . $row['department_id'] . "'>" . $row['dm_name'] . "</a>";
                            echo "</li>";
                        }
                    } else {
                        echo "<li class='sidebar-dropdown-menu-item'><a href='#'>No Departments Found</a></li>";
                    }
                    ?>
                </li>

            </ul>
            <!-- dropdown menu here end -->

            <!-- dropdown menu here start -->
        <li class="sidebar-menu-item has-dropdown">
            <a href="">
                <i class="ri-user-fill sidebar-menu-item-icon"></i>
                Student
                <i class="ri-arrow-down-s-line sidebar-menu-item-accordion ms-auto"></i>
            </a>
            <ul class="sidebar-dropdown-menu">
                <li class="sidebar-dropdown-menu-item">
                    <a href="admission_requirements">
                        Admission Requirements
                    </a>
                </li>
                <li class="sidebar-dropdown-menu-item">
                    <a href="scholarship">
                        Scholarship
                    </a>
                </li>
                 <li class="sidebar-dropdown-menu-item">
                   <a href="computer_laboratory">
                       Computer laboratory
                   </a>
                </li>
                <!--<li class="sidebar-dropdown-menu-item">-->
                <!--    <a href="#">-->
                <!--        Computer Practice Center-->
                <!--    </a>-->
                <!--</li>-->
                <!--<li class="sidebar-dropdown-menu-item">-->
                <!--    <a href="student_org">-->
                <!--        Student Organizations-->
                <!--    </a>-->
                <!--</li>-->
                <li class="sidebar-dropdown-menu-item">
                    <a href="downloadable_forms">
                        Forms
                    </a>
                </li>
        </li>
    </ul>
    </li>
    <!-- dropdown menu here end -->

    <!-- dropdown menu here start -->
    <li class="sidebar-menu-item has-dropdown">
        <a href="">
            <i class="ri-briefcase-line sidebar-menu-item-icon"></i>
            Management
            <i class="ri-arrow-down-s-line sidebar-menu-item-accordion ms-auto"></i>
        </a>
        <ul class="sidebar-dropdown-menu">
            <li class="sidebar-dropdown-menu-item">
                <a href="university_founder">
                    University Founder
                </a>
            </li>
            <li class="sidebar-dropdown-menu-item">
                <a href="rector_page">
                    Rector
                </a>
            </li>
            <!--<li class="sidebar-dropdown-menu-item">-->
            <!--    <a href="Board_of_Directors">-->
            <!--        Board of Directors-->
            <!--    </a>-->
            <!--</li>-->
            <!--<li class="sidebar-dropdown-menu-item">-->
            <!--    <a href="dean_page">-->
            <!--        Dean and Deputy Dean-->
            <!--    </a>-->
            <!--</li>-->
            <!--<li class="sidebar-dropdown-menu-item">-->
            <!--    <a href="Head_of_Dep_and_office">-->
            <!--        Head of Departments and Head of Office-->
            <!--    </a>-->
            <!--</li>-->
    </li>
    </ul>
    </li>
    <!-- dropdown menu here end -->

    <li class="sidebar-menu-divider mt-1 mb-1 text-uppercase">Others</li>

    <li class="sidebar-menu-item">
        <a href="archive">
            <i class="ri-archive-line sidebar-menu-item-icon"></i>
            Archive
        </a>
    </li>

    <li class="sidebar-menu-item">
        <a href="logs">
            <i class="ri-history-line sidebar-menu-item-icon"></i>
            Logs
        </a>
    </li>

    <!-- dropdown menu here start -->
    <li class="sidebar-menu-item has-dropdown">
        <a href="">
            <i class="ri-information-line sidebar-menu-item-icon"></i>
            About
            <i class="ri-arrow-down-s-line sidebar-menu-item-accordion ms-auto"></i>
        </a>
        <ul class="sidebar-dropdown-menu">
            <li class="sidebar-dropdown-menu-item">
                <a href="university_profile">
                    University Profile
                </a>
            </li>
            <li class="sidebar-dropdown-menu-item">
                <a href="university_background">
                    University Background
                </a>
            </li>
            <li class="sidebar-dropdown-menu-item">
                <a href="university_vmgo">
                    Vision, Mission & Goal
                </a>
            </li>
            <li class="sidebar-dropdown-menu-item">
                <a href="university_hymn">
                    Hymn
                </a>
            </li>
            <li class="sidebar-dropdown-menu-item">
                <a href="contact_location">
                    Contact & Location
                </a>
            </li>


            <li class="sidebar-dropdown-menu-item">
                <a href="developers.php?page=2025">Developers</a>
            </li>
    </li>
    </ul>
    </li>
    <!-- dropdown menu here end -->
    </ul>
</div>
<div class="sidebar-overlay"></div>