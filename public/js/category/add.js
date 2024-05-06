$(document).on('submit', 'form', function () {
    let isValid = true;
    if ($('input[name="category_name"]').val() == '') {
        $('input[name="category_name"]').addClass('is-invalid')
        isValid = false;
    }
    if (!isValid) {
        return false;
    }
    $(this).find('button[type="submit"]').prop('disabled',true);
    $(this).submit();
})
$(document).on('focus', 'input[name="category_name"]', function () {
    $(this).removeClass('is-invalid');
})
