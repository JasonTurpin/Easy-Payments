$(document).ready(function() {
    // Add input errors
    if (typeof errorInputs !== 'undefined' && $.isArray(errorInputs)) {
        // Loop over error inputs, and add error classes
        $.each(errorInputs, function(dontCare, val) {
            $('[name="' + val + '"]').closest('.form-group').addClass('has-error');
        });
    }

    // Removes all error classes
    $('.has-error :text').on('keydown', function() {
        $(this).closest('.form-group').removeClass('has-error');
    });

    // Removes error class on radio button click
    $('.has-error :radio').on('click', function() {
        $(this).closest('.form-group').removeClass('has-error');
    });

    // Remove error classes on select boxes on change
    $('.has-error select').on('change', function() {
        $(this).closest('.form-group').removeClass('has-error');
    });

    // Removes leading and trailing whitespace
    $('.trimWhitespace').on('blur', function() {
        var value = $(this).val();
        value = value.replace(/^\s\s*/, '').replace(/\s\s*$/, '');
        $(this).val(value);
    });
});
