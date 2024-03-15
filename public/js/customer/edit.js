$(document).ready(function () {
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
                    $(`#discount${discountId}`).remove();
                }
            },
            error: function (xhr, status, error) {
                console.error('Error deleting data:', error);
            }
        });

        $('#deleteDiscountModal').modal('hide');
    });

    $('form').on('submit', function () {
        const $firstRow = $('.discount-row').first();
        let isValid = true;
        if ($firstRow.find('.category').val() == null
            && $firstRow.find('.product').val() == null
            && $firstRow.find('input[name="discount_percent[]"]').val() == ''
        ) {
            $(this).submit();
        }
        if ($firstRow.find('.category').val() == null) {
            $firstRow.find('.category').addClass('is-invalid')
            isValid = false;
        }
        if ($firstRow.find('.product').val() == null) {
            $firstRow.find('.product').addClass('is-invalid')
            isValid = false;
        }
        if ($firstRow.find('input[name="discount_percent[]"]').val() == '') {
            $firstRow.find('input[name="discount_percent[]"]').addClass('is-invalid')
            isValid = false;
        }
        if (!isValid) {
            return false;
        }
    });

    $(document).on('click', '.btn-clone-row-edit', function () {
        const newRow = $('.discount-row').first().clone();
        newRow.find('input[type="text"]').attr('required', 'required').val('');
        newRow.find('.product').empty().append('<option selected="" disabled="" value="">Chọn...</option>');
        newRow.find('.product').attr('required', 'required')
        newRow.find('.category').attr('required', 'required')
        newRow.find('.price').text('0');
        newRow.find('.priceDiscount').text('0');
        newRow.find('.category, .product, input[name="discount_percent[]"]').removeClass('is-invalid');
        newRow.insertAfter($('.discount-row').first());
    });

    $(document).on('click', '.btn-remove-row-edit', function () {
        if ($('select.category').length == 1) {
            $(this).closest('tr').find('input[type="text"], select').val('');
            $(this).closest('tr').find('.price, .priceDiscount').text('0');
            return false;
        }
        updateProductSelect($(this).closest('tr').find('.product option:selected'), true);
        $(this).closest('tr').remove();
        $('.discount-row').first().find('.category, .product, input[name="discount_percent[]"]').removeAttr('required');
    });

    $('.discount-row').first().find('.category, .product, input[name="discount_percent[]"]').on('focus', function () {
        $(this).removeClass('is-invalid');
    })
});
