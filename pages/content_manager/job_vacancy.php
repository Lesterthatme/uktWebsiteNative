<?php
session_start();
include("../../connection/dbconnection.php");

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
    <title><?php echo htmlspecialchars($settings['websitetitle_cm']); ?></title> 
    <!-- start css  -->
    <link rel="stylesheet" href="../../assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../assets/bootstrap/css/style.css?=v1.4">
    <!-- end css -->
    <!-- Remix icon -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../../assets/RemixIcon/fonts/remixicon.css">
    <!-- Summernote CSS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>
</head>

</head>

<body class="bg-light">

    <!-- include side bar start -->
    <?php include 'include/alert.php'; ?>
    <?php include 'confirmation.php'; ?>
    <?php include 'include/sidebar.php'; ?>
    <!-- include side bar end -->

    <main class="bg-light">

        <!-- include navbar start -->
        <?php include 'include/navbar.php';?>
        <!-- include navbar end -->

        <!-- start: Content -->
        <div class="p-4">
            <div class="row">
                <div class="card border-0 pb-3">
                    <div class="card-body">
                        <div class="doc-tabs-container mt-3">
                            <ul class="doc-tabs d-flex list-unstyled">
                                <li class="me-3">
                                    <a class="doc-link " href="job_opportunities">Overview</a>
                                </li>
                                <li class="me-3">
                                    <a class="doc-link active" href="job_vacancy">Job Vacancy</a>
                                </li>
                            </ul>
                            <hr class="doc-tabs-divider">
                        </div>
                        <button type="button" class="btn btn-sm rounded-2 px-4 float-end btn-dynamic" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-toggle="tooltip" data-bs-placement="top" title="Click here to add job">
                            <i class="ri-add-line"></i> Add Job
                        </button>
                        <p class="card-text text-muted small">Bulletin of Job Openings</p>
                        <!-- Modal FOR ADDING START-->
                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5 fw-bold" id="exampleModalLabel">Add Job Vacancy</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="../../function/content_manager/jobvacancy_function.php" method="POST" enctype="multipart/form-data">
                                            <div class="row">
                                                <div class="col-12 col-md-6 mb-3">
                                                    <label for="date_added" class="form-label fw-semibold text-muted"><strong>Date Posted:</strong></label>
                                                    <input type="date" class="form-control" id="date_added" name="date_posted" value="<?php echo date('Y-m-d'); ?>" required>
                                                </div>
                                                
                                            </div>

                                            <div class="row">
                                                <div class="col-12 col-md-8 mb-3">
                                                    <label for="job_position" class="form-label fw-semibold text-muted"><strong>Job Position</strong></label>
                                                    <input type="text" class="form-control" id="job_position" name="job_position" placeholder="Enter Job Position" required>
                                                </div>
                                                <div class="col-12 col-md-4 mb-3">
                                                    <label for="manpower_need" class="form-label fw-semibold text-muted"><strong>No. of Vacancies</strong></label>
                                                    <input type="number" class="form-control" id="manpower_need" name="manpower_need" placeholder="Enter No. of vacancies" required>
                                                </div>
                                            </div>

                                            <div class="mb-3">
                                                <label for="Campus/College/Office" class="form-label fw-semibold text-muted"><strong>Campus/College/Office</strong></label>
                                                <input type="text" class="form-control" id="Campus/College/Office" name="location" placeholder="Enter Location" required>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label fw-semibold text-muted"><strong>Upload Forms:</strong></label>
                                                <input type="file" name="job_forms" id="formFileInput" class="form-control"
                                                    accept=".pdf, .doc, .docx, .xls, .xlsx, .csv, .ppt, .pptx, .txt, .zip, .rar">
                                                <small class="text-muted">Supports: PDF, DOC, DOCX, XLS, XLSX, CSV, TXT, ZIP, RAR</small>
                                            </div>

                                            <div class="d-grid d-md-flex justify-content-md-end">
                                                <button type="submit" name="add_job" class="btn btn-dynamic" data-bs-toggle="tooltip" data-bs-placement="top" title="Click here to save"><i class="ri-save-line"></i> Save</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- MODAL FOR ADDING END -->

                        <!-- VIEWING ADMISSION START-->
                        <div class="log_container ">
                            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-3">
                                <div class="d-flex align-items-center mb-md-0">
                                    <label class="me-2">Show</label>
                                    <select id="entriesSelect" class="form-select custom-dropdown">
                                        <option value="5">5</option>
                                        <option value="10" selected>10</option>
                                        <option value="15">15</option>
                                        <option value="20">20</option>
                                    </select>
                                    <label class="ms-2 me-3">entries</label>
                                </div>
                                <div class="search-container me-2">
                                    <i class="ri-search-line"></i>
                                    <input type="text" id="searchBar" class="form-control" placeholder="Search">
                                </div>
                                <div class="d-flex align-items-center ms-md-auto mt-1">

                                    <select id="sortBy" class="form-select">
                                        <option value="">Sort By</option>
                                        <option value="date">Sort by Date</option>
                                        <option value="time">Sort by Time</option>
                                    </select>
                                </div>
                            </div>

                            <?php
                            include("../../connection/dbconnection.php");

                            // Fetch admission requirements
                            $query = "SELECT * FROM job_vacancy ORDER BY date_posted DESC";
                            $result = mysqli_query($conn, $query);
                            ?>

                            <div class="table-container">
                                <table class="table table-hover" id="activityTable">
                                    <thead>
                                        <tr>
                                            <th class="text-center">Position</th>
                                            <th class="text-center">No. of Vacancies</th>
                                            <th class="text-center">Date Posted</th>
                                            <th class="text-center">Campus/College/Office</th>
                                            <th class="text-center">Remarks</th>
                                            <th class="text-center">Attachment</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if ($result->num_rows > 0): ?>
                                            <?php while ($row = $result->fetch_assoc()): ?>
                                                <tr>
                                                    <td class="text-center"><?= $row['job_position'] ?></td>
                                                    <td class="text-center"><?= $row['manpower_need'] ?></td>
                                                    <td class="text-center"><?= date('F d, Y', strtotime($row['date_posted'])) ?></td>
                                                    <td class="text-center"><?= $row['location'] ?></td>
                                                    <td class="text-center">
                                                        <?php if ($row['remarks'] === 'Filled'): ?>
                                                            <span class="badge bg-success"><?= $row['remarks'] ?></span>
                                                        <?php elseif ($row['remarks'] === 'Unfilled'): ?>
                                                            <span class="badge bg-danger"><?= $row['remarks'] ?></span>
                                                        <?php else: ?>
                                                            <span class="badge bg-secondary"><?= $row['remarks'] ?></span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td class="text-center">
                                                        <?php if (!empty($row['job_forms'])): ?>
                                                            <?php
                                                            $filePath = str_replace('../', '../../', $row['job_forms']);
                                                            $fileExt = strtolower(pathinfo($row['job_forms'], PATHINFO_EXTENSION));

                                                            // Choose icon based on file extension
                                                            switch ($fileExt) {
                                                                case 'pdf':
                                                                    $icon = '<i class="ri-file-pdf-line text-danger" style="font-size: 30px;"></i>';
                                                                    break;
                                                                case 'doc':
                                                                case 'docx':
                                                                    $icon = '<i class="ri-file-word-line text-primary" style="font-size: 30px;"></i>';
                                                                    break;
                                                                case 'xls':
                                                                case 'xlsx':
                                                                case 'csv':
                                                                    $icon = '<i class="ri-file-excel-line text-success" style="font-size: 30px;"></i>';
                                                                    break;
                                                                case 'ppt':
                                                                case 'pptx':
                                                                    $icon = '<i class="ri-file-ppt-line text-warning" style="font-size: 30px;"></i>';
                                                                    break;
                                                                case 'txt':
                                                                    $icon = '<i class="ri-file-text-line text-secondary" style="font-size: 30px;"></i>';
                                                                    break;
                                                                case 'zip':
                                                                case 'rar':
                                                                    $icon = '<i class="ri-folder-zip-line text-muted" style="font-size: 30px;"></i>';
                                                                    break;
                                                                default:
                                                                    $icon = '<i class="ri-file-line text-dark" style="font-size: 30px;"></i>';
                                                            }
                                                            ?>
                                                            <a href="<?= $filePath ?>" target="_blank" class="text-decoration-none" title="Open File">
                                                                <?= $icon ?>
                                                            </a>
                                                        <?php else: ?>
                                                            <span class="text-muted">No Attachment</span>
                                                        <?php endif; ?>
                                                    </td>

                                                    <td class="text-center">
                                                        <div class="dropdown">
                                                            <button class="btn btn-light btn-sm" type="button" data-bs-toggle="dropdown" data-bs-toggle="tooltip" data-bs-placement="top" title="Click here to see the action">
                                                                <i class="ri-more-2-fill"></i>
                                                            </button>
                                                            <ul class="dropdown-menu">

                                                                <li>
                                                                    <a href="#editModal<?php echo $row['vacancy_id']; ?>"
                                                                        class="dropdown-item text-dark"
                                                                        data-bs-toggle="modal" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit this job vacancy">
                                                                        <i class="ri-pencil-line"></i> Edit
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <form action="../../function/content_manager/jobvacancy_function.php" method="POST" onsubmit="return confirm('Are you sure you want to delete this job vacancy?')">
                                                                        <input type="hidden" name="vacancy_id" value="<?= $row['vacancy_id'] ?>">
                                                                        <button type="submit" name="delete_jobvacancy" class="dropdown-item text-dark" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete this job vacancy">
                                                                        <i class="ri-delete-bin-line"></i> Delete
                                                                        </button>
                                                                    </form>
                                                                </li>

                                                            </ul>
                                                        </div>
                                                    </td>
                                                </tr>

                                                <!-- EDIT JOB VACANCY START -->
                                                <div class="modal fade" id="editModal<?= $row['vacancy_id']; ?>" tabindex="-1" aria-labelledby="editModalLabel<?= $row['vacancy_id']; ?>" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title fw-bold">Update Job Vacancy</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>

                                                            <div class="modal-body">
                                                                <form id="editForm<?= $row['vacancy_id']; ?>" action="../../function/content_manager/jobvacancy_function.php" method="POST" enctype="multipart/form-data">
                                                                    <input type="hidden" name="vacancy_id" value="<?= $row['vacancy_id']; ?>">

                                                                    <div class="row">
                                                                        <div class="col-md-6 mb-3">
                                                                            <label class="form-label"><strong>Date Posted</strong></label>
                                                                            <input type="date" class="form-control" name="date_posted" value="<?= $row['date_posted']; ?>" required>
                                                                        </div>
                                                                        <div class="col-md-6 mb-3">
                                                                            <label class="form-label"><strong>Remarks</strong></label>
                                                                            <select class="form-select" name="remarks" required>
                                                                                <option value="">Select Remarks</option>
                                                                                <option value="Filled" <?= $row['remarks'] == 'Filled' ? 'selected' : ''; ?>>Filled</option>
                                                                                <option value="Unfilled" <?= $row['remarks'] == 'Unfilled' ? 'selected' : ''; ?>>Unfilled</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>

                                                                    <div class="row">
                                                                        <div class="col-md-8 mb-3">
                                                                            <label class="form-label"><strong>Job Position</strong></label>
                                                                            <input type="text" class="form-control" name="job_position" value="<?= htmlspecialchars($row['job_position']); ?>" required>
                                                                        </div>
                                                                        <div class="col-md-4 mb-3">
                                                                            <label class="form-label"><strong>No. of Vacancies</strong></label>
                                                                            <input type="number" class="form-control" name="manpower_need" value="<?= htmlspecialchars($row['manpower_need']); ?>" required>
                                                                        </div>
                                                                    </div>

                                                                    <div class="mb-3">
                                                                        <label class="form-label"><strong>Campus/College/Office</strong></label>
                                                                        <input type="text" class="form-control" name="location" value="<?= htmlspecialchars($row['location']); ?>" required>
                                                                    </div>

                                                                    <!-- SHOW CURRENT FILE -->
                                                                    <?php if (!empty($row['job_forms'])): ?>
                                                                        <?php
                                                                        $full_path = $row['job_forms'];
                                                                        $file = basename($full_path);
                                                                        $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));

                                                                        $icons = [
                                                                            'pdf' => 'ri-file-pdf-line',
                                                                            'doc' => 'ri-file-word-line',
                                                                            'docx' => 'ri-file-word-line',
                                                                            'xls' => 'ri-file-excel-line',
                                                                            'xlsx' => 'ri-file-excel-line',
                                                                            'csv' => 'ri-file-excel-line',
                                                                            'ppt' => 'ri-file-ppt-line',
                                                                            'pptx' => 'ri-file-ppt-line',
                                                                            'txt' => 'ri-file-text-line',
                                                                            'zip' => 'ri-archive-line',
                                                                            'rar' => 'ri-archive-line',
                                                                        ];
                                                                        $icon = $icons[$ext] ?? 'ri-attachment-2';
                                                                        ?>

                                                                        <div class="mb-3" id="currentFilePreview<?= $row['vacancy_id']; ?>">
                                                                            <label class="form-label"><strong>Current File:</strong></label><br>
                                                                            <div class="d-flex align-items-center gap-2">
                                                                                <i class="<?= $icon ?> text-primary" style="font-size: 50px;"></i>
                                                                                <span><?= htmlspecialchars($file) ?></span>
                                                                            </div>
                                                                        </div>
                                                                    <?php endif; ?>

                                                                    <!-- PREVIEW NEW FILE -->
                                                                    <div id="newFilePreview<?= $row['vacancy_id']; ?>" class="mt-2" style="display: none;">
                                                                        <label class="form-label"><strong>Selected File:</strong></label>
                                                                        <div class="d-flex align-items-center gap-2">
                                                                            <i id="newFileIcon<?= $row['vacancy_id']; ?>" class="ri-attachment-2 text-success" style="font-size: 50px;"></i>
                                                                            <span id="newFileName<?= $row['vacancy_id']; ?>"></span>
                                                                        </div>
                                                                    </div>

                                                                    <!-- FILE INPUT -->
                                                                    <div class="mb-3">
                                                                        <label class="form-label"><strong>Upload New Form (Optional)</strong></label>
                                                                        <input type="file" name="job_forms" class="form-control"
                                                                            accept=".pdf,.doc,.docx,.xls,.xlsx,.csv,.ppt,.pptx,.txt,.zip,.rar"
                                                                            onchange="handleFileChange<?= $row['vacancy_id']; ?>(this)">
                                                                        <small class="text-muted">Supports: PDF, DOC, DOCX, XLS, XLSX, CSV, PPT, PPTX, TXT, ZIP, RAR</small>
                                                                    </div>

                                                                    <div class="modal-footer pb-0">
                                                                        <button type="submit" name="update_job" class="btn btn-dynamic" data-bs-toggle="tooltip" data-bs-placement="top" title="Click here to save">
                                                                            <i class="ri-save-line"></i> Save
                                                                        </button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- JS SCRIPT TO HANDLE FILE CHANGE -->
                                                <script>
                                                    function handleFileChange<?= $row['vacancy_id']; ?>(input) {
                                                        const file = input.files[0];
                                                        if (file) {
                                                            // Hide current file
                                                            const current = document.getElementById('currentFilePreview<?= $row['vacancy_id']; ?>');
                                                            if (current) current.style.display = 'none';

                                                            // Show new preview
                                                            const preview = document.getElementById('newFilePreview<?= $row['vacancy_id']; ?>');
                                                            const fileName = document.getElementById('newFileName<?= $row['vacancy_id']; ?>');
                                                            const fileIcon = document.getElementById('newFileIcon<?= $row['vacancy_id']; ?>');

                                                            const ext = file.name.split('.').pop().toLowerCase();
                                                            const iconMap = {
                                                                'pdf': 'ri-file-pdf-line',
                                                                'doc': 'ri-file-word-line',
                                                                'docx': 'ri-file-word-line',
                                                                'xls': 'ri-file-excel-line',
                                                                'xlsx': 'ri-file-excel-line',
                                                                'csv': 'ri-file-excel-line',
                                                                'ppt': 'ri-file-ppt-line',
                                                                'pptx': 'ri-file-ppt-line',
                                                                'txt': 'ri-file-text-line',
                                                                'zip': 'ri-archive-line',
                                                                'rar': 'ri-archive-line'
                                                            };

                                                            fileIcon.className = (iconMap[ext] || 'ri-attachment-2') + ' text-success';
                                                            fileName.textContent = file.name;
                                                            preview.style.display = 'flex';
                                                        }
                                                    }
                                                </script>
                                                <!-- EDIT JOB VACANCY END -->


                                            <?php endwhile; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="3" class="text-center">No Job Vacancy available</td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>

                                <div class="d-flex justify-content-center">
                                    <ul class="pagination custom-pagination mt-2"></ul>
                                </div>
                            </div>
                            <?php mysqli_close($conn); ?>

                        </div>
                    </div>
                </div>
                <?php include 'include/footer.php'; ?>
            </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/quill@1.3.6/dist/quill.min.js"></script>
    <script src="../../assets/bootstrap/js/logs.js?v=1.1"></script>
    <script src="../../assets/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../../assets/bootstrap/js/jquery-3.7.1.js"></script>
    <script src="../../assets/bootstrap/js/script.js"></script>
    <script src="../../assets/bootstrap/js/page_poster.js"></script>
    <script src="../../assets/bootstrap/js/drag_and_drop.js?=1.1"></script>
    <script src="../../assets/bootstrap/js/activeLink.js?v=1.3"></script>
    <script src="../../assets/bootstrap/js/table.js"></script>
    <script src="../../assets/bootstrap/js/site_settings.js"></script>

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


    <!-- end js -->
</body>

</html>