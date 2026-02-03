<?php
date_default_timezone_set('Asia/Phnom_Penh');
session_start();
include '../connection/dbconnection.php';

if (isset($_POST['title_admin'], $_POST['title_cm'], $_POST['website_tagline'])) {
    $title_admin = $_POST['title_admin'];
    $title_cm = $_POST['title_cm'];
    $website_tagline = $_POST['website_tagline'];

    $favicon = $_FILES['favicon'];
    $website_background = $_FILES['website_background'];
    $website_footerbg = $_FILES['website_footerbg'];
    $site_banner = $_FILES['site_banner'];
    $homepage_bg = $_FILES['homepage_bg'];

    $fetch = $conn->query("SELECT fav_icon, website_background, website_footerbg, site_banner, homepage_bg
     FROM site_settings WHERE settings_id = 1");
    $settings = $fetch->fetch_assoc();

    $favicon_name = $settings['fav_icon'];
    $background_name = $settings['website_background'];
    $footerbg_name = $settings['website_footerbg'];
    $sitebanner_name = $settings['site_banner'];
    $homepagebg_name = $settings['homepage_bg'];

    if ($favicon['error'] == 0) {
        $favicon_name = time() . '_' . basename($favicon['name']);
        $favicon_target = '../assets/uploads/site settings/favicon/' . $favicon_name;
        move_uploaded_file($favicon['tmp_name'], $favicon_target);
    }

    if ($website_background['error'] == 0) {
        $background_name = time() . '_' . basename($website_background['name']);
        $background_target = '../assets/uploads/site settings/website background/' . $background_name;
        move_uploaded_file($website_background['tmp_name'], $background_target);
    }

    if ($website_footerbg['error'] == 0) {
        $footerbg_name = time() . '_' . basename($website_footerbg['name']);
        $footerbg_target = '../assets/uploads/site settings/website footer/' . $footerbg_name;
        move_uploaded_file($website_footerbg['tmp_name'], $footerbg_target);
    }

    if ($site_banner['error'] == 0) {
        $sitebanner_name = time() . '_' . basename($site_banner['name']);
        $sitebanner_target = '../assets/uploads/site settings/website banner/' . $sitebanner_name;
        move_uploaded_file($site_banner['tmp_name'],  $sitebanner_target);
    }

    if ($homepage_bg['error'] == 0) {
        $homepagebg_name = time() . '_' . basename($homepage_bg['name']);
        $homepagebg_target = '../assets/uploads/site settings/home page background/' . $homepagebg_name;
        move_uploaded_file($homepage_bg['tmp_name'],  $homepagebg_target);
    }

    $user_id = $_SESSION['user_id'];

    $stmt = $conn->prepare("SELECT ap_id FROM authorized_person WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    
    if (!$row) {
        $_SESSION['toastMsg'] = "Authorized person not found.";
        $_SESSION['toastType'] = "toast-error";
        header("Location: ../pages/adminukt/site_settings");
        exit();
    }

    $ap_id = $row['ap_id'];
    $up_id = 1; 
    $update_sql = "UPDATE site_settings SET 
                    fav_icon = ?, 
                    website_tagline = ?, 
                    websitetitle_admin = ?, 
                    websitetitle_cm = ?, 
                    website_background = ?, 
                    website_footerbg = ?, 
                    site_banner = ?,
                    homepage_bg = ?,
                    ap_id = ?, 
                    up_id = ?
                   WHERE settings_id = 1";

    $stmt = $conn->prepare($update_sql);
    $stmt->bind_param("ssssssssii",
        $favicon_name,
        $website_tagline,
        $title_admin,
        $title_cm,
        $background_name,
        $footerbg_name,
        $sitebanner_name,
        $homepagebg_name,
        $ap_id,
        $up_id
    );

    if ($stmt->execute()) {
    
        $description = "Updated site settings.";
        $log_date = date('Y-m-d'); 
        $log_time = date('H:i:s'); 

        $log_stmt = $conn->prepare("INSERT INTO history_log (description, log_date, log_time, user_id) VALUES (?, ?, ?, ?)");
        $log_stmt->bind_param("sssi", $description, $log_date, $log_time, $user_id);
        $log_stmt->execute();

        $_SESSION['toastMsg'] = "Site settings updated successfully!";
        $_SESSION['toastType'] = "toast-success";
    } else {
        $_SESSION['toastMsg'] = "Error updating site settings: " . $stmt->error;
        $_SESSION['toastType'] = "toast-error";
    }

    header("Location: ../pages/adminukt/site_settings");
    exit();
}
?>
