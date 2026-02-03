<?php
require '../../connection/dbconnection.php';
session_start();
$user_id = $_SESSION['user_id'];
// Fetch user details
$query = "SELECT ua.username, ua.email, ua.image, 
                 ap.ap_firstname, ap.ap_mi, ap.ap_lastname, 
                 ap.birthday, ap.age, ap.sex 
          FROM user_account ua
          INNER JOIN authorized_person ap ON ua.user_id = ap.user_id
          WHERE ua.user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

$user_image = !empty($user['image']) ? '../../assets/uploads/' . $user['image'] : '../../assets/uploads/officiallogo.png';

// update account functio start
date_default_timezone_set('Asia/Phnom_Penh');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstname = $_POST['ap_firstname'];
    $mi = $_POST['ap_mi'];
    $lastname = $_POST['ap_lastname'];
    $birthday = $_POST['birthday'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $sex = $_POST['sex'];

    // Check if user exists
    $fetch_query = "SELECT username FROM user_account WHERE user_id = ?";
    $stmt = $conn->prepare($fetch_query);
    $stmt->bind_param('i', $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $current_user = $result->fetch_assoc();

    if (!$current_user) {
        $_SESSION['toastMsg'] = "User not found.";
        $_SESSION['toastType'] = "toast-error";
        header("Location: edit_profile");
        exit;
    }

    // Handle profile image upload
    if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === UPLOAD_ERR_OK) {
        $image_tmp_name = $_FILES['profile_image']['tmp_name'];
        $image_name = time() . "_" . $_FILES['profile_image']['name']; // Prevent duplicate names
        $upload_dir = '../../assets/uploads/profile_pic/';
        $image_path = $upload_dir . basename($image_name);

        if (move_uploaded_file($image_tmp_name, $image_path)) {
            $update_image_query = "UPDATE user_account SET image = ? WHERE user_id = ?";
            $stmt = $conn->prepare($update_image_query);
            $stmt->bind_param('si', $image_name, $user_id);
            $stmt->execute();
        }
    }

    // Update authorized_person table
    $query = "UPDATE authorized_person SET ap_firstname = ?, ap_mi = ?, ap_lastname = ?, birthday = ?, sex = ? WHERE user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('sssssi', $firstname, $mi, $lastname, $birthday, $sex, $user_id);
    $stmt->execute();

    // Update user_account table
    $query = "UPDATE user_account SET email = ?, username = ? WHERE user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('ssi', $email, $username, $user_id);
    $stmt->execute();

    // Log the action
    $description = "Admin Profile Updated.";
    $log_date = date('Y-m-d');
    $log_time = date('H:i:s');

    $log_query = "INSERT INTO history_log (description, log_date, log_time, user_id) VALUES (?, ?, ?, ?)";
    $log_stmt = $conn->prepare($log_query);
    $log_stmt->bind_param('sssi', $description, $log_date, $log_time, $user_id);
    $log_stmt->execute();

    // Set session message for toast alert
    $_SESSION['toastMsg'] = "Profile updated successfully!";
    $_SESSION['toastType'] = "toast-success";

    header("Location: view_profile"); // Redirect to profile page
    exit;
}

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
    <!-- start css  -->
    <link rel="stylesheet" href="../../assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../assets/bootstrap/css/style.css">
    <!-- end css -->
    <!-- Remix icon -->
    <link rel="stylesheet" href="../../assets/RemixIcon/fonts/remixicon.css">
    <style>
        #profile-image {
            cursor: pointer;
        }



        .embossed-input {
            box-shadow: inset 2px 2px 5px rgba(0, 0, 0, 0.1), inset -2px -2px 5px rgba(255, 255, 255, 1);
        }

        .profile-pic-container {
            position: relative;
            width: 200px;
            height: 200px;
            border-radius: 50%;
            overflow: hidden;
            border: 2px solid #ddd;
        }

        .profile-pic-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
        }

        .camera-icon {
            position: absolute;
            bottom: 20px;
            right: 25px;
            background: rgba(0, 0, 0, 0.6);
            border-radius: 50%;
            padding: 5px;
            cursor: pointer;
        }

        .camera-icon img {
            width: 44px;
            height: 44px;
        }

        #fileInput {
            display: none;
        }
    </style>

</head>

