<?php
// session_start();
require '../../connection/dbconnection.php';

$user_id = (int) $_SESSION['user_id'];

$query = "
    SELECT ua.user_id, ua.username, ua.email, ua.image, 
           ap.ap_firstname, ap.ap_mi, ap.ap_lastname, ap.birthday, ap.age, ap.sex
    FROM user_account ua
    LEFT JOIN authorized_person ap ON ua.user_id = ap.user_id
    WHERE ua.user_id = $user_id
";

$result = mysqli_query($conn, $query);

if (!$result) {
    die("Query Failed: " . mysqli_error($conn));
}
$user = mysqli_fetch_assoc($result);


// START >> UPDATE FUNCTION OF ADMIN
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_admin'])) {

    $user_id = (int) $_POST['user_id'];
    $ap_firstname = mysqli_real_escape_string($conn, $_POST['ap_firstname']);
    $ap_mi = mysqli_real_escape_string($conn, $_POST['ap_mi']);
    $ap_lastname = mysqli_real_escape_string($conn, $_POST['ap_lastname']);
    $birthday = mysqli_real_escape_string($conn, $_POST['birthday']);
    $age = (int) $_POST['age'];
    $sex = mysqli_real_escape_string($conn, $_POST['sex']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $session_user_id = $_SESSION['user_id'] ?? null;

    if (!$session_user_id) {
        die("Error: User is not logged in.");
    }

    $update_fields = [];

    // Check changes in authorized_person table
    if ($ap_firstname != $user['ap_firstname'])
        $update_fields[] = "First Name";
    if ($ap_mi != $user['ap_mi'])
        $update_fields[] = "Middle Initial";
    if ($ap_lastname != $user['ap_lastname'])
        $update_fields[] = "Last Name";
    if ($birthday != $user['birthday'])
        $update_fields[] = "Birthday";
    if ($age != $user['age'])
        $update_fields[] = "Age";
    if ($sex != $user['sex'])
        $update_fields[] = "Sex";

    // Image Upload Handling (for user_account)
    $image_name = $user['image']; // Keep existing image if not updated
    if (!empty($_FILES['image']['name'])) {
        $upload_dir = "../../assets/uploads/profile_pic/";
        $new_image_name = basename($_FILES['image']['name']);
        $target_file = $upload_dir . $new_image_name;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Allowed file types
        $allowed_types = ['jpg', 'jpeg', 'png'];

        if (in_array($imageFileType, $allowed_types)) {
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                $update_fields[] = "Profile Image (Updated from {$user['image']} to $new_image_name)";
                $image_name = $new_image_name;
            } else {
                die("Error uploading image.");
            }
        } else {
            die("Invalid file type. Allowed: JPG, JPEG, PNG.");
        }
    }

    // Update authorized_person table
    $update_person = "
        UPDATE authorized_person 
        SET ap_firstname='$ap_firstname', ap_mi='$ap_mi', ap_lastname='$ap_lastname', 
            birthday='$birthday', age=$age, sex='$sex'
        WHERE user_id = $user_id
    ";

    // Check changes in user_account table
    if ($username != $user['username'])
        $update_fields[] = "Username";
    if ($email != $user['email'])
        $update_fields[] = "Email";

    // Update user_account table (including image)
    $update_user = "
        UPDATE user_account 
        SET username='$username', email='$email', image='$image_name' 
        WHERE user_id = $user_id
    ";

    if (mysqli_query($conn, $update_person) && mysqli_query($conn, $update_user)) {
        // Insert history log if changes were made
        if (!empty($update_fields)) {
            $log_description = "Updated $ap_firstname Profile: ". implode(", ", $update_fields);
            $log_query = "INSERT INTO history_log (description, log_date, log_time, user_id) 
                          VALUES ('$log_description', CURDATE(), CURRENT_TIME(), '$session_user_id')";

            if (!mysqli_query($conn, $log_query)) {
                die("Error inserting history log: " . mysqli_error($conn));
            }
        }

        $_SESSION['toastMsg'] = "Admin profile updated successfully!";
        $_SESSION['toastType'] = "toast-success";
    } else {
        die("Error updating profile: " . mysqli_error($conn));
    }

    header("Location: view_admin_profile.php");
    exit();
}
// END >> UPDATE FUNCTION OF ADMIN
?>
