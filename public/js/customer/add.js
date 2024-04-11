$(document).ready(function () {
    $(document).on('change', '.category', function (event) {
        event.preventDefault();
        const categoryId = $(this).val();
        const $product = $(this).closest('tr').find('.product');
        $(this).closest('tr').find('.product').empty().append('<option selected="" disabled="" value="">Chọn...</option>');
        $(this).closest('tr').find('.price').text('0');
        $(this).closest('tr').find('.priceDiscount').text('0');
        const productIdNotIn = getAllSelectedProduct();
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
        const productSelectedOption = $(this).find('option:selected(not:disabled)');
        const price = productSelectedOption.data('price');
        if (!isNaN(price)) {
            const formattedPrice = new Intl.NumberFormat("en", {
                maximumFractionDigits: 0, minimumFractionDigits: 0,
            }).format(price);
            const $price = $(this).closest('tr').find('.price');
            const $priceDiscount = $(this).closest('tr').find('.priceDiscount');
            const $discountPrice = $(this).closest('tr').find('.discountPrice');
            const discountPrice = parseFloat($discountPrice.val().replace(/,/g, ''));
            if (!isNaN(discountPrice)) {
                $priceDiscount.text(new Intl.NumberFormat("en", {
                    maximumFractionDigits: 0, minimumFractionDigits: 0,
                }).format(Math.max(price - discountPrice, 0)))
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
            $(this).val('0');
            return false;
        }
        discountPercent = parseFloat($(this).val());
        if (discountPercent <= 0) {
            $(this).val('0');
        }
        if (discountPercent > 100) {
            $(this).val('0');
        }
        if (decPart !== undefined && decPart.length > 4) {
            $(this).val(discountPercent.toFixed(4));
        }
    });
    $(document).on('blur', '.discountPercent', function (event) {
        const $price = $(this).closest('tr').find('.price');
        const $priceDiscount = $(this).closest('tr').find('.priceDiscount');
        const $discountPrice = $(this).closest('tr').find('.discountPrice');
        const price = parseFloat($price.text().replace(/,/g, ''));
        const discountPercent = parseFloat($(this).val());
        if ($(this).val() == '') {
            return false;
        }
        if (isNaN(discountPercent)) {
            $priceDiscount.text('0');
            return false;
        }
        $priceDiscount.text(new Intl.NumberFormat("en", {
            maximumFractionDigits: 0, minimumFractionDigits: 0,
        }).format(Math.max(price - (discountPercent * price) / 100, 0)))

        $discountPrice.val(new Intl.NumberFormat("en", {
            maximumFractionDigits: 0, minimumFractionDigits: 0,
        }).format(Math.max(price - $priceDiscount.text().replace(/,/g, ''), 0)))
        if ($discountPrice.val().replace(/,/g, '') > price) {
            $discountPrice.addClass('is-invalid');
            return false;
        }
        $discountPrice.removeClass('is-invalid')
    });

    $(document).on('blur', '.discountPrice', function (event) {
        const $price = $(this).closest('tr').find('.price');
        const $priceDiscount = $(this).closest('tr').find('.priceDiscount');
        const $discountPercent = $(this).closest('tr').find('.discountPercent');
        const price = parseFloat($price.text().replace(/,/g, ''));
        const discountPrice = parseFloat($(this).val().replace(/,/g, ''));
        if ($(this).val() == '') {
            return false;
        }
        if (isNaN(discountPrice)) {
            $priceDiscount.text('0');
            return false;
        }
        if (discountPrice > price) {
            $(this).addClass('is-invalid');
            return false;
        }
        $priceDiscount.text(new Intl.NumberFormat("en", {
            maximumFractionDigits: 0, minimumFractionDigits: 0,
        }).format(Math.max(price - discountPrice, 0)))

        $discountPercent.val(new Intl.NumberFormat("en", {
            maximumFractionDigits: 4, minimumFractionDigits: 0,
        }).format(price == 0 ? 0 :Math.max(discountPrice/price * 100, 0)))
        $discountPercent.removeClass('is-invalid')
    });

    $(document).on('keyup', '.discountPrice', function (event) {
        $(this).formatCurrency({
            'symbol': '',
            'decimalSymbol': '',
            'digitGroupSymbol': ','
        });
    })

    $(document).on('click', '.btn-clone-row', function () {
        appendNewRowDiscount()
    });

    $(document).on('click', '.btn-remove-row', function () {
        if ($('select.category').length == 1) {
            $(this).closest('tr').find('input[type="text"], select').val('');
            $(this).closest('tr').find('.price, .priceDiscount').text('0');
            return false;
        }
        updateProductSelect($(this).closest('tr').find('.product option:selected(not:disabled)'), true);
        $(this).closest('tr').remove();
    });

    $(document).on('submit', 'form', function () {
        let isValid = true;
        if ($('input[name="customer_name"]').val() == '') {
            $('input[name="customer_name"]').addClass('is-invalid')
            isValid = false;
        }
        if ($('select[name="area_id"]').val() == null) {
            $('select[name="area_id"]').addClass('is-invalid')
            isValid = false;
        }
        if ($('input[name="phone"]').val() == '') {
            $('input[name="phone"]').addClass('is-invalid')
            isValid = false;
        }
        if ($('input[name="address"]').val() == '') {
            $('input[name="address"]').addClass('is-invalid')
            isValid = false;
        }
        $('.discount-row').each(function () {
            if ($(this).find('.category').val() == null && $(this).find('.product').val() == null
                && $(this).find('input[name="discount_percent[]"]').val() == ''
                && $(this).find('input[name="discount_price[]"]').val() == ''
                && $(this).find('textarea[name="note[]"]').val() == ''
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
            if ($(this).find('input[name="discount_price[]"]').val() == '') {
                $(this).find('input[name="discount_price[]"]').addClass('is-invalid')
                isValid = false;
            }

            const price = $(this).closest('tr').find('.price').text().replace(/,/g, '');
            const discountPrice = $(this).closest('tr').find('.discountPrice').val().replace(/,/g, '');
            if (parseFloat(discountPrice) > parseFloat(price)) {
                $(this).closest('tr').find('.discountPrice').addClass('is-invalid')
                isValid = false;
            }
        })
        if (!isValid) {
            return false;
        }
        $(this).find('button[type="submit"]').prop('disabled', true);
        $(this).submit();
    });
    $(document).on('focus', 'input[name="customer_name"], input[name="phone"], input[name="address"], select[name="area_id"], .discount-row .category, .product, input[name="discount_percent[]"], input[name="discount_price[]"]', function () {
        $(this).removeClass('is-invalid');
    })

    $("#search_product").autocomplete({
        minLength: 2, delay: 0, source: function (request, response) {
            $.ajax({
                type: "GET",
                url: 'customer/search-product',
                contentType: "application/json; charset=utf-8",
                data: {query: $('#search_product').val(), productIdsNotIn: getAllSelectedProduct()},
                dataType: "json",
                success: function (products) {
                    response($.map(products.data, function (product) {
                        return {
                            value: product.value,
                            id: product.id,
                            product_code: product.product_code,
                            product_name: product.product_name,
                            price: product.price,
                            image_url: product.image_url,
                            color: product.color,
                            category_id: product.category_id,
                            category: product.category
                        };
                    }));
                },
                error: function (xhr, error) {
                    console.error(xhr.responseText);
                }
            });
        }, select: function (event, ui) {
            let $row = $('.discount-row').first();
            if ($row.find('.category').val() != null) {
                $row = appendNewRowDiscount();
            }
            $row.find('.category').val(ui.item.category_id)
            let $productOptions = '';
            $.each(ui.item.category.product, function (index, product) {
                if (getAllSelectedProduct().includes('' + product.id)) {
                    return;
                }
                $productOptions += `<option ${product.id == ui.item.id ? 'selected' : ''} data-price="${product.price}" value="${product.id}">${product.product_name}</option>`;
            });
            $row.find('.product').append($productOptions)
            $row.find('.product').val(ui.item.id)
            $row.find('.product').trigger('change')
            $(this).trigger("blur");
            return false;
        }
    }).focus(function () {
        window.pageIndex = 0;
        $(this).autocomplete("search");
    }).autocomplete("instance")._renderItem = function (ul, product) {
        return $(`<li class="card">`)
            .append(`<div class="mt-0">
                      <div class="d-flex justify-content-center align-items-center">
                        <div class="col-2">
                          <img src="${product.image_url}" alt="" class="card-img">
                        </div>
                        <div class="col-10">
                          <div class="card-body">
                            <strong class="card-title">${product.product_code} - ${product.product_name}</strong>
                            <p class="card-text">Màu: ${product.color}</p>
                          </div>
                        </div>
                      </div>
                    </div>`)
            .appendTo(ul);
    };
});

function getAllSelectedProduct() {
    let productIdNotIn = $('.product option:selected')
        .filter((index, option) => option.value != '' && option.value != '0')
        .map((index, option) => option.value)
        .get();
    let productIds = $('table').find('input[type="hidden"][name="product_id[]"]').map(function () {
        return $(this).val();
    }).get();
    productIdNotIn.push(...(productIds || []));
    return productIdNotIn;
}

function updateProductSelect(productSelectedOption, remove = false) {
    $('.product').each(function () {
        const $product = $(this);
        const $category = $(this).closest('tr').find('.category');
        const $categoryId = $category.val();
        const $productOnChange = productSelectedOption.closest('.product');
        const $categoryIdOnChange = productSelectedOption.closest('tr').find('.category').val();
        if (!$categoryId || $categoryId != $categoryIdOnChange || $product.val() == $productOnChange.val()) {
            return;
        }
        const productIds = $product.find('option').map(function () {
            return $(this).val();
        }).get()

        if (remove) {
            if (!productIds.includes(productSelectedOption.val())) {
                $product.append(productSelectedOption.clone().removeAttr('selected'));
                return;
            }
            return false;
        }
        $product.find('option').each(function () {
            if (!$(this).is(':selected') && $(this).val() == productSelectedOption.val()) {
                $(this).remove();
            }
        });

        $productOnChange.find('option').each(function () {
            if (!$(this).is(':selected') && !productIds.includes($(this).val())) {
                $product.append($(this).clone().removeAttr('selected'));
            }
        })
    });
}

function appendNewRowDiscount() {
    const newRow = $('.discount-row').first().clone();
    newRow.find('input[type="text"]').val('');
    newRow.find('.product').empty().append('<option selected="" disabled="" value="">Chọn...</option>');
    newRow.find('.price').text('0');
    newRow.find('.priceDiscount').text('0');
    newRow.find('input[name="discount_percent[]"').val(0);
    newRow.find('.category, .product, input[name="discount_percent[]"]').removeClass('is-invalid');
    newRow.insertAfter($('.discount-row').first());
    return newRow;
}
