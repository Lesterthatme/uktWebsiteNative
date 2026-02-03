<style>
  .splide-gallery,
  .splide-gallery-thumbs {
    background-color: #d9d9d9;
    border-radius: 8px;
    overflow: hidden;
  }

  .splide-gallery__slide .image-wrapper {
    position: relative;
    aspect-ratio: 16 / 9;
    overflow: hidden;
  }

  .splide-gallery__slide img {
    width: 100%;
    height: 100%;
    object-fit: cover;
  }

  .splide-gallery-thumbs__slide {
    aspect-ratio: 4 / 3;
    overflow: hidden;
  }

  .splide-gallery-thumbs__slide img {
    width: 100%;
    height: 100%;
    object-fit: cover;
  }

  .splide-gallery-thumbs .splide__slide.is-active img {
    border: 2px solid #fff;
  }

  .image-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.6);
    opacity: 0;
    transition: opacity 0.3s ease;
    padding: 1rem;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    text-align: center;
  }

  .image-wrapper:hover .image-overlay {
    opacity: 1;
  }

  .image-overlay h5,
  .image-overlay p {
    margin: 0;
    color: #fff;
  }

  .image-overlay p {
    font-size: 0.9rem;
  }
   .gallery-breadcrumb-section {
      background-color: #fff;
      width: 100%;
      box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
      padding: 16px 0;
    }

    .gallery-breadcrumb-wrapper {
      padding: 0 15px;
    }

    .gallery-custom-breadcrumb {
      font-size: 14px;
      color: #6c757d;
      margin-bottom: 0;
      display: flex;
      align-items: center;
      flex-wrap: wrap;
      gap: 6px;
    }

    .gallery-breadcrumb-link {
      color: #6c757d;
      text-decoration: none;
      padding: 6px 8px;
      border-radius: 8px;
      transition: color 0.2s ease-in-out;
      font-weight: 500;
    }

    .gallery-breadcrumb-link:hover {
      color: #14532d;
    }

    .gallery-breadcrumb-active {
      color: #6c757d; /* Secondary color */
      font-weight: 600; /* Semibold */
      cursor: default;
      text-decoration: none;
    }

    .gallery-separator-icon {
      font-size: 16px;
      color: #adb5bd;
    }

    @media (max-width: 576px) {
      .gallery-custom-breadcrumb {
        font-size: 13px;
        gap: 4px;
      }
    }
</style>

<?php include 'banner.php'; ?>
<?php include 'breadcrumbs.php'; ?>

<?php
function getDepartmentDetails($conn, $department_id)
{
  $query = "SELECT dm_image, dm_about, dm_name FROM department WHERE department_id = ?";
  $stmt = mysqli_prepare($conn, $query);

  if ($stmt) {
    mysqli_stmt_bind_param($stmt, "i", $department_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $dm_image, $dm_about, $dm_name);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    return [
      'image' => $dm_image ? $dm_image : 'default.png',
      'about' => $dm_about ? $dm_about : 'No description available.',
      'name' => $dm_name ? $dm_name : 'Unknown Department'
    ];
  }

  return [
    'image' => 'default.png',
    'about' => 'No description available.',
    'name' => 'Unknown Department'
  ];
}
?>

