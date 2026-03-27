<?php
include("../connection/dbconnection.php");
session_start();

date_default_timezone_set("Asia/Phnom_Penh");

// Adding Scholarship start
if (isset($_POST["add_scholarship"])) {
    $conn->begin_transaction();
    try {
        $allowed_locations = ['adminukt', 'content_manager'];
        $location = $_POST['add_scholarship'];

        $status = "Active";
        $scholarship_title = $_POST["scholarship_title"];
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
                    header("Location: ../pages/" . $location . "/scholarship");
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
                    header("Location: ../pages/" . $location . "/scholarship");
                    exit;
                } else {
                    echo "Invalid location.";
                    exit;
                }
            }

            // Generate unique name
            $imageName = uniqid() . "_" . basename($fileName);

            $uploadPath = "../assets/uploads/student/scholarship/" . $imageName;

            move_uploaded_file($fileTmp, $uploadPath);
        }

        $stmt = $conn->prepare("INSERT INTO university_scholarship (scholarship_title, `description` , date_added, `status`, ap_id, up_id, `image`) 
                    VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssiis", $scholarship_title, $description, $date_added, $status, $ap_id, $up_id, $imageName);
        if (!$stmt->execute()) {
            $conn->rollback();
            $_SESSION['toastMsg'] = "Error adding scholarship: " . $stmt->error;
            $_SESSION['toastType'] = "toast-error";
            if (in_array($location, $allowed_locations)) {
                header("Location: ../pages/" . $location . "/scholarship");
                exit;
            } else {
                echo "Invalid location.";
                exit;
            }
        }

        $log_description = "Added a new University Scholarship: " . $scholarship_title;
        $log_date = date("Y-m-d");
        $log_time = date("H:i:s");

        $log_sql = "INSERT INTO history_log (`description`, log_date, log_time, user_id) VALUES (?, ?, ?, ?)";
        $stmt_log = $conn->prepare($log_sql);
        $stmt_log->bind_param("sssi", $log_description, $log_date, $log_time, $user_id);
        $stmt_log->execute();


        $conn->commit();
        $_SESSION['toastMsg'] = "Scholarship updated successfully!";
        $_SESSION['toastType'] = "toast-success";
        if (in_array($location, $allowed_locations)) {
            header("Location: ../pages/" . $location . "/scholarship");
            exit;
        } else {
            echo "Invalid location.";
            exit;
        }
    } catch (Exception $e) {
        $conn->rollback();
        $_SESSION['toastMsg'] = "Something Went Wrong!";
        $_SESSION['toastType'] = "toast-error";
        if (in_array($location, $allowed_locations)) {
            header("Location: ../pages/" . $location . "/scholarship");
            exit;
        } else {
            echo "Invalid location.";
            exit;
        }
    }
}
// Adding Scholarship End

// Updating Scholarship start
if (isset($_POST['update_scholarship'])) {
    $conn->begin_transaction();
    try {
        $allowed_locations = ['adminukt', 'content_manager'];
        $location = $_POST['update_scholarship'];

        $scholarship_id = $_POST['scholarship_id'];
        $scholarship_title = mysqli_real_escape_string($conn, $_POST['scholarship_title']);
        $description = mysqli_real_escape_string($conn, $_POST['description']);
        $status = mysqli_real_escape_string($conn, $_POST['status']);
        $date_added = mysqli_real_escape_string($conn, $_POST['date_added']);

        $image_sql = "";
        if (isset($_FILES['scholarship_image']) && $_FILES['scholarship_image']['error'] == 0) {
            $allowed_ext = ['jpg', 'jpeg', 'png'];
            $file_name = $_FILES['scholarship_image']['name'];
            $file_tmp = $_FILES['scholarship_image']['tmp_name'];
            $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

            if (in_array($file_ext, $allowed_ext)) {
                $new_file_name = uniqid('sch_', true) . "." . $file_ext;
                $upload_dir = "../assets/uploads/student/scholarship/" . $new_file_name;

                if (move_uploaded_file($file_tmp, $upload_dir)) {
                    // Optional: delete old image
                    $old_image = mysqli_fetch_assoc(mysqli_query($conn, "SELECT `image` FROM university_scholarship WHERE scholarship_id = '$scholarship_id'"))['image'];
                    if (!empty($old_image) && file_exists("../assets/uploads/student/scholarship/" . $old_image)) {
                        unlink("../assets/uploads/student/scholarship/" . $old_image);
                    }

                    // Prepare SQL part for image update
                    $image_sql = ", image = '$new_file_name'";
                    echo $image_sql;
                } else {
                    $_SESSION['toastMsg'] = "Failed to upload image.";
                    $_SESSION['toastType'] = "toast-error";
                    if (in_array($location, $allowed_locations)) {
                        header("Location: ../pages/" . $location . "/scholarship");
                        exit;
                    } else {
                        echo "Invalid location.";
                        exit;
                    }
                }
            } else {
                $_SESSION['toastMsg'] = "Invalid image type. Allowed: jpg, jpeg, png";
                $_SESSION['toastType'] = "toast-error";
                if (in_array($location, $allowed_locations)) {
                    header("Location: ../pages/" . $location . "/scholarship");
                    exit;
                } else {
                    echo "Invalid location.";
                    exit;
                }
            }
        }

        $query = "UPDATE university_scholarship 
                      SET scholarship_title = '$scholarship_title', 
                          `description` = '$description', 
                          `status` = '$status',
                          date_added = '$date_added'
                          $image_sql
                      WHERE scholarship_id = '$scholarship_id'";

        if (mysqli_query($conn, $query)) {
            $log_description = "Updated University Scholarship: " . $scholarship_title;
            $log_date = date("Y-m-d");
            $log_time = date("H:i:s");

            $log_sql = "INSERT INTO history_log (description, log_date, log_time, user_id) VALUES (?, ?, ?, ?)";
            $stmt_log = $conn->prepare($log_sql);
            $stmt_log->bind_param("sssi", $log_description, $log_date, $log_time, $user_id);
            $stmt_log->execute();

            $conn->commit();
            $_SESSION['toastMsg'] = "Scholarship updated successfully!";
            $_SESSION['toastType'] = "toast-success";
            if (in_array($location, $allowed_locations)) {
                header("Location: ../pages/" . $location . "/scholarship");
                exit;
            } else {
                echo "Invalid location.";
                exit;
            }
        } else {
            $conn->rollback();
            $_SESSION['toastMsg'] = "Error updating scholarship: " . mysqli_error($conn);
            $_SESSION['toastType'] = "toast-error";
            if (in_array($location, $allowed_locations)) {
                header("Location: ../pages/" . $location . "/scholarship");
                exit;
            } else {
                echo "Invalid location.";
                exit;
            }
        }
    } catch (Exception $e) {
        $conn->rollback();
        if (in_array($location, $allowed_locations)) {
            header("Location: ../pages/" . $location . "/scholarship");
            exit;
        } else {
            echo "Invalid location.";
            exit;
        }
    }
}
// Updating Scholarship End

