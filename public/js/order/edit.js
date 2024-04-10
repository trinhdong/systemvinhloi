$(document).ready(function () {
    $('#deleteOrderDetailModal').on('show.bs.modal', function (event) {
        const button = $(event.relatedTarget);
        const orderDetailId = button.data('order-detail-id');
        $('#deleteOrderDetail').attr('data-order-detail-id', orderDetailId);
    });

    $('#deleteOrderDetail').on('click', function () {
        const orderDetailId = $(this).attr('data-order-detail-id');
        $(`#orderDetail${orderDetailId}`).remove();
        $(this).removeAttr('data-order-detail-id', orderDetailId);
        if ($('#orderlist tr.productOrder:not(.d-none)').length === 0) {
            $('#empty-row').removeClass('d-none');
        }
        $('#deleteOrderDetailModal').modal('hide');
        totalOrder()
    });
});
