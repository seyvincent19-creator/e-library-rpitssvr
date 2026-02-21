// Script File Image and File PDF
const IMAGE_MAX = 2  * 1024 * 1024; // 2MB
const PDF_MAX   = 20 * 1024 * 1024; // 20MB

// ─── Image: validation + preview ────────────────────────────────────────────
const imageInput   = document.getElementById('imageInput');
const imagePreview = document.getElementById('imagePreview');

if (imageInput) {
    imageInput.addEventListener('change', function () {
        const file = this.files[0];
        if (!file) return;

        if (!file.type.startsWith('image/')) {
            alert('Please select an image file only.');
            this.value = '';
            return;
        }

        if (file.size > IMAGE_MAX) {
            alert('Image size exceeds the 2 MB limit.');
            this.value = '';
            return;
        }

        if (imagePreview) {
            imagePreview.src = URL.createObjectURL(file);
            imagePreview.style.display = 'block';
        }
    });
}

// ─── PDF: validation + visual feedback ──────────────────────────────────────
const pdfInput = document.getElementById('pdfInput');
const pdfName  = document.getElementById('pdfName');

function formatSize(bytes) {
    if (bytes >= 1024 * 1024) return (bytes / (1024 * 1024)).toFixed(1) + ' MB';
    return (bytes / 1024).toFixed(0) + ' KB';
}

if (pdfInput) {
    pdfInput.addEventListener('change', function () {
        const file = this.files[0];
        if (!file) return;

        if (file.type !== 'application/pdf') {
            alert('Only PDF files are allowed.');
            this.value = '';
            return;
        }

        if (file.size > PDF_MAX) {
            alert('PDF size exceeds the 20 MB limit.');
            this.value = '';
            return;
        }

        // Update icon colour to red
        const icon = this.closest('.upload-box')?.querySelector('i');
        if (icon) {
            icon.style.color = '#dc3545';
        }

        // Show file name + size
        if (pdfName) {
            pdfName.innerHTML = `<strong style="color:#dc3545;">${file.name}</strong>
                <br><small class="text-muted">${formatSize(file.size)}</small>`;
        }
    });
}
