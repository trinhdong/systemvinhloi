$(document).ready(function () {
    $('#deleteCategoryModal').on('show.bs.modal', function (event) {
        const button = $(event.relatedTarget);
        const categoryId = button.data('category-id');
        $('#deleteCategory').attr('data-category-id', categoryId);
    });

    $('#deleteCategory').on('click', function () {
        const categoryId = $(this).data('category-id');
        $(`#formDeleteCategory${categoryId}`).submit();
        $('#deleteCategoryModal').modal('hide');
    });
});
