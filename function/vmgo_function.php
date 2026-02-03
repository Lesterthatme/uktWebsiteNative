<?php
session_start();
include '../connection/dbconnection.php';

date_default_timezone_set('Asia/Phnom_Penh');

// update mission function start
if (isset($_POST['update_mission'])) {
    $university_mission = mysqli_real_escape_string($conn, $_POST['university_mission']);
    $user_id = $_SESSION['user_id']; 

    $query = "UPDATE university_vmgo SET university_mission = '$university_mission' WHERE vmgo_id = 1";
    
    if (mysqli_query($conn, $query)) {
        $description = "University Mission Updated.";
        $log_date = date('Y-m-d'); 
        $log_time = date('H:i:s');

        $log_query = "INSERT INTO history_log (description, log_date, log_time, user_id) 
                      VALUES ('$description', '$log_date', '$log_time', '$user_id')";

        mysqli_query($conn, $log_query);
        echo "<script>
                alert('Updated successfully');
                window.location.href = '../pages/adminukt/university_vmgo?update=success';
              </script>";
        exit();
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
}
// update mission function end

// update vision function start
if (isset($_POST['update_vision'])) {
    $university_vision = mysqli_real_escape_string($conn, $_POST['university_vision']);
    $user_id = $_SESSION['user_id']; 

    $query = "UPDATE university_vmgo SET university_vision = '$university_vision' WHERE vmgo_id = 1";
    
    if (mysqli_query($conn, $query)) {
        $description = "University Vision Updated.";
        $log_date = date('Y-m-d'); 
        $log_time = date('H:i:s');

        $log_query = "INSERT INTO history_log (description, log_date, log_time, user_id) 
                      VALUES ('$description', '$log_date', '$log_time', '$user_id')";

        mysqli_query($conn, $log_query);
        echo "<script>
                alert('Updated successfully');
                window.location.href = '../pages/adminukt/university_vmgo?update=success';
              </script>";
        exit();
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
}
// update vision function end

// update goal function start
if (isset($_POST['update_goal'])) {
    $university_goal = mysqli_real_escape_string($conn, $_POST['university_goal']);
    $user_id = $_SESSION['user_id']; 

    $query = "UPDATE university_vmgo SET university_goal = '$university_goal' WHERE vmgo_id = 1";
    
    if (mysqli_query($conn, $query)) {
        $description = "University Goal Updated.";
        $log_date = date('Y-m-d'); 
        $log_time = date('H:i:s');

        $log_query = "INSERT INTO history_log (description, log_date, log_time, user_id) 
                      VALUES ('$description', '$log_date', '$log_time', '$user_id')";

        mysqli_query($conn, $log_query);
        echo "<script>
                alert('Updated successfully');
                window.location.href = '../pages/adminukt/university_vmgo?update=success';
              </script>";
        exit();
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
}
// update goal function end
?>
