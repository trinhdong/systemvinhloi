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
@section('action')
    <div class="col-12">
        <a href="{{route('area.list')}}" class="btn btn-sm btn-secondary">Quay lại</a>
    </div>
@endsection
@section('content')
    <div class="card">
        <div class="card-body">
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
            </div>
            <button style="width: 80px;" class="btn btn-success" type="submit">Lưu</button>
            </div>
            </form>
        </div>
        </div>
    </div>
@endsection
@section('script')
@endsection



