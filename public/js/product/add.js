$(document).ready(function () {
    $('#category').select2({
        placeholder: "Chọn danh mục",
        allowClear: true,
        theme: "bootstrap4",
    });
    $('#image_url').change(function(event) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#imagePreview').attr('src', e.target.result).show();
        }
        reader.readAsDataURL(event.target.files[0]);
    });
});
