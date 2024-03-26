$(document).ready(function () {
    $(document).on('click', '#rejectPayment', function () {
        if ($(this).closest('#rejectPaymentModal').find('#rejectNote').val() == '') {
            $(this).closest('#rejectPaymentModal').find('#rejectNote').addClass('is-invalid')
            return false;
        }
        $('#update-status-payment-reject').append($(this).closest('#rejectPaymentModal').find('#rejectNote').clone().removeAttr('id'))
        $('#update-status-payment-reject').submit()
        $(this).prop('disabled',true);
        $(this).closest('#rejectPaymentModal').modal('hide');
    })

    $(document).on('click', '#approvePayment', function () {
        if ($(this).closest('#approvePaymentModal').find('#approveNote').val() == '') {
            $(this).closest('#approvePaymentModal').find('#approveNote').addClass('is-invalid')
            return false;
        }
        $('#update-status-payment').append($(this).closest('#approvePaymentModal').find('#approveNote').clone().removeAttr('id'))
        $('#update-status-payment').submit()
        $(this).prop('disabled',true);
        $(this).closest('#approvePaymentModal').modal('hide');
    })

    $(document).on('focus', '#approveNote, #rejectNote', function () {
        $(this).removeClass('is-invalid');
    })
})
