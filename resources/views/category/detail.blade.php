@extends('layouts.app')

@section('title')
    Danh mục sản phẩm
@endsection

@section('action')
    <div class="col-12">
        <a href="{{route('category.list')}}" class="btn btn-sm btn-secondary">Quay lại</a>
    </div>
@endsection

@section('breadcrumb')
    Danh sách danh mục sản phẩm
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row py-4">
                <div class="col-12">
                    <input type="text" hidden name="customer_id" value="103">
                    <div class="d-flex align-items-center">
                        <h5 class="mb-0">Thông tin danh mục sản phẩm</h5>
                    </div>
                    <div class="table-responsive mt-3">
                        <table class="table table-bordered">
                            <tbody>
                            <tr>
                                <th class="sz-col-100">
                                    <em class="fa fa-id-card mr-1" aria-hidden="true"></em>Tên danh mục sản phẩm
                                </th>
                                <td>{{$category->category_name}}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <a href="{{route('category.edit', $category->id)}}" style="width: 80px;" class="btn btn-primary mt-3">Sửa</a>
            <form class="d-none" id="formDeleteCategory{{$category->id}}"
                  action="{{ route('category.delete', $category->id) }}" method="POST">
                @csrf
                @method('DELETE')
            </form>
            <a style="width: 80px;" href="javascript:;" id="deleteCategoryModalBtn"
               class="btn btn-danger mt-3"
               data-bs-tooltip="tooltip"
               data-bs-toggle="modal"
               data-bs-placement="bottom" title="Xóa"
               data-bs-target="#deleteCategoryModal" data-category-id="{{$category->id}}">
               Xóa
            </a>
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
@endsection
@section('script')
    <script src="js/category/index.js"></script>
@endsection
