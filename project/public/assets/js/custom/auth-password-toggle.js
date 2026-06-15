document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('[data-password-toggle]').forEach(function (button) {
        button.addEventListener('click', function () {
            var target = document.getElementById(button.getAttribute('data-password-target'));

            if (!target) {
                return;
            }

            var isHidden = target.getAttribute('type') === 'password';
            target.setAttribute('type', isHidden ? 'text' : 'password');

            var icon = button.querySelector('i');

            if (icon) {
                icon.classList.toggle('bi-eye', !isHidden);
                icon.classList.toggle('bi-eye-slash', isHidden);
            }

            button.setAttribute('aria-label', isHidden ? 'Hide password' : 'Show password');
            button.setAttribute('aria-pressed', isHidden ? 'true' : 'false');
        });
    });
});