<div class="container">
  <div class="row">
    <!-- Main content column (8 columns on large screens) -->
    <div class="col-lg-8" data-aos="fade-up" data-aos-delay="200">
      <div class="row">
        <div class="container py-5">
          <?php
          include 'connection/dbconnection.php';
          $department_id = 0;

          if (isset($_GET['department_slug'])) {
            $department_slug = $_GET['department_slug'];

            // Convert slug back to department name
            $department_name = str_replace("-", " ", $department_slug);

            // Fetch department ID from database using department name
            $query = "SELECT department_id FROM department WHERE dm_name = ? LIMIT 1";
            $stmt = mysqli_prepare($conn, $query);

            if ($stmt) {
              mysqli_stmt_bind_param($stmt, "s", $department_name);
              mysqli_stmt_execute($stmt);
              mysqli_stmt_bind_result($stmt, $department_id);
              mysqli_stmt_fetch($stmt);
              mysqli_stmt_close($stmt);
            }
          }
          $department_details = getDepartmentDetails($conn, $department_id);
          ?>

          <div class="row align-items-center">
            <div class="col">
              <img src="assets/uploads/department_image/<?= htmlspecialchars($department_details['image']) ?>"
                class="img-fluid rounded"
                alt="Department Image"
                style="width: 500px; height: auto; object-fit: cover; display: block; margin-left: auto; margin-right: auto;">
              <h3 class="section-title mt-5"><i class="ri-building-line"></i> ABOUT</h3>
              <p class="text-muted mt-5 about-text" style="text-align: justify;">
                <?= nl2br(htmlspecialchars($department_details['about'])) ?>
              </p>
            </div>
          </div>


          <h3 class="mt-5 section-title"><i class="ri-group-line"></i> Faculty Members</h3>
          <div class="faculty-container mt-5">
            <?php
            include 'connection/dbconnection.php';
            $deptId = $department_id;
            $facultyQuery = "SELECT * FROM faculty_member WHERE department_id = ?";
            $stmt = mysqli_prepare($conn, $facultyQuery);

            if ($stmt) {
              mysqli_stmt_bind_param($stmt, "i", $deptId);
              mysqli_stmt_execute($stmt);
              $facultyResult = mysqli_stmt_get_result($stmt);

              if ($facultyResult && mysqli_num_rows($facultyResult) > 0) {
                while ($faculty_member = mysqli_fetch_assoc($facultyResult)) {
            ?>
                  <div class="card faculty-card border-0 shadow">
                    <img src="assets/uploads/faculty_member/<?php echo !empty($faculty_member['fm_image']) ? htmlspecialchars($faculty_member['fm_image']) : 'default.jpg'; ?>"
                      class="card-img-top" alt="Faculty">
                    <div class="faculty-info">
                      <h6 class="name">
                        <?php echo htmlspecialchars($faculty_member['fm_firstname'] . ' ' . $faculty_member['fm_mname'] . ' ' . $faculty_member['fm_lastname']); ?>
                      </h6>
                      <p><?php echo htmlspecialchars($faculty_member['fm_position']); ?></p>
                    </div>
                  </div>
            <?php
                }
              } else {
                echo "<p class='text-muted mt-3'>No faculty members found for this department.</p>";
              }

              mysqli_stmt_close($stmt);
            } else {
              echo "<p class='text-danger mt-3'>Error fetching faculty members.</p>";
            }
            ?>

          </div>
          <h3 class="mt-5 section-title"><i class="ri-building-4-line"></i>Facilities</h3>
<div class="container py-3">
    <!-- Main Gallery -->
    <?php
    include 'connection/dbconnection.php';
    $facility_query = "SELECT * FROM department_facilities WHERE department_id = $department_id";
    $facility_result = mysqli_query($conn, $facility_query);

    if ($facility_result && mysqli_num_rows($facility_result) > 0) {
        $facilities = mysqli_fetch_all($facility_result, MYSQLI_ASSOC);
    } else {
        $facilities = [];
    }
    ?>

    <?php if (!empty($facilities)): ?>
        <section class="splide splide-gallery mb-3" aria-label="Dessert Gallery">
            <div class="splide__track splide-gallery__track">
                <ul class="splide__list splide-gallery__list">
                    <?php foreach ($facilities as $facility): ?>
                        <li class="splide__slide splide-gallery__slide">
                            <div class="image-wrapper">
                                <img src="assets/uploads/department_facility/<?= $facility['facility_image'] ?>" alt="<?= htmlspecialchars($facility['facility_name']) ?>">
                                <div class="image-overlay d-flex flex-column justify-content-center align-items-center text-center">
                                    <h5 class="fw-bold"><?= htmlspecialchars($facility['facility_name']) ?></h5>
                                    <p><?= htmlspecialchars($facility['facility_description']) ?></p>
                                </div>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </section>

        <!-- Thumbnail Navigation -->
        <section class="splide splide-gallery-thumbs" aria-label="Thumbnail Navigation">
            <div class="splide__track splide-gallery-thumbs__track">
                <ul class="splide__list splide-gallery-thumbs__list">
                    <?php foreach ($facilities as $facility): ?>
                        <li class="splide__slide splide-gallery-thumbs__slide">
                            <img src="assets/uploads/department_facility/<?= $facility['facility_image'] ?>" class="img-thumbnail" alt="<?= htmlspecialchars($facility['facility_name']) ?>">
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </section>
    <?php else: ?>
        <div class="text-center text-muted">
            No facilities available for this department.
        </div>
    <?php endif; ?>
</div>


        </div>
      </div>
    </div>

    <!-- Sidebar column (4 columns on large screens) -->
    <div class="col-lg-4 sidebar" data-aos="fade-up" data-aos-delay="200">
      <?php include 'widgets.php'; ?>
    </div>
  </div>
</div>

<script>

  document.addEventListener('DOMContentLoaded', function () {
    const main = new Splide('.splide-gallery', {
      type      : 'fade',
      heightRatio: 0.5,
      pagination: false,
      arrows    : false,
      cover     : true,
    });

    const thumbs = new Splide('.splide-gallery-thumbs', {
      fixedWidth  : 100,
      fixedHeight : 64,
      isNavigation: true,
      gap         : 10,
      focus       : 'center',
      pagination  : false,
      cover       : true,
      arrows      : true,
      breakpoints : {
        600: {
          fixedWidth : 66,
          fixedHeight: 40,
        },
      },
    });

    main.sync(thumbs);
    main.mount();
    thumbs.mount();
  });

</script>