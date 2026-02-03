<?php
include("../../connection/dbconnection.php");
session_start();

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['message_id'])) {
    $message_id = intval($_GET['message_id']);

    $query = "SELECT * FROM university_message WHERE message_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $message_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        $message_subject = $row['message_subject'];
        $message_body = $row['message_body'];
        $sender_email = $row['sender_email'];
        $sender_fname = $row['sender_fname'];
        $sender_lname = $row['sender_lname'];
        $date_sent = date("M d, Y h:i A", strtotime($row['date_sent']));

        $updateQuery = "UPDATE university_message SET status = 'read' WHERE message_id = ?";
        $updateStmt = $conn->prepare($updateQuery);
        $updateStmt->bind_param("i", $message_id);
        $updateStmt->execute();

        $up_id = $row['up_id'];

        $apQuery = "SELECT ap_id FROM university_profile WHERE up_id = ?";
        $apStmt = $conn->prepare($apQuery);
        $apStmt->bind_param("i", $up_id);
        $apStmt->execute();
        $apResult = $apStmt->get_result();

        if ($apRow = $apResult->fetch_assoc()) {
            $ap_id = $apRow['ap_id'];

            $userQuery = "SELECT user_id FROM authorized_person WHERE ap_id = ?";
            $userStmt = $conn->prepare($userQuery);
            $userStmt->bind_param("i", $ap_id);
            $userStmt->execute();
            $userResult = $userStmt->get_result();

            if ($userRow = $userResult->fetch_assoc()) {
                $user_id = $userRow['user_id'];

                $updateApQuery = "UPDATE university_message SET ap_id = ? WHERE message_id = ?";
                $updateApStmt = $conn->prepare($updateApQuery);
                $updateApStmt->bind_param("ii", $ap_id, $message_id);
                $updateApStmt->execute();
            }
        }
    } else {
        echo "Message not found.";
        exit();
    }
} else {
    echo "Invalid request.";
    exit();
}

// Fetch all site settings start
$settings = [];
$sql = "SELECT * FROM site_settings LIMIT 1";
$result = mysqli_query($conn, $sql);

if ($row = mysqli_fetch_assoc($result)) {
    $settings = $row;

    if (!empty($settings)) {
        $title_admin = htmlspecialchars($settings['websitetitle_admin']);
        $title_cm = htmlspecialchars($settings['websitetitle_cm']);
    }
}
// Fetch all site settings end
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/png" href="../../assets/uploads/site settings/favicon/<?php echo htmlspecialchars($settings['fav_icon']); ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($settings['websitetitle_admin']); ?></title>
    <link rel="stylesheet" href="../../assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../assets/bootstrap/css/style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="../../assets/RemixIcon/fonts/remixicon.css">

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
</head>

<body class="bg-light">

    <!-- include side bar start -->
    <?php include 'include/alert.php'; ?>
    <?php include 'confirmation.php'; ?>
    <?php include 'include/sidebar.php'; ?>
    <!-- include side bar end -->
    <main class="bg-light">

        <!-- include navbar start -->
        <?php include 'include/navbar.php';

        ?>

        <div class="p-4">
            <div class="row">
                <div class="card border-0 pb-3">
                    <div class="card-body">
                        <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
                            <h5 class="card-title fs-6 mb-2 mb-md-0">Message List</h5>
                        </div>
                        <p class="card-text text-muted small">These messages originate from students or individuals who have concerns regarding the university.</p>

                        <div class="log_container">

                            <div class="container mt-4">
                                <div class="card shadow-lg border-0">
                                    <div class="card-header bg-primary text-white">
                                        <h5 class="mb-0">📩 Message Details</h5>
                                    </div>
                                    <div class="card-body">
                                        <h4 class="text-dark"><?php echo htmlspecialchars($message_subject); ?></h4>
                                        <p class="text-muted"><strong>From:</strong> <?php echo htmlspecialchars($sender_fname . ' ' . $sender_lname); ?> (<a href="mailto:<?php echo $sender_email; ?>" class="text-decoration-none"><?php echo $sender_email; ?></a>)</p>
                                        <p><strong>📅 Sent on:</strong> <?php echo $date_sent; ?></p>
                                        <hr>
                                        <p class="text-dark fs-5" style="white-space: pre-line;"><strong>Message:</strong>
                                            <?php echo nl2br(htmlspecialchars($message_body)); ?>
                                        </p>

                                        <!-- Reply & Actions -->
                                        <div class="mt-3 d-flex justify-content-between">
                                            <button id="replyBtn" class="btn btn-outline-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="Reply to this message">
                                                <i class="ri-reply-fill"></i> Reply
                                            </button>
                                            <a href="message" class="btn btn-outline-secondary" data-bs-toggle="tooltip" data-bs-placement="top" title="Back to the message page"><i class="ri-arrow-left-line"></i> Back to Messages</a>
                                        </div>

                                        <!-- Reply Form (Hidden by Default) -->
                                        <div id="replyForm" class="mt-3 p-3 bg-light border rounded" style="display: none;">
                                            <form action="../../function/message_function.php" method="POST">
                                                <input type="hidden" name="message_id" value="<?php echo $message_id; ?>">
                                                <input type="hidden" name="ap_id" value="<?php echo $ap_id; ?>">

                                                <label for="reply_message" class="fw-bold">Your Reply:</label>
                                                <textarea name="reply_message" class="form-control" rows="4" placeholder="Write your reply..." required></textarea>

                                                <div class="d-flex mt-3">
                                                    <button type="submit" name="send_reply" class="btn btn-primary me-2" data-bs-toggle="tooltip" data-bs-placement="top" title="Send reply"><i class="ri-mail-send-fill"></i> Send Reply</button>
                                                    <button type="button" id="cancelReply" class="btn btn-danger" data-bs-toggle="tooltip" data-bs-placement="top" title="Cancel reply"><i class="ri-close-line"></i> Cancel</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-center">
                                <ul class="pagination custom-pagination mt-2"></ul>
                            </div>

                        </div>

                    </div>
                </div>
                <?php include 'include/footer.php'; ?>
            </div>

        </div>


        <script>
            $(document).ready(function() {
                $("#replyBtn").click(function() {
                    $("#replyForm").slideDown();
                    $(this).hide();
                });

                $("#cancelReply").click(function() {
                    $("#replyForm").slideUp();
                    $("#replyBtn").show();
                });
            });
        </script>
    </main>

    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../../assets/bootstrap/js/script.js"></script>
    <script src="../../assets/bootstrap/js/activeLink.js?=v1.2"></script>
    <script src="../../assets/bootstrap/js/site_settings.js"></script>
    <!-- end js -->

    <!-- JavaScript for Select All End -->
</body>

</html>