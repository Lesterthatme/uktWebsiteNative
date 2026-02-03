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
    <title><?php echo htmlspecialchars($settings['websitetitle_cm']); ?></title> 
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
        <?php include 'include/navbar.php';?>
        <!-- include navbar end -->

        <!-- start: Content -->
        <div class="p-4">
            <div class="row">
                <div class="card border-0 pb-3">
                    <div class="card-body">
                    <div class="doc-tabs-container mt-3">
                            <ul class="doc-tabs d-flex list-unstyled">
                                <li class="me-3">
                                    <a class="doc-link active" href="message">Inbox</a>
                                </li>
                                <li class="me-3">
                                    <a class="doc-link" href="sent_items">Sent Items</a>
                                </li>
                            </ul>
                            <hr class="doc-tabs-divider">
                        </div>
                        <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
                            <h5 class="card-title fs-6 mb-2 mb-md-0">Message List</h5>
                        </div>

                        <p class="card-text text-muted small">These messages originate from students or individuals who have concerns regarding the university.</p>
                        <!-- Show Entries and Search Bar -->
                        <div class="d-flex justify-content-between mb-3">
                            <div class="d-flex align-items-center">
                                <label class="me-2">Show
                                    <select id="entriesSelect" class="form-select form-select-sm d-inline-block w-auto">
                                        <option value="5">5</option>
                                        <option value="10" selected>10</option>
                                        <option value="25">25</option>
                                        <option value="50">50</option>
                                    </select> entries
                                </label>
                                <!-- Delete Button (Initially Hidden) -->
                                <button id="deleteSelected" class="btn btn-sm ms-2 d-none" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete selected messages"
                                    style="position: relative; transition: box-shadow 0.3s ease-in-out;"
                                    onmouseover="this.style.boxShadow='0 0 10px 4px rgba(0, 0, 0, 0.2)';"
                                    onmouseout="this.style.boxShadow='';">
                                    <i class="ri-delete-bin-line"></i> Delete Selected
                                </button>
                            </div>

                            <div class="dropdown">
                                <button class="btn btn-light dropdown-toggle" type="button" id="filterDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                   Sort By
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="filterDropdown">
                                    <li><a class="dropdown-item filter-btn" href="#" data-filter="">All</a></li>
                                    <li><a class="dropdown-item filter-btn" href="#" data-filter="read">Read</a></li>
                                    <li><a class="dropdown-item filter-btn" href="#" data-filter="unread">Unread</a></li>
                                </ul>
                            </div>
                        </div>

                        <div class="log_container">
                            <div class="table-container">
                                <?php
                                include("../../connection/dbconnection.php");

                                $filter = isset($_GET['filter']) ? $_GET['filter'] : '';
                                $whereClause = "";

                                if ($filter === "read") {
                                    $whereClause = "WHERE status = 'Read'";
                                } elseif ($filter === "unread") {
                                    $whereClause = "WHERE status = 'unread'";
                                }

                                $query = "SELECT * FROM university_message $whereClause ORDER BY (DATE(date_sent) = CURDATE()) DESC, date_sent DESC";
                                $result = $conn->query($query);
                                ?>
                                <table class="table table-hover" id="activityTable">
                                    <thead>
                                        <tr>
                                            <th class="text-start"><input type="checkbox" id="selectAll" class="me-2"></th>
                                            <th class="text-start">Subject</th>
                                            <th class="text-start">Date</th>
                                            <th class="text-start">Status</th>

                                        </tr>
                                    </thead>
                                    <tbody id="messageTableBody">
                                    </tbody>
                                </table>
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
            $(document).on('click', '.filter-btn', function() {
                let filter = $(this).data("filter");
                let newUrl = window.location.pathname + (filter ? "?filter=" + filter : "");
                history.pushState(null, "", newUrl);
                fetchMessages();
            });

            $(document).ready(function() {
                var table = $('#activityTable').DataTable({
                    "paging": true,
                    "lengthChange": false,
                    "searching": true,
                    "ordering": false,
                    "info": true,
                    "pageLength": 10,
                    "language": {
                        "search": "",
                        "searchPlaceholder": "Search messages..."
                    }
                });

                $('#entriesSelect').on('change', function() {
                    table.page.len($(this).val()).draw();
                });

                $('#searchInput').on('keyup', function() {
                    table.search($(this).val()).draw();
                });

                $('#selectAll').on('click', function() {
                    let isChecked = $(this).prop('checked');

                    $('.selectRow').each(function() {
                        let messageId = $(this).data('id').toString();

                        if (isChecked) {
                            checkedIds.add(messageId);
                        } else {
                            checkedIds.delete(messageId);
                        }

                        $(this).prop('checked', isChecked);
                    });

                    toggleTrashIcon();
                });

                $(document).on('click', '.selectRow', function() {
                    let messageId = $(this).data('id').toString();

                    if ($(this).prop('checked')) {
                        checkedIds.add(messageId);
                    } else {
                        checkedIds.delete(messageId);
                        $('#selectAll').prop('checked', false);
                    }

                    toggleTrashIcon();
                });
                $('#deleteSelected').css("display", "block");

                function toggleTrashIcon() {
                    if ($('.selectRow:checked').length > 0) {
                        console.log("Checkbox selected, showing delete button.");
                        $('#deleteSelected').removeClass('d-none').show();
                    } else {
                        console.log("No checkbox selected, hiding delete button.");
                        $('#deleteSelected').addClass('d-none').hide();
                    }
                }

                $('#deleteSelected').on('click', function() {
                    var selectedIds = [];
                    $('.selectRow:checked').each(function() {
                        selectedIds.push($(this).data('id'));
                    });

                    if (selectedIds.length > 0) {
                        Swal.fire({
                            title: "Are you sure?",
                            text: "You are about to delete selected messages.",
                            icon: "warning",
                            showCancelButton: true,
                            confirmButtonText: "Yes, delete it!",
                            cancelButtonText: "Cancel"
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $.post('../../function/content_manager/message_function.php', {
                                    message_ids: selectedIds
                                }, function(response) {
                                    Swal.fire({
                                        title: "Deleted!",
                                        text: "Message has been deleted.",
                                        icon: "success",
                                        timer: 5000,
                                        showConfirmButton: false
                                    });
                                    setTimeout(() => location.reload(), 500);
                                });
                            }
                        });
                    }
                });

                let checkedIds = new Set();

                function fetchMessages() {
                    let filter = new URLSearchParams(window.location.search).get("filter") || "";

                    $(".selectRow:checked").each(function() {
                        checkedIds.add($(this).data("id").toString());
                    });

                    $.ajax({
                        url: "fetch_messages.php",
                        type: "GET",
                        data: {
                            filter: filter
                        },
                        dataType: "json",
                        success: function(data) {
                            let table = $('#activityTable').DataTable();
                            table.clear();

                            // if (data.length === 0) {
                            //     table.row.add(['', 'Loading messages...', '', '', '']).draw();
                            //     return;
                            // }

                            data.forEach(row => {
                                let isUnread = row.status === "unread" ? "fw-bold" : "";
                                let statusBadge = row.status === "read" ?
                                    '<span class="badge bg-success">Read</span>' :
                                    '<span class="badge bg-danger">Unread</span>';

                                let checked = checkedIds.has(row.message_id.toString()) ? "checked" : "";

                                table.row.add([
                                    `<input type="checkbox" class="selectRow" data-id="${row.message_id}" ${checked}>`,
                                    `<a href="view_message?message_id=${row.message_id}" class="${isUnread}" style="text-decoration: none; color: black;" data-bs-toggle="tooltip" data-bs-placement="top" title="Please click the subject to view the message">${row.message_subject}</a>`,
                                    `<a href="view_message?message_id=${row.message_id}" span class="${isUnread}" style="text-decoration: none; color: black;" data-bs-toggle="tooltip" data-bs-placement="top" title="Please click the subject to view the message" >${row.date_sent_formatted}</span>`, // Bold if unread

                                    statusBadge,

                                ]).draw(false);

                            });

                            $(".selectRow").on("change", function() {
                                let id = $(this).data("id").toString();
                                if ($(this).is(":checked")) {
                                    checkedIds.add(id);
                                } else {
                                    checkedIds.delete(id);
                                }
                            });
                        }
                    });
                }
                // Auto-refresh messages every .5 seconds
                setInterval(fetchMessages, 500);
            });
        </script>

    </main>

    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../../assets/bootstrap/js/script.js"></script>
    <script src="../../assets/bootstrap/js/activeLink.js?=v1.3"></script>
    <script src="../../assets/bootstrap/js/site_settings.js"></script>
    <!-- end js -->

    <!-- JavaScript for Select All End -->
</body>

</html>