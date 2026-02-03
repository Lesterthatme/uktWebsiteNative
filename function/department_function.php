<?php
date_default_timezone_set('Asia/Phnom_Penh');

$deptId = isset($_GET['department_id']) ? intval($_GET['department_id']) : 0;
if ($deptId > 0) {

  $query = "SELECT * FROM department WHERE department_id = $deptId";
  $result = mysqli_query($conn, $query);

  if ($result && mysqli_num_rows($result) > 0) {
    $department = mysqli_fetch_assoc($result);
  } else {

    $department = [
      "department_id" => 0,
      "dm_name" => "No Department Found",
      "dm_about" => "",
      "dm_image" => "",
      "dm_status" => "Inactive"
    ];
  }
} else {
  $department = [
    "department_id" => 0,
    "dm_name" => "No Department Selected",
    "dm_about" => "",
    "dm_image" => "",
    "dm_status" => "Inactive"
  ];
}

// START >> ADD FUNCTION OF FACULTY MEMBER
if (isset($_POST['add_facultymem'])) {

    $fm_firstname = $_POST['fm_firstname'];
    $fm_mname = $_POST['fm_mname'];
    $fm_lastname = $_POST['fm_lastname'];
    $fm_position = $_POST['fm_position'];
    $fm_email = $_POST['fm_email'];
    $fm_number = $_POST['fm_number'];
    $deptId = intval($_POST['department_id']);
    $fm_created = date("Y-m-d H:i:s");
    $fm_status = "Active";
    $user_id = $_SESSION['user_id'] ?? null;

    if (!$user_id) {
        $_SESSION['toastMsg'] = "User is not logged in.";
        $_SESSION['toastType'] = "toast-error";
        header("Location: Manage_Department");
        exit();
    }

    $new_file_name = null;
    if (!empty($_FILES["fm_image"]["name"])) {
        $targetDir = "../../assets/uploads/faculty_member/";
        $file_ext = pathinfo($_FILES["fm_image"]["name"], PATHINFO_EXTENSION);
        $allowed_extensions = ['jpg', 'jpeg', 'png', 'jfif']; 

        if (in_array(strtolower($file_ext), $allowed_extensions)) {
            $new_file_name = uniqid('fm_', true) . '.' . $file_ext;

            if ($_FILES["fm_image"]["error"] !== UPLOAD_ERR_OK) {
                die("Upload error: " . $_FILES["fm_image"]["error"]);
            }

            if (move_uploaded_file($_FILES["fm_image"]["tmp_name"], $targetDir . $new_file_name)) {
                echo "File uploaded successfully!";
            } else {
                die("File upload failed!");
            }
        } else {
            die("Invalid file type! Only JPG, JPEG, PNG, and JFIF are allowed.");
        }
    }

    $query = "INSERT INTO faculty_member (fm_firstname, fm_mname, fm_lastname, fm_position, fm_email, fm_number, fm_image, fm_created, fm_status, department_id) 
            VALUES ('$fm_firstname', '$fm_mname', '$fm_lastname', '$fm_position', '$fm_email', '$fm_number', '$new_file_name', '$fm_created', '$fm_status', $deptId)";

    if ($conn->query($query)) {
        $_SESSION['toastMsg'] = "Faculty Member Added Successfully!";
        $_SESSION['toastType'] = "toast-success";

        header("Location: view_department?department_id=$deptId#faculty");
    } else {
        $_SESSION['toastMsg'] = "Error Adding Faculty Member.";
        $_SESSION['toastType'] = "toast-error";
        header("Location: Manage_Department");
    }
    exit();
}
// END >> ADD FUNCTION OF FACULTY MEMBER


