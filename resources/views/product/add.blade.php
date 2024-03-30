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
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('product.create.post') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="p-4 border rounded row mb-4">
                            <div class="col-md-6">
                                <div class="mt-2">
                                    <label for="product_code" class="form-label">Mã sản phẩm</label>
                                    <input name="product_code" type="text" class="form-control" id="product_code" value="" placeholder="Nhập mã sản phẩm" >
                                    <div class="invalid-feedback">Vui lòng nhập mã sản phẩm</div>
                                </div>
                                <div class="mt-2">
                                    <label for="product_name" class="form-label">Tên sản phẩm</label>
                                    <input name="product_name" type="text" class="form-control" id="product_name" value="" placeholder="Nhập tên sản phẩm" >
                                    <div class="invalid-feedback">Vui lòng nhập tên sản phẩm</div>
                                </div>
                                <div class="mt-2">
                                    <label for="color" class="form-label">Màu sắc</label>
                                    <input name="color" type="text" class="form-control" id="color" value="" placeholder="Nhập màu sắc sản phẩm" >
                                    <div class="invalid-feedback">Vui lòng nhập màu sắc sản phẩm</div>
                                </div>
                                <div class="mt-2">
                                    <label for="capacity" class="form-label">Dung tích</label>
                                    <input name="capacity" type="text" class="form-control" id="capacity" value="" placeholder="Nhập dung tích sản phẩm" >
                                    <div class="invalid-feedback">Vui lòng nhập dung tích sản phẩm</div>
                                </div>
                                <div class="mt-2">
                                    <label for="unit" class="form-label">Đơn vị tính</label>
                                    <input name="unit" type="text" class="form-control" id="unit" value="" placeholder="Nhập dung tích sản phẩm" >
                                    <div class="invalid-feedback">Vui lòng nhập dung tích sản phẩm</div>
                                </div>
                                <div class="mt-2">
                                    <label for="price" class="form-label">Đơn giá</label>
                                    <input name="price" type="number" class="form-control" id="price" value="" placeholder="Nhập đơn giá sản phẩm" >
                                    <div class="invalid-feedback">Vui lòng nhập đơn giá sản phẩm</div>
                                </div>
                                <div class="mt-2">
                                    <label for="category" class="form-label">Danh mục sản phẩm</label>
                                    <select name="category_id" class="form-control" id="category">
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
                                    <img id="imagePreview" style="max-width: 50%; height: auto; display: none;" />
                                </div>
                            </div>
                        </div>
                        <button style="width: 80px;" class="btn btn-success" type="submit">Lưu</button>
            </form>
        </div>
    </div>
@endsection
@section('script')
    <script src="js/product/add.js"></script>
@endsection



