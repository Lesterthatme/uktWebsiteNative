<?php
include '../../connection/dbconnection.php';
session_start();

// Set timezone
date_default_timezone_set('Asia/Phnom_Penh');

// Already logged in - prevent access
// if (isset($_SESSION['user_id'])) {
//     header("Location: page_management");
//     exit();
// }

// Auto-login with remember_me cookie
if (isset($_COOKIE['remember_me'])) {
    $session_token = $_COOKIE['remember_me'];

    $stmt = $conn->prepare("SELECT * FROM user_account WHERE session_token = ?");
    $stmt->bind_param("s", $session_token);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user) {
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['user_type'] = $user['user_type'];
        header("Location: page_management");
        exit();
    }
}

$message = '';

if (isset($_POST["login_button"])) {
    $login_value = isset($_POST["email"]) ? trim($_POST["email"]) : '';
    $password = isset($_POST["password"]) ? $_POST["password"] : '';

    if (empty($login_value)) {
        echo "<script>alert('Email or Username is required');</script>";
    }

    if (empty($password)) {
        echo "<script>alert('Password is required');</script>";
    }

    if ($message == '') {
        $query = "SELECT * FROM user_account WHERE (email = ? OR username = ?) AND password = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sss", $login_value, $login_value, $password);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();

            if ($row['user_type'] !== 'Administrator') {
                echo "<script>
                alert('You don\\'t have a privilege to log in as an Administrator'); window.location.href = 'login';</script>";
                exit;
            }

            if (!empty($row['session_token'])) {
                echo "<script>alert('You are already logged in. Please log out the previous session.'); window.location.href = 'login';</script>";
                exit;
            }

            // Generate and save session token
            session_regenerate_id();
            $session_token = session_id();

            $update_query = "UPDATE user_account SET session_token = ? WHERE user_id = ?";
            $update_stmt = $conn->prepare($update_query);
            $update_stmt->bind_param("si", $session_token, $row['user_id']);
            $update_stmt->execute();

            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['email'] = $row['email'];
            $_SESSION['user_type'] = $row['user_type'];
            $_SESSION['session_token'] = $session_token;

            // Logging
            $description = "Account Logged in";
            $log_date = date('Y-m-d');
            $log_time = date('H:i:s');
            $user_id = $row['user_id'];

            $log_query = "INSERT INTO history_log (description, log_date, log_time, user_id) VALUES (?, ?, ?, ?)";
            $log_stmt = $conn->prepare($log_query);
            $log_stmt->bind_param("sssi", $description, $log_date, $log_time, $user_id);
            $log_stmt->execute();

            // Set Remember Me cookie (valid for 30 days)
            if (isset($_POST['remember'])) {
                setcookie("remember_me", $session_token, time() + (30 * 24 * 60 * 60), "/");
            } else {
                setcookie("remember_me", "", time() - 3600, "/");
            }

            header("Location: page_management");
            exit;
        } else {
            echo "<script>alert('Invalid username, email or password!'); window.location.href = 'login';</script>";
            exit;
        }
    }
}

// display university logo and university name start
$query = "SELECT university_name, university_logo FROM university_profile LIMIT 1";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    $university = $result->fetch_assoc();
    $university_name = $university['university_name'];
    $university_logo = $university['university_logo'];
} else {
    // Default values in case no university is found
    $university_name = "University Name";
    $university_logo = "default-logo.png";
}
// display university logo and university name end

