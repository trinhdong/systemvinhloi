@extends('layouts.app')
@section('title')
    Đơn hàng
@endsection
@section('action')
    <div class="col-12">
        <a href="{{route('order.add')}}" class="btn btn-sm btn-primary">Thêm đơn hàng</a>
    </div>
@endsection
@section('breadcrumb')
    Danh sách đơn hàng
@endsection
@section('content')
    <div class="card">
        <div class="card-body">
            <div class="d-flex align-items-center f">
                <form id="searchForm" class="ms-auto position-relative">
                    @csrf
                    <div class="row">
                        <div class="col-3">
                            <select name="customer_id" class="form-select single-select">
                                <option selected="" value="">Chọn khách hàng</option>
                                @foreach($customers as $customerId => $customerName)
                                    <option value="{{ $customerId }}" @if(intval(request('customer_id')) === $customerId) selected @endif>{{ $customerName }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-3">
                            <select name="status" class="form-select">
                                <option selected="" value="">Chọn trạng thái</option>
                                @foreach(STATUS_ORDER_TYPE as $status => $statusName)
                                    <option value="{{ $status }}" @if(intval(request('status')) === $status) selected @endif>{{ $statusName }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-3">
                            <input name="order_date" type="text" id="datepicker" class="form-control" placeholder="Ngày đặt hàng" />
                        </div>
                        <div class="col-3">
                            <div class="ms-auto position-relative">
                                <div class="position-absolute top-50 translate-middle-y search-icon px-3"><i class="bi bi-search"></i></div>
                                <input id="submit" name="query" value="{{ request('query') }}" class="form-control ps-5" type="text" placeholder="Tìm kiếm...">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="table-responsive mt-3">
                <table class="table align-middle">
                    <thead class="table-secondary">
                    <tr>
                        <th>#</th>
                        <th>Mã đơn hàng</th>
                        <th>Tên khách hàng</th>
                        <th>Tổng tiền</th>
                        <th>Trạng thái</th>
                        <th>Ngày tạo</th>
                        <th class="col-1">Hành động</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if($orders->isEmpty())
                        <tr><td colspan="7" class="text-center">Không tìm thấy dữ liệu</td></tr>
                    @else
                    @foreach($orders as $key => $order)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $order->order_number }}</td>
                            <td>{{ $customers[$order->customer_id] }}</td>
                            <td>{{ number_format($order->order_total) }}</td>
                            <td>{{ STATUS_ORDER_TYPE[$order->status] }}</td>
                            <td>{{ Date::parse($order->order_date)->format(FORMAT_DATE_VN) }}</td>
                            <td>
                                <div class="table-actions d-flex align-items-center gap-3 fs-6">
                                    <a href="#" class="text-primary"
                                       data-bs-toggle="tooltip"
                                       data-bs-placement="bottom" title="Xem"><i class="bi bi-eye-fill"></i></a>
                                    <a href="#" class="text-warning"
                                       data-bs-toggle="tooltip"
                                       data-bs-placement="bottom"
                                       title="Chỉnh sửa">
                                        <i class="bi bi-pencil-fill"></i></a>
                                        <form class="d-none" id="formDeleteOrder{{$order->id}}" action="{{ route('order.delete', $order->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                        <a href="javascript:;" id="deleteOrderModalBtn" class="text-danger pointer-event"
                                                data-bs-tooltip="tooltip"
                                                data-bs-toggle="modal"
                                                data-bs-placement="bottom" title="Xóa"
                                                data-bs-target="#deleteOrderModal" data-order-id="{{$order->id}}">
                                            <i class="bi bi-trash-fill"></i>
                                        </a>
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
    <div class="modal fade" id="deleteOrderModal" tabindex="-1" aria-labelledby="deleteOrderModalLabel" aria-hidden="true" style="display: none;">
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
