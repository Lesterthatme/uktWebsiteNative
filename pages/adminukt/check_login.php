<?php 
//check_login.php
// include '../../connection/dbconnection.php';

// session_start();

// $data = ['output' => 'logout'];

// if (isset($_SESSION['user_id'], $_SESSION['session_token'])) {
//     $query = "SELECT session_token FROM user_account WHERE user_id = ?";

//     $statement = $conn->prepare($query);
//     if ($statement) {
//         $statement->bind_param("i", $_SESSION['user_id']);
//         $statement->execute();

//         $result = $statement->get_result();
//         if ($row = $result->fetch_assoc()) {
//             if ($row['session_token'] === $_SESSION['session_token']) {
//                 $data['output'] = 'login';
//             }
//         }
//     }
// }

// echo json_encode($data);

?>
