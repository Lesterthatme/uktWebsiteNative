<?php
include '../connection/dbconnection.php';
session_start(); 
date_default_timezone_set('Asia/Phnom_Penh'); 

if (isset($_POST['update_university'])) {

    $up_id = $_POST['up_id'];
    $university_name = $_POST['university_name'];
    $university_street = $_POST['university_street'];
    $city_municipality = $_POST['city_municipality'];
    $university_province = $_POST['university_province'];
    $university_country = $_POST['university_country'];
    $university_postalcode = $_POST['university_postalcode'];
    $university_contactnumber = $_POST['university_contactnumber'];
    $university_emailaddress = $_POST['university_emailaddress'];
    $university_website = $_POST['university_website'];
    $fb_link = $_POST['fb_link'];
    $youtube_link = $_POST['youtube_link'];
    $university_yearestablished = $_POST['university_yearestablished'];
    $university_president = $_POST['university_president'];
    $user_id = $_SESSION['user_id']; 
    $log_date = date("Y-m-d");
    $log_time = date("H:i:s");

    // Fetch old data
    $fetch_query = "SELECT university_name, university_street, city_municipality, university_province, university_country, 
                           university_postalcode, university_contactnumber, university_emailaddress, university_website, 
                           fb_link, youtube_link, university_yearestablished, university_president, university_logo
                    FROM university_profile WHERE up_id = ?";
    
    $fetch_stmt = $conn->prepare($fetch_query);
    if (!$fetch_stmt) {
        $_SESSION['toastMsg'] = "Database error while preparing fetch query!";
        $_SESSION['toastType'] = "toast-error";
        header("Location: ../pages/adminukt/university_profile");
        exit;
    }
    $fetch_stmt->bind_param("i", $up_id);
    $fetch_stmt->execute();
    $fetch_stmt->bind_result(
        $old_name, $old_street, $old_city, $old_province, $old_country, 
        $old_postalcode, $old_contact, $old_email, $old_website, 
        $old_fb_link, $old_youtube_link, $old_year, $old_president, $old_image
    );
    $fetch_stmt->fetch();
    $fetch_stmt->close();

    // Detect changes
    $changes = [];
    if ($university_name !== $old_name) $changes[] = "Name";
    if ($university_street !== $old_street) $changes[] = "Street";
    if ($city_municipality !== $old_city) $changes[] = "City";
    if ($university_province !== $old_province) $changes[] = "Province";
    if ($university_country !== $old_country) $changes[] = "Country";
    if ($university_postalcode !== $old_postalcode) $changes[] = "Postal Code";
    if ($university_contactnumber !== $old_contact) $changes[] = "Contact Number";
    if ($university_emailaddress !== $old_email) $changes[] = "Email";
    if ($university_website !== $old_website) $changes[] = "Website";
    if ($fb_link !== $old_fb_link) $changes[] = "Facebook Link"; 
    if ($youtube_link !== $old_youtube_link) $changes[] = "Youtube Link"; 
    if ($university_yearestablished !== $old_year) $changes[] = "Year Established";
    if ($university_president !== $old_president) $changes[] = "President";

    $new_image = $old_image; 
    if (!empty($_FILES['university_logo']['name'])) {
        $target_dir = "../assets/uploads/university_image/";
        $file_name = basename($_FILES["university_logo"]["name"]);
        $target_file = $target_dir . $file_name;

        if (move_uploaded_file($_FILES["university_logo"]["tmp_name"], $target_file)) {
            $new_image = $file_name;
            $changes[] = "Image";
        } else {
            $_SESSION['toastMsg'] = "Error uploading image!";
            $_SESSION['toastType'] = "toast-error";
            header("Location: ../pages/adminukt/university_profile");
            exit;
        }
    }

    if (empty($changes)) {
        $_SESSION['toastMsg'] = "No changes detected.";
        $_SESSION['toastType'] = "toast-warning";
        header("Location: ../pages/adminukt/university_profile");
        exit();
    }

    // Update university profile
    $update_query = "UPDATE university_profile SET 
                university_name = ?, university_street = ?, city_municipality = ?, university_province = ?, 
                university_country = ?, university_postalcode = ?, university_contactnumber = ?, university_emailaddress = ?, 
                university_website = ?, fb_link = ?, youtube_link = ?, university_yearestablished = ?, university_president = ?, university_logo = ? 
                WHERE up_id = ?";

    $stmt = $conn->prepare($update_query);
    if (!$stmt) {
        $_SESSION['toastMsg'] = "Database error while preparing update query!";
        $_SESSION['toastType'] = "toast-error";
        header("Location: ../pages/adminukt/university_profile");
        exit;
    }
    $stmt->bind_param(
        "ssssssssssssssi", 
        $university_name, $university_street, $city_municipality, $university_province, 
        $university_country, $university_postalcode, $university_contactnumber, $university_emailaddress, 
        $university_website, $fb_link, $youtube_link, $university_yearestablished, $university_president, $new_image, $up_id
    );

    if ($stmt->execute()) {

        // Insert into history log
        $descriptionLog = "Updated University Profile: " . implode(", ", $changes);
        $log_query = "INSERT INTO history_log (description, log_date, log_time, user_id) VALUES (?, ?, ?, ?)";

        $log_stmt = $conn->prepare($log_query);
        if (!$log_stmt) {
            $_SESSION['toastMsg'] = "Database error while preparing log query!";
            $_SESSION['toastType'] = "toast-error";
            header("Location: ../pages/adminukt/university_profile");
            exit;
        }
        $log_stmt->bind_param("sssi", $descriptionLog, $log_date, $log_time, $user_id);
        $log_stmt->execute();
        $log_stmt->close();

        $_SESSION['toastMsg'] = "University profile updated successfully!";
        $_SESSION['toastType'] = "toast-success";
    } else {
        $_SESSION['toastMsg'] = "Update failed! Please try again.";
        $_SESSION['toastType'] = "toast-error";
    }

    $stmt->close();
    mysqli_close($conn);
    header("Location: ../pages/adminukt/university_profile");
    exit();
}
?>
