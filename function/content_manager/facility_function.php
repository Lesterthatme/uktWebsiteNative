<?php
session_start();
include("../../connection/dbconnection.php");
date_default_timezone_set('Asia/Phnom_Penh'); 

// start adding facility images
if (isset($_POST['add_facility'])) {
    $facility_name = mysqli_real_escape_string($conn, $_POST['facility_name']);
    $facility_description = mysqli_real_escape_string($conn, $_POST['facility_description']);
    $image_type = $_POST['image_type'];
    $department_id = $_POST['department_id'] ?? null;

    $user_id = $_SESSION['user_id'] ?? null;

    if (!$department_id || !$user_id) {
        die("Unauthorized or invalid request.");
    }

    $targetDir = "../../assets/uploads/department_facility/";
    if (!file_exists($targetDir)) {
        mkdir($targetDir, 0777, true);
    }

    $facility_image = '';
    if (isset($_FILES["facility_image"]) && $_FILES["facility_image"]["error"] == 0) {
        $fileTmpPath = $_FILES["facility_image"]["tmp_name"];
        $fileName = time() . "_" . basename($_FILES["facility_image"]["name"]);
        $targetFilePath = $targetDir . $fileName;

        if (move_uploaded_file($fileTmpPath, $targetFilePath)) {
            $facility_image = $fileName;
        }
    }
    $today = date("Y-m-d");

    $insertQuery = "INSERT INTO department_facilities 
        (facility_name, facility_description, facility_image, image_type, date_upload, department_id) 
        VALUES ('$facility_name', '$facility_description', '$facility_image', '$image_type', '$today', $department_id)";
    
    if (mysqli_query($conn, $insertQuery)) {
        $log_description = "Added new facility: $facility_name";
        $log_date = date("Y-m-d");
        $log_time = date("H:i:s");

        $logQuery = "INSERT INTO history_log (description, log_date, log_time, user_id) 
                     VALUES ('$log_description', '$log_date', '$log_time', $user_id)";
        mysqli_query($conn, $logQuery);

        $_SESSION['toastMsg'] = "Facility Added Successfully!";
        $_SESSION['toastType'] = "toast-success";

        header("Location: ../../pages/content_manager/facilities?department_id=$department_id#facility");
        exit();
    } else {
        $_SESSION['toastMsg'] = "Error Adding Facility.";
        $_SESSION['toastType'] = "toast-error";

        header("Location: ../../pages/content_manager/facilities?department_id=$department_id#facility");
        exit();
    }
}
// end adding facility end

// Start updating facility
if (isset($_POST['update_facility'])) {
    if (isset($_POST['facility_id']) && is_numeric($_POST['facility_id'])) {
        $facility_id = $_POST['facility_id'];
        $facility_name = mysqli_real_escape_string($conn, $_POST['facility_name']);
        $facility_description = mysqli_real_escape_string($conn, $_POST['facility_description']);
        $image_type = mysqli_real_escape_string($conn, $_POST['image_type']);
        $department_id = $_POST['department_id'];
        $user_id = $_SESSION['user_id']; 
        $target_dir = "../../assets/uploads/department_facility/";
        $facility_image = $_POST['current_image']; 

      
        if (isset($_FILES['facility_image']) && $_FILES['facility_image']['error'] === 0) {
            $uploaded_name = basename($_FILES['facility_image']['name']);
            $target_file = $target_dir . $uploaded_name;

            if (move_uploaded_file($_FILES['facility_image']['tmp_name'], $target_file)) {
                if (!empty($_POST['current_image']) && file_exists($target_dir . $_POST['current_image'])) {
                    unlink($target_dir . $_POST['current_image']);
                }
                $facility_image = $uploaded_name;
            } else {
                $_SESSION['toastMsg'] = "Error uploading the image.";
                $_SESSION['toastType'] = "toast-error";
                header("Location: ../../pages/content_manager/facilities?department_id=$department_id#facility");
                exit;
            }
        }

        $update_query = "UPDATE department_facilities 
                         SET facility_name = '$facility_name', 
                             facility_description = '$facility_description', 
                             facility_image = '$facility_image', 
                             image_type = '$image_type' 
                         WHERE facility_id = $facility_id";

        if (mysqli_query($conn, $update_query)) {
            $log_description = mysqli_real_escape_string($conn, "Updated facility: $facility_name");
            $log_date = date('Y-m-d');
            $log_time = date('H:i:s');

            $log_query = "INSERT INTO history_log (description, log_date, log_time, user_id)
                          VALUES ('$log_description', '$log_date', '$log_time', '$user_id')";
            mysqli_query($conn, $log_query);

            $_SESSION['toastMsg'] = "Facility Updated Successfully!";
            $_SESSION['toastType'] = "toast-success";
        } else {
            $_SESSION['toastMsg'] = "Error updating the facility: " . mysqli_error($conn);
            $_SESSION['toastType'] = "toast-error";
        }

        header("Location: ../../pages/content_manager/facilities?department_id=$department_id#facility");
        exit;
    } else {
        $_SESSION['toastMsg'] = "Invalid Facility ID.";
        $_SESSION['toastType'] = "toast-error";
        header("Location: ../../pages/content_manager/facilities?department_id=$department_id#facility");
        exit;
    }
}
// End updating facility

