$(document).ready(function() {
    $('#generate-response').submit(function(e) {
        e.preventDefault();
        var clickedButtonValue = $("button[type=submit][clicked=true]").val();
        submitForm(clickedButtonValue);
    });
});

$("button[type=submit]").click(function() {
    $("button[type=submit]").removeAttr("clicked");
    $(this).attr("clicked", "true");
});

function submitForm(clickedButtonValue) {


    var formData = {
        'title': $('#title').val(),
        'category': clickedButtonValue
    };


    $.ajax({
        type: 'POST',
        url:  $('#generate-response').attr('action'),
        data: formData,
        dataType: 'json',
        encode: true,
        beforeSend: function() {
            $('#title').prop('disabled', true);
            $('#search_movie').prop('disabled', true);
            $('#search_series').prop('disabled', true);
        }
    })
        .done(function(data) {
            console.log(data);
            window.location.href = data.resultUrl;

        })
        .fail(function(error) {
            $('#title').prop('disabled', false);
            $('#search_movie').prop('disabled', false);
            $('#search_series').prop('disabled', false);
        });
}