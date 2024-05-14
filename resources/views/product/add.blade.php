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
    Thêm sản phẩm
@endsection
@section('action')
    <div class="col-12">
        <a href="{{route('product.list')}}" class="btn btn-sm btn-secondary">Quay lại</a>
    </div>
@endsection
@section('content')
    <form class="row g-3" action="{{ route('product.create.post') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="card">
            <div class="card-body">
                <div class="p-4 border rounded mb-4">
                    <div class="col-md-6">
                        <div class="mt-2">
                            <label for="product_code" class="form-label">Mã sản phẩm</label>
                            <input name="product_code" type="text" class="form-control" id="product_code" value="{{ old('product_code') }}"
                                   placeholder="Nhập mã sản phẩm">
                            <div class="invalid-feedback">Vui lòng nhập mã sản phẩm</div>
                        </div>
                        <div class="mt-2">
                            <label for="product_name" class="form-label">Tên sản phẩm</label>
                            <input name="product_name" type="text" class="form-control" id="product_name" value="{{ old('product_name') }}"
                                   placeholder="Nhập tên sản phẩm">
                            <div class="invalid-feedback">Vui lòng nhập tên sản phẩm</div>
                        </div>
                        <div class="mt-2">
                            <label for="color" class="form-label">Màu sắc</label>
                            <input name="color" type="text" class="form-control" id="color" value="{{ old('color') }}"
                                   placeholder="Nhập màu sắc sản phẩm">
                        </div>
                        <div class="mt-2">
                            <label for="capacity" class="form-label">Dung tích</label>
                            <input name="capacity" type="text" class="form-control" id="capacity" value="{{ old('capacity') }}"
                                   placeholder="Nhập dung tích sản phẩm">
                            <div class="invalid-feedback">Vui lòng nhập dung tích sản phẩm</div>
                        </div>
                        <div class="mt-2">
                            <label for="unit" class="form-label">Đơn vị tính</label>
                            <input name="unit" type="text" class="form-control" id="unit" value="{{ old('unit') }}"
                                   placeholder="Nhập dung tích sản phẩm">
                            <div class="invalid-feedback">Vui lòng nhập dung tích sản phẩm</div>
                        </div>
                        <div class="mt-2">
                            <label for="specifications" class="form-label">Quy cách</label>
                            <input name="specifications" type="text" class="form-control" id="specifications"
                                   value="{{ old('specifications') }}" placeholder="Nhập quy cách sản phẩm">
                            <div class="invalid-feedback">Vui lòng nhập quy cách sản phẩm</div>
                        </div>
                        <div class="mt-2">
                            <label for="quantity_per_package" class="form-label">Số lượng theo quy cách</label>
                            <input name="quantity_per_package" type="text" class="form-control"
                                   id="quantity_per_package" value="{{ old('quantity_per_package') }}"
                                   placeholder="Nhập số lượng theo quy cách sản phẩm">
                            <div class="invalid-feedback">Vui lòng nhập số lượng theo quy cách</div>
                        </div>
                        <div class="mt-2">
                            <label for="price" class="form-label">Đơn giá</label>
                            <input name="price" type="text" class="form-control" id="price" value="{{ old('price') }}"
                                   placeholder="Nhập đơn giá sản phẩm">
                            <div class="invalid-feedback">Vui lòng nhập đơn giá sản phẩm</div>
                        </div>
                        <div class="mt-2">
                            <label for="category" class="form-label">Danh mục sản phẩm</label>
                            <select name="category_id" class="form-control single-select">
                                <option value="">Chọn danh mục</option>
                                @foreach($categoryList as $category)
                                    <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">Vui lòng chọn danh mục sản phẩm</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mt-2">
                            <label for="image_url" class="form-label">Hình ảnh sản phẩm</label>
                            <input type="file" class="form-control" id="image_url" name="image_url">
                            <div class="invalid-feedback">Vui lòng thêm hình ảnh của sản phẩm</div>
                        </div>
                        <div class="mt-2">
                            <img id="imagePreview" style="max-width: 50%; height: auto; display: none;"/>
                        </div>
                    </div>
                </div>
                <button style="width: 80px;" class="btn btn-success" type="submit">Lưu</button>
            </div>
        </div>
    </form>
@endsection
@section('script')
    <script src="js/product/add.js"></script>
@endsection
