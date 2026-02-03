<?php
session_start();
include '../connection/dbconnection.php'; 

if (isset($_POST["add_account"])) {
    $first_name = $_POST['first_name'];
    $middle_name = $_POST['middle_name'];
    $last_name = $_POST['last_name'];
    $birthday = $_POST['birthday'];
    $age = $_POST['age'];
    $sex = $_POST['sex'];
    $email = $_POST['email']; 
    $username = $_POST['username'];
    $password = $_POST['password'];
    $full_address = $_POST['full_address'];
    $contact_number = $_POST['contact_number'];
    
    $image = $_FILES['image']['name'];
    $image_tmp = $_FILES['image']['tmp_name'];
    $image_folder = "../assets/uploads/profile_pic/" . $image;
    move_uploaded_file($image_tmp, $image_folder);

    $user_type = "Content manager";
    $account_status = "approved";

    if (!isset($_SESSION['user_id'])) {
        echo "<script>
                alert('Error: Session expired. Please log in again.');
                window.location.href = '../login.php';
              </script>";
        exit();
    }
    $session_user_id = $_SESSION['user_id'];

    // Check if email already exists
    $check_email_query = "SELECT * FROM user_account WHERE email = ?";
    $stmt_check = $conn->prepare($check_email_query);
    $stmt_check->bind_param("s", $email);
    $stmt_check->execute();
    $stmt_check->store_result();

    if ($stmt_check->num_rows > 0) {
        echo "<script>
                alert('Error: Email already exists!');
                window.location.href = '../pages/adminukt/add_account';
              </script>";
        exit();
    }
    $stmt_check->close();

    // Insert into user_account
    $query_user = "INSERT INTO user_account (username, password, email, image, user_type, account_status) 
                   VALUES (?, ?, ?, ?, ?, ?)";
    
    $stmt_user = $conn->prepare($query_user);
    $stmt_user->bind_param("ssssss", $username, $password, $email, $image, $user_type, $account_status);

    if ($stmt_user->execute()) {
        $new_user_id = $stmt_user->insert_id;

        // Insert into authorized_person
        $query_ap = "INSERT INTO authorized_person (ap_firstname, ap_mi, ap_lastname, birthday, age, sex, full_address, contact_number, user_id) 
                     VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt_ap = $conn->prepare($query_ap);
        $stmt_ap->bind_param("ssssisssi", $first_name, $middle_name, $last_name, $birthday, $age, $sex, $full_address, $contact_number, $new_user_id);

        if ($stmt_ap->execute()) {
            date_default_timezone_set('Asia/Phnom_Penh');

            $log_description = "Added Content Manager $username";
            $log_date = date('Y-m-d');
            $log_time = date('H:i:s');

            $query_log = "INSERT INTO history_log (description, log_date, log_time, user_id) VALUES (?, ?, ?, ?)";
            $stmt_log = $conn->prepare($query_log);
            $stmt_log->bind_param("sssi", $log_description, $log_date, $log_time, $session_user_id);
            $stmt_log->execute();
            $stmt_log->close();

            echo "<script>
                    alert('User added successfully!');
                    window.location.href = '../pages/adminukt/add_account';
                  </script>";
        } else {
            echo "<script>alert('Error adding authorized person!');</script>";
        }
    } else {
        echo "<script>alert('Error adding user account!');</script>";
    }

    $stmt_user->close();
    $stmt_ap->close();
    $conn->close();
}
?>
