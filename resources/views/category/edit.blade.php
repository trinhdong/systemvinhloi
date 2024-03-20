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
    Chỉnh sửa danh mục sản phẩm
@endsection
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('category.update', $category->id) }}" method="post">
                        @csrf
                        <div class="p-4 rounded">
                            <div class="row mb-2">
                                <label for="name" class="col-sm-2 col-form-label">Tên danh mục</label>
                                <div class="col-sm-10">
                                    <input type="text" name="id" value="{{$category->id}}" hidden>
                                    <input type="text" name="category_name" class="form-control" id="category_name" placeholder="Nhập tên danh mục sản phẩm" value="{{$category->category_name}}">
                                </div>
                            </div>
                        </div>
                </div>
                <div class="d-flex justify-content-center mb-5">
                    <div>
                        <a href="{{route('category.list')}}" type="button" class="btn btn-primary px-5 mx-2">Quay lại</a>
                    </div>
                    <div>
                        <button type="submit" class="btn btn-success px-5 mx-2 w-100">Lưu</button>
                    </div>
                </div>
            </div>
            </form>
        </div>
    </div>
@endsection
@section('script')
@endsection



