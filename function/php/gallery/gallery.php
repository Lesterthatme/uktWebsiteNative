<?php
include("../../../connection/dbconnection.php");
session_start();

if (isset($_GET['remove']) && $_GET['remove'] == "ooNamanYes") {

    $allowed_locations = ['adminukt', 'content_manager'];
    $location = $_GET['loc'] ?? '';

    // $_SESSION['toastMsg'] = "You are not authorize person to do this action.";
    // $_SESSION['toastType'] = "toast-error";
    // redirectToLocation($location, $id);
    function redirectToLocation($location)
    {
        if (in_array($location, ['adminukt', 'content_manager'])) {
            header("Location: ../../../pages/$location/university_video");
            exit;
        } else {
            echo "Invalid location.";
            exit;
        }
    }


    $conn->begin_transaction();
    try {
        $pinned = "0";
        $stmt = $conn->prepare("UPDATE university_video SET is_pinned = ?");
        $stmt->bind_param('s', $pinned);
        if (!$stmt->execute()) {
            $conn->rollback();
            $_SESSION['toastMsg'] = "Error: Changes not works.";
            $_SESSION['toastType'] = "toast-error";
            redirectToLocation($location);
        }

        $conn->commit();
        $_SESSION['toastMsg'] = "Success: Removed the highlighted video.";
        $_SESSION['toastType'] = "toast-success";
    } catch (Exception $e) {
        $conn->rollback();
        $_SESSION['toastMsg'] = "Error: Something Went Wrong.";
        $_SESSION['toastType'] = "toast-error";
        redirectToLocation($location);
    }

    redirectToLocation($location);
}

if (isset($_GET['add']) && $_GET['add'] == "ooNamanYes") {
    $allowed_locations = ['adminukt', 'content_manager'];
    $location = $_GET['loc'] ?? '';

    // $_SESSION['toastMsg'] = "You are not authorize person to do this action.";
    // $_SESSION['toastType'] = "toast-error";
    // redirectToLocation($location, $id);
    function redirectToLocation($location)
    {
        if (in_array($location, ['adminukt', 'content_manager'])) {
            header("Location: ../../../pages/$location/university_video");
            // echo "pumasok";
            exit;
        } else {
            echo "Invalid location.";
            exit;
        }
    }

    $conn->begin_transaction();
    try {
        $id = $_GET['id'] ?? '';
        if (!$id) {
            $_SESSION['toastMsg'] = "No ID sent.";
            $_SESSION['toastType'] = "toast-error";
            redirectToLocation($location);
        }

        $pinned = "0";
        $pinned2 = "1";
        $stmt = $conn->prepare("UPDATE university_video SET is_pinned = ?");
        $stmt->bind_param('s', $pinned);
        if (!$stmt->execute()) {
            $conn->rollback();
            $_SESSION['toastMsg'] = "Error: Changes could not be applied.";
            $_SESSION['toastType'] = "toast-error";
            redirectToLocation($location);
        }

        //checks only the Get type ID
        $stmt2 = $conn->prepare("SELECT * FROM university_video WHERE video_id = ?");
        $stmt2->bind_param('s', $id);
        if (!$stmt2->execute()) {
            $conn->rollback();
            $_SESSION['toastMsg'] = "No video was found in the system.";
            $_SESSION['toastType'] = "toast-error";
            redirectToLocation($location);
        }
        $result = $stmt2->get_result();
        if ($result->num_rows > 0) {
            $video = $result->fetch_assoc();
            $videoId = $video['video_id'];
        } else {
            $conn->rollback();
            $_SESSION['toastMsg'] = "No video was found in the system section 2.";
            $_SESSION['toastType'] = "toast-error";
            redirectToLocation($location);
        }


        $stmt3 = $conn->prepare("UPDATE university_video SET is_pinned = ? WHERE video_id = ? ");
        $stmt3->bind_param('ss', $pinned2, $videoId);
        if (!$stmt3->execute()) {
            $conn->rollback();
            $_SESSION['toastMsg'] = "Error: Could not set the new highlighted video.";
            $_SESSION['toastType'] = "toast-error";
            redirectToLocation($location);
        }

        $conn->commit();
        $_SESSION['toastMsg'] = "Success: New highlighted Video.";
        $_SESSION['toastType'] = "toast-success";
        redirectToLocation($location);
    } catch (Exception $e) {
        $conn->rollback();
        $_SESSION['toastMsg'] = "Error: Something Went Wrong.";
        $_SESSION['toastType'] = "toast-error";
        redirectToLocation($location);
    }

    redirectToLocation($location);
}
