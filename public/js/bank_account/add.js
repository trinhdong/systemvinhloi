$(document).on('submit', 'form', function () {
    let isValid = true;
    if ($('input[name="bank_name"]').val() == '') {
        $('input[name="bank_name"]').addClass('is-invalid')
        isValid = false;
    }
    if ($('input[name="bank_code"]').val() == '') {
        $('input[name="bank_code"]').addClass('is-invalid')
        isValid = false;
    }
    if ($('input[name="bank_account_name"]').val() == '') {
        $('input[name="bank_account_name"]').addClass('is-invalid')
        isValid = false;
    }
    if (!isValid) {
        return false;
    }
    $(this).find('button[type="submit"]').prop('disabled',true);
    $(this).submit();
})
$(document).on('focus', 'input[name="bank_name"], input[name="bank_code"], input[name="bank_account_name"]', function () {
    $(this).removeClass('is-invalid');
})
