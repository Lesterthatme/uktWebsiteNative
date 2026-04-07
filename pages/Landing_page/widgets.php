<div class="widgets-container">
    <div class="categories-widget widget-item">
        <h3 class="widget-title">អ្នកសិក្សា</h3>
        <ul class="mt-3">
            <li><a href="program_offerings">ការផ្តល់ជូនកម្មវិធី</a></li>
            <?php
            include 'connection/dbconnection.php';

            $query = "SELECT * FROM department WHERE dm_status = 'Active'";
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


    <div class="categories-widget widget-item">
        <h3 class="widget-title">តំណភ្ជាប់សិស្ស</h3>
        <ul class="mt-3">
            <li><a href="admission_requirements">តម្រូវការចូលរៀន</a></li>
            <li><a href="scholarships">អាហារូបករណ៍</a></li>
            <li><a href="https://www.elibraryofcambodia.org/">បណ្ណាល័យសាកលវិទ្យាល័យ</a></li>
            <!--<li><a href="computer_practice_center">Computer Practice Center</a></li>-->
            <li><a href="forms">ទម្រង់បែបបទ</a></li>
        </ul>
    </div>

    <!-- Recent Posts Widget -->
    <div class="recent-posts-widget widget-item">
        <h3 class="widget-title">ការប្រកាសផ្សេងទៀត</h3>

        <!-- Recent Post Items -->
        <?php
        include 'connection/dbconnection.php';
        include_once 'landing_page_include/slugify.php';

        $sql = "SELECT * FROM announcement WHERE announcement_status = 'Active' ORDER BY announcement_date DESC LIMIT 3";
        $result = mysqli_query($conn, $sql);

        if ($result && mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                // $announcement_id = $row['announcement_id'];
                $announcement_image = htmlspecialchars($row['announcement_image']);
                $announcement_title = htmlspecialchars($row['announcement_title']);
                $announcement_date = htmlspecialchars(date("F j, Y", strtotime($row['announcement_date'])));
                $announcement_slug = slugify($row['announcement_title']);
        ?>
                <div class="post-item">
                    <img src="assets/uploads/announcement/<?php echo $announcement_image; ?>"
                        alt="<?php echo $announcement_title; ?>" class="flex-shrink-0">
                    <div>
                        <h4><a
                                href="announcement_view?announcement_slug=<?php echo $announcement_slug; ?>"><?php echo $announcement_title; ?></a>
                        </h4>
                        <time datetime="<?php echo $row['announcement_date']; ?>"><?php echo $announcement_date; ?></time>
                    </div>
                </div>
        <?php
            }
        } else {
            echo "<p>គ្មានការប្រកាសណាមួយអាចរកបានទេ។</p>";
        }
        ?>
        <div class="text-center">
            <a href="announcements" class="view-all-btn ">
                មើលទាំងអស់ <i class="ri-arrow-right-line"></i>
            </a>
        </div>
    </div>

    <!-- Another Recent News Posts -->
    <?php
    include 'connection/dbconnection.php';

    // Add this slugify function if not globally available
    include_once 'landing_page_include/slugify.php';


    $query = "SELECT * FROM news WHERE news_status = 'Active' ORDER BY news_date DESC LIMIT 3";
    $result = mysqli_query($conn, $query);
    ?>

    <div class="recent-posts-widget widget-item">
        <h3 class="widget-title">ព័ត៌មានផ្សេងទៀត</h3>

        <?php
        if ($result && mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $news_image = htmlspecialchars($row['news_image']);
                $news_title = htmlspecialchars($row['news_title']);
                $news_date = htmlspecialchars(date("F j, Y", strtotime($row['news_date'])));
                $news_slug = slugify($row['news_title']);
        ?>
                <div class="post-item">
                    <img src="assets/uploads/news/<?php echo $news_image; ?>" alt="<?php echo $news_title; ?>"
                        class="flex-shrink-0">
                    <div>
                        <h4><a href="news_view?news_slug=<?php echo $news_slug; ?>"><?php echo $news_title; ?></a></h4>
                        <time datetime="<?php echo $row['news_date']; ?>"><?php echo $news_date; ?></time>
                    </div>
                </div>
        <?php
            }
        } else {
            echo "<p>គ្មានព័ត៌មានទេ។</p>";
        }
        ?>

        <div class="text-center">
            <a href="news" class="view-all-btn">
                មើលទាំងអស់ <i class="ri-arrow-right-line"></i>
            </a>
        </div>
    </div>

</div>