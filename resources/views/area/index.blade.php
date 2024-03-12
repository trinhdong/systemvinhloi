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
                <div class="col-sm-4 mb-2">
                    <form class="position-relative">
                        <div class="position-absolute top-50 translate-middle-y search-icon px-3"><i class="bi bi-search"></i></div>
                        <input class="form-control ps-5 rounded" type="text" placeholder="Nhập nội dung tìm kiếm" name="user_name" value="">
                    </form>
                </div>
                    <div class="col-sm-5 col-md-4 col-lg-4 mb-2">
                        <a href="{{route('area.create.show')}}" type="button" class="btn btn-primary px-5 float-end">Tạo khu vực</a>
                    </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive mt-3">
                        @if($areaList && $areaList->count() > 0)
                        <table class="table align-middle last-child-right">
                            <thead class="table-secondary">
                            <tr>
                                <th>Số thứ tự</th>
                                <th>Tên khu vực</th>
                                <th>Nội dung khi vực</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
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
                                            <a href="#" class="text-primary" data-bs-toggle="tooltip" data-bs-placement="bottom" title="詳細"><i class="bi bi-eye-fill"></i></a>
                                                <a href="#" class="text-primary" data-bs-toggle="tooltip" data-bs-placement="bottom" title="編集"><i class="bi bi-pencil-fill"></i></a>
                                                <a class="text-danger delete-user" data-bs-toggle="tooltip" data-bs-placement="bottom" title="削除" data-id=""><i class="bi bi-trash-fill"></i></a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <div class=" justify-content-center">
                            {!! $areaList->links('pagination::bootstrap-5') !!}
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>

    </script>
@endsection



