$(document).on('submit', 'form', function () {
    let isValid = true;
    if ($('input[name="name"]').val() == '') {
        $('input[name="name"]').addClass('is-invalid')
        isValid = false;
    }
    if ($('input[name="email"]').val() == '') {
        $('input[name="email"]').addClass('is-invalid')
        isValid = false;
    }
    if ($('.has-validation input[name="password"]').val() == '') {
        $('input[name="password"]').addClass('is-invalid')
        isValid = false;
    }
    if ($('select[name="role"]').val() == null) {
        $('select[name="role"]').addClass('is-invalid')
        isValid = false;
    }
    if (!isValid) {
        return false;
    }
    $(this).find('button[type="submit"]').prop('disabled',true);
    $(this).submit();
})
$(document).on('focus', 'input[name="name"], input[name="email"], input[name="password"], select[name="role"]', function () {
    $(this).removeClass('is-invalid');
})
