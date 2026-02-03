const uploadArea = document.getElementById('uploadArea');
const fileInput = document.getElementById('fileInput');
const previewImage = document.getElementById('previewImage');
const previewContainer = document.getElementById('previewContainer');
const deleteBtn = document.getElementById('deleteBtn');

uploadArea.addEventListener('click', () => fileInput.click());

uploadArea.addEventListener('dragover', (e) => {
    e.preventDefault();
    uploadArea.style.backgroundColor = '#f0f0f0';
});

uploadArea.addEventListener('dragleave', () => {
    uploadArea.style.backgroundColor = '';
});

uploadArea.addEventListener('drop', (e) => {
    e.preventDefault();
    uploadArea.style.backgroundColor = '';
    const file = e.dataTransfer.files[0];
    handleFile(file);
});

fileInput.addEventListener('change', (e) => {
    const file = e.target.files[0];
    handleFile(file);
});

deleteBtn.addEventListener('click', () => {
    previewImage.src = '';
    previewContainer.classList.add('d-none');
    fileInput.value = '';
});

function handleFile(file) {
    if (file && file.type.startsWith('image/')) {
        const reader = new FileReader();
        reader.onload = (e) => {
            previewImage.src = e.target.result;
            previewContainer.classList.remove('d-none');
        };
        reader.readAsDataURL(file);
    }
}

const editUploadArea = document.getElementById('editUploadArea');
const editFileInput = document.getElementById('editFileInput');
const editPreviewImage = document.getElementById('editPreviewImage');
const editPreviewContainer = document.getElementById('editPreviewContainer');
const editDeleteBtn = document.getElementById('editDeleteBtn');

editUploadArea.addEventListener('click', () => editFileInput.click());

editUploadArea.addEventListener('dragover', (e) => {
    e.preventDefault();
    editUploadArea.style.backgroundColor = '#f0f0f0';
});

editUploadArea.addEventListener('dragleave', () => {
    editUploadArea.style.backgroundColor = '';
});

editUploadArea.addEventListener('drop', (e) => {
    e.preventDefault();
    editUploadArea.style.backgroundColor = '';
    const file = e.dataTransfer.files[0];
    handleEditFile(file);
});

editFileInput.addEventListener('change', (e) => {
    const file = e.target.files[0];
    handleEditFile(file);
});

editDeleteBtn.addEventListener('click', () => {
    editPreviewImage.src = '';
    editPreviewContainer.classList.add('d-none');
    editFileInput.value = '';
});

function handleEditFile(file) {
    if (file && file.type.startsWith('image/')) {
        const reader = new FileReader();
        reader.onload = (e) => {
            editPreviewImage.src = e.target.result;
            editPreviewContainer.classList.remove('d-none');
        };
        reader.readAsDataURL(file);
    }
}

