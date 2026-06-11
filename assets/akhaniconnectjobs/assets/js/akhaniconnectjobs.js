document.addEventListener('DOMContentLoaded', function () {
    var toggles = document.querySelectorAll('.akhani-connect-jobs__toggle');

    toggles.forEach(function (toggle) {
        toggle.addEventListener('click', function () {
            var targetId = toggle.getAttribute('aria-controls');
            var panel = targetId ? document.getElementById(targetId) : null;

            if (!panel) {
                return;
            }

            var isExpanded = toggle.getAttribute('aria-expanded') === 'true';

            toggles.forEach(function (otherToggle) {
                var otherTargetId = otherToggle.getAttribute('aria-controls');
                var otherPanel = otherTargetId ? document.getElementById(otherTargetId) : null;

                if (!otherPanel) {
                    return;
                }

                otherToggle.setAttribute('aria-expanded', 'false');
                otherPanel.hidden = true;
            });

            toggle.setAttribute('aria-expanded', isExpanded ? 'false' : 'true');
            panel.hidden = isExpanded;
        });
    });
});
