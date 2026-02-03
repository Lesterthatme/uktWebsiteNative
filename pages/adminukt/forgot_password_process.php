<?php
include '/connection/dbconnection.php';
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
    <meta charset="UTF-8" />
    <link rel="icon" type="image/png" href="../../assets/uploads/site settings/favicon/<?php echo htmlspecialchars($settings['fav_icon']); ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($settings['websitetitle_admin']); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../../assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../assets/bootstrap/css/loginform.css?v=1.3">
    <title>Forgot Password</title>
    <style>
        body {
            background: url('../../assets/uploads/site settings/website background/<?php echo $website_background; ?>') no-repeat center center/cover;
        }
    </style>
</head>

<body>
    <div class="login-container">

        <!-- make this manageable also -->
        <?php
        if (isset($_POST['reset'])) {
            $email = $_POST['email'];
        } else {
            exit();
        }

        use PHPMailer\PHPMailer\PHPMailer;
        use PHPMailer\PHPMailer\SMTP;
        use PHPMailer\PHPMailer\Exception;

        require '../../mail/Exception.php';
        require '../../mail/PHPMailer.php';
        require '../../mail/SMTP.php';

        // Instantiation and passing `true` enables exceptions
        $mail = new PHPMailer(true);
        try {
            //itatago koto 

            //Server settings
            include $_SERVER['DOCUMENT_ROOT'] . '/includes/smtp.php';

            //Recipients
            $mail->setFrom('your_email@gmail.com', 'University of Kratie');
            $mail->addAddress($email);     // Add a recipient

            $forgot_password_code = substr(str_shuffle('1234567890QWERTYUIOPASDFGHJKLZXCVBNM'), 0, 10);

            // Content
            $mail->isHTML(true);
            $mail->Subject = 'UKT Password Reset';
            $mail->Body    = 'To reset your password click <a href="localhost/pages/adminukt/change_password?forgot_password_code=' . $forgot_password_code . '">here </a>. </br>Reset your password in a day.';


            $verifyQuery = $conn->query("SELECT * FROM user_account WHERE email = '$email'");

            if ($verifyQuery->num_rows) {
                $codeQuery = $conn->query("UPDATE user_account SET forgot_password_code = '$forgot_password_code' WHERE email = '$email'");

                if ($mail->send()) {
                    include 'email_success.php';
                }
            } else {
                include 'error.php';
            }
            $conn->close();
        } catch (Exception $e) {
            echo '<img src="../../assets/images/basc.png" alt="Error" />';
            echo '<h3 class="text-danger text-center">Message could not be sent Please check your internet connection!</h3>';
        }
        ?>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="../../assets/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../../assets/bootstrap/js/site_settings.js?v=1.9"></script>
</body>

</html>