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

                    <div class="col-12 mt-4">
                        <h5 class="mb-0">Sản phẩm khuyến mãi</h5>
                    </div>

                    <div class="table-responsive mt-3">
                        <table class="table align-middle table-bordered">
                            <thead class="table-light">
                            <tr>
                                <th class="col-3">Danh mục</th>
                                <th class="col-3">Sản phẩm</th>
                                <th>Phần trăm giảm giá</th>
                                <th>Giá</th>
                                <th>Giá khuyến mãi</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($discounts as $discount)
                                <tr>
                                    <td>{{$categories[$categoryIds[$discount->product_id]] ?? ''}}</td>
                                    <td>{{$products[$discount->product_id]}}</td>
                                    <td>{{$discount->discount_percent}}%</td>
                                    <td>{{number_format($productPrice[$discount->product_id] ?? 0)}}</td>
                                    <td>{{number_format(max($productPrice[$discount->product_id] - ($productPrice[$discount->product_id] * $discount->discount_percent) / 100, 0))}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
