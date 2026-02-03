<?php
session_start();
include '../../connection/dbconnection.php';
date_default_timezone_set("Asia/Phnom_Penh");

// START >> ADD FORM
// if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["add_form"])) {
//     $form_name = trim($_POST["form_name"]);
//     $form_description = $_POST["form_description"];
//     $ap_id = $_POST["ap_id"];

//     // Check for duplicate form name
//     $check_query = "SELECT COUNT(*) FROM university_form WHERE form_name = ?";
//     $stmt_check = $conn->prepare($check_query);
//     $stmt_check->bind_param("s", $form_name);
//     $stmt_check->execute();
//     $stmt_check->bind_result($count);
//     $stmt_check->fetch();
//     $stmt_check->close();

//     if ($count > 0) {
//         $_SESSION['toastMsg'] = "Error: A form with the same name already exists!";
//         $_SESSION['toastType'] = "toast-error";
//         header("Location: ../../pages/content_manager/downloadable_forms");
//         exit();
//     }

//     $target_dir = "../../assets/uploads/Downloadable_Forms/";
//     $file_name = basename($_FILES["form_path"]["name"]);
//     $target_file = $target_dir . time() . "_" . $file_name;
//     $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

//     $allowed_types = ["pdf", "doc", "docx", "xls", "xlsx", "csv", "ppt", "pptx", "txt", "zip", "rar"];

//     if (in_array($file_type, $allowed_types)) {
//         if (move_uploaded_file($_FILES["form_path"]["tmp_name"], $target_file)) {
//             $sql = "INSERT INTO university_form (form_name, form_description, form_path, date_uploaded, time_uploaded, ap_id) 
//                     VALUES (?, ?, ?, CURDATE(), CURTIME(), ?)";
//             $stmt = $conn->prepare($sql);
//             $stmt->bind_param("sssi", $form_name, $form_description, $target_file, $ap_id);

//             if ($stmt->execute()) {
//                 // Fetch user_id
//                 $user_id_query = "SELECT user_id FROM authorized_person WHERE ap_id = ?";
//                 $stmt_user = $conn->prepare($user_id_query);
//                 $stmt_user->bind_param("i", $ap_id);
//                 $stmt_user->execute();
//                 $stmt_user->bind_result($user_id);
//                 $stmt_user->fetch();
//                 $stmt_user->close();

//                 // Log the action
//                 $log_description = "New Form Added: $form_name";
//                 $log_query = "INSERT INTO history_log (description, log_date, log_time, user_id) VALUES (?, CURDATE(), CURTIME(), ?)";
//                 $stmt_log = $conn->prepare($log_query);
//                 $stmt_log->bind_param("si", $log_description, $user_id);
//                 $stmt_log->execute();
//                 $stmt_log->close();

//                 $_SESSION['toastMsg'] = "Form uploaded successfully!";
//                 $_SESSION['toastType'] = "toast-success";
//             } else {
//                 $_SESSION['toastMsg'] = "Error saving to database!";
//                 $_SESSION['toastType'] = "toast-error";
//             }
//         } else {
//             $_SESSION['toastMsg'] = "File upload failed!";
//             $_SESSION['toastType'] = "toast-error";
//         }
//     } else {
//         $_SESSION['toastMsg'] = "Invalid file type! Allowed: PDF, DOC, DOCX, XLS, XLSX, CSV, PPT, PPTX, TXT, ZIP, RAR";
//         $_SESSION['toastType'] = "toast-error";
//     }

//     header("Location: ../../pages/content_manager/downloadable_forms");
//     exit();
// }
// END >> ADD FORM

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["delete_form"])) {
    require '../../connection/dbconnection.php';
    session_start();

    $form_id = intval($_POST["form_id"]);

    // Fetch the form path
    $query = "SELECT form_path FROM university_form WHERE form_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $form_id);
    $stmt->execute();
    $stmt->bind_result($file_path);
    $stmt->fetch();
    $stmt->close();

    if ($file_path) {
        // Delete the form record
        $delete_query = "DELETE FROM university_form WHERE form_id = ?";
        $stmt_delete = $conn->prepare($delete_query);
        $stmt_delete->bind_param("i", $form_id);

        if ($stmt_delete->execute()) {
            // Remove the file from the server
            if (file_exists($file_path)) {
                unlink($file_path);
            }

            // Log the deletion
            if (isset($_SESSION['user_id'])) {
                $user_id = $_SESSION['user_id'];
                $log_description = "Deleted form: " . basename($file_path);
                $log_date = date("Y-m-d");
                $log_time = date("H:i:s");

                $log_query = "INSERT INTO history_log (description, log_date, log_time, user_id) VALUES (?, ?, ?, ?)";
                $stmt_log = $conn->prepare($log_query);
                $stmt_log->bind_param("sssi", $log_description, $log_date, $log_time, $user_id);
                $stmt_log->execute();
                $stmt_log->close();
            }

            $_SESSION['toastMsg'] = "Form deleted successfully!";
            $_SESSION['toastType'] = "toast-success";
        } else {
            $_SESSION['toastMsg'] = "Error deleting form!";
            $_SESSION['toastType'] = "toast-error";
        }
        $stmt_delete->close();
    } else {
        $_SESSION['toastMsg'] = "Form not found!";
        $_SESSION['toastType'] = "toast-error";
    }

    $conn->close();
    header("Location: ../../pages/content_manager/downloadable_forms");
    exit();
}

// Start updating form
if (isset($_POST['update_form'])) {
    $form_id = $_POST['form_id'];
    $form_name = mysqli_real_escape_string($conn, $_POST['form_name']);
    $form_description = mysqli_real_escape_string($conn, $_POST['form_description']);

    if (isset($_SESSION["user_id"])) {
        $user_id = $_SESSION["user_id"];
    } else {
        $_SESSION['toastMsg'] = "Error: User not logged in!";
        $_SESSION['toastType'] = "toast-error";
        header("Location: ../../pages/content_manager/downloadable_forms");
        exit();
    }

    $query = "UPDATE university_form 
            SET form_name = '$form_name', 
                form_description = '$form_description'
            WHERE form_id = '$form_id'";

    if (mysqli_query($conn, $query)) {
        $log_description = "Updated Form: " . $form_name;
        $log_date = date("Y-m-d");  
        $log_time = date("H:i:s"); 

        $log_sql = "INSERT INTO history_log (description, log_date, log_time, user_id) VALUES (?, ?, ?, ?)";
        $stmt_log = $conn->prepare($log_sql);
        $stmt_log->bind_param("sssi", $log_description, $log_date, $log_time, $user_id);
        $stmt_log->execute();
        $stmt_log->close();

        $_SESSION['toastMsg'] = "Form updated successfully!";
        $_SESSION['toastType'] = "toast-success";
    } else {
        $_SESSION['toastMsg'] = "Error updating form: " . mysqli_error($conn);
        $_SESSION['toastType'] = "toast-error";
    }

    mysqli_close($conn);
    header("Location: ../../pages/content_manager/downloadable_forms");
    exit();
}
// End updating form
?>