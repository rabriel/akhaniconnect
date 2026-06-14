document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('[data-upload-tile]').forEach(function (tile) {
        var input = tile.querySelector('[data-upload-input]');
        var filename = tile.querySelector('[data-upload-filename]');

        if (!input || !filename) {
            return;
        }

        input.addEventListener('change', function () {
            var hasFile = input.files && input.files.length > 0;
            filename.textContent = hasFile ? input.files[0].name : 'No file selected';
            tile.classList.toggle('is-selected', hasFile);
        });
    });
});
