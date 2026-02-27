<?php
require $_SERVER['DOCUMENT_ROOT'] . '/ukt' . '/connection/dbconnection.php';

if (isset($_POST['signupBtn'])) {
    $conn->begin_transaction();
    try {
        $first_name = $conn->real_escape_string($_POST['ap_firstname']);
        $mi = $conn->real_escape_string($_POST['ap_mi']);
        $last_name = $conn->real_escape_string($_POST['ap_lastname']);
        $birthday = $conn->real_escape_string($_POST['birthday']);
        $age = $conn->real_escape_string($_POST['age']);
        $sex = $conn->real_escape_string($_POST['sex']);
        $username = $conn->real_escape_string($_POST['username']);
        $email = $conn->real_escape_string($_POST['email']);
        $password = $conn->real_escape_string($_POST['password']);
        $confirm_password = $conn->real_escape_string($_POST['confirm_password']);

        // Check if email already exists
        $email_query = "SELECT email FROM user_account WHERE email = '$email'";
        $email_result = $conn->query($email_query);

        if ($email_result->num_rows > 0) {
            $_SESSION['alreadyExist_message'] = 'Email already exists!';
            header("Location: ukt/pages/content_manager/signup.php");
            exit;
        }

        // Check if passwords match
        if ($password !== $confirm_password) {
            $_SESSION['passNotMatch'] = 'Password and Confirm Password do not match!';
            header("Location: ukt/pages/content_manager/signup.php");
            exit;
        }

        // Handle image upload
        $upload_folder = '../../assets/uploads/profile_pic/';
        $default_image = "default-profile.jpeg";
        $image = $_FILES['image']['name'];
        $image_tmp = $_FILES['image']['tmp_name'];

        if (!empty($image)) {
            if (!file_exists($upload_folder)) {
                mkdir($upload_folder, 0777, true); // Ensure folder exists
            }
            move_uploaded_file($image_tmp, $upload_folder . $image);
            $final_image = $image;
        } else {
            $final_image = $default_image;
        }

        // Insert into user_account
        $insert_user_account = "INSERT INTO user_account (username, email, password, image, user_type, account_status) 
                            VALUES ('$username', '$email', '$password', '$final_image', 'Content manager', 'pending')";

        if ($conn->query($insert_user_account)) {
            $user_id = $conn->insert_id;
            // Insert into authorized_person
            $insert_authorized_person = "INSERT INTO authorized_person (ap_firstname, ap_mi, ap_lastname, birthday, age, sex, user_id) 
                                     VALUES ('$first_name', '$mi', '$last_name', '$birthday', '$age', '$sex', '$user_id')";

            if ($conn->query($insert_authorized_person)) {
                $conn->commit();
                echo "
                <script>
                alert('Signup successful!');
            </script>";
                header('Location: ../../../pages/content_manager/login.php');
                exit;
            } else {
                $conn->rollback();
                header('Location: ukt/pages/content_manager/signup.php');
                exit;
            }
        } else {
            $conn->rollback();
            header('Location: ukt/pages/content_manager/signup.php');
            exit;
        }
    } catch (Exception $e) {
        $conn->rollback();
        header('Location: ukt/pages/content_manager/signup.php');
        exit;
    }
}
