<?php
include '../../connection/dbconnection.php';
session_start();

// Fetch all site settings start
$settings = [];
$sql = "SELECT * FROM site_settings LIMIT 1";
$result = mysqli_query($conn, $sql);

if ($row = mysqli_fetch_assoc($result)) {
  $settings = $row;

  if (!empty($settings)) {
    $title_admin = htmlspecialchars($settings['websitetitle_admin']);
    $title_cm = htmlspecialchars($settings['websitetitle_cm']);
    $website_tagline = htmlspecialchars($settings['website_tagline']);
  }
}
// Fetch all site settings end

$sql = "SELECT university_name FROM university_profile ";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  $row = $result->fetch_assoc();
  $university_name = $row["university_name"];
} else {
  echo "<p>No university name found.</p>";
  exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <link rel="icon" type="image/png" href="../../assets/uploads/site settings/favicon/<?php echo htmlspecialchars($settings['fav_icon']); ?>" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo htmlspecialchars($settings['websitetitle_admin']); ?></title>
  <link rel="stylesheet" href="../../assets/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="../../assets/bootstrap/css/style.css?=v2.9">
  <link rel="stylesheet" href="../../assets/RemixIcon/fonts/remixicon.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/mdbassit/Coloris@latest/dist/coloris.min.css" />
  <!--<link rel="stylesheet" href="translator/translator_style.css">-->
</head>

<body class="bg-light">

  <!-- include side bar start -->
   
  <?php include 'include/alert.php'; ?>
  <?php include 'include/sidebar.php'; ?>
  <!-- include side bar end -->

  <main class="bg-light">

    <!-- include navbar start -->
    <?php include 'include/navbar.php'; ?>
    <!-- include navbar end -->
    <!-- start: Content -->
    <div class="p-4">
      <div class="row">
        <div class="card border-0 pb-0">
          <div class="card-body">
            <div class="card-body">
              <div class="d-flex justify-content-center">
                <div class="account_profile-card w-100">
                  <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-3 p-2">
                      <div class="d-flex flex-column flex-sm-row align-items-center text-center text-sm-start gap-3">
                        <img src="../../assets/uploads/site settings/favicon/<?php echo htmlspecialchars($settings['fav_icon']); ?>" alt="Profile Image"
                          class="rounded-circle" style="width: 100px; height: 100px; object-fit: cover;">
                        <div>
                          <h4 class="fw-bold mb-1"><?php echo htmlspecialchars($university_name); ?></h4>
                          <small class="text-muted"><?php echo $website_tagline; ?></small>
                        </div>
                      </div>
                    
                      <div class="d-flex flex-column flex-sm-row gap-2">
                        <button type="button" class="btn btn-sm rounded-2 px-4 btn-dynamic" data-bs-toggle="modal"
                          data-bs-target="#updateSettingsModal" data-bs-toggle="tooltip" data-bs-placement="top" title="Click here to update the settings">
                          <i class="ri-edit-2-line"></i> Update Settings
                        </button>
                      </div>
                    </div>

                  <hr>
                  <div class="row">
                    <div class="col-md-6 mb-3">
                      <label class="form-label fw-bold">Website Title (Admin)</label>
                      <input type="text" class="form-control translate" value="<?php echo $title_admin; ?>" disabled>
                    </div>
                    <div class="col-md-6 mb-3">
                      <label class="form-label fw-bold translate">Website Title (Content Manager)</label>
                      <input type="text" class="form-control" value="<?php echo $title_cm; ?>" disabled>
                    </div>
                  </div>
                 <hr>
                  <div class="row mb-5">
                    <div class="col-md-6 col-12">
                      <label class="fw-bold d-block mb-2"><i class="ri-image-line"></i> Website Background Image</label>
                      <a href="#" class="image-modal-trigger" data-bs-toggle="modal" data-bs-target="#imageModal" data-image="website_background">
                        <img src="../../assets/uploads/site settings/website background/<?php echo htmlspecialchars($settings['website_background']); ?>"
                          alt="Background Image" style="width: 100%; height: 300px; object-fit: cover; padding: 5px; border-radius: 8px;">
                      </a>
                    </div>
                    <div class="col-md-6 col-12">
                      <label class="fw-bold d-block mb-2"><i class="ri-image-line"></i> Website Footer Image (landing page)</label>
                      <a href="#" class="image-modal-trigger" data-bs-toggle="modal" data-bs-target="#imageModal" data-image="website_footerbg">
                        <img src="../../assets/uploads/site settings/website footer/<?php echo htmlspecialchars($settings['website_footerbg']); ?>"
                          alt="Background Image" style="width: 100%; height: 300px; object-fit: cover; padding: 5px; border-radius: 8px;">
                      </a>
                    </div>
                  </div>
                  <div class="row mb-5">
                    <div class="col-md-6 col-12">
                      <label class="fw-bold d-block mb-2"><i class="ri-image-line"></i> Website Banner Image (landing page)</label>
                      <a href="#" class="image-modal-trigger" data-bs-toggle="modal" data-bs-target="#imageModal" data-image="site_banner">
                        <img src="../../assets/uploads/site settings/website banner/<?php echo htmlspecialchars($settings['site_banner']); ?>"
                          alt="Banner Image" style="width: 100%; height: 300px; object-fit: cover; padding: 5px; border-radius: 8px;">
                      </a>
                    </div>

                    <div class="col-md-6 col-12">
                      <label class="fw-bold d-block mb-2"><i class="ri-image-line"></i> Website Home Page Background (landing page)</label>
                      <a href="#" class="image-modal-trigger" data-bs-toggle="modal" data-bs-target="#imageModal" data-image="site_banner">
                        <img src="../../assets/uploads/site settings/home page background/<?php echo htmlspecialchars($settings['homepage_bg']); ?>"
                          alt="Homepage Image" style="width: 100%; height: 300px; object-fit: cover; padding: 5px; border-radius: 8px;">
                      </a>
                    </div>
                  </div>
                  <div class="row mb-0">
                    <hr>
                    <div class="col">
                     <input id="colorInput" type="text" data-coloris>
                      <div class="mt-1 d-flex align-items-center">
                        <label class="fw-bold d-inline-flex align-items-center mb-0">
                          <i class="ri-palette-line me-1"></i> Text/Button Color
                        </label>
                        <div id="colorIndicator" class="color-indicator ms-2"
                          style="background-color: #186428; width: 20px; height: 20px; border-radius: 50%; cursor: pointer;"
                          onclick="openColorPicker()" title="This is automatically saved when you select a color.">
                        </div>
                      </div>
                      <small class="text-muted ">This is automatically saved when you select a color.</small>
                    </div>
                    <!--<div class="col-md-6 col-12">-->
                    <!--  <label class="form-label fw-bold translate mt-3">Toggle to Translate</label> <br>-->
                    <!--  <label class="switch">-->
                    <!--    <input type="checkbox" id="languageToggle">-->
                    <!--    <span class="slider btn-dynamic"></span>-->
                    <!--  </label>-->
                    <!--  <span class="lang-label" id="langLabel"> EN</span><br>-->
                    <!--  <small class="text-muted translate">English to Khmer.</small>-->
                    <!--</div>-->
                  </div>
                  <label class="form-label fw-bold  mt-3">Do you want to backup the database?</label> <br>
                   <!--<small class="text-muted translate">Click download database.</small>-->
                  <form action="../../function/backup_db.php" method="POST">
                          <button type="submit" name="backup" class="btn btn-dynamic btn-sm rounded-2 px-4"
                            onclick="return confirm('Do you want to download the database now?')" data-bs-toggle="tooltip"
                            data-bs-placement="top" title="Click here to download database">
                            <i class="ri-download-2-line"></i> Download Database
                          </button>
                    </form>
               
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>

      <!-- UPDATE MODAL START -->
      <div class="modal fade" id="updateSettingsModal" tabindex="-1" aria-labelledby="updateSettingsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
          <div class="modal-content">
            <form action="../../function/settings_function.php" method="POST" enctype="multipart/form-data">
              <input type="hidden" name="update_favicon" value="1">

              <div class="modal-header">
                <h5 class="modal-title" id="updateSettingsModalLabel"><strong>Update Website Settings</strong></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>

              <div class="modal-body">
                <div class="container-fluid">
                  <!-- Row 1: Favicon + Website Tagline -->
                  <div class="row g-3 mt-1">
                    <div class="col-md-6">
                      <label for="favicon" class="form-label"><strong>Favicon</strong></label>

                      <!-- Preview for Favicon -->
                      <img id="faviconPreview" src="../../assets/uploads/site settings/favicon/<?php echo htmlspecialchars($settings['fav_icon']); ?>"
                        alt="Favicon Preview" style="max-width: 150px; max-height: 150px; object-fit: cover; border-radius: 8px; display: block; margin: 10px auto 0;">

                      <!-- Centered Button -->
                      <div class="d-flex justify-content-center">
                        <button type="button" class="btn btn-dynamic mt-2" onclick="document.getElementById('favicon').click()" data-bs-toggle="tooltip"
                          data-bs-placement="top" title="Click here to update favicon">
                          <i class="ri-loop-left-line"></i> Update Favicon
                        </button>
                      </div>

                      <!-- Hidden file input -->
                      <input type="file" name="favicon" id="favicon"
                        class="form-control" accept="image/*"
                        onchange="previewImage(event, 'faviconPreview')"
                        style="display: none;">
                    </div>

                    <div class="col-md-6">
                      <label for="website_tagline" class="form-label"><strong>Website Tagline</strong></label>
                      <input type="text" name="website_tagline" id="website_tagline" class="form-control" value="<?php echo $website_tagline; ?>" required>
                    </div>
                  </div>

                  <!-- Row 2: Title Admin + Title Content Manager -->
                  <div class="row g-3 mt-4">
                    <div class="col-md-6">
                      <label for="title_admin" class="form-label"><strong>Website Title (Admin)</strong></label>
                      <input type="text" name="title_admin" id="title_admin" class="form-control" value="<?php echo $title_admin; ?>" required>
                    </div>

                    <div class="col-md-6">
                      <label for="title_cm" class="form-label"><strong>Website Title (Content Manager)</strong></label>
                      <input type="text" name="title_cm" id="title_cm" class="form-control" value="<?php echo $title_cm; ?>" required>
                    </div>
                  </div>

                  <!-- Row 3: Website Background + Footer Background -->
                  <div class="row g-3 mt-4">
                    <div class="col-md-6">
                      <label for="website_background" class="form-label"><strong>Website Background</strong></label>
                      <img id="backgroundPreview" src="../../assets/uploads/site settings/website background/<?php echo htmlspecialchars($settings['website_background']); ?>"
                        alt="Website Background Preview" style="max-width: 100%; max-height: 250px; object-fit: cover; border-radius: 8px; display: block; margin: 10px auto 0;">

                      <!-- Centered Button -->
                      <div class="d-flex justify-content-center">
                        <button type="button" class="btn btn-dynamic mt-2" onclick="document.getElementById('website_background').click()" data-bs-toggle="tooltip"
                          data-bs-placement="top" title="Click here to update website background image">
                          <i class="ri-loop-left-line"></i> Update Website Background
                        </button>
                      </div>

                      <!-- Hidden file input -->
                      <input type="file" name="website_background" id="website_background"
                        class="form-control" accept="image/*" onchange="previewImage(event, 'backgroundPreview')"
                        style="display: none;">
                    </div>

                    <div class="col-md-6">
                      <label for="website_footerbg" class="form-label"><strong>Website Footer Background</strong></label>
                      <img id="footerbgPreview" src="../../assets/uploads/site settings/website footer/<?php echo htmlspecialchars($settings['website_footerbg']); ?>"
                        alt="Website Footer Background Preview" style="max-width: 100%; max-height: 250px; object-fit: cover; border-radius: 8px; display: block; margin: 10px auto 0;">

                      <!-- Centered Button -->
                      <div class="d-flex justify-content-center">
                        <button type="button" class="btn btn-dynamic mt-2" onclick="document.getElementById('website_footerbg').click()"
                          data-bs-toggle="tooltip" data-bs-placement="top" title="Click here to update footer background">
                          <i class="ri-loop-left-line"></i> Update Footer Background
                        </button>
                      </div>

                      <!-- Hidden file input -->
                      <input type="file" name="website_footerbg" id="website_footerbg"
                        class="form-control" accept="image/*" onchange="previewImage(event, 'footerbgPreview')"
                        style="display: none;">
                    </div>
                  </div>

                  <!-- website banner and homepage start-->
                  <div class="row g-3 mt-4">
                    <!-- banner start here  -->
                    <div class="col-md-6">
                      <label for="website_banner" class="form-label"><strong>Website Banner</strong></label>
                      <img id="bannerPreview" src="../../assets/uploads/site settings/website banner/<?php echo htmlspecialchars($settings['site_banner']); ?>"
                        alt="Website Banner Preview" style="max-width: 100%; max-height: 250px; object-fit: cover; border-radius: 8px; display: block; margin: 10px auto 0;">

                      <!-- Centered Button -->
                      <div class="d-flex justify-content-center">
                        <button type="button" class="btn btn-dynamic mt-2" onclick="document.getElementById('site_banner').click()" data-bs-toggle="tooltip"
                          data-bs-placement="top" title="Click here to update website banner image">
                          <i class="ri-loop-left-line"></i> Update Website Banner
                        </button>
                      </div>

                      <!-- Hidden file input -->
                      <input type="file" name="site_banner" id="site_banner"
                        class="form-control" accept="image/*" onchange="previewImage(event, 'bannerPreview')"
                        style="display: none;">
                    </div>

                    <!-- homepage start here  -->
                    <div class="col-md-6">
                      <label for="homepage_background" class="form-label"><strong>Home Page Background</strong></label>
                      <img id="HomepageBgPreview" src="../../assets/uploads/site settings/home page background/<?php echo htmlspecialchars($settings['homepage_bg']); ?>"
                        alt="Home page background Preview" style="max-width: 100%; max-height: 250px; object-fit: cover; border-radius: 8px; display: block; margin: 10px auto 0;">

                      <!-- Centered Button -->
                      <div class="d-flex justify-content-center">
                        <button type="button" class="btn btn-dynamic mt-2" onclick="document.getElementById('homepage_bg').click()" data-bs-toggle="tooltip"
                          data-bs-placement="top" title="Click here to update homepage background image">
                          <i class="ri-loop-left-line"></i> Update Home Page Background
                        </button>
                      </div>

                      <!-- Hidden file input -->
                      <input type="file" name="homepage_bg" id="homepage_bg"
                        class="form-control" accept="image/*" onchange="previewImage(event, 'HomepageBgPreview')"
                        style="display: none;">
                    </div>
                    <!-- homepage end here  -->
                  </div>
                  <!-- website banner and homepage end -->
                </div> <!-- end container -->
              </div>

              <div class="modal-footer">
                <button type="submit" class="btn btn-dynamic" data-bs-toggle="tooltip" data-bs-placement="top" title="Click to save changes">
                  <i class="ri-save-fill"></i> Save Changes
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
      <!-- Update Title modal end -->
    </div>
    <?php include 'include/footer.php'; ?>
    </div>
  </main>

  <!-- start js -->
  <script src="../../assets/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../../assets/bootstrap/js/jquery-3.7.1.js"></script>
  <script src="../../assets/bootstrap/js/script.js"></script>
  <script src="../../assets/bootstrap/js/activeLink.js?=v2.0"></script>
  <script src="../../assets/bootstrap/js/site_settings.js?v=1.8"></script>
  <script src="https://cdn.jsdelivr.net/gh/mdbassit/Coloris@latest/dist/coloris.min.js"></script>

  <!--<script src="translator.js"></script>-->
  <!-- Include the translator script START -->
  <script>
    const toggle = document.getElementById('languageToggle');
    const langLabel = document.getElementById('langLabel');

    // Load saved language
    window.addEventListener('load', () => {
      const savedLang = localStorage.getItem('selectedLanguage') || 'en';
      const isKhmer = savedLang === 'km';
      toggle.checked = isKhmer;
      langLabel.textContent = isKhmer ? 'KM' : 'EN';
      translatePage(savedLang);
    });

    // On toggle change
    toggle.addEventListener('change', function() {
      const newLang = this.checked ? 'km' : 'en';
      localStorage.setItem('selectedLanguage', newLang);
      langLabel.textContent = this.checked ? 'KM' : 'EN';
      translatePage(newLang);
    });
  </script>
  <!-- Include the translator script END-->

  <script>
    // Define images array
    const images = {
      website_background: "../../assets/uploads/site settings/website background/<?php echo htmlspecialchars($settings['website_background']); ?>",
      website_footerbg: "../../assets/uploads/site settings/website footer/<?php echo htmlspecialchars($settings['website_footerbg']); ?>"
      website_banner: "../../assets/uploads/site settings/website banner/<?php echo htmlspecialchars($settings['site_banner']); ?>"
      homepage_bg: "../../assets/uploads/site settings/home page background/<?php echo htmlspecialchars($settings['homepage_bg']); ?>"
    };

    // When a thumbnail is clicked, show the corresponding image in the modal
    document.querySelectorAll('.image-modal-trigger').forEach(trigger => {
      trigger.addEventListener('click', function(e) {
        e.preventDefault();
        const imageKey = e.currentTarget.getAttribute('data-image');
        const modalImage = document.getElementById('modal-image');
        modalImage.src = images[imageKey];
        modalImage.setAttribute('data-key', imageKey);
      });
    });

    // Handle Next/Prev buttons
    document.getElementById('next-image').addEventListener('click', function() {
      const modalImage = document.getElementById('modal-image');
      const keys = Object.keys(images);
      const currentIndex = keys.indexOf(modalImage.getAttribute('data-key'));
      const nextIndex = (currentIndex + 1) % keys.length;
      modalImage.src = images[keys[nextIndex]];
      modalImage.setAttribute('data-key', keys[nextIndex]);
    });

    document.getElementById('prev-image').addEventListener('click', function() {
      const modalImage = document.getElementById('modal-image');
      const keys = Object.keys(images);
      const currentIndex = keys.indexOf(modalImage.getAttribute('data-key'));
      const prevIndex = (currentIndex - 1 + keys.length) % keys.length;
      modalImage.src = images[keys[prevIndex]];
      modalImage.setAttribute('data-key', keys[prevIndex]);
    });
  </script>

  <script>
    document.getElementById('favicon').addEventListener('change', function(event) {
      const preview = document.getElementById('faviconPreview');
      const file = event.target.files[0];

      if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
          preview.src = e.target.result;
        };
        reader.readAsDataURL(file);
      }
    });

    function previewImage(event, previewId) {
      var file = event.target.files[0];
      var reader = new FileReader();

      reader.onload = function(e) {
        // Get the preview element and set the source to the selected image
        var preview = document.getElementById(previewId);
        preview.src = e.target.result;
      };

      if (file) {
        reader.readAsDataURL(file);
      }
    }
  </script>

  <script>
    Coloris({
      el: '#colorInput',
      theme: 'default',
      themeMode: 'light',
      format: 'hex',
      clearButton: true,
      defaultColor: '#198754',
      swatches: [
        '#264653', '#2a9d8f', '#e9c46a', '#f4a261', '#e76f51',
        '#1d3557', '#457b9d', '#a8dadc', '#ff6b6b', '#198754'
      ],
      inline: false,
    });

    function openColorPicker() {
      document.getElementById('colorInput').click();
    }
    document.getElementById('colorInput').addEventListener('input', function() {
      document.getElementById('colorIndicator').style.backgroundColor = this.value;
    });
  </script>

  <!-- START >> JS SCRIPT IN ALERT -->
  <script>
    document.addEventListener("DOMContentLoaded", function() {
      console.log("Checking for toast message...");

      <?php if (isset($_SESSION['toastMsg']) && $_SESSION['toastMsg'] != "") { ?>
        let toastType = "<?php echo $_SESSION['toastType']; ?>";
        let message = "<?php echo $_SESSION['toastMsg']; ?>";

        // If success, show "Success", else show "Failed"
        let title = (toastType === "toast-success") ? "Success" : "Failed";

        console.log("Toast Found:", title, message);
        showToast(toastType, title, message);

        // Unset session variables after displaying the toast
        <?php unset($_SESSION['toastMsg']);
        unset($_SESSION['toastType']); ?>
      <?php } else { ?>
        console.log("No toast message found.");
      <?php } ?>
    });

    function showToast(type, title, message) {
      let toast = document.getElementById("toastBox");
      let icon = document.getElementById("toastIcon");
      let titleElement = document.getElementById("toastTitle");
      let messageElement = document.getElementById("toastMessage");

      if (!toast) {
        console.error("Toast box element not found!");
        return;
      }

      // Remove previous styles
      toast.classList.remove("toast-show", "toast-success", "toast-info", "toast-warning", "toast-error");

      // Add new class
      toast.classList.add(type, "toast-show");

      // Set title and message
      titleElement.textContent = title;
      messageElement.textContent = message;

      // Set icon based on type
      switch (type) {
        case "toast-success":
          icon.className = "ri-checkbox-circle-line toast-icon";
          break;
        case "toast-info":
          icon.className = "ri-information-line toast-icon";
          break;
        case "toast-warning":
          icon.className = "ri-alert-line toast-icon";
          break;
        case "toast-error":
          icon.className = "ri-close-circle-line toast-icon";
          break;
        default:
          icon.className = "ri-information-line toast-icon"; // Default icon
      }

      // Show toast
      toast.style.display = "flex";

      // Hide after 3 seconds
      setTimeout(closeToast, 3000);
    }

    function closeToast() {
      let toast = document.getElementById("toastBox");
      toast.classList.remove("toast-show");
      setTimeout(() => {
        toast.style.display = "none";
      }, 500);
    }
  </script>
  <!-- END >> JS SCRIPT IN ALERT -->



</body>

</html>