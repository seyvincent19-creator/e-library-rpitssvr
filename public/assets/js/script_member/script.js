//   Script File Image
const IMAGE_MAX = 2 * 1024 * 1024; // 2MB

// Image validation + preview
const imageInput = document.getElementById('imageInput');
const imagePreview = document.getElementById('imagePreview');

imageInput.addEventListener('change', function () {
    const file = this.files[0];
    if (!file) return;

    if (!file.type.startsWith('image/')) {
        alert('Please select image only');
        this.value = '';
        return;
    }

    if (file.size > IMAGE_MAX) {
        alert('Image size exceeds 2MB limit');
        this.value = '';
        return;
    }

    imagePreview.src = URL.createObjectURL(file);
    imagePreview.style.display = 'block';
});


