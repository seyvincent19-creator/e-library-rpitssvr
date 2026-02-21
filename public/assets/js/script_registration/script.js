const photoInput  = document.getElementById('photoInput');
const uploadZone  = document.getElementById('uploadZone');
const previewWrap = document.getElementById('previewWrap');
const previewImg  = document.getElementById('previewImg');
const removeBtn   = document.getElementById('removeBtn');
const fileName    = document.getElementById('fileName');

function showPreview(file) {
    if (!file || !file.type.startsWith('image/')) return;
    const reader = new FileReader();
    reader.onload = e => {
    previewImg.src      = e.target.result;
    previewWrap.style.display = 'block';
    uploadZone.style.display  = 'none';
    fileName.textContent      = file.name;
    };
    reader.readAsDataURL(file);
}

photoInput.addEventListener('change', () => {
    if (photoInput.files[0]) showPreview(photoInput.files[0]);
});

removeBtn.addEventListener('click', () => {
    photoInput.value          = '';
    previewImg.src            = '#';
    previewWrap.style.display = 'none';
    uploadZone.style.display  = 'block';
    fileName.textContent      = '';
});

/* Drag & drop */
uploadZone.addEventListener('dragover', e => {
    e.preventDefault();
    uploadZone.classList.add('dragover');
});
uploadZone.addEventListener('dragleave', () => {
    uploadZone.classList.remove('dragover');
});
uploadZone.addEventListener('drop', e => {
    e.preventDefault();
    uploadZone.classList.remove('dragover');
    const file = e.dataTransfer.files[0];
    if (file) {
    const dt = new DataTransfer();
    dt.items.add(file);
    photoInput.files = dt.files;
    showPreview(file);
    }
});
