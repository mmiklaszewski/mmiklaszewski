$(document).ready(function() {
    $('#save-opinion').submit(function(e) {
        e.preventDefault();
        submitForm();
    });
});

$("button[type=submit]").click(function() {
    $("button[type=submit]").removeAttr("clicked");
    $(this).attr("clicked", "true");
});


function checkFieldsAndInput() {
    var field = document.getElementById('opinion');

    var isOpinionValid = checkInput('opinion', 1, 400);

    var submit = $('#save');

    if (field.value.trim() !== '' && isOpinionValid) {
        submit.prop('disabled', false);
    } else {
        submit.prop('disabled', true);
    }
}

function submitForm() {
    var opinion =  $('#opinion');

    var formData = {
        'opinion': opinion.val(),
        'movie': $('#movie').val()
    };

    $.ajax({
        type: 'POST',
        url:  $('#save-opinion').attr('action'),
        data: formData,
        dataType: 'json',
        encode: true,
        beforeSend: function() {
            opinion.prop('disabled', true);

            $('#save').append(' <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>')
        }
    })
        .done(function(data) {
            opinion.prop('disabled', false);

            var button = $('#save');
            var spanElement = button.find('span')
            if (spanElement.length > 0) {
                spanElement.remove();
            }

            window.location.href = data.resultUrl;
        })
        .fail(function(error) {
            $('#opinion').prop('disabled', false);
            $('#save').prop('disabled', false);

        });
}