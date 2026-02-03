<?php
session_start();

include '../../connection/dbconnection.php';

// Query to get the job data
$query = "SELECT job_id, job_description, posted_date, application_deadline, contact_email
           FROM job_opportunities WHERE up_id = 1";
$result = mysqli_query($conn, $query);
$job_data = mysqli_fetch_assoc($result);

$job_description = $job_data['job_description'];
$posted_date = $job_data['posted_date'];
$application_deadline = $job_data['application_deadline'];
$contact_email = $job_data['contact_email'];


// Fetch all site settings start
$settings = [];
$sql = "SELECT * FROM site_settings LIMIT 1";
$result = mysqli_query($conn, $sql);

if ($row = mysqli_fetch_assoc($result)) {
  $settings = $row;

  if (!empty($settings)) {
    $title_admin = htmlspecialchars($settings['websitetitle_admin']);
    $title_cm = htmlspecialchars($settings['websitetitle_cm']);
  }
}
// Fetch all site settings end
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/png" href="../../assets/uploads/site settings/favicon/<?php echo htmlspecialchars($settings['fav_icon']); ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($settings['websitetitle_admin']); ?></title> 
    <link rel="stylesheet" href="../../assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../assets/bootstrap/css/style.css?=v1.4">
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../../assets/RemixIcon/fonts/remixicon.css">
    <!-- Summernote CSS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-lite.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-lite.min.js"></script>
</head>

<body class="bg-light">

    <!-- include side bar start -->
    <?php include 'include/alert.php'; ?>
    <?php include 'confirmation.php'; ?>
    <?php include 'include/sidebar.php'; ?>
    <!-- include side bar end -->

    <main class="bg-light">

        <!-- include navbar start -->
        <?php include 'include/navbar.php'; ?>
        <!-- include navbar end -->

        <!-- start: Content -->
        <div class="p-4">
            <div class="row">
                <div class="card border-0 pb-3">
                    <div class="card-body">
                        <div class="doc-tabs-container mt-3">
                            <ul class="doc-tabs d-flex list-unstyled">
                                <li class="me-3">
                                    <a class="doc-link active" href="job_opportunities">Overview</a>
                                </li>
                                <li class="me-3">
                                    <a class="doc-link" href="job_vacancy">Job Vacancy</a>
                                </li>
                            </ul>
                            <hr class="doc-tabs-divider">
                        </div>
                        <button type="button" class="btn btn-sm rounded-2 px-4 float-end btn-dynamic" data-bs-toggle="modal"
                            data-bs-target="#exampleModal"  data-bs-toggle="tooltip" data-bs-placement="top" title="Click here to edit this overview">
                            <i class="ri-edit-2-line"></i> Edit Overview
                        </button>
                        <p class="card-text text-muted small">Don’t forget to update this section whenever a new opportunity is added!</p>
                        <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
                          
                        </div>

                        <!-- Modal for editing background start-->
                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog modal-xl">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5 text-muted fw-bold" id="exampleModalLabel">Update Job Description
                                        </h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body pb-0">
                                        <form method="POST" action="../../function/job_function.php" role="dialog">
                                            <input type="hidden" name="job_id" value="<?= $job_data['job_id'] ?>">
                                            <div class="row">
                                                <div class="col-md-12 mb-3">
                                                    <div class="mb-3">
                                                        <label for="posted_date" class="form-label"><strong>Date</strong></label>
                                                        <input type="date" class="form-control" name="posted_date" style="width: 200px;" value="<?= $job_data['posted_date'] ?>" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="application_deadline" class="form-label"><strong>Application Deadline</strong></label>
                                                        <input type="date" class="form-control" name="application_deadline" style="width: 200px;" value="<?= $job_data['application_deadline'] ?>" required>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label for="contact_email" class="form-label"><strong>Contact Email</strong></label>
                                                        <input type="email" class="form-control" name="contact_email" value="<?= $job_data['contact_email'] ?>" required>
                                                    </div>

                                                    <label for=""><strong>Job Description</strong></label>
                                                    <textarea id="summernote" name="job_description" class="form-control mb-2"
                                                        style="height: 20vh;"><?= $job_data['job_description'] ?></textarea>

                                                    <div id="summernote"></div>
                                                    <script>
                                                        $('#summernote').summernote({
                                                            placeholder: 'Hello stand alone ui',
                                                            tabsize: 2,
                                                            height: 120,
                                                            toolbar: [
                                                                ['style', ['style']],
                                                                ['font', ['bold', 'italic', 'underline', 'strikethrough', 'superscript', 'subscript', 'clear']],
                                                                ['fontname', ['fontname']],
                                                                ['fontsize', ['fontsize']],
                                                                ['color', ['color']],
                                                                ['para', ['ol', 'ul', 'paragraph', 'height']],
                                                                ['table', ['table']],
                                                                ['view', ['undo', 'redo', 'fullscreen', 'codeview', 'help']]
                                                            ],
                                                            fontNames: ['Poppins', 'Arial', 'Arial Black', 'Comic Sans MS', 'Courier New', 'Helvetica', 'Impact', 'Tahoma', 'Times New Roman', 'Verdana'],
                                                            fontNamesIgnoreCheck: ['Poppins']
                                                        });
                                                    </script>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" name="update_job" class="btn btn-dynamic" data-bs-toggle="tooltip" 
                                                 data-bs-placement="top" title="Click to save"><i class="ri-save-fill"></i> Save</button>
                                            </div>
                                        </form>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <!-- Modal for editing background end-->

                        <!-- viewing job description start -->
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-8">
                                    <p class="lead"><?php echo $job_description; ?></p>
                                    <p><strong>Contact Email:</strong> <?php echo $job_data['contact_email']; ?></p>
                                    <p class="text-muted mb-0"><strong>Application Deadline:</strong> <?php echo date("F j, Y", strtotime($job_data['application_deadline'])); ?></p>
                                    <p class="text-muted mb-0"><strong>Date updated:</strong> <?php echo date("F j, Y", strtotime($job_data['posted_date'])); ?></p>

                                </div>
                            </div>
                        </div>
                        <!-- viewing job description end -->

                    </div>
                </div>
            </div>
            <?php include 'include/footer.php'; ?>
        </div>
    </main>

    <!-- start js -->

    <script src="https://cdn.jsdelivr.net/npm/quill@1.3.6/dist/quill.min.js"></script>
    <script src="../../assets/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../../assets/bootstrap/js/jquery-3.7.1.js"></script>
    <script src="../../assets/bootstrap/js/script.js?v=1.2"></script>
    <!-- <script src="../../assets/bootstrap/js/page_poster.js"></script> -->
    <!-- <script src="../../assets/bootstrap/js/drag_and_drop.js?=1.1"></script> -->
    <script src="../../assets/bootstrap/js/activeLink.js?v=1.2"></script>
    <!-- <script src="../../assets/bootstrap/js/table.js"></script> -->
    <script src="../../assets/bootstrap/js/site_settings.js"></script>
    <!-- end js -->

    <!-- START >> JS SCRIPT IN ALERT -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
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
                case "toast-success":
                    icon.className = "ri-checkbox-circle-line toast-icon";
                    break;
                case "toast-info":
                    icon.className = "ri-information-line toast-icon";
                    break;
                case "toast-warning":
                    icon.className = "ri-alert-line toast-icon";
                    break;
                case "toast-error":
                    icon.className = "ri-close-circle-line toast-icon";
                    break;
                default:
                    icon.className = "ri-information-line toast-icon"; // Default icon
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