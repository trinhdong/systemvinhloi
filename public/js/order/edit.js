$(document).ready(function () {
    $('#deleteOrderDetailModal').on('show.bs.modal', function (event) {
        const button = $(event.relatedTarget);
        const orderDetailId = button.data('order-detail-id');
        $('#deleteOrderDetail').attr('data-order-detail-id', orderDetailId);
    });

    $('#deleteOrderDetail').on('click', function () {
        const orderDetailId = $(this).data('order-detail-id');
        $.ajax({
            url: '/order/delete-order-detail/' + orderDetailId,
            type: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': $('input[name="_token"]').val()
            },
            success: function (response) {
                if (response.success) {
                    Lobibox.notify('success', {
                        title: 'Thành công',
                        pauseDelayOnHover: true,
                        continueDelayOnInactiveTab: false,
                        position: 'top right',
                        icon: 'bx bx-check-circle',
                        msg: "Xóa thành công"
                    });
                    $(`#orderDetail${orderDetailId}`).remove();
                }
            },
            error: function (xhr, status, error) {
                Lobibox.notify('error', {
                    title: 'Lỗi',
                    pauseDelayOnHover: true,
                    continueDelayOnInactiveTab: false,
                    position: 'top right',
                    icon: 'bx bx-x-circle',
                    msg: "Xóa thất bại"
                });
                console.error('Error deleting data:', error);
            }
        });

        $('#deleteOrderDetailModal').modal('hide');
    });
});
