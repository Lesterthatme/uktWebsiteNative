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
  <h3 class="fw-semibold">Rules for Student Organizations:</h3>
  <ul>
    <li>All student groups must be officially recognized by the Student Affairs Office.</li>
    <li>Annual reports and financial records must be submitted at the end of each academic year.</li>
    <li>All events must be approved at least two weeks before the scheduled date.</li>
    <li>Membership should be open to all UKT students without discrimination.</li>
  </ul>

  <h3 class="fw-semibold">Funding & Support for Student Groups:</h3>
  <ul>
    <li>UKT provides financial assistance for student-led projects and events. Apply for funding grants through the Student Affairs Office.</li>
  </ul>
</div>

<!-- container nav -->

<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog p-2 modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title fw-bold text-muted" id="editModalLabel">Edit Rules for Student Organizations</h5>
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

    

        </form>

      </div>
      <div class="modal-footer">
        <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> -->
        <button type="button" class="btn btn-success"><i class="ri-save-fill"></i> Save</button>
      </div>
    </div>
  </div>
</div>