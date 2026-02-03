<?php

require '../../connection/dbconnection.php';
session_start();

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
    <link rel="stylesheet" href="../../assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../assets/bootstrap/css/style.css?v=2.8">
    <link rel="stylesheet" href="../../assets/RemixIcon/fonts/remixicon.css">

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

                        <?php include 'include/archivedpage_selector.php'; ?>

                        <div class="log_container mt-3">
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
                            include '../../connection/dbconnection.php';

                            $sql = "SELECT album_id AS id,
                                            album_name AS name,
                                            date_archived AS deleted_date,
                                            'Album' AS item_type
                                        FROM university_album_archive
                                        UNION
                                        SELECT 
                                            image_id AS id,
                                            image_name AS name,
                                            date_archived AS deleted_date,
                                            'Image' AS item_type
                                        FROM university_image_archive
                                        WHERE album_id NOT IN (
                                            SELECT album_id FROM university_album_archive
                                        )
                                        ORDER BY deleted_date DESC
                                    ";

                            $result = $conn->query($sql);
                            ?>

                            <!-- container nav -->
                            <div class="table-container">
                                <table class="table table-hover text-center align-middle" id="activityTable">
                                    <thead>
                                        <tr>
                                            <th class="text-start">Name</th>
                                            <th class="text-start">Date Deleted</th>
                                            <th class="text-start">Item Type</th>
                                            <th class="text-center">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                                echo '<tr>';

                                                // Name column
                                                echo '<td class="text-start">';
                                                echo '<div class="d-flex align-items-center gap-2">';
                                                if ($row['item_type'] === 'Album') {
                                                    echo '<i class="ri-folder-fill text-warning fs-4"></i>';
                                                    echo '<span>' . htmlspecialchars($row['name']) . '</span>';
                                                } else {
                                                    $imagePath = "../../assets/uploads/university_gallery/" . $row['name'];
                                                    if (file_exists($imagePath)) {
                                                        echo '<img src="' . $imagePath . '" alt="Image" style="width: 40px; height: 40px; object-fit: cover; border-radius: 5px;">';
                                                        echo '<span>' . htmlspecialchars($row['name']) . '</span>';
                                                    } else {
                                                        echo '<i class="ri-image-line text-muted fs-4"></i>';
                                                    }
                                                }
                                                echo '</div>';
                                                echo '</td>';

                                                // Date Deleted
                                                echo '<td class="text-start">' . date("F j, Y", strtotime($row['deleted_date'])) . '</td>';

                                                // Item Type
                                                echo '<td class="text-start">' . htmlspecialchars($row['item_type']) . '</td>';

                                                // Actions
                                                echo '<td class="text-center">
                                                        <div class="dropdown">
                                                            <button class="btn btn-light btn-sm" type="button" data-bs-toggle="dropdown" 
                                                                aria-expanded="false" title="Click here to see the action">
                                                                <i class="ri-more-2-fill"></i>
                                                            </button>
                                                            <ul class="dropdown-menu">
                                                                <li>
                                                                    <a class="dropdown-item text-dark" 
                                                                        href="../../function/content_manager/restorearchived_function.php?restoregallery_id=' . $row['id'] . '&item_type=' . $row['item_type'] . '" 
                                                                        onclick="return confirm(\'Do you want to restore this Album/Image?\')" 
                                                                        data-bs-toggle="tooltip" 
                                                                        data-bs-placement="right" 
                                                                        title="Click here to restore the Album/Image">
                                                                        <i class="ri-reset-left-line"></i> Restore
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item text-dark" 
                                                                        href="../../function/content_manager/restorearchived_function.php?deletegallery_id=' . $row['id'] . '&item_type=' . $row['item_type'] . '" 
                                                                        onclick="return confirm(\'Do you want to delete this Album/Image?\')" 
                                                                        data-bs-toggle="tooltip" 
                                                                        data-bs-placement="right" 
                                                                        title="Click here to permanently delete the Album/Image">
                                                                        <i class="ri-delete-bin-line"></i> Delete
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                        </td>';
                                                echo '</tr>';
                                            }
                                        } else {
                                            echo '<tr><td colspan="4">No archived items found.</td></tr>';
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>

                            <div class="d-flex justify-content-center">
                                <ul class="pagination custom-pagination mt-2"></ul>
                            </div>
                        </div>

                        <?php $conn->close(); ?>
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
    <script src="../../assets/bootstrap/js/carousel.js?=v1.0"></script>
    <script src="../../assets/bootstrap/js/formDrag_and_Drop.js"></script>
    <script src="../../assets/bootstrap/js/activeLink.js?v=1.9"></script>
    <script src="../../assets/bootstrap/js/logs.js"></script>
    <script src="../../assets/bootstrap/js/site_settings.js?v=1.4"></script>

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