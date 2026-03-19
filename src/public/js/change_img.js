document.addEventListener('DOMContentLoaded', function () {
    const input = document.getElementById('icon_img');
    const preview = document.getElementById('preview');

    if (!input || !preview) return;

    input.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (!file) return;

        const reader = new FileReader();

        reader.onload = function(e) {
            preview.src = e.target.result;
        };

        reader.readAsDataURL(file);
    });
});