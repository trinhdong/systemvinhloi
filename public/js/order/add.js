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
                                                <tr class="hover-able cursor-pointer product" data-id=${product.id} data-product-image=${product.image_url}  data-product-name=${product.product_name}  data-product-price=${product.price}>
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
                                                    <td>${productPrice}</td>
                                                </tr>
                                            `;
                });
                if (!products || products.length == 0) {
                    template =  `
                            <tr>
                                <td class="text-center" colspan='2'>
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

$(document).ready(function () {
    $(document).on('submit', 'form', function () {
        let isValid = true;
        if ($('input[name="order_number"]').val() == '') {
            $('input[name="order_number"]').addClass('is-invalid')
            isValid = false;
        }
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
            if ($(this).find('input[name="quantity[]"]').val() == '') {
                $(this).find('input[name="discount_percent[]"]').addClass('is-invalid')
                isValid = false;
            }
        })
        if ($('input[name="discount_percent[]"]').val() == '' || $('input[name="discount_percent[]"]').val() == '') {
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
        if (!isValid) {
            return false;
        }
        $(this).submit();
    })

    $(document).on('focus', 'input[name="order_number"], select[name="customer_id"], input[name="discount_percent[]"], input[name="discount_percent[]"]', function () {
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
        if ($('#productList tr.product').length === 0) {
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
        if (decPart !== undefined && decPart.length > 2) {
            $(this).val(discountPercent.toFixed(2));
        }
    });
    $(document).on('blur', '.discount-percent input', function (event) {
        const $price = $(this).closest('tr').find('.product-price');
        const $priceDiscount = $(this).closest('tr').find('.unit-price');
        const price = parseFloat($price.text().replace(/,/g, ''));
        const discountPercent = !isNaN(parseFloat($(this).val())) ? parseFloat($(this).val()) : 0;
        $(this).val(discountPercent);
        const unitPrice = new Intl.NumberFormat("en", {
            maximumFractionDigits: 0,
            minimumFractionDigits: 0,
        }).format(Math.max(price - (discountPercent * price) / 100, 0));
        $priceDiscount.text(unitPrice);
        $priceDiscount.closest('td').find('input:hidden').val(Math.max(price - (discountPercent * price) / 100, 0));
        $(this).closest('tr').find('.quantity input').trigger('blur');
        totalOrder();
    });
    $(document).on('keyup', '.quantity input', function (event) {
        let quantity = $(this).val();
        if (!Number.isInteger(parseFloat(quantity)) || quantity == '0') {
            $(this).val('1');
        }
    })
    $(document).on('blur', '.quantity input', function (event) {
        let quantity = $(this).val();
        if (!Number.isInteger(parseFloat(quantity))) {
            $(this).val('1');
        }
        const priceDiscount = $(this).closest('tr').find('.unit-price').text().replace(/,/g, '');
        $(this).closest('tr').find('.total').text(1);
        if (!isNaN(quantity) && !isNaN(priceDiscount)) {
            $(this).closest('tr').find('.total').text(new Intl.NumberFormat("en", {
                maximumFractionDigits: 0,
                minimumFractionDigits: 0,
            }).format(priceDiscount * quantity));
        }
        totalOrder()
    })
});
function totalOrder() {
    let totalOrder = 0;
    let totalDiscount = 0;
    let totalProductOrder = 0;
    $('.productOrder td.total').each(function () {
        if ($(this).closest('tr').hasClass('d-none')) {
            return;
        }
        const quantity = parseFloat($(this).closest('tr').find('.quantity input').val());
        const totalProductPrice = parseFloat($(this).closest('tr').find('.product-price').text().replace(/,/g, '') || 0)
        const total = parseFloat($(this).text().replace(/,/g, '') || 0)
        const discountPercent = parseFloat($(this).closest('tr').find('.discount-percent input').val() || 0)
        totalOrder += total;
        totalProductOrder += totalProductPrice*quantity;
        totalDiscount += discountPercent < 100 ? ((totalProductPrice * discountPercent) / 100)*quantity : totalProductPrice*quantity;
    });
    $('input[name="order_total"]').val(totalOrder);
    $('input[name="order_discount"]').val(totalDiscount);
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
