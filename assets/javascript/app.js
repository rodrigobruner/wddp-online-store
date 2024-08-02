
$(document).ready(function() {
    $("#createUser").on('submit', function(e) {
        e.preventDefault();

        var formData = new FormData(this);
        $.ajax({
            type: "POST",
            url: '/New',
            data: Object.fromEntries(formData.entries()),
            dataType: 'json',
            success: function(response) {
                if (response.status == "error") {
                    $('#formError').html("<span class='fa fa-warning'></span> <b>Error(s):</b><br><br>"+response.msg);
                    $('#formError').fadeIn(1000);
                } else {
                    $('#createUser').fadeOut();
                    $('#formError').fadeOut();
                    $('#formResult').html("<span class='fa fa-check'></span> "+response.msg);
                    $('#formResult').fadeIn(1000);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log("Raw response: ", jqXHR.responseText);
                $('#formResult').html("An error occurred: " + textStatus);
            }
        });
    });
});
