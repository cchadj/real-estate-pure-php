$(function() {
    $('#citySelect')
        .on("change", function() {
            const selectedCity = $(this).val();
            console.log("Selected City")
            console.log(selectedCity)
            const areaSelect = $('#areaSelect');

            const url= new URL("/api/areas", location);
            url.searchParams.set("city", selectedCity);

            $.ajax({
                url: url.toString(),
                method: "GET",
                success: function(response) {
                    /** @var {{id: string, city: string , name: string }[]} areas */
                    const areas = JSON.parse(response).data;
                    areaSelect.empty();
                    // areaSelect.append('<option value="">Select Area</option>');
                    areas.forEach(({id, name}) => {
                        areaSelect.append(`<option value="${id}">${name}</option>`);
                        console.log(id, name)
                    })
                },
                error: function (response) {
                    console.log(response)
                }
            });
    });
});