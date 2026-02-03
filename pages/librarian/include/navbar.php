<?php
require '../../connection/dbconnection.php';

if (!isset($_SESSION['user_id'])) {
  header('location:login.php');
  exit;
}

// Fetch user details
$user_id = $_SESSION['user_id'];
$query = "SELECT ua.username, ua.email, ua.image, 
                 ap.ap_firstname, ap.ap_mi, ap.ap_lastname, 
                 ap.birthday, ap.age, ap.sex 
          FROM user_account ua
          INNER JOIN authorized_person ap ON ua.user_id = ap.user_id
          WHERE ua.user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (!empty($user['image']) && file_exists('../../assets/uploads/profile_pic/' . $user['image'])) {
  $user_image = '../../assets/uploads/profile_pic/' . $user['image'];
} else {
  $user_image = '../../assets/uploads/profile_pic/profile (1).png';
}

// Count pending accounts
$pending_query = "SELECT COUNT(*) AS pending_count FROM user_account WHERE account_status = 'pending'";
$pending_result = $conn->query($pending_query);
$pending_count = 0;
if ($pending_result) {
  $pending_row = $pending_result->fetch_assoc();
  $pending_count = $pending_row['pending_count'];
}
?>

<nav class="px-3 py-3 bg-white">
  <i class="ri-menu-2-line sidebar-toggle me-3 d-block"></i>
  <h5 class="fw-bold mb-0 me-auto">Library Management</h5>

  <!-- Pending Accounts Notification -->
  <!-- <div class="dropdown me-4">
    <a href="#" class="text-decoration-none position-relative" id="notificationDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
        <i class="ri-notification-4-fill" style="font-size: 24px; color: black;"></i>
        <span id="pending-badge" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="display: none;">
            <?= $pending_count; ?>
        </span>
    </a>

    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="notificationDropdown">
        <li id="notification-message" class="dropdown-item text-muted">No new notifications</li>
    </ul>
</div> -->

  <div class="dropdown">
    <div class="d-flex align-items-center cursor-pointer dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
      <img src="<?= htmlspecialchars($user_image); ?>" alt="Profile Image" class="rounded-circle" style="width: 50px; height: 50px; object-fit: cover;">
      <span class="text-dark ms-3">Hi, <?= htmlspecialchars($user['username']); ?></span>
    </div>
    <ul class="dropdown-menu">
      <li><a class="dropdown-item" href="view_profile"><i class="ri-user-line"></i> View Profile</a></li>
      <li>
        <a class="dropdown-item" href="#" onclick="confirmLogout(event)">
          <i class="ri-logout-circle-r-line"></i> Logout
        </a>
      </li>
    </ul>
  </div>
</nav>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  function confirmLogout(event) {
    event.preventDefault();
    Swal.fire({
      title: 'Are you sure?',
      text: 'Do you want to logout?',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, logout',
      cancelButtonText: 'No',
    }).then((result) => {
      if (result.isConfirmed) {
        window.location.href = "logout.php";
      }
    });
  }
</script>

<!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->
<!-- <script>
  function fetchPendingNotifications() {
    $.ajax({
      url: "get_pending_count.php", // Ensure this file returns JSON with { "pending_count": number }
      method: "GET",
      dataType: "json",
      success: function (response) {
        if (response.pending_count > 0) {
          $("#pending-badge").text(response.pending_count).show();
          $("#notification-message").html('<a href="pending_account" class="dropdown-item"> New user sign up! Do you want to view it now?</a>');
        } else {
          $("#pending-badge").hide();
          $("#notification-message").text("No new user signed up");
        }
      },
      error: function () {
        console.log("Error fetching pending notifications.");
      }
    });
  }

  // Fetch notifications every 5 seconds
  setInterval(fetchPendingNotifications, 5000);
  fetchPendingNotifications();
</script> -->
