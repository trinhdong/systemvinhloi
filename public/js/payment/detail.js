$(document).ready(function () {
    $(document).on('click', '#rejectPayment', function () {
        if ($(this).closest('#rejectPaymentModal').find('#rejectNote').val() == '') {
            $(this).closest('#rejectPaymentModal').find('#rejectNote').addClass('is-invalid');
            return false;
        }
        $('#update-status-payment-reject').append($(this).closest('#rejectPaymentModal').find('#rejectNote').clone().removeAttr('id'))
        $('#update-status-payment-reject').submit()
        $(this).prop('disabled',true);
        $(this).closest('#rejectPaymentModal').modal('hide');
    })
    $(document).on('click', '#updatePayment', function () {
        if (isEdit || $isEditDeposit) {
            if (($('#payment-method').length > 0 || $('#payment-method2').length > 0) && $('select[name="payment_method"]').val() == '') {
                $('select[name="payment_method"]').addClass('is-invalid');
                Lobibox.notify('error', {
                    title: 'Lỗi',
                    pauseDelayOnHover: true,
                    continueDelayOnInactiveTab: false,
                    position: 'top right',
                    icon: 'bx bx-x-circle',
                    msg: "Vui lòng nhập phương thức thanh toán"
                });
                $(this).closest('#updatePaymentModal').modal('hide');
                return false;
            }
            if (isTranfer || ($('#payment-method').length > 0 || $('#payment-method2').length > 0) && $('select[name="payment_method"]').val() == 1) {
                let $isValid = true;
                if ($('input[name="bank_name"]').val() == '') {
                    $('input[name="bank_name"]').addClass('is-invalid');
                    $isValid = false;
                }
                if ($('input[name="bank_code"]').val() == '') {
                    $('input[name="bank_code"]').addClass('is-invalid');
                    $isValid = false;
                }
                if ($('input[name="bank_customer_name"]').val() == '') {
                    $('input[name="bank_customer_name"]').addClass('is-invalid');
                    $isValid = false;
                }
                if ($('select[name="bank_account_id"]').val() == '') {
                    $('select[name="bank_account_id"]').addClass('is-invalid');
                    $isValid = false;
                }
                if (!$isValid) {
                    Lobibox.notify('error', {
                        title: 'Lỗi',
                        pauseDelayOnHover: true,
                        continueDelayOnInactiveTab: false,
                        position: 'top right',
                        icon: 'bx bx-x-circle',
                        msg: "Vui lòng nhập đầy đủ thông tin tài khoản ngân hàng"
                    });
                    $(this).closest('#updatePaymentModal').modal('hide');
                    return false;
                }
            }

            if ($('input#paid').length > 0 && isNaN(parseFloat($('#paid').val().replace(/,/g, ''))) || $('#datepicker').val() == '') {
                $(this).closest('#updatePaymentModal').modal('hide');
                $($('#datepicker').val() == '' ? '#datepicker' : '#paid').addClass('is-invalid')
                Lobibox.notify('error', {
                    title: 'Lỗi',
                    pauseDelayOnHover: true,
                    continueDelayOnInactiveTab: false,
                    position: 'top right',
                    icon: 'bx bx-x-circle',
                    msg: $('#datepicker').val() == '' ? "Vui lòng nhập ngày thanh toán" : "Vui lòng nhập số tiền đã thanh toán"
                });
                return false;
            }
            if ($('#paidRemaining').length > 0 && isNaN(parseFloat($('#paidRemaining').val().replace(/,/g, ''))) || $('#datepicker').val() == '') {
                $(this).closest('#updatePaymentModal').modal('hide');
                $($('#datepicker').val() == '' ? '#datepicker' : '#paidRemaining').addClass('is-invalid')
                Lobibox.notify('error', {
                    title: 'Lỗi',
                    pauseDelayOnHover: true,
                    continueDelayOnInactiveTab: false,
                    position: 'top right',
                    icon: 'bx bx-x-circle',
                    msg: $('#datepicker').val() == '' ? "Vui lòng nhập ngày thanh toán" : "Vui lòng nhập số tiền còn lại đã thanh toán"
                });
                return false;
            }
            if ($('#payment-method').length > 0) {
                $('#update-payment').append($('select[name="payment_method"]').clone().removeAttr('id').val($('select[name="payment_method"]').val()))
            }
            if ($('#payment-method2').length > 0) {
                $('#update-payment').append($('select[name="payment_method"]').clone().removeAttr('id').val($('select[name="payment_method"]').val()))
            }
            if (isTranfer || (($('#payment-method').length > 0 || $('#payment-method2').length > 0) && $('select[name="payment_method"]').val() == 1)) {
                $('#update-payment').append($('input[name="bank_name"]').clone().removeAttr('id'))
                $('#update-payment').append($('input[name="bank_code"]').clone().removeAttr('id'))
                $('#update-payment').append($('input[name="bank_customer_name"]').clone().removeAttr('id'))
                $('#update-payment').append($('select[name="bank_account_id"]').clone().removeAttr('id').val($('select[name="bank_account_id"]').val()))
            }
            $('#update-payment').append($('#paidRemaining').clone().removeAttr('id'))
            $('#update-payment').append($('#paid').clone().removeAttr('id'))
            $('#update-payment').append($('#datepicker').clone().removeAttr('id'))
            $('#update-payment').append($(this).closest('#updatePaymentModal').find('#updateNote').clone().removeAttr('id'))
        }
        let $selectPrintRed = $('#has-print-red-invoice').clone().val($('#has-print-red-invoice').val());
        $('#update-payment').append($selectPrintRed.removeAttr('id'))
        $('#update-payment').submit()
        $('#update-payment').find('input#paid, #paidRemaining, #datepicker, input[name="bank_name"], input[name="bank_code"], input[name="bank_customer_name"], select[name="bank_account_id"]').remove()
        $(this).prop('disabled',true);
        $(this).closest('#updatePaymentModal').modal('hide');
    })

    $(document).on('click', '#approvePayment', function () {
        // if ($(this).closest('#approvePaymentModal').find('#approveNote').val() == '') {
        //     $(this).closest('#approvePaymentModal').find('#approveNote').addClass('is-invalid')
        //     return false;
        // }
        $('#update-status-payment').append($(this).closest('#approvePaymentModal').find('#approveNote').clone().removeAttr('id'))
        $('#update-status-payment').submit()
        $(this).prop('disabled',true);
        $(this).closest('#approvePaymentModal').modal('hide');
    })

    $(document).on('focus', '#approveNote, #rejectNote, #paid, #paidRemaining, input[name="bank_code"], input[name="bank_name"], input[name="bank_customer_name"], select[name="bank_account_id"]', function () {
        $(this).removeClass('is-invalid');
    })
    $(document).on('change', '#datepicker', function () {
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
    $(document).on('input', '#paidRemaining', function (event) {
        if ($(this).val() === '') {
            $(this).val('0')
        }
        $(this).formatCurrency({
            'symbol': '',
            'decimalSymbol': '',
            'digitGroupSymbol': ','
        });
    })
    $(document).on('blur', '#paidRemaining', function () {
        const orderTotal = parseFloat($('#order-total').text().replace('₫', '').replace(/,/g, ''));
        const deposit = parseFloat($('#deposit').text().replace('₫', '').replace(/,/g, ''));
        const paidRemaining = parseFloat($(this).val().replace(/,/g, ''));
        if (!isNaN(paidRemaining) && !isNaN(deposit)) {
            $('#paid').text(new Intl.NumberFormat("en", {
                maximumFractionDigits: 0,
                minimumFractionDigits: 0,
            }).format(deposit + paidRemaining, 0)+'₫')
        }
        if (!isNaN(orderTotal)) {
            $('#remaining').text(new Intl.NumberFormat("en", {
                maximumFractionDigits: 0,
                minimumFractionDigits: 0,
            }).format(Math.max(orderTotal - (deposit + paidRemaining), 0))+'₫')
        }
    })
    $(document).on('change', '#bank-account', function () {
        const bankAccountId = $(this).val();
        $.ajax({
            url: '/payment/getBankAccountById/'+parseInt(bankAccountId),
            type: 'GET',
            success: function (bankAccount) {
                if ($.isEmptyObject(bankAccount)) {
                    $('#bank-account-info').addClass('d-none');
                    return false
                }
                $('#bank-account-info').removeClass('d-none');
                $('#bank-account-info').find('#bank-name').text(bankAccount.bank_name || '');
                $('#bank-account-info').find('#bank-code').text(bankAccount.bank_code || '');
                $('#bank-account-info').find('#bank-account-name').text(bankAccount.bank_account_name || '');
                if (bankAccount.bank_branch === null) {
                    $('#bank-account-info').find('#bank-branch').text('').closest('div').addClass('d-none');
                } else {
                    $('#bank-account-info').find('#bank-branch').closest('div').removeClass('d-none')
                    $('#bank-account-info').find('#bank-branch').text(bankAccount.bank_branch || '');
                }
            },
            error: function (xhr, status, error) {
                console.error(xhr.responseText);
            }
        })
    });

    $(document).on('change', '#payment-method', function () {
        $(this).removeClass('is-invalid')
        $('#payment-method-info').find('input, select').removeClass('is-invalid')
        if ($(this).val() == 1) {
            $('#payment-method-info').removeClass('d-none')
        } else {
            $('#payment-method-info').addClass('d-none')
        }
    })

    $(document).on('change', '#payment-method2', function () {
        $(this).removeClass('is-invalid')
        $('#payment-method-info2').find('input, select').removeClass('is-invalid')
        if ($(this).val() == 1) {
            $('#payment-method-info2').removeClass('d-none')
        } else {
            $('#payment-method-info2').addClass('d-none')
        }
    })
})
