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

    validateForm("#warehouseForm", {
        name: {
            validators: {
                notEmpty: {
                    message: "Please enter the warehouse name",
                },
                stringLength: {
                    min: 2,
                    message: "Name must be at least 2 characters long",
                },
            },
        },
        address: {
            validators: {
                notEmpty: {
                    message: "Please enter the warehouse address",
                },
            },
        },
        city: {
            validators: {
                notEmpty: {
                    message: "Please enter the city",
                },
            },
        },
        state: {
            validators: {
                notEmpty: {
                    message: "Please enter the state",
                },
            },
        },
        zip_code: {
            validators: {
                notEmpty: {
                    message: "Please enter the zip code",
                },
                regexp: {
                    regexp: /^[0-9]{5}$/,
                    message: "Please enter a valid zip code",
                },
            },
        },
        country: {
            validators: {
                notEmpty: {
                    message: "Please enter the country",
                },
            },
        },
        phone: {
            validators: {
                notEmpty: {
                    message: "Please enter the phone number",
                },
                regexp: {
                    regexp: /^[0-9]{10,15}$/,
                    message: "Please enter a valid phone number",
                },
            },
        },
        email: {
            validators: {
                notEmpty: {
                    message: "Please enter the email address",
                },
                emailAddress: {
                    message: "Please enter a valid email address",
                },
            },
        },
        is_active: {
            validators: {
                notEmpty: {
                    message: "Please select the status",
                },
            },
        },
        worker: {
            validators: {
                notEmpty: {
                    message: "Please select the worker",
                },
            },
        },
    });
});
