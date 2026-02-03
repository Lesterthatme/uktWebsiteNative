<?php
session_start();
include '../../../connection/dbconnection.php';

// Restore function for library archive updates start
if (isset($_GET['restoreupdate_id'])) {
    $restoreupdate_id = intval($_GET['restoreupdate_id']); 

    $query = "SELECT original_table, archive_description FROM library_archive WHERE record_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $restoreupdate_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $archive = $result->fetch_assoc();

    if ($archive) {
        $original_table = $archive['original_table'];
        $archive_description = json_decode($archive['archive_description'], true) ?? []; // Ensure array

        $columns = implode(", ", array_keys($archive_description));
        
        // Handle array values and escape strings properly
        $values = implode("', '", array_map(function($value) use ($conn) {
            return is_array($value) ? json_encode($value) : $conn->real_escape_string($value);
        }, array_values($archive_description)));

        $restoreQuery = "INSERT INTO `$original_table` ($columns) VALUES ('$values')";

        if ($conn->query($restoreQuery)) {
            $deleteQuery = "DELETE FROM library_archive WHERE record_id = ?";
            $stmt = $conn->prepare($deleteQuery);
            $stmt->bind_param("i", $restoreupdate_id);
            $stmt->execute();

            $_SESSION['toastMsg'] = "Record restored successfully!";
            $_SESSION['toastType'] = "toast-success";
            header("Location: ../library_updatesarchive");
            exit();
        } else {
            $_SESSION['toastMsg'] = "Failed to restore record: " . $conn->error;
            $_SESSION['toastType'] = "toast-error";
            header("Location: ../library_updatesarchive");
            exit();
        }
    } else {
        $_SESSION['toastMsg'] = "Record not found in archive.";
        $_SESSION['toastType'] = "toast-error";
        header("Location: ../library_updatesarchive");
        exit();
    }
}
// Restore function for library archive updates end


// Restore function for library archive resources start
if (isset($_GET['restoreresources_id'])) {
    $restoreresources_id = intval($_GET['restoreresources_id']); 

    $query = "SELECT original_table, archive_description FROM library_archive WHERE record_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $restoreresources_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $archive = $result->fetch_assoc();

    if ($archive) {
        $original_table = $archive['original_table'];
        $archive_description = json_decode($archive['archive_description'], true); 

        $columns = implode(", ", array_keys($archive_description));
        $values = implode("', '", array_map([$conn, 'real_escape_string'], array_values($archive_description)));

        $restoreQuery = "INSERT INTO `$original_table` ($columns) VALUES ('$values')";
        
        if ($conn->query($restoreQuery)) {
            $deleteQuery = "DELETE FROM library_archive WHERE record_id = ?";
            $stmt = $conn->prepare($deleteQuery);
            $stmt->bind_param("i", $restoreresources_id);
            $stmt->execute();

            $_SESSION['toastMsg'] = "Record restored successfully!";
            $_SESSION['toastType'] = "toast-success";
            header("Location: ../University_Library_resources");
            exit();
        } else {
            $_SESSION['toastMsg'] = "Failed to restore record: " . $conn->error;
            $_SESSION['toastType'] = "toast-error";
            header("Location: ../University_Library_resources");
            exit();
        }
    } else {
        $_SESSION['toastMsg'] = "Record not found in archive.";
        $_SESSION['toastType'] = "toast-error";
        header("Location: ../University_Library_resources");
        exit();
    }
}
// Restore function for library archive resources end


// Restore function for library research archive start
if (isset($_GET['restoreresearch_id'])) {
    $restoreresearch_id = intval($_GET['restoreresearch_id']); 

    $query = "SELECT original_table, archive_description FROM library_archive WHERE record_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $restoreresearch_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $archive = $result->fetch_assoc();

    if ($archive) {
        $original_table = $archive['original_table'];
        $archive_description = json_decode($archive['archive_description'], true); 

        $columns = implode(", ", array_keys($archive_description));
        $values = implode("', '", array_map([$conn, 'real_escape_string'], array_values($archive_description)));

        $restoreQuery = "INSERT INTO `$original_table` ($columns) VALUES ('$values')";
        
        if ($conn->query($restoreQuery)) {
            $deleteQuery = "DELETE FROM library_archive WHERE record_id = ?";
            $stmt = $conn->prepare($deleteQuery);
            $stmt->bind_param("i",  $restoreresearch_id);
            $stmt->execute();

            $_SESSION['toastMsg'] = "Record restored successfully!";
            $_SESSION['toastType'] = "toast-success";
            header("Location: ../University_Library_Research_Projects");
            exit();
        } else {
            $_SESSION['toastMsg'] = "Failed to restore record: " . $conn->error;
            $_SESSION['toastType'] = "toast-error";
            header("Location: ../University_Library_Research_Projects");
            exit();
        }
    } else {
        $_SESSION['toastMsg'] = "Record not found in archive.";
        $_SESSION['toastType'] = "toast-error";
        header("Location: ../University_Library_Research_Projects");
        exit();
    }
}
// Restore function for library research archive end

if (isset($_GET['restoreimage_id'])) {
    $restoreimage_id = intval($_GET['restoreimage_id']);

    $query = "SELECT JSON_UNQUOTE(JSON_EXTRACT(archive_description, '$.libimage_name')) AS libimage_name,
                     JSON_UNQUOTE(JSON_EXTRACT(archive_description, '$.libalbum_name')) AS libalbum_name
              FROM library_archive
              WHERE record_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $restoreimage_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $libimage_name = $row['libimage_name'];
        $libalbum_name = $row['libalbum_name'];

        // Step 2: Get the original libalbum_id from library_album
        $albumQuery = "SELECT libalbum_id FROM library_album WHERE libalbum_name = ?";
        $albumStmt = $conn->prepare($albumQuery);
        $albumStmt->bind_param("s", $libalbum_name);
        $albumStmt->execute();
        $albumResult = $albumStmt->get_result();

        if ($albumResult->num_rows > 0) {
            $albumRow = $albumResult->fetch_assoc();
            $libalbum_id = $albumRow['libalbum_id'];

            // Step 3: Restore the data to library_image
            $restoreQuery = "INSERT INTO library_image (libimage_name, upload_date, libalbum_id)
                             VALUES (?, NOW(), ?)";
            $restoreStmt = $conn->prepare($restoreQuery);
            $restoreStmt->bind_param("si", $libimage_name, $libalbum_id);

            if ($restoreStmt->execute()) {
                // Step 4: Delete the restored record from library_archive
                $deleteQuery = "DELETE FROM library_archive WHERE record_id = ?";
                $deleteStmt = $conn->prepare($deleteQuery);
                $deleteStmt->bind_param("i", $restoreimage_id);
                $deleteStmt->execute();

                echo "<script>
                        alert('Image restored successfully!');
                        window.location.href = '../library_picturesarchive';
                      </script>";
            } else {
                echo "<div class='alert alert-danger'>Failed to restore image.</div>";
            }
        } else {
            // Original album not found — DELETE the image from the archive
            $deleteImageQuery = "DELETE FROM library_archive WHERE record_id = ?";
            $deleteImageStmt = $conn->prepare($deleteImageQuery);
            $deleteImageStmt->bind_param("i", $restoreimage_id);
            $deleteImageStmt->execute();

            echo "<script>
                        alert('Original album not found. Image deleted from archive!');
                        window.location.href = '../library_picturesarchive';
                      </script>";

        }
    } else {
        echo "<div class='alert alert-warning'>Archived data not found.</div>";
    }
} else {
    echo "<div class='alert alert-danger'>Invalid request.</div>";
}

$conn->close();


?>

