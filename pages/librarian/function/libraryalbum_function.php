<?php
include("../../../connection/dbconnection.php"); 
session_start();

date_default_timezone_set("Asia/Phnom_Penh");

// Start adding album 
if (isset($_POST["add_libalbum"])) { 
    $libalbum_name = $_POST["libalbum_name"];
    $libalbum_description = $_POST["libalbum_description"];
    $status = $_POST["status"];
    $library_id = 1; 
    $date_created = $_POST["date_created"]; 

    if (isset($_SESSION["user_id"])) {
        $user_id = $_SESSION["user_id"];

        // Fetch authorized person ID
        $ap_query = "SELECT ap_id FROM authorized_person WHERE user_id = ?";
        $stmt_ap = $conn->prepare($ap_query);
        if (!$stmt_ap) {
            die("Error preparing statement (AP query): " . $conn->error);
        }

        $stmt_ap->bind_param("i", $user_id);
        $stmt_ap->execute();
        $result_ap = $stmt_ap->get_result();
        
        if ($result_ap->num_rows > 0) {
            $row = $result_ap->fetch_assoc();
            $ap_id = $row["ap_id"];
        } else {
            echo "<script>alert('Error: Authorized person not found.'); history.back();</script>";
            exit;
        }
        $stmt_ap->close();
    } else {
        echo "<script>alert('Error: User not logged in.'); history.back();</script>";
        exit;
    }

    // Check if album name already exists
    $check_query = "SELECT * FROM library_album WHERE libalbum_name = ?";
    $stmt_check = $conn->prepare($check_query);
    $stmt_check->bind_param("s", $album_name);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();

    if ($result_check->num_rows > 0) {
        echo "<script>alert('Album name already exists!'); history.back();</script>";
        exit; // Stop further execution if album name exists
    }

    // Insert into university_album table
    $sql = "INSERT INTO library_album (libalbum_name, libalbum_description, date_created, status, ap_id, library_id) 
            VALUES (?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssii", $libalbum_name, $libalbum_description, $date_created, $status, $ap_id,  $library_id);

    if ($stmt->execute()) {
        $libalbum_id = $stmt->insert_id;

        // Handle image uploads
        if (!empty($_FILES['images']['name'][0])) {
            $uploadDir = "../assets/uploads/library_gallery/";

            foreach ($_FILES['images']['tmp_name'] as $key => $tmp_name) {
                $imageName = basename($_FILES['images']['name'][$key]);
                $targetFilePath = $uploadDir . $imageName;

                if (move_uploaded_file($tmp_name, $targetFilePath)) {
                    $insertImage = "INSERT INTO library_image (libimage_name, upload_date, libalbum_id)
                                    VALUES (?, ?, ?)";
                    $stmtImage = $conn->prepare($insertImage);
                    $upload_date = date('Y-m-d');

                    if ($stmtImage) {
                        $stmtImage->bind_param("ssi", $imageName, $upload_date, $libalbum_id);
                        $stmtImage->execute();
                        $stmtImage->close();
                    } else {
                        echo "<script>alert('Error inserting image: " . $conn->error . "'); history.back();</script>";
                    }
                }
            }
        }

        // Insert into history log
        $description = "Added New Library album: '$libalbum_name' ";
        $log_date = date("Y-m-d");
        $log_time = date("H:i:s");

        $log_query = "INSERT INTO history_log (description, log_date, log_time, user_id) 
                      VALUES (?, ?, ?, ?)";

        $stmt_log = $conn->prepare($log_query);
        if ($stmt_log) {
            $stmt_log->bind_param("sssi", $description, $log_date, $log_time, $user_id);
            $stmt_log->execute();
            $stmt_log->close();
        }

        echo "<script>alert('Album and images added successfully!'); window.location.href='../library_gallery';</script>";
    } else {
        echo "<script>alert('Error adding album: " . $stmt->error . "'); history.back();</script>";
    }

    $stmt->close();
    $conn->close();
}
// End adding album

// update album start
if (isset($_POST['update_libalbum'])) {
    $libalbum_id = $_POST['libalbum_id'];
    $libalbum_name = mysqli_real_escape_string($conn, $_POST['libalbum_name']);
    $libalbum_description = mysqli_real_escape_string($conn, $_POST['libalbum_description']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    $date_created = mysqli_real_escape_string($conn, $_POST['date_created']); 

    if (isset($_SESSION["user_id"])) {
        $user_id = $_SESSION["user_id"];
    } else {
        echo "<script>alert('Error: User not logged in.'); history.back();</script>";
        exit;
    }

    // Check if album_name already exists (excluding current album)
    $check_query = "SELECT COUNT(*) AS count FROM library_album WHERE libalbum_name = '$libalbum_name' AND libalbum_id != '$libalbum_id'";
    $check_result = mysqli_query($conn, $check_query);
    $check_row = mysqli_fetch_assoc($check_result);

    if ($check_row['count'] > 0) {
        echo "<script>alert('Album name already exists!'); history.back();</script>";
        exit;
    }

    // Update album if name is unique
    $query = "UPDATE library_album 
              SET libalbum_name = '$libalbum_name', libalbum_description = '$libalbum_description',
                  status = '$status',
                  date_created = '$date_created'
              WHERE libalbum_id = '$libalbum_id'";

    if (mysqli_query($conn, $query)) {
        $log_description = "Updated Library Album: " . $libalbum_name;
        $log_date = date("Y-m-d");  
        $log_time = date("H:i:s"); 

        $log_sql = "INSERT INTO history_log (description, log_date, log_time, user_id) VALUES (?, ?, ?, ?)";
        $stmt_log = $conn->prepare($log_sql);
        $stmt_log->bind_param("sssi", $log_description, $log_date, $log_time, $user_id);
        $stmt_log->execute();
        $stmt_log->close();

        echo "<script>
                alert('Album updated successfully!');
                window.location.href = '../library_gallery';
              </script>";
    } else {
        echo "<script>alert('Error Updating Album: " . mysqli_error($conn) . "');</script>";
    }

    mysqli_close($conn);
}

// update album end

// Delete start
if (isset($_GET['libalbum_id'])) {
    if (!isset($_SESSION['user_id'])) {
        $_SESSION['toastMsg'] = "Error: Session expired. Please log in again.";
        $_SESSION['toastType'] = "toast-error";
        header("Location: ../login.php");
        exit();
    }

    $libalbum_id = intval($_GET['libalbum_id']);
    $user_id = $_SESSION['user_id'];

    // Fetch album details
    $query = "SELECT * FROM library_album WHERE libalbum_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $libalbum_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        $libalbum_name = $row['libalbum_name'];

        // Delete images first
        $delete_images_query = "DELETE FROM library_image WHERE libalbum_id = ?";
        $delete_images_stmt = $conn->prepare($delete_images_query);
        $delete_images_stmt->bind_param("i", $libalbum_id);
        $delete_images_stmt->execute();

        // Delete album
        $delete_album_query = "DELETE FROM library_album WHERE libalbum_id = ?";
        $delete_stmt = $conn->prepare($delete_album_query);
        $delete_stmt->bind_param("i", $libalbum_id);

        if ($delete_stmt->execute()) {
            // Log deletion
            $log_description = "Deleted Library Album: $libalbum_name";
            $log_date = date("Y-m-d");
            $log_time = date("H:i:s");

            $log_query = "INSERT INTO history_log (description, log_date, log_time, user_id) VALUES (?, ?, ?, ?)";
            $log_stmt = $conn->prepare($log_query);
            $log_stmt->bind_param("sssi", $log_description, $log_date, $log_time, $user_id);
            $log_stmt->execute();
            $log_stmt->close();

            $_SESSION['toastMsg'] = "Library album deleted successfully.";
            $_SESSION['toastType'] = "toast-success";
        } else {
            $_SESSION['toastMsg'] = "Library album delete failed!";
            $_SESSION['toastType'] = "toast-error";
        }
    } else {
        $_SESSION['toastMsg'] = "Library album not found.";
        $_SESSION['toastType'] = "toast-error";
    }

    header("Location: ../library_gallery");
    exit();

    $stmt->close();
    $delete_images_stmt->close();
    $delete_stmt->close();
    $conn->close();
}
// Delete end

// ---------------add photo start------------------------------------

if (isset($_POST['add_libphoto'])) {
    $libalbum_id = $_POST['libalbum_id'];
    $upload_date = $_POST['date_created'];

    if (empty($libalbum_id)) {
        echo "<script>alert('Album ID is missing. Please try again.'); window.history.back();</script>";
        exit;
    }

    // Retrieve album_name
    $album_query = "SELECT libalbum_name FROM library_album WHERE libalbum_id = ?";
    $stmt_album = $conn->prepare($album_query);
    $stmt_album->bind_param("i", $libalbum_id);
    $stmt_album->execute();
    $result_album = $stmt_album->get_result();

    if ($result_album->num_rows > 0) {
        $album_row = $result_album->fetch_assoc();
        $libalbum_name = $album_row['libalbum_name'];
    } else {
        echo "<script>alert('Album not found.'); window.history.back();</script>";
        exit;
    }

    // Check if images are uploaded
    if (!empty($_FILES['images']['name'][0])) {
        $image_folder = "../assets/uploads/library_gallery/";

        if (!is_dir($image_folder)) {
            mkdir($image_folder, 0777, true);
        }

        foreach ($_FILES['images']['name'] as $key => $image_name) {
            $tmp_name = $_FILES['images']['tmp_name'][$key];
            $image_ext = pathinfo($image_name, PATHINFO_EXTENSION);
            $new_image_name = uniqid('img_', true) . '.' . $image_ext;

            $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
            if (!in_array(strtolower($image_ext), $allowed_types)) {
                echo "<script>alert('Invalid file type for $image_name. Only JPG, JPEG, PNG, and GIF are allowed.'); window.history.back();</script>";
                exit;
            }

            if (move_uploaded_file($tmp_name, $image_folder . $new_image_name)) {
                $stmt = $conn->prepare("INSERT INTO library_image (libimage_name, upload_date, libalbum_id) VALUES (?, ?, ?)");
                $stmt->bind_param("ssi", $new_image_name, $upload_date, $libalbum_id);

                if ($stmt->execute()) {
                    // Insert into history log
                    $description = "Uploaded new photo: '$new_image_name' to album: '$libalbum_name'";
                    $log_date = date("Y-m-d");
                    $log_time = date("H:i:s");

                    $log_query = "INSERT INTO history_log (description, log_date, log_time, user_id) 
                                  VALUES (?, ?, ?, ?)";

                    $stmt_log = $conn->prepare($log_query);
                    if ($stmt_log) {
                        $stmt_log->bind_param("sssi", $description, $log_date, $log_time, $_SESSION['user_id']);
                        $stmt_log->execute();
                        $stmt_log->close();
                    }

                    echo "<script>alert('Images uploaded successfully.'); window.location.href='../library_images?libalbum_id=$libalbum_id';</script>";
                } else {
                    echo "<script>alert('Failed to insert image $image_name.'); window.history.back();</script>";
                }
            } else {
                echo "<script>alert('Error uploading $image_name.'); window.history.back();</script>";
            }
        }
    } else {
        echo "<script>alert('Please select at least one image to upload.'); window.history.back();</script>";
    }
}

// ---------------add photo end--------------------------------------
// Delete Photo Start
if (isset($_GET['delete_image'])) {
    $libimage_id = intval($_GET['delete_image']);

    // Fetch image path and album details
    $stmt = $conn->prepare("SELECT libimage_name, libalbum_id FROM library_image WHERE libimage_id = ?");
    $stmt->bind_param("i", $libimage_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $image = $result->fetch_assoc();
        $image_path = "../assets/uploads/library_gallery/" . $image['libimage_name'];
        $libalbum_id = $image['libalbum_id'];

        // Fetch album name for logging
        $stmt_album = $conn->prepare("SELECT libalbum_name, library_id FROM library_album WHERE libalbum_id = ?");
        $stmt_album->bind_param("i", $libalbum_id);
        $stmt_album->execute();
        $result_album = $stmt_album->get_result();

        if ($result_album->num_rows > 0) {
            $album_row = $result_album->fetch_assoc();
            $libalbum_name = $album_row['libalbum_name'];
            $library_id = $album_row['library_id'];
        } else {
            echo "<script>alert('Album not found.'); window.history.back();</script>";
            exit;
        }

        // Archive data preparation
        $archive_description = json_encode([
            'libimage_name' => $image['libimage_name'],
            'libalbum_name' => $libalbum_name
        ]);
        $archived_at = date("Y-m-d H:i:s");

        // Fetch ap_id of the logged-in user
        $ap_stmt = $conn->prepare("SELECT ap_id FROM authorized_person WHERE user_id = ?");
        $ap_stmt->bind_param("i", $_SESSION['user_id']);
        $ap_stmt->execute();
        $ap_result = $ap_stmt->get_result();

        if ($ap_row = $ap_result->fetch_assoc()) {
            $archived_by = $ap_row['ap_id'];

            // Insert into library_archive
            $archive_stmt = $conn->prepare("INSERT INTO library_archive 
                (original_table, record_id, archive_description, archived_at, archived_by, library_id) 
                VALUES ('library_image', ?, ?, ?, ?, ?)");
            $archive_stmt->bind_param("issii", $libimage_id, $archive_description, $archived_at, $archived_by, $library_id);
            $archive_stmt->execute();

            // Delete the image from the database
            $stmt_delete = $conn->prepare("DELETE FROM library_image WHERE libimage_id = ?");
            $stmt_delete->bind_param("i", $libimage_id);

            if ($stmt_delete->execute()) {
                // Insert deletion log
                $description = "Deleted photo: '{$image['libimage_name']}' from album: '$libalbum_name'";
                $log_date = date("Y-m-d");
                $log_time = date("H:i:s");

                $stmt_log = $conn->prepare("INSERT INTO history_log (description, log_date, log_time, user_id) 
                                            VALUES (?, ?, ?, ?)");
                $stmt_log->bind_param("sssi", $description, $log_date, $log_time, $_SESSION['user_id']);
                $stmt_log->execute();

                echo "<script>alert('Image deleted successfully.'); window.history.back();</script>";
                exit;
            } else {
                echo "<script>alert('Failed to delete the image.'); window.history.back();</script>";
                exit;
            }
        } else {
            echo "<script>alert('Error: Authorized person not found.'); window.history.back();</script>";
            exit;
        }
    } else {
        echo "<script>alert('Image not found.'); window.history.back();</script>";
        exit;
    }

    // Close statements
    $stmt->close();
    $stmt_album->close();
    $ap_stmt->close();
    $archive_stmt->close();
    $stmt_delete->close();
}
// Delete Photo End
?>
