<div class="card p-3 mt-3">
  <!-- <p><span class="status-badge">Active</span></p> -->
  <div class="dropdown three-dots">
    <button class="btn p-0 border-0" type="button" data-bs-toggle="dropdown" aria-expanded="false">
      <span></span><span></span><span></span>
    </button>
    <ul class="dropdown-menu dropdown-menu-end">
      <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#editModal">
        Edit
      </a>
    </ul>
  </div>
  <h3 class="mt-2 fw-semibold text-uppercase">ABOUT STUDENT ORGANIZATION</h3>
  <p>Student organizations at the University of Kratie (UKT) provide a platform for students to engage in academic, social, cultural, and professional development. These organizations foster leadership, collaboration, and personal growth through various activities and events.</p>
  <p class="text-muted">Date Updated: February 6, 2025 at 2:39 PM</p>
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


