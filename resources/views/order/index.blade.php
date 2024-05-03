@extends('layouts.app')
@section('title')
    Đơn hàng
@endsection
@section('breadcrumb')
    Danh sách đơn hàng
@endsection
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="d-flex justify-content-between m-2 row">
                <div class="col-sm-10 mb-2">
                    <form id="form-search" class="position-relative">
                        <div class="row">
                            <div class="col-4">
                                <div class="position-absolute translate-middle-y search-icon px-3" style="top:20px"><i
                                            class="bi bi-search"></i></div>
                                <input onchange="$('#form-search').submit()" class="form-control ps-5 rounded" type="text"
                                       placeholder="Nhập nội dung tìm kiếm"
                                       name="query" value="{{ request('query') }}">
                            </div>
                            <div class="col-3">
                                <input onchange="$('#form-search').submit()" name="order_date" type="text" id="datepicker"
                                       placeholder="Ngày tạo đơn hàng" autocomplete="off"
                                       class="form-control" value="{{ request('order_date') ?? '' }}" >
                            </div>
                            <div class="col-3">
                                <input onchange="$('#form-search').submit()" name="delivery_appointment_date" type="text" id="delivery-appointment-date"
                                       placeholder="Ngày hẹn giao hàng" autocomplete="off"
                                       class="form-control" value="{{ request('delivery_appointment_date') ?? '' }}" >
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-3">
                                <select onchange="$('#form-search').submit()" name="customer_id" class="form-select single-select">
                                    <option selected="" value="">Chọn khách hàng</option>
                                    @foreach($customers as $customerId => $customerName)
                                        <option value="{{ $customerId }}"
                                                @if(intval(request('customer_id')) === $customerId) selected @endif>{{ $customerName }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @if($isAdmin || $isAccountant)
                            <div class="col-3">
                                <select onchange="$('#form-search').submit()" name="sale_id" class="form-select single-select">
                                    <option selected="" value="">Nhân viên bán hàng</option>
                                    @foreach($sales as $saleId => $saleName)
                                        <option value="{{ $saleId }}"
                                                @if(intval(request('sale_id')) === $saleId) selected @endif>{{ $saleName }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @endif
                            <div class="col-3">
                                <select onchange="$('#form-search').submit()" name="status" class="form-select single-select">
                                    <option selected="" value="">Chọn trạng thái đơn hàng</option>
                                    @foreach($statusList as $status => $statusName)
                                        <option value="{{ $status }}"
                                                @if(intval(request('status')) === $status) selected @endif>{{ $statusName }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-3">
                                <select onchange="$('#form-search').submit()" name="payment_status" class="form-select single-select">
                                    <option selected="" value="">Chọn trạng thái thanh toán</option>
                                    @foreach($paymentStatus as $status => $statusName)
                                        <option value="{{ $status }}"
                                                @if(intval(request('payment_status')) === $status) selected @endif>{{ $statusName }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-2">
                    @if($isAdmin || $isSale)
                        <a href="{{route('order.add')}}" class="btn btn-primary float-end">Thêm đơn hàng</a>
                    @endif
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive mt-3">
                        <table class="table align-middle last-child-right">
                            <thead class="table-secondary">
                            <tr>
                                <th>#</th>
                                <th>Mã đơn hàng</th>
                                <th>Tên khách hàng</th>
                                @if($isAdmin || $isAccountant)
                                    <th>Nhân viên bán hàng</th>
                                @endif
                                @if($isAdmin || $isSale || $isAccountant)
                                <th>Tổng tiền</th>
                                @endif
                                <th>Trạng thái đơn hàng</th>
                                <th>Trạng thái thanh toán</th>
                                <th>Ngày hẹn giao hàng</th>
                                <th>Ngày tạo</th>
                                <th class="col-1">Hành động</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if($orders->isEmpty())
                                <tr>
                                    <td colspan="{{$isWareHouseStaff ? 9 : ($isAdmin || $isAccountant ? 11 : 10)}}" class="text-center">Không tìm thấy dữ liệu</td>
                                </tr>
                            @else
                                @foreach($orders as $key => $order)
                                    <?php
                                        $isLastDayDelivered = $isStocker && $order->status === IN_PROCESSING && !empty($order->delivery_appointment_date) && date(FORMAT_DATE_VN, strtotime($order->delivery_appointment_date)) <= date(FORMAT_DATE_VN, strtotime($order->order_date));
                                        $enableButton = $order->enableButtonByRole(Auth::user()->role);
                                    ?>
                                    <tr style="background-color: {{$isLastDayDelivered ? 'red' : ''}}">
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $order->order_number }}</td>
                                        <td>{{ $order->customer->customer_name }}</td>
                                        @if($isAdmin || $isAccountant)
                                        <td>{{ $order->user->name ?? '' }}</td>
                                        @endif
                                        @if($isAdmin || $isSale || $isAccountant)
                                        <td>{{ number_format($order->order_total) }}</td>
                                        @endif
                                        <td>
                                            <span class="badge rounded-pill bg-{{STATUS_COLOR[$order->status]}}">{{STATUS_ORDER[$order->status]}}</span>
                                        </td>
                                        <td>
                                            <span class="badge rounded-pill bg-{{STATUS_PAYMENT_COLOR[$order->payment_status]}}">{{STATUS_PAYMENT[$order->payment_status]}}</span>
                                        </td>
                                        <td>{{ !empty($order->delivery_appointment_date) ? Date::parse($order->delivery_appointment_date)->format(FORMAT_DATE_VN) : '' }}</td>
                                        <td>{{ Date::parse($order->order_date)->format(FORMAT_DATE_VN) }}</td>
                                        <td>
                                            <div class="table-actions d-flex align-items-center justify-content-center gap-3 fs-6">
                                                @if($isWareHouseStaff || $isAccountant)
                                                    <a href="{{ route($isAccountant ? 'order.detail' : 'warehouse-staff.order.detail', $order->id) }}" class="text-primary"
                                                       data-bs-toggle="tooltip"
                                                       data-bs-placement="bottom" title="Xem"><i class="bi bi-eye-fill"></i></a>
                                                @else
                                                    @if($enableButton['view'])
                                                    <a href="{{ route($isStocker ? 'stocker.order.detail' : 'order.detail', $order->id) }}" class="text-primary"
                                                       data-bs-toggle="tooltip"
                                                       data-bs-placement="bottom" title="Xem"><i class="bi bi-eye-fill"></i></a>
                                                    @else
                                                        <div class="text-primary"
                                                           data-bs-toggle="tooltip"
                                                           data-bs-placement="bottom" title="Xem"><i class="bi bi-eye-fill" style="color: #e9ecef"></i></div>
                                                    @endif
                                                    @if($enableButton['edit'] || ($isStocker && $order->status === IN_PROCESSING && ($order->payment_type === PAYMENT_ON_DELIVERY || $order->payment_type === DEPOSIT)))
                                                    <a href="{{ route($isStocker ? 'stocker.order.edit' : 'order.edit', $order->id) }}" class="text-warning"
                                                       data-bs-toggle="tooltip"
                                                       data-bs-placement="bottom"
                                                       title="Chỉnh sửa">
                                                        <i class="bi bi-pencil-fill"></i></a>
                                                    @else
                                                            <div class="text-warning"
                                                               data-bs-toggle="tooltip"
                                                               data-bs-placement="bottom"
                                                               title="Chỉnh sửa">
                                                                <i class="bi bi-pencil-fill" style="color: #e9ecef"></i></div>
                                                    @endif
                                                    @if($enableButton['delete'] || $isAdmin)
                                                    <form class="d-none" id="formDeleteOrder{{$order->id}}"
                                                          action="{{ route('order.delete', $order->id) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>
                                                    <a href="javascript:;" id="deleteOrderModalBtn"
                                                       class="text-danger pointer-event"
                                                       data-bs-tooltip="tooltip"
                                                       data-bs-toggle="modal"
                                                       data-bs-placement="bottom" title="Xóa"
                                                       data-bs-target="#deleteOrderModal" data-order-id="{{$order->id}}">
                                                        <i class="bi bi-trash-fill"></i>
                                                    </a>
                                                    @else
                                                            <div
                                                               class="text-danger pointer-event"
                                                               data-bs-tooltip="tooltip"
                                                               data-bs-placement="bottom" title="Xóa">
                                                                <i class="bi bi-trash-fill" style="color: #e9ecef"></i>
                                                            </div>
                                                    @endif
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            {{ $orders->links('pagination::bootstrap-4') }}
                        </div>
                    </div>
                </div>
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
@endsection
@section('script')
    <script src="js/order/index.js"></script>
@endsection
