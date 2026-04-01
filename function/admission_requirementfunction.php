<?php
include("../connection/dbconnection.php");
session_start();

// Start adding requirement
if (isset($_POST["add_requirement"])) {
    $allowed_locations = ['adminukt', 'content_manager'];
    $location = $_GET['loc'] ?? '';

    // $_SESSION['toastMsg'] = "You are not authorize person to do this action.";
    // $_SESSION['toastType'] = "toast-error";
    // redirectToLocation($location, $id);
    function redirectToLocation($location)
    {
        if (in_array($location, ['adminukt', 'content_manager'])) {
            header("Location: ../pages/$location/admission_requirements");
            exit;
        } else {
            echo "Invalid location.";
            exit;
        }
    }

    $conn->begin_transaction();
    try {
        $status = 'Active';
        $requirement_title = $_POST["requirement_title"];
        $description = $_POST["description"];
        $up_id = 1;
        $date_added = $_POST["date_added"];


        $imageName = null; // default if no image

        if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {

            $fileTmp = $_FILES['image']['tmp_name'];
            $fileSize = $_FILES['image']['size'];
            $fileName = $_FILES['image']['name'];

            // Get MIME type
            $fileType = mime_content_type($fileTmp);
            // Allowed types
            $allowedTypes = ['image/jpeg', 'image/png'];

            if (!in_array($fileType, $allowedTypes)) {
                $_SESSION['toastMsg'] = "Invalid image type!";
                $_SESSION['toastType'] = "toast-error";
                if (in_array($location, $allowed_locations)) {
                    header("Location: ../pages/" . $location . "/admission_requirements");
                    exit;
                } else {
                    echo "Invalid location.";
                    exit;
                }
            }

            // Limit size (5MB)
            if ($fileSize > 5 * 1024 * 1024) {
                $_SESSION['toastMsg'] = "Image too large! Max 5MB.";
                $_SESSION['toastType'] = "toast-error";
                if (in_array($location, $allowed_locations)) {
                    header("Location: ../pages/" . $location . "/admission_requirements");
                    exit;
                } else {
                    echo "Invalid location.";
                    exit;
                }
            }

            // Generate unique name
            $imageName = uniqid() . "_" . basename($fileName);

            $uploadPath = "../assets/uploads/student/requirements/" . $imageName;

            move_uploaded_file($fileTmp, $uploadPath);
        }


        $user_id = $_SESSION["user_id"];

        // Fetch authorized person ID from user_account table
        $ap_query = "SELECT ap_id FROM authorized_person WHERE user_id = ?";
        $stmt_ap = $conn->prepare($ap_query);
        $stmt_ap->bind_param("i", $user_id);
        $stmt_ap->execute();
        $result_ap = $stmt_ap->get_result();

        if ($result_ap->num_rows > 0) {
            $row = $result_ap->fetch_assoc();
            $ap_id = $row["ap_id"];
        } else {
            $_SESSION['toastMsg'] = "Error: Authorized person not found.";
            $_SESSION['toastType'] = "toast-error";
            redirectToLocation($location);
        }

        // Insert into admission_requirement table
        $stmt = $conn->prepare("INSERT INTO admission_requirement (requirement_title, `description`, `image`, date_added, `status`, ap_id, up_id) 
                VALUES (?, ?, ?,?, ?, ?, ?)");
        $stmt->bind_param("sssssii", $requirement_title, $description, $imageName, $date_added, $status, $ap_id, $up_id);
        if (!$stmt->execute()) {
            $_SESSION['toastMsg'] = "Error adding requirement.";
            $_SESSION['toastType'] = "toast-error";
            redirectToLocation($location);
        }

        // Insert log into history_log table
        $log_description = "Added a new admission requirement: " . $requirement_title;
        $log_date = date("Y-m-d");
        $log_time = date("H:i:s");

        $log_sql = "INSERT INTO history_log (description, log_date, log_time, user_id) VALUES (?, ?, ?, ?)";
        $stmt_log = $conn->prepare($log_sql);
        $stmt_log->bind_param("sssi", $log_description, $log_date, $log_time, $user_id);
        if (!$stmt_log->execute()) {
            $_SESSION['toastMsg'] = "Error adding history log.";
            $_SESSION['toastType'] = "toast-error";
            redirectToLocation($location);
        }


        $_SESSION['toastMsg'] = "Requirement added successfully!";
        $_SESSION['toastType'] = "toast-success";

        $conn->commit();
        $_SESSION['toastMsg'] = "Added.";
        $_SESSION['toastType'] = "toast-success";
    } catch (Exception $e) {
        $conn->rollback();
        $_SESSION['toastMsg'] = "Image not found.";
        $_SESSION['toastType'] = "toast-error";
    }

    redirectToLocation($location);
}
// End adding requirement

// Start updating requirement
if (isset($_POST['update_requirement'])) {
    $allowed_locations = ['adminukt', 'content_manager'];
    $location = $_GET['loc'] ?? '';

    // $_SESSION['toastMsg'] = "You are not authorize person to do this action.";
    // $_SESSION['toastType'] = "toast-error";
    // redirectToLocation($location, $id);

    function redirectToLocation($location)
    {
        if (in_array($location, ['adminukt', 'content_manager'])) {
            header("Location: ../pages/$location/admission_requirements");
            exit;
        } else {
            echo "Invalid location.";
            exit;
        }
    }

    $conn->begin_transaction();
    try {

        $requirement_id = $_POST['requirement_id'];
        $date_added =  $_POST['date_added'];
        $status =  $_POST['status'];
        $requirement_title =  $_POST['requirement_title'];
        $description =  $_POST['description'];
        $image_sql = "";

        if (isset($_FILES['requirement_image']) && $_FILES['requirement_image']['error'] == 0) {
            $allowed_ext = ['jpg', 'jpeg', 'png'];
            $file_name = $_FILES['requirement_image']['name'];
            $file_tmp = $_FILES['requirement_image']['tmp_name'];
            $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

            if (in_array($file_ext, $allowed_ext)) {
                $new_file_name = uniqid('sch_', true) . "." . $file_ext;
                $upload_dir = "../assets/uploads/student/requirements/" . $new_file_name;

                if (move_uploaded_file($file_tmp, $upload_dir)) {
                    // Optional: delete old image
                    $old_image = mysqli_fetch_assoc(mysqli_query($conn, "SELECT `image` FROM admission_requirement WHERE requirement_id = '$requirement_id'"))['image'];
                    if (!empty($old_image) && file_exists("../assets/uploads/student/requirements/" . $old_image)) {
                        unlink("../assets/uploads/student/requirements/" . $old_image);
                    }

                    // Prepare SQL part for image update
                    $image_sql = ", image = '$new_file_name'";
                    echo $image_sql;
                } else {
                    $_SESSION['toastMsg'] = "Failed to upload image.";
                    $_SESSION['toastType'] = "toast-error";
                    redirectToLocation($location);
                }
            } else {
                $_SESSION['toastMsg'] = "Invalid image type. Allowed: jpg, jpeg, png";
                $_SESSION['toastType'] = "toast-error";
                redirectToLocation($location);
            }
        }

        $user_id = $_SESSION['user_id'];

        $query = "UPDATE admission_requirement 
                  SET requirement_title = '$requirement_title', 
                      description = '$description', 
                      status = '$status',
                      date_added = '$date_added' 
                      $image_sql
                  WHERE requirement_id = '$requirement_id'";

        if (mysqli_query($conn, $query)) {
            $log_description = "Updated admission requirement: " . $requirement_title;
            $log_date = date("Y-m-d");
            $log_time = date("H:i:s");

            $log_sql = "INSERT INTO history_log (description, log_date, log_time, user_id) VALUES (?, ?, ?, ?)";
            $stmt_log = $conn->prepare($log_sql);
            $stmt_log->bind_param("sssi", $log_description, $log_date, $log_time, $user_id);
            if (!$stmt_log->execute()) {
                $_SESSION['toastMsg'] = "Error updating requirement log";
                $_SESSION['toastType'] = "toast-error";
                redirectToLocation($location);
            }
        } else {
            $_SESSION['toastMsg'] = "Error updating requirement: " . mysqli_error($conn);
            $_SESSION['toastType'] = "toast-error";
            redirectToLocation($location);
        }


        $conn->commit();
        $_SESSION['toastMsg'] = "Requirement updated successfully!";
        $_SESSION['toastType'] = "toast-success";
    } catch (Exception $e) {
        $conn->rollback();
        $_SESSION['toastMsg'] = "Image not found.";
        $_SESSION['toastType'] = "toast-error";
    }
    redirectToLocation($location);
}
// End updating requirement

// Start deleting requirement
if (isset($_GET['requirement_id'])) {
    $allowed_locations = ['adminukt', 'content_manager'];
    $location = $_GET['loc'] ?? '';

    // $_SESSION['toastMsg'] = "You are not authorize person to do this action.";
    // $_SESSION['toastType'] = "toast-error";
    // redirectToLocation($location, $id);

    function redirectToLocation($location)
    {
        if (in_array($location, ['adminukt', 'content_manager'])) {
            header("Location: ../pages/$location/admission_requirements");
            exit;
        } else {
            echo "Invalid location.";
            exit;
        }
    }

    $conn->begin_transaction();
    try {
        $requirement_id = intval($_GET['requirement_id']);
        $user_id = $_SESSION["user_id"];

        // Get authorized person (ap_id) using user_id
        $stmt_ap = $conn->prepare("SELECT ap_id FROM authorized_person WHERE user_id = ?");
        $stmt_ap->bind_param("i", $user_id);
        if (!$stmt_ap->execute()) {
            $_SESSION['toastMsg'] = "Error: Authorized person not found.";
            $_SESSION['toastType'] = "toast-error";
            redirectToLocation($location);
        }

        $result_ap = $stmt_ap->get_result();

        $ap_row = $result_ap->fetch_assoc();
        $archived_by = $ap_row['ap_id'];
        $up_id = 1; // constant

        // Check if requirement exists

        $check_query = "SELECT * FROM admission_requirement WHERE requirement_id = $requirement_id";
        $check_result = mysqli_query($conn, $check_query);

        if (mysqli_num_rows($check_result) > 0) {
            $row = mysqli_fetch_assoc($check_result);
            $image = $row['image'];
            $requirement_title = $row['requirement_title'];
            $archived_at = date('Y-m-d H:i:s');
            // Archive the record before deletion
            $archive_description = json_encode($row, JSON_UNESCAPED_UNICODE);

            $archive_stmt = $conn->prepare("INSERT INTO university_archive (original_table, record_id, archive_description, archived_at, archived_by, up_id)
                                            VALUES (?, ?, ?, ?, ?, ?)");

            $original_table = 'admission_requirement';
            $archive_stmt->bind_param("sissii", $original_table, $requirement_id, $archive_description, $archived_at, $archived_by, $up_id);
            if (!$archive_stmt->execute()) {
                $_SESSION['toastMsg'] = "Error: Achieving failed.";
                $_SESSION['toastType'] = "toast-error";
                redirectToLocation($location);
            }

            // Delete the requirement
            $delete_query = "DELETE FROM admission_requirement WHERE requirement_id = $requirement_id";
            if (mysqli_query($conn, $delete_query)) {
                // Insert log
                $log_description = "Deleted admission requirement: " . $requirement_title;
                $log_date = date("Y-m-d");
                $log_time = date("H:i:s");

                $log_sql = "INSERT INTO history_log (`description`, log_date, log_time, user_id) VALUES (?, ?, ?, ?)";
                $stmt_log = $conn->prepare($log_sql);
                $stmt_log->bind_param("sssi", $log_description, $log_date, $log_time, $user_id);
                if (!$stmt_log->execute()) {
                    $_SESSION['toastMsg'] = "Error: Logging Error.";
                    $_SESSION['toastType'] = "toast-error";
                    redirectToLocation($location);
                }

                unlink("../assets/uploads/student/requirements/" . $image);
            } else {
                $_SESSION['toastMsg'] = "Error deleting requirement.";
                $_SESSION['toastType'] = "toast-error";
                redirectToLocation($location);
            }
        }

        $conn->commit();
        $_SESSION['toastMsg'] = "Requirement deleted and archived successfully.";
        $_SESSION['toastType'] = "toast-success";
    } catch (Exception $e) {
        $conn->rollback();
        $_SESSION['toastMsg'] = "Something Went Wrong.";
        $_SESSION['toastType'] = "toast-error";
    }

    redirectToLocation($location);
}
// End deleting requirement
