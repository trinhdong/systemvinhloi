@extends('layouts.app')
@section('title')
    {{-- write css this page--}}
    Sản phẩm
@endsection
@section('css')
    {{-- write css this page--}}
@endsection
@section('breadcrumb')
    {{-- write breadcrumb this page--}}
    Chi tiết sản phẩm
@endsection
@section('action')
    <div class="col-12">
        <a href="{{route('product.list')}}" class="btn btn-sm btn-secondary">Quay lại</a>
    </div>
@endsection
@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row py-4">
                <div class="col-12">
                    <div class="d-flex align-items-center">
                        <h5 class="mb-0">Thông tin sản phẩm</h5>
                    </div>
                    <div class="table-responsive mt-3">
                        <table class="table table-bordered">
                            <tbody>
                            <tr>
                                <th class="sz-col-100">
                                    <em class="fa fa-id-card mr-1" aria-hidden="true"></em>Mã sản phẩm
                                </th>
                                <td>{{$product->product_code}}</td>
                            </tr>
                            <tr>
                                <th class="sz-col-100">
                                    <em class="fa fa-id-card mr-1" aria-hidden="true"></em>Tên sản phẩm
                                </th>
                                <td>{{$product->product_name}}</td>
                            </tr>
                            <tr>
                                <th class="sz-col-100">
                                    <em class="fa fa-id-card mr-1" aria-hidden="true"></em>Màu sắc
                                </th>
                                <td>{{$product->color}}</td>
                            </tr>
                            <tr>
                                <th class="sz-col-100">
                                    <em class="fa fa-id-card mr-1" aria-hidden="true"></em>Dung tích
                                </th>
                                <td>{{$product->capacity}}</td>
                            </tr>
                            <tr>
                                <th class="sz-col-100">
                                    <em class="fa fa-id-card mr-1" aria-hidden="true"></em>Đơn vị tính
                                </th>
                                <td>{{$product->unit}}</td>
                            </tr>
                            <tr>
                                <th class="sz-col-100">
                                    <em class="fa fa-id-card mr-1" aria-hidden="true"></em>Quy cách
                                </th>
                                <td>{{$product->specifications}}</td>
                            </tr>
                            <tr>
                                <th class="sz-col-100">
                                    <em class="fa fa-id-card mr-1" aria-hidden="true"></em>Số lượng theo quy cách
                                </th>
                                <td>{{$product->quantity_per_package}}</td>
                            </tr>
                            <tr>
                                <th class="sz-col-100">
                                    <em class="fa fa-id-card mr-1" aria-hidden="true"></em>Đơn giá
                                </th>
                                <td>{{number_format($product->price)}}</td>
                            </tr>
                            <tr>
                                <th class="sz-col-100">
                                    <em class="fa fa-id-card mr-1" aria-hidden="true"></em>Hình ảnh sản phẩm
                                </th>
                                <td>
                                    <div class="mt-2">
                                        @if($product->image_url)
                                            <img src="{{ asset($product->image_url) }}" alt=""  style="max-width: 20%; height: auto;">
                                        @else
                                            <img src="{{ asset("/storage/images/products/no-image.jpg") }}" alt=""  style="max-width: 20%; height: auto;">
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-start align-items-center">
                        <a href="{{route('product.edit', $product->id)}}" style="width: 80px;" class="btn btn-primary mt-3 me-2">Sửa</a>
                    </div>
                </div>
            </div>
            @endsection
 @section('script')
@endsection



