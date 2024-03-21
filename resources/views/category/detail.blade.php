@extends('layouts.app')

@section('title')
    Danh mục sản phẩm
@endsection

@section('action')
    <div class="col-12">
        <a href="{{route('category.edit', $category->id)}}" class="btn btn-sm btn-primary me-2">Chỉnh sửa</a>
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
        </div>
    </div>
@endsection
