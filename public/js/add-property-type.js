$(() => {
    $('#create-property-type-form').on("submit", function (e) {
        e.preventDefault(); // prevent default form submission
        const formData = $(this).serialize(); // serialize form data
        console.log(formData)
        // $.ajax({
        //     url: 'process.php', // PHP script that handles form submission
        //     type: 'POST',
        //     data: formData,
        //     success: function (response) {
        //         $('#result').html(response); // display response in result div
        //     }
        // });
    });
});
