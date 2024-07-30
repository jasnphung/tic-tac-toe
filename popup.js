$(document).ready(function() {
    var $form = $('#updateProfileForm');

    $('#updateProfileButton').click(function() {
        $('#popup').show(); // Show the popup
    });

    $form.on('submit', function(event) {
        event.preventDefault(); // Prevent default form submission

        $.ajax({
            url: 'update_profile.php', // URL to your PHP script
            type: 'POST',
            data: $form.serialize(), // Serialize form data
            dataType: 'json', // Expect JSON response
            success: function(response) {
                if (response.success) {
                    $form[0].reset(); // Reset the form if update was successful
                    $('#popup').hide(); // Hide the popup
                    alert(response.message); // Display success message
                } else {
                    alert(response.error_message); // Display error message
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', status, error); // Log AJAX errors
            }
        });
    });

    $('.popup .close').click(function() {
        $('#popup').hide(); // Hide the popup when close button is clicked
    });

    $(window).click(function(event) {
        if ($(event.target).is('#popup')) {
            $('#popup').hide(); // Hide popup on outside click
        }
    });
});
