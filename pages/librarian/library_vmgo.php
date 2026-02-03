<?php
include 'include/alert.php';
session_start();
include '../../connection/dbconnection.php';
if (!isset($_SESSION['session_token'])) {
  header('location:login.php');
  exit;
}

$query = "SELECT library_id, library_mission, library_vision, library_goal, library_objectives FROM library_university";
$result = mysqli_query($conn, $query);

if (!$result) {
  die("Query Failed: " . mysqli_error($conn));
}

$mission = $vision = $goal = $objectives = "";

if ($row = mysqli_fetch_assoc($result)) {
  $library_id = $row['library_id'];
  $mission = $row['library_mission'];
  $vision = $row['library_vision'];
  $goal = $row['library_goal'];
  $objectives = $row['library_objectives'];
}
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
  <link rel="stylesheet" href="../../assets/bootstrap/css/style.css?=v1.4">
  <!-- end css -->
  <!-- Remix icon -->
  <link rel="stylesheet" href="../../assets/RemixIcon/fonts/remixicon.css">
  <link href="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-lite.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-lite.min.js"></script>
   <!-- Summernote CSS -->
   <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-lite.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-lite.min.js"></script>
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
            <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
              <h5 class="card-title fs-6 mb-2 mb-md-0">Vision, Mission, Goal & Objectives</h5>
            </div>

            <!-- Modal for editing mission start-->
            <div class="modal fade" id="mission" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-xl">
                <div class="modal-content">
                  <div class="modal-header">
                    <h1 class="modal-title fs-5 text-muted fw-bold" id="exampleModalLabel">Edit Mission</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <form method="POST" action="function/libraryvmgo_function.php" role="dialog">
                      <input type="hidden" name="library_id" id="library_id" value="<?php echo $library_id; ?>">
                      <div class="row mb-3">
                        <label class="form-label fw-semibold text-muted">Mission</label>
                        <textarea class="form-control" id="summernote_mission" name="library_mission" rows="3" placeholder="Enter Library University Mission"><?php echo ($mission); ?></textarea>
                        <div id="summernote_mission"></div>
                          <script>
                            $('#summernote_mission').summernote({
                              placeholder: 'Hello stand alone ui',
                              tabsize: 2,
                              height: 120,
                              toolbar: [
                                [ 'style', [ 'style' ] ],
                                      [ 'font', [ 'bold', 'italic', 'underline', 'strikethrough', 'superscript', 'subscript', 'clear'] ],
                                      [ 'fontname', [ 'fontname' ] ],
                                      [ 'fontsize', [ 'fontsize' ] ],
                                      [ 'color', [ 'color' ] ],
                                      [ 'para', [ 'ol', 'ul', 'paragraph', 'height' ] ],
                                      [ 'table', [ 'table' ] ],
                                      ['insert', ['link', 'picture']],
                                      [ 'view', [ 'undo', 'redo', 'fullscreen', 'codeview', 'help' ] ]
                              ]
                            });
                          </script>
                      </div>
                      <div class="modal-footer">
                        <button type="submit" name="update_mission" class="btn btn-success"><i class="ri-save-fill"></i> Save</button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
            <!-- Modal for editing mission end-->

            <!-- Modal for editing vision start-->
            <div class="modal fade" id="vision" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-xl">
                <div class="modal-content">
                  <div class="modal-header">
                    <h1 class="modal-title fs-5 text-muted fw-bold" id="exampleModalLabel">Edit Vision</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                  <form method="POST" action="function/libraryvmgo_function.php" role="dialog">
                  <input type="hidden" name="library_id" id="library_id" value="<?php echo $library_id; ?>">
                      <div class="row mb-3">
                        <label class="form-label fw-semibold text-muted">Vision</label>
                        <textarea class="form-control" id="summernote_vision" name="library_vision" rows="3" placeholder="Enter Library University Vision"><?php echo ($vision); ?></textarea>
                        <div id="summernote_vision"></div>
                          <script>
                            $('#summernote_vision').summernote({
                              placeholder: 'Hello stand alone ui',
                              tabsize: 2,
                              height: 120,
                              toolbar: [
                                [ 'style', [ 'style' ] ],
                                      [ 'font', [ 'bold', 'italic', 'underline', 'strikethrough', 'superscript', 'subscript', 'clear'] ],
                                      [ 'fontname', [ 'fontname' ] ],
                                      [ 'fontsize', [ 'fontsize' ] ],
                                      [ 'color', [ 'color' ] ],
                                      [ 'para', [ 'ol', 'ul', 'paragraph', 'height' ] ],
                                      [ 'table', [ 'table' ] ],
                                      ['insert', ['link', 'picture']],
                                      [ 'view', [ 'undo', 'redo', 'fullscreen', 'codeview', 'help' ] ]
                              ]
                            });
                          </script>
                      </div>
                      <div class="modal-footer">
                        <button type="submit" name="update_vision" class="btn btn-success"><i class="ri-save-fill"></i> Save</button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
            <!-- Modal for editing vision end-->

            <!-- Modal for editing goal start-->
            <div class="modal fade" id="goal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-xl">
                <div class="modal-content">
                  <div class="modal-header">
                    <h1 class="modal-title fs-5 text-muted fw-bold" id="exampleModalLabel">Edit Vision</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                  <form method="POST" action="function/libraryvmgo_function.php" role="dialog">
                    <input type="hidden" name="library_id" id="library_id" value="<?php echo $library_id; ?>">
                      <div class="row mb-3">
                        <label class="form-label fw-semibold text-muted">Goal</label>
                        <textarea class="form-control" id="summernote_goal" name="library_goal" rows="3" placeholder="Enter Library University Goal"><?php echo ($goal); ?></textarea>
                        <div id="summernote_goal"></div>
                          <script>
                            $('#summernote_goal').summernote({
                              placeholder: 'Hello stand alone ui',
                              tabsize: 2,
                              height: 120,
                              toolbar: [
                                [ 'style', [ 'style' ] ],
                                      [ 'font', [ 'bold', 'italic', 'underline', 'strikethrough', 'superscript', 'subscript', 'clear'] ],
                                      [ 'fontname', [ 'fontname' ] ],
                                      [ 'fontsize', [ 'fontsize' ] ],
                                      [ 'color', [ 'color' ] ],
                                      [ 'para', [ 'ol', 'ul', 'paragraph', 'height' ] ],
                                      [ 'table', [ 'table' ] ],
                                      ['insert', ['link', 'picture']],
                                      [ 'view', [ 'undo', 'redo', 'fullscreen', 'codeview', 'help' ] ]
                              ]
                            });
                          </script>
                      </div>
                      <div class="modal-footer">
                        <button type="submit" name="update_goal" class="btn btn-success"><i class="ri-save-fill"></i> Save</button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
            <!-- Modal for editing goal end-->

            <!-- Modal for editing objectives start-->
            <div class="modal fade" id="objectives" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-xl">
                <div class="modal-content">
                  <div class="modal-header">
                    <h1 class="modal-title fs-5 text-muted fw-bold" id="exampleModalLabel">Edit Vision</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                  <form method="POST" action="function/libraryvmgo_function.php" role="dialog">
                    <input type="hidden" name="vmgo_id" id="vmgo_id" value="<?php echo $vmgo_id; ?>">
                      <div class="row mb-3">
                        <label class="form-label fw-semibold text-muted">Objectives</label>
                        <textarea class="form-control" id="summernote_objectives" name="library_objectives" rows="3" placeholder="Enter University Vision"><?php echo ($objectives); ?></textarea>
                        <div id="summernote_objectives"></div>
                          <script>
                            $('#summernote_objectives').summernote({
                              placeholder: 'Hello stand alone ui',
                              tabsize: 2,
                              height: 120,
                              toolbar: [
                                [ 'style', [ 'style' ] ],
                                      [ 'font', [ 'bold', 'italic', 'underline', 'strikethrough', 'superscript', 'subscript', 'clear'] ],
                                      [ 'fontname', [ 'fontname' ] ],
                                      [ 'fontsize', [ 'fontsize' ] ],
                                      [ 'color', [ 'color' ] ],
                                      [ 'para', [ 'ol', 'ul', 'paragraph', 'height' ] ],
                                      [ 'table', [ 'table' ] ],
                                      ['insert', ['link', 'picture']],
                                      [ 'view', [ 'undo', 'redo', 'fullscreen', 'codeview', 'help' ] ]
                              ]
                            });
                          </script>
                      </div>
                      <div class="modal-footer">
                        <button type="submit" name="update_objectives" class="btn btn-success"><i class="ri-save-fill"></i> Save</button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
            <!-- Modal for editing objectives  end-->

            <!-- Page Poster start -->
            <?php

            ?>
            <div class="vmgo_card_container">
              <div class="vmgo_card mission position-relative">
                <i class="ri-flag-line"></i>
                <h5>MISSION</h5>
                <p><?php echo ($mission); ?></p>

                <div class="dropdown position-absolute top-0 end-0">
                  <button class="btn btn-link text-dark p-0" type="button" id="dropdownMission" data-bs-toggle="dropdown" aria-expanded="false" style="text-decoration: none !important;">
                    <i class="ri-more-2-fill fs-5"></i>
                  </button>
                  <ul class="dropdown-menu dropdown-menu-end" style="left: auto; right: 100%;" aria-labelledby="dropdownMission">
                    <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#mission">Edit</a></li>
                  </ul>
                </div>
              </div>

              <div class="vmgo_card vision position-relative">
                <i class="ri-eye-line"></i>
                <h5>VISION</h5>
                <p><?php echo ($vision); ?></p>
                <div class="dropdown position-absolute top-0 end-0">
                  <button class="btn btn-link text-dark p-0" type="button" id="dropdownVision" data-bs-toggle="dropdown" aria-expanded="false" style="text-decoration: none !important;">
                    <i class="ri-more-2-fill fs-5"></i>
                  </button>
                  <ul class="dropdown-menu dropdown-menu-end" style="left: auto; right: 100%;" aria-labelledby="dropdownVision">
                    <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#vision">Edit</a></li>
                  </ul>
                </div>
              </div>

              <div class="vmgo_card goal position-relative">
                <i class="ri-trophy-line"></i>
                <h5>GOAL</h5>
                <p><?php echo ($goal); ?></p>
                <div class="dropdown position-absolute top-0 end-0">
                  <button class="btn btn-link text-dark p-0" type="button" id="dropdownGoal" data-bs-toggle="dropdown" aria-expanded="false" style="text-decoration: none !important;">
                    <i class="ri-more-2-fill fs-5"></i>
                  </button>
                  <ul class="dropdown-menu dropdown-menu-end" style="left: auto; right: 100%;" aria-labelledby="dropdownGoal">
                    <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#goal">Edit</a></li>
                  </ul>
                </div>
              </div>

              <div class="vmgo_card goal position-relative">
              <i class="ri-focus-2-line"></i>
                <h5>Objectives</h5>
                <p><?php echo ($objectives); ?></p>
                <div class="dropdown position-absolute top-0 end-0">
                  <button class="btn btn-link text-dark p-0" type="button" id="dropdownObjectives" data-bs-toggle="dropdown" aria-expanded="false" style="text-decoration: none !important;">
                    <i class="ri-more-2-fill fs-5"></i>
                  </button>
                  <ul class="dropdown-menu dropdown-menu-end" style="left: auto; right: 100%;" aria-labelledby="dropdownObjectives">
                    <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#objectives">Edit</a></li>
                  </ul>
                </div>
              </div>
            </div>
            <!-- Page Poster End -->
          </div>
        </div>
      </div>
      <?php include 'include/footer.php'; ?>
    </div>
  </main>

  <!-- start js -->
  <script src="../../assets/script.js"></script> <!-- this script is for disabling multiple login in session -->
  <script src="../../assets/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../../assets/bootstrap/js/jquery-3.7.1.js"></script>
  <script src="../../assets/bootstrap/js/script.js"></script>
  <script src="../../assets/bootstrap/js/page_poster.js"></script>
  <script src="../../assets/bootstrap/js/drag_and_drop.js?=1.1"></script>
  <script src="../../assets/bootstrap/js/activeLink.js?v=1.1"></script>
  <script src="../../assets/bootstrap/js/table.js"></script>
    <script src="../../assets/bootstrap/js/site_settings.js?v=1.0"></script>
  <!-- end js -->

      <!-- START >> JS SCRIPT IN ALERT -->
      <script>
    document.addEventListener("DOMContentLoaded", function () {
      console.log("Checking for toast message...");

      <?php if (isset($_SESSION['toastMsg']) && $_SESSION['toastMsg'] != "") { ?>
        let toastType = "<?php echo $_SESSION['toastType']; ?>";
        let message = "<?php echo $_SESSION['toastMsg']; ?>";

        // If success, show "Success", else show "Failed"
        let title = (toastType === "toast-success") ? "Success" : "Failed";

        console.log("Toast Found:", title, message);
        showToast(toastType, title, message);

        // Unset session variables after displaying the toast
        <?php unset($_SESSION['toastMsg']);
        unset($_SESSION['toastType']); ?>
      <?php } else { ?>
        console.log("No toast message found.");
      <?php } ?>
    });

    function showToast(type, title, message) {
      let toast = document.getElementById("toastBox");
      let icon = document.getElementById("toastIcon");
      let titleElement = document.getElementById("toastTitle");
      let messageElement = document.getElementById("toastMessage");

      if (!toast) {
        console.error("Toast box element not found!");
        return;
      }

      // Remove previous styles
      toast.classList.remove("toast-show", "toast-success", "toast-info", "toast-warning", "toast-error");

      // Add new class
      toast.classList.add(type, "toast-show");

      // Set title and message
      titleElement.textContent = title;
      messageElement.textContent = message;

      // Set icon based on type
      switch (type) {
        case "toast-success": icon.className = "ri-checkbox-circle-line toast-icon"; break;
        case "toast-info": icon.className = "ri-information-line toast-icon"; break;
        case "toast-warning": icon.className = "ri-alert-line toast-icon"; break;
        case "toast-error": icon.className = "ri-close-circle-line toast-icon"; break;
        default: icon.className = "ri-information-line toast-icon"; // Default icon
      }

      // Show toast
      toast.style.display = "flex";

      // Hide after 3 seconds
      setTimeout(closeToast, 3000);
    }

    function closeToast() {
      let toast = document.getElementById("toastBox");
      toast.classList.remove("toast-show");
      setTimeout(() => {
        toast.style.display = "none";
      }, 500);
    }
  </script>
  <!-- END >> JS SCRIPT IN ALERT -->




</body>

</html>