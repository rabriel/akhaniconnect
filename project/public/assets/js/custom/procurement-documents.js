"use strict";

(function () {
    var repeater = document.getElementById("procurement_document_repeater");
    var addButton = document.getElementById("procurement_document_add");
    var template = document.getElementById("procurement_document_template");

    if (!repeater || !addButton || !template) {
        return;
    }

    var maxItems = parseInt(repeater.dataset.maxItems || "10", 10);

    function refreshRows() {
        var items = repeater.querySelectorAll("[data-repeater-item]");

        items.forEach(function (item, index) {
            var title = item.querySelector(".fw-bold.fs-5");
            if (title) {
                title.textContent = "Document " + (index + 1);
            }

            var nameInput = item.querySelector("[data-field='name'], input[type='text']");
            if (nameInput) {
                nameInput.setAttribute("name", "documents[" + index + "][name]");
            }

            var fileInput = item.querySelector("[data-field='file'], input[type='file']");
            if (fileInput) {
                fileInput.setAttribute("name", "documents[" + index + "][file]");
            }

            var removeButton = item.querySelector(".procurement-document-remove");
            if (removeButton) {
                removeButton.disabled = items.length === 1;
            }
        });

        addButton.disabled = items.length >= maxItems;
    }

    function addRow() {
        if (repeater.querySelectorAll("[data-repeater-item]").length >= maxItems) {
            return;
        }

        var content = template.content.cloneNode(true);
        repeater.appendChild(content);
        refreshRows();
    }

    addButton.addEventListener("click", addRow);

    repeater.addEventListener("click", function (event) {
        var button = event.target.closest(".procurement-document-remove");

        if (!button) {
            return;
        }

        var item = button.closest("[data-repeater-item]");
        if (!item) {
            return;
        }

        var items = repeater.querySelectorAll("[data-repeater-item]");
        if (items.length === 1) {
            return;
        }

        item.remove();
        refreshRows();
    });

    refreshRows();
})();
