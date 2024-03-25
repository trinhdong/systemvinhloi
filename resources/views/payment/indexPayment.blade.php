@extends('layouts.app')
@section('title')
    Thanh toán
@endsection
@section('breadcrumb')
    Danh sách thanh toán
@endsection
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="d-flex justify-content-between m-2 row">
                <div class="col-sm-10 mb-2">
                    <form id="form-search" class="position-relative">
                        <div class="row">
                            <div class="col-4">
                                <div class="position-absolute top-50 translate-middle-y search-icon px-3"><i
                                            class="bi bi-search"></i></div>
                                <input onchange="$('#form-search').submit()" class="form-control ps-5 rounded" type="text"
                                       placeholder="Nhập nội dung tìm kiếm"
                                       name="query" value="{{ request('query') }}">
                            </div>
                            <div class="col-2">
                                <select onchange="$('#form-search').submit()" name="customer_id" class="form-select single-select">
                                    <option selected="" value="">Chọn khách hàng</option>
                                    @foreach($customers as $customerId => $customerName)
                                        <option value="{{ $customerId }}"
                                                @if(intval(request('customer_id')) === $customerId) selected @endif>{{ $customerName }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-2">
                                <select onchange="$('#form-search').submit()" name="payment_status" class="form-select single-select">
                                    <option selected="" value="">Chọn trạng thái</option>
                                    @foreach(STATUS_PAYMENT as $status => $statusName)
                                        <option value="{{ $status }}"
                                                @if(intval(request('status')) === $status) selected @endif>{{ $statusName }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </form>
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
                                <th>Tổng tiền</th>
                                <th>Hình thức thanh toán</th>
                                <th>Trạng thái thanh toán</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if($orders->isEmpty())
                                <tr>
                                    <td colspan="7" class="text-center">Không tìm thấy dữ liệu</td>
                                </tr>
                            @else
                                @foreach($orders as $key => $order)
                                    <?php $enableButton = $order->enableButtonByRole(Auth::user()->role) ?>
                                    <tr class="hover-able cursor-pointer" onclick="window.location = '{{route('payment.detailPayment', $order->id)}}'">
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $order->order_number }}</td>
                                        <td>{{ $customers[$order->customer_id] }}</td>
                                        <td>{{ number_format($order->order_total) }}</td>
                                        <td>{{ PAYMENTS_TYPE[$order->payment_type] }}</td>
                                        <td>
                                            <span class="badge rounded-pill bg-{{STATUS_PAYMENT_COLOR[$order->payment_status]}}">{{STATUS_PAYMENT[$order->payment_status]}}</span>
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
