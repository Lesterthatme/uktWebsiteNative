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
  <h5 class="fw-bold mb-0 me-auto">Page Management</h5>

  <!--  Notification Counts Start --> 
  <div class="dropdown me-4">
    <a href="#" class="text-decoration-none position-relative" id="notificationDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
        <i class="ri-notification-4-fill" style="font-size: 24px; color: black;"></i>
        <span id="pending-badge" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="display: none;">
            <?= $pending_count; ?>
        </span>
    </a>

    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="notificationDropdown">
        <li id="notification-message" class="dropdown-item text-muted">No new notifications</li>
    </ul>
  </div>
  <!--  Notification Counts End -->

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
      html: `
        <h3>Are you sure?</h3>
        <p>Do you want to logout?</p>`,  // Replace with a <p> tag
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#6c757d',
      confirmButtonText: 'Yes, logout',
      cancelButtonText: 'No',
      didOpen: () => {
        // Optionally apply custom styling to the h3 and p tags if needed
        const titleElement = document.querySelector('h3');
        titleElement.style.fontSize = '24px';  // Example: Change font size
        titleElement.style.marginBottom = '10px';  // Example: Add margin to the bottom

        const paraElement = document.querySelector('p');
        paraElement.style.fontSize = '16px';  // Example: Adjust paragraph font size
      }
    }).then((result) => {
      if (result.isConfirmed) {
        window.location.href = "logout.php";
      }
    });
  }
</script>


<script>
function fetchPendingNotifications() {
  $.ajax({
    url: "get_pending_count.php",
    method: "GET",
    dataType: "json",
    success: function (response) {
      // Update notification bell count (total notifications)
      if (response.total_notifications > 0) {
        $("#pending-badge").text(response.total_notifications).show();
      } else {
        $("#pending-badge").hide();
      }

      // Clear old notifications
      $("#notification-message").html("");

      // Add pending account notification
      if (response.pending_count > 0) {
        $("#notification-message").append(
          `<a href="pending_account" class="dropdown-item">🔔 ${response.pending_count} new user sign-up(s), view now!</a>`
        );
      }

      // Add unread messages notification
      if (response.unread_messages > 0) {
        let messageText = response.unread_messages === 1 ? 
          "1 message received, view it now" : 
          `${response.unread_messages} messages received, view them now`;
        $("#notification-message").append(
          `<a href="message" class="dropdown-item">📩 ${messageText}</a>`
        );
      }

      // If no notifications, show default text
      if (response.total_notifications === 0) {
        $("#notification-message").text("No new notifications");
      }
    },
    error: function () {
      console.log("Error fetching notifications.");
    }
  });
}

// Fetch notifications every second
setInterval(fetchPendingNotifications, 500);
fetchPendingNotifications();
</script>
