@extends('layouts.app')
@section('title')
    Đơn hàng
@endsection
@section('action')
    <div class="col-12">
        <a href="{{Auth::user()->role == WAREHOUSE_STAFF ? route('warehouse-staff.order.index') : route('order.index')}}" class="btn btn-sm btn-secondary">Quay lại</a>
    </div>
@endsection
@section('breadcrumb')
    {{$order->order_number}}
@endsection
@section('content')
    <div class="card">
        <div class="card-header py-3">
            <div class="row g-3 align-items-center">
                <div class="col-12 col-lg-8 col-md-6 me-auto">
                    <div class="d-flex justify-content-start align-items-center">
                        <h5 class="mb-0 me-3">Mã đơn hàng: {{$order->order_number}}</h5>
                        <span class="font-14 badge rounded-pill bg-{{STATUS_COLOR[$order->status]}}">{{STATUS_ORDER[$order->status]}}</span>
                    </div>
                </div>
                <div class="col-12 col-lg-4 col-6 col-md-3">
                    <p class="mb-1" style="float:right">{{date("d/m/Y", strtotime($order->order_date))}}</p>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="card border shadow-none radius-10">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table align-middle mb-0">
                                            <thead class="table-light">
                                            <tr>
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
                                            @foreach($order->orderDetail as $orderDetail)
                                                <tr class="productOrder" data-id="{{ $orderDetail->product_id }}"
                                                    id="orderDetail{{$orderDetail->id}}">
                                                    <td>
                                                        <div>
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
                                                        {{$orderDetail->note}}
                                                    </td>
                                                    <td>
                                                        {{number_format($orderDetail->product_price)}}
                                                    </td>
                                                    <td class="discount-percent">
                                                        {{ $orderDetail->discount_percent }}
                                                    </td>
                                                    <td>
                                                        {{number_format($orderDetail->unit_price)}}
                                                    </td>
                                                    <td class="quantity">
                                                        {{number_format($orderDetail->quantity)}}
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
                                        <p id="delivery-info-address" class="d-flex justify-content-between"><strong>Địa
                                                chỉ: </strong><span>{{$order->customer->address}}</span></p>
                                        <p id="delivery-info-phone" class="d-flex justify-content-between"><strong>Số điện
                                                thoại: </strong><span>{{$order->customer->phone}}</span></p>
                                        @if (!empty($order->shipping_address))
                                            <div class="align-items-center d-flex justify-content-between">
                                                <label for="" class="fw-bolder me-1" style="white-space: nowrap">Địa chỉ
                                                    giao
                                                    hàng: </label>
                                                <span>{{$order->shipping_address}}</span>
                                            </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-12 {{!empty($order->customer->tax_code) && !empty($order->customer->email) && !empty($order->customer->company) ? '' : 'd-none'}}">
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
                                        <div class=" d-flex justify-content-between">
                                            <label for="" class="fw-bolder me-1" style="white-space: nowrap">Phương thức thanh toán: </label>
                                            {{PAYMENTS_METHOD[$order->payment_method]}}
                                        </div>
                                        <div id="payment-method-info" class="{{$order->payment_method == 1 ? '' : 'd-none'}}">
                                            <div class="align-items-center mt-3 d-flex justify-content-between">
                                                <label for="" class="fw-bolder me-1" style="white-space: nowrap">Tên chủ tài
                                                    khoản: </label>
                                                {{$order->bank_customer_name}}
                                            </div>
                                            <div class="align-items-center mt-3 d-flex justify-content-between">
                                                <label for="" class="fw-bolder me-1" style="white-space: nowrap">Tên ngân
                                                    hàng: </label>
                                                {{$order->bank_name}}
                                            </div>
                                            <div class="align-items-center mt-3 d-flex justify-content-between">
                                                <label for="" class="fw-bolder me-1" style="white-space: nowrap">Số tài
                                                    khoản: </label>
                                                {{$order->bank_code}}
                                            </div>
                                        </div>
                                        <div id="deposit" class="{{$order->payment_type == 2 ? '' : 'd-none'}} align-items-center mt-3 d-flex justify-content-between">
                                            <label for="" class="fw-bolder me-1" style="white-space: nowrap">Số tiền
                                                cọc: </label>
                                            <h5 class="mb-0 text-danger">{{number_format($order->deposit)}}₫</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-4">
                    @if(in_array(Auth::user()->role, [SUPER_ADMIN, ADMIN, SALE]) && ($order->status == DRAFT || $order->status == REJECTED))
                        <a href="{{route('order.edit', $order->id)}}" style="width: 80px;" class="btn btn-primary">Sửa</a>
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
                </div>
                <div class="col-4">
                    <div class="d-flex justify-content-center align-items-center">
                        @if(in_array(Auth::user()->role, [SUPER_ADMIN, ADMIN, SALE]) && ($order->status == DRAFT || $order->status == REJECTED || $order->status == DELIVERY))
                            @if($order->status == DELIVERY)
                                <form class="d-none" id="update-status-order" method="POST" action="{{ route('order.updateStatusOrder', ['id' => $order->id, 'status' => DELIVERED]) }}">
                                    @csrf
                                    @method('PUT')
                                </form>
                            @else
                            <form class="d-none" id="update-status-order" method="POST" action="{{ route('order.updateStatusOrder', ['id' => $order->id, 'status' => $order->payment_type = PAYMENT_ON_DELIVERY ? CONFIRMED : AWAITING]) }}">
                                @csrf
                                @method('PUT')
                            </form>
                            @endif
                            <button id="sendOrderModalBtn" data-bs-target="#sendOrderModal" data-bs-toggle="modal" class="text-center btn btn-success me-2">Phê duyệt</button>
                        @endif
                        @if(in_array(Auth::user()->role, [SUPER_ADMIN, ADMIN, WAREHOUSE_STAFF]) && $order->status == CONFIRMED)
                            <form class="d-none" id="update-status-order-reject" method="POST" action="{{ route(Auth::user()->role == WAREHOUSE_STAFF ? 'warehouse-staff.order.updateStatusOrder' : 'order.updateStatusOrder', ['id' => $order->id, 'status' => REJECTED]) }}">
                                @csrf
                                @method('PUT')
                            </form>
                            <button id="rejectOrderModalBtn" data-bs-target="#rejectOrderModal" data-bs-toggle="modal" class="text-center btn btn-danger me-2">Từ chối</button>
                            <form class="d-none" id="update-status-order" method="POST" action="{{ route(Auth::user()->role == WAREHOUSE_STAFF ? 'warehouse-staff.order.updateStatusOrder' : 'order.updateStatusOrder', ['id' => $order->id, 'status' => DELIVERY]) }}">
                                @csrf
                                @method('PUT')
                            </form>
                            <button id="sendOrderModalBtn" data-bs-target="#sendOrderModal" data-bs-toggle="modal" class="text-center btn btn-success me-2">Phê duyệt</button>
                        @endif
                        @if(in_array($order->status, [CONFIRMED, DELIVERY, DELIVERED, COMPLETE]))
                            <button type="button" class="btn btn-primary"><i class="bi bi-printer-fill"></i> In</button>
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
    <div class="modal fade" id="sendOrderModal" tabindex="-1" aria-labelledby="sendOrderModalLabel"
         aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="sendOrderModalLabel">Phê duyệt đơn hàng</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">Bạn có chắc muốn phê duyệt đơn hàng này?</div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy bỏ</button>
                    <button onclick="$('#update-status-order').submit()" id="sendOrder" type="button" class="btn btn-success">Đồng ý</button>
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
                <div class="modal-body">Bạn có chắc muốn từ chối đơn hàng này?</div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy bỏ</button>
                    <button onclick="$('#update-status-order-reject').submit()" id="rejectOrder" type="button" class="btn btn-danger">Đồng ý</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="js/order/index.js"></script>
@endsection
