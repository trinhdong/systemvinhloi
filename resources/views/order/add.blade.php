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
            <div class="card-body">
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
                                                    <th>Màu sắc</th>
                                                    <th>Dung tích</th>
                                                    <th>Đơn vị tính</th>
                                                    <th>Giá</th>
                                                    <th>Chiết khấu</th>
                                                    <th>Giá sau chiết khấu</th>
                                                    <th>Số lượng</th>
                                                    <th>Tổng tiền sau chiết khấu</th>
                                                </tr>
                                                </thead>
                                                <tbody id="orderlist">
                                                <tr id="empty-row">
                                                    <td colspan="11" class="text-center">Chưa có sản phẩm nào được thêm
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
                                                        <textarea disabled name="note[]" id="" cols="1" rows="1"
                                                                  class="form-control"></textarea>
                                                    </td>
                                                    <td class="product-color"></td>
                                                    <td class="product-capacity"></td>
                                                    <td class="product-unit"></td>
                                                    <td>
                                                        <div class="product-price"></div>
                                                        <input disabled type="hidden" name="product_price[]"/>
                                                    </td>
                                                    <td class="discount-percent">
                                                        <div class="input-group has-validation">
                                                            <input disabled name="discount_percent[]" type="text"
                                                                   class="form-control"
                                                                   placeholder="0" autocomplete="off">
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
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-7">
                                <div class="col-12">
                                    <div id="delivery-info" class="d-none card border radius-10">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center mb-4">
                                                <div>
                                                    <h5 class="mb-0">Thông tin giao hàng</h5>
                                                </div>
                                            </div>
                                            <p id="delivery-info-name" class="d-flex justify-content-between"><strong>Tên: </strong></p>
                                            <p id="delivery-info-phone" class="d-flex justify-content-between"><strong>Số điện thoại: </strong></p>
                                            <p id="delivery-info-address" class="d-flex justify-content-between"><strong>Địa chỉ: </strong></p>
                                            <div class="align-items-center justify-content-between">
                                                <label for="" class="fw-bolder me-1" style="white-space: nowrap">Địa
                                                    chỉ giao hàng: </label>
                                                <input name="shipping_address" type="text" class="form-control"
                                                       placeholder="Nhập địa chỉ giao hàng" autocomplete="off">
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
                                                              rows="2"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="red-bill" class="d-none col-2">
                                    <div class="form-check">
                                        <input class="form-check-input" value="1" type="checkbox" id="gridCheck1"
                                               name="is_print_red_invoice">
                                        <label class="form-check-label" for="gridCheck1">
                                            Xuất hoá đơn đỏ
                                        </label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div id="red-bill-info" class="d-none card border radius-10">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center mb-4">
                                                <div>
                                                    <h5 class="mb-0">Thông tin xuất hoá đơn</h5>
                                                </div>
                                            </div>
                                            <p id="red-bill-info-company" class="d-flex justify-content-between"><strong>Tên công ty: </strong></p>
                                            <p id="red-bill-info-company-address" class="d-flex justify-content-between"><strong>Địa chỉ công ty: </strong></p>
                                            <p id="red-bill-info-tax_code" class="d-flex justify-content-between"><strong>Mã số thuế: </strong></p>
                                            <p id="red-bill-info-email" class="d-flex justify-content-between"><strong>Email: </strong></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-5">
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
                                                    <input type="hidden" name="order_total_product_price"/>
                                                    <h5 id="total-product-order" class="mb-0">0₫</h5>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-center mb-3">
                                                <div>
                                                    <p class="mb-0 fw-bolder">Chiết khấu:</p>
                                                </div>
                                                <div class="ms-auto">
                                                    <input type="hidden" name="order_discount"/>
                                                    <h5 id="total-discount" class="mb-0 text-danger">0₫</h5>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-center mb-3">
                                                <div>
                                                    <p class="mb-0 fw-bolder">Tổng tiền sau chiết khấu:</p>
                                                </div>
                                                <div class="ms-auto">
                                                    <input type="hidden" name="order_total"/>
                                                    <h5 id="total-order" class="mb-0 text-danger">0₫</h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div id="payment-info" class="d-none card border radius-10">
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
                                                        <option value="{{ $k }}">{{ $v }}</option>
                                                    @endforeach
                                                </select>
                                                <div class="invalid-feedback">Vui lòng nhập hình thức thanh toán
                                                </div>
                                            </div>
                                            <div>
                                                <select id="payment-method" name="payment_method"
                                                        class="d-none form-select d-none">
                                                    <option selected="" value="">Phương thức thanh toán</option>
                                                    @foreach(PAYMENTS_METHOD as $k => $v)
                                                        <option value="{{ $k }}">{{ $v }}</option>
                                                    @endforeach
                                                </select>
                                                <div class="invalid-feedback">Vui lòng nhập phương thức thanh toán
                                                </div>
                                            </div>
                                            <div id="payment-method-info" class="d-none">
                                                <div class="align-items-center mt-3">
                                                    <label for="" class="fw-bolder me-1"
                                                           style="white-space: nowrap">Tên chủ tài khoản: </label>
                                                    <input name="bank_customer_name" type="text"
                                                           class="form-control"
                                                           placeholder="Nhập tên chủ tài khoản" autocomplete="off">
                                                    <div class="invalid-feedback">Vui lòng nhập tên chủ tài khoản
                                                    </div>
                                                    <div>
                                                    </div>
                                                </div>
                                                <div class="align-items-center mt-3">
                                                    <label for="" class="fw-bolder me-1"
                                                           style="white-space: nowrap">Tên ngân hàng: </label>
                                                    <input name="bank_name" type="text" class="form-control"
                                                           placeholder="Nhập tên ngân hàng" autocomplete="off">
                                                    <div class="invalid-feedback">Vui lòng nhập tên ngân hàng</div>

                                                    <div>
                                                    </div>
                                                </div>
                                                <div class="align-items-center mt-3">
                                                    <label for="" class="fw-bolder me-1"
                                                           style="white-space: nowrap">Số tài khoản: </label>
                                                    <input name="bank_code" type="text" class="form-control"
                                                           placeholder="Nhập số tài khoản" autocomplete="off">
                                                    <div class="invalid-feedback">Vui lòng nhập số tài khoản</div>
                                                    <div>
                                                    </div>
                                                </div>

                                            </div>
                                            <div id="deposit" class="d-none align-items-center">
                                                <label for="" class="fw-bolder me-1" style="white-space: nowrap">Số
                                                    tiền cọc: </label>
                                                <input name="deposit" type="text" class="form-control"
                                                       placeholder="Nhập số tiền cọc" autocomplete="off">
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
                <button style="width: 80px; margin-top: -10px" class="btn btn-success" type="submit">Lưu</button>
            </div>
        </div>
    </form>

    @include('order.addProduct', compact('categories', 'discounts'))
@endsection
@section('script')
    <script>const discounts = {!! json_encode($discounts) !!};</script>
    <script src="{{ asset('js/order/add.js') }}"></script>
@endsection
