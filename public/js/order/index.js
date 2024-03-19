$(document).ready(function () {
    $('#deleteOrderModal').on('show.bs.modal', function (event) {
        const button = $(event.relatedTarget);
        const orderId = button.data('order-id');
        $('#deleteOrder').attr('data-order-id', orderId);
    });

    $('#deleteOrder').on('click', function () {
        const orderId = $(this).data('order-id');
        $(`#formDeleteOrder${orderId}`).submit();
        $('#deleteOrderModal').modal('hide');
    });
});
