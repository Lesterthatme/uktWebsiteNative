<?php
include '../../connection/dbconnection.php';
session_start();
date_default_timezone_set('Asia/Phnom_Penh');

if (isset($_POST['university_background'])) {
    $university_background = mysqli_real_escape_string($conn, $_POST['university_background']);
    $user_id = $_SESSION['user_id'];

    // Update university background
    $query = "UPDATE university_profile SET university_background = '$university_background' WHERE up_id = 1";

    if (mysqli_query($conn, $query)) {
        // Insert history log for background update
        $description = "University Background Updated.";
        $log_date = date('Y-m-d');
        $log_time = date('H:i:s');
        $log_query = "INSERT INTO history_log (description, log_date, log_time, user_id) 
                      VALUES ('$description', '$log_date', '$log_time', '$user_id')";
        mysqli_query($conn, $log_query);

        if (isset($_FILES['images']) && count($_FILES['images']['name']) > 0) {
            // Get ap_id of the logged-in user
            $ap_result = mysqli_query($conn, "SELECT ap_id FROM authorized_person WHERE user_id = $user_id");
            $ap_data = mysqli_fetch_assoc($ap_result);
            $ap_id = $ap_data['ap_id'] ?? null;
        
            if (!$ap_id) {
                $_SESSION['toastMsg'] = "Authorized person not found for this user.";
                $_SESSION['toastType'] = "toast-error";
                header("Location: ../../pages/content_manager/university_background");
                exit();
            }
        
            $imageCount = count($_FILES['images']['name']);
            for ($i = 0; $i < $imageCount; $i++) {
                $imageName = $_FILES['images']['name'][$i];
                $imageTmpName = $_FILES['images']['tmp_name'][$i];
                $imageError = $_FILES['images']['error'][$i];
                $imageSize = $_FILES['images']['size'][$i];
        
                if ($imageError === 0 && $imageSize < 5000000) {
                    $imageExtension = strtolower(pathinfo($imageName, PATHINFO_EXTENSION));
                    $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'jfif'];
        
                    if (in_array($imageExtension, $allowedExtensions)) {
                        $upimage_id = $i + 1;
        
                        $getOldImageQuery = "SELECT up_image FROM universityprofile_image WHERE upimage_id = $upimage_id LIMIT 1";
                        $result = mysqli_query($conn, $getOldImageQuery);
                        $oldImage = mysqli_fetch_assoc($result)['up_image'];
        
                        if ($oldImage) {
                            $oldImagePath = '../../assets/uploads/university_image/' . $oldImage;
                            if (file_exists($oldImagePath)) {
                                unlink($oldImagePath);
                            }
                        }
        
                        $newImageName = uniqid('', true) . '.' . $imageExtension;
                        $imageDestination = '../../assets/uploads/university_image/' . $newImageName;
                        move_uploaded_file($imageTmpName, $imageDestination);
        
                        $updateImageQuery = "UPDATE universityprofile_image 
                                             SET up_image = '$newImageName', ap_id = $ap_id 
                                             WHERE upimage_id = $upimage_id LIMIT 1";
                        mysqli_query($conn, $updateImageQuery);
                    }
                }
            }
        }

        $_SESSION['toastMsg'] = "University background and images updated successfully!";
        $_SESSION['toastType'] = "toast-success";
    } else {
        $_SESSION['toastMsg'] = "Error updating record: " . mysqli_error($conn);
        $_SESSION['toastType'] = "toast-error";
    }

    header("Location: ../../pages/content_manager/university_background");
    exit();
}
?>
