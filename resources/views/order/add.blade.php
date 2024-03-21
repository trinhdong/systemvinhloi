@extends('layouts.app')
@section('title')
    Đơn hàng
@endsection
@section('action')
    <div class="col-12">
        <a href="{{route('order.index')}}" class="btn btn-sm btn-secondary">Quay lại</a>
    </div>
@endsection
@section('breadcrumb')
    Thêm đơn hàng
@endsection
@section('content')

 <form class="row g-3 needs-validation" action="{{ route('order.create') }}" method="POST">
    @csrf
    <div class="card">
        <div class="card-header py-3">
            <div class="row g-5">
                <div class="col-3">
                    <input name="order_number" type="text" class="form-control" placeholder="Mã đơn hàng">
                    <div class="invalid-feedback">Vui lòng nhập mã đơn hàng</div>
                </div>
                <div class="col-3">
                    <select id="customer" name="customer_id" class="form-select single-select">
                        <option selected="" disabled="" value="">Chọn khách hàng</option>
                        @foreach($customers as $customerId => $customerName)
                            <option value="{{ $customerId }}">{{ $customerName }}</option>
                        @endforeach
                    </select>
                    <div class="invalid-feedback">Vui lòng chọn khách hàng</div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12 col-lg-8">
                    <div class="card border shadow-none radius-10">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table align-middle mb-0">
                                    <thead class="table-light">
                                    <tr>
                                        <th style="width: 50px">
                                            <button type="button" id="addProductToOrderModalBtn" class="btn btn-sm btn-outline-primary border-0 btn-clone-row"
                                                    title="Thêm"
                                                    data-bs-tooltip="tooltip"
                                                    data-bs-toggle="modal"
                                                    data-bs-placement="bottom"
                                                    data-bs-target="#addProductToOrderModal"
                                            >
                                                <div class="font-13" style="margin-right: 5px;">
                                                    <i class="lni lni-plus"></i>
                                                </div>
                                            </button>
                                        </th>
                                        <th>Sản phẩm</th>
                                        <th>Giá gốc</th>
                                        <th>Phần trăm khuyến mãi</th>
                                        <th>Giá sau chiết khấu</th>
                                        <th>Số lượng</th>
                                        <th>Tổng tiền</th>
                                    </tr>
                                    </thead>
                                    <tbody id="orderlist">
                                    <tr id="empty-row">
                                        <td colspan="7" class="text-center">Chưa có sản phẩm nào được thêm</td>
                                    </tr>
                                    <tr class="d-none productOrder">
                                        <td>
                                            <button disabled type="button" class="btn btn-sm btn-outline-danger border-0 btn-remove-row" title="Xóa">
                                                <div class="font-13" style="margin-right: 5px;">
                                                    <i class="lni lni-close"></i>
                                                </div>
                                            </button>
                                        </td>
                                        <td>
                                            <div>
                                                <input disabled type="hidden" name="product_id[]" />
                                                <a class="d-flex align-items-center gap-2" href="javascript:;">
                                                    <div class="product-box product-image">
                                                        <img src="" alt="">
                                                    </div>
                                                    <div>
                                                        <P class="mb-0 product-title"></P>
                                                    </div>
                                                </a>
                                            </div>
                                        </td>
                                        <td class="product-price"></td>
                                        <td class="discount-percent">
                                            <div class="input-group has-validation">
                                                <input disabled name="discount_percent[]" type="text" class="form-control"
                                                       placeholder="000.00" autocomplete="off">
                                                <div class="invalid-feedback"></div>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="unit-price"></p>
                                            <input disabled type="hidden" name="unit_price[]" />
                                        </td>
                                        <td class="quantity">
                                            <div class="input-group has-validation">
                                                <input disabled name="quantity[]" type="number" min="1" step="1" class="form-control"
                                                       placeholder="0" autocomplete="off" value="">
                                                <div class="invalid-feedback"></div>
                                            </div>
                                        </td>
                                        <td class="total"></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-4">
                    <div class="card border shadow-none bg-light radius-10">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-4">
                                <div>
                                    <h5 class="mb-0">Chi tiết đơn hàng</h5>
                                </div>
                            </div>
                            <div class="d-flex align-items-center mb-3">
                                <div>
                                    <p class="mb-0">Tổng tiền:</p>
                                </div>
                                <div class="ms-auto">
                                    <h5 id="total-product-order" class="mb-0">0₫</h5>
                                </div>
                            </div>
                            <div class="d-flex align-items-center mb-3">
                                <div>
                                    <p class="mb-0">Khuyến mãi:</p>
                                </div>
                                <div class="ms-auto">
                                    <input type="hidden" name="order_discount" />
                                    <h5 id="total-discount"  class="mb-0 text-danger">0₫</h5>
                                </div>
                            </div>
                            <div class="d-flex align-items-center mb-3">
                                <div>
                                    <p class="mb-0">Tổng tiền sau chiết khấu:</p>
                                </div>
                                <div class="ms-auto">
                                    <input type="hidden" name="order_total" />
                                    <h5 id="total-order"  class="mb-0 text-danger">0₫</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-2">
                <div class="d-grid">
                    <button class="btn btn-primary" type="submit">Thêm mới</button>
                </div>
            </div>
        </div>
    </div>
