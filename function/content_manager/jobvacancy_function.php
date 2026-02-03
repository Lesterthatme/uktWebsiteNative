<?php
include '../../connection/dbconnection.php'; 
session_start();

date_default_timezone_set('Asia/Phnom_Penh'); 

// ADD JOB VACANCY START
if (isset($_POST['add_job'])) {
    $user_id = $_SESSION['user_id']; 
    $job_position = $_POST['job_position'];
    $manpower_need = $_POST['manpower_need'];
    $date_posted = $_POST['date_posted'];
    $remarks = 'Unfilled';
    $location = $_POST['location'];
    $up_id = 1;

    $job_forms = '';
    if (isset($_FILES['job_forms']) && $_FILES['job_forms']['error'] == 0) {
        $target_dir = "../../assets/uploads/vacancy_form/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        $file_name = basename($_FILES["job_forms"]["name"]);
        $target_file = $target_dir . time() . "_" . $file_name;

        if (move_uploaded_file($_FILES["job_forms"]["tmp_name"], $target_file)) {
            $job_forms = $target_file;
        } else {
            $_SESSION['toastMsg'] = "Error uploading file.";
            $_SESSION['toastType'] = "toast-error";
            header("Location: ../../pages/content_manager/job_vacancy");
            exit();
        }
    }

    $stmt = $conn->prepare("SELECT ap_id FROM authorized_person WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        $_SESSION['toastMsg'] = "No authorized person linked with this user.";
        $_SESSION['toastType'] = "toast-error";
        header("Location: ../../pages/content_manager/job_vacancy");
        exit();
    }

$row = $result->fetch_assoc();
$ap_id = $row['ap_id'];
$stmt->close();

    if (!$ap_id) {
        $_SESSION['toastMsg'] = "No authorized person linked with this user.";
        $_SESSION['toastType'] = "toast-error";
        header("Location: ../../pages/content_manager/job_vacancy");
        exit();
    }

    $stmt = $conn->prepare("INSERT INTO job_vacancy (job_position, manpower_need, date_posted, job_forms, remarks, location, ap_id, up_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sissssii", $job_position, $manpower_need, $date_posted, $job_forms, $remarks, $location, $ap_id, $up_id);

    if ($stmt->execute()) {
        $stmt->close();

        $description = "Added new job vacancy: $job_position";
        $log_date = date("Y-m-d");
        $log_time = date("H:i:s");

        $stmt = $conn->prepare("INSERT INTO history_log (description, log_date, log_time, user_id) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sssi", $description, $log_date, $log_time, $user_id);
        $stmt->execute();
        $stmt->close();

        $_SESSION['toastMsg'] = "Job opportunity added successfully!";
        $_SESSION['toastType'] = "toast-success";
    } else {
        $_SESSION['toastMsg'] = "Failed to add job opportunity. <br><small>Error: " . htmlspecialchars($stmt->error) . "</small>";

        $_SESSION['toastType'] = "toast-error";
    }

    header("Location: ../../pages/content_manager/job_vacancy");
    exit();
}
// ADD JOB VACANCY END

