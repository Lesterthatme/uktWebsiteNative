<?php
include 'include/alert.php';
require '../../connection/dbconnection.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('location:login.php');
    exit;
}
$user_id = $_SESSION['user_id'];

if (!isset($_SESSION['session_token'])) {
    header('location:login.php');
    exit;
}

// for changing password start
$message = '';

date_default_timezone_set('Asia/Phnom_Penh'); // Set timezone to Cambodia

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Fetch the current password and user details from the database
    $query = "SELECT * FROM user_account WHERE user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if (!$user) {
        setToastMessage("User not found.", "toast-error");
        header("Location: login.php");
        exit;
    } else {
        // Check if the entered current password matches the stored password
        if ($current_password === $user['password']) {
            // Check if the new password and confirm password match
            if ($new_password === $confirm_password) {
                // Update the password in the database
                $query = "UPDATE user_account SET password = ? WHERE user_id = ?";
                $stmt = $conn->prepare($query);
                $stmt->bind_param('si', $new_password, $user_id);
                
                if ($stmt->execute()) {
                    // Insert into history_log
                    $description = "Password Updated";
                    $log_date = date('Y-m-d');
                    $log_time = date('H:i:s');

                    $log_query = "INSERT INTO history_log (description, log_date, log_time, user_id) VALUES (?, ?, ?, ?)";
                    $log_stmt = $conn->prepare($log_query);
                    $log_stmt->bind_param('sssi', $description, $log_date, $log_time, $user_id);
                    $log_stmt->execute();

                    setToastMessage("Password updated successfully!");
                    header("Location: view_profile");
                    exit;
                } else {
                    setToastMessage("Failed to update password. Please try again.", "toast-error");
                    header("Location: view_profile");
                    exit;
                }
            } else {
                setToastMessage("New password and confirm password do not match.", "toast-error");
                header("Location: view_profile");
                exit;
            }
        } else {
            setToastMessage("Current password is incorrect.", "toast-error");
            header("Location: view_profile");
            exit;
        }
    }
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
    <link rel="stylesheet" href="../../assets/bootstrap/css/style.css?v=2.8">
    <!-- end css -->
    <!-- Remix icon -->
    <link rel="stylesheet" href="../../assets/RemixIcon/fonts/remixicon.css">
</head>

<body class="bg-light">
    <?php include 'include/sidebar.php'; ?>
    <main class="bg-light">

        <?php include 'include/navbar.php'; ?>

        <div class="p-4">
            <div class="row">
                <div class="card border-0 pb-3">

                    <!-- <input type="text" name="user_id" value="<?php echo $user['user_id']; ?>"> -->
                    <div class="card-body">
                        <div class="container d-flex justify-content-center">
                            <div class="account_profile-card w-100" style="max-width: 1600px;">
                                <div class="d-flex flex-column flex-md-row justify-content-between align-items-center">
                                    <div class="d-flex align-items-center text-center text-md-start">
                                        <img src="<?= $user_image; ?>" alt="Profile Image" class="rounded-circle"
                                            style="width: 100px; height: 100px; object-fit: cover;">
                                        <div class="ms-3">
                                            <h4 class="mb-0"><?php echo $user['username'] ?? 'Admin UKT'; ?></h4>
                                            <small
                                                class="text-muted"><?php echo $user['email'] ?? 'admin@gmail.com'; ?></small>
                                        </div>
                                    </div>
                                    <div class="d-inline-flex gap-2">
                                        <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal"
                                            data-bs-target="#staticBackdrop">
                                            Update Password
                                        </button>
                                        <a href="edit_profile.php" class="btn btn-dynamic"><i
                                                class="ri-edit-2-line"></i> Edit Profile</a>
                                    </div>

                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">First Name</label>
                                        <input type="text" class="form-control" name="ap_firstname"
                                            value="<?php echo $user['ap_firstname'] ?? ''; ?>" disabled>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Middle Name</label>
                                        <input type="text" class="form-control" name="ap_mi"
                                            value="<?php echo $user['ap_mi'] ?? ''; ?>" disabled>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Last Name</label>
                                        <input type="text" class="form-control" name="ap_lastname"
                                            value="<?php echo $user['ap_lastname'] ?? ''; ?>" disabled>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Birthday</label>
                                        <input type="text" class="form-control" name="birthday"
                                            value="<?php echo $user['birthday'] ?? ''; ?>" disabled>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Age</label>
                                        <input type="text" class="form-control" name="age"
                                            value="<?php echo $user['age'] ?? ''; ?>" disabled>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Sex</label>
                                        <input type="text" class="form-control" name="sex"
                                            value="<?php echo $user['sex'] ?? ''; ?>" disabled>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Username</label>
                                        <input type="text" class="form-control" name="username"
                                            value="<?php echo $user['username'] ?? ''; ?>" disabled>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Email</label>
                                        <input type="text" class="form-control" name="email"
                                            value="<?php echo $user['email'] ?? ''; ?>" disabled>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <?php include 'include/footer.php'; ?>
        </div>

        <!-- Modal for changing password start-->
        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Update Password</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="container">
                            <?php if (!empty($message)): ?>
                                <div
                                    class="alert <?= strpos($message, 'successfully') !== false ? 'alert-success' : 'alert-danger'; ?>">
                                    <?= htmlspecialchars($message); ?>
                                </div>
                            <?php endif; ?>
                            <form method="POST" action="">
                                <div class="mb-3">
                                    <label for="current_password" class="form-label"><strong>Current
                                            Password</strong></label>
                                    <input type="password" class="form-control" id="current_password"
                                        name="current_password" placeholder="Enter Current Password" required>
                                </div>
                                <div class="mb-3">
                                    <label for="new_password" class="form-label"><strong>New Password</strong></label>
                                    <input type="password" class="form-control" id="new_password" name="new_password"
                                        placeholder="Enter New Password" required>
                                </div>
                                <div class="mb-3">
                                    <label for="confirm_password" class="form-label"><strong>Confirm New
                                            Password</strong></label>
                                    <input type="password" class="form-control" id="confirm_password"
                                        name="confirm_password" placeholder="Confirm New Password" required>
                                </div>
                                <button type="submit" class="btn btn-dynamic w-100">Update Password</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal for changing password end-->
    </main>
    <script src="../../assets/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../../assets/bootstrap/js/jquery-3.7.1.js"></script>
  <script src="../../assets/bootstrap/js/script.js"></script>
  <script src="../../assets/bootstrap/js/carousel.js"></script>
  <script src="../../assets/bootstrap/js/drag_and_drop.js?=v1.1"></script>
  <script src="../../assets/bootstrap/js/activeLink.js?v=2.1"></script>
  <script src="../../assets/bootstrap/js/logs.js"></script>
  <script src="../../assets/bootstrap/js/site_settings.js?v=1.0"></script>
</body>

</html>