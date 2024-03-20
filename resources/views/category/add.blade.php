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
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('category.create.post') }}" method="post">
                        @csrf
                        <div class="p-4 rounded">
                            <div class="row mb-2">
                                <label for="category_name" class="col-sm-2 col-form-label">Tên danh mục</label>
                                <div class="col-sm-10">
                                    <input type="text" name="category_name" class="form-control" id="category_name" placeholder="Nhập tên danh mục sản phẩm" value="">
                                </div>
                            </div>
                        </div>
                </div>
            </div>
            <div class="d-flex justify-content-end">
                <div>
                    <a href="{{route('category.list')}}" type="button" class="btn btn-primary px-5 mx-2">Quay lại</a>
                </div>
                <div>
                    <button type="submit" class="btn btn-primary px-5 mx-2">Lưu</button>
                </div>
            </div>
            </form>
        </div>
    </div>
@endsection
@section('script')
@endsection



