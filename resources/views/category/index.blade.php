@extends('layouts.app')
@section('title')
    Danh mục sản phẩm
@endsection
@section('css')
    {{-- write css this page--}}
@endsection
@section('breadcrumb')
    {{-- write breadcrumb this page--}}
    Danh sách danh mục sản phẩm
@endsection
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="d-flex justify-content-between m-2 row">
                <div class="col-sm-4 mb-2">
                    <form class="position-relative">
                        <div class="position-absolute top-50 translate-middle-y search-icon px-3"><i
                                class="bi bi-search"></i></div>
                        <input class="form-control ps-5 rounded" type="text" placeholder="Nhập nội dung tìm kiếm"
                               name="search-category" value="">
                    </form>
                </div>
                <div class="col-sm-5 col-md-4 col-lg-4 mb-2">
                    <a href="{{route('category.create.show')}}" type="button" class="btn btn-primary px-5 float-end">Thêm danh mục</a>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive mt-3">
                        <table class="table align-middle last-child-right">
                            <thead class="table-secondary">
                            <tr>
                                <th>#</th>
                                <th>Tên danh mục</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @if($categoryList && $categoryList->count() > 0)
                                @php
                                    $currentPage = $categoryList->currentPage();
                                    $perPage = $categoryList->perPage();
                                    $currentItem = ($currentPage - 1) * $perPage;
                                @endphp
                                @foreach($categoryList as $key => $item)
                                    <tr>
                                        <td>{{++$currentItem}}</td>
                                        <td>{{$item->category_name}}</td>
                                        <td>
                                            <div class="table-actions d-flex align-items-center gap-3 fs-6">
                                                <a href="{{route('category.detail', $item->id)}}" class="text-primary"
                                                   data-bs-toggle="tooltip"
                                                   data-bs-placement="bottom" title="Xem"><i
                                                        class="bi bi-eye-fill"></i></a>
                                                <a href="{{route('category.edit', $item->id)}}" class="text-warning"
                                                   data-bs-toggle="tooltip"
                                                   data-bs-placement="bottom" title="Chỉnh sửa"><i
                                                        class="bi bi-pencil-fill"></i></a>
                                                <form class="d-none" id="formDeleteCategory{{$item->id}}"
                                                      action="{{ route('category.delete', $item->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                                <a href="javascript:;" id="deleteCategoryModalBtn"
                                                   class="text-danger pointer-event"
                                                   data-bs-tooltip="tooltip"
                                                   data-bs-toggle="modal"
                                                   data-bs-placement="bottom" title="Xóa"
                                                   data-bs-target="#deleteCategoryModal" data-category-id="{{$item->id}}">
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
                        @if($categoryList && $categoryList->count() > 0)
                            <div class=" justify-content-center">
                                {!! $categoryList->links('pagination::bootstrap-5') !!}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="modal fade" id="deleteCategoryModal" tabindex="-1" aria-labelledby="deleteCategoryModalLabel"
                 aria-hidden="true" style="display: none;">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="deleteCategoryModalLabel">Xóa danh mục</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">Bạn có chắc muốn xóa danh mục này?</div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy bỏ</button>
                            <button id="deleteCategory" type="button" class="btn btn-danger">Xóa</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="js/category/index.js"></script>
@endsection



