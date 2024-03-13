@extends('layouts.app')
@section('title')
    Nhân viên
@endsection
@section('action')
    <div class="col-12">
        <a href="{{route('user.edit', $user->id)}}" class="btn btn-sm btn-warning me-2">Chỉnh sửa</a>
        <a href="{{route('user.index')}}" class="btn btn-sm btn-primary">Quay lại</a>
    </div>
@endsection
@section('breadcrumb')
    {{$user->name}}
@endsection
@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row py-4">
                <div class="col-xl-4 offset-xl-4">
                    <input type="text" hidden name="user_id" value="103">
                    <div class="d-flex align-items-center">
                        <h5 class="mb-0">Thông tin nhân viên</h5>
                    </div>
                    <div class="table-responsive mt-3">
                        <table class="table table-bordered">
                            <tbody>
                            <tr>
                                <th class="sz-col-170">
                                    <em class="fa fa-id-card mr-1" aria-hidden="true"></em>Tên
                                </th>
                                <td>{{$user->name}}</td>
                            </tr>
                            <tr>
                                <th class="sz-col-170">
                                    <em class="fa fa-envelope mr-1" aria-hidden="true"></em>Email
                                </th>
                                <td>{{$user->email}}</td>
                            </tr>
                            <tr>
                                <th class="sz-col-170">
                                    <em class="fa fa-envelope mr-1" aria-hidden="true"></em>Chức vụ
                                </th>
                                <td>{{ROLE_TYPE_NAME[$user->role]}}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
