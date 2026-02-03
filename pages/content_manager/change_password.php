<?php
require 'change_password_process.php';
include '../../connection/dbconnection.php';

// display university logo and university name start
$query = "SELECT university_name, university_image FROM university_profile LIMIT 1";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    $university = $result->fetch_assoc();
    $university_name = $university['university_name'];
    $university_image = $university['university_image'];
} else {
    // Default values in case no university is found
    $university_name = "University Name";
    $university_image = "default-logo.png";
}
// display university logo and university name end
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="../../assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../assets/bootstrap/css/loginform.css?v=1.1">
</head>

<body>
    <div class="login-container">
    <img src="../../assets/uploads/university_image/<?php echo htmlspecialchars($university_image); ?>"
            alt="University Logo" class="sidebar-logo-img me-3" style="height: 150px; width: 150px;">
        <div class="d-flex flex-column mt-2">
            <h3 class="subtitle"><?php echo ($university_name); ?></h3>
        </div>
        <p class="subtitle">Change Password</p>
        <form action="" method="post">
            <div class="mb-3">
                <input type="email" name="email" id="inputEmail" class="form-control" placeholder="Enter email address" required>
            </div>
            <div class="mb-3">
                <input type="password" name="new_password" id="inputPassword" class="form-control" placeholder="Enter new password" required>
            </div>

            <div class="row mt-3">
                <button type="submit" class="btn btn-dynamic fw-bold" name="change">Change</button>
            </div>
    </div>
    </form>
    <script src="../../../assets/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../../assets/bootstrap/js/site_settings.js?v=1.8"></script>
</body>

</html>