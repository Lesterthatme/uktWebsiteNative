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
  <link rel="stylesheet" href="../../assets/bootstrap/css/style.css?=v1.6">
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
                    <div class="profile-pic-container">
                      <img src="../../assets/images/officiallogo (1).png" alt="Profile Picture" id="profile-pic">
                      <label for="profile-upload" class="upload-icon">
                        <i class="ri-camera-fill"></i>
                      </label>
                      <input type="file" id="profile-upload" accept="image/*" onchange="previewImage(event)">
                    </div>
                    <div class="ms-3">
                      <h4 class="mb-0">Admin UKT</h4>
                      <small class="text-muted">admin@gmail.com</small>
                    </div>
                  </div>
                  
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
                <div class="row">
                  <div class="col-md-6 mb-3">
                    <label class="form-label">Password</label>
                    <input type="text" class="form-control" value="Password" disabled>
                  </div>
                  <div class="col-md-6 mb-3">
                    <label class="form-label">Confirm Password</label>
                    <input type="text" class="form-control" value="Confirm Password" disabled>
                  </div>
                </div>
                <button class="btn btn-success float-end mt-3"><i class="ri-save-fill"></i> Save</button>
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
  <script src="../../assets/bootstrap/js/activeLink.js?v=1.0"></script>
  <script src="../../assets/bootstrap/js/toast_msg.js"></script>
  <script>
    document.addEventListener("DOMContentLoaded", function() {
      const fileInput = document.getElementById("profile-upload");
      const profilePic = document.getElementById("profile-pic");

      fileInput.addEventListener("change", function(event) {
        const file = event.target.files[0];

        if (file) {
          const reader = new FileReader();

          reader.onload = function(e) {
            profilePic.src = e.target.result; // Update the image source
          };

          reader.readAsDataURL(file);
        }
      });
    });
  </script>
  <!-- end js -->
</body>

</html>