<?php
include 'include/alert.php';
session_start();
include '../../function/partnership_function.php';
include 'confirmation.php';

include("../../connection/dbconnection.php");

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <link rel="icon" type="image/png" href="../../assets/images/officiallogo (1).png" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>University of Kratie || Admin</title>
  <!-- start css  -->
  <link rel="stylesheet" href="../../assets/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="../../assets/bootstrap/css/style.css?=v1.2">
  <!-- end css -->
  <!-- Remix icon -->
  <link rel="stylesheet" href="../../assets/RemixIcon/fonts/remixicon.css">
</head>

<body class="bg-light">

  <!-- include side bar start -->
  <?php include 'include/sidebar.php';

  ?>
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
            <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
              <h5 class="card-title fs-6 mb-2 mb-md-0">Head of Department</h5>
              <button type="button" class="btn btn-sm rounded-2 px-4 btn-success" data-bs-toggle="modal" data-bs-target="#exampleModal">
                <i class="ri-add-line"></i> Add Official
              </button>
            </div>

            <p class="card-text text-muted small">
              Stay informed with the latest updates, important notices, and key announcements. This section keeps you connected with recent events, system updates, and essential information to ensure you’re always in the loop.
            </p>

            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-lg">
                <div class="modal-content">
                  <div class="modal-header">
                    <h1 class="modal-title fs-5 text-muted fw-bold" id="exampleModalLabel">Add Official</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <form>
                      <div class="mb-3">
                        <label class="form-label fw-semibold text-muted">Upload Image:</label>
                        <div class="upload-area" id="uploadArea">
                          <img src="https://cdn-icons-png.flaticon.com/512/126/126477.png" alt="Upload Icon">
                          <p class="mb-0">Drag & Drop <br><span class="text-success">or browse</span></p>
                          <small class="text-muted">Supports: JPEG, JPG, PNG</small>
                          <input type="file" id="fileInput" class="d-none" accept="image/jpeg, image/jpg, image/png">
                        </div>
                        <div id="previewContainer" class="preview-container d-none">
                          <button type="button" class="delete-btn" id="deleteBtn">&times;</button>
                          <img id="previewImage" class="preview-img" alt="Preview Image">
                        </div>
                      </div>

                      <div class="row mb-3">
                        <div class="col-md-4">
                          <label for="first-name" class="form-label fw-semibold text-muted">First Name:</label>
                          <input type="text" id="first-name" class="form-control" placeholder="Enter Firstname">
                        </div>
                        <div class="col-md-4">
                          <label for="middle-name" class="form-label fw-semibold text-muted">Middle Name:</label>
                          <input type="text" id="middle-name" class="form-control" placeholder="Enter Middle Name">
                        </div>
                        <div class="col-md-4">
                          <label for="last-name" class="form-label fw-semibold text-muted">Last Name:</label>
                          <input type="text" id="last-name" class="form-control" placeholder="Enter Last Name">
                        </div>
                      </div>

                      <div class="mb-3">
                        <label for="message" class="form-label fw-semibold text-muted">Position:</label>
                        <input type="text" class="form-control" placeholder="Enter Position">
                      </div>
                      <div class="mb-3">
                        <label for="message" class="form-label fw-semibold text-muted">Position Description:</label>
                        <textarea class="form-control" id="message" rows="3" placeholder="Enter Position Description"></textarea>
                      </div>

                    </form>

                  </div>
                  <div class="modal-footer">

                    <button type="button" class="btn btn-success"><i class="ri-save-fill"></i> Save</button>
                  </div>
                </div>
              </div>
            </div>
            <!-- container nav -->
            <div id="partnerCarousel" class="carousel slide" data-bs-ride="carousel">
              <div class="carousel-inner p-4">
                <div class="carousel-item active">
                  <div class="d-flex flex-wrap justify-content-center gap-4">
                    <div class="management_card">
                      <div class="dropdown three-dots">
                        <button class="btn p-0 border-0" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                          <span></span><span></span><span></span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#editModal">Edit</a></li>
                          <li><a class="dropdown-item text-danger" href="#">Delete</a></li>
                        </ul>
                      </div>
                      <img src="../../assets/images/developer/KIMBERLY.jpg" alt="Profile Image" class="officials_image">
                      <div class="official_name">Kimberly C. Sinaguinan</div>
                      <div class="official_position">Content Manager</div>
                      <p class="position_description text-justify">A Content Manager is responsible for creating, editing, and managing digital content across websites, social media, and other platforms. They ensure content aligns with brand guidelines, SEO best practices, and audience engagement strategies. Their role often involves content planning, team coordination, analytics tracking, and improving user experience.</p>
                    </div>

                    <div class="management_card">
                      <div class="dropdown three-dots">
                        <button class="btn p-0 border-0" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                          <span></span><span></span><span></span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                          <li><a class="dropdown-item" href="#">Edit</a></li>
                          <li><a class="dropdown-item text-danger" href="#">Delete</a></li>
                        </ul>
                      </div>
                      <img src="../../assets/images/developer/CARL.jpg" alt="Profile Image" class="officials_image">
                      <div class="official_name">Carl Angelo L. Aquino</div>
                      <div class="official_position">Front-End</div>
                      <p class="position_description text-justify">A Front-End Content Manager focuses on designing, structuring, and optimizing web content for a seamless user experience. They work with HTML, CSS, JavaScript, and CMS platforms to ensure visually appealing, responsive, and interactive content. Their role includes content updates, UI improvements, SEO optimization, and collaboration with designers and developers to maintain brand consistency.</p>
                    </div>

                    <div class="management_card">
                      <div class="dropdown three-dots">
                        <button class="btn p-0 border-0" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                          <span></span><span></span><span></span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                          <li><a class="dropdown-item" href="#">Edit</a></li>
                          <li><a class="dropdown-item text-danger" href="#">Delete</a></li>
                        </ul>
                      </div>
                      <img src="../../assets/images/developer/RONALDO.jpg" alt="Profile Image" class="officials_image">
                      <div class="official_name">Ronaldo F. Payawal</div>
                      <div class="official_position">Back-end Developer</div>
                      <p class="position_description text-justify">A Back-End Content Manager handles the technical aspects of content management, ensuring seamless data storage, retrieval, and delivery. They work with databases, server-side languages (like PHP, Node.js, or Python), and CMS back-end systems to manage content dynamically. Their role includes content automation, API integration, security management, and optimizing server performance for efficient content delivery.</p>
                    </div>

                    <div class="management_card">
                      <div class="dropdown three-dots">
                        <button class="btn p-0 border-0" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                          <span></span><span></span><span></span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                          <li><a class="dropdown-item" href="#">Edit</a></li>
                          <li><a class="dropdown-item text-danger" href="#">Delete</a></li>
                        </ul>
                      </div>
                      <img src="../../assets/images/developer/CHRISTIAN.jpg" alt="Profile Image" class="officials_image">
                      <div class="official_name">Christian S. Arenas</div>
                      <div class="official_position">Quality Assurance</div>
                      <p class="position_description text-justify">A Quality Assurance (QA) Content Manager ensures that all digital content meets quality standards before publication. They review content for accuracy, consistency, SEO compliance, responsiveness, and accessibility. Their role includes testing UI/UX functionality, checking for broken links, verifying cross-browser compatibility, and collaborating with developers to fix issues, ensuring a seamless user experience.</p>
                    </div>

                    <div class="management_card">
                      <div class="dropdown three-dots">
                        <button class="btn p-0 border-0" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                          <span></span><span></span><span></span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                          <li><a class="dropdown-item" href="#">Edit</a></li>
                          <li><a class="dropdown-item text-danger" href="#">Delete</a></li>
                        </ul>
                      </div>
                      <img src="../../assets/images/developer/FRANCESCA.jpeg" alt="Profile Image" class="officials_image">
                      <div class="official_name">Francesca V. Piczon</div>
                      <div class="official_position">System Analyst</div>
                      <p class="position_description text-justify">A System Analyst evaluates and improves IT systems by analyzing business requirements and designing technical solutions. They bridge the gap between business needs and technology, ensuring efficient system functionality, integration, and performance. Their role includes gathering requirements, conducting feasibility studies, optimizing workflows, and collaborating with developers, stakeholders, and QA teams to enhance system efficiency and user experience.</p>
                    </div>

                  </div>
                </div>
              </div>
              <button class="carousel-control-prev custom-carousel-btn" type="button" data-bs-target="#partnerCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
              </button>

              <button class="carousel-control-next custom-carousel-btn" type="button" data-bs-target="#partnerCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
              </button>

              <div class="carousel-indicators">
                <button type="button" data-bs-target="#partnerCarousel" data-bs-slide-to="0" class="active bg-success" aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#partnerCarousel" data-bs-slide-to="1" class="bg-success" aria-label="Slide 2"></button>
              </div>
            </div>


            <!-- container nav -->

            <!-- edit modal start -->
            <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-lg">
                <div class="modal-content">
                  <div class="modal-header">
                    <h1 class="modal-title fs-5 text-muted fw-bold" id="exampleModalLabel">Edit Official Info</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <form>
                      <div class="mb-3">
                        <label class="form-label fw-semibold text-muted">Upload Image:</label>
                        <div class="upload-area" id="editUploadArea"> <!-- Changed ID -->
                          <img src="https://cdn-icons-png.flaticon.com/512/126/126477.png" alt="Upload Icon">
                          <p class="mb-0">Drag & Drop <br><span class="text-success">or browse</span></p>
                          <small class="text-muted">Supports: JPEG, JPG, PNG</small>
                          <input type="file" id="editFileInput" class="d-none" accept="image/jpeg, image/jpg, image/png"> <!-- Changed ID -->
                        </div>
                        <div id="editPreviewContainer" class="preview-container d-none"> <!-- Changed ID -->
                          <button type="button" class="delete-btn" id="editDeleteBtn">&times;</button> <!-- Changed ID -->
                          <img id="editPreviewImage" class="preview-img" alt="Preview Image"> <!-- Changed ID -->
                        </div>
                      </div>
                      <div class="row mb-3">
                        <div class="col-md-4">
                          <label for="first-name" class="form-label fw-semibold text-muted">First Name:</label>
                          <input type="text" id="first-name" class="form-control" placeholder="Enter Firstname">
                        </div>
                        <div class="col-md-4">
                          <label for="middle-name" class="form-label fw-semibold text-muted">Middle Name:</label>
                          <input type="text" id="middle-name" class="form-control" placeholder="Enter Middle Name">
                        </div>
                        <div class="col-md-4">
                          <label for="last-name" class="form-label fw-semibold text-muted">Last Name:</label>
                          <input type="text" id="last-name" class="form-control" placeholder="Enter Last Name">
                        </div>
                      </div>

                      <div class="mb-3">
                        <label for="message" class="form-label fw-semibold text-muted">Position:</label>
                        <input type="text" class="form-control" placeholder="Enter Position">
                      </div>
                      <div class="mb-3">
                        <label for="message" class="form-label fw-semibold text-muted">Position Description:</label>
                        <textarea class="form-control" id="message" rows="3" placeholder="Enter Position Description"></textarea>
                      </div>

                      <div class="mb-3">
                        <label for="form-select" class="form-label fw-semibold text-muted">Status:</label>
                        <select class="form-select" aria-label="Default select example">
                          <option value="1">Active</option>
                          <option value="2">Inactive</option>
                        </select>
                      </div>

                    </form>

                  </div>
                  <div class="modal-footer">

                    <button type="button" class="btn btn-success"><i class="ri-save-fill"></i> Save</button>
                  </div>
                </div>
              </div>
            </div>
            <!-- edit modal end -->

            <!-- View  News Modal Structure -->
            <div class="modal fade" id="newsModal" tabindex="-1" aria-labelledby="newsModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-lg">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title fw-bold text-muted" id="newsModalLabel">View News Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body text-center">
                    <img src="../../assets/images/announcement/2.jpg" class="img-fluid rounded mb-3" alt="Announcement Image" style="max-width: 30%; height: auto;">
                    <h5>Songkran New Year, Year of Chosakt</h5>
                    <p class="text-muted">The University of Kratie is preparing for the upcoming Songkran New Year, which marks the Year of Chosak BC. The celebration, scheduled for the entire province, is expected to bring together students, faculty, and local communities.</p>
                  </div>
                </div>
              </div>
            </div>
            <!-- View  News Modal Structure -->
          </div>
        </div>
      </div>
      <?php include 'include/footer.php'; ?>
    </div>
  </main>

  <!-- start js -->
  <script src="../../assets/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../../assets/bootstrap/js/jquery-3.7.1.js"></script>
  <script src="../../assets/bootstrap/js/script.js"></script>
  <script src="../../assets/bootstrap/js/carousel.js"></script>
  <script src="../../assets/bootstrap/js/drag_and_drop.js?=1.1"></script>
  <script src="../../assets/bootstrap/js/activeLink.js?v=1.2"></script>
  <script src="../../assets/bootstrap/js/table.js"></script>
  <!-- end js -->
</body>

</html>