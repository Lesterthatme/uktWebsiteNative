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
  <!-- start css  -->
  <link rel="stylesheet" href="../../assets/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="../../assets/bootstrap/css/style.css?=v3.0">
  <!-- end css -->
  <!-- Remix icon -->
  <link rel="stylesheet" href="../../assets/RemixIcon/fonts/remixicon.css">
</head>

<body class="bg-light">

  <!-- include side bar start -->
  <?php include 'include/alert.php';?>
  <?php include 'confirmation.php';?>
  <?php include 'include/sidebar.php'; ?>
  <!-- include side bar end -->

  <main class="bg-light">

    <!-- include navbar start -->
    <?php include 'include/navbar.php'; ?>
    <!-- include navbar end -->

    <!-- start: Content -->
    <div class="p-4">
      <div class="row">
        <div class="card border-0">
          <div class="card-body">
          <div class="doc-tabs-container mt-3">
              <ul class="doc-tabs d-flex list-unstyled">
                <li class="me-3">
                  <a class="doc-link" href="page_management">Highlights</a>
                </li>
                <li class="me-3">
                  <a class="doc-link" href="partnership">Partnership</a>
                </li>
                <li class="me-3">
                  <a class="doc-link" href="calendar">University Calendar</a>
                </li>
                <li class="me-3">
                  <a class="doc-link active" href="FaQ">FAQ</a>
                </li>
              </ul>
              <hr class="doc-tabs-divider">
            </div>
            <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
              <h5 class="card-title fs-6 mb-2 mb-md-0">Frequently Asked Questions (FAQ)</h5>
              <button type="button" class="btn btn-sm rounded-2 px-4 btn-dynamic float-end" data-bs-toggle="modal" data-bs-target="#exampleModal" title="Click to Add FAQ">
                <i class="ri-add-line"></i> Add FAQ </button>
            </div>

            <p class="card-text text-muted small">Find quick answers to common questions about admissions, programs, student services, and university life.</p>

            <!-- Modal to add hightlights start -->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h1 class="modal-title fw-bold text-muted" id="exampleModalLabel" style="font-size: 18px;">Add FAQ</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body pb-0">
                    <div class="dropdown">

                      <ul class="custom-dropdown-menu dropdown-menu" aria-labelledby="iconDropdown" id="icon-container"></ul>
                    </div>
                    <form method="POST" action="../../function/faq_function.php">
                    <div class="modal-body">
                      <div class="mb-3">
                        <label for="faq_question" class="form-label fw-semibold text-muted">Question:</label>
                        <textarea class="form-control border border-2 rounded-2" id="faq_question" name="faq_question"
                          rows="3" placeholder="Enter Question" required></textarea>
                      </div>
                      <div class="mb-3">
                        <label for="faq_answer" class="form-label fw-semibold text-muted">Answer:</label>
                        <textarea class="form-control border border-2 rounded-2" id="faq_answer" name="faq_answer"
                          rows="5" placeholder="Enter Answer" required></textarea>
                      </div>
                      <!-- <div class="mb-3">
                        <label for="faq_status" class="form-label fw-semibold text-muted">Status:</label>
                        <select class="form-select border border-2 rounded-2" id="faq_status" name="faq_status"
                          required>
                          <option value="Active">Active</option>
                          <option value="Inactive">Inactive</option>
                        </select>
                      </div> -->
                    </div>
                    <div class="modal-footer">
                      <button type="submit" name="add_faq" class="btn btn-dynamic btn-md" data-bs-toggle="tooltip" 
                      data-bs-placement="top" title="Click to save"><i class="ri-save-fill"></i>
                        Save</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
            </div>
            <!-- Modal to add hightlights end -->

            <!-- FAQ Start -->
            <div class="faq-container mt-5">
              <!-- accordion viewing start -->
              <?php
              include '../../connection/dbconnection.php';
              // Fetch FAQ data
              $sql = "SELECT faq_id, faq_question, faq_answer, faq_date, faq_time, faq_status, ap_id FROM faq";
              $result = $conn->query($sql);
              // Check if any records exist
              if ($result->num_rows > 0) {
                ?>
                <div class="accordion" id="faqAccordion2">
                  <?php
                  while ($row = $result->fetch_assoc()) {
                    $faqId = $row['faq_id'];
                    $faqQuestion = $row['faq_question'];
                    $faqAnswer = $row['faq_answer'];
                    $faqDate = $row['faq_date'];
                    $faqTime = $row['faq_time'];
                    $faqStatus = $row['faq_status'];
                    $apId = $row['ap_id'];
                    $headingId = "faq-heading-$faqId";
                    $collapseId = "faq-collapse-$faqId";
                    ?>
                    <div class="accordion-item">
                      <h3 class="accordion-header" id="<?php echo $headingId; ?>">
                        <div class="d-flex justify-content-between align-items-center">
                          <button class="accordion-button collapsed flex-grow-1 text-start" type="button"
                            data-bs-toggle="collapse" data-bs-target="#<?php echo $collapseId; ?>" aria-expanded="false"
                            aria-controls="<?php echo $collapseId; ?>" data-bs-toggle="tooltip" 
                           data-bs-placement="top" title="Click here to see the FAQ details">
                            <?php echo htmlspecialchars($faqQuestion); ?>
                          </button>
                          <div class="dropdown three-dots-accord me-3">
                            <button class="btn p-0 border-0" type="button" data-bs-toggle="dropdown" aria-expanded="false" data-bs-toggle="tooltip" 
                            data-bs-placement="top" title="Click here to see the action">
                              <span></span><span></span><span></span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                              <li><a class="dropdown-item text-dark" href="#" data-bs-toggle="modal" data-bs-target="#editModal"
                                  data-faq-id="<?php echo $faqId; ?>" data-bs-toggle="tooltip" 
                                  data-bs-placement="top" title="Click here to edit this FAQ details"><i class="ri-pencil-line"></i> Edit</a>
                                </li>
                                  <li>
                                <a href="javascript:void(0);" class="dropdown-item text-dark text-decoration-none"
                                  data-id="<?= $faqId ?>" onclick="openModal(event, this.dataset.id);" data-bs-toggle="tooltip" 
                                  data-bs-placement="top" title="Click here to delete this FAQ"><i class="ri-delete-bin-line"></i> 
                                  Delete
                                </a>
                              </li>
                            </ul>
                          </div>
                        </div>
                      </h3>
                      <div id="<?php echo $collapseId; ?>" class="accordion-collapse collapse"
                        aria-labelledby="<?php echo $headingId; ?>" data-bs-parent="#faqAccordion2">
                        <div class="accordion-body">
                          <p><?php echo htmlspecialchars($faqAnswer); ?></p>
                          <small><strong>Date:</strong> <?php echo date("F j, Y", strtotime($faqDate)); ?> |
                            <strong>Time:</strong> <?php echo date("h:i A", strtotime($faqTime)); ?> |
                            <strong>Status:</strong>
                            <span style="color: <?php echo ($faqStatus === 'Active') ? 'green' : 'red'; ?>;">
                              <?php echo htmlspecialchars($faqStatus); ?>
                            </span></small>
                        </div>
                      </div>
                    </div>
                    <?php
                  }
                  ?>
                </div>
                <?php
              } else {
                echo "<p>No FAQs available.</p>";
              }
              $conn->close();
              ?>
            </div>

            </div>

            <!-- FAQ End -->
            <!-- Edit Modal start-->
            <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title fw-bold text-muted" id="editModalLabel">Edit FAQ</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body pb-0">
                    <div class="dropdown">
                      <ul class="custom-dropdown-menu dropdown-menu" aria-labelledby="iconDropdown" id="icon-container">
                      </ul>
                    </div>
                    <form method="POST" action="../../function/faq_function.php">
                      <input type="hidden" id="edit_faq_id" name="faq_id">
                      <div class="mb-3">
                        <label for="edit_faq_status" class="form-label fw-semibold text-muted">Status:</label>
                        <select class="form-select border border-2 rounded-2" id="edit_faq_status" name="faq_status"
                          required>
                          <option value="Active">Active</option>
                          <option value="Inactive">Inactive</option>
                        </select>
                      </div>
                      <div class="mb-3">
                        <label for="edit_faq_question" class="form-label fw-semibold text-muted">Question:</label>
                        <textarea class="form-control border border-2 rounded-2" id="edit_faq_question"
                          name="faq_question" rows="3" required></textarea>
                      </div>
                      <div class="mb-3">
                        <label for="edit_faq_answer" class="form-label fw-semibold text-muted">Answer:</label>
                        <textarea class="form-control border border-2 rounded-2" id="edit_faq_answer" name="faq_answer"
                          rows="5" required></textarea>
                      </div>
                      
                      <div class="modal-footer">
                        <button type="submit" name="edit_faq" class="btn btn-dynamic btn-md" data-bs-toggle="tooltip" 
                         data-bs-placement="top" title="Click to save"><iclass="ri-save-fill"></i> Save</button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
            <!-- Edit Modal end-->
          </div>
        </div>
      </div>
    </div>
    </div>
      <?php include 'include/footer.php'; ?>
    </div>
    </div>
  </main>

  <!-- start js -->
  <script src="../../assets/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../../assets/bootstrap/js/jquery-3.7.1.js"></script>
  <script src="../../assets/bootstrap/js/script.js"></script>
  <script src="../../assets/bootstrap/js/carousel.js"></script>
  <script src="../../assets/bootstrap/js/activeLink.js"></script>
  <script src="../../assets/bootstrap/js/site_settings.js?=v2.1"></script>
  <!-- end js -->
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const editButtons = document.querySelectorAll('[data-bs-target="#editModal"]');

      editButtons.forEach(button => {
        button.addEventListener('click', function () {
          const faqId = this.getAttribute('data-faq-id');

          // Fetch FAQ data via AJAX
          fetch(`../../function/get_faq_details.php?id=${faqId}`)
            .then(response => response.json())
            .then(data => {
              document.getElementById('edit_faq_id').value = data.faq_id;
              document.getElementById('edit_faq_question').value = data.faq_question;
              document.getElementById('edit_faq_answer').value = data.faq_answer;
              document.getElementById('edit_faq_status').value = data.faq_status;
            })
            .catch(error => console.error('Error fetching FAQ details:', error));
        });
      });
    });
  </script>

  <!-- end js -->

  <!-- START >> JS SCRIPT IN ALERT -->
  <script>
    document.addEventListener("DOMContentLoaded", function () {
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
        case "toast-success": icon.className = "ri-checkbox-circle-line toast-icon"; break;
        case "toast-info": icon.className = "ri-information-line toast-icon"; break;
        case "toast-warning": icon.className = "ri-alert-line toast-icon"; break;
        case "toast-error": icon.className = "ri-close-circle-line toast-icon"; break;
        default: icon.className = "ri-information-line toast-icon"; // Default icon
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

  <script>
    document.addEventListener("DOMContentLoaded", function () {
      window.openModal = function (event, faq_id) {
        event.preventDefault();
        document.getElementById("modalFaqId").value = faq_id; // Set FAQ ID
        document.getElementById("confirmationModal-faq").style.display = "flex";
      };

      window.closeModal = function () {
        document.getElementById("confirmationModal-faq").style.display = "none";
      };

      window.closeModalOutside = function (event) {
        if (event.target.id === "confirmationModal-faq") {
          closeModal();
        }
      };
    });
  </script>
</body>

</html>