const formUploadArea = document.getElementById("formUploadArea");
const formFileInput = document.getElementById("formFileInput");
const fileContainer = document.getElementById("fileContainer");
const formList = document.getElementById("formList");

// Handle Click Event
formUploadArea.addEventListener("click", () => formFileInput.click());

// Handle File Selection
formFileInput.addEventListener("change", handleFileUpload);

// Handle Drag & Drop
formUploadArea.addEventListener("dragover", (e) => {
    e.preventDefault();
    formUploadArea.style.background = "#d1fae5";
});

formUploadArea.addEventListener("dragleave", () => {
    formUploadArea.style.background = "transparent";
});

formUploadArea.addEventListener("drop", (e) => {
    e.preventDefault();
    formUploadArea.style.background = "transparent";
    const files = e.dataTransfer.files;
    if (files.length > 0) {
        formFileInput.files = files;
        handleFileUpload();
    }
});

function handleFileUpload() {
    const file = formFileInput.files[0];
    if (!file) return;

    // Create file info display
    fileContainer.innerHTML = `
        <div class="file-info">
            <span>${file.name}</span>
            <button type="button" class="form-delete-btn"><i class="ri-delete-bin-line"></i></button>
        </div>
    `;

    // Delete file functionality
    document.querySelector(".form-delete-btn").addEventListener("click", () => {
        fileContainer.innerHTML = "";
        formFileInput.value = "";
    });
}

// Remove Form from List
formList.addEventListener("click", function(event) {
    if (event.target.closest(".remove-form-btn")) {
        event.target.closest("li").remove();
    }
});