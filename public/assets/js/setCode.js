$(document).ready(function() {
    $('#set-code').submit(function(e) {
        e.preventDefault();
        submitForm();
    });
});

function checkFieldsAndInput() {
    var codeField = document.getElementById('code');

    var submit = $('#set-code-submit');

    if (codeField.value.trim() !== '' ) {
        submit.prop('disabled', false);
    } else {
        submit.prop('disabled', true);
    }
}




function submitForm(clickedButtonValue) {
    var formData = {
        'code': $('#code').val(),
    };

    $.ajax({
        type: 'POST',
        url:  $('#set-code').attr('action'),
        data: formData,
        dataType: 'json',
        encode: true,
        beforeSend: function() {}
    })
        .done(function(data) {
            window.location.href = data.resultUrl;
        })
        .fail(function(error) {
            $('#code').prop('disabled', false);
        });
}