if (isset($_POST['clear_session'])) {
    $identifier = trim($_POST['user_identifier']);

    if ($identifier) {
        // Prepare the query
        $query = "UPDATE user_account SET session_token = NULL WHERE username = ? OR email = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ss", $identifier, $identifier);

        if ($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                echo "<script>alert('Session token cleared successfully.'); window.location.href='login';</script>";
            } else {
                echo "<script>alert('No user found with the provided username or email.'); window.location.href='login';</script>";
            }
        } else {
            echo "<script>alert('Error clearing session token: " . addslashes($stmt->error) . "'); window.location.href='login';</script>";
        }
        $stmt->close();
    } else {
        echo "<script>alert('Please enter a valid email or username.'); window.location.href='login';</script>";
    }
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
        $website_tagline = htmlspecialchars($settings['website_tagline']);
        $website_background = htmlspecialchars($settings['website_background']);
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
    <link rel="stylesheet" href="../../assets/bootstrap/css/loginform.css?v=1.3">
    <script type="text/javascript">
        function noBack() {
            Swal.fire({
                icon: 'warning',
                title: 'Oops...',
                text: 'Please logout your account first.',
                confirmButtonText: 'OK',
                confirmButtonColor: '#3085d6'
            }).then(() => {
                setTimeout(function() {
                    window.history.forward();
                }, 100);
            });
        }

        window.onpageshow = function(event) {
            if (event.persisted || (window.performance && window.performance.navigation.type === 2)) {
                noBack();
            }
        };

        window.history.forward();
    </script>
    <style>
        body {
            background: url('../../assets/uploads/site settings/website background/<?php echo $website_background; ?>') no-repeat center center/cover;
        }
    </style>
</head>

<body>
    <div class="login-container">
        <img src="../../assets/uploads/university_image/<?php echo htmlspecialchars($university_logo); ?>"
            alt="University Logo" class="sidebar-logo-img me-3" style="height: 150px; width: 150px;" data-bs-toggle="modal" data-bs-target="#clearSessionModal">
        <div class="d-flex flex-column mt-2">
            <h3 class="subtitle"><?php echo ($university_name); ?></h3>
        </div>
        <p class="subtitle"><?php echo htmlspecialchars($settings['website_tagline']); ?></p>

        <form method="POST">
            <div>
                <?php if ($message != ''): ?>
                    <ul><?php echo $message; ?></ul>
                <?php endif; ?>
            </div>
            <div class="mb-3">
                <input type="text" name="email" class="form-control" id="email" placeholder="E-mail or Username"
                    value="<?php echo isset($_COOKIE['user_email']) ? $_COOKIE['user_email'] : ''; ?>" required>
            </div>
            <div class="mb-3">
                <input type="password" name="password" class="form-control" id="password" placeholder="Password"
                    value="<?php echo isset($_COOKIE['user_password']) ? $_COOKIE['user_password'] : ''; ?>" required>
            </div>
            <div class="options">
                <div>
                    <input type="checkbox" id="remember" name="remember" checked />
                    <label for="remember">Remember me</label>
                </div>

                <a href="" data-bs-toggle="modal" data-bs-target="#forgotPasswordModal" class="forgot_pass">Forgot Password?</a>
            </div>
            <button type="submit" name="login_button" class="btn btn-dynamic w-100 mt-3 py-2 fw-bold">Login</button>
        </form>

        <!-- New images at the bottom -->
        <div class="bottom-images">
            <img src="../../assets/images/basc.png" alt="Image 1">
            <img src="../../assets/images/ICS.png" alt="Image 2">
        </div>
    </div>

    <!-- Clear Session Modal -->
    <div class="modal fade" id="clearSessionModal" tabindex="-1" aria-labelledby="clearSessionModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" action="">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="clearSessionModalLabel">Clear Session</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <label for="user_identifier" class="form-label">Enter your email or username:</label>
                        <input type="text" class="form-control" name="user_identifier" id="user_identifier" placeholder="Enter username or email" required>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" name="clear_session" class="btn btn-dynamic">Clear Session</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal for forgot password start-->
    <div class="modal fade" id="forgotPasswordModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Forgot Password</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="forgot_password_process" method="post">
                        <div class="row mb-3 justify-content-md-center">
                            <div class="col-12">
                                <label for="username" class="form-label mx-auto">
                                    <h5 class="mb-1 fs-7 text-muted fw-bold">Enter your Email-Address</h5>
                                </label>
                                <input type="email" name="email" placeholder="Email address" class="form-control mb-3 py-3 minimalist-input" required>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-login w-100 btn-dynamic" name="reset">
                                    Send
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal for forgot password end-->

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="../../assets/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../../assets/bootstrap/js/site_settings.js?v=1.8"></script>
</body>

</html>