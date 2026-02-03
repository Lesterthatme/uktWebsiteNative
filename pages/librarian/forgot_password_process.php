<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../assets/downloaded links/bootstrap-5.3.3-dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="../custom css and js/For sign in and sign up assets/loginPageStyle.css">
    <title>Forgot Password</title>
</head>

<body>
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="row border rounded-5 p-3 bg-white shadow box-area">
            <div class="col-md-6 rounded-4 d-flex justify-content-center align-items-center flex-column left-box" style="background-color: #5ba6f1; ">
                <div class="featured-image mb-3">
                    <img src="pictures/2.png" class="img-fluid" style="width: 250px" />
                </div>
                <p class="text-white fs-2 text-uppercase">
                    <!-- auto type sci games -->
                    <b><span class="auto-type"><b></b></b>
                    <!-- auto type sci games end -->
                </p>
                <small class="text-white text-wrap text-center">Online Application for Science 8</small>
            </div>

            <div class="col-md-6 right-box">
                <div class="row align-items-center">
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
                        //Server settings
                        $mail->isSMTP();                                            // Send using SMTP
                        $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
                        $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
                        $mail->Username   = 'uktkratie@gmail.com';                     // SMTP username
                        $mail->Password   = 'fgww ccwv zcjb rdzx';                               // SMTP password
                        $mail->SMTPSecure = 'tls';       // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
                        $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

                        //Recipients
                        $mail->setFrom('your_email@gmail.com', 'University of Kratie');
                        $mail->addAddress($email);     // Add a recipient

                        $forgot_password_code = substr(str_shuffle('1234567890QWERTYUIOPASDFGHJKLZXCVBNM'), 0, 10);

                        // Content
                        $mail->isHTML(true);
                        $mail->Subject = 'UKT Password Reset';
                        $mail->Body    = 'To reset your password click <a href="http://localhost/ukt2.0/pages/librarian/change_password.php?forgot_password_code=' . $forgot_password_code. '">here </a>. </br>Reset your password in a day.';

                        $conn = new mysqli('localhost', 'u123573546_uktadmin', 'UKT2.0_db', 'u123573546_uktnew_db');

                        if ($conn->connect_error) {
                            echo '<p class="text-danger">Could not connect to the database.</p>';
                        } else {
                            $verifyQuery = $conn->query("SELECT * FROM user_account WHERE email = '$email'");

                            if ($verifyQuery->num_rows) {
                                $codeQuery = $conn->query("UPDATE user_account SET forgot_password_code = '$forgot_password_code' WHERE email = '$email'");

                                if ($mail->send()) {
                                    echo '<img src="pictures/confetti.gif" alt="Check" />';
                                    echo '<h3 class="text-success">Message has been sent, check your email</h3>';
                                } else {
                                    echo '<img src="pictures/imagefiles/error.gif" alt="Error" />';
                                    echo '<h3 class="text-danger">Message could not be sent. Mailer Error: ' . $mail->ErrorInfo . '</h3>';
                                }
                            }
                            $conn->close();
                        }
                    } catch (Exception $e) {
                        echo '<img src="../pictures/error.gif" alt="Error" />';
                        echo '<h3 class="text-danger text-center">Message could not be sent Please check your internet connection!</h3>';
                    }
                    ?>
                    
                </div>
            </div>
        </div>
    </div>
    <script src="https://unpkg.com/typed.js@2.1.0/dist/typed.umd.js"></script>
    <script>
        var typed = new Typed(".auto-type", {
            strings: ["Welcome to Sci-games"],
            typeSpeed: 50,
            loop: true,
        });
        var typed = new Typed(".happy", {
            strings: [
                "We are happy to have you back.",
            ],
            typeSpeed: 70,
            loop: true,
        });
    </script>

</body>

</html>