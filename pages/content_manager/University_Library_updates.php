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
                    <h1 class="modal-title fs-5 text-muted fw-bold" id="exampleModalLabel">Add Library Update</h1>
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

                      <div class="mb-3">
                        <label for="message" class="form-label fw-semibold text-muted">Title:</label>
                        <input type="text" class="form-control" placeholder="Enter Title">
                      </div>
                      <div class="mb-3">
                        <label for="message" class="form-label fw-semibold text-muted">Description:</label>
                        <textarea class="form-control" id="message" rows="3" placeholder="Enter Description"></textarea>
                      </div>

                      <div class="mb-3">
                        <label class="form-label">Category</label>
                        <select class="form-select" id="category" required>
                          <option value="">Select</option>
                          <option value="Male">Announcement</option>
                          <option value="Female">News</option>
                        </select>
                      </div>
                      <div class="mb-3">
                        <label for="date" class="form-label">Date</label>
                        <input type="date" class="form-control" id="date_published" required>
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
                  <a class="doc-link active" href="University_Library_updates.php">Library Updates</a>
                </li>
                <li class="me-3">
                  <a class="doc-link" href="University_Library_resources.php">Library Resources</a>
                </li>
                <li class="me-3">
                  <a class="doc-link" href="University_Library_operating_hrs.php">Operating Hours</a>
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
                <i class="ri-add-line"></i> Add Library Update
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
                      <th>Image</th>
                      <th>Title</th>
                      <th>Category</th>
                      <!-- <th>Description</th> -->
                      <th>Date</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>


                    <tr>
                      <td> <img src="../../assets/images/announcement_library.jpg" alt="update_cover" class="img-fluid rounded" style="width: 40px; height: 40px; object-fit: cover;"></td>
                      <td>
                        Free Wifi for All
                      </td>
                      <td>Announcement</td>
                      <!-- <td>The Free Wi-Fi for All - Free Public Internet Access Program from the Department of Information and Communications Technology to accelerate the Philippine government's efforts in enhancing internet accessibility for Filipinos so that economic, social, and educational opportunities will be bolstered, and the growing digital divide can be bridged.#freewifi4all #AngWIFINatin </td> -->
                      <td>April 10, 2025</td>
                      <td>
                        <div class="dropdown">
                          <button class="btn btn-light btn-sm" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="ri-more-2-fill"></i>
                          </button>
                          <ul class="dropdown-menu">
                            <li><a class="dropdown-item text-primary q" href="#" data-bs-toggle="modal" data-bs-target="#viewBookModal" onclick="loadBookDetails('The Great Gatsby', 'Classic Fiction', 'April 10, 1925', 'A classic novel by F. Scott Fitzgerald.', 'https://via.placeholder.com/150')">
                                View
                              </a></li>
                            <li><a class="dropdown-item text-success"  href="#" data-bs-toggle="modal" data-bs-target="#editModal">Edit</a></li>
                            <li><a class="dropdown-item text-danger" href="#">Delete</a></li>
                          </ul>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td> <img src="../../assets/images/announcement_library.jpg" alt="update_cover" class="img-fluid rounded" style="width: 40px; height: 40px; object-fit: cover;"></td>
                      <td>
                        Open Access Databases
                      </td>
                      <td>Announcement</td>
                      <!-- <td>The Free Wi-Fi for All - Free Public Internet Access Program from the Department of Information and Communications Technology to accelerate the Philippine government's efforts in enhancing internet accessibility for Filipinos so that economic, social, and educational opportunities will be bolstered, and the growing digital divide can be bridged.#freewifi4all #AngWIFINatin </td> -->
                      <td>April 10, 2025</td>
                      <td>
                        <div class="dropdown">
                          <button class="btn btn-light btn-sm" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="ri-more-2-fill"></i>
                          </button>
                          <ul class="dropdown-menu">
                            <li><a class="dropdown-item text-primary q" href="#" data-bs-toggle="modal" data-bs-target="#viewBookModal" onclick="loadBookDetails('The Great Gatsby', 'Classic Fiction', 'April 10, 1925', 'A classic novel by F. Scott Fitzgerald.', 'https://via.placeholder.com/150')">
                                View
                              </a></li>
                            <li><a class="dropdown-item text-success"  href="#" data-bs-toggle="modal" data-bs-target="#editModal" >Edit</a></li>
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
                      <h5 class="modal-title fw-bold text-muted" id="editModalLabel">Edit Library Update</h5>
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

                      <div class="mb-3">
                        <label for="message" class="form-label fw-semibold text-muted">Title:</label>
                        <input type="text" class="form-control" placeholder="Enter Title">
                      </div>
                      <div class="mb-3">
                        <label for="message" class="form-label fw-semibold text-muted">Description:</label>
                        <textarea class="form-control" id="message" rows="3" placeholder="Enter Description"></textarea>
                      </div>

                      <div class="mb-3">
                        <label class="form-label">Category</label>
                        <select class="form-select" id="category" required>
                          <option value="">Select</option>
                          <option value="Male">Announcement</option>
                          <option value="Female">News</option>
                        </select>
                      </div>
                      <div class="mb-3">
                        <label for="date" class="form-label">Date</label>
                        <input type="date" class="form-control" id="date_published" required>
                      </div>

                    </form>

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
                <div class="modal-dialog modal-lg">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title fw-bold text-muted" id="viewBookModalLabel">Library Update Details</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <div class="row">
                        <div class="col-md-4">
                          <img id="libraryUpdate" src="../../assets/images/announcement_library.jpg" alt="libraryUpdate" class="img-fluid rounded">
                        </div>
                        <div class="col-md-8">
                          <h4 id="bookTitle">Free Wifi for all</h4>
                          <p><strong>Category:</strong> <span id="bookCategory">Announcement</span></p>
                          <p><strong>Date:</strong> <span id="bookDate">April 10, 2025</span></p>
                          <p><strong>The Free Wi-Fi for All - Free Public Internet Access Program from the Department of Information and Communications Technology to accelerate the Philippine government's efforts in enhancing internet accessibility for Filipinos so that economic, social, and educational opportunities will be bolstered, and the growing digital divide can be bridged.
                              #freewifi4all #AngWIFINatin </strong></p>
                        </div>
                      </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
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
  <script src="../../assets/bootstrap/js/logs.js?v=1.4"></script>
  <script src="../../assets/bootstrap/js/site_settings.js?v=1.0"></script>
  <!-- end js -->
</body>

</html>