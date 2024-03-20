$(document).ready(function () {
    $('#deleteProductModal').on('show.bs.modal', function (event) {
        const button = $(event.relatedTarget);
        const productId = button.data('product-id');
        $('#deleteProduct').attr('data-product-id', productId);
    });

    $('#deleteProduct').on('click', function () {
        const productId = $(this).data('product-id');
        $(`#formDeleteProduct${productId}`).submit();
        $('#deleteProductModal').modal('hide');
    });

    $('#category').select2({
        placeholder: "Chọn danh mục",
        allowClear: true // This option will allow the user to remove the selected option
    });
});
