@extends('layouts.app')
@section('title')
    Khu vực
@endsection
@section('breadcrumb')
    {{$area->name}}
@endsection
@section('action')
    <div class="col-12">
        <a href="{{route('area.list')}}" class="btn btn-sm btn-secondary">Quay lại</a>
    </div>
@endsection
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive mt-3">
                        <table class="table table-bordered">
                            <tbody>
                            <tr>
                                <th style="width: 200px">
                                    <em class="fa fa-id-card mr-1" aria-hidden="true"></em>Tên khu vực
                                </th>
                                <td>{{$area->name}}</td>
                            </tr>
                            <tr>
                                <th style="width: 200px">
                                    <em class="fa fa-id-card mr-1" aria-hidden="true"></em>Nội dung khu vực
                                </th>
                                <td>{{$area->description}}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <a href="{{route('area.edit', $area->id)}}" style="width: 80px;" class="btn btn-primary">Sửa</a>
            <form class="d-none" id="formDeleteArea{{$area->id}}"
                  action="{{ route('area.delete', $area->id) }}" method="POST">
                @csrf
                @method('DELETE')
            </form>
            <a style="width: 80px;" href="javascript:;" id="deleteAreaModalBtn"
               class="btn btn-danger"
               data-bs-tooltip="tooltip"
               data-bs-toggle="modal"
               data-bs-placement="bottom" title="Xóa"
               data-bs-target="#deleteAreaModal" data-area-id="{{$area->id}}">
              Xóa
            </a>
        </div>
    </div>
    <div class="modal fade" id="deleteAreaModal" tabindex="-1" aria-labelledby="deleteAreaModalLabel"
         aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteAreaModalLabel">Xóa khu vực</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">Bạn có chắc muốn xóa khu vực này?</div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy bỏ</button>
                    <button id="deleteArea" type="button" class="btn btn-danger">Xóa</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="js/area/index.js"></script>
@endsection
