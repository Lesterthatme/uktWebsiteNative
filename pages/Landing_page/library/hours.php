<?php
include 'connection/dbconnection.php';

$query = "SELECT * FROM operating_hours ORDER BY FIELD(day, 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday')";
$result = mysqli_query($conn, $query);
?>

<section class="operating_hrs p-4 my-5">
  <div class="operating-hours-title text-center mb-4" data-aos="fade-up">
    <h2>Operating Hours</h2>
    <p>ម៉ោងបើកសេវា</p>
  </div>

  <!-- Grid Section -->
  <div class="row g-4 justify-content-center">
    <?php
    if (mysqli_num_rows($result) > 0) {
        $delay = 100;
        while ($row = mysqli_fetch_assoc($result)) {
            $day = htmlspecialchars($row['day']);
            $is_open = $row['is_open']; 
            $open_time = date("h:i A", strtotime($row['open_time']));
            $close_time = date("h:i A", strtotime($row['close_time']));
            
            $status_text = ($is_open == 1) ? "OPEN" : "CLOSED";
            $status_class = ($is_open == 1) ? "status-btn open-hrs badge bg-success" : "status-btn close-hrs badge bg-danger";
            
            ?>
            <div class="col-md-4 col-sm-6" data-aos="fade-up" data-aos-delay="<?php echo $delay; ?>">
              <div class="operating-card text-center p-3 shadow-sm border rounded">
                <h5 class="fw-bold"><?php echo strtoupper($day); ?></h5>
                <p><?php echo ($is_open == 1) ? "$open_time - $close_time" : "Closed"; ?></p>
                <span class="<?php echo $status_class; ?>"><?php echo $status_text; ?></span>
              </div>
            </div>
            <?php
            $delay += 100; 
        }
    } else {
        echo "<div class='col-12 text-center'><div class='alert alert-warning'>No operating hours available.</div></div>";
    }
    ?>
  </div>
</section>
