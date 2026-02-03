<?php
date_default_timezone_set('Asia/Phnom_Penh');

if (isset($_POST['add_partnership'])) {
    include '../../connection/dbconnection.php';
    $up_name = $_POST['up_name'];
    $up_link = $_POST['up_link'];
    $up_status = 'Active';
    $user_id = $_SESSION['user_id'] ?? null;

    if (!$user_id) {
        $_SESSION['toastMsg'] = "User is not logged in.";
        $_SESSION['toastType'] = "toast-error";
        header("Location: partnership");
        exit();
    }

    $ap_query = "SELECT ap_id FROM authorized_person WHERE user_id = ?";
    $ap_stmt = $conn->prepare($ap_query);
    $ap_stmt->bind_param("i", $user_id);
    $ap_stmt->execute();
    $ap_stmt->bind_result($ap_id);
    $ap_stmt->fetch();
    $ap_stmt->close();

    if (!$ap_id) {
        $_SESSION['toastMsg'] = "No authorized person found for the logged-in user!";
        $_SESSION['toastType'] = "toast-error";
        header("Location: partnership");
        exit();
    }

    if (!empty($_FILES['up_image']['name'])) {
        $file_name = $_FILES['up_image']['name'];
        $file_tmp = $_FILES['up_image']['tmp_name'];
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
       $allowed_extensions = ['jpg', 'jpeg', 'png', 'jfif'];

        if (in_array($file_ext, $allowed_extensions)) {
            $new_file_name = uniqid() . '.' . $file_ext;
            $upload_path = '../../assets/uploads/partnership/' . $new_file_name;

            if (move_uploaded_file($file_tmp, $upload_path)) {

                $query = "INSERT INTO university_partnership (up_name, up_link, up_image, up_date, up_time, up_status, ap_id) 
                          VALUES (?, ?, ?, CURDATE(), CURRENT_TIME(), ?, ?)";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("ssssi", $up_name, $up_link, $new_file_name, $up_status, $ap_id);
                
                if ($stmt->execute()) {
                    $stmt->close();

                    // Insert into history_log table
                    $log_description = "Added a new university partnership: '$up_name'";
                    $log_query = "INSERT INTO history_log (description, log_date, log_time, user_id) 
                                  VALUES (?, CURDATE(), CURRENT_TIME(), ?)";
                    $log_stmt = $conn->prepare($log_query);
                    $log_stmt->bind_param("si", $log_description, $user_id);

                    if ($log_stmt->execute()) {
                        $_SESSION['toastMsg'] = "University Partnership Added Successfully!";
                        $_SESSION['toastType'] = "toast-success";
                    } else {
                        $_SESSION['toastMsg'] = "Partnership added, but failed to log history.";
                        $_SESSION['toastType'] = "toast-warning";
                    }
                    $log_stmt->close();
                } else {
                    $_SESSION['toastMsg'] = "Error adding partnership: " . $stmt->error;
                    $_SESSION['toastType'] = "toast-error";
                }
            } else {
                $_SESSION['toastMsg'] = "Failed to upload the file.";
                $_SESSION['toastType'] = "toast-error";
            }
        } else {
            $_SESSION['toastMsg'] = "Invalid file type. Only JPG, JPEG, and PNG are allowed.";
            $_SESSION['toastType'] = "toast-warning";
        }
    } else {
        $_SESSION['toastMsg'] = "Please upload an image file.";
        $_SESSION['toastType'] = "toast-warning";
    }

    header("Location: partnership");
    exit();
}

// START >> UPDATE FUNCTION OF PARTNERSHIP
if (isset($_POST['update_partnership'])) {
    include '../../connection/dbconnection.php';
    $up_id = $_POST['up_id'];
    $up_name = mysqli_real_escape_string($conn, $_POST['up_name']);
    $up_link = mysqli_real_escape_string($conn, $_POST['up_link']);
    $up_status = $_POST['up_status']; 
    $user_id = $_SESSION['user_id'] ?? null;

    if (!$user_id) {
        die("Error: User is not logged in.");
    }

    $result = mysqli_query($conn, "SELECT * FROM university_partnership WHERE up_id = '$up_id'");
    if (!$result) {
        die("Error fetching partnership data: " . mysqli_error($conn));
    }
    $current_data = mysqli_fetch_assoc($result);

    $update_fields = [];

    if ($up_name != $current_data['up_name'])
        $update_fields[] = "Name";
    if ($up_link != $current_data['up_link'])
        $update_fields[] = "Link";
    if ($up_status != $current_data['up_status'])
        $update_fields[] = "Status";

    $imageName = $current_data['up_image']; 
    if (!empty($_FILES['up_image']['name'])) {
        $upload_dir = "../../assets/uploads/partnership/";
        $imageName = basename($_FILES['up_image']['name']);
        $target_file = $upload_dir . $imageName;

        if (move_uploaded_file($_FILES['up_image']['tmp_name'], $target_file)) {
            $update_fields[] = "Image";
        } else {
            die("Error uploading image.");
        }
    }

    $sql = "UPDATE university_partnership SET 
                up_name = '$up_name', 
                up_link = '$up_link', 
                up_status = '$up_status', 
                up_image = '$imageName' 
            WHERE up_id = '$up_id'";

    if ($conn->query($sql)) {
      
        if (!empty($update_fields)) {
            $log_description = "Updated the $up_name Partnership: " . implode(", ", $update_fields);
            $log_query = "INSERT INTO history_log (description, log_date, log_time, user_id) 
                          VALUES ('$log_description', CURDATE(), CURRENT_TIME(), '$user_id')";

            if (!$conn->query($log_query)) {
                die("Error inserting history log: " . mysqli_error($conn));
            }
        }

        $_SESSION['toastMsg'] = "Partnership updated successfully!";
        $_SESSION['toastType'] = "toast-success";
    } else {
        die("Error updating partnership: " . mysqli_error($conn));
    }

    header("Location: partnership");
    exit();
}
// END >> UPDATE FUNCTION OF PARTNERSHIP

