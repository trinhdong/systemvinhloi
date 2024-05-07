@extends('layouts.app')
@section('title')
    {{-- write css this page--}}
    Danh mục sản phẩm
@endsection
@section('css')
    {{-- write css this page--}}
@endsection
@section('breadcrumb')
    {{-- write breadcrumb this page--}}
    Thêm danh mục sản phẩm
@endsection
@section('action')
    <div class="col-12">
        <a href="{{route('category.list')}}" class="btn btn-sm btn-secondary">Quay lại</a>
    </div>
@endsection
@section('content')
    <form action="{{ route('category.create.post') }}" method="post">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-body">
                                @csrf
                                <div class="p-4 rounded">
                                    <div class="row mb-2">
                                        <label for="category_name" class="col-sm-2 col-form-label">Tên danh mục</label>
                                        <div class="col-sm-10">
                                            <input type="text" name="category_name" class="form-control"
                                                   id="category_name" placeholder="Nhập tên danh mục sản phẩm" value="">
                                            <div class="invalid-feedback">Vui lòng nhập tên danh mục</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button style="width: 80px;" class="btn btn-success" type="submit">Lưu</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
@section('script')
    <script src="js/category/add.js"></script>
@endsection
