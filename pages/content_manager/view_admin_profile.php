<?php include 'include/alert.php';

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <link rel="icon" type="image/png" href="../../assets/images/officiallogo (1).png" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>University of Kratie || Admin</title>
  <!-- start css  -->
  <link rel="stylesheet" href="../../assets/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="../../assets/bootstrap/css/style.css?=v1.3">
  <!-- end css -->
  <!-- Remix icon -->
  <link rel="stylesheet" href="../../assets/RemixIcon/fonts/remixicon.css">
</head>

<body class="bg-light">

  <!-- include side bar start -->
  <?php include 'include/sidebar.php';

  ?>
  <!-- include side bar end -->

  <main class="bg-light">

    <!-- include navbar start -->
    <?php include 'include/navbar.php';

    ?>
    <!-- include navbar end -->

    <!-- start: Content -->
    <div class="p-4">
      <div class="row">
        <div class="card border-0 pb-3">
          <div class="card-body">
            <div class="container d-flex justify-content-center">
              <div class="account_profile-card w-100" style="max-width: 1600px;">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-center">
                  <div class="d-flex align-items-center text-center text-md-start">
                    <img src="../../assets/images/officiallogo (1).png" alt="Profile" class="account_profile-image">
                    <div class="ms-3">
                      <h4 class="mb-0">Admin UKT</h4>
                      <small class="text-muted">admin@gmail.com</small>
                    </div>
                  </div>
                  <button class="btn btn-dynamic"><i class="ri-edit-2-line"></i> Edit Profile</button>
                </div>
                <hr>
                <div class="row">
                  <div class="col-md-4 mb-3">
                    <label class="form-label">First Name</label>
                    <input type="text" class="form-control" value="Your First Name" disabled>
                  </div>
                  <div class="col-md-4 mb-3">
                    <label class="form-label">Middle Name</label>
                    <input type="text" class="form-control" value="Your Middle Name" disabled>
                  </div>
                  <div class="col-md-4 mb-3">
                    <label class="form-label">Last Name</label>
                    <input type="text" class="form-control" value="Your Last Name" disabled>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-4 mb-3">
                    <label class="form-label">Birthday</label>
                    <input type="text" class="form-control" value="Birthday" disabled>
                  </div>
                  <div class="col-md-4 mb-3">
                    <label class="form-label">Age</label>
                    <input type="text" class="form-control" value="Age" disabled>
                  </div>
                  <div class="col-md-4 mb-3">
                    <label class="form-label">Sex</label>
                    <input type="text" class="form-control" value="Username" disabled>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6 mb-3">
                    <label class="form-label">Username</label>
                    <input type="text" class="form-control" value="Username" disabled>
                  </div>
                  <div class="col-md-6 mb-3">
                    <label class="form-label">Email</label>
                    <input type="text" class="form-control" value="Email" disabled>
                  </div>
                </div>
              </div>
            </div>



          </div>
        </div>
      </div>
      <?php include 'include/footer.php'; ?>
    </div>
  </main>

  <!-- start js -->
  <script src="../../assets/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../../assets/bootstrap/js/jquery-3.7.1.js"></script>
  <script src="../../assets/bootstrap/js/script.js"></script>
  <script src="../../assets/bootstrap/js/carousel.js"></script>
  <script src="../../assets/bootstrap/js/drag_and_drop.js?=v1.0"></script>
  <script src="../../assets/bootstrap/js/activeLink.js?v=1.5"></script>
  <script src="../../assets/bootstrap/js/toast_msg.js"></script>
    <script src="../../assets/bootstrap/js/site_settings.js"></script>
  <!-- end js -->
</body>

</html>