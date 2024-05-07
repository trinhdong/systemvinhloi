@extends('layouts.app')
@section('title')
    Danh sách khu vực
@endsection
@section('css')
    {{-- write css this page--}}
@endsection
@section('breadcrumb')
    {{-- write breadcrumb this page--}}
    Danh sách khu vực
@endsection
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="d-flex justify-content-between m-2 row">
                <div class="col-10">
                    <div class="row">
                        <div class="col-4">
                            <form id="form-search" class="position-relative">
                                <div class="position-absolute top-50 translate-middle-y search-icon px-3"><i
                                        class="bi bi-search"></i></div>
                                <input onchange="$('#form-search').submit()" class="form-control ps-5 rounded" type="text" placeholder="Nhập nội dung tìm kiếm"
                                       name="search-area" value="{{ request('search-area') }}">
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-2">
                    <a href="{{route('area.create.show')}}" type="button" class="btn btn-primary float-end">Thêm khu vực</a>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive mt-3">
                            <table class="table align-middle last-child-right">
                                <thead class="table-secondary">
                                <tr>
                                    <th>#</th>
                                    <th>Tên khu vực</th>
                                    <th>Nội dung khu vực</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                @if($areaList && $areaList->count() > 0)
                                @php
                                    $currentPage = $areaList->currentPage();
                                    $perPage = $areaList->perPage();
                                    $currentItem = ($currentPage - 1) * $perPage;
                                @endphp
                                @foreach($areaList as $key => $item)
                                    <tr>
                                        <td>{{++$currentItem}}</td>
                                        <td>{{$item->name}}</td>
                                        <td>{{$item->description}}</td>
                                        <td>
                                            <div class="table-actions d-flex align-items-center gap-3 fs-6">
                                                <a href="{{route('area.detail', $item->id)}}" class="text-primary"
                                                   data-bs-toggle="tooltip"
                                                   data-bs-placement="bottom" title="Xem"><i
                                                        class="bi bi-eye-fill"></i></a>
                                                <a href="{{route('area.edit', $item->id)}}" class="text-warning"
                                                   data-bs-toggle="tooltip"
                                                   data-bs-placement="bottom" title="Chỉnh sửa"><i
                                                        class="bi bi-pencil-fill"></i></a>
                                                <form class="d-none" id="formDeleteArea{{$item->id}}"
                                                      action="{{ route('area.delete', $item->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                                <a href="javascript:;" id="deleteAreaModalBtn"
                                                   class="text-danger pointer-event"
                                                   data-bs-tooltip="tooltip"
                                                   data-bs-toggle="modal"
                                                   data-bs-placement="bottom" title="Xóa"
                                                   data-bs-target="#deleteAreaModal" data-area-id="{{$item->id}}">
                                                    <i class="bi bi-trash-fill"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                @else
                                    <tr>
                                        <td colspan="4" class="text-center">Không tìm thấy dữ liệu</td>
                                    </tr>
                                @endif
                                </tbody>
                            </table>
                            @if($areaList && $areaList->count() > 0)
                                <div class=" justify-content-center">
                                    {!! $areaList->links('pagination::bootstrap-5') !!}
                                </div>
                            @endif
                    </div>
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
        </div>
    </div>
@endsection
@section('script')
    <script src="js/area/index.js"></script>
@endsection



