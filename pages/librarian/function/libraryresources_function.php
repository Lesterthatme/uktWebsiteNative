<?php
include '../../../connection/dbconnection.php';
session_start();

date_default_timezone_set('Asia/Phnom_Penh');

// Start adding library resources
if (isset($_POST['add_resource'])) {
    if (!isset($_SESSION['user_id'])) {
        $_SESSION['toastMsg'] = "Error: Session expired. Please log in again.";
        $_SESSION['toastType'] = "toast-error";
        header("Location: ../login.php");
        exit();
    }

    $user_id = $_SESSION['user_id'];

    if (!isset($_SESSION['ap_id'])) {
        $query = "SELECT ap_id FROM authorized_person WHERE user_id = '$user_id'";
        $result = mysqli_query($conn, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $_SESSION['ap_id'] = $row['ap_id'];
            $ap_id = $row['ap_id'];
        } else {
            $_SESSION['toastMsg'] = "Error: Authorized person not found.";
            $_SESSION['toastType'] = "toast-error";
            header("Location: ../University_Library_Resources.php");
            exit();
        }
    } else {
        $ap_id = $_SESSION['ap_id'];
    }

    $library_id = 1;
    $resource_type = mysqli_real_escape_string($conn, $_POST['resource_type']);
    $resource_title = mysqli_real_escape_string($conn, $_POST['resource_title']);
    $resource_author = mysqli_real_escape_string($conn, $_POST['resource_author']);
    $resource_ISBN = mysqli_real_escape_string($conn, $_POST['resource_ISBN']);
    $publication_year = mysqli_real_escape_string($conn, $_POST['publication_year']);
    $resource_status = mysqli_real_escape_string($conn, $_POST['resource_status']);
    $added_date = date("Y-m-d H:i:s");

    $query = "INSERT INTO library_resources (resource_title, resource_author, resource_ISBN, publication_year, resource_type, added_date, resource_status, library_id, ap_id) 
              VALUES ('$resource_title', '$resource_author', '$resource_ISBN', '$publication_year', '$resource_type', '$added_date', '$resource_status', '$library_id', '$ap_id')";

    if (mysqli_query($conn, $query)) {
        $log_description = "Added a new library resource: $resource_title";
        $log_date = date("Y-m-d");
        $log_time = date("H:i:s");

        $log_query = "INSERT INTO history_log (description, log_date, log_time, user_id) 
                      VALUES ('$log_description', '$log_date', '$log_time', '$user_id')";
        mysqli_query($conn, $log_query);

        $_SESSION['toastMsg'] = "Library resource added successfully.";
        $_SESSION['toastType'] = "toast-success";
        header("Location: ../University_Library_resources.php");
    } else {
        $_SESSION['toastMsg'] = "Error adding library resource.";
        $_SESSION['toastType'] = "toast-error";
        header("Location: ../University_Library_resources.php");
    }

    mysqli_close($conn);
    exit();
}
// End adding library resources