// Deleting Scholarship start
if (isset($_GET['scholarship_id'])) {
    $allowed_locations = ['adminukt', 'content_manager'];
    $location = $_GET['loc'];
    $scholarship_id = intval($_GET['scholarship_id']);

    $check_query = "SELECT * FROM university_scholarship WHERE scholarship_id = $scholarship_id";
    $check_result = mysqli_query($conn, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        $row = mysqli_fetch_assoc($check_result); // Store scholarship data
        $scholarship_title = $row['scholarship_title'];
        $image = $row['image'];

        // Get user_id from session
        if (isset($_SESSION["user_id"])) {
            $user_id = $_SESSION["user_id"];
        } else {
            $_SESSION['toastMsg'] = "Error: User not logged in.";
            $_SESSION['toastType'] = "toast-error";
            if (in_array($location, $allowed_locations)) {
                header("Location: ../pages/" . $location . "/scholarship");
                exit;
            } else {
                echo "Invalid location.";
                exit;
            }
        }

        // Get ap_id of current user
        $ap_query = "SELECT ap_id FROM authorized_person WHERE user_id = ?";
        $stmt_ap = $conn->prepare($ap_query);
        $stmt_ap->bind_param("i", $user_id);
        $stmt_ap->execute();
        $stmt_ap->bind_result($ap_id);
        $stmt_ap->fetch();
        $stmt_ap->close();

        // Insert into archive table before deletion
        $original_table = "university_scholarship";
        $record_id = $scholarship_id;
        $archive_description = json_encode($row); // convert full row to JSON
        $archived_at = date("Y-m-d H:i:s");
        $up_id = 1;

        $archive_sql = "INSERT INTO university_archive (original_table, record_id, archive_description, archived_at, archived_by, up_id)
                        VALUES (?, ?, ?, ?, ?, ?)";
        $stmt_archive = $conn->prepare($archive_sql);
        $stmt_archive->bind_param("sissii", $original_table, $record_id, $archive_description, $archived_at, $ap_id, $up_id);
        $stmt_archive->execute();
        $stmt_archive->close();

        // Now delete the scholarship
        $delete_query = "DELETE FROM university_scholarship WHERE scholarship_id = $scholarship_id";
        if (mysqli_query($conn, $delete_query)) {
            // Insert into history log
            $log_description = "Deleted Scholarship: " . $scholarship_title;
            $log_date = date("Y-m-d");
            $log_time = date("H:i:s");

            $log_sql = "INSERT INTO history_log (description, log_date, log_time, user_id) VALUES (?, ?, ?, ?)";
            $stmt_log = $conn->prepare($log_sql);
            $stmt_log->bind_param("sssi", $log_description, $log_date, $log_time, $user_id);
            $stmt_log->execute();
            $stmt_log->close();

            $_SESSION['toastMsg'] = "Scholarship deleted and archived successfully.";
            $_SESSION['toastType'] = "toast-success";

            unlink("../assets/uploads/student/scholarship/" . $image);
        } else {
            $_SESSION['toastMsg'] = "Error deleting scholarship.";
            $_SESSION['toastType'] = "toast-error";
        }
    } else {
        $_SESSION['toastMsg'] = "Scholarship not found.";
        $_SESSION['toastType'] = "toast-error";
    }
    if (in_array($location, $allowed_locations)) {
        header("Location: ../pages/" . $location . "/scholarship");
        exit;
    } else {
        echo "Invalid location.";
        exit;
    }
}
// Deleting Scholarship End