// UPDATE JOB VACANCY START
if (isset($_POST['update_job'])) {
    $vacancy_id = $_POST['vacancy_id'];
    $date_posted = $_POST['date_posted'];
    $remarks = $_POST['remarks'];
    $job_position = $_POST['job_position'];
    $manpower_need = $_POST['manpower_need'];
    $location = $_POST['location'];
    $user_id = $_SESSION['user_id']; 
    $up_id = 1;

    // Get ap_id from authorized_person using user_id
    $stmt_ap = $conn->prepare("SELECT ap_id FROM authorized_person WHERE user_id = ?");
    $stmt_ap->bind_param("i", $user_id);
    $stmt_ap->execute();
    $result_ap = $stmt_ap->get_result();

    if ($result_ap->num_rows > 0) {
        $ap_id = $result_ap->fetch_assoc()['ap_id'];

        // File upload logic
        $job_forms = null;
        if (!empty($_FILES['job_forms']['name'])) {
            $file_name = time() . '_' . basename($_FILES['job_forms']['name']);
            $target_dir = "../../assets/uploads/vacancy_form/";
            $target_path = $target_dir . $file_name;

            if (move_uploaded_file($_FILES['job_forms']['tmp_name'], $target_path)) {
                $job_forms = $target_path;
            }
        }

        if ($job_forms) {
            $stmt_update = $conn->prepare("UPDATE job_vacancy SET date_posted=?, remarks=?, job_position=?, manpower_need=?, location=?, job_forms=?, ap_id=?, up_id=? WHERE vacancy_id=?");
            $stmt_update->bind_param("sssssssii", $date_posted, $remarks, $job_position, $manpower_need, $location, $job_forms, $ap_id, $up_id, $vacancy_id);
        } else {
            $stmt_update = $conn->prepare("UPDATE job_vacancy SET date_posted=?, remarks=?, job_position=?, manpower_need=?, location=?, ap_id=?, up_id=? WHERE vacancy_id=?");
            $stmt_update->bind_param("ssssssii", $date_posted, $remarks, $job_position, $manpower_need, $location, $ap_id, $up_id, $vacancy_id);
        }

        if ($stmt_update->execute()) {
            // Log the action
            $description = "Updated job vacancy: $job_position";
            $log_date = date("Y-m-d");
            $log_time = date("H:i:s");

            $stmt_log = $conn->prepare("INSERT INTO history_log (description, log_date, log_time, user_id) VALUES (?, ?, ?, ?)");
            $stmt_log->bind_param("sssi", $description, $log_date, $log_time, $user_id);
            $stmt_log->execute();

            $_SESSION['toastMsg'] = "Job vacancy updated successfully.";
            $_SESSION['toastType'] = "toast-success";
        } else {
            $_SESSION['toastMsg'] = "Error updating job vacancy.";
            $_SESSION['toastType'] = "toast-error";
        }
    } else {
        $_SESSION['error'] = "Authorized person not found.";
    }

    header("Location: ../../pages/content_manager/job_vacancy");
    exit();
}
// UPDATE JOB VACANCY END

// DELETE JOB VACANCY START

if (isset($_POST['delete_jobvacancy'])) {
    $vacancy_id = $_POST['vacancy_id'];
    $user_id = $_SESSION['user_id'];
    $up_id = 1;

    try {
        // Step 1: Get ap_id
        $ap_stmt = $conn->prepare("SELECT ap_id FROM authorized_person WHERE user_id = ?");
        $ap_stmt->bind_param("i", $user_id);
        $ap_stmt->execute();
        $ap_result = $ap_stmt->get_result();
        $ap_row = $ap_result->fetch_assoc();

        if (!$ap_row) {
            $_SESSION['error'] = "Authorized person not found.";
            header("Location: ../../pages/content_manager/job_vacancy");
            exit();
        }

        $ap_id = $ap_row['ap_id'];

        // Step 2: Get job vacancy data before deletion
        $vac_stmt = $conn->prepare("SELECT * FROM job_vacancy WHERE vacancy_id = ?");
        $vac_stmt->bind_param("i", $vacancy_id);
        $vac_stmt->execute();
        $vac_result = $vac_stmt->get_result();
        $vac_data = $vac_result->fetch_assoc();

        if (!$vac_data) {
            $_SESSION['error'] = "Job vacancy not found.";
            header("Location: ../../pages/content_manager/job_vacancy");
            exit();
        }

        // Step 3: Archive the data
        $original_table = 'job_vacancy';
        $record_id = $vacancy_id;
        $archive_description = json_encode($vac_data);
        $archived_at = date('Y-m-d H:i:s');

        $archive_stmt = $conn->prepare("INSERT INTO university_archive (original_table, record_id, archive_description, archived_at, archived_by, up_id) VALUES (?, ?, ?, ?, ?, ?)");
        $archive_stmt->bind_param("sissii", $original_table, $record_id, $archive_description, $archived_at, $ap_id, $up_id);
        $archive_stmt->execute();

        // Step 4: Delete job
        $delete_stmt = $conn->prepare("DELETE FROM job_vacancy WHERE vacancy_id = ?");
        $delete_stmt->bind_param("i", $vacancy_id);
        $delete_stmt->execute();

        // Step 5: Log deletion
        $description = "Deleted job vacancy: " . $vac_data['job_position'];
        $log_date = date('Y-m-d');
        $log_time = date('H:i:s');

        $log_stmt = $conn->prepare("INSERT INTO history_log (description, log_date, log_time, user_id) VALUES (?, ?, ?, ?)");
        $log_stmt->bind_param("sssi", $description, $log_date, $log_time, $user_id);
        $log_stmt->execute();

        $_SESSION['toastMsg'] = "Job vacancy deleted successfully.";
        $_SESSION['toastType'] = "toast-success";
    } catch (Exception $e) {
        $_SESSION['toastMsg'] = "Error deleting job vacancy: " . $e->getMessage();
        $_SESSION['toastType'] = "toast-error";
    }

    header("Location: ../../pages/content_manager/job_vacancy");
    exit();
}
// DELETE JOB VACANCY END
?>
