<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <link rel="icon" type="image/png" href="../../assets/images/officiallogo (1).png" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>University of Kratie || Admin</title>
  <!-- start css  -->
  <link rel="stylesheet" href="../../assets/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="../../assets/bootstrap/css/style.css?v=2.8">
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
            </div>
            <p class="card-text text-muted small"></p>
            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-lg">
                <div class="modal-content">
                  <div class="modal-header">
                    <h1 class="modal-title fs-5 text-muted fw-bold" id="exampleModalLabel">Add Library Resources</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <form>
                      <!-- <div class="mb-3">
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
                      </div> -->

                      <div class="mb-3">
                        <label class="form-label">Resource Type:</label>
                        <select class="form-select" id="category" required>
                          <option value="">Select</option>
                          <option value="Male">Books</option>
                          <option value="Female">Journal</option>
                          <option value="Female">Magazine</option>
                          <option value="Female">Thesis</option>
                          <option value="Female">E-Books</option>
                        </select>
                      </div>

                      <div class="mb-3">
                        <label for="message" class="form-label fw-semibold text-muted">Title:</label>
                        <input type="text" class="form-control" placeholder="Enter Title">
                      </div>

                      <div class="mb-3">
                        <label for="message" class="form-label fw-semibold text-muted">Author:</label>
                        <input type="text" class="form-control" placeholder="Enter Author">
                      </div>

                      <div class="mb-3">
                        <label for="date" class="form-label">Publication Year</label>
                        <input type="month" class="form-control" id="date_published" required>
                      </div>
                      <div class="mb-3">
                        <label for="message" class="form-label fw-semibold text-muted">ISBN/ISSN:</label>
                        <input type="number" class="form-control" placeholder="Enter ISBN/ISSN">
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

            <div class="doc-tabs-container mt-3">
              <ul class="doc-tabs d-flex list-unstyled">
                <li class="me-3">
                  <a class="doc-link" href="University_Library_updates.php">Library Updates</a>
                </li>
                <li class="me-3">
                  <a class="doc-link" href="University_Library_resources.php">Library Resources</a>
                </li>
                <li class="me-3">
                  <a class="doc-link active" href="University_Library_operating_hrs.php">Operating Hours</a>
                </li>
                <li class="me-3">
                  <a class="doc-link" href="#">Research Projects</a>
                </li>

              </ul>
              <hr class="doc-tabs-divider">
            </div>

            <div class="d-flex flex-column flex-md-row align-items-md-center mb-3">
              <p class="mb-2 mb-md-0 flex-grow-1">
                Library Updates provide the latest news on new books, digital resources, services, and facility improvements to enhance learning and research.
              </p>
            </div>
            <div class="d-flex justify-content-end mt-2 mt-md-0">
              <button type="button" class="btn btn-sm rounded-2 px-4 btn-dynamic" data-bs-toggle="modal" data-bs-target="#exampleModal">
                <i class="ri-add-line"></i> Add Library Resources
              </button>
            </div>

            <div class="log_container mt-3">
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
                <div class="d-flex align-items-center ms-md-auto mt-1">

                  <select id="sortBy" class="form-select">
                    <option value="">Sort By</option>
                    <option value="date">Sort by Date</option>
                    <option value="time">Sort by Time</option>
                  </select>
                </div>
              </div>



              <div class="table-container">
                <table class="table table-hover text-center align-middle" id="activityTable">
                  <thead>
                    <tr>
                      <th>Day</th>
                      <th>Hours</th>
                      <th>Operating Status</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                     <td></td>
                     <td></td>
                     <td></td>
                      <td>
                        <div class="dropdown">
                          <button class="btn btn-light btn-sm" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="ri-more-2-fill"></i>
                          </button>
                          <ul class="dropdown-menu">
                            <li><a class="dropdown-item text-primary q" href="#" data-bs-toggle="modal" data-bs-target="#viewBookModal" onclick="loadBookDetails('The Great Gatsby', 'Classic Fiction', 'April 10, 1925', 'A classic novel by F. Scott Fitzgerald.', 'https://via.placeholder.com/150')">
                                View
                              </a></li>
                            <li><a class="dropdown-item text-success" href="#" data-bs-toggle="modal" data-bs-target="#editModal">Edit</a></li>
                            <li><a class="dropdown-item text-danger" href="#">Delete</a></li>
                          </ul>
                        </div>
                      </td>
                    </tr>
                  


                    <!-- Repeat for other rows -->
                  </tbody>
                </table>
                <div class="d-flex justify-content-center">
                  <ul class="pagination custom-pagination mt-2"></ul>
                </div>
              </div>

              <!-- container nav -->

              <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                <div class="modal-dialog p-2 modal-lg">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title fw-bold text-muted" id="editModalLabel">Edit Library Resource</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <div class="mb-3">
                        <label class="form-label">Resource Type:</label>
                        <select class="form-select" id="category" required>
                          <option value="">Select</option>
                          <option value="Male">Books</option>
                          <option value="Female">Journal</option>
                          <option value="Female">Magazine</option>
                          <option value="Female">Thesis</option>
                          <option value="Female">E-Books</option>
                        </select>
                      </div>

                      <div class="mb-3">
                        <label for="message" class="form-label fw-semibold text-muted">Title:</label>
                        <input type="text" class="form-control" placeholder="Enter Title">
                      </div>

                      <div class="mb-3">
                        <label for="message" class="form-label fw-semibold text-muted">Author:</label>
                        <input type="text" class="form-control" placeholder="Enter Author">
                      </div>

                      <div class="mb-3">
                        <label for="date" class="form-label">Publication Year</label>
                        <input type="month" class="form-control" id="date_published" required>
                      </div>
                      <div class="mb-3">
                        <label for="message" class="form-label fw-semibold text-muted">ISBN/ISSN:</label>
                        <input type="number" class="form-control" placeholder="Enter ISBN/ISSN">
                      </div>


                    </div>
                    <div class="modal-footer">
                      <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> -->
                      <button type="button" class="btn btn-success"><i class="ri-save-fill"></i> Save</button>
                    </div>
                  </div>
                </div>
              </div>


              <!-- View Update Modal -->
              <div class="modal fade" id="viewBookModal" tabindex="-1" aria-labelledby="viewBookModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title fw-bold text-muted" id="viewBookModalLabel">View Library Resource</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <div class="row d-flex justify-content-center">
                        <div class="col-md-8">
                          <div class="row">
                            
                              <p><strong>Resource Type:</strong> <span>Journal</span></p>
                              <p><strong>Title:</strong> <span>Test Book</span></p>
                              <p><strong>Author:</strong> <span>Ronaldo Payawal</span></p>
                              <p><strong>Publication Year:</strong> <span>February 25,2025</span></p>
                              <p><strong>ISBN/ISSN:</strong> <span>1234-5678</span></p>
                            
                            
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div> -->
                  </div>
                </div>
              </div>


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
  <script src="../../assets/bootstrap/js/drag_and_drop.js?=v1.1"></script>
  <script src="../../assets/bootstrap/js/activeLink.js?v=1.6"></script>
  <script src="../../assets/bootstrap/js/logs.js?v=1.0"></script>
  <script src="../../assets/bootstrap/js/site_settings.js?v=1.0"></script>
  <!-- end js -->
</body>

</html>