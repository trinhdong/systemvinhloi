$(document).ready(function () {
    $(document).on('click', '#rejectPayment', function () {
        // if ($(this).closest('#rejectPaymentModal').find('#rejectNote').val() == '') {
        //     $(this).closest('#rejectPaymentModal').find('#rejectNote').addClass('is-invalid')
        //     return false;
        // }
        $('#update-status-payment-reject').append($(this).closest('#rejectPaymentModal').find('#rejectNote').clone().removeAttr('id'))
        $('#update-status-payment-reject').submit()
        $(this).prop('disabled',true);
        $(this).closest('#rejectPaymentModal').modal('hide');
    })

    $(document).on('click', '#approvePayment', function () {
        // if ($(this).closest('#approvePaymentModal').find('#approveNote').val() == '') {
        //     $(this).closest('#approvePaymentModal').find('#approveNote').addClass('is-invalid')
        //     return false;
        // }
        if ($('#paid').length > 0 && isNaN(parseFloat($('#paid').val().replace(/,/g, '')))) {
            $(this).closest('#approvePaymentModal').modal('hide');
            $('#paid').addClass('is-invalid')
            Lobibox.notify('error', {
                title: 'Lỗi',
                pauseDelayOnHover: true,
                continueDelayOnInactiveTab: false,
                position: 'top right',
                icon: 'bx bx-x-circle',
                msg: "Vui lòng nhập số tiền đã thanh toán"
            });
            return false;
        }
        $('#update-status-payment').append($(this).closest('#approvePaymentModal').find('#approveNote').clone().removeAttr('id'))
        $('#update-status-payment').append($('#paid').clone().removeAttr('id'))
        $('#update-status-payment').submit()
        $(this).prop('disabled',true);
        $(this).closest('#approvePaymentModal').modal('hide');
    })

    $(document).on('focus', '#approveNote, #rejectNote, #paid', function () {
        $(this).removeClass('is-invalid');
    })

    $(document).on('blur', '#paid', function () {
        const orderTotal = parseFloat($('#order-total').text().replace('₫', '').replace(/,/g, ''));
        const paid = parseFloat($(this).val().replace(/,/g, ''));
        if (!isNaN(paid) && !isNaN(orderTotal)) {
            $('#remaining').text(new Intl.NumberFormat("en", {
                maximumFractionDigits: 0,
                minimumFractionDigits: 0,
            }).format(Math.max(orderTotal - paid, 0))+'₫')
        }
    })
    $(document).on('input', '#paid', function (event) {
        $(this).formatCurrency({
            'symbol': '',
            'decimalSymbol': '',
            'digitGroupSymbol': ','
        });
    })
})