// START >> UPDATE FUNCTION OF FACULTY MEMBER
if (isset($_POST['update_facultymem'])) {
  $id = $_POST['fm_id'];
  $firstname = $_POST['fm_firstname'];
  $mname = $_POST['fm_mname'];
  $lastname = $_POST['fm_lastname'];
  $position = $_POST['fm_position'];
  $email = $_POST['fm_email'];
  $number = $_POST['fm_number'];
  $fm_status = $_POST['fm_status'];
  $department_id = $_POST['department_id'];
  $user_id = $_SESSION['user_id'];

  // Get current faculty member data
  $result = mysqli_query($conn, "SELECT * FROM faculty_member WHERE fm_id = '$id'");
  $current_data = mysqli_fetch_assoc($result);

  // Handle profile image update
  if (!empty($_FILES['fm_image']['name'])) {
      $file_name = uniqid('fm_', true) . '.' . pathinfo($_FILES['fm_image']['name'], PATHINFO_EXTENSION);
      $upload_dir = '../../assets/uploads/faculty_member/';
      move_uploaded_file($_FILES['fm_image']['tmp_name'], $upload_dir . $file_name);
  } else {
      $file_name = $current_data['fm_image'];
  }

  // Track changed fields for logging
  $update_fields = [];
  if ($firstname != $current_data['fm_firstname']) $update_fields[] = "First Name";
  if ($mname != $current_data['fm_mname']) $update_fields[] = "Middle Name";
  if ($lastname != $current_data['fm_lastname']) $update_fields[] = "Last Name";
  if ($position != $current_data['fm_position']) $update_fields[] = "Position";
  if ($email != $current_data['fm_email']) $update_fields[] = "Email";
  if ($number != $current_data['fm_number']) $update_fields[] = "Number";
  if ($fm_status != $current_data['fm_status']) $update_fields[] = "Status";
  if ($department_id != $current_data['department_id']) $update_fields[] = "Department";
  if ($file_name != $current_data['fm_image']) $update_fields[] = "Profile Image";

  // Update faculty member details
  $update_query = "UPDATE faculty_member SET 
                      fm_firstname = '$firstname', 
                      fm_mname = '$mname', 
                      fm_lastname = '$lastname', 
                      fm_position = '$position', 
                      fm_email = '$email', 
                      fm_number = '$number',
                      fm_status = '$fm_status',
                      department_id = '$department_id', 
                      fm_image = '$file_name' 
                   WHERE fm_id = '$id'";

  if (mysqli_query($conn, $update_query)) {
      // Log changes
      $log_description = "Updated faculty member: $firstname $lastname - " . implode(", ", $update_fields);
      mysqli_query($conn, "INSERT INTO history_log (description, log_date, log_time, user_id) 
                           VALUES ('$log_description', CURDATE(), CURTIME(), '$user_id')");

      $_SESSION['toastMsg'] = "Faculty member updated successfully!";
      $_SESSION['toastType'] = "toast-success";
  } else {
      $_SESSION['toastMsg'] = "Failed to update faculty member.";
      $_SESSION['toastType'] = "toast-error";
  }

  // Redirect to department view
  header("Location: view_department?department_id=$department_id");
  exit();
}
// END >> UPDATE FUNCTION OF FACULTY MEMBER

// START >> ADD FUNCTION OF adding department 
if (isset($_POST['add_department'])) {

    $dm_name = mysqli_real_escape_string($conn, $_POST['dm_name']);
    $dm_about = mysqli_real_escape_string($conn, $_POST['dm_about']);
    $dm_created = date("Y-m-d H:i:s");
    $dm_status = "Active";
    $user_id = $_SESSION['user_id'] ?? null;

    if (!$user_id) {
        $_SESSION['toastMsg'] = "User is not logged in.";
        $_SESSION['toastType'] = "toast-error";
        header("Location: Manage_Department");
        exit();
    }

    // Get authorized person ID
    $ap_query = "SELECT ap_id FROM authorized_person WHERE user_id = $user_id";
    $ap_result = $conn->query($ap_query);

    if ($ap_result->num_rows > 0) {
        $ap_row = $ap_result->fetch_assoc();
        $ap_id = $ap_row['ap_id'];
    } else {
        $_SESSION['toastMsg'] = "No authorized person found for the user.";
        $_SESSION['toastType'] = "toast-error";
        header("Location: Manage_Department");
        exit();
    }

    // Handle image upload
    $image_name = "";
    if (!empty($_FILES["dm_image"]["name"])) {
        $target_dir = "../../assets/uploads/department_image/";
        $image_name = uniqid('dm_', true) . '.' . pathinfo($_FILES["dm_image"]["name"], PATHINFO_EXTENSION);
        $image_path = $target_dir . $image_name;

        if (!move_uploaded_file($_FILES["dm_image"]["tmp_name"], $image_path)) {
            $_SESSION['toastMsg'] = "Image upload failed.";
            $_SESSION['toastType'] = "toast-error";
            header("Location: Manage_Department");
            exit();
        }
    }

    // Insert new department with `up_id = 1`
    $query = "INSERT INTO department (dm_name, dm_about, dm_image, dm_created, dm_status, up_id, ap_id) 
              VALUES ('$dm_name', '$dm_about', '$image_name', '$dm_created', '$dm_status', 1, '$ap_id')";

    if ($conn->query($query) === TRUE) {
        $department_id = $conn->insert_id;

        // Log action
        $log_description = "Added Department: $dm_name";
        $log_query = "INSERT INTO history_log (description, log_date, log_time, user_id) 
                      VALUES ('$log_description', CURDATE(), CURTIME(), '$user_id')";
        $conn->query($log_query);

        $_SESSION['toastMsg'] = "Department added successfully!";
        $_SESSION['toastType'] = "toast-success";
        header("Location: view_department?department_id=$department_id");
        exit();
    } else {
        $_SESSION['toastMsg'] = "Failed to add department.";
        $_SESSION['toastType'] = "toast-error";
        header("Location: Manage_Department");
        exit();
    }
}
// END >> ADD FUNCTION OF department

// START >> UPDATE FUNCTION OF DEPARTMENT
if (isset($_POST['update_department'])) {
  $department_id = $_POST['department_id'];
  $dm_status = $_POST['dm_status'] == 1 ? 'Active' : 'Inactive';
  $dm_name = mysqli_real_escape_string($conn, $_POST['dm_name']);
  $dm_about = mysqli_real_escape_string($conn, $_POST['dm_about']);
  $user_id = $_SESSION['user_id'] ?? null;

  if (!$user_id) {
      die("Error: User is not logged in.");
  }

  // Fetch current department data
  $result = mysqli_query($conn, "SELECT * FROM department WHERE department_id = '$department_id'");
  if (!$result) {
      die("Error fetching department data: " . mysqli_error($conn));
  }
  $current_data = mysqli_fetch_assoc($result);

  $update_fields = [];

  if ($dm_name != $current_data['dm_name'])
      $update_fields[] = "Name";
  if ($dm_about != $current_data['dm_about'])
      $update_fields[] = "About Section";
  if ($dm_status != $current_data['dm_status'])
      $update_fields[] = "Status";


  $image_name = $current_data['dm_image']; 
  if (!empty($_FILES['dm_image']['name'])) {
      $upload_dir = "../../assets/uploads/department_image/";
      $new_image_name = basename($_FILES['dm_image']['name']);
      $target_file = $upload_dir . $new_image_name;
      $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

      $allowed_types = ['jpg', 'jpeg', 'png', 'jfif'];

      if (in_array($imageFileType, $allowed_types)) {
          if (move_uploaded_file($_FILES["dm_image"]["tmp_name"], $target_file)) {
              $update_fields[] = "Image (Updated from {$current_data['dm_image']} to $new_image_name)";
              $image_name = $new_image_name; 
          } else {
              die("Error uploading image.");
          }
      } else {
          die("Invalid file type. Allowed: JPG, JPEG, PNG.");
      }
  }

  $sql = "UPDATE department SET 
              dm_name = '$dm_name', 
              dm_about = '$dm_about', 
              dm_status = '$dm_status', 
              dm_image = '$image_name' 
          WHERE department_id = '$department_id'";

  if ($conn->query($sql)) {
      if (!empty($update_fields)) {
          $log_description = "Updated Department";
          $log_query = "INSERT INTO history_log (description, log_date, log_time, user_id) 
                        VALUES ('$log_description', CURDATE(), CURRENT_TIME(), '$user_id')";

          if (!$conn->query($log_query)) {
              die("Error inserting history log: " . mysqli_error($conn));
          }
      }

      $_SESSION['toastMsg'] = "Department updated successfully!";
      $_SESSION['toastType'] = "toast-success";
  } else {
      die("Error updating department: " . mysqli_error($conn));
  }

  header("Location: Manage_Department");
  exit();
}
// END >> UPDATE FUNCTION OF DEPARTMENT

// start>> delete FUNCTION OF DEPARTMENT
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_faculty']) && isset($_POST['fm_id'])) {
    include '../connection/dbconnection.php';
    session_start();
    $fm_id = intval($_POST['fm_id']);
    $user_id = $_SESSION['user_id'] ?? null;

    if (!$user_id) {
        $_SESSION['toastMsg'] = "User is not logged in.";
        $_SESSION['toastType'] = "toast-error";
        header("Location: Manage_Department");
        exit();
    }

    $result = mysqli_query($conn, "SELECT fm_firstname, fm_mname, fm_lastname, fm_image, department_id FROM faculty_member WHERE fm_id = $fm_id");
    $faculty = mysqli_fetch_assoc($result);

    if (!$faculty) {
        $_SESSION['toastMsg'] = "Faculty member not found.";
        $_SESSION['toastType'] = "toast-error";
    } else {
        $fm_name = $faculty['fm_firstname'] . " " . $faculty['fm_mname'] . " " . $faculty['fm_lastname'];
        $fm_image = $faculty['fm_image'];
        $deptId = $faculty['department_id'];

        $deleteQuery = "DELETE FROM faculty_member WHERE fm_id = $fm_id";
        if (mysqli_query($conn, $deleteQuery)) {
            if (!empty($fm_image) && file_exists("../../assets/uploads/faculty_member/$fm_image")) {
                unlink("../../assets/uploads/faculty_member/$fm_image");
            }

            $logQuery = "INSERT INTO history_log (description, log_date, log_time, user_id) VALUES (?, CURDATE(), CURTIME(), ?)";
            $stmt = $conn->prepare($logQuery);
            $description = "Deleted Faculty Member: $fm_name";
            $stmt->bind_param("si", $description, $user_id);
            $stmt->execute();
            $stmt->close();

            $_SESSION['toastMsg'] = "Faculty Member deleted successfully.";
            $_SESSION['toastType'] = "toast-success";
        } else {
            $_SESSION['toastMsg'] = "Failed to delete faculty member.";
            $_SESSION['toastType'] = "toast-error";
        }

        header("Location: ../pages/adminukt/view_department?department_id=$deptId");
        exit();
    }
}
// end>> delete FUNCTION OF DEPARTMENT
?>