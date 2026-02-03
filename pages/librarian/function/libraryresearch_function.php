<?php
include '../../../connection/dbconnection.php';
session_start();

date_default_timezone_set('Asia/Phnom_Penh');
if (isset($_POST['add_research'])) {
    session_start();
    include 'path/to/your/database/connection.php'; // Adjust the path to your database connection file

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
            header("Location: ../University_Library_Research_Projects.php");
            exit();
        }
    } else {
        $ap_id = $_SESSION['ap_id'];
    }

    $library_id = 1;
    $research_title = $_POST['research_title'];
    $researchers = $_POST['researchers'];
    $research_adviser = $_POST['research_adviser'];
    $publication_year = $_POST['date_published'];
    $research_type = $_POST['research_type'];

    $query = "INSERT INTO research_project (research_title, researcher_name, research_adviser, publication_year, research_type, ap_id, library_id) 
              VALUES ('$research_title', '$researchers', '$research_adviser', '$publication_year', '$research_type', '$ap_id', '$library_id')";

    if (mysqli_query($conn, $query)) {
        $log_description = "Added a new research project: $research_title";
        $log_date = date("Y-m-d");
        $log_time = date("H:i:s");
        
        $log_query = "INSERT INTO history_log (description, log_date, log_time, user_id) 
                      VALUES ('$log_description', '$log_date', '$log_time', '$user_id')";
        mysqli_query($conn, $log_query);

        $_SESSION['toastMsg'] = "Research project added successfully.";
        $_SESSION['toastType'] = "toast-success";
    } else {
        $_SESSION['toastMsg'] = "Error adding research project.";
        $_SESSION['toastType'] = "toast-error";
    }

    mysqli_close($conn);
    header("Location: ../University_Library_Research_Projects.php");
    exit();
}

// Delete start
if (isset($_GET['delete_id'])) {
    if (!isset($_SESSION['user_id'])) {
        $_SESSION['toastMsg'] = "Error: Session expired. Please log in again.";
        $_SESSION['toastType'] = "toast-error";
        header("Location: ../login.php");
        exit();
    }

    $research_id = intval($_GET['delete_id']);
    $user_id = $_SESSION['user_id']; 

    // Fetch research project details
    $query = "SELECT * FROM research_project WHERE research_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $research_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        $research_title = $row['research_title'];
        $researcher_name = $row['researcher_name'];
        $research_adviser = $row['research_adviser'];
        $publication_year = $row['publication_year'];
        $research_type = $row['research_type'];
        $ap_id = $row['ap_id'];
        $library_id = $row['library_id'];

        // Fetch `ap_id` of the logged-in user
        $ap_query = "SELECT ap_id FROM authorized_person WHERE user_id = ?";
        $ap_stmt = $conn->prepare($ap_query);
        $ap_stmt->bind_param("i", $user_id);
        $ap_stmt->execute();
        $ap_result = $ap_stmt->get_result();
        
        if ($ap_row = $ap_result->fetch_assoc()) {
            $archived_by = $ap_row['ap_id'];

            // Convert research data into JSON
            $archive_description = json_encode([
                "research_title" => $research_title,
                "researcher_name" => $researcher_name,
                "research_adviser" => $research_adviser,
                "publication_year" => $publication_year,
                "research_type" => $research_type
            ]);

            $archived_at = date("Y-m-d H:i:s");

            // Insert into `library_archive`
            $insert_archive = "INSERT INTO library_archive 
                (original_table, record_id, archive_description, archived_at, archived_by, library_id) 
                VALUES ('research_project', ?, ?, ?, ?, ?)";
            
            $archive_stmt = $conn->prepare($insert_archive);
            $archive_stmt->bind_param("issii", $research_id, $archive_description, $archived_at, $archived_by, $library_id);

            if ($archive_stmt->execute()) {
                // Now delete the research project
                $delete_query = "DELETE FROM research_project WHERE research_id = ?";
                $delete_stmt = $conn->prepare($delete_query);
                $delete_stmt->bind_param("i", $research_id);

                if ($delete_stmt->execute()) {
                    // Log the deletion
                    $log_description = "Deleted a research project: $research_title";
                    $log_date = date("Y-m-d");
                    $log_time = date("H:i:s");

                    $log_query = "INSERT INTO history_log (description, log_date, log_time, user_id) VALUES (?, ?, ?, ?)";
                    $log_stmt = $conn->prepare($log_query);
                    $log_stmt->bind_param("sssi", $log_description, $log_date, $log_time, $user_id);
                    $log_stmt->execute();
                    $log_stmt->close();

                    $_SESSION['toastMsg'] = "Research project archived and deleted successfully.";
                    $_SESSION['toastType'] = "toast-success";
                    header("Location: ../University_Library_Research_Projects");
                    exit();
                } else {
                    $_SESSION['toastMsg'] = "Research project delete failed!";
                    $_SESSION['toastType'] = "toast-error";
                    header("Location: ../University_Library_Research_Projects");
                    exit();
                }
            } else {
                $_SESSION['toastMsg'] = "Archiving failed. Research project was not deleted.";
                $_SESSION['toastType'] = "toast-error";
                header("Location: ../University_Library_Research_Projects");
                exit();
            }
        } else {
            $_SESSION['toastMsg'] = "Error: Authorized person not found.";
            $_SESSION['toastType'] = "toast-error";
            header("Location: ../University_Library_Research_Projects");
            exit();
        }
    } else {
        header("Location: ../University_Library_Research_Projects?message=not_found");
        exit();
    }

    $stmt->close();
    $ap_stmt->close();
    $archive_stmt->close();
    $delete_stmt->close();
    $conn->close();
}

// delete end

// Start >> Update research
if (isset($_POST['update_research'])) {
    if (!isset($_SESSION['user_id'])) {
        $_SESSION['toastMsg'] = "Error: Session expired. Please log in again.";
        $_SESSION['toastType'] = "toast-error";
        header("Location: ../login.php");
        exit();
    }

    $research_id = intval($_POST['research_id']);
    $title = $_POST['research_title'];
    $researchers = $_POST['researcher_name'];
    $adviser = $_POST['research_adviser'];
    $year = $_POST['publication_year'];
    $type = $_POST['research_type'];
    $user_id = $_SESSION['user_id'];

    $query = "UPDATE research_project SET 
                research_title = ?, 
                researcher_name = ?, 
                research_adviser = ?, 
                publication_year = ?, 
                research_type = ? 
              WHERE research_id = ?";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssssi", $title, $researchers, $adviser, $year, $type, $research_id);

    if ($stmt->execute()) {
        $log_description = "Updated research project: $title";
        $log_date = date("Y-m-d");
        $log_time = date("H:i:s");

        $log_query = "INSERT INTO history_log (description, log_date, log_time, user_id) VALUES (?, ?, ?, ?)";
        $log_stmt = $conn->prepare($log_query);
        $log_stmt->bind_param("sssi", $log_description, $log_date, $log_time, $user_id);
        $log_stmt->execute();
        $log_stmt->close();

        $_SESSION['toastMsg'] = "Research project updated successfully.";
        $_SESSION['toastType'] = "toast-success";
        header("Location: ../University_Library_Research_Projects");
        exit();
    } else {
        $_SESSION['toastMsg'] = "Research project update failed.";
        $_SESSION['toastType'] = "toast-error";
        header("Location: ../University_Library_Research_Projects");
        exit();
    }

    $stmt->close();
    $conn->close();
}
// End >> Update research

?>
