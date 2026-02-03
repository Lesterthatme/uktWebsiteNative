<?php
session_start();
include("../../connection/dbconnection.php");

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
        <!-- include navbar end -->

        <!-- start: Content -->
        <div class="p-4">
            <div class="row">
                <div class="card border-0 pb-3">
                    <div class="card-body">
                        <div class="doc-tabs-container mt-3">
                            <ul class="doc-tabs d-flex list-unstyled">
                                <li class="me-3">
                                    <a class="doc-link" href="message">Inbox</a>
                                </li>
                                <li class="me-3">
                                    <a class="doc-link active" href="">Sent Items</a>
                                </li>
                            </ul>
                            <hr class="doc-tabs-divider">
                        </div>
                        <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
                            <h5 class="card-title fs-6 mb-2 mb-md-0">Message Sent List</h5>
                        </div>

                        <p class="card-text text-muted small">These messages originate from students or individuals who have concerns regarding the university.</p>
                        <!-- Show Entries and Search Bar -->

                        <div class="log_container">
                            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-3">
                                <div class="d-flex align-items-center mb-md-0">
                                    <label class="me-2">Show</label>
                                    <select id="entriesSelect" class="form-select custom-dropdown">
                                        <option value="5">5</option>
                                        <option value="10" selected>10</option>
                                        <option value="15">15</option>
                                        <option value="20">20</option>
                                    </select>
                                    <label class="ms-2 me-3">entries</label>
                                </div>
                                <div class="search-container me-2">
                                    <i class="ri-search-line"></i>
                                    <input type="text" id="searchBar" class="form-control" placeholder="Search">
                                </div>

                                <!-- <button id="deleteSelected" class="btn btn-danger btn-sm d-none" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete selected messages">Delete Selected</button> -->

                                <button id="deleteSelected" class="btn btn-sm ms-2 d-none" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete selected messages"
                                    style="position: relative; transition: box-shadow 0.3s ease-in-out;"
                                    onmouseover="this.style.boxShadow='0 0 10px 4px rgba(0, 0, 0, 0.2)';"
                                    onmouseout="this.style.boxShadow='';">
                                    <i class="ri-delete-bin-line"></i> Delete Selected
                                </button>
                                <div class="d-flex align-items-center ms-md-auto mt-1">
                                    <select id="sortBy" class="form-select">
                                        <option value="">Sort By</option>
                                        <option value="date">Sort by Date</option>
                                        <option value="time">Sort by Time</option>
                                    </select>
                                </div>
                            </div>

                            <?php
                            include("../../connection/dbconnection.php");

                            // Fetch sender_email, message_subject, and reply_date only
                            $query = "SELECT um.message_id, um.sender_email, um.message_subject,
                                      um.message_body, mr.reply_id, mr.reply_message, mr.reply_date
                                      FROM university_message um
                                      JOIN message_reply mr ON um.message_id = mr.message_id
                                      ORDER BY um.message_id, mr.reply_date";

                            $result = mysqli_query($conn, $query);
                            ?>

                            <div class="table-container">
                                <table class="table table-hover" id="activityTable">
                                    <thead>
                                        <tr>
                                            <th class="text-center">
                                                <input type="checkbox" id="selectAll" class="me-2">
                                            </th>
                                            <th class="text-center">To</th>
                                            <th class="text-center">Subject</th>
                                            <th class="text-center">Reply Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (mysqli_num_rows($result) > 0): // Check if there are messages 
                                        ?>
                                            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                                                <tr>
                                                    <td class="text-center">
                                                        <input type="checkbox" class="row-checkbox me-2" value="<?= $row['reply_id'] ?>">

                                                    </td>
                                                    <td class="text-center clickable-row"
                                                        data-bs-toggle="modal" data-bs-target="#messageModal"
                                                        data-message="<?= htmlspecialchars($row['message_body'], ENT_QUOTES, 'UTF-8') ?>"
                                                        data-reply="<?= htmlspecialchars($row['reply_message'], ENT_QUOTES, 'UTF-8') ?>"
                                                        data-bs-toggle="tooltip" title="Click this to view the message details">
                                                        <?= htmlspecialchars($row['sender_email'], ENT_QUOTES, 'UTF-8') ?>
                                                    </td>
                                                    <td class="text-center clickable-row"
                                                        data-bs-toggle="modal" data-bs-target="#messageModal"
                                                        data-message="<?= htmlspecialchars($row['message_body'], ENT_QUOTES, 'UTF-8') ?>"
                                                        data-reply="<?= htmlspecialchars($row['reply_message'], ENT_QUOTES, 'UTF-8') ?>"
                                                        data-bs-toggle="tooltip" title="Click this to view the message details">
                                                        <?= htmlspecialchars($row['message_subject'], ENT_QUOTES, 'UTF-8') ?>
                                                    </td>
                                                    <td class="text-center clickable-row"
                                                        data-bs-toggle="modal" data-bs-target="#messageModal"
                                                        data-message="<?= htmlspecialchars($row['message_body'], ENT_QUOTES, 'UTF-8') ?>"
                                                        data-reply="<?= htmlspecialchars($row['reply_message'], ENT_QUOTES, 'UTF-8') ?>"
                                                        data-bs-toggle="tooltip" title="Click this to view the message details">
                                                        <?= date("F j, Y", strtotime($row['reply_date'])) ?>
                                                    </td>
                                                </tr>
                                            <?php endwhile; ?>
                                        <?php else: // If no messages exist, show this row 
                                        ?>
                                            <tr>
                                                <td colspan="4" class="text-center">No messages with replies found.</td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>

                                <div class="d-flex justify-content-center">
                                    <ul class="pagination custom-pagination mt-2"></ul>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>

            </div>
        </div>
        <?php include 'include/footer.php'; ?>
        </div>

        <!-- Message Modal -->
        <div class="modal fade" id="messageModal" tabindex="-1" aria-labelledby="messageModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="messageModalLabel">Message Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <strong>Message:</strong>
                        <p id="modalMessageBody"></p>
                        <hr>
                        <strong>Reply:</strong>
                        <p id="modalReplyMessage"></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>


    </main>

    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../../assets/bootstrap/js/script.js"></script>
    <script src="../../assets/bootstrap/js/activeLink.js?=v1.4"></script>
    <script src="../../assets/bootstrap/js/site_settings.js"></script>
    <script src="../../assets/bootstrap/js/logs.js?v=1.1"></script>

    <script>
        $(document).ready(function() {
            $(".clickable-row").click(function() {
                var messageBody = $(this).data("message");
                var replyMessage = $(this).data("reply");

                $("#modalMessageBody").text(messageBody);
                $("#modalReplyMessage").text(replyMessage);
            });
        });

        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll(".clickable-row").forEach(row => {
                row.addEventListener("click", function(event) {
                    // Prevent modal from opening when clicking a checkbox
                    if (event.target.type === "checkbox") {
                        event.stopPropagation();
                    }
                });
            });
        });
    </script>


    <script>
        $(document).ready(function() {
            // Show modal with message details
            $(".clickable-row").click(function() {
                var message = $(this).data("message");
                var reply = $(this).data("reply");
                $("#modalMessage").text(message);
                $("#modalReply").text(reply);
            });

            // Select All Functionality
            $("#selectAll").change(function() {
                $(".row-checkbox").prop("checked", $(this).prop("checked"));
                toggleDeleteButton();
            });

            // Toggle Delete Button when checkboxes are clicked
            $(".row-checkbox").change(function() {
                if (!$(this).prop("checked")) {
                    $("#selectAll").prop("checked", false); // Uncheck header checkbox if any row checkbox is unchecked
                } else if ($(".row-checkbox:checked").length === $(".row-checkbox").length) {
                    $("#selectAll").prop("checked", true); // Check header checkbox if all row checkboxes are checked
                }
                toggleDeleteButton();
            });

            function toggleDeleteButton() {
                var checkedBoxes = $(".row-checkbox:checked").length;
                if (checkedBoxes > 0) {
                    $("#deleteSelected").removeClass("d-none");
                } else {
                    $("#deleteSelected").addClass("d-none");
                }
            }

            // Delete Selected Messages
            // Handle delete button click
            $("#deleteSelected").click(function() {
                let selectedReplies = [];
                $(".row-checkbox:checked").each(function() {
                    selectedReplies.push($(this).val());
                });

                if (selectedReplies.length > 0) {
                    Swal.fire({
                        title: "Are you sure?",
                        text: "You will not be able to recover this reply!",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#d33",
                        cancelButtonColor: "#3085d6",
                        confirmButtonText: "Yes, delete it!"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: "../../function/delete_reply.php",
                                type: "POST",
                                data: {
                                    reply_ids: selectedReplies
                                },
                                success: function(response) {
                                    Swal.fire("Deleted!", "The selected replies have been deleted.", "success")
                                        .then(() => location.reload());
                                },
                                error: function() {
                                    Swal.fire("Error!", "Something went wrong.", "error");
                                }
                            });
                        }
                    });
                } else {
                    Swal.fire("No Selection", "Please select at least one reply.", "info");
                }
            });
        });
    </script>

    <!-- end js -->

    <!-- JavaScript for Select All End -->
</body>

</html>