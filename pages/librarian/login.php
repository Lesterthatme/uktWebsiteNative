<?php
include '../../connection/dbconnection.php';

$message = '';

if (isset($_POST["login_button"])) {
    $formdata = array();

    if (empty($_POST["email"])) {
        $message .= '<li>Email Address is required</li>';
    } else {
        if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
            $message .= '<li>Invalid Email Address</li>';
        } else {
            $formdata['email'] = $_POST['email'];
        }
    }

    if (empty($_POST['password'])) {
        $message .= '<li>Password is required</li>';
    } else {
        $formdata['password'] = $_POST['password'];
    }

    if ($message == '') {
        $data = $formdata['email'];

        $query = "SELECT * FROM user_account WHERE email = ?";
        $statement = $conn->prepare($query);

        if ($statement) {
            $statement->bind_param("s", $data);
            $statement->execute();
            $result = $statement->get_result();

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();

                if ($row['password'] == $formdata['password']) {
                    if ($row['user_type'] == 'Content manager') {
                        echo "<script>alert(\"You don't have a privilege\"); window.location.href='login';</script>";
                        exit;
                    } elseif ($row['account_status'] == 'approved' && $row['user_type'] == 'Librarian') {
                        session_start();
                        session_regenerate_id();
                
                        $session_token = session_id();
                
                        $update_query = "UPDATE user_account SET session_token = ? WHERE user_id = ?";
                        $update_statement = $conn->prepare($update_query);
                        $update_statement->bind_param("si", $session_token, $row['user_id']);
                        $update_statement->execute();
                        $update_statement->close();
                
                        $_SESSION['user_id'] = $row['user_id'];
                        $_SESSION['session_token'] = $session_token;
                
                        date_default_timezone_set('Asia/Phnom_Penh');
                        $description = "Account Logged in";
                        $log_date = date('Y-m-d');
                        $log_time = date('H:i:s');
                        $user_id = $row['user_id'];
                
                        $log_query = "INSERT INTO history_log (description, log_date, log_time, user_id) VALUES (?, ?, ?, ?)";
                        $log_statement = $conn->prepare($log_query);
                        $log_statement->bind_param("sssi", $description, $log_date, $log_time, $user_id);
                        $log_statement->execute();
                        $log_statement->close();
                
                        if (isset($_POST['remember'])) {
                            setcookie("user_email", $formdata['email'], time() + (86400 * 30), "/");
                            setcookie("user_password", $formdata['password'], time() + (86400 * 30), "/");
                        } else {
                            setcookie("user_email", "", time() - 3600, "/");
                            setcookie("user_password", "", time() - 3600, "/");
                        }
                
                        header('location:University_Library_updates');
                        exit;
                    } else {
                        $message = 'Your account is ' . $row['account_status'] . '. Please contact support.';
                    }
                } else {
                    $message = 'Wrong Password';
                }
            } else {
                // Wrong email
                $message = 'Wrong Email Address';
            }
            $statement->close();
        } else {
            $message = 'Database Query Error';
        }
    }
    if ($message != '') {
        echo "<script>alert('$message'); window.location.href='login';</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="../../assets/images/officiallogo (1).png" />
    <title>Login Page</title>
    <link rel="stylesheet" href="../../assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../assets/bootstrap/css/loginform.css">
    <title>Admin UKT Login</title>
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
                }, 100); // Forward after SweetAlert closes
            });
        }

        window.onpageshow = function(event) {
            if (event.persisted || (window.performance && window.performance.navigation.type === 2)) {
                noBack();
            }
        };

        // Block browser back button
        window.history.forward();
    </script>
</head>

<body>
    <div class="login-container">
        <img src="../../assets/images/officiallogo (1).png" alt="Logo" class="logo">
        <h3>University of Kratie</h3>
        <p class="subtitle">Knowledge for Development</p>
        <small class="mb-4">University Library</small>

        <form method="POST">
            <div>
                <?php if ($message != ''): ?>
                    <ul><?php echo $message; ?></ul>
                <?php endif; ?>
            </div>
            <div class="mb-3">
                <input type="email" name="email" class="form-control" id="email" placeholder="E-mail"
                    value="<?php echo isset($_COOKIE['user_email']) ? $_COOKIE['user_email'] : ''; ?>" required>
            </div>
            <div class="mb-3">
                <input type="password" name="password" class="form-control" id="password" placeholder="Password"
                    value="<?php echo isset($_COOKIE['user_password']) ? $_COOKIE['user_password'] : ''; ?>" required>
            </div>
            <div class="options">
                <div>
                    <input type="checkbox" id="remember" name="remember" <?php echo isset($_COOKIE['user_email']) ? 'checked' : ''; ?> />
                    <label for="remember">Remember me</label>
                </div>

                <a href="" data-bs-toggle="modal" data-bs-target="#forgotPasswordModal" class="forgot_pass">Forgot Password?</a>
            </div>
            <button type="submit" name="login_button" class="btn btn-dynamic w-100 mt-3 py-2 fw-bold">Login</button>
        </form>

        <p class="signup-text">
            Don't have an account? <a href="signup">Sign up</a>
        </p>

        <!-- New images at the bottom -->
        <div class="bottom-images">
            <img src="../../assets/images/basc.png" alt="Image 1">
            <img src="../../assets/images/ICS.png" alt="Image 2">
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
                    <form action="forgot_password_process.php" method="post">
                        <div class="row mb-3 justify-content-md-center">
                            <div class="col-12">
                                <label for="username" class="form-label mx-auto">
                                    <h5 class="mb-1 fs-7 text-muted fw-bold">Enter your Email-Address</h5>
                                </label>
                                <input type="email" name="email" placeholder="Email address" class="form-control mb-3 py-3 minimalist-input" required>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-dynamic w-100 mt-3 py-2 fw-bold" name="reset">
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