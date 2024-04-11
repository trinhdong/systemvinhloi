@extends('layouts.app')
@section('title')
    Đơn hàng
@endsection
@section('action')
    <div class="col-12">
        @if($isStocker)
            <a href="{{route('stocker.order.index')}}"
               class="btn btn-sm btn-secondary">Quay lại</a>
        @endif
        @if($isWareHouseStaff)
            <a href="{{route('warehouse-staff.order.index')}}"
               class="btn btn-sm btn-secondary">Quay lại</a>
        @endif
        @if($isAdmin || $isSale || $isAccountant)
            <a href="{{route('order.index')}}"
               class="btn btn-sm btn-secondary">Quay lại</a>
        @endif
    </div>
@endsection
@section('breadcrumb')
    {{$order->order_number}}
@endsection
@section('content')
    <div class="card">
        <div class="card-header py-3">
            <div class="row g-3 align-items-center">
                <div class="col-4 me-auto">
                    <div class="d-flex justify-content-start align-items-center">
                        <h5 class="mb-0 me-3">Mã đơn hàng: {{$order->order_number}}</h5>
                        <span class="font-14 badge rounded-pill bg-{{STATUS_COLOR[$order->status]}}">{{STATUS_ORDER[$order->status]}}</span>
                    </div>
                </div>
                @if(!$isAccountant && $order->has_update_quantity == HAD_UPDATE_QUANTITY)
                <div class="col-4 text-center">
                    <span class="text-danger">Thủ kho đã cập nhật lại số lượng thùng</span>
                </div>
                @endif
                <div class="col-4">
                    <p class="mb-1" style="float:right">{{date(FORMAT_DATE_VN, strtotime($order->order_date))}}</p>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="{{$isAdmin || $isSale || $isAccountant || $isStocker ? 'col-12' : 'col-7'}}">
                            <div class="card border shadow-none radius-10">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table align-middle mb-0">
                                            <thead class="table-light">
                                            <tr>
                                                <th>Sản phẩm</th>
                                                @if($isAdmin || $isSale || $isAccountant || $isStocker)
                                                    <th>Ghi chú</th>
                                                @endif
                                                <th>Màu sắc</th>
                                                <th>Dung tích</th>
                                                <th>Đơn vị tính</th>
                                                @if($isAdmin || $isSale || $isAccountant || $isStocker)
                                                    <th>Giá</th>
                                                    <th>Chiết khấu (%)</th>
                                                    <th>Số tiền chiết khấu</th>
                                                    <th>Ghi chú chiết khấu</th>
                                                    <th>Giá sau chiết khấu</th>
                                                @endif
                                                <th>Số lượng thùng</th>
                                                @if($isAdmin || $isSale || $isAccountant || $isStocker)
                                                    <th>Tổng tiền sau chiết khấu</th>
                                                @endif
                                            </tr>
                                            </thead>
                                            <tbody id="orderlist">
                                            @foreach($order->orderDetail as $orderDetail)
                                                <tr class="productOrder" data-id="{{ $orderDetail->product_id }}"
                                                    id="orderDetail{{$orderDetail->id}}">
                                                    <td>
                                                        <div>
                                                            <div class="d-flex align-items-center gap-2">
                                                                <div class="product-box product-image">
                                                                    <img src="{{ $orderDetail->product->image_url }}"
                                                                         alt="">
                                                                </div>
                                                                <div>
                                                                    <P class="mb-0 product-title">{{ $orderDetail->product->product_name }}</P>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    @if($isAdmin || $isSale || $isAccountant || $isStocker)
                                                        <td style="min-width:150px">
                                                            {{$orderDetail->note}}
                                                        </td>
                                                    @endif
                                                    <td>
                                                        {{$orderDetail->product->color}}
                                                    </td>
                                                    <td>
                                                        {{$orderDetail->product->capacity}}
                                                    </td>
                                                    <td>
                                                        {{$orderDetail->product->unit}}
                                                    </td>
                                                    @if($isAdmin || $isSale || $isAccountant || $isStocker)
                                                        <td>
                                                            {{number_format($orderDetail->product_price)}}
                                                        </td>
                                                        <td class="discount-percent">
                                                            {{ rtrim(rtrim(number_format($orderDetail->discount_percent, 4), '0'), '.') }}%
                                                        </td>
                                                        <td class="discount-price">
                                                            {{ number_format($orderDetail->discount_price) }}
                                                        </td>
                                                        <td>
                                                            {{ $orderDetail->discount_note }}
                                                        </td>
                                                        <td>
                                                            {{number_format($orderDetail->unit_price)}}
                                                        </td>
                                                    @endif
                                                    <td class="quantity">
                                                        {{number_format($orderDetail->quantity)}}
                                                    </td>
                                                    @if($isAdmin || $isSale || $isAccountant || $isStocker)
                                                        <td class="total">{{number_format($orderDetail->unit_price*$orderDetail->quantity)}}</td>
                                                    @endif
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-7">
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
                                        <p id="delivery-info-phone" class="d-flex justify-content-between"><strong>Số
                                                điện
                                                thoại: </strong><span>{{$order->customer->phone}}</span></p>
                                        <p id="delivery-info-address" class="d-flex justify-content-between"><strong>Địa
                                                chỉ: </strong><span>{{$order->customer->address}}</span></p>
                                        <div class="align-items-center d-flex justify-content-between">
                                            <label for="" class="fw-bolder me-1" style="white-space: nowrap">Địa chỉ
                                                giao
                                                hàng: </label>
                                            <span>{{$order->shipping_address ?? $order->customer->address}}</span>
                                        </div>
                                        @if (!empty($order->delivery_appointment_date))
                                        <div class="align-items-center d-flex justify-content-between mt-3">
                                            <label for="" class="fw-bolder me-1" style="white-space: nowrap">Ngày hẹn giao hàng: </label>
                                            <span>{{date(FORMAT_DATE_VN, strtotime($order->delivery_appointment_date))}}</span>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @if($isAdmin || $isSale || $isAccountant || $isStocker)
                                <div class="col-12 {{!empty($order->customer->tax_code) && !empty($order->customer->email) && !empty($order->customer->company) && !empty($order->customer->company_address) ? '' : 'd-none'}}">
                                    <div id="red-bill-info"
                                         class="{{$order->is_print_red_invoice == PRINTED_RED_INVOICE ? '' : 'd-none'}} card border radius-10">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center mb-4">
                                                <div>
                                                    <h5 class="mb-0">Thông tin xuất hoá đơn</h5>
                                                </div>
                                            </div>
                                            <p id="red-bill-info-company" class="d-flex justify-content-between">
                                                <strong>Tên
                                                    công
                                                    ty: </strong><span>{{$order->customer->company}}</span></p>
                                            <p id="red-bill-info-company-address"
                                               class="d-flex justify-content-between">
                                                <strong>Địa chỉ công
                                                    ty: </strong><span>{{$order->customer->company_address}}</span></p>
                                            <p id="red-bill-info-tax_code" class="d-flex justify-content-between">
                                                <strong>Mã
                                                    số
                                                    thuế: </strong><span>{{$order->customer->tax_code}}</span></p>
                                            <p id="red-bill-info-email" class="d-flex justify-content-between">
                                                <strong>Email: </strong><span>{{$order->customer->email}}</span></p>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            <div class="col-12">
                                <div id="order-note" class="card border radius-10">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center mb-4">
                                            <div>
                                                <h5 class="mb-0">Ghi chú đơn hàng</h5>
                                            </div>
                                        </div>
                                        <div>
                                            {{$order->order_note}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if($isAdmin || $isSale || $isAccountant || $isStocker)
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
                                                    <h5 id="total-product-order"
                                                        class="mb-0">{{number_format($order->order_total_product_price)}}₫</h5>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-center mb-3">
                                                <div>
                                                    <p class="mb-0 fw-bolder">Chiết khấu:</p>
                                                </div>
                                                <div class="ms-auto">
                                                    <h5 id="total-discount"
                                                        class="mb-0 text-danger">{{number_format($order->order_discount)}}₫</h5>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-center mb-3">
                                                <div>
                                                    <p class="mb-0 fw-bolder">Tổng tiền sau chiết khấu:</p>
                                                </div>
                                                <div class="ms-auto">
                                                    <h5 id="total-order"
                                                        class="mb-0 text-danger">{{number_format($order->order_total)}}₫</h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div id="payment-info" class="card border shadow-none bg-light radius-10">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center mb-4">
                                                <div>
                                                    <h5 class="mb-0">Thông tin thanh toán</h5>
                                                </div>
                                            </div>
                                            <div class="mb-3 d-flex justify-content-between">
                                                <label for="" class="fw-bolder me-1" style="white-space: nowrap">Hình thức thanh toán: </label>
                                                {{PAYMENTS_TYPE[$order->payment_type]}}
                                            </div>
                                            @if(!empty($order->payment_method))
                                                <div class=" d-flex justify-content-between">
                                                    <label for="" class="fw-bolder me-1" style="white-space: nowrap">Phương thức thanh toán: </label>
                                                    {{PAYMENTS_METHOD[$order->payment_method]}}
                                                </div>
                                            @endif
                                            <div id="payment-method-info" class="{{$order->payment_method == TRANFER ? '' : 'd-none'}}">
                                                <label for="" class="fw-bolder me-1 mt-3" style="white-space: nowrap">Tài khoản chuyển tiền: </label>
                                                <div class="card border shadow-none bg-light radius-10">
                                                    <div class="card-body">
                                                        <div class="align-items-center d-flex justify-content-between">
                                                            <label for="" class="fw-bolder me-1" style="white-space: nowrap">Tên ngân hàng: </label>
                                                            {{$order->bank_name}}
                                                        </div>
                                                        <div class="align-items-center mt-3 d-flex justify-content-between">
                                                            <label for="" class="fw-bolder me-1" style="white-space: nowrap">Số tài khoản: </label>
                                                            {{$order->bank_code}}
                                                        </div>
                                                        <div class="align-items-center mt-3 d-flex justify-content-between">
                                                            <label for="" class="fw-bolder me-1" style="white-space: nowrap">Tên chủ tài khoản: </label>
                                                            {{$order->bank_customer_name}}
                                                        </div>
                                                    </div>
                                                </div>
                                                @if(!empty($order->bankAccount))
                                                <label for="" class="fw-bolder me-1" style="white-space: nowrap">Tài khoản nhận tiền: </label>
                                                <div class="card border radius-10 shadow-none bg-light">
                                                    <div class="card-body">
                                                        <div class="align-items-center d-flex justify-content-between">
                                                            <label for="" class="fw-bolder me-1" style="white-space: nowrap">Tên ngân hàng: </label>
                                                            {{$order->bankAccount->bank_name ?? ''}}
                                                        </div>
                                                        <div class="align-items-center mt-3 d-flex justify-content-between">
                                                            <label for="" class="fw-bolder me-1" style="white-space: nowrap">Số tài khoản: </label>
                                                            {{$order->bankAccount->bank_code ?? ''}}
                                                        </div>
                                                        <div class="align-items-center mt-3 d-flex justify-content-between">
                                                            <label for="" class="fw-bolder me-1" style="white-space: nowrap">Tên chủ tài khoản: </label>
                                                            {{$order->bankAccount->bank_account_name ?? ''}}
                                                        </div>
                                                        @if($order->bankAccount->bank_branch !== null)
                                                        <div class="align-items-center mt-3 d-flex justify-content-between">
                                                            <label for="" class="fw-bolder me-1" style="white-space: nowrap">Tên chi nhánh: </label>
                                                            {{$order->bankAccount->bank_branch ?? ''}}
                                                        </div>
                                                        @endif
                                                    </div>
                                                </div>
                                                @endif
                                            </div>
                                            <div id="deposit"
                                                 class="{{$order->payment_type == DEPOSIT ? '' : 'd-none'}} align-items-center mt-3 d-flex justify-content-between">
                                                <label for="" class="fw-bolder me-1" style="white-space: nowrap">Số tiền cọc: </label>
                                                <h5 class="mb-0 text-danger">{{number_format($order->deposit)}}₫</h5>
                                            </div>
                                            @if($order->payment_status == DEPOSITED || $order->payment_status == PAID)
                                                <div id="paid"
                                                     class="align-items-center mt-3 d-flex justify-content-between">
                                                    <label for="" class="fw-bolder me-1" style="white-space: nowrap">Số tiền đã thanh toán: </label>
                                                    <h5 class="mb-0 text-danger">{{number_format($order->paid)}}₫</h5>
                                                </div>
                                                <div id="payment_date" class="{{$order->payment_type == PAYMENT_ON_DELIVERY ? 'd-none' : ''}} align-items-center mt-3 d-flex justify-content-between">
                                                    <label for="" class="fw-bolder me-1" style="white-space: nowrap">Ngày thanh toán: </label>
                                                    <h5 class="mb-0 text-danger">{{!empty($order->payment_date) ? date(FORMAT_DATE_VN, strtotime($order->payment_date)) : ''}}</h5>
                                                </div>
                                            @endif
                                            @if(!empty($order->payment_due_day))
                                            <div id="payment_date" class="{{$order->payment_type == PAYMENT_ON_DELIVERY ? '' : 'd-none'}} align-items-center mt-3 d-flex justify-content-between">
                                                <label for="" class="fw-bolder me-1" style="white-space: nowrap">Ngày đến hạn thanh toán: </label>
                                                <h5 class="mb-0 text-danger">{{$order->payment_due_day}}</h5>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                    </div>
                </div>
            </div>

            @if(!$comments->isEmpty())
                <div class="card">
                    <div class="card-body col-7">
                        <table class="table align-middle border last-child-right">
                            <thead class="table-secondary">
                            <tr>
                                <th class="col-2">Nhân viên</th>
                                <th class="col-2">Trạng thái</th>
                                <th class="">Ghi chú</th>
                                <th class="col-2 text-right">Thời gian cập nhật</th>
                            </tr>
                            </thead>
                            <tbody class="bd-content-stable">
                            @foreach($comments as $comment)
                                <tr>
                                    <td>{{$users[$comment->created_by]}}</td>
                                    <td>
                                        <span class="badge rounded-pill bg-{{STATUS_COLOR[$comment->status]}}">{{STATUS_ORDER[$comment->status]}}</span>
                                    </td>
                                    <td>{{$comment->note}}</td>
                                    <td class="text-right">{{date(FORMAT_DATE_TIME_VN, strtotime($comment->created_at))}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
            <div class="row">
                <div class="col-4">
                    @if(($isAdmin || $isSale) && ($order->status == DRAFT || $order->status == REJECTED))
                        <a href="{{route('order.edit', $order->id)}}" style="width: 80px;"
                           class="btn btn-primary">Sửa</a>
                        <form class="d-none" id="formDeleteOrder{{$order->id}}"
                              action="{{ route('order.delete', $order->id) }}"
                              method="POST">
                            @csrf
                            @method('DELETE')
                        </form>
                        <a style="width: 80px;" href="javascript:;" id="deleteOrderModalBtn"
                           class="btn btn-danger"
                           data-bs-tooltip="tooltip"
                           data-bs-toggle="modal"
                           data-bs-placement="bottom" title="Xóa"
                           data-bs-target="#deleteOrderModal"
                           data-order-id="{{$order->id}}">
                            Xóa
                        </a>
                    @endif
                    @if($isStocker && $order->status == IN_PROCESSING && ($order->payment_type === PAYMENT_ON_DELIVERY || $order->payment_type === DEPOSIT))
                        <a href="{{route('stocker.order.edit', $order->id)}}" style="width: 80px;"
                           class="btn btn-primary">Sửa</a>
                    @endif
                </div>
                <div class="col-4">
                    <div class="d-flex justify-content-center align-items-center">
                        @if(($isAdmin || $isSale) && ($order->status == DRAFT || $order->status == REJECTED))
                            @if($order->payment_status === DEPOSITED || $order->payment_status === PAID || $order->payment_type === PAYMENT_ON_DELIVERY)
                            <form class="d-none" id="update-status-order" method="POST"
                                  action="{{ route('order.updateStatusOrder', ['id' => $order->id]) }}">
                                @csrf
                                @method('PUT')
                            </form>
                            <button id="approveOrderModalBtn" data-bs-target="#approveOrderModal" data-bs-toggle="modal"
                                    class="text-center btn btn-primary me-2">Gửi đơn hàng
                            </button>
                            <div class="modal fade" id="approveOrderModal" tabindex="-1"
                                 aria-labelledby="approveOrderModalLabel"
                                 aria-hidden="true" style="display: none;">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="approveOrderModalLabel">Gửi đơn hàng</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            Bạn muốn gửi đơn hàng này?
                                            <div class="mb-3 mt-3">
                                                <label for="approveNote" class="form-label">Ghi chú:</label>
                                                <textarea class="form-control" id="approveNote" name="note"
                                                          rows="3"></textarea>
                                                <div class="invalid-feedback">Vui lòng nhập ghi chú</div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy
                                                bỏ
                                            </button>
                                            <button id="approveOrder" type="button" class="btn btn-success">Đồng ý
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                            @if($order->status === DRAFT && $order->payment_status === UNPAID && ($order->payment_type === DEPOSIT || $order->payment_type === PAY_FULL))
                                <form class="d-none" id="update-check-payment-order" method="POST"
                                      action="{{ route('order.updateStatusPayment', ['id' => $order->id]) }}">
                                    @csrf
                                    @method('PUT')
                                </form>
                                <button id="approvePaymentOrderModalBtn" data-bs-target="#approvePaymentOrderModal" data-bs-toggle="modal"
                                        class="text-center btn btn-success me-2">Xác nhận thanh toán
                                </button>
                                <div class="modal fade" id="approvePaymentOrderModal" tabindex="-1"
                                     aria-labelledby="approvePaymentOrderModalLabel"
                                     aria-hidden="true" style="display: none;">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="approvePaymentOrderModalLabel">Xác nhận thanh toán</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                Bạn muốn xác nhận thanh toán của đơn hàng này?
                                                <div class="mb-3 mt-3">
                                                    <label for="approveNote" class="form-label">Ghi chú:</label>
                                                    <textarea class="form-control" id="approveNote" name="note"
                                                              rows="3"></textarea>
                                                    <div class="invalid-feedback">Vui lòng nhập ghi chú</div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy
                                                    bỏ
                                                </button>
                                                <button id="approvePaymentOrder" type="button" class="btn btn-success">Đồng ý
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endif
                        @if(($isAdmin || $isStocker) && (in_array($order->status, [IN_PROCESSING, DELIVERY])))
                            @if($order->status == IN_PROCESSING && $order->payment_status == UNPAID)
                                <form class="d-none" id="update-status-order-reject" method="POST"
                                      action="{{ route($isStocker ? 'stocker.order.updateStatusOrder' : 'order.updateStatusOrder', ['id' => $order->id, 'status' => REJECTED]) }}">
                                    @csrf
                                    @method('PUT')
                                </form>
                                <button id="rejectOrderModalBtn" data-bs-target="#rejectOrderModal"
                                        data-bs-toggle="modal"
                                        class="text-center btn btn-danger me-2">Từ chối
                                </button>
                            @endif
                            <form class="d-none" id="update-status-order" method="POST"
                                  action="{{ route($isStocker ? 'stocker.order.updateStatusOrder' : 'order.updateStatusOrder', ['id' => $order->id]) }}">
                                @csrf
                                @method('PUT')
                            </form>
                            <button id="approveOrderModalBtn" data-bs-target="#approveOrderModal" data-modal-body=""
                                    data-bs-toggle="modal"
                                    class="text-center btn btn-primary me-2">{{STATUS_ORDER_BUTTON[$order->status == IN_PROCESSING ? DELIVERY : DELIVERED]}}
                            </button>
                            <div class="modal fade" id="approveOrderModal" tabindex="-1"
                                 aria-labelledby="approveOrderModalLabel"
                                 aria-hidden="true" style="display: none;">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="approveOrderModalLabel">Cập nhật tình trạng đơn
                                                hàng</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            Bạn muốn cập nhật tình trạng đơn hàng là
                                            <strong>{{STATUS_ORDER[$order->status == IN_PROCESSING ? DELIVERY : DELIVERED]}}</strong>?
                                            <div class="mb-3 mt-3">
                                                <label for="approveNote" class="form-label">Ghi chú:</label>
                                                <textarea class="form-control" id="approveNote" name="note"
                                                          rows="3"></textarea>
                                                <div class="invalid-feedback">Vui lòng nhập ghi chú</div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy
                                                bỏ
                                            </button>
                                            <button id="approveOrder" type="button" class="btn btn-success">Đồng ý
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                        @if(in_array($order->status, [DELIVERY, DELIVERED, COMPLETE]))
                            @if($isAdmin || $isStocker)
                                <a href="{{route('stocker.order.printInvoice', $order->id)}}" target="_blank" id="printButton" type="button" class="btn btn-success me-3"><i
                                        class="bi bi-printer-fill"></i> In đơn hàng
                                </a>
                                <a href="{{route('order.printDeliveryBill', $order->id)}}" target="_blank" id="printButton" type="button" class="btn btn-primary"><i
                                        class="bi bi-printer-fill"></i> In phiếu kho
                                </a>
                            @endif
                            @if($isSale)
                                <a href="{{route('order.printInvoice', $order->id)}}" target="_blank" id="printButton" type="button" class="btn btn-success"><i
                                        class="bi bi-printer-fill"></i> In
                                </a>
                            @endif
                        @endif
                    </div>
                </div>
                <div class="col-4"></div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="deleteOrderModal" tabindex="-1" aria-labelledby="deleteOrderModalLabel"
         aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteOrderModalLabel">Xóa đơn hàng</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">Bạn có chắc muốn xóa đơn hàng này?</div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy bỏ</button>
                    <button id="deleteOrder" type="button" class="btn btn-danger">Xóa</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="rejectOrderModal" tabindex="-1" aria-labelledby="rejectOrderModalLabel"
         aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="rejectOrderModalLabel">Từ chối đơn hàng</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Bạn có chắc muốn từ chối đơn hàng này?
                    <div class="mb-3 mt-3">
                        <label for="rejectNote" class="form-label">Ghi chú:</label>
                        <textarea class="form-control" id="rejectNote" name="note" rows="3"></textarea>
                        <div class="invalid-feedback">Vui lòng nhập ghi chú</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy bỏ</button>
                    <button id="rejectOrder" type="button" class="btn btn-danger">Đồng ý</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="js/order/index.js"></script>
    <script src="js/order/detail.js"></script>
@endsection
