$(function () {
    $(".deleteButton").on("click", function (e) {
        e.preventDefault();
        const propertyName = $(this).attr("data-property-name")
        const propertyId = $(this).attr("data-property-id")

        if (confirm(`Are you sure you want to delete property "${propertyName}"`)) {
            const url= new URL("/api/properties", location);
            url.searchParams.set("id", propertyId);

            $.ajax({
                url: url.toString(),
                type: "DELETE",
                processData: false,
                contentType: false,
                success: function () {
                    const rowSelector =`tr#${propertyId}`
                    $(rowSelector).remove();
                    console.log("Removed")
                },
                error: function () {

                },
            });
        }
    })
})
