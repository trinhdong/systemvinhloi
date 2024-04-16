$(document).ready(function () {
    $('#approvePaymentModal').on('show.bs.modal', function (event) {
        const button = $(event.relatedTarget);
        const orderId = button.data('order-id');
        $('#approvePayment').attr('data-order-id', orderId);
    });
    $(document).on('click', '#approvePayment', function () {
        const orderId = $(this).data('order-id');
        $(`#update-status-payment${orderId}`).append($(this).closest('#approvePaymentModal').find('#approveNote').clone().removeAttr('id'))
        $(`#update-status-payment${orderId}`).submit()
        $(this).prop('disabled', true);
        $(this).closest('#approvePaymentModal').modal('hide');
    })
})
