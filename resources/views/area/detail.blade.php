@extends('layouts.app')
@section('title')
    Khu vực
@endsection
@section('breadcrumb')
    {{$area->name}}
@endsection
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                        <div class="p-4 rounded">
                            <div class="row mb-2">
                                <label for="name" class="col-sm-2 col-form-label">Tên khu vực</label>
                                <div class="col-sm-10">
                                    <input type="text" name="name" class="form-control" id="area_name" placeholder="Nhập tên khu vực" value="{{$area->name}}" readonly>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <label for="description" class="col-sm-2 col-form-label">Nội dung khu vực</label>
                                <div class="col-sm-10">
                                    <textarea name="description" class="form-control" id="description" placeholder="Nhập nội dung khu vực" readonly>{{$area->description}}</textarea>
                                </div>
                            </div>
                        </div>
                </div>
                <div class="d-flex justify-content-center mb-5">
                    <div>
                        <a href="{{route('area.list')}}" type="button" class="btn btn-primary px-5 mx-2">Quay lại</a>
                        <a href="#" type="button" class="btn btn-warning px-5 me-2">Chỉnh sửa</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
