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
    var codeElement =  $('#code');

    var formData = {
        'code':codeElement.val(),
    };

    $.ajax({
        type: 'POST',
        url:  $('#set-code').attr('action'),
        data: formData,
        dataType: 'json',
        encode: true,
        beforeSend: function() {
            codeElement.prop('disabled', true);
            codeElement.removeClass("is-invalid");
            $('#codeFeedback').html('')
        }
    })
        .done(function(data) {
            codeElement.prop('disabled', false);
            if (data.errors) {
                for (var key in data.errors) {
                    if (data.errors.hasOwnProperty(key)) {
                        $('#codeFeedback').append('<p>' + data.errors[key] + '</p>');
                    }
                }

                codeElement.removeClass("is-valid");
                codeElement.addClass("is-invalid");

            } else {
                window.location.href = data.resultUrl;
            }
        })
        .fail(function(error) {
            $('#code').prop('disabled', false);
        });
}