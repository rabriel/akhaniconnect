"use strict";

Dropzone.autoDiscover = false;

(function () {
    var dropzoneElement = document.getElementById("candidate_document_dropzone");
    var typeElement = document.getElementById("candidate_document_type");

    if (!dropzoneElement || !typeElement || typeof Dropzone === "undefined") {
        return;
    }

    var shouldReload = false;

    new Dropzone("#candidate_document_dropzone", {
        url: dropzoneElement.dataset.uploadUrl,
        paramName: "file",
        headers: {
            "X-CSRF-TOKEN": dropzoneElement.dataset.csrfToken,
            "Accept": "application/json"
        },
        acceptedFiles: ".pdf,.doc,.docx,.jpg,.jpeg,.png",
        maxFilesize: 5,
        addRemoveLinks: true,
        uploadMultiple: false,
        accept: function (file, done) {
            if (!typeElement.value) {
                done("Please select a document type before uploading.");
                return;
            }

            done();
        },
        init: function () {
            this.on("sending", function (file, xhr, formData) {
                formData.append("type", typeElement.value);
            });

            this.on("success", function () {
                shouldReload = true;
            });

            this.on("queuecomplete", function () {
                if (shouldReload) {
                    window.location.reload();
                }
            });

            this.on("error", function (file, message) {
                var resolvedMessage = message;

                if (typeof message === "object" && message !== null && message.errors) {
                    var firstKey = Object.keys(message.errors)[0];
                    if (firstKey && Array.isArray(message.errors[firstKey])) {
                        resolvedMessage = message.errors[firstKey][0];
                    }
                }

                if (typeof resolvedMessage === "string" && resolvedMessage.length > 0) {
                    window.alert(resolvedMessage);
                }
            });
        }
    });
})();
