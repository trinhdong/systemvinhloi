$(document).ready(function () {
    $(function () {
        $('.select-customer').each(function () {
            $(this).select2({
                theme: 'bootstrap4',
                width: '750px',
                placeholder: $(this).attr('placeholder'),
                allowClear: Boolean($(this).data('allow-clear')),
            });
        });
    });
    $('#deleteDiscountModal').on('show.bs.modal', function (event) {
        const button = $(event.relatedTarget);
        const discountId = button.data('discount-id');
        $('#deleteDiscount').attr('data-discount-id', discountId);
    });

    $('#deleteDiscount').on('click', function () {
        const discountId = $(this).data('discount-id');
        $.ajax({
            url: '/customer/delete-discount/' + discountId,
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
                    $(`#discount${discountId}`).remove();
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

        $('#deleteDiscountModal').modal('hide');
    });
});
