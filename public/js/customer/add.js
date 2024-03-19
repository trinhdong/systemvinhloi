$(document).ready(function () {
    $(document).on('change', '.category', function (event) {
        event.preventDefault();
        const categoryId = $(this).val();
        const $product = $(this).closest('tr').find('.product');
        $(this).closest('tr').find('.product').empty().append('<option selected="" disabled="" value="">Chọn...</option>');
        $(this).closest('tr').find('.price').text('0');
        $(this).closest('tr').find('.priceDiscount').text('0');
        const productIdNotIn = getAllSelectedProduct();
        const productIds = $(this).closest('tbody').find('input[type="hidden"][name="product_id[]"]').map(function () {
            return $(this).val();
        }).get();
        productIdNotIn.push(...(productIds || []));
        $.ajax({
            url: 'product/getByCategoryId',
            type: 'GET',
            data: {categoryId: categoryId, productIdNotIn: productIdNotIn},
            success: function (products) {
                $.each(products, function (index, product) {
                    $product.append($(`<option data-price="${product.price}"></option>`).val(product.id).text(product.product_name));
                });
            },
            error: function (xhr) {
                console.log('Error:', xhr.responseText);
            }
        });
    });

    $(document).on('change', '.product', function (event) {
        const productSelectedOption = $(this).find('option:selected');
        const price = productSelectedOption.data('price');
        if (!isNaN(price)) {
            const formattedPrice = new Intl.NumberFormat("en", {
                maximumFractionDigits: 0,
                minimumFractionDigits: 0,
            }).format(price);
            const $price = $(this).closest('tr').find('.price');
            const $priceDiscount = $(this).closest('tr').find('.priceDiscount');
            const $discountPercent = $(this).closest('tr').find('.discountPercent');
            const discountPercent = parseFloat($discountPercent.val());
            if (!isNaN(discountPercent)) {
                $priceDiscount.text(new Intl.NumberFormat("en", {
                    maximumFractionDigits: 0,
                    minimumFractionDigits: 0,
                }).format(Math.max(price - (discountPercent * price) / 100, 0)))
            } else {
                $priceDiscount.text(formattedPrice);
            }
            $price.text(formattedPrice);
        }
        updateProductSelect(productSelectedOption);
    });
    $(document).on('keyup', '.discountPercent', function (event) {
        let discountPercent = $(this).val();
        if (isNaN($(this).val()) || [".."].includes(event.key)) {
            $(this).val('');
            return false;
        }
        let number = ($(this).val().split('.'));
        let intPart = number[0];
        let decPart = number[1];

        if (intPart !== undefined && intPart.length > 3) {
            $(this).val('');
            return false;
        }
        discountPercent = parseFloat($(this).val());
        if (discountPercent <= 0) {
            $(this).val('');
        }
        if (discountPercent > 100) {
            $(this).val('');
        }
        if (decPart !== undefined && decPart.length > 2) {
            $(this).val(discountPercent.toFixed(2));
        }
    });
    $(document).on('blur', '.discountPercent', function (event) {
        const $price = $(this).closest('tr').find('.price');
        const $priceDiscount = $(this).closest('tr').find('.priceDiscount');
        const price = parseFloat($price.text().replace(/,/g, ''));
        const discountPercent = parseFloat($(this).val());
        if (isNaN(discountPercent)) {
            $priceDiscount.text('0');
            return false;
        }
        $priceDiscount.text(new Intl.NumberFormat("en", {
            maximumFractionDigits: 0,
            minimumFractionDigits: 0,
        }).format(Math.max(price - (discountPercent * price) / 100, 0)))
    });

    $(document).on('click', '.btn-clone-row', function () {
        const newRow = $('.discount-row').first().clone();
        newRow.find('input[type="text"]').val('');
        newRow.find('.product').empty().append('<option selected="" disabled="" value="">Chọn...</option>');
        newRow.find('.price').text('0');
        newRow.find('.priceDiscount').text('0');
        newRow.find('.category, .product, input[name="discount_percent[]"]').removeClass('is-invalid');
        newRow.insertAfter($('.discount-row').first());
    });

    $(document).on('click', '.btn-remove-row', function () {
        if ($('select.category').length == 1) {
            $(this).closest('tr').find('input[type="text"], select').val('');
            $(this).closest('tr').find('.price, .priceDiscount').text('0');
            return false;
        }
        updateProductSelect($(this).closest('tr').find('.product option:selected'), true);
        $(this).closest('tr').remove();
    });

    $(document).on('submit','form', function () {
        let isValid = true;
        if ($('input[name="customer_name"]').val() == '') {
            $('input[name="customer_name"]').addClass('is-invalid')
            isValid = false;
        }
        if ($('select[name="area_id"]').val() == null) {
            $('select[name="area_id"]').addClass('is-invalid')
            isValid = false;
        }
        $('.discount-row').each(function () {
            if ($(this).find('.category').val() == null
                && $(this).find('.product').val() == null
                && $(this).find('input[name="discount_percent[]"]').val() == ''
            ) {
                return;
            }
            if ($(this).find('.category').length > 0 && $(this).find('.category').val() == null) {
                $(this).find('.category').addClass('is-invalid')
                isValid = false;
            }
            if ($(this).find('.product').length > 0 && $(this).find('.product').val() == null) {
                $(this).find('.product').addClass('is-invalid')
                isValid = false;
            }
            if ($(this).find('input[name="discount_percent[]"]').val() == '') {
                $(this).find('input[name="discount_percent[]"]').addClass('is-invalid')
                isValid = false;
            }
        })
        if (!isValid) {
            return false;
        }
        $(this).submit();
    });
    $(document).on('focus', 'input[name="customer_name"], select[name="area_id"], .discount-row .category, .product, input[name="discount_percent[]"]', function () {
        $(this).removeClass('is-invalid');
    })
});

function getAllSelectedProduct() {
    return $('.product option:selected')
        .filter((index, option) => option.value != '' && option.value != '0')
        .map((index, option) => option.value)
        .get();
}

function updateProductSelect(productSelectedOption, remove = false) {
    $('.product').each(function () {
        const $product = $(this);
        const $category = $(this).closest('tr').find('.category');
        const $categoryId = $category.val();
        const $productOnChange = productSelectedOption.closest('select');
        const $categoryIdOnChange = productSelectedOption.closest('tr').find('.category').val();
        if (!$categoryId || $categoryId !== $categoryIdOnChange || $product.val() == $productOnChange.val()) {
            return;
        }
        const productIds = $product.find('option').map(function () {
            return $(this).val();
        }).get()

        if (remove) {
            if (!productIds.includes(productSelectedOption.val())) {
                $product.append(productSelectedOption.clone());
                return;
            }
            return false;
        }
        $product.find('option').each(function () {
            if (!$(this).is(':selected') && $(this).val() === productSelectedOption.val()) {
                $(this).remove();
            }
        });

        $productOnChange.find('option').each(function () {
            if (!$(this).is(':selected') && !productIds.includes($(this).val())) {
                $product.append($(this).clone());
            }
        })
    });
}
