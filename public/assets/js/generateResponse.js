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

function checkFieldsAndInput() {
    var titleField = document.getElementById('title');
    var preferencesField = document.getElementById('preferences');

    var searchMovieButton = $('#search_movie');
    var searchSeriesButton = $('#search_series');

    var isTitleValid = checkInput('title', 1, 100);
    var isPreferencesValid = checkInput('preferences', 1, 300);

    if (titleField.value.trim() !== '' && preferencesField.value.trim() !== '' && isTitleValid && isPreferencesValid) {
        searchMovieButton.prop('disabled', false);
        searchSeriesButton.prop('disabled', false);
    } else {
        searchMovieButton.prop('disabled', true);
        searchSeriesButton.prop('disabled', true);
    }
}

function checkInput(id, min, max) {
    var element = document.getElementById(id);
    var isValid = element.value.length >= min && element.value.length <= max;

    if (isValid) {
        element.classList.add("is-valid");
        element.classList.remove("is-invalid");
    } else {
        element.classList.remove("is-valid");
        element.classList.add("is-invalid");
    }

    return isValid;
}

function submitForm(clickedButtonValue) {
    var formData = {
        'title': $('#title').val(),
        'category': clickedButtonValue,
        'preferences': $('#preferences').val(),
    };

    $.ajax({
        type: 'POST',
        url:  $('#generate-response').attr('action'),
        data: formData,
        dataType: 'json',
        encode: true,
        beforeSend: function() {
            $('#title').prop('disabled', true);
            $('#preferences').prop('disabled', true);
            $('#search_movie').prop('disabled', true);
            $('#search_series').prop('disabled', true);
            $('#search_'+clickedButtonValue).append(' <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>')
        }
    })
        .done(function(data) {
            window.location.href = data.resultUrl;
        })
        .fail(function(error) {
            $('#title').prop('disabled', false);
            $('#search_movie').prop('disabled', false);
            $('#search_series').prop('disabled', false);
        });
}