</form>

@include('order.addProduct', compact('categories', 'discounts'))
@endsection
@section('script')
    <script src="js/order/add.js"></script>
    <script>
        $(document).on('click', '#productList tr.product', function () {
            // if ($(this).hasClass('disabledOnClick')) {
            //     return false;
            // }
            const discounts = {!! json_encode($discounts) !!};
            const customerId = parseInt($('#customer').val());
            const productId = parseInt($(this).data('id'));
            const productName = $(this).data('product-name');
            const productPrice = $(this).data('product-price');
            const productPriceFormat = new Intl.NumberFormat("en", {
                maximumFractionDigits: 0,
                minimumFractionDigits: 0,
            }).format(productPrice);
            const productImage = $(this).data('product-image');
            const $productOrder = $('#orderlist').find('.productOrder.d-none').clone();
            $productOrder.removeClass('d-none');
            $productOrder.attr('data-id', productId);
            $productOrder.find('button, input').removeAttr('disabled');
            $productOrder.find('input[name="product_id[]"]').val(productId);
            $productOrder.find('.product-image img').attr('src', productImage);
            $productOrder.find('.product-price').text(productPriceFormat);
            $productOrder.find('.product-title').text(productName);
            $productOrder.find('.discount-percent input').val(0);
            $productOrder.find('.unit-price').text(productPriceFormat);
            $productOrder.find('.unit-price').closest('td').find('input:hidden').val(productPrice);
            $productOrder.find('.total').text(productPriceFormat);
            $productOrder.find('.quantity input').val(1);
            if (!isNaN(customerId) && !isNaN(discounts[customerId + '_' + productId])) {
                const discountPercent = discounts[customerId + '_' + productId];
                const pricePercent = new Intl.NumberFormat("en", {
                    maximumFractionDigits: 0,
                    minimumFractionDigits: 0,
                }).format(Math.max(productPrice - (productPrice * discountPercent) / 100, 0));
                $productOrder.find('.discount-percent input').attr('readonly', 'readonly').val(discounts[customerId + '_' + productId]);
                $productOrder.find('.unit-price').text(pricePercent);
                $productOrder.find('.unit-price').closest('td').find('input:hidden').val(pricePercent);
                $productOrder.find('.total').text(pricePercent);
            }
            $('#orderlist').prepend($productOrder);
            $('#empty-row').addClass('d-none');
            $(this).remove();
            if ($('#productList .product').length == 0) {
                $('#productList').append(`
                <tr>
                    <td class="text-center" colspan='2'>
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
            $('#orderlist .productOrder').each(function () {
                if ($(this).hasClass('d-none')) {
                    return;
                }
                const discounts = {!! json_encode($discounts) !!};
                const productId = parseInt($(this).data('id'));
                let productPrice = $(this).find('.product-price').text();
                $(this).find('.discount-percent input').val(0);
                $(this).find('.unit-price').text(productPrice);
                $(this).find('.unit-price').closest('td').find('input:hidden').val(productPrice);
                $(this).find('.discount-percent input').val(0).removeAttr('readonly');
                if (!isNaN(discounts[customerId + '_' + productId])) {
                    productPrice = parseFloat(productPrice.replace(/,/g, ''));
                    const discountPercent = discounts[customerId + '_' + productId];
                    const pricePercent = new Intl.NumberFormat("en", {
                        maximumFractionDigits: 0,
                        minimumFractionDigits: 0,
                    }).format(Math.max(productPrice - (productPrice * discountPercent) / 100, 0));
                    $(this).find('.discount-percent input').attr('readonly', 'readonly').val(discountPercent);
                    $(this).find('.unit-price').text(pricePercent);
                    $(this).find('.unit-price').closest('td').find('input:hidden').val(pricePercent);
                }
                $(this).find('.quantity input').trigger('blur');
            })
            totalOrder()
        });
    </script>
@endsection
