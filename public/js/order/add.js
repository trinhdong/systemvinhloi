
$(document).ready(function () {
    if (typeof isStocker != "undefined" &&  isStocker) {
        $('#editOrder').find('input, button, select, textarea').addClass('disabled').attr('readonly', 'readonly')
        $('#editOrder').find('input:checkbox').attr('onclick', 'return false;')
        $('#editOrder').find('#customer').attr('disabled', 'disabled')
        $('#editOrder').find('.quantity input').removeClass('disabled').removeAttr('readonly')
    }
    $(document).on('submit', 'form', function () {
        let isValid = true;
        if ($('select[name="customer_id"]').val() == null) {
            $('select[name="customer_id"]').addClass('is-invalid')
            isValid = false;
        }
        $('.productOrder').each(function () {
            if ($(this).closest('tr').hasClass('d-none')) {
                return;
            }
            if ($(this).find('input[name="discount_percent[]"]').val() == '') {
                $(this).find('input[name="discount_percent[]"]').addClass('is-invalid')
                isValid = false;
            }
            if ($(this).find('input[name="discount_price[]"]').val() == '') {
                $(this).find('input[name="discount_price[]"]').addClass('is-invalid')
                isValid = false;
            }
            if ($(this).find('input[name="quantity[]"]').val() == '') {
                $(this).find('input[name="quantity[]"]').addClass('is-invalid')
                isValid = false;
            }
            const price = $(this).closest('tr').find('.product-price').text().replace(/,/g, '');
            const discountPrice = $(this).closest('tr').find('.discount-price input').val().replace(/,/g, '');
            if (parseFloat(discountPrice) > parseFloat(price)) {
                $(this).closest('tr').find('.discount-price input').addClass('is-invalid')
                isValid = false;
            }
        })
        if ($('.productOrder:not(.d-none)').find($('input[name="product_id[]"]')).length == 0) {
            Lobibox.notify('error', {
                title: 'Lỗi',
                pauseDelayOnHover: true,
                continueDelayOnInactiveTab: false,
                position: 'top right',
                icon: 'bx bx-x-circle',
                msg: "Vui lòng thêm sản phẩm vào đơn hàng"
            });
            isValid = false;
        }
        if ($('#payment-type').val() == 2 && parseFloat($('input[name="deposit"]').val().replace(/,/g, '')) >= parseFloat($('input[name="order_total"]').val())) {
            Lobibox.notify('error', {
                title: 'Lỗi',
                pauseDelayOnHover: true,
                continueDelayOnInactiveTab: false,
                position: 'top right',
                icon: 'bx bx-x-circle',
                msg: "Vui lòng nhập số tiền cọc nhỏ hơn tổng tiền"
            });
            isValid = false;
        }
        if ($('select[name="payment_type"]').val() == '') {
            $(this).find('select[name="payment_type"]').addClass('is-invalid');
            isValid = false;
        } else if ($('select[name="payment_type"]').val() != 3 && $('select[name="payment_method"]').val() == '') {
            $(this).find('select[name="payment_method"]').addClass('is-invalid');
            isValid = false;
        }

        if ($('#payment-method').val() == 1) {
            if ($('input[name="bank_customer_name"]').val() == '') {
                $(this).find('input[name="bank_customer_name"]').addClass('is-invalid');
                isValid = false;
            }
            if ($('input[name="bank_name"]').val() == '') {
                $(this).find('input[name="bank_name"]').addClass('is-invalid');
                isValid = false;
            }
            if ($('input[name="bank_code"]').val() == '') {
                $(this).find('input[name="bank_code"]').addClass('is-invalid');
                isValid = false;
            }
            if ($('select[name="bank_account_id"]').val() == '') {
                $(this).find('select[name="bank_account_id"]').addClass('is-invalid');
                isValid = false;
            }
        }
        if (($('#payment-type').val() == 1 || $('#payment-type').val() == 2) && $('input[name="payment_date"]').val() == '') {
            $(this).find('input[name="payment_date"]').addClass('is-invalid');
            isValid = false;
        }
        if ($('#payment-type').val() == 2 && $('input[name="deposit"]').val() == '') {
            $(this).find('input[name="deposit"]').addClass('is-invalid');
            isValid = false;
        }
        // if ($('#payment-type').val() == 3) {
        //     if ($('input[name="payment_due_date"]').val() == '') {
        //         $(this).find('input[name="payment_due_date"]').addClass('is-invalid');
        //         isValid = false;
        //     }
        // }

        if (!isValid) {
            return false;
        }
        $(this).find('button[type="submit"]').prop('disabled',true);
        $(this).submit();
    })

    $(document).on('focus', 'select[name="customer_id"], input[name="discount_percent[]"], input[name="discount_percent[]"], input[name="discount_price[]"], input[name="bank_customer_name"], input[name="bank_name"], input[name="bank_code"], select[name="payment_type"], select[name="payment_method"], input[name="deposit"], input[name="payment_date"], select[name="bank_account_id"], input[name="payment_due_date"]', function () {
        $(this).removeClass('is-invalid');
    })
    $(document).on('change', 'select[name="customer_id"]', function () {
        $(this).removeClass('is-invalid');
    })

    $(document).on('click', '#addProductToOrderModal .page-link', function () {
        onSearch($(this), $(this).data('page'));
    });
    $('#addProductToOrderModal #searchProduct').on('input', function () {
        onSearch($(this))
    });
    $('#addProductToOrderModal #category').on('change', function () {
        onSearch($(this))
    });
    $('#addProductToOrderModal').on('show.bs.modal', function () {
        onSearch($(this));
    });
    $('#addProductToOrderModal').on('hide.bs.modal', function () {
        $(this).find('#productList').html('');
        $(this).find('#category').val('');
        $(this).find('#searchProduct').val('');
    });

    $(document).on('click', '.btn-remove-row', function () {
        $(this).closest('tr').remove();
        if ($('#orderlist tr.productOrder:not(.d-none)').length === 0) {
            $('#empty-row').removeClass('d-none');
        }
        totalOrder()
    })

    $(document).on('keyup', '.discount-percent input', function (event) {
        let discountPercent = $(this).val();
        if (isNaN($(this).val()) || [".."].includes(event.key)) {
            $(this).val('0');
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
    $(document).on('blur', '.discount-percent input', function (event) {
        const $price = $(this).closest('tr').find('.product-price');
        const $priceDiscount = $(this).closest('tr').find('.unit-price');
        const $discountPrice = $(this).closest('tr').find('.discount-price input');
        const price = parseFloat($price.text().replace(/,/g, ''));
        const discountPercent = !isNaN(parseFloat($(this).val())) ? parseFloat($(this).val()) : 0;

        $priceDiscount.text(new Intl.NumberFormat("en", {
            maximumFractionDigits: 0, minimumFractionDigits: 0,
        }).format(Math.max(price - (discountPercent * price) / 100, 0)))

        $discountPrice.val(new Intl.NumberFormat("en", {
            maximumFractionDigits: 0, minimumFractionDigits: 0,
        }).format(Math.max(price - $priceDiscount.text().replace(/,/g, ''), 0)))

        const discountPrice = !isNaN($discountPrice.val().replace(/,/g, '')) ? parseFloat($discountPrice.val().replace(/,/g, '')) : 0;
        $(this).val(discountPercent);
        const unitPrice = new Intl.NumberFormat("en", {
            maximumFractionDigits: 0,
            minimumFractionDigits: 0,
        }).format(Math.max(price - discountPrice, 0));
        $priceDiscount.text(unitPrice);
        $priceDiscount.closest('td').find('input:hidden').val(Math.max(price - discountPrice, 0));
        if ($discountPrice.val().replace(/,/g, '') > price) {
            $discountPrice.addClass('is-invalid');
            return false;
        }
        $discountPrice.removeClass('is-invalid')
        $(this).closest('tr').find('.quantity input').trigger('blur');
    });
    $(document).on('blur', '.discount-price input', function (event) {
        const $price = $(this).closest('tr').find('.product-price');
        const $priceDiscount = $(this).closest('tr').find('.unit-price');
        const $discountPercent = $(this).closest('tr').find('.discount-percent input');
        const price = parseFloat($price.text().replace(/,/g, ''));
        const discountPrice = parseFloat($(this).val().replace(/,/g, ''));
        $priceDiscount.closest('td').find('input:hidden').val(Math.max(price - discountPrice, 0));
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
        }).format(price == 0 ? 0 : Math.max(discountPrice/price * 100, 0)))
        $discountPercent.removeClass('is-invalid')
        $(this).closest('tr').find('.quantity input').trigger('blur');
    });
    $(document).on('keyup', '.discount-price input', function (event) {
        $(this).formatCurrency({
            'symbol': '',
            'decimalSymbol': '',
            'digitGroupSymbol': ','
        });
    })
    $(document).on('input', '.quantity input', function (event) {
        $(this).formatCurrency({
            'symbol': '',
            'decimalSymbol': '',
            'digitGroupSymbol': ','
        });
        if ($(this).val() == 0) {
            $(this).val(1)
        }
    })
    $(document).on('blur', '.quantity input', function (event) {
        const quantity = parseInt($(this).val().replace(/,/g, ''));
        const priceDiscount = parseFloat($(this).closest('tr').find('.unit-price').text().replace(/,/g, ''));
        const quantityPerPackage = parseInt($(this).closest('tr').find('.quantity-per-package').val());
        $(this).closest('tr').find('.total-quantity').text(new Intl.NumberFormat("en", {
            maximumFractionDigits: 0,
            minimumFractionDigits: 0,
        }).format(quantity*quantityPerPackage));
        $(this).closest('tr').find('.total').text(1);
        if (!isNaN(quantity) && !isNaN(priceDiscount)) {
            $(this).closest('tr').find('.total').text(new Intl.NumberFormat("en", {
                maximumFractionDigits: 0,
                minimumFractionDigits: 0,
            }).format(priceDiscount * quantity * quantityPerPackage));
        }
        totalOrder()
    })
    $(document).on('change', '#payment-method', function () {
        $('#payment-method-info input').removeClass('is-invalid');
        $('#payment-method-info select').removeClass('is-invalid');
        $('#deposit input').removeClass('is-invalid');
        $('#payment-date input').removeClass('is-invalid');
        if ($(this).val() == 1) {
            $('#payment-method-info').removeClass('d-none');
            $('#payment-date').removeClass('d-none');
        } else {
            $('#payment-method-info').addClass('d-none').find('input').val('');
            $('#bank-account').val('');
            $('#bank-account-info').addClass('d-none');
        }
        if ($(this).val() == 2) {
            $('#payment-date').removeClass('d-none');
        }
        if ($(this).val() == '' || $('#payment-type').val() != 2) {
            if (!$('#deposit').hasClass('d-none')) {
                $('#deposit').addClass('d-none').find('input').val('');
            }
        } else {
            $('#deposit').removeClass('d-none');
        }
    })
    $(document).on('change', '#payment-type', function () {
        $('#payment-method, #payment-method-info input').removeClass('is-invalid');
        $('#payment-method-info select').removeClass('is-invalid');
        if ($(this).val() == 1 || $(this).val() == 2) {
            $('#payment-method').removeClass('d-none');
            $('#payment-method').trigger('change');
        } else {
            $('#payment-method').addClass('d-none').val('');
            if (!$('#payment-method-info').hasClass('d-none')) {
                $('#payment-method-info').addClass('d-none').find('input').val('');
            }
            if (!$('#deposit').hasClass('d-none')) {
                $('#deposit').addClass('d-none').find('input').val('');
            }
            if (!$('#payment-date').hasClass('d-none')) {
                $('#payment-date').addClass('d-none').find('input').val('');
            }
        }
        if ($(this).val() == 3) {
            $('#payment-due-day').removeClass('d-none')
        } else {
            $('#payment-due-day').addClass('d-none').find('input').val('')
        }
    })
    $(document).on('change', '#red-bill', function () {
        if ($(this).find('input').is(':checked')) {
            $('#red-bill-info').removeClass('d-none');
        } else {
            $('#red-bill-info').addClass('d-none');
        }
    })
    $(document).on('input', '#deposit input', function()
    {
        $(this).formatCurrency({
            'symbol': '',
            'decimalSymbol': '',
            'digitGroupSymbol': ','
        });
    });
    $(document).on('click', '#productList tr.product', function () {
        // if ($(this).hasClass('disabledOnClick')) {
        //     return false;
        // }
        const customerId = parseInt($('#customer').val());
        const productId = parseInt($(this).data('id'));
        const productName = $(this).data('product-name');
        const productPrice = $(this).data('product-price');
        const productImage = $(this).data('product-image');
        const productColor = $(this).data('product-color');
        const productCapacity = $(this).data('product-capacity');
        const productUnit = $(this).data('product-unit');
        const productSpecifications = $(this).data('product-specifications');
        const productQuantityPerPackage = $(this).data('product-quantity-per-package');
        appendProduct(customerId, productId, productName, productPrice, productImage, productColor, productCapacity, productUnit, productSpecifications, productQuantityPerPackage);
        $(this).remove();
        if ($('#productList .product').length == 0) {
            $('#productList').append(`
                <tr>
                    <td class="text-center" colspan='5'>
                        Không có dữ liệu
                    </td>
                </tr>
                `);
        }
        // onSearch($(this));
        totalOrder()
    });

    $(document).on('change', '#customer', function () {
        const customerId = $(this).val();
        $('#delivery-info').find('span').text('');
        $('#red-bill-info').find('span').text('');
        $('#red-bill-info').addClass('d-none');
        $('#red-bill').find('input').removeAttr('checked');
        $('#red-bill').find('input').prop('checked', false);
        $('#payment-info').find('input').removeClass('is-invalid').val('');
        $('#payment-type').removeClass('is-invalid');
        if (customerId && customerId !== '') {
            appendCustomerInfo(customerId);
            appendProductAjax(customerId);
        } else {
            if (!$('#delivery-info').hasClass('d-none')) {
                $('#delivery-info').addClass('d-none');
            }
            if (!$('#payment-type').hasClass('d-none')) {
                $('#payment-type').addClass('d-none');
            }
            if (!$('#payment-method').hasClass('d-none')) {
                $('#payment-method').addClass('d-none');
            }
            if (!$('#payment-method-info').hasClass('d-none')) {
                $('#payment-method-info').addClass('d-none');
            }
            $('#payment-method-info').addClass('d-none').find('input').val('');
        }
    });

    $(document).on('change', '#bank-account', function () {
        const bankAccountId = $(this).val();
        $.ajax({
            url: '/order/getBankAccountById/'+parseInt(bankAccountId),
            type: 'GET',
            success: function (bankAccount) {
                if ($.isEmptyObject(bankAccount)) {
                    $('#bank-account-info').addClass('d-none');
                    return false
                }
                $('#bank-account-info').removeClass('d-none');
                $('#bank-account-info').find('#bank-name').text(bankAccount.bank_name || '');
                $('#bank-account-info').find('#bank-code').text(bankAccount.bank_code || '');
                $('#bank-account-info').find('#bank-account-name').text(bankAccount.bank_account_name || '');
                if (bankAccount.bank_branch === null) {
                    $('#bank-account-info').find('#bank-branch').text('').closest('div').addClass('d-none');
                } else {
                    $('#bank-account-info').find('#bank-branch').closest('div').removeClass('d-none')
                    $('#bank-account-info').find('#bank-branch').text(bankAccount.bank_branch || '');
                }
            },
            error: function (xhr, status, error) {
                console.error(xhr.responseText);
            }
        })
    });
});
function applyDiscount(customerId) {
    $('#orderlist .productOrder').each(function () {
        if ($(this).hasClass('d-none')) {
            return;
        }
        const productId = parseInt($(this).data('id'));
        let productPrice = $(this).find('.product-price').text();
        $(this).find('.discount-percent input').val(0);
        $(this).find('.discount-price input').val(0);
        $(this).find('.unit-price').text(productPrice);
        $(this).find('.unit-price').closest('td').find('input:hidden').val(productPrice);
        $(this).find('.discount-percent input').val(0).removeAttr('readonly').removeClass('disabled');
        $(this).find('.discount-price input').val(0).removeAttr('readonly').removeClass('disabled');
        $(this).find('.discount-note').text('');
        if (!isNaN(discounts[customerId + '_' + productId]) && !isNaN(discountsPrice[customerId + '_' + productId])) {
            productPrice = parseFloat(productPrice.replace(/,/g, ''));
            const discountPercent = discounts[customerId + '_' + productId];
            const discountPrice = discountsPrice[customerId + '_' + productId];
            const discountNote = discountsNote[customerId + '_' + productId];
            const pricePercent = new Intl.NumberFormat("en", {
                maximumFractionDigits: 0,
                minimumFractionDigits: 0,
            }).format(Math.max(productPrice - discountPrice, 0));
            $(this).find('.discount-percent input').attr('readonly', 'readonly').addClass('disabled').val(new Intl.NumberFormat("en", {
                maximumFractionDigits: 4,
                minimumFractionDigits: 0,
            }).format(discountPercent));
            $(this).find('.discount-price input').attr('readonly', 'readonly').addClass('disabled').val(new Intl.NumberFormat("en", {
                maximumFractionDigits: 0,
                minimumFractionDigits: 0,
            }).format(discountPrice));
            $(this).find('.unit-price').text(pricePercent);
            $(this).find('.unit-price').closest('td').find('input:hidden').val(pricePercent);
            $(this).find('.discount-note').text(discountNote)
        }
        $(this).find('.quantity input').trigger('blur');
    })
}
function totalOrder() {
    let totalOrder = 0;
    let totalDiscount = 0;
    let totalProductOrder = 0;
    $('.productOrder td.total').each(function () {
        if ($(this).closest('tr').hasClass('d-none')) {
            return;
        }
        const quantity = parseInt($(this).closest('tr').find('.quantity input').val().replace(/,/g, ''));
        const quantityPerPackage = parseInt($(this).closest('tr').find('.quantity-per-package').val());
        const totalProductPrice = parseFloat($(this).closest('tr').find('.product-price').text().replace(/,/g, '') || 0)
        const total = parseFloat($(this).text().replace(/,/g, '') || 0)
        const discountPrice = parseFloat($(this).closest('tr').find('.discount-price input').val().replace(/,/g, '') || 0)
        totalOrder += total;
        totalProductOrder += totalProductPrice*quantity*quantityPerPackage;
        totalDiscount += discountPrice*quantity*quantityPerPackage;
    });
    $('input[name="order_total"]').val(totalOrder);
    $('input[name="order_discount"]').val(totalDiscount);
    $('input[name="order_total_product_price"]').val(totalProductOrder);
    $('#total-product-order').text(new Intl.NumberFormat("en", {
        maximumFractionDigits: 0,
        minimumFractionDigits: 0,
    }).format(totalProductOrder)+'₫');
    $('#total-order').text(new Intl.NumberFormat("en", {
        maximumFractionDigits: 0,
        minimumFractionDigits: 0,
    }).format(totalOrder)+'₫');
    $('#total-discount').text(new Intl.NumberFormat("en", {
        maximumFractionDigits: 0,
        minimumFractionDigits: 0,
    }).format(totalDiscount)+'₫');
}
function appendCustomerInfo(customerId) {
    $.ajax({
        url: '/customer/customer-info/'+customerId,
        method: 'GET',
        success: function (customer) {
            $('#payment-info').removeClass('d-none');
            $('#delivery-info').removeClass('d-none');
            $('#delivery-info').find('#delivery-info-name').append(`<span>${customer.customer_name || ''}</span>`);
            $('#delivery-info').find('#delivery-info-address').append(`<span>${customer.address || ''}</span>`);
            $('#delivery-info').find('#delivery-info-phone').append(`<span>${customer.phone || ''}</span>`);
            if (customer.company != null && customer.company_address != null && customer.tax_code != null && customer.email != null) {
                $('#red-bill').removeClass('d-none');
                $('#red-bill-info').find('#red-bill-info-company').append(`<span>${customer.company || ''}</span>`);
                $('#red-bill-info').find('#red-bill-info-company-address').append(`<span>${customer.company_address || ''}</span>`);
                $('#red-bill-info').find('#red-bill-info-tax_code').append(`<span>${customer.tax_code || ''}</span>`);
                $('#red-bill-info').find('#red-bill-info-email').append(`<span>${customer.email || ''}</span>`);
            } else {
                if (!$('#red-bill').hasClass('d-none')) {
                    $('#red-bill').addClass('d-none');
                }
                if (!$('#red-bill-info').hasClass('d-none')) {
                    $('#red-bill-info').addClass('d-none');
                }
            }
        },
        error: function (xhr, status, error) {
            console.error(xhr.responseText);
        }
    });
}
function appendProductAjax(customerId) {
    const productIdsNotIn = $('#orderlist .productOrder').map(function () {
        return parseInt($(this).data('id') || 0);
    }).get();

    $.ajax({
        url: '/order/getDiscountByCustomerId',
        type: 'GET',
        data: {customerId: customerId, productIdsNotIn: productIdsNotIn},
        success: function (products) {
            products.forEach(function (product) {
                const productId = product.id;
                const productName = product.product_name;
                const productPrice = product.price;
                const productImage = product.image_url;
                const productColor = product.color;
                const productCapacity = product.capacity;
                const productUnit = product.unit;
                const productSpecifications = product.specifications;
                const productQuantityPerPackage = product.quantity_per_package;
                appendProduct(customerId, productId, productName, productPrice, productImage, productColor, productCapacity, productUnit, productSpecifications, productQuantityPerPackage)
            });
            applyDiscount(customerId);
            totalOrder();
        },
        error: function (xhr, status, error) {
            console.error(xhr.responseText);
        }
    })
}
function appendProduct(customerId, productId, productName, productPrice, productImage, productColor, productCapacity, productUnit, productSpecifications, productQuantityPerPackage) {
    const productPriceFormat = new Intl.NumberFormat("en", {
        maximumFractionDigits: 0,
        minimumFractionDigits: 0,
    }).format(productPrice);
    const unitPriceFormat = new Intl.NumberFormat("en", {
        maximumFractionDigits: 0,
        minimumFractionDigits: 0,
    }).format(productPrice*productQuantityPerPackage);
    const $productOrder = $('#orderlist').find('.productOrder.d-none').clone();
    $productOrder.removeClass('d-none');
    $productOrder.attr('data-id', productId);
    $productOrder.find('button, input, textarea').removeAttr('disabled');
    $productOrder.find('input[name="product_id[]"]').val(productId);
    $productOrder.find('.product-image img').attr('src', productImage);
    $productOrder.find('.product-price').text(productPriceFormat);
    $productOrder.find('.product-title').text(productName);
    $productOrder.find('.product-color').text(productColor);
    $productOrder.find('.product-capacity').text(productCapacity);
    $productOrder.find('.product-unit').text(productUnit);
    $productOrder.find('.discount-percent input').val(0);
    $productOrder.find('.discount-price input').val(0);
    $productOrder.find('.unit-price').text(unitPriceFormat);
    $productOrder.find('.product-specifications').text(productSpecifications);
    $productOrder.find('.total-quantity').text(new Intl.NumberFormat("en", {
        maximumFractionDigits: 0,
        minimumFractionDigits: 0,
    }).format(productQuantityPerPackage));
    $productOrder.find('.quantity-per-package').val(productQuantityPerPackage);
    $productOrder.find('.unit-price').closest('td').find('input:hidden').val(productPrice*productQuantityPerPackage);
    $productOrder.find('.product-price').closest('td').find('input:hidden').val(productPrice);
    $productOrder.find('.total').text(unitPriceFormat);
    $productOrder.find('.quantity input').val(1);
    $productOrder.find('.discount-note').text('');
    if (!isNaN(customerId) && !isNaN(discounts[customerId + '_' + productId]) && !isNaN(discountsPrice[customerId + '_' + productId])) {
        const discountPercent = discounts[customerId + '_' + productId];
        const discountPrice = discountsPrice[customerId + '_' + productId];
        const discountNote = discountsNote[customerId + '_' + productId] || '';
        const pricePercent = new Intl.NumberFormat("en", {
            maximumFractionDigits: 0,
            minimumFractionDigits: 0,
        }).format(Math.max(productPrice*productQuantityPerPackage - discountPrice*productQuantityPerPackage, 0))
        $productOrder.find('.discount-percent input').attr('readonly', 'readonly').addClass('disabled').val(new Intl.NumberFormat("en", {
            maximumFractionDigits: 0,
            minimumFractionDigits: 0,
        }).format(discounts[customerId + '_' + productId]));
        $productOrder.find('.discount-price input').attr('readonly', 'readonly').addClass('disabled').val(new Intl.NumberFormat("en", {
            maximumFractionDigits: 4,
            minimumFractionDigits: 0,
        }).format(discountsPrice[customerId + '_' + productId]));
        $productOrder.find('.discount-note').text(discountNote);
        $productOrder.find('.unit-price').text(pricePercent);
        $productOrder.find('.unit-price').closest('td').find('input:hidden').val(Math.max(productPrice*productQuantityPerPackage - discountPrice*productQuantityPerPackage, 0))
        $productOrder.find('.total').text(pricePercent);
    }
    $('#orderlist').prepend($productOrder);
    $('#empty-row').addClass('d-none');
}
function renderPagination(paginate) {
    let paginationHTML = `<nav aria-label="Page navigation"><ul class="pagination justify-content-center">`;

    paginationHTML += paginate.prev_page_url ?
        `<li class="page-item"><a class="page-link" data-page="${paginate.current_page - 1}" href="javascript:;" rel="prev">‹</a></li>` :
        `<li class="page-item disabled"><span class="page-link">‹</span></li>`;

    paginate.links.forEach(link => {
        if (link.label != 'pagination.previous' && link.label != 'pagination.next') {
            paginationHTML += link.active ?
                `<li class="page-item active" aria-current="page"><span class="page-link">${link.label}</span></li>` :
                `<li class="page-item"><a class="page-link" data-page="${parseInt(link.label)}" href="javascript:;">${link.label}</a></li>`;
        }
    });

    paginationHTML += paginate.next_page_url ?
        `<li class="page-item"><a class="page-link" data-page="${paginate.current_page + 1}" href="javascript:;" rel="next">›</a></li>` :
        `<li class="page-item disabled"><span class="page-link">›</span></li>`;

    paginationHTML += `</ul></nav>`;

    $('#paginateCustom').html(paginationHTML);
}

