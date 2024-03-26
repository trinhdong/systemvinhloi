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
    Chỉnh sửa đơn hàng
@endsection
@section('content')

    <form class="row g-3 needs-validation" action="{{ route('order.update', $order->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="card">
            <div class="card-body">
                <div class="card">
                    <div class="card-header py-3">
                        <div class="row g-5">
                            <div class="col-3">
                                <input name="order_number" type="text" class="form-control" placeholder="Mã đơn hàng"
                                       value="{{ $order->order_number }}">
                                <div class="invalid-feedback">Vui lòng nhập mã đơn hàng</div>
                            </div>
                            <div class="col-3">
                                <select id="customer" name="customer_id" class="form-select single-select">
                                    <option selected="" disabled="" value="">Chọn khách hàng</option>
                                    @foreach($customers as $customerId => $customerName)
                                        <option value="{{ $customerId }}"
                                                @if($order->customer_id == $customerId) selected @endif>{{ $customerName }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">Vui lòng chọn khách hàng</div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="card border shadow-none radius-10">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table align-middle mb-0">
                                                <thead class="table-light">
                                                <tr>
                                                    <th style="width: 50px">
                                                        <button type="button" id="addProductToOrderModalBtn"
                                                                class="btn btn-sm btn-outline-primary border-0 btn-clone-row"
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
                                                    <th>Ghi chú</th>
                                                    <th>Giá gốc</th>
                                                    <th>Chiết khấu</th>
                                                    <th>Giá sau chiết khấu</th>
                                                    <th>Số lượng</th>
                                                    <th>Tổng tiền sau chiết khấu</th>
                                                </tr>
                                                </thead>
                                                <tbody id="orderlist">
                                                <tr id="empty-row" class="d-none">
                                                    <td colspan="8" class="text-center">Chưa có sản phẩm nào được thêm
                                                    </td>
                                                </tr>
                                                <tr class="d-none productOrder">
                                                    <td>
                                                        <button disabled type="button"
                                                                class="btn btn-sm btn-outline-danger border-0 btn-remove-row"
                                                                title="Xóa">
                                                            <div class="font-13" style="margin-right: 5px;">
                                                                <i class="lni lni-close"></i>
                                                            </div>
                                                        </button>
                                                    </td>
                                                    <td>
                                                        <div>
                                                            <input disabled type="hidden" name="product_id[]"/>
                                                            <div class="d-flex align-items-center gap-2">
                                                                <div class="product-box product-image">
                                                                    <img src="" alt="">
                                                                </div>
                                                                <div>
                                                                    <P class="mb-0 product-title"></P>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td style="min-width:150px">
                                                        <textarea name="note[]" id="" cols="1" rows="1"
                                                                  class="form-control"></textarea>
                                                    </td>
                                                    <td>
                                                        <div class="product-price"></div>
                                                        <input type="hidden" name="product_price"/>
                                                    </td>
                                                    <td class="discount-percent">
                                                        <div class="input-group has-validation">
                                                            <input disabled name="discount_percent[]" type="text"
                                                                   class="form-control"
                                                                   placeholder="000.00" autocomplete="off">
                                                            <div class="invalid-feedback"></div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="unit-price"></div>
                                                        <input disabled type="hidden" name="unit_price[]"/>
                                                    </td>
                                                    <td class="quantity">
                                                        <div class="input-group has-validation">
                                                            <input style="max-width: 80px" disabled name="quantity[]"
                                                                   type="text" min="1" step="1"
                                                                   class="w-auto form-control"
                                                                   placeholder="0" autocomplete="off" value="">
                                                            <div class="invalid-feedback"></div>
                                                        </div>
                                                    </td>
                                                    <td class="total"></td>
                                                </tr>
                                                @foreach($order->orderDetail as $orderDetail)
                                                    <tr class="productOrder" data-id="{{ $orderDetail->product_id }}"
                                                        id="orderDetail{{$orderDetail->id}}">
                                                        <td>
                                                            <a href="javascript:;" id="deleteOrderDetailModalBtn"
                                                               class="btn btn-sm btn-outline-danger border-0"
                                                               title="Xóa"
                                                               data-bs-toggle="modal"
                                                               data-bs-target="#deleteOrderDetailModal"
                                                               data-order-detail-id="{{$orderDetail->id}}">
                                                                <div class="font-13" style="margin-right: 5px;">
                                                                    <i class="lni lni-close"></i>
                                                                </div>
                                                            </a>
                                                        </td>
                                                        <td>
                                                            <div>
                                                                <input type="hidden" name="product_id[]"
                                                                       value="{{$orderDetail->product_id}}"/>
                                                                <div class="d-flex align-items-center gap-2">
                                                                    <div class="product-box product-image">
                                                                        <img src="{{ $orderDetail->product->image }}"
                                                                             alt="">
                                                                    </div>
                                                                    <div>
                                                                        <P class="mb-0 product-title">{{ $orderDetail->product->product_name }}</P>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td style="min-width:150px">
                                                            <textarea name="note[]" id="" cols="1" rows="1"
                                                                      class="form-control">{{ $orderDetail->note }}</textarea>
                                                        </td>
                                                        <td>
                                                            <div class="product-price">{{number_format($orderDetail->product_price)}}</div>
                                                            <input type="hidden" name="product_price[]"
                                                                   value="{{$orderDetail->product_price}}"/>
                                                        </td>
                                                        <td class="discount-percent">
                                                            <div class="input-group has-validation">
                                                                <input name="discount_percent[]" type="text" readonly=""
                                                                       class="disabled form-control"
                                                                       placeholder="000.00" autocomplete="off"
                                                                       value="{{ $orderDetail->discount_percent }}">
                                                                <div class="invalid-feedback"></div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="unit-price">{{number_format($orderDetail->unit_price)}}</div>
                                                            <input type="hidden" name="unit_price[]"
                                                                   value="{{$orderDetail->unit_price}}"/>
                                                        </td>
                                                        <td class="quantity">
                                                            <div class="input-group has-validation">
                                                                <input style="max-width: 80px" name="quantity[]"
                                                                       type="text" min="1" step="1"
                                                                       class="w-auto form-control"
                                                                       placeholder="0" autocomplete="off"
                                                                       value="{{number_format($orderDetail->quantity)}}">
                                                                <div class="invalid-feedback"></div>
                                                            </div>
                                                        </td>
                                                        <td class="total">{{number_format($orderDetail->unit_price*$orderDetail->quantity)}}</td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="col-12">
                                    <div id="delivery-info" class="card border radius-10">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center mb-4">
                                                <div>
                                                    <h5 class="mb-0">Thông tin giao hàng</h5>
                                                </div>
                                            </div>
                                            <p id="delivery-info-name" class="d-flex justify-content-between">
                                                <strong>Tên: </strong><span>{{$order->customer->customer_name}}</span></p>
                                            <p id="delivery-info-phone" class="d-flex justify-content-between"><strong>Số điện
                                                    thoại: </strong><span>{{$order->customer->phone}}</span></p>
                                            <p id="delivery-info-address" class="d-flex justify-content-between"><strong>Địa
                                                    chỉ: </strong><span>{{$order->customer->address}}</span></p>
                                            <div class="align-items-center">
                                                <label for="" class="fw-bolder me-1" style="white-space: nowrap">Địa chỉ
                                                    giao hàng khác nếu có: </label>
                                                <input name="shipping_address" type="text" class="form-control"
                                                       placeholder="Nhập địa chỉ giao hàng" autocomplete="off"
                                                       value="{{$order->shipping_address}}">
                                                <div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div id="order-note" class="card border radius-10">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center mb-4">
                                                <div>
                                                    <h5 class="mb-0">Ghi chú đơn hàng</h5>
                                                </div>
                                            </div>
                                            <div>
                                                <textarea name="order_note" class="form-control" id="" cols="30"
                                                          rows="2">{{$order->order_note}}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="red-bill"
                                     class="{{$order->customer->tax_code != null && $order->customer->email != null && $order->customer->company != null ? '' : 'd-none'}} col-2">
                                    <div class="form-check">
                                        <input {{$order->is_print_red_invoice == 1 ? 'checked' : ''}} class="form-check-input"
                                               value="1" type="checkbox" id="gridCheck1" name="is_print_red_invoice">
                                        <label class="form-check-label" for="gridCheck1">
                                            Xuất hoá đơn đỏ
                                        </label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div id="red-bill-info"
                                         class="{{$order->is_print_red_invoice == 1 ? '' : 'd-none'}} card border radius-10">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center mb-4">
                                                <div>
                                                    <h5 class="mb-0">Thông tin xuất hoá đơn</h5>
                                                </div>
                                            </div>
                                            <p id="red-bill-info-company" class="d-flex justify-content-between"><strong>Tên công
                                                    ty: </strong><span>{{$order->customer->company}}</span></p>
                                            <p id="red-bill-info-tax_code" class="d-flex justify-content-between"><strong>Mã số
                                                    thuế: </strong><span>{{$order->customer->tax_code}}</span></p>
                                            <p id="red-bill-info-email" class="d-flex justify-content-between">
                                                <strong>Email: </strong><span>{{$order->customer->email}}</span></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="col-12">
                                    <div class="card border shadow-none bg-light radius-10">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center mb-4">
                                                <div>
                                                    <h5 class="mb-0">Chi tiết đơn hàng</h5>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-center mb-3">
                                                <div>
                                                    <p class="mb-0 fw-bolder">Tổng tiền:</p>
                                                </div>
                                                <div class="ms-auto">
                                                    <input type="hidden" name="order_total_product_price"
                                                           value="{{$order->order_total_product_price}}"/>
                                                    <h5 id="total-product-order"
                                                        class="mb-0">{{number_format($order->order_total_product_price)}}₫</h5>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-center mb-3">
                                                <div>
                                                    <p class="mb-0 fw-bolder">Chiết khấu:</p>
                                                </div>
                                                <div class="ms-auto">
                                                    <input type="hidden" name="order_discount"
                                                           value="{{$order->order_discount}}"/>
                                                    <h5 id="total-discount"
                                                        class="mb-0 text-danger">{{number_format($order->order_discount)}}₫</h5>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-center mb-3">
                                                <div>
                                                    <p class="mb-0 fw-bolder">Tổng tiền sau chiết khấu:</p>
                                                </div>
                                                <div class="ms-auto">
                                                    <input type="hidden" name="order_total"
                                                           value="{{$order->order_total}}"/>
                                                    <h5 id="total-order"
                                                        class="mb-0 text-danger">{{number_format($order->order_total)}}₫</h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div id="payment-info" class="card border radius-10">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center mb-4">
                                                <div>
                                                    <h5 class="mb-0">Thông tin thanh toán</h5>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <select id="payment-type" name="payment_type" class="form-select">
                                                    <option selected="" value="">Hình thức thanh toán</option>
                                                    @foreach(PAYMENTS_TYPE as $k => $v)
                                                        <option value="{{ $k }}"
                                                                @if($order->payment_type == $k) selected @endif>{{ $v }}</option>
                                                    @endforeach
                                                </select>
                                                <div class="invalid-feedback">Vui lòng nhập hình thức thanh toán</div>
                                            </div>
                                            <div>
                                                <select id="payment-method" name="payment_method"
                                                        class="form-select {{$order->payment_type == 3 ? 'd-none' : ''}}">
                                                    <option selected="" value="">Phương thức thanh toán</option>
                                                    @foreach(PAYMENTS_METHOD as $k => $v)
                                                        <option value="{{ $k }}"
                                                                @if($order->payment_method == $k) selected @endif>{{ $v }}</option>
                                                    @endforeach
                                                </select>
                                                <div class="invalid-feedback">Vui lòng nhập phương thức thanh toán</div>
                                            </div>
                                            <div id="payment-method-info"
                                                 class="{{$order->payment_method == 1 ? '' : 'd-none'}}">
                                                <div class="align-items-center mt-3">
                                                    <label for="" class="fw-bolder me-1" style="white-space: nowrap">Tên
                                                        chủ tài khoản: </label>
                                                    <input name="bank_customer_name" type="text" class="form-control"
                                                           placeholder="Nhập tên chủ tài khoản" autocomplete="off"
                                                           value="{{$order->bank_customer_name}}">
                                                    <div class="invalid-feedback">Vui lòng nhập tên chủ tài khoản</div>
                                                    <div>
                                                    </div>
                                                </div>
                                                <div class="align-items-center mt-3">
                                                    <label for="" class="fw-bolder me-1" style="white-space: nowrap">Tên
                                                        ngân hàng: </label>
                                                    <input name="bank_name" type="text" class="form-control"
                                                           placeholder="Nhập tên ngân hàng" autocomplete="off"
                                                           value="{{$order->bank_name}}">
                                                    <div class="invalid-feedback">Vui lòng nhập tên ngân hàng</div>

                                                    <div>
                                                    </div>
                                                </div>
                                                <div class="align-items-center mt-3">
                                                    <label for="" class="fw-bolder me-1" style="white-space: nowrap">Số
                                                        tài khoản: </label>
                                                    <input name="bank_code" type="text" class="form-control"
                                                           placeholder="Nhập số tài khoản" autocomplete="off"
                                                           value="{{$order->bank_code}}">
                                                    <div class="invalid-feedback">Vui lòng nhập số tài khoản</div>
                                                    <div>
                                                    </div>
                                                </div>

                                            </div>
                                            <div id="deposit"
                                                 class="{{$order->payment_type == 2 ? '' : 'd-none'}} align-items-center mt-3">
                                                <label for="" class="fw-bolder me-1" style="white-space: nowrap">Số tiền
                                                    cọc: </label>
                                                <input name="deposit" type="text" class="form-control"
                                                       placeholder="Nhập số tiền cọc" autocomplete="off"
                                                       value="{{$order->deposit > 0 ? number_format($order->deposit) : ''}}">
                                                <div class="invalid-feedback">Vui lòng nhập số tiền cọc</div>
                                                <div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <button style="width: 80px; margin-top: -10px" class="btn btn-success" type="submit">Lưu
                </button>
            </div>
        </div>
    </form>
    <div class="modal fade" id="deleteOrderDetailModal" tabindex="-1" aria-labelledby="deleteOrderDetailModalLabel"
         aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteOrderDetailModalLabel">Xóa sản phẩm khỏi đơn hàng</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">Bạn có chắc muốn xóa sản phẩm này?</div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy bỏ</button>
                    <button id="deleteOrderDetail" type="button" class="btn btn-danger">Xóa</button>
                </div>
            </div>
        </div>
    </div>
    @include('order.addProduct', compact('categories', 'discounts'))
@endsection
@section('script')
    <script src="js/order/add.js"></script>
    <script src="js/order/edit.js"></script>
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
            $productOrder.find('.product-price').closest('td').find('input:hidden').val(productPrice);
            $productOrder.find('.total').text(productPriceFormat);
            $productOrder.find('.quantity input').val(1);
            if (!isNaN(customerId) && !isNaN(discounts[customerId + '_' + productId])) {
                const discountPercent = discounts[customerId + '_' + productId];
                const pricePercent = new Intl.NumberFormat("en", {
                    maximumFractionDigits: 0,
                    minimumFractionDigits: 0,
                }).format(Math.max(productPrice - (productPrice * discountPercent) / 100, 0));
                $productOrder.find('.discount-percent input').attr('readonly', 'readonly').addClass('disabled').val(discounts[customerId + '_' + productId]);
                $productOrder.find('.unit-price').text(pricePercent);
                $productOrder.find('.unit-price').closest('td').find('input:hidden').val(Math.max(productPrice - (productPrice * discountPercent) / 100, 0));
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
            $('#delivery-info').find('span').text('');
            $('#red-bill-info').find('span').text('');
            $('#red-bill').find('input').removeAttr('checked');
            $('#payment-info').find('input').removeClass('is-invalid').val('');
            $('#payment-type').removeClass('is-invalid');
            if (customerId && customerId !== '') {
                appendCustomerInfo(customerId);
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
                $(this).find('.discount-percent input').val(0).removeAttr('readonly').removeClass('disabled');
                if (!isNaN(discounts[customerId + '_' + productId])) {
                    productPrice = parseFloat(productPrice.replace(/,/g, ''));
                    const discountPercent = discounts[customerId + '_' + productId];
                    const pricePercent = new Intl.NumberFormat("en", {
                        maximumFractionDigits: 0,
                        minimumFractionDigits: 0,
                    }).format(Math.max(productPrice - (productPrice * discountPercent) / 100, 0));
                    $(this).find('.discount-percent input').attr('readonly', 'readonly').addClass('disabled').val(discountPercent);
                    $(this).find('.unit-price').text(pricePercent);
                    $(this).find('.unit-price').closest('td').find('input:hidden').val(pricePercent);
                }
                $(this).find('.quantity input').trigger('blur');
            })
            totalOrder()
        });
    </script>
@endsection
