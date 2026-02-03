<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <link rel="icon" type="image/png" href="../../assets/images/officiallogo (1).png" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>University of Kratie || Admin</title>
  <!-- start css  -->
  <link rel="stylesheet" href="../../assets/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="../../assets/bootstrap/css/style.css?v=3.0">
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
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h1 class="modal-title fs-5 text-muted fw-bold" id="exampleModalLabel">Add Form</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">

                    <form>
                      <div class="mb-3">
                        <label class="form-label fw-semibold text-muted">Upload Forms:</label>
                        <div class="upload-area" id="formUploadArea">
                          <img src="https://cdn-icons-png.flaticon.com/512/126/126477.png" alt="Upload Icon" width="50">
                          <p class="mb-0">Drag & Drop <br><span class="text-success">or browse</span></p>
                          <small class="text-muted">Supports: PDF, DOC, DOCX</small>
                          <input type="file" id="formFileInput" class="d-none" accept=".pdf, .doc, .docx">
                        </div>
                        <div id="fileContainer" class="mt-3"></div>
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
                  <a class="doc-link" href="pending_account">Pending</a>
                </li>
                <li class="me-3">
                  <a class="doc-link active" href="approved_account">Approved</a>
                </li>


              </ul>
              <hr class="doc-tabs-divider">
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
                <!-- <div class="d-flex align-items-center ms-md-auto mt-1">

                  <select id="sortBy" class="form-select">
                    <option value="">Sort By</option>
                    <option value="date">Sort by Date</option>
                    <option value="time">Sort by Time</option>
                  </select>
                </div> -->
              </div>

              <div class="table-container">
                <table class="table table-hover" id="activityTable" style="width: 100%;">
                  <thead>
                    <tr>
                      <th>Image</th>
                      <th>Full Name</th>
                      <th>User Type</th>
                      <th>Account Status</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td> <img src="../../assets/images/developer/CHRISTIAN.jpg" alt="User" class="img-fluid rounded" style="width: 40px; height: 40px; object-fit: cover;"></td>
                      <td>
                        Christian S. Arenas
                      </td>
                      <td>Content Manager</td>
                      <td><span class="status-badge">Active</span></p>
                      </td>
                      <td>
                        <div class="dropdown">
                          <button class="btn btn-light btn-sm" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="ri-more-2-fill"></i>
                          </button>
                          <ul class="dropdown-menu">
                            <li><a class="dropdown-item text-primary" href="#" data-bs-toggle="modal" data-bs-target="#profileModal">
                                View Profile
                              </a></li>
                            <li><a class="dropdown-item text-danger" href="#">Blocked User</a></li>
                          </ul>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td> <img src="../../assets/images/developer/CARL.jpg" alt="User" class="img-fluid rounded" style="width: 40px; height: 40px; object-fit: cover;"></td>
                      <td>
                        Carl Angelo L. Aquino
                      </td>
                      <td>Content Manager</td>
                      <td><span class="status-badge">Active</span></p>
                      </td>
                      <td>
                        <div class="dropdown">
                          <button class="btn btn-light btn-sm" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="ri-more-2-fill"></i>
                          </button>
                          <ul class="dropdown-menu">
                            <li><a class="dropdown-item text-primary" href="#" data-bs-toggle="modal" data-bs-target="#profileModal">
                                View Profile
                              </a></li>
                            <li><a class="dropdown-item text-primary" href="#" data-bs-toggle="modal" data-bs-target="#profileModal">
                                View Profile
                              </a></li>
                            <li><a class="dropdown-item text-danger" href="#">Blocked User</a></li>
                          </ul>
                          </ul>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td> <img src="../../assets/images/developer/RONALDO.jpg" alt="User" class="img-fluid rounded" style="width: 40px; height: 40px; object-fit: cover;"></td>
                      <td>
                        Ronaldo Payawal
                      </td>
                      <td>Content Manager</td>
                      <td><span class="status-badge">Active</span></p>
                      </td>
                      <td>
                        <div class="dropdown">
                          <button class="btn btn-light btn-sm" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="ri-more-2-fill"></i>
                          </button>
                          <ul class="dropdown-menu">
                            <li><a class="dropdown-item text-primary" href="#" data-bs-toggle="modal" data-bs-target="#profileModal">
                                View Profile
                              </a></li>
                            <li><a class="dropdown-item text-primary" href="#" data-bs-toggle="modal" data-bs-target="#profileModal">
                                View Profile
                              </a></li>
                            <li><a class="dropdown-item text-danger" href="#">Blocked User</a></li>
                          </ul>
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
              

              <div class="modal fade" id="profileModal" tabindex="-1" aria-labelledby="profileModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title fw-bold text-muted" id="profileModalLabel">Profile Details</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <div class="text-center">
                        <img src="../../assets/images/developer/CHRISTIAN.jpg" alt="Profile Picture" class="rounded-circle" width="100">
                        <h5 class="mt-2">Christian S. Arenas</h5>
                        <p class="text-muted">christian@gmail.com</p>
                      </div>
                      <hr>
                      <p><strong>Role:</strong> Content Manager</p>
                      <p><strong>Joined:</strong> January 10, 2024</p>
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
  <script src="../../assets/bootstrap/js/carousel.js?=v1.0"></script>
  <script src="../../assets/bootstrap/js/formDrag_and_Drop.js"></script>
  <script src="../../assets/bootstrap/js/activeLink.js?v=1.5"></script>
  <script src="../../assets/bootstrap/js/Logs.js"></script>
  <script src="../../assets/bootstrap/js/site_settings.js?v=1.4"></script>
  <!-- end js -->
</body>

</html>