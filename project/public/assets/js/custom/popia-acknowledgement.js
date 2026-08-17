document.addEventListener('DOMContentLoaded', function () {
    const checkbox = document.querySelector('[data-popia-acknowledgement]');
    const submitButton = document.querySelector('[data-popia-submit]');

    if (!checkbox || !submitButton) {
        return;
    }

    const syncState = function () {
        submitButton.disabled = !checkbox.checked;
    };

    checkbox.addEventListener('change', syncState);
    syncState();
});
