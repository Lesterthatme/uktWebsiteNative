<?php include 'banner.php'; ?>
<?php include 'breadcrumbs.php'; ?>
<?php
include 'connection/dbconnection.php';
$sql = "SELECT university_street, city_municipality, university_province, university_country, 
               university_postalcode, university_contactnumber, university_emailaddress
        FROM university_profile 
        WHERE up_id = 1";

$result = mysqli_query($conn, $sql);

if ($row = mysqli_fetch_assoc($result)) {
  // Format address excluding postal code for Google Maps
  $address = htmlspecialchars($row['university_street'] . ', ' . $row['city_municipality'] . ', ' .
    $row['university_province'] . ', ' . $row['university_country']);

  $postal_code = htmlspecialchars($row['university_postalcode']);
  $contact = htmlspecialchars($row['university_contactnumber']);
  $email = htmlspecialchars($row['university_emailaddress']);

  // Encode address for Google Maps API
  $google_maps_address = urlencode($address);
} else {
  $address = "Not available";
  $postal_code = "Not available";
  $contact = "Not available";
  $email = "Not available";
  $google_maps_address = "";
}

// Insert message logic
date_default_timezone_set('Asia/Phnom_Penh');
if (isset($_POST['send_message'])) {
  $sender_fname = mysqli_real_escape_string($conn, $_POST['sender_fname']);
  $sender_mname = mysqli_real_escape_string($conn, $_POST['sender_mname']);
  $sender_lname = mysqli_real_escape_string($conn, $_POST['sender_lname']);
  $sender_email = mysqli_real_escape_string($conn, $_POST['email']);
  $message_subject = mysqli_real_escape_string($conn, $_POST['message_subject']);
  $message_body = mysqli_real_escape_string($conn, $_POST['message_body']);
  $date_sent = date('Y-m-d H:i:s'); 
  $up_id = 1; 

  $insert_query = "INSERT INTO university_message 
      (message_subject, message_body, sender_email, sender_fname, sender_mname, sender_lname, date_sent, status, up_id) 
      VALUES 
      ('$message_subject', '$message_body', '$sender_email', '$sender_fname', '$sender_mname', '$sender_lname', '$date_sent', 'unread', '$up_id')";

  if (mysqli_query($conn, $insert_query)) {
      echo "<script>alert('Message sent successfully! Please check your inbox or spam folder for a reply from UKT support');</script>";
  } else {
      echo "<script>alert('Error sending message: " . mysqli_error($conn) . "');</script>";
  }
}


mysqli_close($conn);
?>

<div class="contact-container p-5" data-aos="fade-up" data-aos-duration="2000">
  <div class="container mt-4" data-aos="fade-up" data-aos-delay="100">
    <div class="row gy-4 d-flex align-items-stretch">

      <!-- Google Maps Embed -->
      <div class="col-lg-6 d-flex flex-column justify-content-center h-100">
        <?php if (!empty($google_maps_address)): ?>
          <div class="map-container">
            <iframe width="100%" height="200" style="border:0" loading="lazy" allowfullscreen
              referrerpolicy="no-referrer-when-downgrade"
              src="https://www.google.com/maps/embed/v1/place?key=AIzaSyBBT_caDc1fw74uDxF6-Xi8Eh-Nm3mvj6Q&q=<?php echo $google_maps_address; ?>">
            </iframe>
          </div>
        <?php endif; ?>
         <div class="row contact-info mt-4">
     <div class="row justify-content-center mt-4">
  <div class="col-md-4 info-box text-center">
    <div class="contact-card">
      <i class="ri-map-pin-line"></i>
    </div>
    <p><strong>Address:</strong> <?php echo $address; ?></p>
  </div>

  <div class="col-md-4 info-box text-center">
    <div class="contact-card">
      <i class="ri-phone-line"></i>
    </div>
    <p><strong>Phone:</strong> <?php echo $contact; ?></p>
  </div>

  <div class="col-md-4 info-box text-center">
    <div class="contact-card">
      <i class="ri-mail-line"></i>
    </div>
    <p><strong>Email:</strong> <?php echo $email; ?></p>
  </div>
</div>

    </div>
      </div>

      <!-- Contact Form -->
      <div class="col-lg-6 d-flex flex-column justify-content-center h-100">
      <form action="" method="post" class="php-email-form" data-aos="fade-up" data-aos-delay="200">
         <div class="row gy-4">
            <div class="col-md-6">
              <input type="text" name="sender_fname" class="form-control" placeholder="Your First Name" required>
            </div>
            <div class="col-md-6">
              <input type="text" name="sender_mname" class="form-control" placeholder="Your Middle Name" >
            </div>
            <div class="col-md-6">
              <input type="text" name="sender_lname" class="form-control" placeholder="Your Last Name" required>
            </div>
            <div class="col-md-6">
              <input type="email" class="form-control" name="email" placeholder="Your Email" required>
            </div>
            <div class="col-12">
              <input type="text" class="form-control" name="message_subject" placeholder="Subject" required>
            </div>
            <div class="col-12">
              <textarea class="form-control" name="message_body" rows="8" placeholder="Message" required></textarea>
            </div>
            <div class="col-12 text-center">
              <button type="submit" name="send_message" class="news-btn w-100">Send Message</button>
            </div>
          </div>
        </form>
      </div>

    </div>
  </div>
</div>