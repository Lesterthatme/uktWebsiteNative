<?php
include("../connection/dbconnection.php"); 
session_start();

date_default_timezone_set("Asia/Phnom_Penh");

// Start adding album 
if (isset($_POST["add_album"])) { 
    $album_name = $_POST["album_name"];
    $album_description = $_POST["album_description"];
     $status = 'Active';
    $up_id = 1; 
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
    $check_query = "SELECT * FROM university_album WHERE album_name = ?";
    $stmt_check = $conn->prepare($check_query);
    $stmt_check->bind_param("s", $album_name);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();

    if ($result_check->num_rows > 0) {
        echo "<script>alert('Album name already exists!'); history.back();</script>";
        exit; // Stop further execution if album name exists
    }

    // Insert into university_album table
    $sql = "INSERT INTO university_album (album_name, album_description, date_created, status, ap_id, up_id) 
            VALUES (?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssii", $album_name, $album_description, $date_created, $status, $ap_id, $up_id);

    if ($stmt->execute()) {
        $album_id = $stmt->insert_id;

        // Handle image uploads
        if (!empty($_FILES['images']['name'][0])) {
            $uploadDir = "../assets/uploads/university_gallery/";

            foreach ($_FILES['images']['tmp_name'] as $key => $tmp_name) {
                $imageName = basename($_FILES['images']['name'][$key]);
                $targetFilePath = $uploadDir . $imageName;

                if (move_uploaded_file($tmp_name, $targetFilePath)) {
                    $insertImage = "INSERT INTO university_image (image_name, upload_date, album_id)
                                    VALUES (?, ?, ?)";
                    $stmtImage = $conn->prepare($insertImage);
                    $upload_date = date('Y-m-d');

                    if ($stmtImage) {
                        $stmtImage->bind_param("ssi", $imageName, $upload_date, $album_id);
                        $stmtImage->execute();
                        $stmtImage->close();
                    } else {
                        echo "<script>alert('Error inserting image: " . $conn->error . "'); history.back();</script>";
                    }
                }
            }
        }

        // Insert into history log
        $description = "Added new album: '$album_name' ";
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

        echo "<script>alert('Album and images added successfully!'); window.location.href='../pages/adminukt/university_album';</script>";
    } else {
        echo "<script>alert('Error adding album: " . $stmt->error . "'); history.back();</script>";
    }

    $stmt->close();
    $conn->close();
}
// End adding album

// update album start
if (isset($_POST['update_album'])) {
    $album_id = $_POST['album_id'];
    $album_name = mysqli_real_escape_string($conn, $_POST['album_name']);
    $album_description = mysqli_real_escape_string($conn, $_POST['album_description']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    $date_created = mysqli_real_escape_string($conn, $_POST['date_created']); 

    if (isset($_SESSION["user_id"])) {
        $user_id = $_SESSION["user_id"];
    } else {
        echo "<script>alert('Error: User not logged in.'); history.back();</script>";
        exit;
    }

    // Check if album_name already exists (excluding current album)
    $check_query = "SELECT COUNT(*) AS count FROM university_album WHERE album_name = '$album_name' AND album_id != '$album_id'";
    $check_result = mysqli_query($conn, $check_query);
    $check_row = mysqli_fetch_assoc($check_result);

    if ($check_row['count'] > 0) {
        echo "<script>alert('Album name already exists!'); history.back();</script>";
        exit;
    }

    // Update album if name is unique
    $query = "UPDATE university_album 
              SET album_name = '$album_name', album_description = '$album_description',
                  status = '$status',
                  date_created = '$date_created'
              WHERE album_id = '$album_id'";

    if (mysqli_query($conn, $query)) {
        $log_description = "Updated Album: " . $album_name;
        $log_date = date("Y-m-d");  
        $log_time = date("H:i:s"); 

        $log_sql = "INSERT INTO history_log (description, log_date, log_time, user_id) VALUES (?, ?, ?, ?)";
        $stmt_log = $conn->prepare($log_sql);
        $stmt_log->bind_param("sssi", $log_description, $log_date, $log_time, $user_id);
        $stmt_log->execute();
        $stmt_log->close();

        echo "<script>
                alert('Album updated successfully!');
                window.location.href = '../pages/adminukt/university_album';
              </script>";
    } else {
        echo "<script>alert('Error Updating Album: " . mysqli_error($conn) . "');</script>";
    }

    mysqli_close($conn);
}
// update album end

// Delete album start
if (isset($_GET['album_id'])) {
    $album_id = intval($_GET['album_id']);

    if (isset($_SESSION["user_id"])) {
        $user_id = $_SESSION["user_id"];
    } else {
        echo "<script>alert('Error: User not logged in.'); history.back();</script>";
        exit;
    }

    // Fetch album and image details for archiving and deletion
    $album_query = "SELECT * FROM university_album WHERE album_id = ?";
    $stmt_album = $conn->prepare($album_query);
    $stmt_album->bind_param("i", $album_id);
    $stmt_album->execute();
    $result_album = $stmt_album->get_result();

    if ($result_album->num_rows > 0) {
        $album_row = $result_album->fetch_assoc();
        $album_name = $album_row['album_name'];
        $album_description = $album_row['album_description'];
        $date_created = $album_row['date_created'];
        $status = $album_row['status'];
        $ap_id = $album_row['ap_id'];
        // Set up_id to 1
        $up_id = 1;
    } else {
        echo "<script>alert('Error: Album not found.'); history.back();</script>";
        exit;
    }

    // Archive the album into university_album_archive
    $archive_album_query = "INSERT INTO university_album_archive (album_id, album_name, album_description, date_created, status, ap_id, up_id, date_archived)
                            VALUES (?, ?, ?, ?, ?, ?, ?, CURDATE())";
    $stmt_archive_album = $conn->prepare($archive_album_query);
    $stmt_archive_album->bind_param("issssii", $album_id, $album_name, $album_description, $date_created, $status, $ap_id, $up_id);
    $stmt_archive_album->execute();

    // Fetch the images associated with the album
    $image_query = "SELECT * FROM university_image WHERE album_id = ?";
    $stmt_images = $conn->prepare($image_query);
    $stmt_images->bind_param("i", $album_id);
    $stmt_images->execute();
    $result_images = $stmt_images->get_result();

    // Archive images if any
    while ($image_row = $result_images->fetch_assoc()) {
        $image_id = $image_row['image_id'];
        $image_name = $image_row['image_name'];
        $upload_date = $image_row['upload_date'];

        // Archive image into university_image_archive
        $archive_image_query = "INSERT INTO university_image_archive (image_id, image_name, upload_date, album_id, ap_id, up_id, date_archived)
                                VALUES (?, ?, ?, ?, ?, ?, CURDATE())";
        $stmt_archive_image = $conn->prepare($archive_image_query);
        $stmt_archive_image->bind_param("issiii", $image_id, $image_name, $upload_date, $album_id, $ap_id, $up_id);
        $stmt_archive_image->execute();
        $stmt_archive_image->close();
    }

    // Now, delete images from the university_image table
    $delete_images_query = "DELETE FROM university_image WHERE album_id = ?";
    $stmt_delete_images = $conn->prepare($delete_images_query);
    $stmt_delete_images->bind_param("i", $album_id);
    $stmt_delete_images->execute();
    
    // Delete the album from the university_album table
    $delete_album_query = "DELETE FROM university_album WHERE album_id = ?";
    $stmt_delete_album = $conn->prepare($delete_album_query);
    $stmt_delete_album->bind_param("i", $album_id);

    if ($stmt_delete_album->execute()) {
        // Insert into history log
        $description = "Deleted album: '$album_name'";
        $log_date = date("Y-m-d");
        $log_time = date("H:i:s");

        $log_query = "INSERT INTO history_log (description, log_date, log_time, user_id) 
                      VALUES (?, ?, ?, ?)";
        $stmt_log = $conn->prepare($log_query);
        $stmt_log->bind_param("sssi", $description, $log_date, $log_time, $user_id);
        $stmt_log->execute();
        $stmt_log->close();

        echo "<script>
                alert('Album and its images archived and deleted successfully!');
                window.location.href='../pages/adminukt/university_album';
              </script>";
    } else {
        echo "<script>alert('Error deleting album: " . $stmt_delete_album->error . "');</script>";
    }

    // Close prepared statements
    $stmt_images->close();
    $stmt_album->close();
    $stmt_delete_images->close();
    $stmt_delete_album->close();
    $conn->close();
}
// delete album end

// ---------------add photo start------------------------------------

if (isset($_POST['add_photo'])) {
    $album_id = $_POST['album_id'];
    $upload_date = $_POST['date_created'];

    if (empty($album_id)) {
        echo "<script>alert('Album ID is missing. Please try again.'); window.history.back();</script>";
        exit;
    }

    // Retrieve album_name
    $album_query = "SELECT album_name FROM university_album WHERE album_id = ?";
    $stmt_album = $conn->prepare($album_query);
    $stmt_album->bind_param("i", $album_id);
    $stmt_album->execute();
    $result_album = $stmt_album->get_result();

    if ($result_album->num_rows > 0) {
        $album_row = $result_album->fetch_assoc();
        $album_name = $album_row['album_name'];
    } else {
        echo "<script>alert('Album not found.'); window.history.back();</script>";
        exit;
    }

    // Check if images are uploaded
    if (!empty($_FILES['images']['name'][0])) {
        $image_folder = "../assets/uploads/university_gallery/";

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
                $stmt = $conn->prepare("INSERT INTO university_image (image_name, upload_date, album_id) VALUES (?, ?, ?)");
                $stmt->bind_param("ssi", $new_image_name, $upload_date, $album_id);

                if ($stmt->execute()) {
                    // Insert into history log
                    $description = "Uploaded new photo: '$new_image_name' to album: '$album_name'";
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

                    echo "<script>alert('Images uploaded successfully.'); window.location.href='../pages/adminukt/view_album?album_id=$album_id';</script>";
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
    $image_id = intval($_GET['delete_image']);
    $query = "SELECT image_name, album_id, upload_date FROM university_image WHERE image_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $image_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $image = $result->fetch_assoc();
        $image_name = $image['image_name'];
        $image_path = "../../assets/uploads/university_gallery/" . $image_name;
        $album_id = $image['album_id'];
        $upload_date = $image['upload_date'];
        $album_query = "SELECT album_name FROM university_album WHERE album_id = ?";
        $stmt_album = $conn->prepare($album_query);
        $stmt_album->bind_param("i", $album_id);
        $stmt_album->execute();
        $result_album = $stmt_album->get_result();

        if ($result_album->num_rows > 0) {
            $album_row = $result_album->fetch_assoc();
            $album_name = $album_row['album_name'];
        } else {
            echo "<script>alert('Album not found.'); window.history.back();</script>";
            exit;
        }

        $user_id = $_SESSION['user_id']; 
        $fetch_ap_id_query = "SELECT ap_id FROM authorized_person WHERE user_id = ?";
        $stmt_ap_id = $conn->prepare($fetch_ap_id_query);
        $stmt_ap_id->bind_param("i", $user_id);
        $stmt_ap_id->execute();
        $result_ap_id = $stmt_ap_id->get_result();

        if ($result_ap_id->num_rows > 0) {
            $ap_row = $result_ap_id->fetch_assoc();
            $ap_id = $ap_row['ap_id'];
        } else {
            echo "<script>alert('Authorized person not found.'); window.history.back();</script>";
            exit;
        }
        $up_id = 1;  

        $insert_archive_query = "INSERT INTO university_image_archive (image_id, image_name, upload_date, album_id, date_archived, ap_id, up_id) 
                                VALUES (?, ?, ?, ?, CURRENT_TIMESTAMP, ?, ?)";
        $stmt_insert_archive = $conn->prepare($insert_archive_query);

        $stmt_insert_archive->bind_param("isssii", $image_id, $image_name, $upload_date, $album_id, $ap_id, $up_id);

        if ($stmt_insert_archive->execute()) {
            $delete_query = "DELETE FROM university_image WHERE image_id = ?";
            $stmt_delete = $conn->prepare($delete_query);
            $stmt_delete->bind_param("i", $image_id);

            if ($stmt_delete->execute()) {
                if (file_exists($image_path)) {
                    unlink($image_path);
                }

                $description = "Deleted photo: '{$image_name}' from album: '$album_name'";
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

                echo "<script>alert('Image deleted and archived successfully.'); window.history.back();</script>";
            } else {
                echo "<script>alert('Failed to delete the image.'); window.history.back();</script>";
            }
        } else {
            echo "<script>alert('Failed to archive the image.'); window.history.back();</script>";
        }
    } else {
        echo "<script>alert('Image not found.'); window.history.back();</script>";
    }
}
// Delete Photo End End
?>
