<?php

include '../../connection/dbconnection.php';
session_start();
// Fetch all site settings start
if (!isset($_SESSION['user_id'])) {
    header('Location: ' . BASE_URL . 'pages/adminukt/login.php');
    exit;
}
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
    <!-- start css  -->
    <link rel="stylesheet" href="../../assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../assets/bootstrap/css/style.css?v=2.9">
    <!-- end css -->
    <!-- Remix icon -->
    <link rel="stylesheet" href="../../assets/RemixIcon/fonts/remixicon.css">

    <style>
        .video-card {
            border-radius: 10px;
            padding: 10px;
            background: #fff;
            transition: all 0.3s ease;
        }

        /* Hover effect */
        .video-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        /* Highlighted state */
        .video-card.active {
            border: 2px solid #0d6efd;
            box-shadow: 0 0 15px rgba(13, 110, 253, 0.5);
        }

        /* Highlighted button */
        .video-card.active .highlight-btn {
            background-color: #0d6efd;
            color: #fff;
        }
    </style>
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
                        <div class="d-flex flex-wrap justify-content-between align-items-center mb-2">
                            <h5 class="card-title fs-6 mb-2 mb-md-0">University Video</h5>
                            <button type="button" class="btn btn-sm btn-danger rounded-2 px-4"
                                title="Click to remove highlight" id="removeHighlightBtn">

                                <svg xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke-width="1.5"
                                    stroke="currentColor"
                                    width="16"
                                    height="16"
                                    class="me-1">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15 12H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                </svg>

                                Remove Highlight
                            </button>
                            <!-- later create a GET link -->
                        </div>
                        <p class="card-text text-muted small">Videos from database.</p>
                    </div>
                    <div class="container-fluid card-body">
                        <div class="row g-4">
                            <?php
                            $videos = [];
                            $stmt = mysqli_query($conn, "SELECT * FROM university_video");
                            if (mysqli_num_rows($stmt) > 0) {
                                while ($row = mysqli_fetch_assoc($stmt)) {
                                    $videos[] = [
                                        "id" => $row['video_id'],
                                        "link" => $row['video_link'],
                                        "isActive" => $row['is_pinned']
                                    ];
                                }
                            } else {
                            ?>
                                <div class="col-12">
                                    <div class="video-card text-center py-5">

                                        <!-- Heroicon: Video Camera (outline) -->
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke-width="1.5"
                                            stroke="currentColor"
                                            width="60"
                                            height="60"
                                            class="mb-3 text-muted">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M15.75 10.5V6.75A2.25 2.25 0 0013.5 4.5h-6A2.25 2.25 0 005.25 6.75v10.5A2.25 2.25 0 007.5 19.5h6a2.25 2.25 0 002.25-2.25V13.5l3.75 3v-9l-3.75 3z" />
                                        </svg>

                                        <h6 class="fw-semibold">No Videos Available</h6>
                                        <p class="text-muted small mb-0">
                                            There are currently no videos in the database.
                                        </p>

                                    </div>
                                </div>
                            <?php
                            }
                            ?>

                            <?php


                            foreach ($videos as $video):
                                parse_str(parse_url($video['link'], PHP_URL_QUERY), $params);
                                $video_id = $params['v'] ?? '';
                                $embed_url = "https://www.youtube.com/embed/" . $video_id;
                            ?>
                                <div class="col-lg-4 col-md-6 col-sm-12">
                                    <?php
                                    if ($video['isActive'] == "1") {
                                        echo '<div class="video-card active">';
                                    } else {
                                        echo '<div class="video-card">';
                                    }
                                    ?>
                                    <div class="ratio ratio-16x9">
                                        <iframe src="<?= $embed_url ?>" allowfullscreen></iframe>
                                    </div>

                                    <div class="text-center mt-2">
                                        <button class="btn btn-sm btn-outline-primary highlight-btn" data-id="<?= $video['id'] ?>">
                                            Highlight
                                        </button>
                                    </div>

                                </div>
                        </div>
                    <?php endforeach; ?>

                    </div>
                </div>
            </div>


            <?php include 'include/footer.php'; ?>
        </div>

    </main>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../../assets/bootstrap/js/Logs.js?v=1.1"></script>
    <script src="../../assets/bootstrap/js/site_settings.js"></script>
    <script src="../../assets/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../../assets/bootstrap/js/jquery-3.7.1.js"></script>
    <script src="../../assets/bootstrap/js/script.js"></script>
    <script src="../../assets/bootstrap/js/carousel2itemslide.js?=v1.7"></script>
    <script src="../../assets/bootstrap/js/drag_and_drop.js?=v1.0"></script>
    <script src="../../assets/bootstrap/js/activeLink.js?=v1.2"></script>

    <script>
        document.querySelectorAll('.highlight-btn').forEach(button => {
            button.addEventListener('click', function() {

                // Remove active from all
                document.querySelectorAll('.video-card').forEach(card => {
                    card.classList.remove('active');
                });

                // Add active to clicked one
                const card = this.closest('.video-card');
                card.classList.add('active');

                var id = this.dataset.id;

                // alert(id);
                window.location.href = `../../function/php/gallery/gallery.php?loc=adminukt&add=ooNamanYes&id=${id}`;
            });
        });
    </script>
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
    <!-- remove highlight btn -->
    <script>
        document.getElementById('removeHighlightBtn').addEventListener('click', () => {
            window.location.href = `../../function/php/gallery/gallery.php?loc=adminukt&remove=ooNamanYes`;
        });
    </script>
    <!-- end of remove highlight btn -->
</body>

</html>