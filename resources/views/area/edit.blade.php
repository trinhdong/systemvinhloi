@extends('layouts.app')
@section('title')
    {{-- write css this page--}}
    Khu vực
@endsection
@section('css')
    {{-- write css this page--}}
@endsection
@section('breadcrumb')
    {{-- write breadcrumb this page--}}
    Chỉnh sửa khu vực
@endsection
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('area.update', $area->id) }}" method="post">
                        @csrf
                        <div class="p-4 rounded">
                            <div class="row mb-2">
                                <label for="name" class="col-sm-2 col-form-label">Tên khu vực</label>
                                <div class="col-sm-10">
                                    <input type="text" name="id" value="{{$area->id}}" hidden>
                                    <input type="text" name="name" class="form-control" id="area_name" placeholder="Nhập tên khu vực" value="{{$area->name}}">
                                </div>
                            </div>
                            <div class="row mb-2">
                                <label for="description" class="col-sm-2 col-form-label">Nội dung khu vực</label>
                                <div class="col-sm-10">
                                    <textarea name="description" class="form-control" id="description" placeholder="Nhập nội dung khu vực">{{$area->description}}</textarea>
                                </div>
                            </div>
                        </div>
                </div>
                <div class="d-flex justify-content-center mb-5">
                    <div>
                        <a href="#" type="button" class="btn btn-primary px-5 mx-2">Quay lại</a>
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