<body>
    <!-- include side bar start -->
    <?php include 'include/alert.php'; ?>
    <?php include 'include/alert.php'; ?>
    <?php include 'include/sidebar.php'; ?>
    <!-- include side bar end -->

    <main class="bg-light">

        <?php include '../adminukt/include/navbar.php'; ?>
        <div class="p-4">
            <div class="row">
                <div class="card border-0 pb-3">
                    <form id="update-form" method="POST" enctype="multipart/form-data">
                        <div class="card-body">
                            <div class="container d-flex justify-content-center">
                                <div class="account_profile-card w-100" style="max-width: 1600px;">
                                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center">
                                        <div class="d-flex align-items-center text-center text-md-start">
                                            <div class="mx-auto text-center profile-pic-container" data-bs-toggle="tooltip"
                                                data-bs-placement="top" title="Click to  here to update profile picture">
                                                <img id="profile-image" src="<?= $user_image; ?>" alt="Profile Picture" onclick="triggerFileInput()">
                                                <div class="camera-icon" onclick="triggerFileInput()">
                                                    <img src="../../assets/images/camera.jfif" alt="Camera Icon">
                                                </div>
                                                <input type="file" class="form-control" id="fileInput" name="profile_image" accept="image/*" style="display: none;">
                                            </div>
                                            <div class="ms-3">
                                                <h4 class="mb-0"><?php echo $user['username']; ?></h4>
                                                <small class="text-muted"><?php echo $user['email']; ?></small>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">First Name</label>
                                            <input type="text" class="form-control" name="ap_firstname"
                                                value="<?php echo $user['ap_firstname'] ?? ''; ?>">
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">Middle Name</label>
                                            <input type="text" class="form-control" name="ap_mi" value="<?php echo $user['ap_mi'] ?? ''; ?>">
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">Last Name</label>
                                            <input type="text" class="form-control" name="ap_lastname"
                                                value="<?php echo $user['ap_lastname'] ?? ''; ?>">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">Birthday</label>
                                            <input type="date" class="form-control" name="birthday"
                                                value="<?php echo $user['birthday'] ?? ''; ?>">
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">Age</label>
                                            <input type="number" class="form-control" name="age" id="age" value="<?php echo $user['age'] ?? ''; ?>">
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">Sex</label>
                                            <select class="form-control" name="sex">
                                                <option value="Male" <?php if ($user['sex'] == 'Male') echo 'selected'; ?>>Male</option>
                                                <option value="Female" <?php if ($user['sex'] == 'Female') echo 'selected'; ?>>Female</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Username</label>
                                            <input type="text" class="form-control" name="username"
                                                value="<?php echo $user['username'] ?? ''; ?>">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Email</label>
                                            <input type="email" class="form-control" name="email" value="<?php echo $user['email'] ?? ''; ?>">
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-dynamic float-end mt-3" data-bs-toggle="tooltip"
                                        data-bs-placement="top" title="Click to save"><i class="ri-save-fill"></i> Save
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <?php include 'include/footer.php'; ?>
        </div>
    </main>

    <script src="../../assets/script.js"></script> <!-- this script is for disabling multiple login in session -->
    <script src="../../assets/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../../assets/bootstrap/js/jquery-3.7.1.js"></script>
    <script src="../../assets/bootstrap/js/script.js"></script>
    <script src="../../assets/bootstrap/js/carousel.js"></script>
    <script src="../../assets/bootstrap/js/site_settings.js"></script>

    <script>
        // script for auto get the image start
        function triggerFileInput() {
            document.getElementById('fileInput').click();
        }
        document.getElementById('fileInput').addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('profile-image').src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        });
        // script for auto get the image end

        // script for auto compute age start
        document.addEventListener("DOMContentLoaded", function() {
            const birthdayInput = document.querySelector('input[name="birthday"]');
            const ageInput = document.getElementById('age');

            function calculateAge() {
                const birthDate = new Date(birthdayInput.value);
                if (isNaN(birthDate)) {
                    ageInput.value = ''; // Clear age if invalid date
                    return;
                }

                const today = new Date();
                let age = today.getFullYear() - birthDate.getFullYear();
                const monthDiff = today.getMonth() - birthDate.getMonth();

                if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
                    age--; // Adjust if birthday hasn't occurred yet this year
                }

                ageInput.value = age;
            }

            birthdayInput.addEventListener("change", calculateAge);
        });
        // script for auto compute age end
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

</body>

</html>