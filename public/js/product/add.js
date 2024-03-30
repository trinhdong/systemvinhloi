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

    $('#image_url').on('change', function() {
        var fileInput = this;
        var imagePreview = $('#imagePreview');

        if (fileInput.files && fileInput.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                imagePreview.attr('src', e.target.result);
                imagePreview.show();
            }

            reader.readAsDataURL(fileInput.files[0]);
        }
    });

    $(document).on('submit', 'form', function () {
        let isValid = true;
        if ($('input[name="product_code"]').val() == '') {
            $('input[name="product_code"]').addClass('is-invalid')
            isValid = false;
        }
        if ($('input[name="product_name"]').val() == '') {
            $('input[name="product_name"]').addClass('is-invalid')
            isValid = false;
        }
        if ($('input[name="color"]').val() == '') {
            $('input[name="color"]').addClass('is-invalid')
            isValid = false;
        }
        if ($('input[name="capacity"]').val() == '') {
            $('input[name="capacity"]').addClass('is-invalid')
            isValid = false;
        }
        if ($('input[name="unit"]').val() == '') {
            $('input[name="unit"]').addClass('is-invalid')
            isValid = false;
        }
        if ($('input[name="price"]').val() == '') {
            $('input[name="price"]').addClass('is-invalid')
            isValid = false;
        }
        if ($('select[name="category_id"]').val() == '') {
            $('select[name="category_id"]').addClass('is-invalid')
            isValid = false;
        }
        if (!isValid) {
            return false;
        }
        $(this).find('button[type="submit"]').prop('disabled', true);
        $(this).submit();
    });

    $(document).on('change', 'input[name="product_code"], input[name="product_name"], input[name="color"], input[name="capacity"], input[name="unit"], input[name="price"], select[name="category_id"]', function () {
        $(this).removeClass('is-invalid');
    });
});
