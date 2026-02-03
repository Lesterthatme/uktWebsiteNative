<?php
include 'connection/dbconnection.php';

$query = "SELECT update_id, update_image, update_category, update_title, update_description, posted_date 
          FROM library_updates 
          ORDER BY posted_date DESC LIMIT 6";
$result = mysqli_query($conn, $query);
?>

<section class="news-section p-4 my-3" data-aos="fade-up" data-aos-duration="2000">
    <h2>Library Updates</h2>
    <p class="news-text-muted">ព័ត៌មានបណ្តាញបណ្ណាល័យ</p>

    <div class="news-container">
        <?php
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $update_id = $row['update_id'];
                $update_image = htmlspecialchars($row['update_image']);
                $update_category = htmlspecialchars($row['update_category']);
                $update_title = htmlspecialchars($row['update_title']);
                $update_description = htmlspecialchars($row['update_description']);
                $posted_date = date("F d, Y", strtotime($row['posted_date']));
                ?>

                <div class="news-card">
                    <div class="image-container">
                        <img src="pages/librarian/assets/uploads/Libraryupdate_images/<?php echo $update_image; ?>"
                            alt="News Image">
                        <span class="date-label"><?php echo $posted_date; ?></span>
                    </div>
                    <div class="news-content">
                        <h3 class="news-title"><?php echo $update_title; ?></h3>
                        <p class="news-desc"><?php echo $update_description; ?></p>
                        <a href="?page=library_update&id=<?php echo $update_id; ?>" class="news-btn">Read More <i
                                class="ri-arrow-right-line"></i></a>
                    </div>
                </div>

                <?php
            }
        } else {
            echo "<div class='alert alert-warning'>No library updates available.</div>";
        }
        ?>
    </div>

    <div class="view-all-container">
        <a href="?page=all_library_updates" class="view-all-btn" data-aos="slide-right">
            VIEW ALL UPDATES <i class="ri-arrow-right-line"></i>
        </a>
    </div>
</section>