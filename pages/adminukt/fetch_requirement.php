<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-lite.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-lite.min.js"></script>

<?php
// Assuming your database connection is already established
require_once '../../connection/dbconnection.php';

if (isset($_GET['requirement_id'])) {
    $requirement_id = $_GET['requirement_id'];
    $query = "SELECT * FROM admission_requirement WHERE requirement_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $requirement_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
?>
        <form id="editForm" method="POST" action="../../function/admission_requirementfunction.php">
            <input type="hidden" name="requirement_id" value="<?php echo $row['requirement_id']; ?>">

            <div class="mb-3">
                <label class="form-label fw-semibold text-muted">Requirement Title:</label>
                <input type="text" class="form-control" name="requirement_title" value="<?php echo $row['requirement_title']; ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold text-muted">Description:</label>
                <textarea class="form-control" id="summernoteupdate" name="description" rows="3" required><?php echo $row['description']; ?></textarea>
                <div id="summernoteupdate"></div>
                <script>
                    $('#summernoteupdate').summernote({
                        placeholder: 'Hello stand alone ui',
                        tabsize: 2,
                        height: 120,
                        toolbar: [
                            ['style', ['style']],
                            ['font', ['bold', 'italic', 'underline', 'strikethrough', 'superscript', 'subscript', 'clear']],
                            ['fontname', ['fontname']],
                            ['fontsize', ['fontsize']],
                            ['color', ['color']],
                            ['para', ['ol', 'ul', 'paragraph', 'height']],
                            ['view', ['undo', 'redo', 'fullscreen', 'codeview', 'help']]
                        ]
                    });
                </script>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold text-muted">Status:</label>
                <select class="form-select" name="status" required>
                    <option value="Active" <?php if ($row['status'] == 'Active') echo 'selected'; ?>>Active</option>
                    <option value="Inactive" <?php if ($row['status'] == 'Inactive') echo 'selected'; ?>>Inactive</option>
                </select>
            </div>

            <div class="modal-footer">
                <button type="submit" name="update_requirement" class="btn btn-dynamic"><i class="ri-save-fill"></i> Save</button>
            </div>
        </form>
<?php
    } else {
        echo "<p class='text-danger'>Requirement not found.</p>";
    }
}
?>