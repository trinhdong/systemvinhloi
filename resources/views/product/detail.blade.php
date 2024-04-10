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
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <div class="p-4 border rounded row mb-4">
                        <div class="col-md-6">
                            <div class="mt-2">
                                <label for="product_code" class="form-label">Mã sản phẩm</label>
                                <input name="product_code" type="text" class="form-control" id="product_code"
                                       value="{{$product->product_code}}" readonly>
                            </div>
                            <div class="mt-2">
                                <label for="product_name" class="form-label">Tên sản phẩm</label>
                                <input name="product_name" type="text" class="form-control" id="product_name"
                                       value="{{$product->product_name}}" readonly>
                            </div>
                            <div class="mt-2">
                                <label for="color" class="form-label">Màu sắc</label>
                                <input name="color" type="text" class="form-control" id="color" value="{{$product->color}}" readonly>
                            </div>
                            <div class="mt-2">
                                <label for="capacity" class="form-label">Dung tích</label>
                                <input name="capacity" type="text" class="form-control" id="capacity" value="{{$product->capacity}}" readonly>
                            </div>
                            <div class="mt-2">
                                <label for="unit" class="form-label">Đơn vị tính</label>
                                <input name="unit" type="text" class="form-control" id="unit" value="{{$product->unit}}" readonly>
                            </div>
                            <div class="mt-2">
                                <label for="specifications" class="form-label">Quy cách</label>
                                <input name="specifications" type="text" class="form-control" id="specifications"
                                       value="{{$product->specifications}}" readonly>
                            </div>
                            <div class="mt-2">
                                <label for="quantity_per_package" class="form-label">Số lượng theo quy cách</label>
                                <input name="quantity_per_package" type="text" class="form-control"
                                       id="quantity_per_package" value="{{$product->quantity_per_package}}" readonly>
                            </div>
                            <div class="mt-2">
                                <label for="price" class="form-label">Đơn giá</label>
                                <input name="price" type="text" class="form-control" id="price" value="{{number_format($product->price)}}" readonly>
                            </div>
                            <div class="mt-2">
                                <label for="category" class="form-label">Danh mục sản phẩm</label>
                                <select name="category_id" class="form-control" id="category" disabled>
                                    <option value="">Chọn danh mục</option>
                                    @foreach($categoryList as $key => $category)
                                        <option value="{{ $category->id }}" {{$product->category_id == $category->id ? 'selected' : ''}}>{{ $category->category_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mt-2">
                                <label for="image_url" class="form-label">Hình ảnh sản phẩm</label>
                            </div>
                            <div class="mt-2">
                                @if($product->image_url)
                                <img src="{{ asset($product->image_url) }}" alt=""  style="max-width: 50%; height: auto;">
                                @else
                                    <img src="{{ asset("/storage/images/products/no-image.jpg") }}" alt=""  style="max-width: 50%; height: auto;">
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center align-items-center">
                        <a href="{{route('product.edit', $product->id)}}" style="width: 80px;" class="btn btn-primary mt-3 me-2">Sửa</a>
                    </div>
                </div>
            </div>
            @endsection
 @section('script')
@endsection



