@extends('layouts.app')
@section('title')
    Khách hàng
@endsection
@section('action')
    <div class="col-12">
        <a href="{{route('customer.edit', $customer->id)}}" class="btn btn-sm btn-warning me-2">Chỉnh sửa</a>
        <a href="{{route('customer.index')}}" class="btn btn-sm btn-primary">Quay lại</a>
    </div>
@endsection
@section('breadcrumb')
    {{$customer->customer_name}}
@endsection
@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row py-4">
                <div class="col-12">
                    <input type="text" hidden name="customer_id" value="103">
                    <div class="d-flex align-items-center">
                        <h5 class="mb-0">Thông tin khách hàng</h5>
                    </div>
                    <div class="table-responsive mt-3">
                        <table class="table table-bordered">
                            <tbody>
                            <tr>
                                <th class="sz-col-100">
                                    <em class="fa fa-id-card mr-1" aria-hidden="true"></em>Tên
                                </th>
                                <td>{{$customer->customer_name}}</td>
                            </tr>
                            <tr>
                                <th class="sz-col-100">
                                    <em class="fa fa-envelope mr-1" aria-hidden="true"></em>Email
                                </th>
                                <td>{{$customer->email}}</td>
                            </tr>
                            <tr>
                                <th class="sz-col-100">
                                    <em class="fa fa-envelope mr-1" aria-hidden="true"></em>Số điện thoại
                                </th>
                                <td>{{$customer->phone}}</td>
                            </tr>
                            <tr>
                                <th class="sz-col-100">
                                    <em class="fa fa-envelope mr-1" aria-hidden="true"></em>Địa chỉ
                                </th>
                                <td>{{$customer->address}}</td>
                            </tr>
                            <tr>
                                <th class="sz-col-100">
                                    <em class="fa fa-envelope mr-1" aria-hidden="true"></em>Khu vực
                                </th>
                                <td>{{$areas[$customer->area_id] ?? ''}}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
