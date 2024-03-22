@extends('layouts.app')
@section('title')
    Nhân viên
@endsection
@section('action')
    <div class="col-12">
        <a href="{{route('user.index')}}" class="btn btn-sm btn-secondary">Quay lại</a>
    </div>
@endsection
@section('breadcrumb')
    {{$order->name}}
@endsection
@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row py-4">
                <div class="col-xl-4 offset-xl-4">
                    <input type="text" hidden name="user_id" value="103">
                    <div class="d-flex align-items-center">
                        <h5 class="mb-0">Thông tin nhân viên</h5>
                    </div>
                    <div class="table-responsive mt-3">
                        <table class="table table-bordered">
                            <tbody>
                            <tr>
                                <th class="sz-col-170">
                                    <em class="fa fa-id-card mr-1" aria-hidden="true"></em>Tên
                                </th>
                                <td>{{$order->name}}</td>
                            </tr>
                            <tr>
                                <th class="sz-col-170">
                                    <em class="fa fa-envelope mr-1" aria-hidden="true"></em>Email
                                </th>
                                <td>{{$order->email}}</td>
                            </tr>
                            <tr>
                                <th class="sz-col-170">
                                    <em class="fa fa-envelope mr-1" aria-hidden="true"></em>Chức vụ
                                </th>
                                <td>{{ROLE_TYPE_NAME[$order->role]}}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <a href="{{route('order.edit', $order->id)}}" style="width: 80px;" class="btn btn-primary mt-3">Sửa</a>
            <form class="d-none" id="formDeleteOrder{{$order->id}}"
                  action="{{ route('order.delete', $order->id) }}" method="POST">
                @csrf
                @method('DELETE')
            </form>
            <a style="width: 80px;" href="javascript:;" id="deleteOrderModalBtn"
               class="btn btn-danger mt-3"
               data-bs-tooltip="tooltip"
               data-bs-toggle="modal"
               data-bs-placement="bottom" title="Xóa"
               data-bs-target="#deleteOrderModal" data-order-id="{{$order->id}}">
                Xóa
            </a>
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
