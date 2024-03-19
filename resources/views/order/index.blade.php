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
            <div class="d-flex align-items-center">
                <form class="ms-auto position-relative">
                    <div class="row col-12">
                        <div class="col-5">

                        </div>
                        <div class="col-7">
                            <div class="ms-auto position-relative">
                                <div class="position-absolute top-50 translate-middle-y search-icon px-3"><i class="bi bi-search"></i></div>
                                <input name="query" value="{{ request('query') }}" class="form-control ps-5" type="text" placeholder="Tìm kiếm...">
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
                        <th>Tên</th>
                        <th class="col-1">Hành động</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if($orders->isEmpty())
                        <tr><td colspan="4" class="text-center">Không tìm thấy dữ liệu</td></tr>
                    @else
                    @foreach($orders as $key => $order)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $order->name }}</td>
                            <td>
                                <div class="table-actions d-flex align-items-center gap-3 fs-6">
                                    <a href="{{route('order.detail', $order->id)}}" class="text-primary"
                                       data-bs-toggle="tooltip"
                                       data-bs-placement="bottom" title="Xem"><i class="bi bi-eye-fill"></i></a>
                                    <a href="{{route('order.edit', $order->id)}}" class="text-warning"
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