function onSearch(e, page) {
    const searchText = e.closest('#addProductToOrderModal').find('#searchProduct').val() || '';
    const categoryId = e.closest('#addProductToOrderModal').find('#category').val() || '0';
    const productIdsNotIn = $('#orderlist .productOrder').map(function () {
        return parseInt($(this).data('id') || 0);
    }).get();
    if (categoryId || searchText.length >= 3) {
        $.ajax({
            url: '/product/search-product',
            method: 'GET',
            data: {
                query: searchText,
                category_id: categoryId,
                productIdsNotIn: productIdsNotIn,
                page: page || 1
            },
            success: function (response) {
                let products = response.data;
                let template = '';
                products.forEach(function (product) {
                    const productPrice = new Intl.NumberFormat("en", {
                        maximumFractionDigits: 0,
                        minimumFractionDigits: 0,
                    }).format(product.price);

                    template += `
                                                <tr class="hover-able cursor-pointer product" data-id='${product.id}' data-product-image='${product.image_url}'  data-product-name='${product.product_name}'  data-product-price='${product.price}' data-product-color='${product.color}' data-product-capacity='${product.capacity}' data-product-unit='${product.unit}' data-product-specifications='${product.specifications}' data-product-quantity-per-package='${product.quantity_per_package}'>
                                                    <td>
                                                        <div>
                                                            <div class="d-flex align-items-center gap-2"">
                                                                <div class="product-box">
                                                                    <img src="${product.image_url}" alt="">
                                                                </div>
                                                                <div>
                                                                    <p class="mb-0 product-title">${product.product_name}</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>${product.color}</td>
                                                    <td>${product.capacity}</td>
                                                    <td>${product.specifications}</td>
                                                    <td>${product.unit}</td>
                                                    <td>${productPrice}</td>
                                                </tr>
                                            `;
                });
                if (!products || products.length == 0) {
                    template =  `
                            <tr>
                                <td class="text-center" colspan='6'>
                                    Không có dữ liệu
                                </td>
                            </tr>
                            `
                }
                $('#productList').html(template);
                // $('#productList tr.product').each(function () {
                //     const $this = $(this);
                //     $this.addClass('disabledOnClick');
                //     setTimeout(function () {
                //         $this.removeClass('disabledOnClick');
                //     }, 1000);
                // })

                if (response.last_page == 1) {
                    $('#paginateCustom').html('');
                    return false;
                }

                renderPagination(response);

            },
            error: function (xhr, status, error) {
                console.error(xhr.responseText);
            }
        });

    }
}