// start deleting facility
if (isset($_GET['facility_id']) && is_numeric($_GET['facility_id'])) {
    $facility_id = intval($_GET['facility_id']);
    $user_id = $_SESSION['user_id'] ?? null;

    if (!$user_id) {
        $_SESSION['toastMsg'] = "Unauthorized access.";
        $_SESSION['toastType'] = "toast-error";
        header("Location: ../../pages/content_manager/facilities");
        exit;
    }

    $fetch_query = "SELECT * FROM department_facilities WHERE facility_id = $facility_id";
    $result = mysqli_query($conn, $fetch_query);

    if ($result && mysqli_num_rows($result) > 0) {
        $facility_data = mysqli_fetch_assoc($result);

        $archive_description = json_encode($facility_data, JSON_UNESCAPED_UNICODE);
        $archived_at = date('Y-m-d H:i:s');
        $up_id = 1; 

        $ap_query = "SELECT ap_id FROM authorized_person WHERE user_id = $user_id";
        $ap_result = mysqli_query($conn, $ap_query);
        $ap_row = mysqli_fetch_assoc($ap_result);
        $ap_id = $ap_row['ap_id'] ?? null;

        if (!$ap_id) {
            $_SESSION['toastMsg'] = "Authorized person not found.";
            $_SESSION['toastType'] = "toast-error";
            header("Location: ../../pages/content_manager/facilities");
            exit;
        }

        $archive_insert = "INSERT INTO university_archive (original_table, record_id, archive_description, archived_at, archived_by, up_id)
                           VALUES ('department_facilities', $facility_id, '$archive_description', '$archived_at', $ap_id, $up_id)";
        mysqli_query($conn, $archive_insert);
        
        $delete_query = "DELETE FROM department_facilities WHERE facility_id = $facility_id";
        if (mysqli_query($conn, $delete_query)) {
    
            $desc = "Deleted facility: " . $facility_data['facility_name'];
            $log_date = date('Y-m-d');
            $log_time = date('H:i:s');

            $log_query = "INSERT INTO history_log (description, log_date, log_time, user_id)
                          VALUES ('$desc', '$log_date', '$log_time', $user_id)";
            mysqli_query($conn, $log_query);

            $_SESSION['toastMsg'] = "Facility deleted and archived successfully.";
            $_SESSION['toastType'] = "toast-success";
        } else {
            $_SESSION['toastMsg'] = "Error deleting facility.";
            $_SESSION['toastType'] = "toast-error";
        }
    } else {
        $_SESSION['toastMsg'] = "Facility not found.";
        $_SESSION['toastType'] = "toast-error";
    }

    header("Location: ../../pages/content_manager/facilities?department_id=" . $facility_data['department_id'] . "#facility");
    exit;
}
// end deleting facility
?>