// DELETE PARTNERSHIP START
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_partnership']) && isset($_POST['up_id'])) {
    require '../../connection/dbconnection.php';
    session_start();

    $up_id = intval($_POST['up_id']);
    $user_id = $_SESSION['user_id'] ?? null;

    if (!$user_id) {
        $_SESSION['toastMsg'] = "User is not logged in!";
        $_SESSION['toastType'] = "toast-error";
        header("Location: ../../pages/content_manager/partnership");
        exit();
    }

    // Retrieve the authorized_person ID (ap_id) from user_id
    $ap_query = "SELECT ap_id FROM authorized_person WHERE user_id = ?";
    $stmt = $conn->prepare($ap_query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($ap_id);
    $stmt->fetch();
    $stmt->close();

    if (!$ap_id) {
        $_SESSION['toastMsg'] = "Unauthorized action!";
        $_SESSION['toastType'] = "toast-error";
        header("Location: ../../pages/content_manager/partnership");
        exit();
    }

    // Fetch partnership details
    $query = "SELECT up_name, up_image, up_date, up_time, up_status, up_link, ap_id 
              FROM university_partnership WHERE up_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $up_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $partnership = $result->fetch_assoc();
    $stmt->close();

    if (!$partnership) {
        $_SESSION['toastMsg'] = "Partnership not found!";
        $_SESSION['toastType'] = "toast-error";
        header("Location: ../../pages/content_manager/partnership");
        exit();
    }

    // Convert partnership details to JSON
    $archive_description = json_encode($partnership);

    // Insert into university_archive with up_id = 1
    $archive_query = "INSERT INTO university_archive (original_table, record_id, archive_description, archived_at, archived_by, up_id) 
                      VALUES ('university_partnership', ?, ?, NOW(), ?, 1)";
    $stmt = $conn->prepare($archive_query);
    $stmt->bind_param("isi", $up_id, $archive_description, $ap_id);

    if (!$stmt->execute()) {
        $_SESSION['toastMsg'] = "Failed to archive partnership!";
        $_SESSION['toastType'] = "toast-error";
        header("Location: ../../pages/content_manager/partnership");
        exit();
    }

    $stmt->close();

    // Delete partnership after archiving
    $delete_query = "DELETE FROM university_partnership WHERE up_id = ?";
    $stmt = $conn->prepare($delete_query);
    $stmt->bind_param("i", $up_id);

    if ($stmt->execute()) {
        // Delete associated image
        $image_path = "../../assets/uploads/partnership/" . $partnership['up_image'];
        if (!empty($partnership['up_image']) && file_exists($image_path)) {
            unlink($image_path);
        }

        // Log the deletion
        $log_description = "Deleted the university partnership: '{$partnership['up_name']}'";
        $log_query = "INSERT INTO history_log (description, log_date, log_time, user_id) 
                      VALUES (?, CURDATE(), CURTIME(), ?)";
        $log_stmt = $conn->prepare($log_query);
        $log_stmt->bind_param("si", $log_description, $user_id);
        $log_stmt->execute();
        $log_stmt->close();

        $_SESSION['toastMsg'] = "University partnership deleted and archived successfully!";
        $_SESSION['toastType'] = "toast-success";
    } else {
        $_SESSION['toastMsg'] = "Failed to delete the university partnership!";
        $_SESSION['toastType'] = "toast-error";
    }

    $stmt->close();
    $conn->close();
    header("Location: ../../pages/content_manager/partnership");
    exit();
}
// DELETE PARTNERSHIP END
?>