// Start >> Delete resources
if (isset($_GET['delete_id'])) {
    if (!isset($_SESSION['user_id'])) {
        $_SESSION['toastMsg'] = "Error: Session expired. Please log in again.";
        $_SESSION['toastType'] = "toast-error";
        header("Location: ../login.php");
        exit();
    }

    $resource_id = intval($_GET['delete_id']);
    $user_id = $_SESSION['user_id'];

    // Get resource details before deleting
    $query = "SELECT * FROM library_resources WHERE resource_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $resource_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        // Convert the resource data to JSON format for archiving
        $archive_description = json_encode($row, JSON_UNESCAPED_UNICODE);

        // Get the authorized person's ID based on user_id
        $auth_query = "SELECT ap_id FROM authorized_person WHERE user_id = ?";
        $auth_stmt = $conn->prepare($auth_query);
        $auth_stmt->bind_param("i", $user_id);
        $auth_stmt->execute();
        $auth_result = $auth_stmt->get_result();
        $auth_row = $auth_result->fetch_assoc();

        if (!$auth_row) {
            $_SESSION['toastMsg'] = "Error: Authorized person not found.";
            $_SESSION['toastType'] = "toast-error";
            header("Location: ../University_Library_resources?message=error");
            exit();
        }

        $ap_id = $auth_row['ap_id'];
        $library_id = $row['library_id'];

        // Insert into library_archive
        $archive_query = "INSERT INTO library_archive (original_table, record_id, archive_description, archived_at, archived_by, library_id)
                          VALUES ('library_resources', ?, ?, NOW(), ?, ?)";
        $archive_stmt = $conn->prepare($archive_query);
        $archive_stmt->bind_param("issi", $resource_id, $archive_description, $ap_id, $library_id);

        if ($archive_stmt->execute()) {
            // Delete the record from library_resources table
            $delete_query = "DELETE FROM library_resources WHERE resource_id = ?";
            $delete_stmt = $conn->prepare($delete_query);
            $delete_stmt->bind_param("i", $resource_id);

            if ($delete_stmt->execute()) {
                // Insert into history_log
                $log_description = "Deleted a library resource: " . $row['resource_title'];
                $log_date = date("Y-m-d");
                $log_time = date("H:i:s");

                $log_query = "INSERT INTO history_log (description, log_date, log_time, user_id) VALUES (?, ?, ?, ?)";
                $log_stmt = $conn->prepare($log_query);
                $log_stmt->bind_param("sssi", $log_description, $log_date, $log_time, $user_id);
                $log_stmt->execute();
                $log_stmt->close();

                $_SESSION['toastMsg'] = "Resource deleted successfully.";
                $_SESSION['toastType'] = "toast-success";
                header("Location: ../University_Library_resources");
                exit();
            } else {
                $_SESSION['toastMsg'] = "Resource delete error.";
                $_SESSION['toastType'] = "toast-error";
                header("Location: ../University_Library_resources");
                exit();
            }
        } else {
            $_SESSION['toastMsg'] = "Resource archive error.";
            $_SESSION['toastType'] = "toast-error";
            header("Location: ../University_Library_resources");
            exit();
        }
    } else {
        $_SESSION['toastMsg'] = "Resource not found.";
        $_SESSION['toastType'] = "toast-error";
        header("Location: ../University_Library_resources");
        exit();
    }
}




// Start >> Updating resource
if (isset($_POST['update_resource'])) {
    if (!isset($_SESSION['user_id'])) {
        $_SESSION['toastMsg'] = "Error: Session expired. Please log in again.";
        $_SESSION['toastType'] = "toast-error";
        header("Location: ../login.php");
        exit();
    }

    $resource_id = $_POST['resource_id'];
    $resource_type = $_POST['resource_type'];
    $resource_title = $_POST['resource_title'];
    $resource_author = $_POST['resource_author'];
    $publication_year = $_POST['publication_year'];
    $resource_isbn = $_POST['resource_ISBN'];
    $resource_status = $_POST['resource_status'];
    $user_id = $_SESSION['user_id']; // Get the logged-in user ID

    // Get the previous resource details before updating
    $query = "SELECT resource_title FROM library_resources WHERE resource_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $resource_id);
    $stmt->execute();
    $stmt->bind_result($old_resource_title);
    $stmt->fetch();
    $stmt->close();

    $sql = "UPDATE library_resources SET 
            resource_type = ?, 
            resource_title = ?, 
            resource_author = ?, 
            publication_year = ?, 
            resource_ISBN = ?, 
            resource_status = ? 
            WHERE resource_id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssi", $resource_type, $resource_title, $resource_author, $publication_year, $resource_isbn, $resource_status, $resource_id);

    if ($stmt->execute()) {
        // Insert into history_log
        $log_description = "Updated library resource: $old_resource_title to $resource_title";
        $log_date = date("Y-m-d");
        $log_time = date("H:i:s");

        $log_query = "INSERT INTO history_log (description, log_date, log_time, user_id) VALUES (?, ?, ?, ?)";
        $log_stmt = $conn->prepare($log_query);
        $log_stmt->bind_param("sssi", $log_description, $log_date, $log_time, $user_id);
        $log_stmt->execute();
        $log_stmt->close();

        $_SESSION['toastMsg'] = "Resource updated successfully.";
        $_SESSION['toastType'] = "toast-success";
        header("Location: ../University_Library_resources");
    } else {
        $_SESSION['toastMsg'] = "Error updating resource.";
        $_SESSION['toastType'] = "toast-error";
        header("Location: ../University_Library_resources");
    }
    $stmt->close();
}
$conn->close();
// End >> Updating resource


?>
