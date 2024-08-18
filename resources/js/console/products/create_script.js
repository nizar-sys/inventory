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

    validateForm("#productForm", {
        code: {
            validators: {
                notEmpty: {
                    message: "Please enter the product code",
                },
                stringLength: {
                    min: 2,
                    message: "Code must be at least 2 characters long",
                },
            },
        },
        name: {
            validators: {
                notEmpty: {
                    message: "Please enter the product name",
                },
                stringLength: {
                    min: 2,
                    message: "Name must be at least 2 characters long",
                },
            },
        },
        category_id: {
            validators: {
                notEmpty: {
                    message: "Please select a category",
                },
            },
        },
        supplier_id: {
            validators: {
                notEmpty: {
                    message: "Please select a supplier",
                },
            },
        },
        image: {
            validators: {
                notEmpty: {
                    message: "Please upload an image",
                },
                file: {
                    extension: "jpeg,jpg,png",
                    type: "image/jpeg,image/png",
                    maxSize: 2 * 1024 * 1024, // 2 MB
                    message:
                        "Please choose a valid image file (jpeg, jpg, png) with a size of up to 2MB",
                },
            },
        },
    });
});
