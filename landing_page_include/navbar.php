<?php
include 'connection/dbconnection.php';
// Fetch all site settings and universtiy name and logo start
$settings = [];
$sql = "SELECT * FROM site_settings LIMIT 1";
$result = mysqli_query($conn, $sql);

if ($row = mysqli_fetch_assoc($result)) {
    $settings = $row;

    if (!empty($settings)) {
        $website_tagline = htmlspecialchars($settings['website_tagline']);
    }
}

$sql = "SELECT university_name, university_logo FROM university_profile ";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  $row = $result->fetch_assoc();
  $university_logo = $row["university_logo"];
  $university_name = $row["university_name"];
} else {
  echo "<p>No university name and university logo found.</p>";
  exit;
}
// Fetch all site settings and universtiy name and logo end
?>


<header id="header" class="header d-flex align-items-center sticky-top">
    <div class="container-fluid container-xl position-relative d-flex align-items-center">
      <a href="home" class="logo-link d-flex align-items-center me-auto">
        <div class="logo-container d-flex align-items-center me-auto">
          <img src="assets/uploads/university_image/<?php echo htmlspecialchars($university_logo); ?>" alt="University Logo" class="logo-image">
          
          <div class="logo-text">
            <span class="university_logo"><?php echo htmlspecialchars($university_name); ?></span>
              <p class="logo-subtitle"><?php echo htmlspecialchars($settings['website_tagline']); ?></p>
          </div>
        </div>
      </a>
    
      <nav id="navmenu" class="navmenu">
        <ul>
          <li class="dropdown"><a href="#"><span>About</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
            <ul>
              <li><a href="university_profile">University Profile</a></li>
              <li><a href="university_background">University Background</a></li>
              <li><a href="vmgo">Vision, Mission & Goals</a></li>
              <li><a href="university_hymn">Hymn</a></li>
              <li><a href="contactus">Contact & Location</a></li>
            </ul>
          </li>
          <li class="dropdown"><a href="#"><span>Academics</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
            <ul>
              <li><a href="program_offerings">Program Offerings</a></li>
              <?php
                include 'connection/dbconnection.php';
                
                $query = "SELECT * FROM department WHERE dm_status = 'Active' ORDER BY dm_name ASC";
                $result = mysqli_query($conn, $query);
                
                if ($result && mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        // Convert department name to a URL-friendly slug
                        $department_slug = strtolower(str_replace(" ", "-", $row['dm_name']));
                        echo "<li><a href='colleges?department_slug=" . urlencode($department_slug) . "'>" . htmlspecialchars($row['dm_name']) . "</a></li>";
                    }
                } else {
                    echo "<li><a href='#'>No Departments Found</a></li>";
                }
                ?>
            </ul>
          </li>
          <li class="dropdown"><a href="#"><span>Bulletin</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
            <ul>
              <li><a href="announcements">Announcement</a></li>
              <li><a href="news">News</a></li>
              <li><a href="university_gallery">University Gallery</a></li>
              <li><a href="university_calendar">University Calendar</a></li>
              <li><a href="job_opportunities">Job Opportunities</a></li>
            </ul>
          </li>
          <li class="dropdown"><a href="#"><span>Management</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
            <ul>
                <li><a href="founder">Founder</a></li>
              <li><a href="rector">Rector</a></li>
              <!--<li><a href="board_of_directors">Board of Directors</a></li>-->
              <!--<li><a href="univ_heads">Head of Department & Head of Office</a></li>-->
            </ul>
          </li>
    
          <li class="dropdown"><a href="#"><span>Students</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
            <ul>
              <li><a href="admission_requirements">Admission Requirements</a></li>
              <li><a href="scholarships">Scholarships</a></li>
              <!--<li><a href="university_library">University Library</a></li>-->
              <li><a href="https://www.elibraryofcambodia.org/">University Library</a></li>
              <!--<li><a href="computer_practice_center">Computer Practice Center</a></li>-->
              <li><a href="forms">Forms</a></li>
              <li><a href="computer_laboratory">Computer Laboratory</a></li>
            
            </ul>
          </li>
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>
    </div>
  </header>

  <script>
  
(function() {
  "use strict";
  function toggleScrolled() {
    const selectBody = document.querySelector('body');
    const selectHeader = document.querySelector('#header');
    if (!selectHeader.classList.contains('scroll-up-sticky') && !selectHeader.classList.contains('sticky-top') && !selectHeader.classList.contains('fixed-top')) return;
    window.scrollY > 100 ? selectBody.classList.add('scrolled') : selectBody.classList.remove('scrolled');
  }

  document.addEventListener('scroll', toggleScrolled);
  window.addEventListener('load', toggleScrolled);

  const mobileNavToggleBtn = document.querySelector('.mobile-nav-toggle');

  function mobileNavToogle() {
    document.querySelector('body').classList.toggle('mobile-nav-active');
    mobileNavToggleBtn.classList.toggle('bi-list');
    mobileNavToggleBtn.classList.toggle('bi-x');
  }
  mobileNavToggleBtn.addEventListener('click', mobileNavToogle);

  document.querySelectorAll('.navmenu .toggle-dropdown').forEach(navmenu => {
    navmenu.addEventListener('click', function(e) {
      e.preventDefault();
      this.parentNode.classList.toggle('active');
      this.parentNode.nextElementSibling.classList.toggle('dropdown-active');
      e.stopImmediatePropagation();
    });
  });
 
  let navmenulinks = document.querySelectorAll('.navmenu a');

  function navmenuScrollspy() {
    navmenulinks.forEach(navmenulink => {
      if (!navmenulink.hash) return;
      let section = document.querySelector(navmenulink.hash);
      if (!section) return;
      let position = window.scrollY + 200;
      if (position >= section.offsetTop && position <= (section.offsetTop + section.offsetHeight)) {
        document.querySelectorAll('.navmenu a.active').forEach(link => link.classList.remove('active'));
        navmenulink.classList.add('active');
      } else {
        navmenulink.classList.remove('active');
      }
    })
  }
  window.addEventListener('load', navmenuScrollspy);
  document.addEventListener('scroll', navmenuScrollspy);
})();
</script>