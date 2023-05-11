$(function () {
    function submitForm(formId, url, handlers, method = "POST") {
        $(formId).on(
            "submit", function (event) {
                event.preventDefault();

                const form = $(this);
                const formData = new FormData(form[0]);
                const fileInput = $('#file')[0]?.files[0] ?? null;
                if (fileInput)
                    formData.append('image', fileInput);

                $.ajax({
                    url,
                    type: method,
                    data: formData,
                    processData: false,
                    contentType: false,
                    ...handlers,
                });
            });
    }

    const handlers = {
        success: function (response) {
            const inputValue = $('input#name').val();
            const message = response.message ?? `Successfully added "${inputValue}"`;
            const banner = $("#banner")
            console.log(message)
            banner.text(message);
            banner.addClass("success");
            banner.removeClass("error");
            banner.removeClass("hidden");
            // $("input[name=name]").val("");
        },
        error: function (response, status, error) {
            const message = JSON.parse(response.responseText).message;
            const banner = $("#banner")
            banner.text(message);
            banner.addClass("error");
            banner.removeClass("success");
            banner.removeClass("hidden");
        }
    }
    submitForm(
        "#citiesCreateForm",
        "/api/cities",
        handlers,
        "POST"
    )
    submitForm(
        "#areasCreateForm",
        "/api/areas",
        handlers,
        "POST"
    )
    submitForm(
        "#propertyTypesCreateForm",
        "/api/property-types",
        handlers,
        "POST"
    )
    submitForm(
        "#propertiesCreateForm",
        "/api/properties",
        handlers,
        "POST"
    )
    submitForm(
        "#propertiesEditForm",
        "/api/properties",
        {
            success: function (response) {
                const inputValue = $('input#name').val();
                const message = response.message ?? `Successfully edited "${inputValue}"`;
                const banner = $("#banner")
                console.log(message)
                banner.text(message);
                banner.addClass("success");
                banner.removeClass("error");
                banner.removeClass("hidden");
                // $("input[name=name]").val("");
            },
            error: function (response, status, error) {
                const message = JSON.parse(response.responseText).message;
                const banner = $("#banner")
                banner.text(message);
                banner.addClass("error");
                banner.removeClass("success");
                banner.removeClass("hidden");
            }
        }
        ,
        "POST",
        // normally this should have been a PUT, but I can't handle multipart request in PHP with PUT.
    )
});
