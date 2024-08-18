document.addEventListener("DOMContentLoaded", () => {
    const validateForm = (formSelector, fieldsConfig) => {
        const formElement = document.querySelector(formSelector);
        if (!formElement) return;

        FormValidation.formValidation(formElement, {
            fields: fieldsConfig,
            plugins: {
                trigger: new FormValidation.plugins.Trigger(),
                bootstrap5: new FormValidation.plugins.Bootstrap5({
                    eleValidClass: "",
                    rowSelector: ".form-floating",
                }),
                submitButton: new FormValidation.plugins.SubmitButton(),
                autoFocus: new FormValidation.plugins.AutoFocus(),
            },
            init: (instance) => {
                instance.on("plugins.message.placed", (e) => {
                    if (
                        e.element.parentElement.classList.contains(
                            "input-group"
                        )
                    ) {
                        e.element.parentElement.insertAdjacentElement(
                            "afterend",
                            e.messageElement
                        );
                    }
                });

                instance.on("core.element.validated", (e) => {
                    if (e.valid) {
                        e.element.classList.add("is-valid");
                    }
                });

                instance.on("core.form.valid", () => {
                    formElement.submit();
                });
            },
        });
    };

    validateForm("#supplierForm", {
        branch_id: {
            validators: {
                notEmpty: {
                    message: "Please select a branch",
                },
            },
        },
        name: {
            validators: {
                notEmpty: {
                    message: "Please enter the supplier name",
                },
                stringLength: {
                    min: 2,
                    message: "Name must be at least 2 characters long",
                },
            },
        },
        contact: {
            validators: {
                notEmpty: {
                    message: "Please enter the contact information",
                },
                regexp: {
                    regexp: /^[\w\s]+$/, // Adjust the pattern as needed for contact information
                    message: "Please enter a valid contact information",
                },
            },
        },
        address: {
            validators: {
                notEmpty: {
                    message: "Please enter the address",
                },
                stringLength: {
                    min: 5,
                    message: "Address must be at least 5 characters long",
                },
            },
        },
    });
});
