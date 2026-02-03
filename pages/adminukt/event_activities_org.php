<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5 text-muted fw-bold" id="exampleModalLabel">Add Event and Activities</h1>
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

          <div class="row">
        
            <div class="mb-3">
              <label class="form-label fw-semibold text-muted">Event Name:</label>
              <input type="text" class="form-control" placeholder="Enter Event Name">
            </div>

            <div class="mb-3">
              <label for="message" class="form-label fw-semibold text-muted">Event Description:</label>
              <textarea class="form-control" rows="4" placeholder="Enter Event Description"></textarea>
            </div>

            <div class="row">
              <div class="col-md-4">
                <label class="form-label fw-semibold text-muted">Event By:</label>
                <select class="form-select" id="campus" required>
                  <option value="Main">BITS</option>
                  <option value="External">BITES</option>
                </select>
              </div>
              <div class="col-md-4">
                <label class="form-label fw-semibold text-muted">Event Date:</label>
                <input type="date" class="form-control">
              </div>
              <div class="col-md-4">
                <label class="form-label fw-semibold text-muted">Event Time:</label>
                <input type="time" class="form-control">
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success"><i class="ri-save-fill"></i> Save</button>
      </div>
    </div>
  </div>
</div>


<div class="d-flex flex-column flex-md-row align-items-md-center mb-3">
  <p class="mb-2 mb-md-0 flex-grow-1">
    A Student Organization is a group formed by students to promote academic, social, cultural, or professional development through
    events, activities, and collaboration.
  </p>
</div>
<div class="d-flex justify-content-end mt-2 mt-md-0">
  <button type="button" class="btn btn-sm rounded-2 px-4 btn-dynamic" data-bs-toggle="modal" data-bs-target="#exampleModal">
    <i class="ri-add-line"></i> Add Events and Activities
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
          <th>Event Name</th>
          <th>Date</th>
          <th>Status</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td><img src="../../assets/images/officiallogo (1).png" alt="update_cover" class="img-fluid rounded" style="width: 40px; height: 40px; object-fit: cover;"></td>
          <td>Agro-Industry
            Enthusiasts </td>
          <td>Main</td>
        


          <td><span class="status-badge">Active</span></td>
          <td>
            <div class="dropdown">
              <button class="btn btn-light btn-sm" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="ri-more-2-fill"></i>
              </button>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#viewBookModal">
                    View
                  </a></li>
                <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#editModal">Edit</a></li>
                <li><a class="dropdown-item" href="#">Delete</a></li>
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
          <h5 class="modal-title fw-bold text-muted" id="editModalLabel">Edit Event and activities</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
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

          <div class="row">
        
        <div class="mb-3">
          <label class="form-label fw-semibold text-muted">Event Name:</label>
          <input type="text" class="form-control" placeholder="Enter Event Name">
        </div>

        <div class="mb-3">
          <label for="message" class="form-label fw-semibold text-muted">Event Description:</label>
          <textarea class="form-control" rows="4" placeholder="Enter Event Description"></textarea>
        </div>

        <div class="row">
              <div class="col-md-4">
                <label class="form-label fw-semibold text-muted">Event By:</label>
                <select class="form-select" id="campus" required>
                  <option value="Main">BITS</option>
                  <option value="External">BITES</option>
                </select>
              </div>
              <div class="col-md-4">
                <label class="form-label fw-semibold text-muted">Event Date:</label>
                <input type="date" class="form-control">
              </div>
              <div class="col-md-4">
                <label class="form-label fw-semibold text-muted">Event Time:</label>
                <input type="time" class="form-control">
              </div>
            </div>

          <div class="mb-3">
            <label class="form-label fw-semibold text-muted">Status</label>
            <select class="form-select" id="Status" required>
              <option value="Active">Active</option>
              <option value="Inactive">Inactive</option>
            </select>
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
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title fw-bold text-muted" id="viewBookModalLabel">View Event</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="row d-flex justify-content-center">
            <div class="col-md-4">
              <img src="../../assets/images/officiallogo (1).png" alt="libraryUpdate" class="img-fluid rounded">
            </div>
            <div class="col-md-8">
              <h4>Title</h4>
              <p><strong>Date:</strong> <span></span></p>
              <p><strong>Description:</strong> <span></span></p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>