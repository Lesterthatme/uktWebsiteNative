const uploadArea = document.getElementById('uploadArea');
const fileInput = document.getElementById('fileInput');
const previewContainer = document.getElementById('previewContainer');

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
    const files = Array.from(e.dataTransfer.files);
    handleFiles(files);
});

fileInput.addEventListener('change', (e) => {
    const files = Array.from(e.target.files);
    handleFiles(files);
});

function handleFiles(files) {
    previewContainer.innerHTML = ''; // Clear previous previews
    previewContainer.classList.remove('d-none');

    const gridContainer = document.createElement('div');
    gridContainer.classList.add('grid-container');
    
    files.forEach(file => {
        if (file && file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = (e) => {
                createPreviewImage(e.target.result, gridContainer);
            };
            reader.readAsDataURL(file);
        }
    });
    previewContainer.appendChild(gridContainer);
}

function createPreviewImage(src, gridContainer) {
    const imgWrapper = document.createElement('div');
    imgWrapper.classList.add('image-wrapper');
    
    const img = document.createElement('img');
    img.src = src;
    img.classList.add('preview-img');
    
    const deleteBtn = document.createElement('button');
    deleteBtn.innerHTML = '&times;';
    deleteBtn.classList.add('delete-btn');
    deleteBtn.addEventListener('click', () => {
        imgWrapper.remove();
        if (gridContainer.children.length === 0) {
            previewContainer.classList.add('d-none');
        }
    });
    
    imgWrapper.appendChild(img);
    imgWrapper.appendChild(deleteBtn);
    gridContainer.appendChild(imgWrapper);
}